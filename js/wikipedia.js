$(document).ready(function(){

	// make Wikipedia_Artikel div draggable
	//$('#wikipedia_artikel').draggable(); --> BULLSHIT!

	// MediaWikiAPI
	$('#wikipedia_suche_button').on('click', function(event){
		
		event.preventDefault();

		//show spinning wheel while page is loading content over mediawiki
		$('#loadingPage').show();

		var input = $('#pac-input').val();
		
		var splitInput = input.split(',');

		var suche = splitInput[0];
		if(suche == "Chinesischer Turm") {
			suche = "Chinesischer Turm (München)"
		}
		
		$.ajax({
			method: 		'GET',
			url: 			'./php/getDataFromWikipedia.php',
			contentType: 	'application/json',
			// dataType: 	'json',
			data: 	{
				'input' : suche
			},
			success: function(data){

				if( data != 'No input was given' )
				{
					$('#wikipedia_artikel #inhalt p').empty();
					$('#wikipedia_artikel #inhalt p').append(data);
				} 
				else {
					$('#wikipedia_artikel #inhalt p').empty();
					$('#wikipedia_artikel #inhalt p').append("No Wikipedia article cloud have been found!");
				}
				$('#loadingPage').hide();
				$('img[name="wikipedia_artikel"], h4[class="wikipedia_artikel_titel"]').effect('bounce', {times:3}, 300);
			},
			error: function(xhr, status) {
				console.log( xhr + status);
			}
		})

		$('#wikipedia_artikel').show();
	});

	$('i[name="toggle_wikipedia_modal"]').on('click', function(event){

		event.preventDefault();
		$('#inhalt').toggle();
	});

})