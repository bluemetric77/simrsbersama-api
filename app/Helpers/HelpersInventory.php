<?php
namespace App\Helpers;
use App\Models\Inventory\ItemMutations;
use App\Models\Inventory\ItemMutationsMonthly;
use App\Models\Master\Inventory\Inventory;
use App\Models\Inventory\ItemsStock;

use PagesHelp;


use Illuminate\Support\Facades\DB;

class HelpersInventory {
   public static function ItemCard($sysid,$source,$operation,$flags)
   {
        $respon=array();
        $respon['success']=true;
        $respon['message']="";

        $operation=strtolower($operation);
        $source=strtoupper($source);

        $line_state=($flags=='VOID') ? 'V' :'N';

        DB::statement("DROP TEMPORARY TABLE IF EXISTS tmp_stock");
        DB::statement("CREATE TEMPORARY TABLE tmp_stock ENGINE=Memory AS SELECT location_id,item_code,qty_in as stock
                    FROM t_item_mutations WHERE sysid IS NULL");

        $data=ItemMutations::select('location_id')
        ->where('doc_sysid',$sysid)
        ->where('doc_type',$source)
        ->first();

        if (($operation=='updated') || ($operation=='deleted')) {
            if ($data){
                DB::insert("INSERT INTO tmp_stock SELECT DISTINCT location_id,item_code,0 FROM t_item_mutations
                    WHERE doc_sysid=? AND  doc_type=? AND line_state=?",[$sysid,$source,$line_state]);
                $buffer=ItemMutations::from("t_item_mutations as a")
                ->selectRaw("b.item_code,c.item_name1 as item_name,d.location_name,b.last_in,b.last_out")
                ->join("m_items_stock as b", function($join){
                    $join->on("a.location_id","=","b.location_id");
                    $join->on("a.item_sysid","=","b.item_sysid");
                })
                ->join("m_items as c","a.item_sysid","=","c.sysid")
                ->join("m_warehouse as d","a.location_id","=","d.sysid")
                ->where('a.doc_sysid',$sysid)
                ->where('a.doc_type',$source)
                ->where('a.line_state',$line_state)
                ->where('a.is_deleted','0')
                ->get();

                /*foreach($buffer as $line) {
                    if ($line->last_out > $line->last_in){
                        $item_code=$line->item_code;
                        $item_name=$line->item_name;
                        $respon['success']=false;
                        $respon['message']="Data tidak bisa ubah, sudah ada transaksi pengeluaran [$item_code - $item_name]";
                        return $respon;
                        exit(0);
                    }
                }*/

                #Recalculation before
                $data=ItemMutations::selectRaw('location_id,item_sysid,item_code,-((qty_in-qty_out)+qty_adjustment) as mutation,mou_inventory,price,-total as total')
                ->where('doc_sysid',$sysid)
                ->where('doc_type',$source)
                ->where('line_state',$line_state)
                ->where('is_deleted','0')
                ->get();

                foreach($data as $row) {
                    $stock=ItemsStock::selectRaw("location_id,item_sysid,item_code,mou_inventory,create_date,on_hand,cogs,is_visible,last_in")
                    ->where('location_id',$row->location_id)
                    ->where('item_sysid',$row->item_sysid)
                    ->first();

                    $end_stock = isset($stock->on_hand) ? $stock->on_hand  :0;
                    $end_stock = floatval($end_stock) + floatval($row->mutation);

                    if ($flags=='IN') {
                        if (!($stock)) {
                            $stock=new ItemsStock();
                            $stock->create_date=Date('Y-m-d H:i:s');
                            $stock->location_id=$row->location_id;
                            $stock->item_sysid=$row->item_sysid;
                            $stock->item_code=$row->item_code;
                            $stock->mou_inventory=$row->mou_inventory;
                            $stock->is_visible='1';
                            $stock->is_hold='0';
                            $stock->on_hand=$end_stock;
                            $stock->cogs=$row->price;
                            $stock->last_in=Date('Y-m-d H:i:s');
                            $stock->save();
                        } else {
                            #Calculate Average Cost Here
                            $total=($stock->cogs * $stock->on_hand) + ($row->total);

                            #Update COGS if Stock is not NOL;
                            if ($end_stock<>0) {
                                $cogs=$total/$end_stock;
                            } else {
                                $cogs=$stock->cogs;
                            }

                            ItemsStock::where('location_id',$row->location_id)
                            ->where('item_sysid',$row->item_sysid)
                            ->update([
                                'cogs'=>$cogs,
                                'on_hand'=>$end_stock,
                                'last_in'=>Date('Y-m-d H:i:s'),
                                'update_date'=>Date('Y-m-d H:i:s')
                            ]);
                        }
                    } else {
                        ItemsStock::where('location_id',$row->location_id)
                        ->where('item_sysid',$row->item_sysid)
                        ->update([
                            'last_out'=>Date('Y-m-d H:i:s'),
                            'on_hand'=>$end_stock,
                            'update_date'=>Date('Y-m-d H:i:s'),
                        ]);
                    }
                    DB::update("UPDATE m_items a
                    INNER JOIN (SELECT item_sysid,SUM(on_hand) as on_hand FROM m_items_stock
                    WHERE item_sysid=?
                    GROUP BY item_sysid) as b ON a.sysid=b.item_sysid
                    SET a.on_hand=b.on_hand
                    WHERE a.sysid=?",[$row->item_sysid,$row->item_sysid]);
                }
                ItemMutations::
                where('doc_sysid',$sysid)
                ->where('doc_type',$source)
                ->where('line_state',$line_state)
                ->update(['is_deleted'=>'1']);

            } else {
                $respon['success']=false;
                $respon['message']="Data transaksi tidak ditemukan";
                return $respon;
                exit;
            }
        }

        if (($operation == 'inserted') || ($operation == 'updated')) {
            if ($flags=='VOID'){
                DB::insert("INSERT INTO t_item_mutations(doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,line_state,item_code,item_name,ref_date,ref_time,
                    mou_inventory,qty_in,qty_out,notes,price,purchase_price,total,entry_date,entry_by)
                    SELECT doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,'V',item_code,item_name,CURRENT_DATE(),CURRENT_TIME(),
                    mou_inventory,
                    CASE
                    WHEN qty_in>0 THEN  0
                    ELSE qty_out
                    END,
                    CASE
                    WHEN qty_out>0 THEN 0
                    ELSE qty_in
                    END,
                    CONCAT('VOID ',notes),price,purchase_price,-total,NOW(),-1 FROM t_item_mutations
                    WHERE doc_sysid=? AND doc_type=? AND line_state='N' AND is_deleted=0",[$sysid,$source]);
            }  else if ($source=='PURCHASE'){
                DB::insert("INSERT INTO t_item_mutations(doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,line_state,item_code,item_name,ref_date,ref_time,
                    mou_inventory,qty_in,notes,price,purchase_price,total,entry_date,entry_by)
                    SELECT a.sysid,?,a.doc_number,a.invoice_number,a.location_id,b.item_sysid,'N',b.item_code,b.item_name,a.ref_date,a.ref_time,
                    b.mou_inventory,b.qty_update,CONCAT('Penerimaan Barang [',a.doc_number,'] ',a.partner_name,'/',a.invoice_number),b.cost_update,b.cost_update,b.total,NOW(),a.create_by
                    FROM t_purchase_receive1 a INNER JOIN t_purchase_receive2 b ON a.sysid=b.sysid
                    WHERE a.sysid=?",[$source,$sysid]);
            }  else if ($source=='PURCHASE-RETURN'){
                DB::insert("INSERT INTO t_item_mutations(doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,line_state,item_code,item_name,ref_date,ref_time,
                    mou_inventory,qty_out,notes,price,purchase_price,total,entry_date,entry_by)
                    SELECT a.sysid,?,a.doc_number,a.invoice_number,a.location_id,b.item_sysid,'N',b.item_code,b.item_name,a.ref_date,a.ref_time,
                    b.mou_inventory,ABS(b.qty_update),CONCAT('Retur Penerimaan Barang [',a.doc_number,'] ',a.partner_name,'/',a.invoice_number),b.cost_update,b.cost_update,b.total,NOW(),a.create_by
                    FROM t_purchase_receive1 a INNER JOIN t_purchase_receive2 b ON a.sysid=b.sysid
                    WHERE a.sysid=?",[$source,$sysid]);
            }  else if ($source=='DISTRIBUTION-OUT'){
                DB::insert("INSERT INTO t_item_mutations(doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,line_state,item_code,item_name,ref_date,ref_time,
                    mou_inventory,qty_out,notes,price,total,entry_date,entry_by)
                    SELECT a.sysid,?,a.doc_number,a.ref_number,a.location_id_from,b.item_sysid,'N',b.item_code,b.item_name,a.ref_date,a.ref_time,
                    b.mou_inventory,ABS(b.quantity_update),CONCAT('Distribusi barang [',a.doc_number,'] ',a.location_name_from,' ke ',a.location_name_to),b.item_cost,b.line_cost,NOW(),a.create_by
                    FROM t_items_distribution1 a INNER JOIN t_items_distribution2 b ON a.sysid=b.sysid
                    WHERE a.sysid=?",[$source,$sysid]);
            }
        }

        $data=ItemMutations::selectRaw('sysid,location_id,item_sysid,item_code,(qty_in-qty_out)+qty_adjustment as mutation,mou_inventory,price,total')
        ->where('doc_sysid',$sysid)
        ->where('doc_type',$source)
        ->where('line_state',$line_state)
        ->where('is_deleted',0)
        ->get();

        foreach($data as $row) {
            $stock=ItemsStock::selectRaw("location_id,item_sysid,item_code,mou_inventory,create_date,on_hand,cogs,is_visible,last_in,cardlog_sysid,update_date")
            ->where('location_id',$row->location_id)
            ->where('item_sysid',$row->item_sysid)
            ->first();

            $begin_stock=isset($stock->on_hand) ? $stock->on_hand :0;
            $end_stock=isset($stock->on_hand) ? $stock->on_hand :0;
            $end_stock=floatval($end_stock) + floatval($row->mutation);

		    if ($flags=='IN') {
                if (!($stock)) {
                    $stock=new ItemsStock();
                    $stock->create_date=Date('Y-m-d H:i:s');
                    $stock->location_id=$row->location_id;
                    $stock->item_sysid=$row->item_sysid;
                    $stock->item_code=$row->item_code;
                    $stock->mou_inventory=$row->mou_inventory;
                    $stock->is_visible='1';
                    $stock->is_hold='0';
                    $stock->on_hand=$end_stock;
                    $stock->cogs=$row->price;
                    $stock->last_in=Date('Y-m-d H:i:s');
                    $stock->create_date=Date('Y-m-d H:i:s');
                    $stock->update_date=Date('Y-m-d H:i:s');
                    $stock->cardlog_sysid=$row->sysid;
                    $stock->save();
                } else {
                    #Calculate Average Cost Here
                    $total=($stock->cogs * $stock->on_hand) + ($row->total);

                    #Update COGS if Stock is not NOL;
                    if ($end_stock<>0) {
                        $cogs=$total/$end_stock;
                    } else {
                        $cogs=$stock->cogs;
                    }

                    ItemsStock::where('location_id',$row->location_id)
                    ->where('item_sysid',$row->item_sysid)
                    ->update([
                        'cogs'=>$cogs,
                        'on_hand'=>$end_stock,
                        'last_in'=>Date('Y-m-d H:i:s'),
                        'cardlog_sysid'=>$row->sysid,
                        'update_date'=>Date('Y-m-d H:i:s')
                    ]);
                }
            } else if ($flags=='SO') {
                ItemsStock::where('location_id',$row->location_id)
                ->where('item_sysid',$row->item_sysid)
                ->update([
                    'cogs'=>$row->price,
                    'on_hand'=>$end_stock,
                    'cardlog_sysid'=>$row->sysid,
                    'update_date'=>Date('Y-m-d H:i:s'),
                ]);
		    } else if ($flags=='VOID') {
                #Calculate Average Cost Here
                $total=($stock->cogs * $stock->on_hand) + ($row->total);

                #Update COGS if Stock is not NOL;
                if ($end_stock<>0) {
                    $cogs=$total/$end_stock;
                } else {
                    $cogs=$stock->cogs;
                }
                #void goods issue action not recalculate COGS
                if ($row->mutation<0) {
                    $cogs=$stock->cogs;
                }

                ItemsStock::where('location_id',$row->location_id)
                ->where('item_sysid',$row->item_sysid)
                ->update([
                    'cogs'=>$cogs,
                    'on_hand'=>$end_stock,
                    'cardlog_sysid'=>$row->sysid,
                    'update_date'=>Date('Y-m-d H:i:s')
                ]);
            } else {
                ItemsStock::where('location_id',$row->location_id)
                ->where('item_sysid',$row->item_sysid)
                ->update([
                    'last_out'=>Date('Y-m-d H:i:s'),
                    'on_hand'=>$end_stock,
                    'cardlog_sysid'=>$row->sysid,
                    'update_date'=>Date('Y-m-d H:i:s'),
                ]);
            }

            ItemMutations::where('sysid',$row->sysid)
            ->update([
                'qty_begin'=>$begin_stock,
                'qty_end'=>$end_stock
            ]);

            DB::update("UPDATE m_items a
            INNER JOIN (SELECT item_sysid,SUM(on_hand) as on_hand FROM m_items_stock
            WHERE item_sysid=?
            GROUP BY item_sysid) as b ON a.sysid=b.item_sysid
            SET a.on_hand=b.on_hand
            WHERE a.sysid=?",[$row->item_sysid,$row->item_sysid]);
        }

        DB::insert("INSERT INTO tmp_stock SELECT DISTINCT location_id,item_code,0 FROM t_item_mutations
            WHERE doc_sysid=? AND  doc_type=? AND line_state=? AND is_deleted=0",[$sysid,$source,$line_state]);
        $stock=DB::table('tmp_stock as a')
        ->selectRaw("a.item_code,b.on_hand,c.item_name1 as item_name,c.inventory_group,d.warehouse_group,d.location_name")
        ->join('m_items_stock as b', function ($join) {
            $join->on('a.item_code','=','b.item_code');
            $join->on('a.location_id','=','b.location_id');
        })
        ->join('m_items as c','a.item_code','=','c.item_code')
        ->join('m_warehouse as d','a.location_id','=','d.sysid')
        ->distinct()->get();

        DB::statement("DROP TEMPORARY TABLE IF EXISTS tmp_stock");
        foreach($stock as $row) {
            $item_code=$row->item_code;
            $item_name=$row->item_name;
            $location_name=$row->location_name;
            $stock=(float)$row->on_hand;
            if ($stock<0){
                $respon['success']=false;
                $respon['message']="Item $item_code - $item_name ( $location_name ) Stock tidak mencukupi/stock Minus";
                break;
            }
            if ($row->inventory_group<>$row->warehouse_group){
                $respon['success']=false;
                $respon['message']="Lokasi ($location_name) tidak bisa untuk item $item_name";
                break;
            }
        }
        return $respon;
   }
}
