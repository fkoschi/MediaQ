<?php
 

	session_start();


// function nameOfLastFile ()
// {
	// $videopath_template="";

	// if( $_SESSION['facebookId'] != '' ){
	// 	// $path = "../videos/$facebookID";
	// 	$path = "./php"; 
	// 	$videopath_template = "broadcast/";
 
	// }else {
	// 	// $path = "../videos/broadcast"; 
	// 	$path = "./shell"; 
	// 	$facebookkey = $_SESSION['facebookId'];
	// 	$videopath_template = "$facebookkey/";

	// }

	// $latest_ctime = 0;
	// $latest_filename = '';    

	// $d = dir($path);
	// while (false !== ($entry = $d->read())) {
	//   $filepath = "{$path}/{$entry}";
	//   // could do also other checks than just checking whether the entry is a file
	//   if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
	//     $latest_ctime = filectime($filepath);
	//     $latest_filename = $videopath_template . $entry;
	//   }
	// }
	// echo $latest_filename;

// 	return $latest_filename
// }




// if ($_GET['run']) {
//   # This code will run if ?run=true is set.
//   exec("./ffmpeg-download/concatFiles.sh");
// }

// if ($_GET['run']) {
//   # This code will run if ?run=true is set.
//   exec("./shell/concatFiles.sh");
// }

// 	// Server mit Video-Files
// 	$video_url = 'http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/video_content/';

// 	// Klasse für den Datenbank Zugriff
// 	require_once('db.php');

// 	$DB = new db;

//  	$con = $DB->connect();

// 	$sql = "SELECT * FROM VIDEO_METADATA LIMIT 20";

// 	$result = mysqli_query($con, $sql);


// 	$video_files = array();

// 	foreach ($result as $key => $value) {
// 		//print_r($key . " : " . "VideoId : " . $value['VideoId'] . " - Plat : " . $value['Plat'] . "<br>");

// 		$video_files[$key]['VideoId'] 	= $video_url . $value['VideoId'];
// 		$video_files[$key]['Plat'] 		= $value['Plat'];
// 		$video_files[$key]['Plng'] 		= $value['Plng'];
// 		$video_files[$key]['Link'] 		= '<a href="http://maps.google.com/maps?z=12&t=m&q=loc: ' . $value['Plat'] . ' ' . $value['Plng'] . ' ">Show on Google Maps</a>';

// 	}

// 	print_r('<pre>');
// 	print_r($video_files);
// 	print_r('</pre>');

	
// 	require('getDatabase.php');

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>MediaQ Team B</title>
	<meta name="autor" content="Felix Koschmidder, Markus Reisinger, Philipp Lienert">
	<meta name="keywords" content="MediaQ, Videos, GoogleMaps, Timelapse">
	<meta charset="utf-8">
	<!-- Favicon -->
	<link rel="shortcut icon" href="./img/icons/favicon.ico" type="image/x-icon">
	<link rel="icon" href="./img/icons/favicon.ico" type="image/x-icon">

	<!-- All the CSS Files -->
	<!-- 				   -->
	<link rel="stylesheet" type="text/css" href="./css/main.css">	<!-- Main.css -->
	<link rel="stylesheet" type="text/css" href="./css/map.css">	<!-- Map.css -->
	<link rel="stylesheet" type="text/css" href="./frameworks/bootstrap/css/bootstrap.min.css">		<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="./frameworks/bootstrap/css/bootstrap-rensponsive.min.css">	<!-- Bootstrap Responsive -->
	<link rel="stylesheet" type="text/css" href="./frameworks/font-awesome-4.3.0/css/font-awesome.css">		<!-- FontAwesome -->
	<link rel="stylesheet" type="text/css" href="./js/jQuery/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="./css/animate.css">
	<!-- All the JS Files -->
	<!-- 				  -->

	<!-- jQuery -->	
	<script type="text/javascript" src="./js/jQuery/jquery-1.11.2.min.js"></script>
	<!-- jQuery UI -->
	<script type="text/javascript" src="./js/jQuery/jquery-ui.min.js"></script>
	<!-- GoogleMapsAPI -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA68doICRsV2u2cpuj6Mlj_k-ODC3pnwCU"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
	<!-- GoogleMaps -->
	<script type="text/javascript" src="./js/googleMaps.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="./frameworks/bootstrap/js/bootstrap.min.js"></script>
	<!-- Wikipedia.js -->
	<script type="text/javascript" src="./js/wikipedia.js"></script>
	<!-- Video.js -->
	<script type="text/javascript" src="./js/video.js"></script>
	<!-- Sidebar.js -->
	<script type="text/javascript" src="./js/sidebar.js"></script>
	<!-- Introduction.js -->
	<script type="text/javascript" src="./js/introduction.js"></script>
	<!-- generateFile.js -->
	<script type="text/javascript" src="./js/generateFile.js"></script>
	<!-- login.js -->
	<!--<script type="text/javascript" src="./js/login.js"></script> -->
	<!-- start session -->
	<!-- <script type="text/javascript" src="./js/getSession.js"></script>   -->
	<!-- Google+ API -->
	<script src="https://apis.google.com/js/client:platform.js" async defer></script>
