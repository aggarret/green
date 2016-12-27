@extends('layouts.app')

@section('head')
    <link href="{{ URL::to('css/OrgDash.css') }}" rel="stylesheet" />

    <link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print"/>
    <link href="{{ URL::to('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" >
    <style>
ul.auto-complete-list {
    z-index: 1052 !important;
}
    </style> 

@endsection

@section('title')
    Dashboard
@endsection

@section('content')
    @if (Storage::disk('local')->has('organization-' . $user->firstName . '-' . $user->id . '.jpg'))
        <div id="toparea" > </div>
        <div id="info" class="container">
        <div class="col-md-6">
            <img id="userImage" class="img-responsive img-circle" src="{{ route('organization.account.image', ['filename' => 'organization-' . $user->firstName . '-' . $user->id . '.jpg']) }}" alt="">
            Organization: {{ $user->organization }} <br>
            Name: {{ $user->firstName }} {{ $user->lastName }} <br>
            Area: {{ $user->zipCode }}
        </div>

    @else
        <p>Image not found!</p>
        Organization: {{ $user->organization }} <br>
        Name: {{ $user->firstName }} {{ $user->lastName }} <br>
        Area: {{ $user->zipCode }}
    @endif

<!-- Organization add Photos -->
<button id="AddPhoto" class="btn btn-success" type="submit">Add Photo!</button>

    <div class="container">
      <form action="{{ route('OrgStorePhoto')}}" id="form1" method="post" enctype="multipart/form-data">
        <fieldset>
        Select image to upload:
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="radio" name="shared" value="TRUE"> Allow us to share<br>
        <input type="radio" name="shared" value="" checked> keep photo on my page <br>
        <label for="calender">Calendar event </label>
        <input id="calendar_id" name="calendar_id" value="2" type ="hidden">
        <input id="calender"  name="calender" class="ui-front" >
         <textarea rows="4" cols="50" name="testimonial" form_id="form2" id="testimonial" hidden>
Please briefly tell us what you personally enjoyed about this event!
</textarea>
        <input type="submit" value="Upload Image" name="submitForm">
        <input type="file" class="uploade" name="file" id="fileToUpload">
      </fieldset>
      </form>
    </div>
     

<!-- Show Photos posted belonging organization for edition and deleating -->
@forelse ($user->photo as $photo)
    {{-- Show Image --}} 
    <img src="{{ asset('organizations\photos' . $photo->image)}}">
    {{-- Edit Button --}}
    <a class="btn btn-warning" href="{{ route ('OrgEditPhoto', $photo->id ) }}">Edit</a>
    {{-- Delete Method --}} 
    <form action="{{ route('OrgDeletePhoto', $photo->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>

@empty
    <p>No users</p>
@endforelse


    
    <div class="col-md-6">
        {!! $calendar->calendar() !!}
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

