//declare map outside of functions incase you want to use it somewhere else.
var map;

function initMap()
{

	//make sure DOM has finished loading
	$(document).ready(function() {

		//get current location.  call initialize when location is grabbed.  could take a few seconds
		navigator.geolocation.getCurrentPosition(initialize);
	});
}

function initialize(position)
{
	//create var to use later.  populate with info from navigator
	var currentLocation = {lat: position.coords.latitude, lng: position.coords.longitude};

	//set any map options here
	var mapOptions = {
		center: currentLocation,
		zoom: 16
	};

	//find the id="map" and place a map within it.  pass in any map options
	map = new google.maps.Map(document.getElementById('map'), mapOptions);


  	var infoWindow = new google.maps.InfoWindow({map: map});
  	//infoWindow.setPosition(currentLocation);


  	var markers = [];
  	for (var i = 0; i < locations.length; i++) {
  		markers.push(addMarkerWithTimeout(locations[i], i * 500));
    }
    console.log('markers');
    console.log(markers);

    function addMarkerWithTimeout(position, timeout) {
        window.setTimeout(function() {
          	markers.push(new google.maps.Marker({
            	position: position,
            	map: map,
            	animation: google.maps.Animation.DROP
        	}));
        }, timeout);
    }

    function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }
/*
	//add some markers to the map.  be sure to define locations prior to this code
	var markers = locations.map(function(location, i)
	{
        return new google.maps.Marker({
        	position: location,
            label: i,
            animation: google.maps.Animation.DROP,
            map: map
        });
    });
*/
    //add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer(map, markers, {
    	imagePath: 'images/m'});
}


