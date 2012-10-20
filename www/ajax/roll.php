<?php

require_once('../../config.php');
$status = 200;
$errors = array();

if(isset($_POST['id']) && isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {
		
} else {
	$status = 501;
	$errors[] = "You didn't submit your entry from the app, are you trying to cheat?";
}

$response = array(
	'status' => (int) $status,
	'errors' => $errors,
	'id' => (int) $_POST['id'],
	'attempt' => $roll
);

echo json_encode($response);

?>
