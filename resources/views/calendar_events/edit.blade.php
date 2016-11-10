@extends('layouts.app')

@section('head')
    <link href="{{ URL::to('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
    <div class="page-header">
        <h1>CalendarEvents / Edit </h1>
    </div>


    <div class="row">
        <div class="col-md-6 col-md-offset-3 round">

            <form action="{{ route('calendar_events.update', $calendar_event->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                     <label for="title">Title of Event</label>
                     <input type="text" name="title" class="form-control" value="{{$calendar_event->title}}"/>
                </div>
                <div class="form-group">
                    <label for="description">Description of Event</label>
                    <textarea class="form-control" name="description" id="description" rows="5"> {{ $calendar_event->description }}</textarea>
                </div>
                    <div class="form-group">
                     <label for="start">Start Time of Event</label>
                     <input id="datetimepicker" type="text" name="start" class="form-control" value="{{$calendar_event->start}}"/>
                </div>
                    <div class="form-group">
                     <label for="end">End Time of Event</label>
                     <input id="datetimepicker2" text" name="end" class="form-control" value="{{$calendar_event->end}}"/>
                </div>
                    <div class="form-group">
                     <label for="is_all_day">Max Number of volunteers for event</label>
                     <input type="text" name="is_all_day" class="form-control" value="{{$calendar_event->max_volunteer}}"/>

                <br>
                <button type="submit" class="btn btn-success btn-block submit-btn">Update Event</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::to('js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ URL::to('js/javas.js') }}"></script>
@endsection
