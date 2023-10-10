<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Config\Datalog;
use Illuminate\Support\Str;
use PagesHelp;

class HelpersDataLog {
   public static function create($sysid,$documentid,$doc_sysid,$doc_number,$model,$operation,$old,$new)
   {
        $created_by = isset($new['header']->create_by) ? $new['header']->create_by   : -1;
        $created_by = isset($new['header']->update_by) ? $new['header']->update_by  : $created_by;
        $uuid       = isset($new['header']->uuid_rec) ? $new['header']->uuid_rec     : '';
        $dt=new Datalog();
        $dt->record_date = Date('Y-m-d H:i:s');
        $dt->uuid_doc    = $uuid;
        $dt->doc_sysid   = $doc_sysid;
        $dt->doc_number  = $doc_number;
        $dt->documentid  = $documentid;
        $dt->operation   = $operation;
        $dt->model       = $model;
        $dt->old_value   = json_encode($old,JSON_PRETTY_PRINT);
        $dt->json_value  = json_encode($new,JSON_PRETTY_PRINT);
        $dt->created_by  = $created_by;
        $dt->uuid_rec   = Str::uuid();
        $dt->save();
   }
}
