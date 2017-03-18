<?php

	
	/**
	*
	*	Datenbankzugriff
	*
	* 	@author Felix Koschmidder
	*	@version 0.1 
	*/
	class db 
	{
		private $host 		= "mediaq.dbs.ifi.lmu.de";
		private $username 	= "student";
		private $password 	= "tneduts";
		private $db 		= "MediaQ_V2";


		function connect()
		{
			$con = mysqli_connect($this->host,$this->username,$this->password,$this->db);

			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_errno();
			}
			return $con;
		}

	}
?>