<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

		<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
		
		<!-- Ekka CSS -->
		<link id="ekka-css" rel="stylesheet" href="{{ asset('assets/css/ekka.css') }}" />
		
		<!-- FAVICON -->
		<link href="{{ asset('assets/img/favicon.png') }}" rel="shortcut icon" />
	</head>
	
	<body class="sign-inup" id="body" style="background-image: linear-gradient(to right top, #051937, #0b4066, #046b96, #009bc3, #12cdeb);">

		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			{{ $slot }}
		</div>
	
		<!-- Javascript -->
		<script src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/jquery-zoom/jquery.zoom.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
	
		<!-- Ekka Custom -->	
		<script src="{{ asset('assets/js/ekka.js') }}"></script>
	</body>
</html>