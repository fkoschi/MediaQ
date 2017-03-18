$(document).ready(function(){

	// just for testing purposes 
	// to see if session variable has been stored	

	$.ajax({
		url		: 	'./php/getSession.php',
		type	: 	'POST',
		success : function(data) {

			var jsonObject = $.parseJSON(data);
			if (jsonObject != null )
			{
				$.each(jsonObject, function(index,value){
					$("#video_list").append("<li><span class='sidebarVideoName'>Video "+index+"</span> <i class='fa fa-download' name='download_video' title='Download'></i> <i class='fa fa-video-camera' name='watch_video' href='"+value.filename+"' title='Watch'></i></li>");
					//<li><span class="sidebarVideoName">Video1</span> <i class="fa fa-download" name="download_video" title="Download"></i> <i class="fa fa-video-camera" name="watch_video" title="Watch"></i></li>
				});
			}
			else {
				$("#video_list").append("<li>Keine Daten vorhanden");
			}
		},
		error 	: function(xhr,status) {
			console.log("error " + xhr.status);
		}
	});
});