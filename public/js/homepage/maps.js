//declare map outside of functions incase you want to use it somewhere else.
var map;
var markers = [];
var markerCluster;
var infowindow = null;

function initMap()
{
    //make sure DOM has finished loading
	$(document).ready(function() {

        /*
        console.log('locations');
        console.log(locations);

        console.log('titles');
        console.log(titles);

        console.log('orgs');
        console.log(orgs);
        */
		//get current location.  call initialize when location is grabbed.  could take a few seconds
		navigator.geolocation.getCurrentPosition(initialize);
	});
}

function initialize(position)
{
	//create var to use later.  populate with info from navigator
	var currentLocation = {lat: position.coords.latitude, lng: position.coords.longitude};
    //var currentLocation = {lat: 37.832685, lng: -122.273709};
	
    //set any map options here
	var mapOptions = {
		center: currentLocation,
		zoom: 15
	};

    //Map is ready to load.  Destroy progress bad
    progressBar.progressbar( "destroy" );

	//find the id="map" and place a map within it.  pass in any map options
	map = new google.maps.Map(document.getElementById('map'), mapOptions);

	//init info window
  	infowindow = new google.maps.InfoWindow({map: map});

  	//function to drop markers, add event listeners, and cluster markers
  	dropMarkers(locations)
    .then(clustering)
    .then(addEventListners)
}


function dropMarkers(pos) {
    /*  locations are passed in from php json.  variable is defined/populated prior to this .js file.
        promise chain addMarkerWithTimeout followed by clustering.
    */
    return Promise.all(pos.map(addMarkerWithTimeout))
}

function addEventListners(markers) {
    return Promise.all(markers.map(function(marker, index) {
     //add event listener for object
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(this.content);
            infowindow.open(map, this);
        });
    }))
}


//return promise of marker object.  use promise because setTimeout doesn't allow a return
function addMarkerWithTimeout(position, timeout) {
    var marker = null;
    return new Promise(function (resolve) {
        window.setTimeout(function () {
            //create a marker object
            resolve(new google.maps.Marker({
                position: position,
                map: map,
                clickable: true,
                content: titles.shift(),
                animation: google.maps.Animation.DROP
            }));
        }, timeout*300);
    })
}


//add a marker clusterer to manage the markers.
function clustering(markerAll) {
	return new Promise(function(resolve) {
        markerCluster = new MarkerClusterer(map, markerAll, {
    	imagePath: 'images/m'});
        //use map to push to markers array.
        markerAll.map(function(e) {
            markers.push(e);
        });
        resolve(markers);
    });
}