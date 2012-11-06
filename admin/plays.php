<?php

require_once('../config.php');

$items = $db->select('plays',array(),array('sort'=>array('date'=>1)));
$count = $db->count('plays',array());


?>

<p>Total Plays: <?php echo $count; ?></p>
<table class="modal">
	<thead>
		<tr>
			<th>FBID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Keys</th>
			<th>Date</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	foreach($items as $item) {
		if(isset($item['fbid'])) $fbid = $item['fbid'];
		if(isset($item['first_name']) && isset($item['last_name'])) {
			$first_name = $item['first_name'];
			$last_name = $item['last_name'];
			$name = $first_name." ".$last_name;
		}
		if(isset($item['email'])) $email = $item['email'];
		if(isset($item['key'])) $key = $item['key'];
		if(isset($item['date'])) $date = date('M d Y h:i:s e', $item['date']->sec);
	?>
		<tr>
			<td><?php echo $fbid;?></td>	
			<td><?php echo $name;?></td>	
			<td><?php echo $email;?></td>	
			<td><?php echo $key;?></td>	
			<td><?php echo $date;?></td>	
		</tr>
	<?php } ?>
	</tbody>
</table>
