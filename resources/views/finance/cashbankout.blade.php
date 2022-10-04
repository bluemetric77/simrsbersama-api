<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Biaya Operasional {{$header->doc_number ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			margin: 0.5cm 1cm 0.5cm 1cm;
		}

	</style>
</head>
<body>
<img src="/var/www/app-dmm.com/engine/storage/app/public/logo-print.png" height="40px">
<div style="text-align:center;font-size:16px;font-weight:bold">BUKTI PENGELUARAN KAS/BANK</div>
<div class="information" style="margin-top:10px;line-height:1.3em">
    <table width="100%"> 
        <tr>
			<td>No. Pengajuan</td>
            <td width="320px" style="font-weight:bold;font-size:14px">: 
			</td>
			<td>Tanggal</td>
            <td>: {{$header->ref_date}}</td>
		</tr>
        <tr>
			<td>Kas/Bank</td>
            <td width="320px" style="font-weight:bold;font-size:14px">: 
				{{$header->cash_bank_name}}
			</td>
			<td>Voucher</td>
            <td>: {{$header->doc_number}}</td>
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
