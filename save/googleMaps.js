https://sites.google.com/site/gmapsdevelopment/
var marker_blu_stars = 'http://www.google.com/mapfiles/kml/paddle/blu-stars.png';

$(document).ready(


		function() {
			var map = new google.maps.Map(document
					.getElementById('map-container'), {
				mapTypeId : google.maps.MapTypeId.ROADMAP
			});

<<<<<<< Updated upstream
			//Geolocation abfangen
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(initialize);
			} else {
				x.innerHTML = "Geolocation is not supported by this browser!";
			}

			function initialize(position) {

				var latitude;
				var longitude;

//				$.getJSON('./../getDatabase.php', function(
//						dataFromDB) {
//					// addPinToMap((data[1]).Plat, (data[1]).Plong,
//					// (data[1]).Plat);
//					console.log("Open JS");
//
//					var marker, i;
//
//					var iMax = 20;
//					var jMax = 4;
//					var locations = new Array();
//
//					for (i = 0; i < iMax; i++) {
//						locations[i] = new Array();
//						for (j = 0; j < jMax; j++) {
//							locations[i][j] = 0;
//						}
//					}
//
//					console.log("Data from PHP");
//					console.log(dataFromDB);
//
//					for (i = 0; i < dataFromDB.length; i++) {
//						locations[i][0] = 'MediaQ'
//						locations[i][1] = dataFromDB[i].Plat;
//						locations[i][2] = dataFromDB[i].Plng;
//						locations[i][3] = (dataFromDB.length - 1) - i;
//					}
//
//					console.log(locations.toString());
//
//					for (i = 0; i < locations.length; i++) {
//						marker = new google.maps.Marker({
//							position : new google.maps.LatLng(locations[i][1],
//									locations[i][2]),
//							map : map
//						});
//
//						google.maps.event.addListener(marker, 'click',
//								(function(marker, i) {
//									return function() {
//										infowindow.setContent(locations[i][0]);
//										infowindow.open(map, marker);
//									}
//								})(marker, i));
//					}
//
//				});

				// Positionsdaten wurden über Browser übermittelt
				if (position) {
					latitude = position.coords.latitude;
					longitude = position.coords.longitude;
				}
				// Positionsdaten statisch setzen
				else {
					// LMU Institut für Informatik
					latitude = 48.149323;
					longitude = 11.594025;
				}
=======
		$.getJSON('http://localhost/origin/getDatabase.php', function(
				dataFromDB) {
			// addPinToMap((data[1]).Plat, (data[1]).Plong,
			// (data[1]).Plat);


		// // Get Geolocation of user 
		// if(navigator.geolocation)
		// {
		// 	navigator.geolocation.getCurrentPosition(initialize);
		// }
		// else 
		// {
		// 	navigator.geolocation.latitude = 123;
		// 	navigator.geolocation.longitude = 54;
		// 	x.innerHTML = "Geolocation is not supported by this browser!";
		// }
	
		var marker, i;

		var iMax = 20;
		var jMax = 4;
		var locations = new Array();

		for (i = 0; i < iMax; i++) {
			locations[i] = new Array();
			for (j = 0; j < jMax; j++) {
				locations[i][j] = 0;
			}
		}

		$.getJSON('http://localhost:8888/getDatabase.php', function(dataFromDB) {
			
			addPinToMap((data[1]).Plat, (data[1]).Plong, (data[1]).Plat);

			console.log(dataFromDB);
			
			for (i = 0; i < dataFromDB.length; i++) {
				locations[i][0] = 'MediaQ'
				locations[i][1] = dataFromDB[i].Plat;
				locations[i][2] = dataFromDB[i].Plng;
				locations[i][3] = (dataFromDB.length - 1) - i;
			}

			console.log(locations.toString());

			for (i = 0; i < locations.length; i++) {
				marker = new google.maps.Marker({
					position : new google.maps.LatLng(locations[i][1],
								locations[i][2]),
								map : map
				});

				google.maps.event.addListener(marker, 'click',(function(marker, i) {
					return function() {
							infowindow.setContent(locations[i][0]);
							infowindow.open(map, marker);
						}
				})(marker, i));
			}

		}); // getJSON

		// Positionsdaten wurden über Browser übermittelt
		// if (position) {
		// 	latitude = position.coords.latitude;
		// 	longitude = position.coords.longitude;
		// }
		// // Positionsdaten statisch setzen
		// else {
			// LMU Institut für Informatik
			latitude = 48.149323;
			longitude = 11.594025;
		// }
	
		console.log(dataFromDB);

		for (i=0; i<dataFromDB.length; i++){
			locations[i][0] = 'MediaQ'
			locations[i][1] = dataFromDB[i].Plat;
			locations[i][2] = dataFromDB[i].Plng;
			locations[i][3] = (dataFromDB.length-1)-i;
		}
			
		console.log(latitude,longitude);

		var markers = [];

		var mapOptions = {
			center : new google.maps.LatLng(latitude, longitude),
			mapTypeControl : true,
			mapTypeControlOptions : {
				style : google.maps.MapTypeControlStyle.LARGE,
				position : google.maps.ControlPosition.BOTTOM_LEFT
			},
			zoomControl : true,
			zoomControlOptions : {
				style : google.maps.ZoomControlStyle.LARGE,
				position : google.maps.ControlPosition.LEFT_BOTTOM
			},
			scaleControl : false,
			zoom : 13,
			title : 'Your position'
		};

		var map = new google.maps.Map(document
				.getElementById('map-container'), mapOptions);

		// Create the search box and link it to the UI element.
		var input = /** @type {HTMLInputElement} */
		(document.getElementById('pac-input'));
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		var myLatIng = new google.maps.LatLng(latitude, longitude);

		var marker = new google.maps.Marker({
			position : myLatIng,
			map : map,
			draggable : false
		});

		var searchBox = new google.maps.places.SearchBox(
		/** @type {HTMLInputElement} */
		(input));
>>>>>>> Stashed changes

				var markers = [];

				var mapOptions = {
					center : new google.maps.LatLng(latitude, longitude),
					mapTypeControl : true,
					mapTypeControlOptions : {
						style : google.maps.MapTypeControlStyle.LARGE,
						position : google.maps.ControlPosition.BOTTOM_LEFT
					},
					zoomControl : true,
					draggable: true,
					zoomControlOptions : {
						style : google.maps.ZoomControlStyle.LARGE,
						position : google.maps.ControlPosition.LEFT_BOTTOM
					},
					scaleControl : false,
					zoom : 13,
					title : 'Your position'
				};

				var map = new google.maps.Map(document
						.getElementById('map-container'), mapOptions);

				// Create the search box and link it to the UI element.
				var input = /** @type {HTMLInputElement} */
				(document.getElementById('pac-input'));
				map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

				var myLatIng = new google.maps.LatLng(latitude, longitude);

				var marker = new google.maps.Marker({
					position : myLatIng,
					map : map,
					draggable : false
				});
				markers.push(marker);

				var searchBox = new google.maps.places.SearchBox(
				/** @type {HTMLInputElement} */
				(input));

				// [START region_getplaces]
				// Listen for the event fired when the user selects an item from
				// the
				// pick list. Retrieve the matching places for that item.
				google.maps.event.addListener(searchBox, 'places_changed',
						function() {

							var places = searchBox.getPlaces();

							if (places.length == 0) {
								return;
							}
							for (var i = 0, marker; marker = markers[i]; i++) {
								marker.setMap(null);
							}

							// For each place, get the icon, place name, and
							// location.
							markers = [];
							var bounds = new google.maps.LatLngBounds();
							for (var i = 0, place; place = places[i]; i++) {
								var image = {
									url : place.icon,
									size : new google.maps.Size(71, 71),
									origin : new google.maps.Point(0, 0),
									anchor : new google.maps.Point(17, 34),
									scaledSize : new google.maps.Size(25, 25)
								};

								// Create a marker for each place.
								var marker = new google.maps.Marker({
									map : map,
									icon : image,
									title : place.name,
									position : place.geometry.location
								});

								markers.push(marker);

								bounds.extend(place.geometry.location);
							}

							var lat = null;
							var lon = null;
							if (places.length == 0) {
								// set default place
								lat = 48.152556;
								lon = 11.592084;
								map.fitBounds(bounds);
							} else {
								lat = places[0].geometry.location.lat();
								lon = places[0].geometry.location.lng();
							}
							console.log("queryPoint is set as: " + lat + "," + lon)
							
							//set new marker and center
							for(var i=0; i<markers.length; i++) {
								markers[i].setMap(null);
							}
							markers = [];
							var LatIng = new google.maps.LatLng(lat, lon);
							var marker = new google.maps.Marker({
								position : LatIng,
								map : map,
								draggable : false,
								icon : marker_blu_stars
							});
							markers.push(marker);
							map.setCenter(new google.maps.LatLng(lat,lon));
							map.setZoom(18);
							console.log("setCenter successful");

							// call getDatabase.php
							var postData = {
						        "lat" : lat,
						        "lon" : lon,
							};
							
							$.ajax({
							 	type: 		"POST",
							 	url: 		"./getDatabase.php",
							 	datatype : 	"json",
								data: postData,
								success: function(data){
									console.log("received data from getDatabase.php");
									var seasonArrays = jQuery.parseJSON(data);
									console.log(seasonArrays);
//									console.log(seasonArrays[0].length + ", " + seasonArrays[1].length + ", " + seasonArrays[2].length + ", " + seasonArrays[3].length);
//									console.log(data);
									
									var makersOfSeason = [];

									var springButton = document.getElementById('spring');
									var summerButton = document.getElementById('summer');
									var autmnButton = document.getElementById('autumn');
									var winterButton = document.getElementById('winter');

									  if (springButton.checked) {
									  	console.log("Frühling angewählt");
									  	makersOfSeason = makersOfSeason.concat(seasonArrays[0]); 
									  } else {
									  	console.log("Frühling nicht angewählt");
									  }

									  if (summerButton.checked) {
									  	console.log("Sommer angewählt");
									  	makersOfSeason = makersOfSeason.concat(seasonArrays[1]); 

									  } else {
									  	console.log("Sommer nicht angewählt");
									  }

									  if (autmnButton.checked) {
									  	console.log("Herbst angewählt");
									  	makersOfSeason = makersOfSeason.concat(seasonArrays[2]); 
									  } else {
									  	console.log("Herbst nicht angewählt");
									  }

									  if (winterButton.checked) {
									  	console.log("Winter angewählt");
									  	makersOfSeason = makersOfSeason.concat(seasonArrays[3]); 									  	
									  } else {
									  	console.log("Winter nicht angewählt");
									  }

//									  console.log(makersOfSeason);

									for (var i = 0, result; r = makersOfSeason[i]; i++) {
										var LatIng = new google.maps.LatLng(r.Plat, r.Plng);
										var marker = new google.maps.Marker({
											position : LatIng,
											map : map,
											draggable : false
										});
										markers.push(marker);
									}
							 	}, 
							 	error: function(xhr, status){
							 		console.log("Error occured while getDatabase.php"); 
							 	}
							});

				// [END region_getplaces]

				// Bias the SearchBox results towards places that are within the bounds of the
				// current map's viewport.
				google.maps.event.addListener(map, 'bounds_changed',
						function() {
							var bounds = map.getBounds();
							searchBox.setBounds(bounds);
						});
			});

			//$('#loadingPage').hide();

		}
			
			function setCenter(lat, lon) {
				
			}
		
	}
);