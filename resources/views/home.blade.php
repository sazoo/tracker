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
		<!--<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>-->
	<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
			
			<script type="text/javascript">

			$(function() {
//--------------------------BUY --------------------------------
				var d1 = [];
				var d2 = [];
				var date = '';
				var buyFour = '';
				var buyTwentyFour = '';
				var i = 0;
				var x = 0;
				var options = '';
				var minValue = '';
				var maxValue = '';
				@foreach($data as $d)
					
					buyFour = '<?php echo $d['buy_four_ema']  ?>';
					buyTwentyFour = '<?php echo $d['buy_twenty_four_ema']  ?>';
					d1.push([i, buyFour]);
					d2.push([i, buyTwentyFour])
					i++;
				@endforeach
				
				<?php 
					$data->sortBy('buy_four_ema');
				?>
				minValue = '<?php echo $data->first()['buy_twenty_four_ema'] - 50; ?>'
				maxValue = '<?php echo $data->last()['buy_twenty_four_ema'] + 50; ?>'
				
				var chartOptions = {
					xaxis: { ticks:24},
					yaxis: {tickSize:50, min:minValue}
				};
				$.plot("#buy-placeholder", [ d1, d2 ], chartOptions);
		//--------------------------------SELL----------------------------------		
				var d1 = [];
				var d2 = [];
				var date = '';
				var sellFour = '';
				var sellTwentyFour = '';
				var i = 0;
				var x = 0;
				var options = '';
				var minValue = '';
				var maxValue = '';
				@foreach($data as $d)
					
					buyFour = '<?php echo $d['sell_four_ema']  ?>';
					buyTwentyFour = '<?php echo $d['sell_twenty_four_ema']  ?>';
					d1.push([i, buyFour]);
					d2.push([i, buyTwentyFour])
					i++;
				@endforeach
				
				<?php 
					$data->sortBy('sell_four_ema');
				?>
				minValue = '<?php echo $data->first()['sell_twenty_four_ema'] - 50; ?>'
				maxValue = '<?php echo $data->last()['sell_twenty_four_ema'] + 50; ?>'
				
				var chartOptions = {
					xaxis: { ticks:24},
					yaxis: {tickSize:50, min:minValue}
				};
				$.plot("#sell-placeholder", [ d1, d2 ], chartOptions);

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
	<div>
	<h2 class="title">Buy Chart</h2>
		<canvas id="buy" width="1200" height="400"></canvas>
    <div id="legendDiv">
		Legend
		<h4><span style="color: rgba(255,0,0,1)">4-EMA</span></h1>
		<h4><span style="color: rgba(0,0,255,1)">24-EMA</span></h1>
	</div>
	</div>
	<div>
	<h2 class="title">Sell Chart</h2>
		<canvas id="sell" width="1200" height="400"></canvas>
    <div id="legendDiv">
		Legend
		<h4><span style="color: rgba(255,0,0,1)">4-EMA</span></h1>
		<h4><span style="color: rgba(0,0,255,1)">24-EMA</span></h1>
	</div>
	</div><div>
	<h2 class="title">RSI Chart</h2>
		<canvas id="rsi" width="1200" height="400"></canvas>
    <div id="legendDiv">
		Legend
		<h4><span style="color: rgba(255,0,0,1)">RSI</span></h1>
	</div>
	</div>
		<!--<div id="buy-placeholder" class="placeholder"></div>
	</div>
	<div class="container">
	SELL
		<div id="sell-placeholder" class="placeholder"></div>
	</div>-->
	<script>
			var label = new Array();
			var fourHrData = new Array();
			var twentyFourHrData = new Array();
			@foreach($data as $d)
				var dateLabel = '';
					dateLabel = '<?php echo date('m/d/Y', strtotime($d['created_at'])) . ' ' .  date('H:i', strtotime($d['created_at'])) ?>';
					label.push(dateLabel);
					fourHrData.push(<?php echo $d['buy_four_ema'] ?>);
					twentyFourHrData.push(<?php echo $d['buy_twenty_four_ema'] ?>);
			@endforeach
			var buyData = {
			labels : label,
			datasets : [
				{
					label: "4-EMA",
					fillColor: "rgba(220,220,220,0)",
					strokeColor: "rgba(255,0,0,1)",
					pointColor: "rgba(255,0,0,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data : fourHrData
				},
				{
					label: "24-EMA",
					fillColor: "rgba(220,220,220,0)",
					strokeColor: "rgba(0,0,255,1)",
					pointColor: "rgba(0,0,255,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(151,187,205,1)",
					data : twentyFourHrData
				}
			]
		}
		var buy = document.getElementById('buy').getContext('2d');
		var myLineChart = new Chart(buy).Line(buyData);
	</script>
	<script>
			var label = new Array();
			var fourHrData = new Array();
			var twentyFourHrData = new Array();
			@foreach($data as $d)
				var dateLabel = '';
					dateLabel = '<?php echo date('m/d/Y', strtotime($d['created_at'])) . ' ' .  date('H:i', strtotime($d['created_at'])) ?>';
					label.push(dateLabel);
					fourHrData.push(<?php echo $d['sell_four_ema'] ?>);
					twentyFourHrData.push(<?php echo $d['sell_twenty_four_ema'] ?>);
			@endforeach
			var sellData = {
			labels : label,
			datasets : [
				{
					label: "4-EMA",
					fillColor: "rgba(220,220,220,0)",
					strokeColor: "rgba(255,0,0,1)",
					pointColor: "rgba(255,0,0,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data : fourHrData
				},
				{
					label: "24-EMA",
					fillColor: "rgba(220,220,220,0)",
					strokeColor: "rgba(0,0,255,1)",
					pointColor: "rgba(0,0,255,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(151,187,205,1)",
					data : twentyFourHrData
				}
			]
		}
		var sell = document.getElementById('sell').getContext('2d');
		var myLineChart = new Chart(sell).Line(sellData);
	</script>
	<script>
			var label = new Array();
			var rsi = new Array();
			@foreach($data as $d)
				var dateLabel = '';
					dateLabel = '<?php echo date('m/d/Y', strtotime($d['created_at'])) . ' ' .  date('H:i', strtotime($d['created_at'])) ?>';
					label.push(dateLabel);
					rsi.push(<?php echo $d['rsi'] ?>);
			@endforeach
			var rsiData = {
			labels : label,
			datasets : [
				{
					label: "RSI",
					fillColor: "rgba(220,220,220,0)",
					strokeColor: "rgba(255,0,0,1)",
					pointColor: "rgba(255,0,0,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data : rsi
				}
			]
		}
		var rsi = document.getElementById('rsi').getContext('2d');
		var myLineChart = new Chart(rsi).Line(rsiData);
	</script>
	</body>
</html>
