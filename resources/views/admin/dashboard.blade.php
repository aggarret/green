@extends('layouts.app')

@section('headsection')
	<link href="{{ URL::to('css/OrgDash.css') }}" rel="stylesheet" />

	<link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print"/>
@endsection

@section('title')
    Admin Dashboard
@endsection

@section('content')
	<h1> test </h1>
	<h2> Shared Photos from users </h2>
	
	@foreach ($photos as $photo)

    <img src="{{ asset('organizations\photos' . $photo->image)}}">
   {{--  <a class="btn btn-warning " href="{{ route ('AdminAddphoto', $photo->id ) }}">Share in about</a> --}}
    <form action="{{ route ('AdminAboutphoto', $photo->id ) }}" method="GET" style="display: inline;"><input type="hidden" name="_method"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Share in about</button></form>

	@endforeach

@endsection


