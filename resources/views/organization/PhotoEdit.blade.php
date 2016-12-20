@extends('layouts.app')

@section('head')
    <link href="{{ URL::to('css/OrgDash.css') }}" rel="stylesheet" />

    <link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print"/>
@endsection

@section('title')
    Dashboard
@endsection

@section('content')
<p>Image not found!</p>
<p>Image not found!</p>
<p>Image not found!</p>
<div class="container">
      <form action="{{ route('OrgUpdatePhoto', $photo->id )}}" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="radio" name="shared" value="TRUE"> Allow us to share<br>
        <input type="radio" name="shared" value="" checked> keep photo on my page <br>
        <label for="tags">Tags: </label>
        <input id="tags"  name="calander_id">
        <input type="submit" value="Upload Image" name="submit">
        <input type="file" class="uploade" name="file" id="fileToUpload">
      </form>
    </div> 