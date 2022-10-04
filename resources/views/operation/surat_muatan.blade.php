<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surat Muatan {{$header->work_order_no ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			margin: 0.5cm 0.5cm 0.5cm 0.5cm;
		}

	</style>
</head>
<body>
<div class="header">
    <table class="none"> 
        <tr>
			<td width="45em">
				<!--<img src="/var/www/html/project/dmmapp/api/storage/app/public/logo-print.png" height="100px">-->
				<img src="/var/www/app-dmm.com/engine/storage/app/public/logo-print.png" height="100px">
				<div>Jl. Alternatif Cibubur Kav DDN Harjamukti</div>
				<div>Cimanggis - Depok 16354</div>
            </td>
            <td>
				<div style="font-weight:bold;font-size:1.2rem">Pool</div>
				<div>Telepon : 021 - 8833-7526</div>
				<div>Fax     : 021 - 8833-7522</div>
				<div>Jl.Raya Teuku Umar Km 44</div>
				<div>Cibitung Bekasi</div>
            </td>
        </tr>
        <tr>
			<td colspan="2" style="text-align:center;font-weight:bold;font-size:1.2rem;text-align:center">
				<div>S U R A T  J A L A N</div>
				<div>{{$header->work_order_no}}</div>
            </td>
        </tr>
	</table>
</div>
<div class="header">
    <table class="none"> 
        <tr>
			<td width="3rem">Konsumen</td>
            <td width="16rem" style="font-weight:bold;font-size:1.0rem">: 
				@if ($header->partner_id=='2103') 
					C.O.D - {{$header->customer_name}} 
				@else
					{{$header->partner_name}} 
				@endif	
			</td>
			<td width="4rem">Tanggal</td>
            <td width="9rem">: {{$header->ref_date}} </td>
			<td>DIKIRIM KEPADA</td>
		</tr>
        <tr>
			<td>Gudang</td>
            <td>: {{$header->warehouse}} </td>
			<td>Kegiatan</td>
            <td>: {{$header->work_order_type}} </td>
            <td>Yth :</td>
        </tr>
        <tr>
			<td>DO/SI</td>
            <td>: {{$header->customer_no}} </td>
			<td>Tipe</td>
            <td>: {{$header->work_type}} </td>
        </tr>
        <tr>
			<td>Asal</td>
            <td>: {{$header->origins}} </td>
			<td>Tujuan</td>
            <td>: {{$header->destination}} </td>
        </tr>
        <tr>
			<td>Pengemudi</td>
            <td>: {{$header->personal_name}} </td>
			<td>No. Polisi</td>
            <td>: {{$header->police_no}}</td>
        </tr>
        <tr>
			<td>No.Telepon</td>
            <td>: {{$header->phone1}} / {{$header->phone2}}</td>
        </tr>
	</table>
</div>
<div class="content">
    <table class="sign"> 
		<thead>
			<tr>
				<th rowspan="2">Merk/No</th>
				<th rowspan="2">Jenis Barang</th>
				<th colspan="3">Jumlah Barang</th>
				<th rowspan="2">Keteranggan</th>
			</tr>
			<tr>
				<th>Coolly</th>
				<th>Pallet</th>
				<th>Tonase</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td height="4rem"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>	
<div class="footer">
    <table class="sign"> 
        <tr>
			<td width="25%">Pemuat</td>
			<td width="25%">Penerima</td>
            <td width="25%">Pengemudi/Truk</td>
			<td width="25%">Petugas</td>
		</tr>
        <tr>
			<td height="4rem"></td>
			<td></td>
            <td>{{$header->personal_name}}</td>
			<td></td>
		</tr>
        <tr>
			<td>Nama&Stample Perusahaan</td>
			<td>Nama&Stample Perusahaan</td>
            <td>Nama Pengemudi</td>
			<td>Nama/Stample</td>
		</tr>
	</table>	
</body>
</html>
