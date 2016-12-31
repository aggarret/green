<H2>Nav Bar</H2>

<H1>Volunteer About </H2>
	<bk>
<H1>Organization About </H2>
	<bk>
<H1>Merchant About </H2>
	<bk>

<H3>testimonial section</H3>
<bk>
<bk>
<bk>
{{-- Cycle through photos that admin allows to share.(see admin contoler) --}} 

@forelse ($photos as $photo)

{{-- show image of photo (if statement to find correct path) --}}
	@if($photo->user_type == "App\Organization" )
	<img src="{{ asset('organizations\photos' . $photo->image)}}">
	@else
	<img src="{{ asset('volunteers\photos' . $photo->image)}}">
	@endif 

@foreach ($Calendarevent as $calendar)
@if ($photo->calendar_id == $calendar->id)
Shows The name of the calender event.
<p> {{$calendar->name }} <p>
	@endif
	@endforeach
Whad did you like about the event? 
<p>{{$photo->testimonial}}</p>
@empty
@endforelse 


<bk>
