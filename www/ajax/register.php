<?php
require_once('../../config.php');

$status = 200;
$errors = array();
$response = array();

// MAKE SURE WE HAVE ALL REQUIRED INFO
if(!isset($_POST['email']) 
|| !isset($_POST['first_name'])
|| !isset($_POST['last_name']) 
|| !isset($_POST['id'])) {

	$response = array(
		'errors' => "You must provide your email address, first name, and last name to continue",
		'status' => 501);
	echo json_encode($response);
	exit();

}

// ASSIGN EACH POST TO ITS OWN VARIABLE
foreach($_POST as $key=>$value) $$key = $value;

// EXCHANGE OR RENEW TOKEN
$FBEndpoint = 'https://graph.facebook.com/oauth/access_token?client_id='. APP_ID .'&client_secret='. APP_SECRET .'&grant_type=fb_exchange_token&fb_exchange_token='.$_POST['access_token'];
$token = file_get_contents($FBEndpoint);
parse_str($token,$output);

// CHECK IF USER IS IN DATABASE
$crit = array('fbid' => $id);
$exists = $db->count('users', $crit);

// ASSIGN LOCATION A VARIABLE
$loc = $location['name'];

// GET EXPIRY DATE ON LONG-LIVED ACCESS TOKEN
$expires = new MongoDate(date('U') + $output['expires']);

// IF USER IS NOT ALREADY IN DATABASE
if($exists == 0) {
	$data = array(
		'fbid'=>$id,
		'first_name'=>$first_name,
		'last_name'=>$last_name,
		'email'=>$email,
		'gender'=>$gender,
		'location'=>$loc,
		'access_token'=>$output['access_token'],
		'expires'=>$expires);
	try {
		// INSERT INTO DATABASE
		$db->insert('users',$data);
	} catch (Exception $e) {
		$errors = $e->getMessage();
		$status = 500;
	}
} else { // IF USER IS ALREADY IN DATABASE
	
	// UPDATE USERS LOCAL PROFILE
	$updates = array(
		'first_name' => $first_name,
		'last_name' => $last_name,
		'email' => $email,
		'gender' => $gender,
		'location' => $loc,
		'access_token' => $output['access_token'],
		'expires' => $expires);
	$update_user = $db->update(array('fbid'=>$id), array('$set'=>$updates));

	$now = date('U'); // TODAYS DATE
	$today = strtotime('today'); // TIMESTAMP FOR BEGINNING OF TODAY
	$tomorrow = strtotime('tomorrow'); // TIMESTAMP FOR BEGINNING OF TOMORROW

	// CHECK IF USER HAS PLAYED TODAY
	$play_today = $db->count('plays', array(
		'fbid' => $id,
		'date' => array('$lt'=>$tomorrow),
		'date' => array('$gte'=>$today)
	));

	// IF THEY HAVE NOT PLAYED, PROCEED AS NORMAL
	if($play_today == 0) {
		// continue as normal
	} elseif ($play_today == 1) { // IF THEY PLAYED ONCE

		// CHECK IF THEY'VE SHARED WITH FRIENDS
		$count_plays = array(
			'fbid' => $id,
			'date' => array('$lt'=>$tomorrow),
			'date' => array('$gte'=>$today),
			'shared' => 1);
		$plays_shared = $db->count('plays', $count_plays);
		
		// IF THEY HAVE NOT SHARED WITH FRIENDS
		if($plays_shared == 0) {
			$status = 201;
			$errors[] = $first_name + ' played once today, and did not share with any friends.';
		} elseif ($plays_shared == 1) { // IF THEY HAVE SHARED WITH FRIENDS
			$status = 202;
			$errors[] = $first_name + ' played once today, and shared with a friend, they get to play again.';
		}

	} elseif ($play_today == 2) { // IF THEY'VE ALREADY PLAYED TWICE TODAY
			
		$status = 203;
		$errors[] = $first_name + ' played twice today';
	} 

	// CHECK IF THE TIME OF DAY HAS PASSED
	$today = new MongoDate(strtotime('today'));
	$now = new MongoDate();
	$tomorrow = new MongoDate(strtotime('tomorrow'));

	$time_check = $db->select('campaigns', array('date' => array('$gte' => $today), 'date' => array('$lt' => $tomorrow)));
	foreach($time_check as $time) $todays_time = $time['date']->sec;
}

$response['errors'] = $errors;
$response['status'] = $status;
$response['salt'] = rand_char(16);
$response['access_token'] = $output['access_token'];
$response['expiry'] = date('U') - $expiry->sec;

echo json_encode($response);

?>
	
