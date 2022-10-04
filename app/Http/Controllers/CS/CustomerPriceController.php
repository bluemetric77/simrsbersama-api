<?php

namespace App\Http\Controllers\CS;

use App\Models\CS\CustomerPrice;
use App\Models\CS\StandartCost;
use App\Models\CS\StandartCostDetail;
use App\Models\Master\VehicleVariableCost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class CustomerPriceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $partner_id = isset($request->partner_id) ? $request->partner_id:'';
        $price_type = isset($request->price_type) ? $request->price_type:'0';
        $data=CustomerPrice::from('m_customer_price as a')
        ->selectRaw("a.id,a.partner_id,b.partner_name,a.vehicle_type,a.origins,a.destinations,
        a.origins_geofance,a.destinations_geofance,a.distance,eta,a.standart_price,a.other_fee,a.fleet_price,
        a.standart_cost,a.is_active,a.update_userid,a.update_timestamp")
        ->leftjoin('m_partner as b','a.partner_id','=','b.partner_id');
        if ($price_type=='1') {
            $data=$data->where('a.is_active','1') ;   
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.vehicle_type', 'like', $filter);
                $q->orwhere('a.origins', 'like', $filter);
                $q->orwhere('a.destinations', 'like', $filter);
                $q->orwhere('a.partner_id', 'like', $filter);
                $q->orwhere('b.partner_name', 'like', $filter);
            });
        }
        if (!($sortBy == '')) {
            if ($descending) {
                $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
            } else {
                $data = $data->orderBy($sortBy, 'asc')->paginate($limit);
            }
        } else {
            $data = $data->paginate($limit);
        }
        return response()->success('Success', $data);
    }

    public function delete(Request $request){
        $id=isset($request->id) ? $request->id :'-1';
        $data=CustomerPrice::find($id);
        if ($data) {
            DB::beginTransaction();
            try {
                $cost_id=$data->cost_id;
                $data->delete();
                StandartCost::where('cost_id',$cost_id)->delete();
                StandartCostDetail::where('cost_id',$cost_id)->delete();
                DB::commit();
                return response()->success('Success','Hapus data berhasil');
            } catch(Exception $error) {
                DB::rollback();    
            }    
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $id=isset($request->id) ? $request->id :'-1';
        $data['price']=CustomerPrice::from('m_customer_price as a')
        ->selectRaw("a.id,a.partner_id,CONCAT(a.partner_id,' - ',IFNULL(b.partner_name,'')) as partner_name,a.vehicle_type,a.origins,a.destinations,
        a.origins_geofance,a.destinations_geofance,a.distance,eta,a.standart_price,a.other_fee,a.fleet_price,
        a.standart_cost,a.is_active,a.cost_id")
        ->leftjoin('m_partner as b','a.partner_id','=','b.partner_id')
        ->where('a.id',$id)->first();
        if ($data['price']){
            $data['costs']=StandartCostDetail::from('m_standart_fleet_cost2 as a')
            ->selectRaw("a.line_no,b.id,a.descriptions,a.fleet_cost,IFNULL(b.is_fix,0) as is_fix,IFNULL(b.is_invoice,0) as is_invoice")
            ->leftjoin("m_fleet_cost as b","a.id","=","b.id")
            ->where('a.cost_id',$data['price']->cost_id)->get();
        }
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $costs = $info['cost'];
        $validator=Validator::make($row,
        [
            'vehicle_type'=>'bail|required',
            'origins'=>'bail|required',
            'destinations'=>'bail|required',
            'standart_cost'=>'bail|required',
            'fleet_price'=>'bail|required',
            'eta'=>'bail|required|numeric|min:1',
        ],[
            'vehicle_type.required'=>'Jenis unit/kendaraan harus diisi',
            'origins.required'=>'Asal kegiatan harus diisi',
            'destinations.required'=>'Tujuan kegiatan harus diisi',
            'standart_cost.required'=>'Biaya operasional harus diisi',
            'fleet_price.required'=>'Tarif kegiatan harus diisi',
            'eta.required'=>'ETA harus diisi',
            'eta.min'=>'ETA harus lebih besar dari NOL',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=CustomerPrice::find($row['id']);
            if ($data){
                $id=$row['id'];
                $cost_id=$row['cost_id'];
                $data->update([
                    'partner_id'=>$row['partner_id'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'origins'=>$row['origins'],
                    'destinations'=>$row['destinations'],
                    'distance'=>$row['distance'],
                    'eta'=>$row['eta'],
                    'standart_price'=>$row['standart_price'],
                    'other_fee'=>$row['other_fee'],
                    'fleet_price'=>$row['fleet_price'],
                    'standart_cost'=>$row['standart_cost'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
                StandartCost::where('cost_id',$cost_id)
                ->update([
                    'descriptions'=>$row['origins'].'-'.$row['origins'].' ('.$row['vehicle_type'].')',
                    'is_active'=>$row['is_active'],
                    'fleet_cost'=>$row['standart_cost']
                ]);
            } else {
                $cost_id=StandartCost::insertGetId([
                    'descriptions'=>$row['origins'].'-'.$row['origins'].' ('.$row['vehicle_type'].')',
                    'is_active'=>$row['is_active'],
                    'fleet_cost'=>$row['standart_cost']
                ]);
                $id=CustomerPrice::insertGetId([
                    'partner_id'=>$row['partner_id'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'origins'=>$row['origins'],
                    'destinations'=>$row['destinations'],
                    'distance'=>$row['distance'],
                    'eta'=>$row['eta'],
                    'standart_price'=>$row['standart_price'],
                    'other_fee'=>$row['other_fee'],
                    'fleet_price'=>$row['fleet_price'],
                    'standart_cost'=>$row['standart_cost'],
                    'cost_id'=>$cost_id,
                    'valid_price'=>Date('Y-m-d'),
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            StandartCostDetail::where('cost_id',$cost_id)->delete();
            foreach($costs as $cost){
                StandartCostDetail::insert([
                   'cost_id'=>$cost_id, 
                   'line_no'=>$cost['line_no'], 
                   'id'=>$cost['id'], 
                   'descriptions'=>$cost['descriptions'], 
                   'fleet_cost'=>$cost['fleet_cost'], 
                ]);
            }
            PagesHelp::write_log($request,'Tarif',-1,$id,'Tarif operasional '.$row['origins'].'-'.$row['destinations']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function getlist(Request $request){
        $partner_id=isset($request->partner_id) ? $request->partner_id :'';
        $vehicle_type=isset($request->vehicle_type) ? $request->vehicle_type :'';
        $data=CustomerPrice::selectRaw("id,CONCAT('[ ',vehicle_type,' ] ',origins,'-',destinations) AS route_name,
        cost_id,fleet_price,standart_cost,origins,destinations")
            ->where('partner_id',$partner_id)
            ->where('is_active','1')
            ->orderBy('id','asc')->get();
        return response()->success('Success',$data);
    }

    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $partner_id = isset($request->partner_id) ? $request->partner_id:'';
        $data=CustomerPrice::from('m_customer_price as a')
        ->selectRaw("a.id,a.vehicle_type,a.origins,a.destinations,
        a.origins_geofance,a.destinations_geofance,a.distance,a.eta,
        a.standart_price,a.other_fee,a.fleet_price,
        IF(a.standart_cost<>0,a.standart_cost,b.fleet_cost) as standart_cost,a.cost_id")
        ->leftjoin('m_standart_fleet_cost1 as b','a.cost_id','=','b.cost_id')
        ->where('a.partner_id',$partner_id)
        ->where('a.is_active','1');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.vehicle_type', 'like', $filter);
                $q->orwhere('a.origins', 'like', $filter);
                $q->orwhere('a.destinations', 'like', $filter);
            });
        }
        if (!($sortBy == '')) {
            if ($descending) {
                $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
            } else {
                $data = $data->orderBy($sortBy, 'asc')->paginate($limit);
            }
        } else {
            $data = $data->paginate($limit);
        }
        return response()->success('Success', $data);
    }

    
}
