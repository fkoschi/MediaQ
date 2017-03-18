$(document).ready(function() {

	// Close Video Modal
	$('i[name="toggle_video_modal"]').on('click',function(event) {

		event.preventDefault();
		$('#video_content').toggle();
	});

	// Toggle Four Seasons Container
	$('i[id="close_four_seasons"]').on('click', function(event) {

		$('#seasons').toggle();
	});
});