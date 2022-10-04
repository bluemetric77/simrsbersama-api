<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kas/Bank{{$header->doc_number ?? ''}}</title>
    <link rel="stylesheet" href="{{public_path('/css/document.css')}}" type="text/css" media="all">
	<style>
		@page  {
			size: 210mm 148.5mm potrait;  // set appropriately
			margin: 5mm 5cm 5mm 5mm;
		}
		@media print {
			@page  {
				size: 210mm 148.5mm potrait;  // set appropriately
				margin: 5mm 5cm 5mm 5mm;
			}
		}

	</style>
</head>
<body>
<div style="font-size:1.0em;font-weight:bold">{{$profile->name}}</div>
<div style="text-align:center;font-size:1em;font-weight:bold">{{($type=='IN')?'BUKTI PENERIMAAN KAS/BANK':'BUKTI PENGELUARAN KAS/BANK'}}</div>
@if (isset($header->order))
	@php $order=$header->order; @endphp
@endif
<div class="header">
    <table class="none" width="55rem"> 
        <tr>
			<td width="4em">No.Pengajuan</td>
            <td width="20em">: {{isset($order) ? $order->expense_no:''}}</td>
			<td width="4em">Tanggal</td>
            <td>: {{$header->ref_date}}</td>
		</tr>
        <tr>
			<td>Kas/Bank</td>
            <td>: {{$header->cashbank_sname}}</td>
			<td>No.Dokumen</td>
            <td style="font-weight:bold">: {{$header->doc_number}}</td>
		</tr>
	</table>
</div>
<div class="content">
	<table class="content-table" width="60em">
		<thead>
			<tr>
				<th align="left">Keterangan</th>
				<th align="right" width="5em">Nominal</th>
			</tr>
		</thead>		
		<tbody>
    	    @php $total=0; $nomor=0; @endphp
			@foreach($detail as $line)
				@php
				$nomor++;
				@endphp
				<tr>
					<td>
						<div>{{$line->descriptions}}</div>
						@if (isset($order))
							<div>{{$order->partner_name}} - {{$order->order_no}} - {{$order->customer_no}}</div>
						@endif
					</td>
					<td align="right">{{number_format(ABS($line->amount),0,',','.')}}</td>
				</tr>
				@php
				$total = $total + abs($line->amount);
				@endphp
			@endforeach
			<tr>
				<td>
				  <span style="font-size:0.7em;font-style:italic">tgl input : {{$header->update_timestamp}}</span>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td style="font-weight: bold;border: 0.5px solid #333;">TOTAL</td>
				<td align="right" style="font-weight: bold;border: 0.5px solid #333;">{{number_format($total,0,',','.')}}</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="footer">
	@if($type=='IN')
		<table class="sign" width="60em"> 
			<tr>
				<th>Diserahkan</th>
				<th>Diotorisasi</th>
				<th>Diterima</th>
				<th>Diverifikasi</th>
				<th>Dijurnal</th>
			</tr>
			<tr>
				<td  height="5em">{{($type=='OUT') ?$header->user_name:''}}</td>
				<td></td>
				<td  height="5em">{{($type=='IN') ?$header->user_name:''}}</td>
				<td></td>
				<td></td>
			</tr>
		</table>	
	@else
		<table class="sign" width="60em"> 
			<tr>
				<th>Diserahkan</th>
				<th>Diotorisasi</th>
				<th>Diterima</th>
				<th>Diverifikasi</th>
				<th>Dijurnal</th>
			</tr>
			<tr>
				<td  height="5em">{{$header->user_name}}</td>
				<td></td>
				<td>{{isset($order) ? $order->driver_name:''}}</td>
				<td></td>
				<td></td>
			</tr>
		</table>	
	@endif 
</body>
</html>
