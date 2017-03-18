$(document).ready(function() {
	
	var checkbox = [];
	checkbox.push(document.getElementById('spring'));
	checkbox.push(document.getElementById('summer'));
	checkbox.push(document.getElementById('autumn'));
	checkbox.push(document.getElementById('winter'));
	
	checkbox[0].onclick = function() {
		showMarkers(springMarkers);
	}
	
	checkbox[1].onclick = function() {
		showMarkers(summerMarkers);
	}
	
	checkbox[2].onclick = function() {
		showMarkers(autumnMarkers);
	}
	
	checkbox[3].onclick = function() {
		showMarkers(winterMarkers);
	}
	
	// Removes the markers from the map, but keeps them in the array.
	function clearMarkers(array) {
		arrayToMap(array, null);
	}
	
	// Shows any markers currently in the array.
	function showMarkers(array) {
		arrayToMap(array, map);
	}
	
	// Sets the map on all markers in the array.
	function arrayToMap(array, map) {
		for (var i = 0; i < array.length; i++) {
			array[i].setMap(map);
		}
	}
	
	function setSeasonMarkers(checkbox, array) {
		if(checkbox) {
			showMarkers(array);
		} else {
			clearMarkers(array);
		}
	}
	
	function initializeSeasonMarkers() {
		//TODO
	}
});