</head>

<body>
	<!-- Facebook SDK -->
	<script type="text/javascript" src="./js/Facebook/fb_sdk.js"></script>
	
	<!-- Video was successfully created -->
	<div id="generatedVideoAlert" class="animated bounceIn">
		<i class="fa fa-times-circle fa-2x" name="generateVideoAlertClose"></i>
		<h3 class="text-center">Success</h3>
		<p class="text-center" style="margin:20px;">Your video was succesfully created.</p>
	</div>
	<!-- Sidebar -->
	<div id="sidebar">
		<h1>Your<br> Videos</h1>
		<ul id="video_list">
			<!-- <li><span class="sidebarVideoName">Video1</span> <i class="fa fa-download" name="download_video" title="Download"></i> <i class="fa fa-video-camera" name="watch_video" title="Watch"></i></li>
			<li><span class="sidebarVideoName">Video2</span> <i class="fa fa-download" name="download_video" title="Download"></i> <i class="fa fa-video-camera" name="watch_video" title="Watch"></i></li> -->
		</ul>
		<div id="noDataContainer">
			<p id="noData"><i class="fa fa-frown-o fa-2x"></i></p>
			<p id="noDataText">Please log in first.</p>
		</div>
		<fb:login-button scope="public_profile,email" id="LoginButton" onlogin="checkLoginState();" class="text-center" autologoutlink="true" data-size="large">
		</fb:login-button>
	</div>
	
