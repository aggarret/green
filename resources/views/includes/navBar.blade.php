<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top" style="color:#FD8332">CP</a>
        </div>

         <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                <li class="hidden">
                    <a class="page-scroll" href="#page-top"></a>
                </li>
                <li>
                    <a class="page-scroll" href="#about" style="color:#FD8332">About</a>
                </li>
                <li>
                    <a class="page-scroll" href="#services" style="color:#FD8332">Leader Boards</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact" style="color:#FD8332">Your Area</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contacttwo" style="color:#FD8332">More Info</a>
                </li>
                <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Sign-in <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu list-group">
                                <li><a href="/volunteer/login">Volunteers</a></li>
                                <li><a href="/organization/login">Organizations</a></li>
                                <li><a href="#">Businesses</a></li>
                            </ul>
                        </li>
            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Sign-up <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu list-group">
                                <li><a href="/volunteer/register">Volunteers</a></li>
                                <li><a href="/organization/register">Organizations</a></li>
                                <li><a href="#">Businesses</a></li>
                            </ul>
                        </li>
            </ul>
             


                @if(Auth::guard('volunteer')->user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::guard('volunteer')->user()->firstName }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu list-group">
                                <li><a href="{{ route('volunteer.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('volunteer.account') }}">Profile</a></li>
                                <li><a href="{{ route('Calender.index') }}">My Events</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('volunteer.logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>


                        </li>
                    @elseif(Auth::guard('organization')->user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::guard('organization')->user()->organization }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu list-group">
                                <li><a href="{{ route('organization.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('organization.account') }}">Profile</a></li>
                                <li><a href="{{ url('/calendar_events/create') }}">Add an Event</a></li>
                                <li><a href="{{ route('calendar_events.index') }}">My Events</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('organization.logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @else
                    
                    @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav> 