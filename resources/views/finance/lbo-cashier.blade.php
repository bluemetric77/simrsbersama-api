<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Biaya Operasional {{$header->doc_number ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			size: 210mm 148.5; // set appropriately
			margin: 0.5cm 1cm 0.5cm 1cm;
		}
		@media print {
			html, body {
				width: 210mm; // set appropriately
				height: 148.5mm; // set appropriately
			}
		}
	</style>
</head>
<body>
<img src="/var/www/app-dmm.com/engine/storage/app/public/logo-print.png" height="40px">
<div style="text-align:center;font-size:16px;font-weight:bold">KASIR BIAYA OPERASIONAL</div>
<div class="information" style="margin-top:10px;line-height:1.3em">
    <table width="100%"> 
        <tr>
			<td>No.Dokumen</td>
            <td width="320px" style="font-weight:bold;font-size:14px">: 
				{{$header->voucher}} 
			</td>
			<td>Tanggal</td>
            <td>: {{$header->ref_date}}</td>
		</tr>
        <tr>
			<td>Konsumen</td>
            <td width="320px" style="font-weight:bold;font-size:14px">: 
				@if ($header->partner_id=='2103') 
					C.O.D - {{$header->customer_name}} 
				@else
					{{$header->partner_name}} 
				@endif	
			</td>
			<td>Mobil/Unit</td>
            <td>: {{$header->police_no}} - {{$header->vehicle_no}} - {{$header->vehicle_group}}</td>
		</tr>
        <tr>
			<td>Asal/Gudang</td>
            <td>: {{$header->origins}} ({{$header->warehouse}})</td>
			<td>Pengemudi</td>
            <td>: {{$header->driver_name}} </td>
        </tr>
        <tr>
			<td>Tujuan</td>
            <td>: {{$header->destination}} </td>
			<td>DO/SI</td>
            <td>: {{$header->customer_no}} </td>
        </tr>
        <tr>
			<td>Surat Muatan</td>
            <td>: {{$header->work_order_no}} </td>
			<td>Kas/Bank</td>
            <td>: {{$header->account_name}} </td>
        </tr>
	</table>
</div>
<div style="margin-left:0px">
	<table class="table-detail" style="font-size:12px">
		<thead>
			<tr>
				<th width="30px">No</th>
				<th width="450px">Keterangan</th>
				<th width="200px">Biaya</th>
			</tr>
		</thead>		
		<tbody>
    	    @php $total=0; $nomor=0; @endphp
			@foreach($detail as $line)
				@php
				$nomor++;
				@endphp
				<tr  style="font-size:12px;text-align:left;vertical-align:top">
					<td align="center">{{$nomor}}</td>
					<td>{{$line->descriptions}}</td>
					<td align="right">{{number_format($line->expense,0,',','.')}}</td>
				</tr>
				@php
				$total = $total + $line->expense;
				@endphp
			@endforeach
			<tr  style="font-size:12px;font-weight:bold">
				<td colspan="2">JUMLAH BIAYA</td>
				<td align="right">{{number_format($header->total,0,',','.')}}</td>
			</tr>
			<tr  style="font-size:12px;font-weight:bold">
				<td colspan="2">Biaya Administrasi</td>
				<td align="right">{{number_format($header->adm_fee,0,',','.')}}</td>
			</tr>
			<tr  style="font-size:12px;font-weight:bold">
				<td colspan="2">TOTAL</td>
				<td align="right">{{number_format($header->total,0,',','.')}}</td>
			</tr>
		</tbody>
	</table>
</div>	
<div class="information" style="margin-top:10px;line-height:1.3em">
    <table width="100%" class="table-sign"> 
        <tr>
			<th>Disetujui</th>
            <th>Dibuat Oleh</th>
			<th>Pengemudi</th>
		</tr>
        <tr style="text-align:center;vertical-align:bottom;font-size:11px">
			<td height="80px"></td>
            <td>{{$header->user_name}}</td>
			<td>{{$header->driver_name}}</td>
		</tr>
        <tr style="text-align:center;vertical-align:bottom;font-size:11px">
			<td></td>
            <td>{{$header->update_timestamp}}</td>
			<td></td>
		</tr>
	</table>	
</body>
</html>
