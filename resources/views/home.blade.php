@extends('layouts.app')

@section('title')
    home Page
@endsection

@section('head')
    <!-- CSS -->
    <link href="{{ URL::to('css/scrolling-nav.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/homepage/maps.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/Home.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
    <!-- Intro Section -->
    <section id="intro" class="intro-section">
        <div class="intro_container">
            <div class="intro_row">
                <div class="intro_col-lg-12">
                    <h1>Carrot Path</h1>
                    <h3> Whether you're a Voluenteer, Organizer or Local Buisness</h3>
                    <h3>Carrot Path has a route for you!</h3>
                    <a class="btn btn-default page-scroll" href="#about"></a>
                    <h4>Follow the Path to Learn More</h4>
                    <video poster="long.jpg" autoplay="true" loop> 
                        <source src="https://s3.amazonaws.com/distill-videos/videos/processed/34/BetweenTwoTrees-HD.mp4.webm" type="video/webm">
                        <source src="https://s3.amazonaws.com/distill-videos/videos/processed/34/BetweenTwoTrees-HD.mp4-mobile.mp4" type="video/mp4">
                   </video>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <!-- <img src="/images/vol_pic.jpg" alt="picture"/> -->
        <div class="about_container">
            <div class="row">
                <div class="about_col-lg-12">
                    <h1>What We're All About</h1>
                    <h4>We're a platform that connects organizations, voluneteers and local buisnesses to fulfill worthy causes within the community.</h4>
                    <a class="btn btn-default page-scroll about_btn" href="#services"></a>
                    <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Volunteer</a></li>
    <li><a href="#tabs-2">Organization</a></li>
    <li><a href="#tabs-3">Merchant</a></li>
  </ul>
  <div id="tabs-1">
    <p><strong>Volunteers</strong></p>
    <ul style="list-style: none;">
       
        <li>Strengthen local community by volunteering at local Non-Profit Organizations.</li>
        <li>Strengthen own personal network by hanging out at the planned “after party” with fellow volunteers</li>
        <li>Informed of  interested Non-Profits</li>
        <li><a id='Volunteer' href="{{ url('/volunteer/login') }}">Volunteers Login</a></li>
        <li><a id='RegVol' href="{{ url('/volunteer/register') }}">Register Volunteers</a></li><br>
    </ul>
  </div>
  <div id="tabs-2">
    <p><strong>Organization</strong></p>
    <ul style="list-style: none;">
       
        <li>Direct access to pool of Carrot Path volunteers</li>
        <li>We say “Thank you for volunteering with us” on behalf of the Non-Profits</li>
        <li>Stay in touch with community</li>
        <li><a id='Organization' href="{{ url('/organization/login') }}">Organizations Login</a></li>
        <li><a id='RegOrg' href="{{ url('/organization/register') }}">Register Organizations</a></li>
    </ul>
  </div>
  <div id="tabs-3">
    <p><strong>Local/Global Businessn</strong></p>
    <ul style="list-style: none;">
        <li>More Customers</li>
        <li>Stay in touch with community</li>
        <li>Market products/services to new audience</li>
        <li>Click Here to Learn More</li>
    </ul>
  </div>
</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Leader Boards</h1>
                    <a class="btn btn-default page-scroll" href="#contact"></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="area" class="area-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Your Area</h1>

                    <!-- Jquery places map inside the div-->
                    <div id="map"></div>
                    
                    <a class="btn btn-default page-scroll" href="#contacttwo"></a>
                </div>
            </div>
        </div>
    </section>

    <section id="contacttwo" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>More Info</h1>
                    <a class="btn btn-default page-scroll" href="#intro"></a>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('script')
    <!-- Scrolling Nav JavaScript -->
    jquery-ui.js
    <script src="{{ URL::to('js/jquery-ui.js') }}"></script>
    <script src="{{ URL::to('js/jquery.easing.min.js') }}"></script>
    <script src="{{ URL::to('js/homepage/scrolling-nav.js') }}"></script>

        
    <script type="text/javascript">
        //this needs to be declared outside of any function.  Can't think of any smarter way to do it
        var locations = [];
        var titles = [];
        var orgs = [];

        //strip out of the coords and title of the events
        $.each({!! $calendar_events !!}, function(k,v) {
            locations.push({lat: parseFloat(v.coord_lat), lng: parseFloat(v.coord_lng)});
            titles.push(v.title);
        });

        //strip out organization name.  had to do this way since org name is a manyToMany of event
        $.each({!! $orgs !!}, function(k,v) {
            orgs.push(v);
        });
    </script>

    <!-- Google maps clusters-->
    <script src="{{ URL::asset('js/homepage/markerclusterer.js') }}"></script>

    <!-- Google maps API-->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAPS_KEY') }}&callback=initMap" async defer></script>
    
    <!-- js to draw mapa and drop pins-->
    <script src="{{ URL::asset('js/homepage/maps.js') }}"></script>
    
    <script>
        $( function() {
            $( "#tabs" ).tabs({
                collapsible: true
            });
        });
    </script>

@endsection
                    