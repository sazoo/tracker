<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Unicorn Admin</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<style>
			table thead {
			  position: fixed;
			}
			.flat-table {
			  display: block;
			  font-family: sans-serif;
			  -webkit-font-smoothing: antialiased;
			  font-size: 10px;
			  overflow: auto;
			  width: auto;
			}
			.flat-table th {
			  background-color: #70c469;
			  color: white;
			  font-weight: normal;
			  padding: 20px 30px;
			  text-align: center;
			}
			.flat-table td {
			  background-color: #eeeeee;
			  color: #6f6f6f;
			  padding: 10px 20px;
			}


		</style>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/respond.min.js"></script>
		<![endif]-->
			
	</head>	
	<body data-color="grey" class="flat">
	<div>
	<table class="flat-table" id="dataTable">
		<thead>
			<tr>
			  <th rowspan="2">Date</th>
			  <th rowspan="2">Time</th>
			  <th colspan="5">Buy</th>
			  <th colspan="5">Sell</th>
			  <th colspan="5">RSI</th>
			</tr>
			<tr>
			  <th>Current</th>
			  <th>4-EMA</th>
			  <th>% diff</th>
			  <th>24-EMA</th>
			  <th>% diff</th>
			  <th>Current</th>
			  <th>4-EMA</th>
			  <th>% diff</th>
			  <th>24-EMA</th>
			  <th>% diff</th>
			  <th>Gain</th>
			  <th>Loss</th>
			  <th>Ave Gain</th>
			  <th>Average Loss</th>
			  <th>RSI</th>
			</tr>
		</thead>
	  <tbody>
		@foreach($data as $d)
		<tr>
		  <td>{{ date('m/d/Y', strtotime($d['date']))}}</td>
		  <td>{{ date('H:i', strtotime($d['date']))}}</td>
		  <td>{{ $d['buy_current']}}</td>
		  <td>{{ $d['buy_four_ema']}}</td>
		  <td>{{ $d['buy_four_prcnt_diff']}}</td>
		  <td>{{ $d['buy_twenty_four_ema']}}</td>
		  <td>{{ $d['buy_twenty_four_prcnt_diff']}}</td>
		  <td>{{ $d['sell_current']}}</td>
		  <td>{{ $d['sell_four_ema']}}</td>
		  <td>{{ $d['sell_four_prcnt_diff']}}</td>
		  <td>{{ $d['sell_twenty_four_ema']}}</td>
		  <td>{{ $d['sell_twenty_four_prcnt_diff']}}</td>
		  <td>{{ $d['gain']}}</td>
		  <td>{{ $d['loss']}}</td>
		  <td>{{ $d['ave_gain']}}</td>
		  <td>{{ $d['ave_loss']}}</td>
		  <td>{{ $d['rsi']}}</td>
		</tr>
		@endforeach
	  </tbody>
	</table>
	</div>
	</body>
</html>
