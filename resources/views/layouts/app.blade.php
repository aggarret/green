<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>@yield('title')</title>

	    <!-- Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Jaldi|Shrikhand" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Heebo:100" rel="stylesheet">

	    <!-- bootstrap 3.3.7-->
	    <link href="{{ URL::to('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
	    @yield('head')
	</head>


	<body id="app-layout">
		<div class="main-body">
			@include('includes.messages')

		    @yield('content')
	    </div>


	    <!-- jquery 3.1.1-->
		<script src="{{ URL::to('assets/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
		
		<!-- custom jquery code-->
		 @yield('script')
	</body>
</html>
