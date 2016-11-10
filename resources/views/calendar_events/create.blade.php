@extends('layouts.app')

@section('head')
    <link href="{{ URL::to('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
    <div class="page-header">
        <h1>CalendarEvents / Create </h1>
    </div>


    <div class="row">
        <div class="col-md-6 col-md-offset-3 round">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('calendar_events.store') }}" method="POST" id="event_create" data-parsley-validate="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="title">Title of Event</label>
                    <input type="text" name="title" class="form-control" value="" required="" minlength="4" data-parsley-type="alphanum"/>
                </div>
                <div class="form-group">
                    <label for="description">Description of Event</label>
                    <textarea class="form-control" name="description" id="description" rows="5" maxlength="512"></textarea>
                </div>
                <div class="form-group">
                    <label for="start">Start Time of Event</label>
                    <input id="start" type="text" name="start" class="form-control" value="" required=""/>
                </div>
                <div class="form-group">
                    <label for="end">End Time of Event</label>
                    <input id="end" type="text" name="end" class="form-control" value="" required=""/>
                </div>
                <div class="form-group">
                    <label for="max_volunteer">Max Number of volunteers for event</label>
                    <input type="text" name="max_volunteer" class="form-control" value="" required="" data-parsley-type="digits"/>
                </div>
                <div class="form-group">
                    <label for="address_street">Street Address</label>
                    <input type="text" name="address_street" class="form-control" value="" required=""/>
                </div>
                <div class="form-group">
                    <label for="address_city">City</label>
                    <input type="text" name="address_city" class="form-control" value="" required="" data-parsley-type="alphanum"/>
                </div>
                <div class="form-group">
                    <label for="address_state">State</label>
                    <input type="text" name="address_state" class="form-control" value="" required="" minlength="2" data-parsley-type="alphanum"/>
                </div>
                <div class="form-group">
                    <label for="address_zip">Zip Code</label>
                    <input type="text" name="address_zip" class="form-control" value="" required="" data-parsley-type="digits" max="99999" data-parsley-type="alphanum"/>
                </div>
                     <br>
                <button type="submit" id= "event_create_button" class="btn btn-success btn-block submit-btn">Create Event</button>
            </form>
        </div>
    </div>

@section('script')
    <!-- Calendar scripts-->
    <script src="{{ URL::to('js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ URL::to('js/javas.js') }}"></script>
    
    <!-- Form Validation -->
    <script src="{{ URL::to('js/parsley.min.js') }}"></script>
    
    
    <!-- custom JS to pull geocode from address -->
    <script type="text/javascript">
        //Need to pull these variables outside of .js file because .js does not understand blade template
        var ajax_url = "{!! route('calendar_events.store') !!}";
        var redirect_url = "{!! route('calendar_events.index') !!}";
    </script>
    <script src="{{ URL::to('js/event_create.js') }}"></script>
    
    <!-- Google geocode API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAPS_KEY') }}&callback=geocode"
    async defer></script>
@endsection
