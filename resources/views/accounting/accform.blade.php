<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bukti Jurnal {{$header[0]->voucher ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			margin: 0.5cm 1cm 0.5cm 1cm;
		}
		.page-break {
			page-break-before: always;
		}
	</style>
</head>
<body>
<img src="/var/www/app-dmm.com/engine/storage/app/public/logo-print.png" height="40px">
<div style="text-align:center;font-size:16px;font-weight:bold">BUKTI JURNAL</div>
<div class="information" style="margin-top:10px;line-height:1.3em">
    <table width="100%"> 
        <tr>
			<td>Voucher</td>
            <td width="250px" style="font-weight:bold;font-size:14px">: 
				{{$header[0]->voucher}} 
			</td>
			<td>Tanggal</td>
            <td>: {{$header[0]->ref_date}}</td>
		</tr>
        <tr>
			<td>No. Referensi 1</td>
            <td>: {{$header[0]->reference1}}</td>
			<td>No. Referensi 2</td>
            <td>: {{$header[0]->reference2}}</td>
		</tr>
        <tr>
			<td>Posting</td>
            <td>: {{$header[0]->posting_date}}</td>
			<td>User</td>
            <td>: {{$header[0]->user_name}} </td>
        </tr>
	</table>
</div>
<div class="invoice" style="margin-left:0px">
	<table class="table-detail" style="font-size:12px">
		<thead>
			<tr>
				<th width="70px">No. Akun</th>
				<th width="150px">Nama Akun</th>
				<th width="300px">Keterangan</th>
				<th width="80px">Debet</th>
				<th width="80px">Kredit</th>
			</tr>
		</thead>		
		<tbody>
    	    @php $debit=0; $credit=0 @endphp
			@foreach($header as $line)
		    <tr  style="font-size:11px;vertical-align:top">
				<td>{{$line->no_account}}</td>
				<td>{{$line->description}}</td>
				<td>{{$line->line_memo}}</td>
				<td align="right">{{number_format($line->debit,2,',','.')}}</td>
				<td align="right">{{number_format($line->credit,2,',','.')}}</td>
			</tr>
			@php
			$debit = $debit + $line->debit;
			$credit = $credit + $line->credit;
			@endphp
			@endforeach
			<tr  style="font-size:12px;font-weight:bold">
				<td colspan="3">TOTAL</td>
				<td align="right">{{number_format($debit,2,',','.')}}</td>
				<td align="right">{{number_format($credit,2,',','.')}}</td>
			</tr>
		</tbody>
	</table>
</div>	
<div class="information" style="margin-top:10px;line-height:1.3em">
	<table class="table-sign" style="font-size:12px">
		<tr style="text-align:center;vertical-align:center"> 
			<td width="200px">Dibuat oleh</td>
			<td width="200px">Disetujui oleh</td>
			<td width="200px">Diverifikasi oleh</td>
		</tr>
		<tr style="text-align:center;vertical-align:bottom;"> 
			<td height="60px">{{$header[0]->user_name}}</td>
			<td></td>
			<td></td>
		</tr>
		<tr style="text-align:center;vertical-align:bottom;font-size:8px"> 
			<td>Tgl/Jam :{{$header[0]->update_timestamp}}</td>
			<td>Tgl/Jam :</td>
			<td>Tgl/Jam :</td>
		</tr>
	</table>
</div>
<div style="position: absolute; bottom: -30;padding-bottom:12px">
	<div style="font-size:12px">dokumen dicetak : {{Date('d-m-Y H:i:s')}}</div>
	<table width="100%">
		<tr style="font-size:12px">
			<td align="left" style="width: 50%;">
				&copy; {{ date('Y') }} {{ config('app.url') }}
			</td>
			<td align="right" style="width:50%;">
				{{$profile->name}}
			</td>
		</tr>
	</table>
</div>
</body>
</html>
