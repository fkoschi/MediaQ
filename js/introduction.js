$(document).ready(function(){

	$('p[class="nextStep"]').on('click', function() {

		var actualPage = $(this).attr('name');

		if (actualPage=='1') {
			// $('#information_page1').hide('slide', {direction : 'right'}, 1000);
			// $('#information_page2').show('slide', {direction : 'left'}, 1000);
			$('#information_page1').hide();
			$('#information_page2').show();

			$('#four_seasons').show().attr('class','animated bounceInDown');

			$('a[id="generate_video_button"], #video').show().attr('class','animated bounceInDown');			

			$(this).attr('name','2');
		}
		else if(actualPage=='2') {

			$('#information_page2').hide();
			$('#information_page3').show();

			$('#wikipedia_suche_button, #wikipedia_artikel').show().attr('class', 'animated bounceInDown');

			$(this).attr('name','3');
		}
		else if(actualPage=='3') {
			$('#startupInformation').attr('class','animated bounceOut');
		}

	});

	$('i[name="close_startupInformation"]').on('click',function(){

		$('#startupInformation').attr('class','animated bounceOut');

		$('#four_seasons, #generate_video_button, #wikipedia_suche_button, #video, #wikipedia_artikel').show().attr('class','animated bounceInDown');
	});

	// $.ajax({
 //          type  : 'POST',
 //          url   : 'php/getSession.php',
 //          success: function(data){
                          
 //            if(data == 'noData') 
 //            {
 //              $("#noDataContainer #noDataText").text("No Data").show();
 //            }
 //            else
 //            { 
 //              $("#noDataContainer").hide();
              
 //              var jsonObject = $.parseJSON(data);             
 //              $("#video_list").empty();
 //              // add element to sidebar for each videfile found on user specific folder
 //              $.each(jsonObject, function(index,value){
 //                  $("#video_list").append("<li><span class='sidebarVideoName'>Video "+index+"</span> <i class='fa fa-download' name='download_video' href='"+value.filename+"' title='Download'></i> <i class='fa fa-video-camera' name='watch_video' href='"+value.filename+"' title='Watch'></i></li>");
 //                  //<li><span class="sidebarVideoName">Video1</span> <i class="fa fa-download" name="download_video" title="Download"></i> <i class="fa fa-video-camera" name="watch_video" title="Watch"></i></li>
 //              });
 //            }             
 //          },
 //          error: function(xhr, status){
 //            console.log("Error: " + xhr );
 //          }
 //      });
});