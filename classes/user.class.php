<?php

class User {
	
	protected	$fbid,
				$first_name,
				$last_name,
				$email,
				$gender,
				$location,
				$access_token,
				$expires,
				$db;

	public function __constructor($db) {
		$this->db = $db;
	}

	public function getFbId() {
		return $this->fbid;
	}

	public function setFbId($fbid) {
		$this->fbid = $fbid;
	}

	public function getFirstName() {
		return $this->first_name;
	}

	public function setFirstName($first_name) {
		$this->first_name = $first_name;
	}

	public function getLastName() {
		return $this->last_name;
	}

	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getGender() {
		return $this->gender;
	}

	public function setGender($gender) {
		$this->gender = $gender;
	}

	public function getLocation() {
		return $this->location;
	}

	public function setLocation($location) {
		$this->location = $location;
	}

	public function getAccessToken() {
		return $this->access_token;
	}

	public function setAccessToken($access_token) {
		$this->access_token = $access_token;
	}

	public function getExpires() {
		return $this->expires;
	}

	public function setExpires($expires) {
		$this->expires = $expires;
	}

	private function instantiate($record) {
		$object = new self;
		foreach($record as $key=>$value) {
			$object->$key = $value;
		}
		return $object;
	}
	
}

?>
