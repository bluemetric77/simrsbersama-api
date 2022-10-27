<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\DrugInformations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PagesHelp;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Inventory::selectRaw("sysid,item_code,item_code_old,item_name1,trademark")
            ->where('inventory_group',$group_name)
            ->where('is_active',true);
        } else {
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.sysid,a.item_code,a.item_code_old,a.item_name1,a.mou_inventory,a.trademark,
                a.is_sales,a.is_purchase,a.is_production,a.is_material,
                a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as  manufactur,c.supplier_name,a.het_price,a.hna,on_hand,on_hand_unit,
                a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name,a.image_path")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->where('a.inventory_group',$group_name);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('item_code', 'ilike', $filter);
                $q->orwhere('item_code_old', 'ilike', $filter);
                $q->orwhere('item_name1', 'ilike', $filter);
                $q->orwhere('trademark', 'ilike', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Inventory::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->sysid,'Deleting recods '.$data->item_code.'-'.$data->item_name1);
                $data->delete();
                DB::commit();
                return response()->success('Success','Hapus data berhasil');
            } 
            catch(\Exception $e) {
                DB::rollback();
                return response()->error('',501,$e);
            }
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function edit(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        if ($group_name=='MEDICAL'){
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.sysid,a.item_code,a.item_code_old,a.item_name1,a.item_name2,a.mou_inventory,a.product_line,
                a.is_price_rounded,a.price_rounded,a.is_expired_control,a.is_sales,a.is_purchase,a.is_production,a.is_material,
                a.is_consignment,a.is_formularium,a.is_employee,a.is_inhealth,a.is_bpjs,a.is_employee,a.is_national,a.item_group_sysid,
                a.trademark,a.manufactur_sysid,a.prefered_vendor_sysid,a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as manufactur,a.inventory_group,a.is_generic,c.supplier_name as supplier,a.het_price,a.hna,a.cogs,
                a.on_hand,a.on_hand_unit,a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name,
                COALESCE(f.generic_name,'') as generic_name,COALESCE(f.rate,0) as rate,COALESCE(f.units,'') as units,COALESCE(f.forms,'') as forms,
                COALESCE(f.special_instruction,'') as special_instruction,COALESCE(f.storage_instruction,'') as storage_instruction,
                COALESCE(a.is_generic,false) as is_generic,COALESCE(f.medical_uses,'') as medical_uses,a.image_path")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->leftjoin("m_items_informations as f","a.sysid","=","f.sysid")
            ->where('a.sysid',$sysid)->first();
        }
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = json_decode($request->json,true);
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'item_code'=>'bail|required',
            'item_name1'=>'bail|required',
            'mou_inventory'=>'bail|required',
        ],[
            'item_code.required'=>'Kode inventory diisi',
            'item_name1.required'=>'Nama inventory diisi',
            'mou_inventory.required'=>'Satuan simpan diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Inventory();
                $data->inventory_group=$row['inventory_group'];
            } else if ($opr=='updated'){
                $data = Inventory::find($row['sysid']);
            }
            $data->item_code=$row['item_code'];
            $data->item_name1=$row['item_name1'];
            $data->item_name2=$row['item_name2'];
            $data->mou_inventory=$row['mou_inventory'];
            $data->is_price_rounded=isset($row['is_price_rounded']) ? $row['is_price_rounded'] :false;
            $data->price_rounded=isset($row['price_rounded']) ? $row['price_rounded'] :0;
            $data->manufactur_sysid=isset($row['manufactur_sysid']) ? $row['manufactur_sysid'] :-1;
            $data->prefered_vendor_sysid=isset($row['prefered_vendor_sysid']) ? $row['prefered_vendor_sysid'] :-1;
            $data->is_price_rounded=$row['is_price_rounded'];
            $data->price_rounded=$row['price_rounded'];
            $data->is_sales=$row['is_sales'];
            $data->is_purchase=$row['is_purchase'];
            $data->is_material=$row['is_material'];
            $data->is_production=$row['is_production'];
            $data->item_group_sysid=$row['item_group_sysid'];
            $data->item_subgroup_sysid=$row['item_subgroup_sysid'];
            if ($row['inventory_group']=='MEDICAL'){
                $data->het_price=$row['het_price'];
                $data->is_consignment=$row['is_consignment'];
                $data->is_formularium=$row['is_formularium'];
                $data->is_inhealth=$row['is_inhealth'];
                $data->is_bpjs=$row['is_bpjs'];
                $data->is_national=$row['is_national'];
                $data->is_employee=$row['is_employee'];
                $data->is_expired_control=$row['is_expired_control'];
                $data->is_generic=$row['is_generic'];
            }
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            $sysid=$data->sysid;
            if ($row['inventory_group']=='MEDICAL'){
                $drugs=DrugInformations::find($sysid);
                if (!($drugs)) {
                    $drugs=new DrugInformations();
                }
                $drugs->sysid=$sysid;
                $drugs->generic_name=$row['generic_name'];
                $drugs->rate=$row['rate'];
                $drugs->units=$row['units'];
                $drugs->forms=isset($row['forms']) ? $row['forms'] :'';
                $drugs->storage_instruction=$row['storage_instruction'];
                $drugs->special_instruction=$row['special_instruction'];
                $drugs->medical_uses=$row['medical_uses'];
                $drugs->is_generic=$row['is_generic'];
                $drugs->save();
            }

            $uploadedFile = $request->file('file');
            if ($uploadedFile){
                $originalFile = $uploadedFile->getClientOriginalName();        
                $originalFile = Date('Ymd-His')."-".$originalFile;
                $directory="inventory";
                $path = $uploadedFile->storeAs($directory,$originalFile);
                Inventory::where('sysid',$sysid)->update(['image_path'=>$path]);
            }

            PagesHelp::write_log($request,$data->sysid,$data->item_code,'Add/Update recods ['.$data->item_code.'-'.$data->item_name1.']');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function download(Request $request)
    {
        $sysid = isset($request->sysid) ? $request->sysid : -1;
        $document=isset($request->document) ? $request->document :'';
        $data=Inventory::selectRaw("COALESCE(image_path,'') as image")->where('sysid',$sysid)->first();
        if ($data) {
            if ($data->image!=''){
                //$publicPath = \Storage::url($data->image);
                $headers = array('Content-Type: application/image');
                return Storage::download($data->image);            
            }
        } else {
              return response()->error('',301,'Dokumen tidak ditemukan');
        }
    }
}
