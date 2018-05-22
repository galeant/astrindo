<!DOCTYPE HTML>
<!--
	Aesthetic by gettemplates.co
	Twitter: http://twitter.com/gettemplateco
	URL: http://gettemplates.co
-->
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="{{ URL::asset('images/200x200.png') }}" type="image/x-icon">
	<title>ASTRINDO &mdash; Indonesia Travel Exchange</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="GetTemplates.co" />

	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{ URL::asset('css/icomoon.css') }}">
	<!-- Themify Icons-->
	<link rel="stylesheet" href="{{ URL::asset('css/themify-icons.css') }}">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="{{ URL::asset('css/magnific-popup.css') }}">

	<!-- Magnific Popup -->
	<!-- <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}"> -->

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/owl.theme.default.min.css') }}">

	<!-- Theme style  -->
	<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

	<!-- Modernizr JS -->
	<script src="{{ URL::asset('js/modernizr-2.6.2.min.js') }}"></script>

	<!-- DatePicker -->
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker.standalone.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker.standalone.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker3.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker3.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker3.standalone.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker/css/bootstrap-datepicker3.standalone.min.css') }}">

	<script src="{{ URL::asset('js/datepicker/js/bootstrap-datepicker.js') }}"></script>	
	<script src="{{ URL::asset('js/datepicker/js/bootstrap-datepicker.min.js') }}"></script>	
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<nav class="navbar navbar-transparent navbar-static-top" id="myNavbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ URL('/') }}"><img src="{{ URL::asset('images/logo2.png') }}"/ width="150px"></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ URL('tipe/Tours') }}">Tour</a></li>
					<li><a href="{{ URL('tipe/Events')}}">Event</a></li>
					<li><a href="{{ URL('tipe/Accommodation')}}">Accomodation</a></li>
					<li><a href="{{ URL('tipe/Attractions')}}">Attraction</a></li>
					<li><a href="{{ URL('contact')}}">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>
