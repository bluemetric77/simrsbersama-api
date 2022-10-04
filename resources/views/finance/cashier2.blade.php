<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kas/Bank{{$header->doc_number ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			margin: 1cm 1cm 1cm 1cm;
		}

	</style>
</head>
<body>
<div style="font-size:1.2rem;font-weight:bold">{{$profile->name}}</div>
<div style="text-align:center;font-size:1rem;font-weight:bold">{{($type=='IN')?'BUKTI PENERIMAAN KAS/BANK':'BUKTI PENGELUARAN KAS/BANK'}}</div>
@if (isset($header->order))
	@php $order=$header->order; @endphp
@endif
<div class="header">
    <table class="none" width="100%"> 
        <tr>
			<td width="4rem">No.Pengajuan</td>
            <td width="25rem">: {{isset($order) ? $order->expense_no:''}}</td>
			<td>Tanggal</td>
            <td>: {{$header->ref_date}}</td>
		</tr>
        <tr>
			<td width="4rem">Kas/Bank</td>
            <td>: {{$header->cashbank_sname}}</td>
			<td>No.Dokumen</td>
            <td>: {{$header->doc_number}}</td>
		</tr>
	</table>
</div>
<div class="content">
	<table class="content-table">
		<thead>
			<tr>
				<th align="left">Keterangan</th>
				<th align="right" width="5rem">Nominal</th>
			</tr>
		</thead>		
		<tbody>
			<tr>
				<td>
					{{$header->descriptions}}
					@if ($header->document_type=='DRO')
						<div>TUJUAN : {{$header->cashbank_dname}}</div>
					@elseif ($header->document_type=='RDO')
						<div>DITERIMA DARI : {{$header->cashbank_dname}}</div>
					@endif
				</td>
				<td align="right">{{number_format(ABS($header->amount),0,',','.')}}</td>
			</tr>
			<tr>
				<td>
				  <span style="font-size:0.7rem;font-style:italic">tgl input : {{$header->update_timestamp}}</span>
				</td>
				<td>

				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="footer">
	@if($type=='IN')
		<table class="sign"> 
			<tr>
				<th>Diserahkan</th>
				<th>Diotorisasi</th>
				<th>Diterima</th>
				<th>Diverifikasi</th>
				<th>Dijurnal</th>
			</tr>
			<tr>
				<td  height="5rem">{{($type=='OUT') ?$header->user_name:''}}</td>
				<td></td>
				<td  height="5rem">{{($type=='IN') ?$header->user_name:''}}</td>
				<td></td>
				<td></td>
			</tr>
		</table>	
	@else
		<table class="sign"> 
			<tr>
				<th>Diserahkan</th>
				<th>Diotorisasi</th>
				<th>Diterima</th>
				<th>Diverifikasi</th>
				<th>Dijurnal</th>
			</tr>
			<tr>
				<td  height="5rem">{{$header->user_name}}</td>
				<td></td>
				<td>{{isset($order) ? $order->driver_name:''}}</td>
				<td></td>
				<td></td>
			</tr>
		</table>	
	@endif 
</body>
</html>
