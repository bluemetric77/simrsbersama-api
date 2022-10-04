<?php
namespace App\Helpers;
use PagesHelp;


use Illuminate\Support\Facades\DB;

class Inventory
{
   public static function getPriceCode(){
      $lastInt=PagesHelp::get_data('PRICE_CODE','I');
      $lastInt=$lastInt+1;
      PagesHelp::write_data('PRICE_CODE','I',$lastInt);
      $price_code=strtoupper(dechex($lastInt));
      $price_code=str_pad($price_code,5,"0",STR_PAD_LEFT);
      return $price_code;
   }

   public static function FIFO($sysid,$source,$operation){
      $respon=array();
      $respon['success']=true;
      $respon['message']="";
      
      /* Rollback Stock */
      DB::update("UPDATE m_item_stock_price a
            INNER JOIN t_item_price b ON a.item_code=b.item_code AND a.warehouse_id=b.warehouse_id AND a.price_code=b.price_code
            SET a.on_hand=IFNULL(a.on_hand,0)-IFNULL(b.qty,0)  
            WHERE b.sysid=? AND b.doc_type=? AND IFNULL(b.is_deleted,0)=0",[$sysid,$source]);

      if ($source=='LPB'){
         $add=DB::table('t_item_invoice2 as a')
           ->selectRaw("b.ref_date,a.warehouse_id,a.item_code,a.descriptions,a.inventory_update as qty,a.price_cost as price,IFNULL(c.price_code,'') as price_code")
           ->join('t_item_invoice1 as b','a.sysid','=','b.sysid')
           ->leftjoin('t_item_price as c', function($join)
                {
                    $join->on('a.sysid', '=', 'c.sysid');
                    $join->on('a.item_code', '=', 'c.item_code');
                    $join->on('c.doc_type','=',DB::raw("'INV'"));
                })
           ->where('a.sysid',$sysid)->distinct()->get();
      }
      else if ($source=='PBG'){
         $minus=DB::table('t_inventory_inout2')->selectRaw('warehouse_id,item_code,descriptions,qty_item')->where('sysid',$sysid)->get();
      } else if ($source=='ITI'){
         $add=DB::table('t_inventory_transfer2 as a')
            ->selectRaw("b.ref_date,a.warehouse_src as warehouse_id,a.item_code,a.descriptions,a.qty_item as qty,a.itemcost as price,IFNULL(c.price_code,'') as price_code")
            ->join('t_inventory_transfer1 as b','a.sysid','=','b.sysid')
            ->leftjoin('t_item_price as c', function($join)
                {
                    $join->on('a.sysid', '=', 'c.sysid');
                    $join->on('a.item_code', '=', 'c.item_code');
                    $join->on('c.doc_type','=',DB::raw("'ITI'"));
                })
            ->where('a.sysid',$sysid)->distinct()->get();
      } else if ($source=='ITO'){
         $minus=DB::table('t_inventory_transfer2')->selectRaw('warehouse_src as warehouse_id,item_code,descriptions,qty_item')->where('sysid',$sysid)->get();
      } else if ($source=='IOS'){
         $minus=DB::table('t_inventory_booked2')->selectRaw('warehouse_id,item_code,descriptions,qty_supply as qty_item')
         ->where('sysid',$sysid)
         ->where('qty_supply','<>',0)->get();
      } else if ($source='ISO'){
         $opname=DB::table('t_inventory_correction2 as a')
         ->selectRaw("b.ref_date,a.warehouse_id,a.price_code,a.item_code,a.descriptions,a.end_stock as qty,a.cost_adjustment as price")
         ->leftjoin('t_inventory_correction1 as b','a.sysid','=','b.sysid')
         ->where('a.sysid',$sysid)->get();
      }

      if (!($operation=='deleted')) {
         DB::delete('DELETE FROM t_item_price WHERE sysid=? AND doc_type=?',[$sysid,$source]);
         if (isset($opname)) {
            $line_id=0;
            foreach($opname as $row){
               $line_id++;
               $price_code=$row->price_code;
               DB::table('t_item_price')
                  ->insert([
                     'sysid'=>$sysid,
                     'item_code'=>$row->item_code,
                     'price_code'=>$price_code,
                     'doc_type'=>$source,
                     'qty'=>$row->qty,
                     'line_id'=>$line_id,
                     'item_cost'=>$row->price,
                     'warehouse_id'=>$row->warehouse_id
                  ]);

               /* Stock Price*/
               $hour=Date('H');
               $minute=Date('i');
               $second=Date('i');
               $date=date_create($row->ref_date);
               $date->modify("+$hour hour +$minute minute +$hour second");

               $price=DB::table('m_item_stock_price')
                  ->where('item_code',$row->item_code)     
                  ->where('warehouse_id',$row->warehouse_id)     
                  ->where('price_code',$price_code)
                  ->first();
               if (!($price)) {
                  DB::table('m_item_stock_price')
                     ->insert([
                        'item_code'=>$row->item_code,
                        'warehouse_id'=>$row->warehouse_id,
                        'price_code'=>$price_code,
                        'price_date'=>date_format($date,"Y-m-d H:i:s"),
                        'price'=>$row->price,
                        'update_timestamp'=>now(),
                        'update_userid'=>'-'
                     ]);
               }  else {
                  DB::table('m_item_stock_price')
                     ->where('item_code',$row->item_code)
                     ->where('warehouse_id',$row->warehouse_id)
                     ->where('price_code',$price_code)
                     ->update([
                        'price_date'=>date_format($date,"Y-m-d H:i:s"),
                        'price'=>$row->price
                     ]);
               }
               /* Stock */    
               $stock=DB::table('m_item_stock')
               ->where('item_code',$row->item_code)     
               ->where('warehouse_id',$row->warehouse_id)     
               ->first();
               if (!($stock)) {
                  DB::table('m_item_stock')
                  ->insert([
                     'item_code'=>$row->item_code,
                     'warehouse_id'=>$row->warehouse_id
                  ]);
               }      
            }
         }

         if (isset($add)) {
            $line_id=0;
            foreach($add as $row){
               $line_id++;
               $price_code=$row->price_code;
               if ($price_code==''){
                  $price_code=Inventory::getPriceCode();
               }
               DB::table('t_item_price')
                  ->insert([
                     'sysid'=>$sysid,
                     'item_code'=>$row->item_code,
                     'price_code'=>$price_code,
                     'doc_type'=>$source,
                     'qty'=>$row->qty,
                     'line_id'=>$line_id,
                     'item_cost'=>$row->price,
                     'warehouse_id'=>$row->warehouse_id
                  ]);
               /* Stock Price*/
               $hour=Date('H');
               $minute=Date('i');
               $second=Date('i');
               $date=date_create($row->ref_date);
               $date->modify("+$hour hour +$minute minute +$hour second");

               $price=DB::table('m_item_stock_price')
                  ->where('item_code',$row->item_code)     
                  ->where('warehouse_id',$row->warehouse_id)     
                  ->where('price_code',$price_code)
                  ->first();
               if (!($price)) {
                  DB::table('m_item_stock_price')
                     ->insert([
                        'item_code'=>$row->item_code,
                        'warehouse_id'=>$row->warehouse_id,
                        'price_code'=>$price_code,
                        'price_date'=>date_format($date,"Y-m-d H:i:s"),
                        'price'=>$row->price,
                        'update_timestamp'=>now(),
                        'update_userid'=>'-'
                     ]);
               }  else {
                  DB::table('m_item_stock_price')
                     ->where('item_code',$row->item_code)
                     ->where('warehouse_id',$row->warehouse_id)
                     ->where('price_code',$price_code)
                     ->update([
                        'price_date'=>date_format($date,"Y-m-d H:i:s"),
                        'price'=>$row->price
                     ]);
               }
               /* Stock */    
               $stock=DB::table('m_item_stock')
               ->where('item_code',$row->item_code)     
               ->where('warehouse_id',$row->warehouse_id)     
               ->first();
               if (!($stock)) {
                  DB::table('m_item_stock')
                  ->insert([
                     'item_code'=>$row->item_code,
                     'warehouse_id'=>$row->warehouse_id
                  ]);
               }      
            }
         }

         if (isset($minus)) {
            $line_id=0;
            foreach($minus as $row){
               $item_code=trim($row->item_code);
               $qty = floatval($row->qty_item);   
               $pc=DB::table('m_item_stock_price')->selectRaw('price_code,on_hand,price')
                  ->where('warehouse_id',$row->warehouse_id) 
                  ->where('item_code',$row->item_code) 
                  ->where('on_hand','>',0)
                  ->orderBy('price_date')
                  ->get();
               if (!$pc->isEmpty()) {
                  $rec = count($pc);
                  $i = 0;
                  while ($qty>0) {
                     $price  = $pc[$i];
                     $update = min(floatval($qty),floatval($price->on_hand));
                     if ($update <= 0){
                        $respon['success'] = false;
                        $respon['message'] = $row->item_code." - ".$row->descriptions." [ ".number_format($qty,2,',','.')." ], Stock tidak mencukupi Gudang ".$row->warehouse_id." (1)";
                        return $respon;
                        exit(0);
                     }
                     $line_id++;
                     DB::table('t_item_price')
                     ->insert([
                        'sysid'=>$sysid,
                        'item_code'=>$row->item_code,
                        'price_code'=>$price->price_code,
                        'doc_type'=>$source,
                        'qty'=> -$update,
                        'line_id'=>$line_id,
                        'item_cost'=>$price->price,
                        'warehouse_id'=>$row->warehouse_id
                     ]);
                     $i= $i + 1;
                     $qty=floatval($qty)-floatval($update);
                     if (($i==$rec) && ($qty>0)) {
                        $respon['success'] = false;
                        $respon['message'] = $row->item_code." - ".$row->descriptions." [ ".number_format($qty,2,',','.')." ], Stock tidak mencukupi Gudang ".$row->warehouse_id." ($i)->".$price->price_code;
                        return $respon;
                        exit(0);
                     }
                  }
               } else {
                  $respon['success']=false;
                  $respon['message']=$row->item_code.' '.$row->descriptions.",Stock [0] tidak mencukupi Gudang ".$row->warehouse_id." (3)";
                  return $respon;
                  exit(0);
               }
            }
         }
         DB::update("UPDATE m_item_stock_price a
            INNER JOIN t_item_price b ON a.item_code=b.item_code AND a.warehouse_id=b.warehouse_id AND a.price_code=b.price_code
            SET a.on_hand=IFNULL(a.on_hand,0)+IFNULL(b.qty,0)  
            WHERE b.sysid=? AND b.doc_type=? AND IFNULL(b.is_deleted,0)=0",[$sysid,$source]);
         return $respon;   
      } else {
         DB::update('UPDATE t_item_price SET is_deleted=1 WHERE sysid=? AND doc_type=?',[$sysid,$source]);
         return $respon;
      }
   }
   public static function ItemCard($sysid,$source,$operation,$cogs,$adjustment,$flager=false)
   {
      $respon=array();
      $respon['success']=true;
      $respon['message']="";

      $operation=strtolower($operation);
		DB::statement("DROP TEMPORARY TABLE IF EXISTS tmp_stock");
      DB::statement("CREATE TEMPORARY TABLE tmp_stock ENGINE=Memory AS SELECT item_code,qty_in as stock 
                     FROM t_item_mutation WHERE sysid IS NULL");

      $data=DB::table('t_item_mutation')->select('warehouse_id')
         ->where('sysid',$sysid)
         ->where('doc_type',$source)
         ->first();
      if (($operation=='updated') || ($operation=='deleted')) {
         if ($data){
            DB::insert("INSERT INTO tmp_stock SELECT DISTINCT item_code,0 FROM t_item_mutation
                  WHERE sysid=? AND  doc_type=?",[$sysid,$source]);      
            if ($operation=='updated') {    
               DB::delete("DELETE FROM t_item_mutation WHERE sysid=? AND doc_type=?",[$sysid,$source]);
            } else {
               if ($flager==true){
                  DB::update("UPDATE t_item_mutation SET is_deleted=1 WHERE sysid=? AND doc_type=?",[$sysid,$source]);
               } else {
                  DB::update("DELETE FROM t_item_mutation WHERE sysid=? AND doc_type=?",[$sysid,$source]);
               }
            }
         } else {
            $respon['success']=false;
            $respon['message']="Data transaksi tidak ditemukan";
            return $respon;
            exit;
         }     
      }
      $fifo=Inventory::FIFO($sysid,$source,$operation);
      if ($fifo['success']== false){
         $respon['success']=false;
         $respon['message']=$fifo['message'];
         return $respon;
         exit(0);
      }
      if (($operation == 'inserted') || ($operation == 'updated')) {   
         if ($source=='LPB'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_id,
                  ABS(b.qty),0,0,b.item_cost,b.item_cost * b.qty,a.ref_date,now(),CONCAT('Penerimaan Barang [',a.doc_number,'] ',a.partner_name,'/',a.ref_document),'',now()
                  FROM t_item_invoice1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
         }
         if ($source=='PBG'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_id,
                  0,ABS(b.qty),0,b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Pengeluaran Barang [',a.doc_number,'] ',IFNULL(a.reference,''),'/',IFNULL(a.vehicle_no,'-')),'',NOW()
                  FROM t_inventory_inout1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
         }
         if ($source=='ITO'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_src,
                  0,ABS(b.qty),0,b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Transfer stock [',a.doc_number,'] ',IFNULL(a.reference,''),'/',IFNULL(a.warehouse_dest,'-')),'',NOW()
                  FROM t_inventory_transfer1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
         }
         if ($source=='ITI'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_src,
                  ABS(b.qty),0,0,b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Transfer stock [',a.doc_number,'] ',IFNULL(a.reference,''),'/',IFNULL(a.warehouse_dest,'-')),'',NOW()
                  FROM t_inventory_transfer1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
         }
         if ($source=='IOS'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_id,
                  ABS(b.qty),0,0,b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Pemakaian Bengkel [',a.doc_number,'] ',IFNULL(a.reference,''),'/',IFNULL(a.warehouse_id,'-')),'',NOW()
                  FROM t_inventory_booked1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
            /*$data=DB::table('t_workorder_material')->select('warehouse_id')
               ->where('sysid',$sysid)
               ->first();
            $warehouse_id=$data->warehouse_id;   
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,?,
                  0,ABS(b.qty),0,b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Pemakaian Bengkel [',a.doc_number,']'),'',NOW()
                  FROM t_workorder_service a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$warehouse_id,$source,$sysid]);
            */      
         }
         if ($source=='ISO'){
            DB::insert("INSERT INTO t_item_mutation(sysid,doc_type,line_no,doc_number,item_code,price_code,warehouse_id,
                        qty_in,qty_out,qty_adjustment,inventory_cost,total_cost,ref_date,posting_date,line_notes,update_userid,update_timestamp)
                  SELECT ?,?,b.line_id,a.doc_number,b.item_code,b.price_code,a.warehouse_id,
                  0,0,ABS(b.qty),b.item_cost,b.item_cost * b.qty,a.ref_date,NOW(),CONCAT('Opname stock [',a.doc_number,'] ',IFNULL(a.reference1,'')),'',NOW()
                  FROM t_inventory_correction1 a INNER JOIN t_item_price b ON a.sysid=b.sysid AND b.doc_type=?
                  WHERE a.sysid=?",[$sysid,$source,$source,$sysid]);
         }
      }
      $data=DB::table('t_item_mutation')->select('warehouse_id')
         ->where('sysid',$sysid)
         ->where('doc_type',$source)
         ->first();
      if ($data){   
         $warehouse_id=$data->warehouse_id;   
      } else {
         $warehouse_id='-';   
      }
      DB::update("UPDATE m_item_stock a
         INNER JOIN 
         (SELECT warehouse_id,item_code,SUM(IFNULL(on_hand,0)) AS on_hand FROM m_item_stock_price 
         WHERE warehouse_id=?
         GROUP BY warehouse_id,item_code) b ON a.item_code=b.item_code AND a.warehouse_id=b.warehouse_id
         SET a.on_hand=b.on_hand
         WHERE a.warehouse_id=?",[$warehouse_id,$warehouse_id]);
		if (($cogs == TRUE) && ($adjustment == FALSE)) {
			DB::update("UPDATE m_item a
				INNER JOIN (SELECT item_code,SUM((qty_in-qty_out)+qty_adjustment) as updated, SUM(total_cost) as total_cost FROM t_item_mutation
            WHERE sysid=? AND doc_type=? AND IFNULL(is_deleted,0)=0
            GROUP BY item_code) b ON a.item_code=b.item_code
				SET a.cost_average=((a.on_hand*a.cost_average)+b.total_cost)/(a.on_hand+b.updated)
				WHERE (a.on_hand+b.updated)<>0",[$sysid,$source]);
			}
		if (($cogs == TRUE) && ($adjustment == TRUE)) {
			DB::update("UPDATE m_item a
				INNER JOIN t_item_mutation b ON a.item_code=b.item_code
				SET a.avg_cost=b.inventory_cost
				WHERE b.sysid=$sysid AND b.doc_type='$source'");
			DB::update("UPDATE m_item_stock a
				INNER JOIN t_inventory_correction2 b ON a.item_code=b.item_code AND a.warehouse_id=b.warehouse_id
				SET a.location=b.location
				WHERE b.sysid=?",[$sysid]);
		}
      DB::update("UPDATE m_item a
         INNER JOIN 
         (SELECT item_code,SUM(on_hand) AS on_hand FROM m_item_stock 
         GROUP BY item_code) b ON a.item_code=b.item_code
         SET a.on_hand=b.on_hand");
      DB::insert("INSERT INTO tmp_stock SELECT DISTINCT item_code,0 FROM t_item_mutation
         WHERE sysid=? AND  doc_type=?",[$sysid,$source]);      
      $stock=DB::table('m_item_stock as a')
         ->select('a.item_code','a.on_hand','d.descriptions as item_name')
         ->join('tmp_stock as c','a.item_code','=','c.item_code')
         ->join('m_item as d','a.item_code','=','d.item_code')
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
