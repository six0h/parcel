<?php

require_once('../config.php');

$today = new MongoDate(strtotime('today'));
$tomorrow = new MongoDate(strtotime('tomorrow'));
$crit = array();
$options = array('limit'=>2,'sort'=>array('date'=>1));
$prizes = $db->select('campaigns',$crit,$options); 
$i = 1;
?>

<div id="photos">
	<img src="img/photos/img1.png" alt="image 1" id="img1" />
	<img src="img/photos/img2.png" alt="image 2" id="img2" />
	<img src="img/photos/img3.png" alt="image 3" id="img3" />
	<img src="img/photos/img4.png" alt="image 4" id="img4" />
</div>

<div id="loading">
	<h1>Give us a sec, this parcel is heavy! Loading...</h1>
</div>


<div id="enter">
	
	<div class="copy-box animate">
		<h1>Open the parcel for your chance to Love Every Second of Sydney in Summer</h1>
	</div>

	<a href="#" id="auth-btn" class="button-link animate auth">Let's Play! <span class="arrow">&gt;</span></a>

	<div class="prize-box animate">

		<?php
		foreach($prizes as $prize) : 
			$caption = $prize['caption'];
			$file = $prize['prize'];
			($i == 1) ? $class = 'today' : $class = 'upcoming';
		?>
			<div class="<?php echo $class; ?>">
				<img src="uploads/<?php echo $file; ?>" alt="<?php echo $caption; ?>"/>
				<p><?php echo $caption; ?></p>
			</div>
		<?php $i++; endforeach; ?>
	</div>

</div>

<div id="result">
	<div class="copy-box">
		<h1>Share with friends!</h1>
		<p>You have already opened the parcel today, we'll give you another chance to experience Sydney in Summer if you pass the parcel to your friends!</p>
	</div>

	<a href="#" class="button-small">Skip <span class="arrow">&gt;</span></a>
	<a href="#" id="result-btn" class="button-half">Pass it On <span class="arrow">&gt;</span></a>
	<a href="#" id="finalBtn" class="button-link">Continue <span class="arrow">&gt;</span></a>
</div>

<div id="winner-form">
	<h1>Enter your details so we can send you your prize.</h1>
	<ul>
		<form method="POST" action="ajax/winnerupdate.php">
			<li><label for="first_name">First Name*</label><input type="text" name="first_name" id="first_name"/></li>
			<li><label for="last_name">Last Name*</label><input type="text" name="last_name" id="last_name"/></li>
			<li><label for="email">Email Address*</label><input type="text" name="email" id="email"/></li>
			<li><label for="location">Location*</label><input type="text" name="location" id="location"/></li>
			<li><label for="postal">Post Code*</label><input type="text" name="postal" id="postal"/></li>
			<li><label for="phone">Phone Number*</label><input type="text" name="phone" id="phone"/></li>
			<li><label for="news">I would like to be contacted on any deal and promotions related to Sydney</label>
				<input type="checkbox" name="news" id="news" class="checks" /></li>
			<li class="agree"><label for="agree">I agree to the Terms & Conditions*</label>
				<input type="checkbox" name="agree" id="agree" class="checks" /><br class="break" /></li>
			<li><input type="submit" value="Submit" id="submit" name="submit"/><br class="break"/></li>
			<input type="hidden" id="fbid" name="fbid"/>
		</form>
	</ul>
</div>

<div id="finalPage">
	<div class="copy-box">
		<h1>Congratulations</h1>
		<h2>We'll contact you shortly with your prize details.</h2>
		<p>See Sydney shine in summer with its spectacular line up of events, relaxed outdoor and beach lifestyle and dazzling display of nature and parks. Visit <a href="http://www.sydney.com" target="_blank">Sydney.com</a> to start planning your next trip.</p>
	</div>

	<div class="panels">
		<div class="panel1">
			<a href="http://www.sydney.com/destinations/sydney/sydney-in-summer/love-every-second-of-sydney?utm_source=facebook&utm_medium=app&utm_campaign=cmp-sydney-summer" target="_blank">Find out More ></a>
		</div>
		<div class="panel2">
			<a href="http://www.sydney.com/deals/summer?utm_source=facebook&utm_medium=app&utm_campaign=cmp-sydney-summer" target="_blank">Find out More ></a>
		</div>
		<div class="panel3">
			<a href="http://www.sydney.com/events?utm_source=facebook&utm_medium=app&utm_campaign=cmp-sydney-summer" target="_blank">Find out More ></a>
		</div>
		<br class="clear" />
	</div>
</div>

<div id="rules">
	<iframe src="TnC.html"></iframe>
	<a href="#" class="close">Close</a>
</div>

