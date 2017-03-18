<?php 
	
	session_start();

	unse($_SESSION['facebookId'] = '');
	
	session_destroy();

	echo "User just logged out from our app";
?>