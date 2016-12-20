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
	Display Photos that only have 
@forelse ($photos as $photo)
<img src="{{ asset('organizations\photos' . $photo->image)}}">
@foreach ($Calendarevent as $calendar)
@if ($photo->calendar_id == $calendar->id)
Shows The name of the calender event.
<p> {{$calendar->name }} <p>
	@endif
	@endforeach
What they liked about the event 
<p>{{$photo->testimonial}}</p>
@empty
@endforelse 


<bk>
