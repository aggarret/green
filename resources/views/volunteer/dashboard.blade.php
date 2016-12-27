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
	<button id="AddPhoto" class="btn btn-success" type="submit">Add Photo!</button>

    <div class="container">
      <form action="{{ route('OrgStorePhoto')}}" id="form1" method="post" enctype="multipart/form-data">
        <fieldset>
        Select image to upload:
        {{-- CSRF Tolken --}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{-- Share option --}}
        <input type="radio" name="shared" value="TRUE"> Allow us to share<br>
        <input type="radio" name="shared" value="" checked> keep photo on my page <br>
        {{-- Autocomplete field for coresponding calendar events --}} 
        <label for="calender">Calendar event </label>
        <input id="calendar_id" name="calendar_id" value="2" type ="hidden">
        <input id="calender"  name="calender" class="ui-front" >
        {{-- Testimonial Area --}}
         <textarea rows="4" cols="50" name="testimonial" form_id="form2" id="testimonial" hidden>
Please briefly tell us what you personally enjoyed about this event!
</textarea>
        <input type="submit" value="Upload Image" name="submitForm">
        {{-- Select File to Upload --}}
        <input type="file" class="uploade" name="file" id="fileToUpload">
      </fieldset>
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
<script text=javascript>
$(function() {
  
  // List for autocomplete to pull from using foreach blade statement for the lable and value 
   var availableTags = [
      @foreach ($calendar_events as $calendar_event)
      
                     { label: "{{ $calendar_event->title }}", value: "{{ $calendar_event->id }}" },
     
        @endforeach
        
];
// When button is selected Show photo form
$( "#AddPhoto" ).click(function() {
  $("#form1").dialog();
});
// If radio input is selected show the input fields for calander and testimonial sections
 $('input[name=shared]').change(function() {
  if ( $('input[name=shared]:checked').val() === "TRUE" ) {
    $("#testimonial").show();
    $("#calander").show();  
}
  else{
    $("#testimonial").hide();
    $("#calander").hide();
  }


});

// Jquery-ui autocomplete 
$( "#calender" ).autocomplete({
      appendTo: "#form1",
      source: availableTags,
      autoFocus: true,
      select: function(event, ui) {
           var num = ui.item.value;
           var id = num.toString();
           $('#calender').val(ui.item.label);  // display the selected text
           $('#calendar_id').val(ui.item.value); // save selected id to hidden input
           console.log(ui.item.value);
           document.getElementsByTagName("INPUT")[3].setAttribute("value", "2"); 

           return false;
          
          
        },
       change: function( event, ui ) {
        $( "#calendar_id" ).val( ui.item? ui.item.value : 0 );
       
    } 
  });
 
});

</script>


@endsection 

