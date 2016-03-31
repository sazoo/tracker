<!DOCTYPE html>
<html lang="en">
	<head>
		<title>DOMS TRACKER</title>
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
		  <script src="https://js.pusher.com/3.0/pusher.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
		<script>

    var pusher = new Pusher('c0c865e8f51359971d4f', {
      encrypted: true
    });
    var channel = pusher.subscribe('ticker');
    channel.bind('new_ticker', function(data) {
		var parsed = JSON.parse(data.text);
		
		var arr = [];

		for(var x in parsed){
		  arr.push(parsed[x]);
		}
      document.getElementById("dataTable").deleteRow(2);
	  
	  
	  var date = new Date(parsed.created_at);
	  var trHTML = '';
	  //$.each(parsed, function (i, item) {
            trHTML += '<tr><td>' + date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear() + '</td><td>' + date.getHours + ':' + date.getMinutes() + '</td><td>' + 
			parsed.bid + '</td><td>' + parsed.buy_four_ema + '</td><td>' + parsed.buy_four_diff + '</td><td>' + parsed.buy_twenty_four_ema + '</td><td>' + 
			parsed.buy_twenty_four_diff + '</td><td>' + parsed.ask + '</td><td>' + parsed.sell_four_ema + '</td><td>' + parsed.sell_four_diff + '</td><td>' + 
			parsed.sell_twenty_four_ema + '</td><td>' + parsed.sell_twenty_four_diff + '</td><td>' + parsed.gain + '</td><td>' + parsed.loss + '</td><td>' +
			parsed.ave_gain + '</td><td>' + parsed.ave_loss + '</td><td>' + parsed.rsi + '</td></tr>';
       // });
        $('#dataTable').append(trHTML);
		
		if(parsed.buy_four_diff < document.getElementById("4_ema_buy_text")){
			document.getElementById("4ema_sell").style.display = 'block';
		}
		if(parsed.buy_four_diff > document.getElementById("4_ema_sell_text")){
			document.getElementById("4ema_buy").style.display = 'block';
		}
	});
  </script>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/respond.min.js"></script>
		<![endif]-->
	<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
			
			
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
		<table>
			<thead>
				<tr>
					<th colspan="4">4-EMA Trend</th>
				</tr>
				<tr>
					<th></th>
					<th>% Diff Signal</th>
					<th>Current Trend</th>
					<th>Order</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Buy</td>
					<td><input type="text" id="4_ema_buy_text"></td>
					<td></td>
					<td id="4ema_sell" style="display: none">SELL!!!!</td>
				</tr>
				<tr>
					<td>Sell</td>
					<td><input type="text" id="4_ema_sell_text"></td>
					<td></td>
					<td id="4ema_buy" style="display: none">BUY!!!!</td>
				</tr>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<th colspan="4">Resistance/Support</th>
				</tr>
				<tr>
					<th></th>
					<th>Limits</th>
					<th>Current Value</th>
					<th>Order</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Buy</td>
					<td><input type="text"></td>
					<td></td>
					<td id="res_sell">SELL!!!!</td>
				</tr>
				<tr>
					<td>Sell</td>
					<td><input type="text"></td>
					<td></td>
					<td id="res_buy">BUY!!!!</td>
				</tr>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<th colspan="4">Stop-Loss</th>
				</tr>
				<tr>
					<th></th>
					<th>Limits</th>
					<th>Current Value</th>
					<th>Order</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Buy</td>
					<td><input type="text"></td>
					<td></td>
					<td id="sl_sell">SELL!!!!</td>
				</tr>
				<tr>
					<td>Sell</td>
					<td><input type="text"></td>
					<td></td>
					<td id="sl_buy">BUY!!!!</td>
				</tr>
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
