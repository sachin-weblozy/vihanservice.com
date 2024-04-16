<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ticket Management - Vhan">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Ticket Management - Vihan</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet"> 

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
	<!-- Font Awsome iCon Kit Script -->
	<script src="https://kit.fontawesome.com/5488d9796f.js" crossorigin="anonymous"></script>

	@livewireStyles

	<!-- PLUGINS CSS STYLE -->
	<link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />

	<!-- Data Tables -->
	<link href='{{ asset('assets/plugins/data-tables/datatables.bootstrap5.min.css') }}' rel='stylesheet'>
	<link href='{{ asset('assets/plugins/data-tables/responsive.datatables.min.css') }}' rel='stylesheet'>

	<!-- Ekka CSS -->
	<link id="ekka-css" href="{{ asset('assets/css/ekka.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.css') }}" />

	<!-- FAVICON -->
	<link href="{{ asset('favicon.png') }}" rel="shortcut icon" />

	<!-- Common Javascript -->
	<script src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
	
	
	@role('user')
	<style>
		.ec-content-wrapper{
			background-color: #d2cece !important;
		}
	</style>
	@endrole
</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

	<!--  WRAPPER  -->
	<div class="wrapper">
		
		<!-- LEFT MAIN SIDEBAR -->
		<x-admin.sidebar />

		<!--  PAGE WRAPPER -->
		<div class="ec-page-wrapper">

			<!-- Header -->
			<x-admin.header />
			
			<!-- CONTENT WRAPPER -->
			{{ $slot }}
			
			<!-- End Content Wrapper -->

			<!-- Footer -->
			<footer class="footer mt-auto">
				<div class="copyright bg-white">
					<p>
						Copyright &copy; <span id="ec-year"></span><a class="text-primary"href="#" target="_blank"> Vihan</a>. All Rights Reserved. | Developed by <a class="text-primary"href="#" target="_blank"> Weblozy</a>
					  </p>
				</div>
			</footer>

		</div> <!-- End Page Wrapper -->
	</div> <!-- End Wrapper -->

	@livewireScripts
	
	<!-- Common Javascript -->
	<script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/jquery-zoom/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>

	<!-- Chart -->
	<script src="{{ asset('assets/plugins/charts/Chart.min.js') }}"></script>
	<script src="{{ asset('assets/js/chart.js') }}"></script>

	<!-- Google map chart -->
	<script src="{{ asset('assets/plugins/charts/google-map-loader.js') }}"></script>
	<script src="{{ asset('assets/plugins/charts/google-map.js') }}"></script>

	<!-- Date Range Picker -->
	<script src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/js/date-range.js') }}"></script>

	<!-- Data Tables -->
	<script src='{{ asset('assets/plugins/data-tables/jquery.datatables.min.js') }}'></script>
	<script src='{{ asset('assets/plugins/data-tables/datatables.bootstrap5.min.js') }}'></script>
	<script src='{{ asset('assets/plugins/data-tables/datatables.responsive.min.js') }}'></script>

	<!-- Option Switcher -->
	<script src="{{ asset('assets/plugins/options-sidebar/optionswitcher.js') }}"></script>

	<!-- Ekka Custom -->
	<script src="{{ asset('assets/js/ekka.js') }}"></script>
</body>

</html>