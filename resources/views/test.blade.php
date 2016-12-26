@extends('layouts.app')

@section('title')
    test
@endsection

@section('head')
    <!-- CSS -->
    <link href="{{ URL::asset('css/homepage/maps.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
	<div id="main"></div>


	<div id="map"></div>
@endsection



@section('script')
	<!-- Google maps API-->
	<script type="text/javascript">
		//this needs to be declared outside of any function.  Can't think of any smarter way to do it
		var locations = [];
		$.each({!! $calendar_events !!}, function(k,v) {
			locations.push({lat: parseFloat(v.coord_lat), lng: parseFloat(v.coord_lng)});
		});
		console.log(locations);
	</script>

   	<script src="{{ URL::asset('js/homepage/markerclusterer.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAPS_KEY') }}&callback=initMap"
    async defer></script>
    <script src="{{ URL::asset('js/homepage/maps.js') }}"></script>
@endsection
