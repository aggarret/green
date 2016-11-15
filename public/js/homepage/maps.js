//declare map outside of functions incase you want to use it somewhere else.
var map;
var markers;
var markerCluster;

function initMap()
{
    //make sure DOM has finished loading
	$(document).ready(function() {

        console.log('locations');
        console.log(locations);

        console.log('titles');
        console.log(titles);

        console.log('orgs');
        console.log(orgs);

		//get current location.  call initialize when location is grabbed.  could take a few seconds
		navigator.geolocation.getCurrentPosition(initialize);
	});
}

function initialize(position)
{
	//create var to use later.  populate with info from navigator
	//var currentLocation = {lat: position.coords.latitude, lng: position.coords.longitude};
    var currentLocation = {lat: 37.832685, lng: -122.273709};
	
    //set any map options here
	var mapOptions = {
		center: currentLocation,
		zoom: 15
	};

    console.log('1');

	//find the id="map" and place a map within it.  pass in any map options
	map = new google.maps.Map(document.getElementById('map'), mapOptions);

    console.log('2');
	//init info window.  not used for anything yet
  	//var infoWindow = new google.maps.InfoWindow({map: map});
  	//infoWindow.setPosition(currentLocation);


  	//function to drop markers.  clustering is the callback function
  	dropMarkers(markers);
    console.log('3');
}

function dropMarkers(markers) {
    //locations are passed in from php json.  variable is defined/populated prior to this .js file.
    Promise.all(locations.map(addMarkerWithTimeout))
    .then(function(value){
        clustering(value);
        return value;
    });
}

//return promise of marker object.  use promise because setTimeout doesn't allow a return
function addMarkerWithTimeout(position, timeout) {
    return new Promise(function(resolve, reject) {
        window.setTimeout(function(){
            resolve(new google.maps.Marker({
                position: position,
                map: map,
                animation: google.maps.Animation.DROP}));
        }, timeout*300);
    }).then(function(value) {
        return value;
    });
}


//add a marker clusterer to manage the markers.
function clustering(markers) {
	markerCluster = new MarkerClusterer(map, markers, {
	imagePath: 'images/m'});
}


