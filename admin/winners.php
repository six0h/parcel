<?php

require_once('../config.php');

$items = $db->select('winners',array(),array('sort'=>array('date'=>1)));


?>

<table class="modal">
	<thead>
		<tr>
			<th>Campaign</th>
			<th>Key</th>
			<th>FBID</th>
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
			<td><?php echo $win_time; ?></td>
			<td><?php echo $date; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
