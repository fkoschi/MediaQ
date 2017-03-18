<?php
// 	ini_set('display_errors', 1); error_reporting(E_ALL);
	
	session_start();

	// get variables
	$working_array=$_SESSION['allSeasons'];
	$facebookUserId = $_SESSION['facebookId'];
	$spring = filter_var($_POST['spring'], FILTER_VALIDATE_BOOLEAN);
	$summer = filter_var($_POST['summer'], FILTER_VALIDATE_BOOLEAN);
	$autumn = filter_var($_POST['autumn'], FILTER_VALIDATE_BOOLEAN);
	$winter = filter_var($_POST['winter'], FILTER_VALIDATE_BOOLEAN);
	$filename = date('Y-m-d-H-i-s');
	
	// set downloadFiles
	$downloadPathsFile = "../shell/downloadPaths.txt";
    $fh = fopen($downloadPathsFile, 'w') or die("can't open file");

    // store data from array in downloadFiles
    $i = 0;
	foreach($working_array as $seasons) {
    	if(($i==0 && $spring) || ($i==1 && $summer) || ($i==2 && $autumn) || ($i==3 && $winter)) {	
    		foreach($seasons as $elements) {
				$hello = "".$elements['VideoId'].",".$elements['SnippetStart'].",".$elements['SnippetStop'].",".$facebookUserId."\n";
				fwrite($fh, $hello);
    		}
		}
		$i++;
	}
    fclose($fh);
	
    //set videoFolder with help of facebookid
    if($facebookUserId == "") {
    	$videoFolder = "../../videos/broadcast/";
    } else {
    	$videoFolder = "../../videos/" . $facebookUserId . "/";
    	shell_exec("bash ../shell/createFolder.sh " . $videoFolder);
    }
    
    // execute magic
	shell_exec("bash ../shell/concatFiles.sh " . $videoFolder . " " . $filename);
	
	//return
	
	$browser = $_SERVER['HTTP_USER_AGENT'];
	
	$return = "";

	if($facebookUserId == "") {
		$return = $return . "broadcast/" . $filename;
	} else {
		$return = $return . $facebookUserId . "/" . $filename;
	}
	
	if(strpos($browser, "Safari") !== false && strpos($browser, "Chrome") === false)
	{
		echo $return . ".mp4";
	}
	else
	{
		echo $return . ".ogg";
	}
	
	
	
	
	
	//////////////////////////////////////////////end
	// 				print_r($elements['SnippetStop']);
	
    // 	echo var_export($spring, true);
    // 	echo var_export($summer, true);
    // 	echo var_export($autumn, true);
    // 	echo var_export($winter, true);
    
	//$return = $return . "\n" . $videoFolder . "\n";
	
	//echo count($_SESSION['allSeasons']);
	// if( $facebookId != '' )
	// {
	// 	$return = shell_exec("bash ./../ffmpeg-download/createFolder.sh " . $facebookId );
	// }
	// else
	// {
	// 	echo "No User is logged in...";
	// }

	// benötigte Form um es an das Skript zu übergeben
	// http://www.unix.com/shell-programming-and-scripting/145663-can-we-pass-array-another-script-file.html
	// die passenden Variablen oben werden dann über shell_exec an das Skript übergeben
	
	// 	$downloadPathsFile = "/Applications/MAMP/htdocs/MediaQ/php/downloadPaths.txt";
	// 	/var/www/html/MediaQ_MVC_V2/bash_video/origin/php
	// 	chmod($upload_dir, 777);
?>