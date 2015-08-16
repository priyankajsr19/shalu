<html>
<head>
	<link type="text/css" rel="stylesheet" href="{$admin_css}" />
	<link type="text/css" rel="stylesheet" href="{$current_theme_css}" />
	
	<style type="text/css">
		
		#stats_table{
			width:1200px;
			font-size:12px;
	 	}
	 	
	 	#stats_table td{
	 		text-align:center;
	 	}
	 	
	</style>
</head>
<body>
<div style="width:1230px;margin:20 auto;">
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" /><a href="deliverystats.php">Shipped products</a></legend>
	<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th colspan="1"></th>
				<th colspan="3">Last Two days</th>
				<th colspan="3">2-4 days</th>
				<th colspan="3">4-7 days</th>
				<th colspan="3"> > 7 days</th>
			</tr>
			<tr>
				<th colspan="1">Provider</th>
				<th colspan="1">Shipped</th><th colspan="1">Delivered</th><th colspan="1">UnDelivered</th>
				<th colspan="1">Shipped</th><th colspan="1">Delivered</th><th colspan="1">UnDelivered</th>
				<th colspan="1">Shipped</th><th colspan="1">Delivered</th><th colspan="1">UnDelivered</th>
				<th colspan="1">Shipped</th><th colspan="1">Delivered</th><th colspan="1">UnDelivered</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="title">Blue Dart</td>
				<td>{$bluedartDetails.twoday.shipped}</td>
				<td>{$bluedartDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=7&range1=2&range2=0">{$bluedartDetails.twoday.undelivered}</a></td>
				<td>{$bluedartDetails.fourday.shipped}</td>
				<td>{$bluedartDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=7&range1=4&range2=2">{$bluedartDetails.fourday.undelivered}</a></td>
				<td>{$bluedartDetails.sevenday.shipped}</td>
				<td>{$bluedartDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=7&range1=7&range2=4">{$bluedartDetails.sevenday.undelivered}</a></td>
				<td>{$bluedartDetails.longer.shipped}</td>
				<td>{$bluedartDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=7&range1=1000&range2=7">{$bluedartDetails.longer.undelivered}</a></td>
			</tr>
			<tr>
				<td class="title"> Quantium</td>
				<td>{$quantiumDetails.twoday.shipped}</td>
				<td>{$quantiumDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=10&range1=2&range2=0">{$quantiumDetails.twoday.undelivered}</a></td>
				<td>{$quantiumDetails.fourday.shipped}</td>
				<td>{$quantiumDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=10&range1=4&range2=2">{$quantiumDetails.fourday.undelivered}</a></td>
				<td>{$quantiumDetails.sevenday.shipped}</td>
				<td>{$quantiumDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=10&range1=7&range2=4">{$quantiumDetails.sevenday.undelivered}</a></td>
				<td>{$quantiumDetails.longer.shipped}</td>
				<td>{$quantiumDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=10&range1=1000&range2=7">{$quantiumDetails.longer.undelivered}</a></td>
			</tr>
			<tr>
				<td class="title">Aramex</td>
				<td>{$aramexDetails.twoday.shipped}</td>
				<td>{$aramexDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=6&range1=2&range2=0">{$aramexDetails.twoday.undelivered}</a></td>
				<td>{$aramexDetails.fourday.shipped}</td>
				<td>{$aramexDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=6&range1=4&range2=2">{$aramexDetails.fourday.undelivered}</a></td>
				<td>{$aramexDetails.sevenday.shipped}</td>
				<td>{$aramexDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=6&range1=7&range2=4">{$aramexDetails.sevenday.undelivered}</a></td>
				<td>{$aramexDetails.longer.shipped}</td>
				<td>{$aramexDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=6&range1=1000&range2=7">{$aramexDetails.longer.undelivered}</a></td>
			</tr>
			<tr>
				<td class="title">Speedpost</td>
				<td>{$speedpostDetails.twoday.shipped}</td>
				<td>{$speedpostDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=11&range1=2&range2=0">{$speedpostDetails.twoday.undelivered}</a></td>
				<td>{$speedpostDetails.fourday.shipped}</td>
				<td>{$speedpostDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=11&range1=4&range2=2">{$speedpostDetails.fourday.undelivered}</a></td>
				<td>{$speedpostDetails.sevenday.shipped}</td>
				<td>{$speedpostDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=11&range1=7&range2=4">{$speedpostDetails.sevenday.undelivered}</a></td>
				<td>{$speedpostDetails.longer.shipped}</td>
				<td>{$speedpostDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=11&range1=1000&range2=7">{$speedpostDetails.longer.undelivered}</a></td>
			</tr>
			<tr>
				<td class="title">AFL</td>
				<td>{$aflDetails.twoday.shipped}</td>
				<td>{$aflDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=12&range1=2&range2=0">{$aflDetails.twoday.undelivered}</a></td>
				<td>{$aflDetails.fourday.shipped}</td>
				<td>{$aflDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=12&range1=4&range2=2">{$aflDetails.fourday.undelivered}</a></td>
				<td>{$aflDetails.sevenday.shipped}</td>
				<td>{$aflDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=12&range1=7&range2=4">{$aflDetails.sevenday.undelivered}</a></td>
				<td>{$aflDetails.longer.shipped}</td>
				<td>{$aflDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=12&range1=1000&range2=7">{$aflDetails.longer.undelivered}</a></td>
			</tr>
			<tr>
				<td class="title">Sab Express</td>
				<td>{$sabexDetails.twoday.shipped}</td>
				<td>{$sabexDetails.twoday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=13&range1=2&range2=0">{$sabexDetails.twoday.undelivered}</a></td>
				<td>{$sabexDetails.fourday.shipped}</td>
				<td>{$sabexDetails.fourday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=13&range1=4&range2=2">{$sabexDetails.fourday.undelivered}</a></td>
				<td>{$sabexDetails.sevenday.shipped}</td>
				<td>{$sabexDetails.sevenday.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=13&range1=7&range2=4">{$sabexDetails.sevenday.undelivered}</a></td>
				<td>{$sabexDetails.longer.shipped}</td>
				<td>{$sabexDetails.longer.delivered}</td>
				<td><a href="deliverystats.php?getlist=1&carrierid=13&range1=1000&range2=7">{$sabexDetails.longer.undelivered}</a></td>
			</tr>
		</tbody>
	</table>
</fieldset>
</div>
</body>
</html>
