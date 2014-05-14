<?php
class csrf {
	public function gen() {
		$_SESSION['csrf_token'] = md5(uniqid());
	}
	
	public function get() {
		return $_SESSION['csrf_token'];
	}
	
	public function check($token) {
		return ($token==$_SESSION['csrf_token']);
	}
}
