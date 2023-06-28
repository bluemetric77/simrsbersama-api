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
                  WHERE doc_sysid=? AND  doc_type=?",[$sysid,$source]);
            $buffer=ItemMutations::from("t_item_mutations as a")->selectRaw("b.item_code,c.item_name1 as item_name,d.location_name,b.last_in,b.last_out")
            ->join("m_items_stock as b", function($join){
               $join->on("a.location_id","=","b.location_id");
               $join->on("a.item_sysid","=","b.item_sysid");
            })
            ->join("m_items as c","a.item_sysid","=","c.sysid")
            ->join("m_warehouse as d","a.location_id","=","d.sysid")
            ->where('a.doc_sysid',$sysid)
            ->where('a.doc_type',$source)
            ->get();
            foreach($buffer as $line) {
               if ($line->last_out > $line->last_in){
                  $item_code=$line->item_code;
                  $item_name=$line->item_name;
                  $respon['success']=false;
                  $respon['message']="Data tidak bisa ubah, sudah ada transaksi pengeluaran [$item_code - $item_name]";
                  return $respon;  
                  exit(0);        
               }
            }

            #Recalculation before
            $data=ItemMutations::selectRaw('location_id,item_sysid,item_code,-(qty_in+qty_out)+qty_adjustment as mutation,mou_inventory,price,-total as total')
            ->where('doc_sysid',$sysid)
            ->where('doc_type',$source)
            ->get();
            foreach($data as $row) {
               if ($flags=='IN') {
                  $stock=ItemsStock::selectRaw("location_id,item_sysid,item_code,mou_inventory,create_date,on_hand,cogs,is_visible,last_in")
                  ->where('location_id',$row->location_id)
                  ->where('item_sysid',$row->item_sysid)
                  ->first();
                  if (!($stock)) {
                     $stock=new ItemsStock();
                     $stock->create_date=Date('Y-m-d H:i:s');
                     $stock->location_id=$row->location_id;
                     $stock->item_sysid=$row->item_sysid;
                     $stock->item_code=$row->item_code;
                     $stock->mou_inventory=$row->mou_inventory;
                     $stock->is_visible='1';
                     $stock->is_hold='0';
                     $stock->on_hand=$row->mutation;
                     $stock->cogs=$row->price;
                     $stock->last_in=Date('Y-m-d H:i:s');
                     $stock->save();
                  } else {
                     #Calculate Average Cost Here
                     $total=($stock->cogs * $stock->on_hand) + ($row->total);
                     $on_hand=floatval($stock->on_hand) + floatval($row->mutation);

                     #Update COGS if Stock is not NOL;
                     if ($on_hand<>0) {
                        $cogs=$total/$on_hand;
                     } else {
                        $cogs=$stock->cogs;
                     }

                     ItemsStock::where('location_id',$row->location_id)
                     ->where('item_sysid',$row->item_sysid)
                     ->update([
                        'cogs'=>$cogs,
                        'on_hand'=>$on_hand,
                        'last_in'=>Date('Y-m-d H:i:s'),
                        'update_date'=>Date('Y-m-d H:i:s')
                     ]);               
                  }
               } else if ($flags=='SO') {
                  DB::update('UPDATE m_items_stock SET on_hand=on_hand + ?,cogs=?
                     WHERE location_id=? AND item_sysid=?',[$row->mutation,$row->price,$row->location_id,$row->item_sysid]);
               } else {
                  DB::update('UPDATE m_items_stock SET on_hand=on_hand + ?,last_out=NOW()
                     WHERE location_id=? AND item_sysid=?',[$row->mutation,$row->location_id,$row->item_sysid]);
               }
            }
            ItemMutations::select('location_id')
               ->where('doc_sysid',$sysid)
               ->where('doc_type',$source)
               ->delete();
         } else {
            $respon['success']=false;
            $respon['message']="Data transaksi tidak ditemukan";
            return $respon;
            exit;
         }     
      }
      if (($operation == 'inserted') || ($operation == 'updated')) {   
         if ($source=='PURCHASE'){
            DB::insert("INSERT INTO t_item_mutations(doc_sysid,doc_type,doc_number,ref_number,location_id,item_sysid,item_code,item_name,ref_date,ref_time,
                  entry_date,mou_inventory,qty_in,notes,price,purchase_price,total,entry_by)
                  SELECT a.sysid,?,a.doc_number,a.invoice_number,a.location_id,b.item_id,b.item_code,b.item_name,a.ref_date,CURRENT_TIME(),
                  NOW(),b.mou_inventory,b.qty_update,CONCAT('Penerimaan Barang [',a.doc_number,'] ',a.partner_name,'/',a.invoice_number),b.cost_update,b.cost_update,b.total,a.create_by
                  FROM t_purchase_receive1 a INNER JOIN t_purchase_receive2 b ON a.sysid=b.sysid
                  WHERE a.sysid=?",[$source,$sysid]);
         }
      }
      $data=ItemMutations::selectRaw('location_id,item_sysid,item_code,(qty_in+qty_out)+qty_adjustment as mutation,mou_inventory,price,total')
      ->where('doc_sysid',$sysid)
      ->where('doc_type',$source)
      ->get();
      foreach($data as $row) {
		   if ($flags=='IN') {
            $stock=ItemsStock::selectRaw("location_id,item_sysid,item_code,mou_inventory,create_date,on_hand,cogs,is_visible,last_in")
            ->where('location_id',$row->location_id)
            ->where('item_sysid',$row->item_sysid)
            ->first();
            if (!($stock)) {
               $stock=new ItemsStock();
               $stock->create_date=Date('Y-m-d H:i:s');
               $stock->location_id=$row->location_id;
               $stock->item_sysid=$row->item_sysid;
               $stock->item_code=$row->item_code;
               $stock->mou_inventory=$row->mou_inventory;
               $stock->is_visible='1';
               $stock->is_hold='0';
               $stock->on_hand=$row->mutation;
               $stock->cogs=$row->price;
               $stock->last_in=Date('Y-m-d H:i:s');
               $stock->save();
            } else {
               #Calculate Average Cost Here
               $total=($stock->cogs * $stock->on_hand) + ($row->total);
               $on_hand=floatval($stock->on_hand) + floatval($row->mutation);

               #Update COGS if Stock is not NOL;
               if ($on_hand<>0) {
                  $cogs=$total/$on_hand;
               } else {
                  $cogs=$stock->cogs;
               }

               ItemsStock::where('location_id',$row->location_id)
               ->where('item_sysid',$row->item_sysid)
               ->update([
                  'cogs'=>$cogs,
                  'on_hand'=>$on_hand,
                  'last_in'=>Date('Y-m-d H:i:s'),
                  'update_date'=>Date('Y-m-d H:i:s')
               ]);               
            }
         } else if ($flags=='SO') {
            DB::update('UPDATE m_items_stock SET on_hand=on_hand + ?,cogs=?,last_update=?
               WHERE location_id=? AND item_sysid=?',
               [$row->mutation,$row->price,Date('Y-m-d H:i:s'),$row->location_id,$row->item_sysid]);
         } else {
            DB::update('UPDATE m_items_stock SET on_hand=on_hand + ?,last_out=?,last_update=?
               WHERE location_id=? AND item_sysid=?',
               [$row->mutation,Date('Y-m-d H:i:s'),Date('Y-m-d H:i:s'),$row->location_id,$row->item_sysid]);
         }
      }
      DB::insert("INSERT INTO tmp_stock SELECT DISTINCT location_id,item_code,0 FROM t_item_mutations
         WHERE doc_sysid=? AND  doc_type=?",[$sysid,$source]);      
      $stock=DB::table('tmp_stock as a')
         ->selectRaw("a.item_code,b.on_hand,c.item_name1 as item_name")
         ->join('m_items_stock as b', function ($join) {
            $join->on('a.item_code','=','b.item_code');
            $join->on('a.location_id','=','b.location_id');
         })
         ->join('m_items as c','a.item_code','=','c.item_code')
         ->distinct()->get();
		DB::statement("DROP TEMPORARY TABLE IF EXISTS tmp_stock");
      foreach($stock as $row) {
         $item_code=$row->item_code;
         $item_name=$row->item_name;
         $stock=(float)$row->on_hand;
         if ($stock<0){
            $respon['success']=false;
            $respon['message']="Item $item_code - $item_name Stock tidak mencukupi/stock Minus";
            break;
         }
      }
      return $respon;  
   }
}
