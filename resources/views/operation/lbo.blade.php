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
<span style="font-weight:bold;font-size:1.0em;margin-left:35em">{{$header->fleet_order_no}}</span>
<div style="text-align:center;font-size:1.1em;font-weight:bold">PENGAJUAN BIAYA OPERASIONAL</div>
<div class="information" style="margin-top:2em;line-height:1.4em">
    <table width="100%"> 
        <tr>
			<td>No.Reservasi</td>
            <td width="20em" style="font-weight:bold;font-size:1.2em">: 
				{{$header->order_no}} - {{$header->customer_no}} 
			</td>
			<td>Tanggal</td>
            <td>: {{$header->ref_date}}</td>
		</tr>
        <tr>
			<td>Konsumen</td>
            <td width="20em" style="font-weight:bold;font-size:1.2em">: 
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
			<td>SIM</td>
            <td>: {{$header->driving_license_no}} - {{$header->driving_license_valid}} </td>
        </tr>
	</table>
</div>
<div class="information" style="margin-left:0px">
	<table style="font-size:1.0em">
		<tbody>
			<tr>
				<td colspan="3"><hr style="height:1px;border-width:0;color:gray;background-color:black"/></td>
			</tr>
			<tr>
				<td width="5em">No</td>
				<td width="33em">Keterangan</td>
				<td width="20em" align="right">Biaya</td>
			</tr>
			<tr>
				<td colspan="3"><hr style="height:1px;border-width:0;color:gray;background-color:black"/></td>
			</tr>
    	    @php $total=0; $nomor=0; @endphp
			@foreach($detail as $line)
				@php
				$nomor++;
				@endphp
				<tr  style="font-size:1.0em;text-align:left;vertical-align:top">
					<td align="center">{{$nomor}}</td>
					<td>{{$line->descriptions}}</td>
					<td align="right">{{number_format($line->expense_budget,0,',','.')}}</td>
				</tr>
				@php
				$total = $total + $line->expense_budget;
				@endphp
			@endforeach
			<tr>
				<td colspan="3"><hr style="height:1px;border-width:0;color:gray;background-color:black"/></td>
			</tr>
			<tr  style="font-size:1.1em;font-weight:bold">
				<td colspan="2">TOTAL</td>
				<td align="right">{{number_format($total,0,',','.')}}</td>
			</tr>
			<tr  style="font-size:1.1em;font-weight:bold">
				<td colspan="2">DP UJO {{$header->dp_method}}</td>
				<td align="right">{{number_format($header->dp_customer,0,',','.')}}</td>
			</tr>
			<tr  style="font-size:1.1em;font-weight:bold">
				<td colspan="2">TOTAL YANG DIAJUKAN</td>
				<td align="right">{{number_format($header->total,0,',','.')}}</td>
			</tr>
		</tbody>
	</table>
</div>	
<div class="information" style="margin-top:2em;line-height:1.2em">
    <table width="100%"> 
        <tr style="text-align:center;vertical-align:center;"">
			<td width="35%">Disetujui</td>
            <td width="35%">Dibuat Oleh</td>
			<td width="30%">Pengemudi</td>
		</tr>
        <tr style="text-align:center;vertical-align:bottom;font-size:1.0em">
			<td height="5em">(...............................)</td>
            <td>{{$header->user_name}}</td>
			<td>{{$header->driver_name}}</td>
		</tr>
	</table>	
</body>
</html>
