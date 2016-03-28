<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Unicorn Admin</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<style>
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
			  padding: 5px 5px;
			  text-align: center;
			}
			.flat-table td {
			  background-color: #eeeeee;
			  color: #6f6f6f;
			  padding: 5px 5px;
			}
			
			.container {
	box-sizing: border-box;
	width: 1000px;
	height: 450px;
	padding: 20px 15px 15px 15px;
	margin: 15px auto 30px auto;
	border: 1px solid #ddd;
	background: #fff;
	background: linear-gradient(#f6f6f6 0, #fff 50px);
	background: -o-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -ms-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -moz-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -webkit-linear-gradient(#f6f6f6 0, #fff 50px);
	box-shadow: 0 3px 10px rgba(0,0,0,0.15);
	-o-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-ms-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-moz-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-webkit-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.placeholder {
	width: 100%;
	height: 100%;
	font-size: 14px;
	line-height: 1.2em;
}


		</style>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/respond.min.js"></script>
		<![endif]-->
		<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
			
			<script type="text/javascript">

			$(function() {

				var d1 = [];
				var date = '';
				var buyFour = '';
				var i = 0;
				var x = 0;
				var options = '';
				var minValue = '';
				var maxValue = '';
				@foreach($data as $d)
					
					buyFour = '<?php echo $d['buy_four_ema']  ?>';
					d1.push([i, buyFour]);
					i++;
				@endforeach
				
				<?php 
					$data->sortBy('buy_four_ema');
				?>
				minValue = '<?php echo $data->first()['buy_four_ema'] - 50; ?>'
				maxValue = '<?php echo $data->last()['buy_four_ema'] + 50; ?>'
				
				var chartOptions = {
					xaxis: { ticks:24},
					yaxis: {tickSize:20, min:minValue}
				};
				$.plot("#buy-placeholder", [ d1 ], chartOptions);

			});

			</script>
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
		  <td>{{ date('m/d/Y', strtotime($d['created_at']))}}</td>
		  <td>{{ date('H:i', strtotime($d['created_at']))}}</td>
		  <td>{{ $d['bid']}}</td>
		  <td>{{ $d['buy_four_ema']}}</td>
		  <td>{{ $d['buy_four_diff']}}</td>
		  <td>{{ $d['buy_twenty_four_ema']}}</td>
		  <td>{{ $d['buy_twenty_four_diff']}}</td>
		  <td>{{ $d['ask']}}</td>
		  <td>{{ $d['sell_four_ema']}}</td>
		  <td>{{ $d['sell_four_diff']}}</td>
		  <td>{{ $d['sell_twenty_four_ema']}}</td>
		  <td>{{ $d['sell_twenty_four_diff']}}</td>
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
	<div class="container">
		<div id="buy-placeholder" class="placeholder"></div>
	</div>
	</body>
</html>
