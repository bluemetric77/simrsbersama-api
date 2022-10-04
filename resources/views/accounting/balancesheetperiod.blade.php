<html>
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no">
    <title>{{$header['title']}}</title>
    <link rel="stylesheet" href="{{public_path('css/document.css')}}" type="text/css" media="all">
	<style type="text/css">
		table, th {
			border: 0.5px solid black;
			border-collapse: collapse;
		}

		table, tr,td {
			padding-left: 5px;
			padding-right: 5px;
		}

		table.center {
			margin-left: auto; 
			margin-right: auto;
		}
		
		.page-break {
			page-break-before: always;
		}
	</style>

</head>
<body>
	<center>
		<h4 class="caption">{{$header['title']}}</h4>
		<h4>{{$header['period']}}</h4>
	</center>
	<br/>
	<table class="center" cellpadding="2" cellspacing="0">
		<tr>
			<th>Nama Perkiraan</th>
			<th>{{$header['period']}}</th>
			<th>s/d {{$header['period']}}</th>
		</tr>
		<tbody>
			@php 
			  $total1=0; $total2=0 ; $saldo1=0; $saldo2=0 ; $name='';$printed=false;
			@endphp
			@foreach($activa as $p)
				@if(($printed==true) and ($p->level_account==2))
					<tr>
						<td style="width: 400px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
						<td align="right"><strong>{{number_format(floatval($saldo1),2,',','.')}}</strong></td>
						<td align="right"><strong>{{number_format(floatval($saldo2),2,',','.')}}</strong></td>
					</tr>
					@php $printed=false @endphp
				@endif
				@php
					if ($p->level_account=='2') {
						$name = $p->account_name;
						$saldo1 = 0;
						$saldo2 = 0;
						$printed = true;
					} else if ($p->level_account>'2') {
						$saldo1 = $saldo1 + floatval($p->reversed1);
						$saldo2 = $saldo2 + floatval($p->reversed2);
					}
				@endphp
				<tr>
					@if($p->level_account =='1')         
						<td style="width: 600px" colspan="3"><strong>{{$p->account_name}}<strong></td>
					@elseif ($p->level_account =='2')         
						<td style="padding-left: 1em" colspan="3"><strong>{{$p->account_name}}<strong></td>
					@else
						<td style="padding-left: 1.5em">- {{$p->account_name}}</td>
						@if	(floatval($p->reversed1)>=0){
							<td align="right">{{number_format(floatval($p->reversed1),2,',','.')}}</td>
						@else
							<td align="right" style="color:red">{{number_format(floatval($p->reversed1),2,',','.')}}</td>
						@endif

						@if	(floatval($p->reversed2)>=0){
							<td align="right">{{number_format(floatval($p->reversed2),2,',','.')}}</td>
						@else
							<td align="right" style="color:red">{{number_format(floatval($p->reversed2),2,',','.')}}</td>
						@endif
					@endif
				</tr>
				@php 
				  $total1 = $total1 + floatval($p->reversed1);
				  $total2 = $total2 + floatval($p->reversed2);
				@endphp
			@endforeach
			<tr>
				<td style="width: 400px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
				<td align="right"><strong>{{number_format(floatval($saldo1),2,',','.')}}</strong></td>
				<td align="right"><strong>{{number_format(floatval($saldo2),2,',','.')}}</strong></td>
			</tr>
			<tr>
				<td style="width: 400px"><strong>TOTAL AKTIVA<strong></td>
				<td align="right"><strong>{{number_format(floatval($total1),2,',','.')}}</strong></td>
				<td align="right"><strong>{{number_format(floatval($total2),2,',','.')}}</strong></td>
			</tr>

			@php 
			  $total1=0; $total2=0; $saldo1=0; $saldo2=0; $name='';$printed=false;
			@endphp
			@foreach($passiva as $p)
				@if(($printed==true) and ($p->level_account==2))
					<tr>
						<td style="width: 500px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
						<td align="right"><strong>{{number_format(floatval($saldo1),2,',','.')}}</strong></td>
						<td align="right"><strong>{{number_format(floatval($saldo2),2,',','.')}}</strong></td>
					</tr>
					@php $printed=false @endphp
				@endif
				@php
					if ($p->level_account=='2') {
						$name = $p->account_name;
						$saldo1 = 0;
						$saldo2 = 0;
						$printed = true;
					} else if ($p->level_account>'2') {
						$saldo1 = $saldo1 + floatval($p->reversed1);
						$saldo2 = $saldo2 + floatval($p->reversed2);
					}
				@endphp
				<tr>
					@if($p->level_account =='1')         
						<td style="width: 500px" colspan="3"><strong>{{$p->account_name}}<strong></td>
					@elseif ($p->level_account =='2')         
						<td style="padding-left: 1em" colspan="3"><strong>{{$p->account_name}}<strong></td>
					@else
						<td style="padding-left: 1.5em">- {{$p->account_name}}</td>
						@if	(floatval($p->reversed1)>=0){
							<td align="right">{{number_format(floatval($p->reversed1),2,',','.')}}</td>
						@else
							<td align="right" style="color:red">{{number_format(floatval($p->reversed1),2,',','.')}}</td>
						@endif

						@if	(floatval($p->reversed2)>=0){
							<td align="right">{{number_format(floatval($p->reversed2),2,',','.')}}</td>
						@else
							<td align="right" style="color:red">{{number_format(floatval($p->reversed2),2,',','.')}}</td>
						@endif
					@endif
				</tr>
				@php 
				  $total1 = $total1 + floatval($p->reversed1);
				  $total2 = $total2 + floatval($p->reversed2);
				@endphp
			@endforeach
			<tr>
				<td style="width: 400px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
				<td align="right"><strong>{{number_format(floatval($saldo1),2,',','.')}}</strong></td>
				<td align="right"><strong>{{number_format(floatval($saldo2),2,',','.')}}</strong></td>
			</tr>
			<tr>
				<td style="width: 400px"><strong>TOTAL PASSIVA<strong></td>
				<td align="right"><strong>{{number_format(floatval($total1),2,',','.')}}</strong></td>
				<td align="right"><strong>{{number_format(floatval($total2),2,',','.')}}</strong></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
