<?php 

	session_start();
	
	/**
	**	Start session and set variables
	**	=> in this case FacebookId
	**
	**  Use this script to set session variables out of javascript files 
	** 
	**	string of log in status will be the callback to introduction.js
	**	=> will be used to set the text of the login/logut button
	**/
	
	$browser = $_SERVER['HTTP_USER_AGENT'];

	if(strpos($browser, "Safari") !== false && strpos($browser, "Chrome") === false)
	{
		$videoBrowser = "Safari";
	}
	else 
	{
		$videoBrowser = "Chrome";
	}

	// Set FacebookId 
	if($_SESSION['facebookId'])
	{
		// $_SESSION['facebookId'] = $_POST['facebookId'];
		
		//create folder from user
		shell_exec('bash ../shell/createFolder.sh ' . $_SESSION['facebookId']);

		// get videos from user	
		$user_videos_list = shell_exec('bash ../shell/getVideosFromUser.sh ' . $_SESSION['facebookId']);	
		$user_videos_array = explode("\n", $user_videos_list);
		$rückgabe_array = [];

		foreach ($user_videos_array as $index => $value) {
			if( $value != "" )
			{
				$fileTypeArray = explode(".",$value);
				$fileType = $fileTypeArray[1];

				if($videoBrowser == 'Safari')
				{
					if($fileType == 'mp4')
					{
						$rückgabe_array[$index]["filename"] = $_SESSION['facebookId'] . "/" . $value;			
					}
				}
				else
				{
					if($fileType == 'ogg')
					{
						$rückgabe_array[$index]["filename"] = $_SESSION['facebookId'] . "/" . $value;
					}
				}
			}
		}
		//var_dump(json_encode($rückgabe_array));
		echo json_encode($rückgabe_array);
	}
	else
	{
		// User is not logged in 
		$_SESSION['facebookId'] = '';
		echo "noData";
	}
	
?>