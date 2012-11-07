<?php

require_once('../config.php');

$items = $db->select('winners',array(),array('sort'=>array('date'=>1)));
$count = $db->count('winners',array());


echo "<span class='content'>Total Users: ".$count." (<a class='exportLink' href='csv-winners.php'>Export to CSV</a>)";
?>
<table class="modal">
	<thead>
		<tr>
			<th>Campaign</th>
			<th>Key</th>
			<th>FBID</th>
			<th>Phone</th>
			<th>Postal</th>
			<th>Win Time</th>
			<th>Campaign Date</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	foreach($items as $item) {
		if(isset($item['campaign_id'])) $id = $item['campaign_id'];
		if(isset($item['key'])) $key = $item['key'];
		if(isset($item['fbid'])) $fbid = $item['fbid'];
		if(isset($item['win_time'])) $win_time = $item['win_time'];

		$datequery = $db->select('campaigns',array('_id'=>new MongoId($id)));
		foreach($datequery as $camp) $date = $camp['date'];
		$date = date('M d Y H:i:s e', $date);
	?>
		<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo $key; ?></td>
			<td><?php echo $fbid; ?></td>
			<td><?php echo $phone; ?></td>
			<td><?php echo $postal; ?></td>
			<td><?php echo $win_time; ?></td>
			<td><?php echo $date; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
