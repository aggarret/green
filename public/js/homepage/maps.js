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
	console.log(currentLocation);

	//set any map options here
	var mapOptions = {
		center: currentLocation,
		zoom: 13
	};

	//find the id="map" and place a map within it.  pass in any map options
	map = new google.maps.Map(document.getElementById('map'), mapOptions);


  	var infoWindow = new google.maps.InfoWindow({map: map});
  	//infoWindow.setPosition(currentLocation);

  	
  	//create an array of alphabetical characters used to label the markers.
	var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
	//add some markers to the map.  be sure to define locations prior to this code
	var markers = locations.map(function(location, i)
	{
		console.log(location);
        return new google.maps.Marker({
        	position: location,
            label: labels[i % labels.length],
            map: map
        });
    });

    //add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer(map, markers, {
    	imagePath: 'images/m'});
}


