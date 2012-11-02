<?php

require_once('../config.php');

$items = $db->select('campaigns',array(),array('sort'=>array('_id'=>1)));


?>

<table class="modal">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date/Time</th>
			<th>Key</th>
			<th>Last Claimed</th>
			<th>Winner</th>
			<th>Win Time</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	foreach($items as $item) {
		$_id = $item['_id'];
		$date = $item['date'];
		$key = $item['key'];
		$last_claim = $item['last_claim'];
		$winner = $item['winner'];
		$win_time = $item['win_time'];
	?>
		<tr>
			<td><?=$_id?></td>
			<td><?=date('M d Y h:i:s', $date->sec);?></td>
			<td><?=$key?></td>
			<td><?=$last_claim?></td>
			<td><? if(isset($winner)) echo $winner;?></td>
			<td><? if(isset($win_time)) echo $win_time;?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
