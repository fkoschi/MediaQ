$(document).ready(function() {

	$('#menu-button').on('click', function() {

		// $("#video_list").empty();

		var option = $(this).attr('name');

		if( option == 'show' )
		{
			// slide in sidebar
			$('#sidebar').css('z-index','99999999999');
	
			// slide out main container
			$('#content').css('margin-left', '250px');

			//hide video container
			$('#video, #wikipedia_artikel, #four_seasons, #generate_video_button, #wikipedia_suche_button').attr('class','animated bounceOutLeft');
			
			$(this).attr('name','hide');		

		}		
		else if( option = 'hide' )
		{
			//slide out slidebar
			$('#sidebar').css('z-index','-1');
			$('#content').css('margin-left', '0');
			$('#video, #wikipedia_artikel, #four_seasons, #generate_video_button, #wikipedia_suche_button').attr('class', 'animated bounceInLeft');

			$(this).attr('name','show');
		}
	});

	// transmitt url from sidebar element to video player
	$('#video_list').delegate('i[name="watch_video"]', 'click', function () {
		
		var fileSuffix = $(this).attr('href').split('.');

		if ( fileSuffix[1] == 'ogg')
		{
			var fileSuffixType = 'audio/ogg';
		}
		else if ( fileSuffix[1] == 'mp4')
		{
			var fileSuffixType = 'video/mp4';
		}
		var videoFolderPathServer = "http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/bash_video/videos/";
		var filePath = videoFolderPathServer + $(this).attr('href');
		$('#video_source').attr('src', filePath);
		$('#video_source').attr('type', fileSuffixType);
		$('#video_content').toggle();		
		$('#sidebar').css('z-index','-1');
		$('#content').css('margin-left', '0');
		$('#video, #wikipedia_artikel, #four_seasons, #generate_video_button, #wikipedia_suche_button').attr('class', 'animated bounceInLeft');
		$("#menu-button").attr('name','show');
		$('video').load();

	});
	// open link in new tab to allow user to download video (just another option)
	$('#video_list').delegate('i[name="download_video"]', 'click', function() {
		var videoFolderPathServer = "http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/bash_video/videos/";
		var filePath = videoFolderPathServer + $(this).attr('href');
		window.open(filePath);
	});

});
