<?php

require_once('../../config.php');
$changes = array();
$status = 200;
$errors = array();

if(!empty($_POST['first_name'])) $changes['first_name'] = $_POST['first_name'];
if(!empty($_POST['last_name'])) $changes['last_name'] = $_POST['last_name'];
if(!empty($_POST['email'])) $changes['email'] = $_POST['email'];
if(!empty($_POST['location'])) $changes['location'] = $_POST['location'];
if(!empty($_POST['postal'])) $changes['postal'] = $_POST['postal'];
if(!empty($_POST['phone'])) $changes['phone'] = $_POST['phone'];
if($_POST['agree'] == 'on') {
	$changes['agree'] = 1;
} else {
	$status = 500;
	$errors[] = 'User did not agree to the terms';
	echo json_encode(array('status'=>$status,'errors'=>$errors));
	exit;
}

if(isset($_POST['news']) && $_POST['news'] == 'on') {
	$changes['news'] = 1;
} else {
	$changes['news'] = 0;
}

if(!isset($_POST['fbid'])) {
	$status = 501;
	$errors[] = 'No userId supplied to update';
	echo json_encode(array('status'=>$status,'errors'=>$errors));
	exit();
}

$set = array('$set'=>$changes);
$crit = array('fbid'=>$_POST['fbid']);

try {
	$db->update('users',$crit,$set);
} catch (Exception $e) {
	$status = 500;
	$errors[] = 'Could not update user info';
	echo json_encode(array('status'=>$status,'errors'=>$errors));
	exit();
}

echo json_encode(array(
	'status'=>$status,
	'errors'=>$errors));

?>