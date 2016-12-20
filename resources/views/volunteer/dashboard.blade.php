@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section ('head')
<link href="{{ URL::to('css/VolDash.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">

<link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print"/>
 <link href="{{ URL::to('css/Dropzone.css') }}" rel="stylesheet" />
 <link href="{{ URL::to('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" >

@endsection
@section('content')
<div class="page-header">
        <h1>CalendarEvents</h1>
 </div>
<div class="container">
	<div class="row">
		<!-- Tracked Hours -->
		<div class="col-md-4 hours">
			<h3>Your Total Hours!</h3>
			<p>Hours: {{  $user->trackedHours }}</p> 	 
		</div>

		<!-- User image -->
		@if (Storage::disk('local')->has('volunteer-' . $user->firstName . '-' . $user->id . '.jpg'))
		<div class="col-md-8 infoSection">
            <div class="picture_info">
                <img id="userImage" class="img-circle img-responsive" width="300" height="300" src="{{ route('volunteer.account.image', ['filename' => 'volunteer-' . $user->firstName . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
            </div>
            <div class="text_info">
	            Name: {{ $user->firstName }} {{ $user->lastName }} <br>
				Area: {{ $user->zipCode }}
			</div>
        </div>
			        
		@else	
            <div class="col-md-8">
                <img src=" {{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?s=100&d=retro" }}">
                Name: {{ $user->firstName }} {{ $user->lastName }} <br>
				Area: {{ $user->zipCode }}
			</div>
		@endif
	
	<!-- User add Photos -->
	<div class="container">
	  <form action="{{ route('VolStorePhoto')}}" method="post" enctype="multipart/form-data">
    	Select image to upload:
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    	<label for="tags">Tags: </label>
  		<input id="tags"  name="calander_id">
    	<input type="submit" value="Upload Image" name="submit">
    	<input type="file" class="uploade" name="file" id="fileToUpload">
	  </form>
	</div>

	<!-- Badges -->
	<div class="container">
		<div class="row"> 
			<div class="col-md-12"><h3>Badges goes here</h3></div>
		</div>
	</div>

	
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<!-- About section -->
				<header><h3>About Me</h3></header>
				<p>{{ $user->about }}</p>
			</div>

			<div class="col-md-2">
				<header><h3>Interests</h3></header>
				<td class="text-right">
					<ul class="userDashboardInterests">
						@foreach ($userInterests as $userInterest)
							<li>{{ $userInterest->name }}</li <br>
						@endforeach
					</ul>
				</td>
			</div>
		</div>
	</div>
@endsection


@section('script')
	<script src="{{ URL::to('js/jquery-ui.js') }}"></script>
	<script>
  $( function() {
    var availableTags = [
      @foreach ($calendar_events as $calendar_event)
    "{{ $calendar_event->title }}",
		@endforeach
      "Scheme"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
	
@endsection
