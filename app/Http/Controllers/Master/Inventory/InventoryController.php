<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\DrugInformations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PagesHelp;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.sysid,a.item_code,a.item_code_old,a.item_name1,a.item_name2,IFNULL(a.mou_purchase,'') as mou_purchase,a.conversion,
                IFNULL(a.mou_inventory,'') as mou_inventory,a.product_line,
                a.is_price_rounded,a.price_rounded,a.is_expired_control,a.item_group_sysid,
                a.trademark,a.manufactur_sysid,a.prefered_vendor_sysid,a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as manufactur,a.inventory_group,a.is_generic,c.supplier_name as supplier,a.het_price,a.hna,a.cogs,
                a.on_hand,a.on_hand_unit,a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->leftjoin("m_items_informations as f","a.sysid","=","f.sysid")
            ->where('a.inventory_group',$group_name)
            ->where('a.is_active','1');
        } else {
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.sysid,a.item_code,a.item_code_old,a.item_name1,a.mou_inventory,a.trademark,
                a.is_sales,a.is_purchase,a.is_production,a.is_material,
                a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as  manufactur,c.supplier_name,a.het_price,a.hna,on_hand,on_hand_unit,
                a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name,a.image_path,a.uuid_rec")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->where('a.inventory_group',$group_name);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('item_code', 'like', $filter);
                $q->orwhere('item_code_old', 'like', $filter);
                $q->orwhere('item_name1', 'like', $filter);
                $q->orwhere('trademark', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'-';
        $data=Inventory::where('uuid_rec',$uuidrec)->first();
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
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'-';
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        if ($group_name=='MEDICAL'){
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.uuid_rec,a.item_code,a.item_code_old,a.item_name1,a.item_name2,a.mou_inventory,a.product_line,
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
            ->where('a.uuid_rec',$uuidrec)->first();
        } else if ($group_name=='GENERAL'){
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.uuid_rec,a.item_code,a.item_code_old,a.item_name1,a.item_name2,a.mou_inventory,a.product_line,
                a.is_sales,a.is_purchase,a.item_group_sysid,a.manufactur_sysid,a.prefered_vendor_sysid,a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as manufactur,a.inventory_group,a.is_generic,c.supplier_name as supplier,a.cogs,
                a.on_hand,a.on_hand_unit,a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name,a.image_path")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->where('a.uuid_rec',$uuidrec)->first();
        } else if ($group_name=='NUTRITION'){
            $data=Inventory::from('m_items as a')
            ->selectRaw("a.uuid_rec,a.item_code,a.item_code_old,a.item_name1,a.item_name2,a.mou_inventory,a.product_line,
                a.is_sales,a.is_purchase,a.is_production,a.is_material,a.item_group_sysid,a.manufactur_sysid,a.prefered_vendor_sysid,a.is_active,a.update_userid,a.create_date,a.update_date,
                b.manufactur_name as manufactur,a.inventory_group,a.is_generic,c.supplier_name as supplier,a.cogs,
                a.on_hand,a.on_hand_unit,a.item_group_sysid,a.item_subgroup_sysid,d.group_name,e.group_name as subgroup_name,a.image_path")
            ->leftjoin("m_manufactur as b","a.manufactur_sysid","=","b.sysid")
            ->leftjoin("m_supplier as c","a.prefered_vendor_sysid","=","c.sysid")
            ->leftjoin("m_items_group as d","a.item_group_sysid","=","d.sysid")
            ->leftjoin("m_items_group as e","a.item_subgroup_sysid","=","e.sysid")
            ->where('a.uuid_rec',$uuidrec)->first();
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
            'item_code.required'=>'Kode inventory harus diisi',
            'item_name1.required'=>'Nama inventory harus diisi',
            'mou_inventory.required'=>'Satuan simpan harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Inventory();
                $data->inventory_group=$row['inventory_group'];
                $data->uuid_rec= Str::uuid();
            } else if ($opr=='updated'){
                $data = Inventory::where('uuid_rec',$row['uuid_rec'])->first();
                $data->uuid_rec= Str::uuid();
            }
            $data->item_code=$row['item_code'];
            $data->item_name1=$row['item_name1'];
            $data->item_name2=$row['item_name2'];
            $data->mou_inventory=$row['mou_inventory'];
            $data->is_price_rounded=isset($row['is_price_rounded']) ? $row['is_price_rounded'] :false;
            $data->price_rounded=isset($row['price_rounded']) ? $row['price_rounded'] :0;
            $data->manufactur_sysid=isset($row['manufactur_sysid']) ? $row['manufactur_sysid'] :-1;
            $data->prefered_vendor_sysid=isset($row['prefered_vendor_sysid']) ? $row['prefered_vendor_sysid'] :-1;
            $data->is_price_rounded=isset($row['is_price_rounded']) ? $row['is_price_rounded'] : false;
            $data->price_rounded=isset($row['price_rounded']) ? $row['price_rounded'] : false;
            $data->is_sales=isset($row['is_sales']) ? $row['is_sales'] : false;
            $data->is_purchase=isset($row['is_purchase']) ? $row['is_purchase'] : false;
            $data->is_material=isset($row['is_material']) ? $row['is_material'] : false;
            $data->is_production=isset($row['is_production']) ? $row['is_production'] : false;
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
            return response()->error('',501,$error);
        }    
    }
    public function download(Request $request)
    {
        $uuidrec = isset($request->uuidrec) ? $request->uuidrec :'-';
        $document=isset($request->document) ? $request->document :'';
        $data=Inventory::selectRaw("COALESCE(image_path,'') as image")->where('uuid_rec',$uuidrec)->first();
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

    public function get_item(Request $request){
        $item_code=isset($request->item_code) ? $request->item_code :'-';
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        $data=Inventory::from('m_items as a')
        ->selectRaw("a.sysid,a.item_code,a.item_code_old,a.item_name1,a.item_name2,IFNULL(a.mou_purchase,'') as mou_purchase,a.conversion,
            IFNULL(a.mou_inventory,'') as mou_inventory,a.product_line,
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
        ->where('a.item_code',$item_code)
        ->where('a.inventory_group',$group_name)->first();
        return response()->success('Success',$data);
    }
    
}
