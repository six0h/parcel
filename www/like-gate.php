<?php

require_once('../config.php');

$today = new MongoDate(strtotime('today'));
$tomorrow = new MongoDate(strtotime('tomorrow'));
$crit = array();
$options = array('limit'=>2,'sort'=>array('date'=>1));
$prizes = $db->select('campaigns',$crit,$options); 
$i = 1;
?>

<div id="like-gate">

	<div class="copy-box">
	
		<h1>Open the parcel for your chance to Love Every Second of Sydney in Summer.</h1>
		<img src="img/like-gate/like-btn.png" alt="Just click LIKE to start"/>

		<div class="prize-box animate">
			<?php
			foreach($prizes as $prize) : 
				$caption = $prize['caption'];
				$file = $prize['prize'];
				($i == 1) ? $class = 'today' : $class = 'upcoming';
			?>
			<div class="<?php echo $class; ?>">
				<img src="uploads/<?php echo $file; ?>" alt="Nascar"/>
				<p><?php echo $caption; ?></p>
			</div>
			<?php $i++; endforeach; ?>
		</div>

	</div>

</div> 