<!-- <div id="content"> -->
	<!-- Container to show up information about using the application on start -->

	<div id="startupInformation" class="animated bounceInDown ui-widget-content">
		<img src="./img/icons/megaphone.png" height="32" width="32" name="Information">
		<h4>How to use</h4>
		<i class="fa fa-times-circle fa-2x" name="close_startupInformation"></i>
		<div id="information_page1">
			<h4>Step 1</h4>
			<p>Using the Search Box at the top left corner of the page you can send your search request.
				This is Google stuff, we are not responsible of the results. 
				As you are used to the process, when sending the request your marker will be placed at the location of your request.
				<br><br>
				The magic comes with the next step.</p>
		</div>
		<div id="information_page2">
			<h4>Step 2</h4>
			<p>This is where magic happens !
				<br><br>
				If you placed your request, we use this location to generate a video from the data captured around this area. 
				Also you have the opportunity to set limits. In this case you can choose one or more seasons for the request. 
				After sending your request through the button placed besides the search box, your video will be generated. 
				Depending on the size and amount of videos, it could be possible that you have to wait 
				for a couple of seconds.
				<br><br>
				Enjoy <i class="fa fa-smile-o"></i>
				</p>
		</div>
		<div id="information_page3">
			<h4>Step 3</h4>
			<p>As if this would not be enough to blow your mind, we have another cool feature for you.
				<br><br>
				Using the just dropped in Button besides the video button you can send another request to the server. 
				This time you search for information on Wikipedia about the current location. 
				<br><br>
				Let us know if you find some bug or wish to have another cool feature. Please do so about the linked Wordpress site. 
				Available through the link on the top right corner of the page. 
				<br><br>
				Cheers!
			</p>
		</div>
		<p class="nextStep" name="1"><b>Next</b> <i class="fa fa-chevron-circle-right"></i></p>
	</div>


	<!-- Spinning Wheel -->
	<!-- Show while Page is loading -->
	<i id="loadingPage" class="fa fa-spinner fa-pulse fa-4x"></i>

	<!-- Login Modal -->
	<!-- Keep in Backup for some extensional functionality -->
	<div id="LoginModal" class="modal hide fade" tabindex="-1" role="dialog" area-hidden="true" aria-labelledby="">
		<div class="modal-header">
			<fb:login-button scope="public_profile,email" id="facebookLoginButton" onlogin="checkLoginState();" class="text-center" autologoutlink="true" data-size="large">
			</fb:login-button>
		</div>
		<div class="modal-body">
			<p>If you log in to facebook you can easily store you generated videos. Every time you log in again,
  				you can use the personal area on the bottom right corner to watch, download or share your generated 
  				videos.</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidde="true">Close</button>
		</div>
	</div>

	<!-- Navigation Bar -->
	<div id="navigation">
		<img src="./img/icons/menu-alt.png" height="16" width="16" id="menu-button" name="show" />
		<a id="information" target="_blank" href="http://mediaqteamb.wordpress.com"><i id="InfoButton" class="fa fa-info-circle fa-2x"></i></a>
		<div id="logo">
			<img class="image-center" src="img/logo/logo.png">
			<!-- <h2 class="text-center">Zurück in die Zukunft</h2> -->
		</div>
		<!-- <a id="LoginButton" href="#LoginModal" role="button" class="btn" data-toggle="modal">Login</a> -->
		<!--<a role="button" class="btn" id="testButton">Check for UserAlbum</a> -->
	</div>
	<!-- 
		Div Modal to show Video, can be activated through a button
		Video generated in backend
	-->
	<div id="video">
		
		<div id="video_nav">
			<img src="./img/icons/video.png" width="24" height="24" title="Video" name="video">
			<h4>Video</h4>
			<i name="toggle_video_modal" class="fa fa-chevron-down fa-1x" title="Minimize"></i>
		</div>
		<div id="video_content">			
			<video width="640" height="420" controls autoplay>
				<source id="video_source" src="" type=""/>	
			</video>	
					
			<div class="fb-share-button" data-href="http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/bash_video/origin/" data-layout="button"></div>
		</div>		
	</div>
	<!-- 
		Div Modal to show Wikipedia aricle
		Show Information about the current input value 
		Hide Modal about close Icon in the top right corner of the Container
	-->
	<div id="wikipedia_artikel" class="ui-widget-content">
		<img src="./img/icons/wikipedia_artikel.png" width="32" height="32" name="wikipedia_artikel" title="Wikipedia Artikel" />
		<h4 class="wikipedia_artikel_titel">Wikipedia</h4>
		<i name="toggle_wikipedia_modal" class="fa fa-chevron-down fa-1x" title="Minimize"></i>	
		<div id="inhalt">
			<p></p>
		</div>			
	</div>
	<!-- Google Input -->
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <!-- 
		Four seasons checkboxes 
		control the way marker are displayed and video is produced
	-->
	<div id="four_seasons">
		<span>Seasons of the year</span>
		<!-- Chevron down to minimize area -->
		<i class="fa fa-chevron-down" id="close_four_seasons"></i>

		<div id="seasons">			
			<div id="season">
				<img src="./img/icons/spring.png" height="24" width="24">
				<input type="checkbox" title="Spring" id="spring" name="spring">
				<span id="badge" class="badge" name="springBadge"></span> 
			</div>
			<div id="season">
				<img src="./img/icons/summer.png" height="24" width="24">
				<input type="checkbox" title="Summer" id="summer" name="summer"> 
				<span id="badge" class="badge" name="summerBadge"></span> 
			</div>				
			<div id="season">	
				<img src="./img/icons/autumn.png" height="24" width="24">
				<input type="checkbox" title="Autumn" id="autumn" name="autumn"> 
				<span id="badge" class="badge" name="autumnBadge"></span> 
			</div>	
			<div id="season">
				<img src="./img/icons/winter.png" height="24" width="24">
				<input type="checkbox" title="Winter" id="winter" name="winter"> 
				<span id="badge" class="badge" name="winterBadge"></span> 
			</div>		
		</div>
	</div>

    <!-- 
    	This Button controls the Wikipedia Container
		If clicked, Information will be shown. 
		Otherwise the Container will be disabled
	-->
	<a id="generate_video_button" class="btn btn-default" href="#" title="Generate Video..." href="?run=true">
		<img class="generate_video_button_bild" src="./img/icons/video.png">
	</a>
    <a id="wikipedia_suche_button" class="btn btn-default" href="#" title="Search for Wikipedia...">	
    	<img class="wikipedia_suche_button_bild" src="./img/icons/wikipedia_artikel.png">
    </a>

	<!-- Container to display GoogleMap -->
	<div id="map-container">
	</div>
<!-- </div> -->

</body>
	
</html>