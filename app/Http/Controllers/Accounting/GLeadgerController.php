<?php

namespace App\Http\Controllers\Accounting;

use App\Models\Accounting\Journal1;
use App\Models\Accounting\Journal2;
use App\Models\Master\COA;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PagesHelp;
use Accounting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PDF;

class GLeadgerController extends Controller
{
    public function show(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $start_date = isset($request->start_date) ? $request->start_date:'1899-12-31';
        $end_date = isset($request->end_date) ? $request->end_date:'1899-12-31';
        $trans_code = isset($request->trans_code) ? $request->trans_code:'ALL';
        $transtype = isset($request->transtype) ? $request->transtype:'-1';
        $vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type:'ALL';
        $data= Journal1::from('t_jurnal1 as a')
        ->selectRaw("a.transid,a.ref_date,a.reference1,a.reference2,CONCAT(a.trans_code,'-',a.trans_series) as voucher,
        a.debit,a.credit,a.notes,IFNULL(a.is_void,0) as is_void,IFNULL(a.is_verified,0) as is_verified,a.verified_date") 
        ->where('a.ref_date', '>=', $start_date)
        ->where('a.ref_date', '<=', $end_date);
        if (!($trans_code=='ALL')) {
            $data=$data->where('trans_code',$trans_code);
        }
        if (!($transtype=='-1')) {
            $data=$data->where('transtype',$transtype);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.trans_code', 'like', $filter)
                    ->orwhere('a.trans_series', 'like', $filter)
                    ->orwhere('a.reference1', 'like', $filter)
                    ->orwhere('a.reference2', 'like', $filter);
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

    public function inquery(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $jurnaltype=isset($request->jurnaltype) ? intval($request->jurnaltype) : -99;
        $data= Journal1::from('t_jurnal1 as a')
        ->selectRaw("a.transid as _index,a.transid,a.pool_code,a.ref_date,a.reference1,a.reference2,a.trans_code,a.trans_series,
                     a.debit,a.credit,a.notes,a.is_void,a.is_verified,a.verified_date") 
        ->where('a.ref_date', '>=', $start_date)
        ->where('a.ref_date', '<=', $end_date);
        if ($jurnaltype!=-1){
            $data=$data->where('a.transtype',$jurnaltype);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.trans_code', 'like', $filter)
                    ->orwhere('a.trans_series', 'like', $filter)
                    ->orwhere('a.reference1', 'like', $filter)
                    ->orwhere('a.reference2', 'like', $filter);
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

    public function destroy(Request $request)
    {
        $id = $request->transid;
    }
    
  
    public function get(Request $request)
    {
        $id = $request->transid;
        $header = Journal1::selectRaw("transid,ref_date,reference1,reference2,trans_code,trans_series,
        fiscal_year,fiscal_month,debit,credit,notes,transtype,is_posted,is_void,IFNULL(is_verified,0) as is_verified")
        ->where('transid', $id)->first();
        $data['header']=$header;
        if ($header) {
            $data['detail']=Journal2::selectRaw("transid,line_no,no_account,description,
                line_memo,debit,credit,reference1,reference2")
                ->where('transid',$id)
                ->get();
        }
        return response()->success('Success', $data);
    }
    public function post(Request $request)
    {
        $data = $request->json()->all();
        $opr = $data['operation'];
        $where = $data['where'];
        $header = $data['header'];
        $detail = $data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required',
            'trans_code'=>'bail|required',
            'transtype'=>'bail|required'
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'trans_code.required'=>'Voucher harus diisi',
            'transtype.required'=>'Tipe jurnal harus diisi'
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        
        $validator=Validator::make($detail,[
            '*.no_account'=>'bail|required|exists:m_account,account_no',
        ],[
            '*.no_account.required'=>'Kode barang harus diisi',
            '*.no_account.exists'=>'No.Akun [ :input ] tidak ditemukan dimaster akun',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        $debit=0;
        $credit=0;
        foreach($detail as $row){
            $debit=$debit + floatval($row['debit']);
            $credit=$credit + floatval($row['credit']);
        }
        if (!($debit==$credit)){
            return response()->error('',501,'Debit & Kredit belum balance/sama');
        }
        $transid = $header['transid'];
        DB::beginTransaction();
        try {
            $realdate = date_create($header['ref_date']);
		    $year_period = date_format($realdate, 'Y');
            $month_period = date_format($realdate, 'm');

            $header['update_userid'] = PagesHelp::UserID($request);
            $header['posting_date'] =new \DateTime();
            $header['update_timestamp'] =new \DateTime();
            $header['fiscal_month'] =$month_period;
            $header['fiscal_year'] =$year_period;
            $transid=$header['transid'];
            unset($header['transid']);
            if ($opr == 'updated') {
                Accounting::rollback($transid);    
                Journal1::where($where)->update($header);
            } else if ($opr = 'inserted') {
                $header['trans_series'] = Journal1::GenerateNumber($header['trans_code'],$header['ref_date']);
                $header['transtype']    = 0;
                $header['transid']=Journal1::max('transid')+1;
                $transid = $header['transid'];
                journal1::insert($header);
            }
            foreach($detail as $row){
                $dtl=(array)$row;
                $dtl['transid']=$transid;
                Journal2::insert([
                    'transid'=>$transid,
                    'line_no'=>$row['line_no'],
                    'no_account'=>$row['no_account'],
                    'control_account'=>$row['no_account'],
                    'sortname'=>isset($row['sortname']) ? $row['sortname'] :'',
                    'line_memo'=>$row['line_memo'],
                    'debit'=>$row['debit'],
                    'credit'=>$row['credit'],
                    'ref_date'=>$header['ref_date'],
                    'due_date'=>$header['ref_date'],
                    'reference1'=>$row['reference1'],
                    'reference2'=>$row['reference2']
                ]);
            }
            $info=Accounting::Posting($transid);  
            if ($info['state']==true){
                DB::commit();
                return response()->success('Success', 'Simpan data Berhasil');
            } else {
                DB::rollback();
                return response()->error('', 501, $info['message']);
            }
            DB::commit();
            return response()->success('Success', 'Simpan data Berhasil');
        } catch (Exception $e) {
            DB::rollback();
            return response()->error('', 501, $e);
        }
    }
    public function cancel(Request $request)
    {
        $userid = PagesHelp::UserID($request);
        $data = $request->json()->all();
        $where = $data['where'];
        $rec = $data['data'];

        $validator = Validator::make($rec, [
            'notes' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->error('', 501, $validator->errors()->all());
        }
        $data = CustomerOrder::from('t_customer_order as a')
            ->select('a.is_transactionlink', 'a.order_no', 'b.work_order_no')
            ->leftJoin('t_fleet_order as b', 'a.order_no', '=', 'b.order_no')
            ->where('a.transid', $where['transid'])
            ->first();
        if ($data->is_transactionlink == 1) {
            return response()->error('', 501, 'Order ' . $data->order_no . ' sudah diproses dengan nomor SPJ ' . $data->work_order_no);
        }
        DB::beginTransaction();
        try {
            CustomerOrder::where($where)
                ->update([
                    'cancel_note' => $rec['notes'],
                    'cancel_userid' => $userid,
                    'order_status' => 'Cancel',
                    'cancel_date' => date('Y-m-d H:i:s')
                ]);
            DB::commit();
            return response()->success('Success', 'Order berhasil dibatalkan');
        } catch (Exception $e) {
            DB::rollback();
            return response()->error('', 501, $e);
        }
    }
    public function print(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $header=Journal1::from('t_jurnal1 as a')
            ->selectRaw("a.transid,a.ref_date,a.reference1,a.reference2,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,a.notes,a.is_void,a.ref_date_void,
                        a.posting_date,a.update_timestamp,
                        b.line_no,b.no_account,b.description,b.line_memo,b.debit,b.credit,a.transtype,c.descriptions,d.user_name")
            ->leftjoin('t_jurnal2 as b','a.transid','=','b.transid')            
            ->leftjoin('m_jurnal_type as c','a.transtype','=','c.jurnal_type')            
            ->leftjoin('o_users as d','a.update_userid','=','d.user_id')            
            ->where('a.transid',$sysid)
            ->orderby('a.transid','asc')
            ->orderby('b.line_no','asc')
            ->get();
        if (!$header->isEmpty()) {
            $header[0]->ref_date=date_format(date_create($header[0]->ref_date),'d-m-Y');
            $header[0]->posting_date=date_format(date_create($header[0]->posting_date),'d-m-Y');
            $header[0]->update_timestamp=date('d-m-Y H:i',strtotime($header[0]->update_timestamp));
            //$header[0]->update_timestamp=date_format(date_create_from_format('Y-m-d H:i:s',$header[0]->update_timestamp),'d-m-Y H:i');
            $profile=PagesHelp::Profile();
            $pdf = PDF::loadView('accounting.accform',['header'=>$header,
                 'profile'=>$profile])->setPaper(array(0, 0, 612,486),'portrait');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }
    public function inqueryxls(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $jurnaltype=isset($request->jurnaltype) ? $request->jurnaltype : -99;
        $data= Journal1::from('t_jurnal1 as a')
        ->selectRaw("a.transid as _index,a.transid,a.pool_code,a.ref_date,a.reference1,a.reference2,a.trans_code,a.trans_series,
                     a.debit,a.credit,a.notes,a.is_void,a.is_verified,a.verified_date") 
        ->where('a.ref_date', '>=', $start_date)
        ->where('a.ref_date', '<=', $end_date);
        if ($jurnaltype==0){
            $data=$data->where('a.transtype',$jurnaltype);
        }
        $data=$data->orderBy('ref_date','asc')
        ->orderBy('transid','asc')
        ->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(0);
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $sheet->setCellValue('A1', 'INQUERY JURNAL');
        $sheet->setCellValue('A2', 'PERIODE');
        $sheet->setCellValue('B2', ': '.date_format(date_create($start_date),"d-m-Y").' s/d '.date_format(date_create($end_date),"d-m-Y"));

        $sheet->getStyle('A5:A5')->getAlignment()->setHorizontal('center');
        $idx=5;
        foreach($data as $row){
            $idx=$idx+1;
            $line=$idx;
            $sheet->setCellValue('A'.$line,"POOL");
            $sheet->setCellValue('B'.$line, ": ".$row['pool_code']);
            $sheet->setCellValue('A'.strval($line+1),"VOUCHER");
            $sheet->setCellValue('B'.strval($line+1), ": ".$row['trans_code'].'-'.$row['trans_series']);
            $sheet->setCellValue('A'.strval($line+2),"Tanggal");
            $sheet->setCellValue('B'.strval($line+2), $row['ref_date']);

            $sheet->setCellValue('E'.$line,"Referensi 1");
            $sheet->setCellValue('F'.$line, ": ".$row['reference1']);
            $sheet->setCellValue('E'.strval($line+1),"Referensi 2");
            $sheet->setCellValue('F'.strval($line+1), ": ".$row['reference1']);
            $sheet->setCellValue('E'.strval($line+2),"Void");
            $sheet->setCellValue('F'.strval($line+2), ": ".$row['is_void']);
            $idx=$line+3;
            $awal=$idx;
            $sheet->setCellValue('A'.$idx,'No');
            $sheet->setCellValue('B'.$idx,'No.Akun');
            $sheet->setCellValue('C'.$idx,'Nama Akun');
            $sheet->setCellValue('D'.$idx,'Keterangan');
            $sheet->setCellValue('E'.$idx,'Proyek');
            $sheet->setCellValue('F'.$idx,'Debit');
            $sheet->setCellValue('G'.$idx,'Kredit');
            $detail=Journal2::where('transid',$row['_index'])->get();
            foreach($detail as $dtl){
                $idx=$idx+1;
                $sheet->setCellValue('A'.$idx,$dtl->line_no);
                $sheet->setCellValue('B'.$idx,$dtl->no_account);
                $sheet->setCellValue('C'.$idx,$dtl->description);
                $sheet->setCellValue('D'.$idx,$dtl->line_memo);
                $sheet->setCellValue('E'.$idx,$dtl->project);
                $sheet->setCellValue('F'.$idx,$dtl->debit);
                $sheet->setCellValue('G'.$idx,$dtl->credit);
            }
            $sheet->getStyle('F'.strval($awal+1).':G'.$idx)->getNumberFormat()->setFormatCode('#,##0.#0;[RED](#,##0.#0)');
            $akhir=$idx;
            $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ];
            $sheet->getStyle('A'.$awal.':G'.$akhir)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$awal.':D'.$akhir)->getAlignment()->setWrapText(true); 
            $sheet->getStyle('A'.$awal.':G'.$akhir)->getAlignment()->setVertical('top');
            $styleArray = [
                        'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => [
                                    'argb' => 'FFA0A0A0',
                                ]
                            ],            
                    ];
            $sheet->getStyle('A'.$awal.':G'.$awal)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$awal.':E'.$akhir)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('B'.strval($awal-1).':B'.strval($awal-1))->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $idx=$idx + 1;
        }
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(40);
        ob_end_clean();
        $response = response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->setPreCalculateFormulas(true);
            $writer->save('php://output');
        });
        $xls="inquery_".$start_date.'_'.$end_date.".xlsx";
        PagesHelp::Response($response,$xls)->send();
    }
}
