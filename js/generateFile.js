$(document).ready(function() {

//	checkbox.push(document.getElementById('spring'));
	var fourSeasonsInput = [];
	
	$("#generate_video_button").on("click", function() {
		
		//show spinning wheel
		$("#loadingPage").show();

		// check on which four season checkbox is selected

		if( $("input[name='spring']").is(':checked') )
		{
			fourSeasonsInput['spring'] = true;
		} else {
			fourSeasonsInput['spring'] = false;
		}
		if( $("input[name='summer']").is(':checked') )
		{
			fourSeasonsInput['summer'] = true;			
		} else {
			fourSeasonsInput['summer'] = false;
		}
		if( $("input[name='autumn']").is(':checked') )
		{
			fourSeasonsInput['autumn'] = true;
		} else {
			fourSeasonsInput['autumn']= false;
		}
		if( $("input[name='winter']").is(':checked') ) 
		{
			fourSeasonsInput['winter'] = true;
		} else {
			fourSeasonsInput['winter'] = false;
		}
		
		var postData = {
		 	"spring" : fourSeasonsInput['spring'],
		 	"summer" : fourSeasonsInput['summer'],
		 	"autumn" : fourSeasonsInput['autumn'],
		 	"winter" : fourSeasonsInput['winter'],
		};
		
		$.ajax({
			type : "POST",
			url		: 	"./php/generateScript.php",
			datatype : "json",
			data : postData,
			success : function(data) {
				
				//play video
				var src = "http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/bash_video/videos/" + data;
				$("#video_source").attr("src", src);
				console.log(src);
				var type = data.split(".");
				if(type[1] == "mp4") {
					$("#video_source").attr("type", "video/mp4");
				} else {
					$("#video_source").attr("type", "audio/ogg");
				}
				if($('#video_content').is(":hidden")) {
					$('#video_content').toggle();
				}
				console.log()
				$('video').load();
				
				
				// redraw sidebar
				$.ajax({
		            type  : 'POST',
		            url   : 'php/getSession.php',
		            success: function(data){
		            
		              if(data == 'noData') 
		              {
		                $("#noDataContainer").show();
		              }
		              else
		              { 
		                var jsonObject = $.parseJSON(data);
		                $("#video_list").empty();
		                // add element to sidebar for each videfile found on user specific folder
		                $.each(jsonObject, function(index,value){
		                    $("#video_list").append("<li><span class='sidebarVideoName'>Video "+index+"</span> <i class='fa fa-download' name='download_video' href='"+value.filename+"' title='Download'></i> <i class='fa fa-video-camera' name='watch_video' href='"+value.filename+"' title='Watch'></i></li>");
		                    //<li><span class="sidebarVideoName">Video1</span> <i class="fa fa-download" name="download_video" title="Download"></i> <i class="fa fa-video-camera" name="watch_video" title="Watch"></i></li>
		                });
		              }             
		            },
		            error: function(xhr, status){
		              console.log("Error: " + xhr );
		            }
		        });
				
				//hide spinning wheel
				$("#loadingPage").hide();
			},
			error 	: function(xhr,status) {
				console.log("error " + xhr.status);
			}
		});		
		
	});

});