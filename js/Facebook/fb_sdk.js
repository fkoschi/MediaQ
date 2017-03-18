// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
	console.log('statusChangeCallback');
	console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		testAPI();
  } 
  else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
    console.log("not not_authorized");

    // window.location.reload();
	} 
  else if (response.status === 'unknown') {
		// I actually don´t know which case this handler is dealing with
    console.log("unknown");

    $.ajax({
      type  : 'POST',
      url   : 'php/endSession.php',
      data  : { facebookId : response.id },
      success: function(data){
          console.log(data);
      },
      error: function(xhr, status){
        console.log("Error: " + xhr );
      }
    });

    $("#video_list").empty();
    window.location.reload();
	} 
  else {
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
    console.log("else");
    // window.location.reload();
  }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


window.fbAsyncInit = function() {
    FB.init({
      appId      : '1599873860296265',
      xfbml      : true,
      version    : 'v2.3'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


function testAPI() {

    console.log('Welcome!  Fetching your information.... ');

    FB.api('/me', function(response) {

      $.ajax({
        type  : 'POST',
        url   : 'php/startSession.php',
        data  : { facebookId : response.id },
        success: function(data){
            console.log(data);
        },
        error: function(xhr, status){
          console.log("Error: " + xhr );
        }
      });
      console.log('Successful login for: ' + response.name + '\n with id: ' + response.id);
    });

    // fetch data depending on which browser the user is on
    $.ajax({
          type  : 'POST',
          url   : 'php/getSession.php',
          success: function(data){
                          
            if(data == 'noData') 
            {
              $("#noDataContainer #noDataText").text("No Data").show();
            }
            else
            { 
              $("#noDataContainer").hide();
              
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
  }