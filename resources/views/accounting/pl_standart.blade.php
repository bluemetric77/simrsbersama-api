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
		table, tr td {
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
		</tr>
		<tbody>
			@php 
			  $total=0; $saldo=0; $name='';$printed=false;
			@endphp
			@foreach($profitloss as $p)
				@if(($printed==true) and ($p->level_account==2))
					<tr>
						<td style="width: 400px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
						<td align="right"><strong>{{$saldo}}</strong></td>
					</tr>
					@php $printed=false @endphp
				@endif
				@php
					if ($p->level_account=='2') {
						$name = $p->account_name;
						$saldo = 0;
						$printed = true;
					} else if ($p->level_account>'2') {
						$saldo = $saldo + floatval($p->reversed1);
					}
				@endphp
				<tr>
					@if($p->level_account =='1')         
						<td style="width: 500px" colspan="2"><strong>{{$p->account_name}}<strong></td>
					@elseif ($p->level_account =='2')         
						<td style="padding-left: 1em" colspan="2"><strong>{{$p->account_name}}<strong></td>
					@else
						<td style="padding-left: 1.5em">- {{$p->account_name}}</td>
						<td align="right">{{number_format(floatval($p->reversed1),2,',','.')}}</td>
					@endif
				</tr>
				@php 
				  $total=$total + floatval($p->reversed1);
				@endphp
			@endforeach
			<tr>
				<td style="width: 400px; padding-left: 1em"><strong>Total {{$name}}<strong></td>
				<td align="right"><strong>{{number_format(floatval($saldo),2,',','.')}}</strong></td>
			</tr>
			<tr>
				<td style="width: 400px"><strong>TOTAL LABA/RUGI<strong></td>
				<td align="right"><strong>{{number_format(floatval($total),2,',','.')}}</strong></td>
			</tr>
		</tbody>
	</table>

</body>
</html>
