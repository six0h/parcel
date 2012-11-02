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
			<th>Caption</th>
			<th>Prize Pic</th>
			<th>Prize</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	foreach($items as $item) {
		$_id = $item['_id'];
		$date = $item['date'];
		$key = $item['key'];
		(isset($item['last_claim'])) ? $last_claim = $item['last_claim'] : $last_claim = '';
		(isset($item['winner'])) ? $winner = $item['winner'] : $winner = '';
		(isset($item['win_time'])) ? $win_time = $item['win_time'] : $win_time = '';
		(isset($item['caption'])) ? $caption = $item['caption'] : $caption = '';
		(isset($item['prize'])) ? $prize = $item['prize'] : $prize = '';
	?>
		<tr>
			<td><?=$_id?></td>
			<td><?=date('M d Y h:i:s', $date->sec);?></td>
			<td><?=$key?></td>
			<td><?=$last_claim?></td>
			<td><? if(isset($winner)) echo $winner;?></td>
			<td><? if(isset($win_time)) echo $win_time;?></td>
			<td><span id="<?=$_id?>" class="edit"><? if(isset($caption)) echo $caption;?></span></td>
			<td>
				<? if($prize != '') echo "<img src='".BASE_URL."uploads/".$prize."'/>";?>
			</td>
			<td>
				<form enctype="multipart/form-data" class="upload_form">
					<input type="file" name="value"/>
					<input type="submit" value="Upload" />
					<input type="hidden" name="id" value="<?=$_id;?>"/>
				</form>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
