@extends('layouts.app')

@section('title')
    home Page
@endsection

@section('head')
    <!-- CSS -->
    <link href="{{ URL::to('css/homepage/scrolling-nav.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/homepage/maps.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::to('css/Home.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
   <!-- Intro Section/First Section-->
    <section id="intro" class="intro-section">
        <video poster="long.jpg" autoplay="true" loop> 
                        <source src="https://s3.amazonaws.com/distill-videos/videos/processed/34/BetweenTwoTrees-HD.mp4.webm" type="video/webm">
                        <source src="https://s3.amazonaws.com/distill-videos/videos/processed/34/BetweenTwoTrees-HD.mp4-mobile.mp4" type="video/mp4">
                   </video>
        <div class="intro_container">
            <div class="intro_row">
                <div class="intro_col-lg-12">

                        <h1>Carrot Path</h1> 
                        <h3> Whether you're a <span id="vol-welcome"><a href="{{ URL::to('volunteer/register') }}">Voluenteer</a></span>, <span id="org-welcome"><a href="organization/register">Organizer</a></span> or <span id="bus-welcome"><a href="admin/register">Local Buisness</a></span></h3>
                        <h3>Carrot Path has a route for you! Register now!</h3>
                    <a class="btn btn-default page-scroll" href="#about"></a>
                    <h4>Follow the Path to Learn More</h4>
                    
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
                    <h1>What We're <span style="color: #FD8332">A</span><span style="color: #2FD935">l</span><span style="color: #2FD935">l</span> About</h1>
                    <div class="info_wrapper">
                        <div class="info_contianer">
                            <div class="info_sec">
                                <h2>Volunteers</h2>
                                <p>- Connect with Organizations<br>
                                - Roll up your sleeves and help out! <br>
                                - Earn and Redeem Carrot points for your time<br>
                                <a href="{{ URL::to('volunteer/register') }}">Sign Up Now!</a></p>
                                <img src="http://www.causeandeventraceseries.com/wp-content/uploads/2016/07/volunteer.jpg"/>
                            </div>
                            <div class="info_sec">
                                <h2>Organizations</h2>
                                <p>- Connect with Volunteers<br>
                                - Some other good reason <br>
                                - And another good reason here<br>
                                <a href="{{ URL::to('organization/register') }}">Sign Up Now!</a></p>
                                <img src="http://www.fastweb.com/uploads/article_photo/photo/1928350/crop380w_community_hands.jpg"/>
                            </div>
                            <div class="info_sec">
                                <h2>Businesses</h2>
                                <p>- Get involved with the local community<br>
                                - Some succinct reason regarding tax breaks<br>
                                - Another succinct reason for getting fresh business through donated coupons<br>
                                <a href="{{ URL::to('admin/register') }}">Sign Up Now!</a></p>
                                <img src="https://www.freshbooks.com/blog/wp-content/uploads/2013/07/SEO7.png"/>
                            </div>
                        </div>
                    </div>
                    <div class="quote">Some awe inspiring quote about volunteering.......<br>
                                                                                         <br>   
                                                                            - From Someone Important</div>
                </div>
                <a class="btn btn-default page-scroll about_btn" href="#leader"></a>
            </div>
        </div>
    </section>
 
    <!-- Services Section/ Third Section -->
    <section id="leader" class="leader-section">
        <div class="container">
            <div class="row">
                <div  class="leader_col-lg-12">
                    <h1>Leader Boards</h1>
                    <a class="btn btn-default page-scroll" href="#map"></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="area" class="area-section">
        <div class="container">
            <div class="row">
                
                <div class="area_col-lg-12">
                    <h1>Your Area</h1>
                    <div id="map"></div> <!-- Jquery places map inside the div-->
                    <div id="progressBar"></div>
                    <a class="btn btn-default page-scroll about_btn" href="#moreinfo"></a>
                </div>

            </div>
        </div>
    </section>

    <section id="moreinfo" class="moreinfo-section">
        <div class="container">
            <div class="row">
                <div class="moreinfo_col-lg-12">
                    <h1>More Info</h1>
                    <a class="btn btn-default page-scroll" href="#intro"></a>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('script')
    <!-- Scrolling Nav JavaScript -->
    
    <script src="{{ URL::to('js/jquery-ui.js') }}"></script>
    <script src="{{ URL::to('js/jquery.easing.min.js') }}"></script>
    <script src="{{ URL::to('js/homepage/scrolling-nav.js') }}"></script>

        
    <script type="text/javascript">
        var progressBar = $( "#progressBar" );
        progressBar.progressbar({
            value: false
        });
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
    <script src="{{ URL::to('js/scrolling-nav.js') }}"></script>
    <script>
        $( function() {
            $( "#tabs" ).tabs({
                collapsible: true
            });
        });
    </script>
@endsection