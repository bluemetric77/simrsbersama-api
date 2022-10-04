<?php

namespace App\Http\Controllers\Finance;

use App\Models\Operation\FleetOrder;
use App\Models\Operation\FleetExpense1;
use App\Models\Operation\FleetExpense2;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use Accounting;
use PDF;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UJOController extends Controller
{
    public function show(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';
        $pool_code = isset($request->pool_code) ? $request->pool_code:'ALL';

        $data=FleetExpense1::from('t_fleet_expense1 as a')
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.standart,a.other_expense,a.dp_customer,a.total,a.cashier,a.dp_method,a.cash_amount,
                  b.origins,b.destination,b.work_order_no,b.driver_name,b.vehicle_no,b.police_no,
                  a.pool_code,a.project_id,a.is_canceled,a.is_closed,a.fleet_orderid")
        ->join("t_fleet_order as b","a.fleet_orderid","=","b.transid")
        ->where("a.ref_date",">=",$date1)
        ->where("a.ref_date","<=",$date2);
        if (!($pool_code=='ALL')) {
            $data=$data->where("a.pool_code",$pool_code);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('b.driver_name', 'like', $filter);
                $q->orwhere('b.origins', 'like', $filter);
                $q->orwhere('b.destination', 'like', $filter);
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
