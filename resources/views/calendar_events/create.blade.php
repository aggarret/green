@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>CalendarEvents / Create </h1>
    </div>
    @include('includes.errors')
    @if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>    
    </div>
@endif

@if(Session::has('message'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {{Session::get('message')}}
        </div>    
    </div>
@endif

            <form action="{{ route('calendar_events.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                     <label for="title">Title of Event</label>
                     <input type="text" name="title" class="form-control" value=""/>
                </div>
                <div class="form-group">
                    <label for="description">Description of Event</label>
                    <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                </div>
                    <div class="form-group">
                     <label for="start">Start Time of Event</label>
                     <input id="start" type="text" name="start" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="end">End Time of Event</label>
                     <input id="end" type="text" name="end" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="max_volunteer">Max Number of volunteers for event</label>
                     <input type="text" name="max_volunteer" class="form-control" value=""/>
                     <br>
                <button type="submit" class="btn btn-success btn-block submit-btn">Create Event</button>
            </form>
        </div>
    </div>

@section('script')
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.js"></script>

    <script src="{{ URL::to('js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ URL::to('js/javas.js') }}"></script>
@endsection
