@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
	<div class="content">
		<div class="row">
			<h1>Welcome, {{ Auth::user()->name }}</h1>
		</div>
		<!-- Top Statistics -->
		<div class="row mt-5">
			<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-1">
					<div class="card-body">
						<h2 class="mb-1">{{ $unsolvedCount }}</h2>
						<p>Unsolved Tickets</p>
						<span class="mdi mdi-ticket-outline"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-2">
					<div class="card-body">
						<h2 class="mb-1">{{ $solvedCount }}</h2>
						<p>Solved Tickets</p>
						<span class="mdi mdi-check-decagram"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-4">
					<div class="card-body">
						<h2 class="mb-1">{{ $totalCount }}</h2>
						<p>Total Users</p>
						<span class="mdi mdi-account"></span>
					</div>
				</div>
			</div>
		</div>

		@role('superadmin')
		<div class="row">
			<div class="col-xl-8 col-md-12 p-b-15">
				<!-- User activity statistics -->
				<div class="card card-default" id="user-activity">
					<div class="no-gutters">
						<div>
							<div class="card-header justify-content-between">
								<h2>Ticket Activity</h2>
							</div>
							<div class="card-body">
								<div class="tab-content" id="userActivityContent"> 
									<div class="tab-pane fade show active" id="user" role="tabpanel">
										<canvas id="tickets" class="chartjs" height="240px"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-4 col-md-12 p-b-15">
				<!-- Doughnut Chart -->
				<div class="card card-default">
					<div class="card-header justify-content-center">
						<h2>Tickets Overview</h2>
					</div>
					<div class="card-body">
						<canvas id="ticketOverview"></canvas>
					</div>
					<div class="card-footer d-flex flex-wrap bg-white p-0">
						<div class="col-12">
							<div class="p-20">
								<ul class="d-flex flex-column justify-content-between">
									<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
											style="color: #ed9090"></i>New Tickets</li>
									<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
											style="color: #f3d676"></i>Tickets InProgress</li>
									<li><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
											style="color: #50d7ab"></i>Tickets Solved</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endrole
		
		@role('admin')
		<div class="row">
			<div class="col-xl-12 col-md-12 p-b-15">
				<div class="card card-default">
					<div class="card-header flex-column align-items-start">
						<h2>Current Users</h2>
					</div>
					<div class="card-body">
						<canvas id="currentUser" class="chartjs"></canvas>
					</div>
					<div class="card-footer d-flex flex-wrap bg-white border-top">
						<a href="#" class="text-uppercase py-3">In-Detail Overview</a>
					</div>
				</div>
			</div>
		</div>
		@endrole
	</div>
	<!-- End Content -->
</div>

<x-admin.charts />
@endcomponent

