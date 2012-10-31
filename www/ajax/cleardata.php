<?php

require_once('../../config.php');

$today = new MongoDate(strtotime('today'));
$tomorrow = new MongoDate(strtotime('tomorrow'));
$now = new MongoDate();

$crit = array('date'=>array(
		'$gte'=>$today,
		'$lt'=>$tomorrow
	));

$update = array(
	'$set'=>array(
		'last_claim'=>0),
	'$unset'=>array(
		'winner'=>1));

$db->update('campaigns',$crit,$update);
$db->remove('plays',array());
$db->remove('winners',array());

echo json_encode(array('status'=>200));
?>