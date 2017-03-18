<?php
	
	session_start();

	$_SESSION['facebookId'] = $_POST['facebookId'];

	echo "crate session for facebook user";

?>