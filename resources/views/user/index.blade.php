@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
	<div class="content">
		<!-- Top Statistics -->
		<div class="row">
			<h1>Welcome, {{ Auth::user()->name }}</h1>
		</div>

		<div class="row mt-5">
			<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
				<a href="{{ route('user.tickets.create') }}">
					<div class="card card-mini dash-card create-card card-1 bg-primary">
						<div class="card-body">
							<span class="mdi mdi-message-plus"></span>
							<h2 class="text-white">Create Ticket</h2>
							<p class="text-white">Click to create ticket</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-1">
					<div class="card-body">
						<h2 class="mb-1">{{ $unsolvedCount }}</h2>
						<p>Unsolved Tickets</p>
						<span class="mdi mdi-ticket-outline"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-2">
					<div class="card-body">
						<h2 class="mb-1">{{ $solvedCount }}</h2>
						<p>Solved Tickets</p>
						<span class="mdi mdi-check-decagram"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
				<div class="card card-mini dash-card card-3">
					<div class="card-body">
						<h2 class="mb-1">{{ $totalCount }}</h2>
						<p>Total Tickets</p>
						<span class="mdi mdi-ticket"></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12 p-b-15">
				<div class="card card-table-border-none card-default recent-orders" id="recent-orders">
					<div class="card-header justify-content-between">
						<h2>Recent Tickets</h2>
						<div class="date-range-report">
							<a href="{{ route('user.tickets.index') }}" class="text-white">
								<button type="button" class="btn btn-primary" >View All</button>
							</a>
						</div>
					</div>
					<div class="card-body pt-0 pb-5">
						<table class="table card-table table-responsive table-responsive-large"
							style="width:100%">
							<thead>
								<tr>
									<th>Ticket ID</th>
									<th>Issue</th>
									<th class="d-none d-lg-table-cell">Assigned To</th>
									<th class="d-none d-lg-table-cell">Raised on</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($recentTickets as $ticket) 
								<tr>
									<td>{{$ticket->id ?? ''}}</td>
									<td>
										@if($ticket->type != 2)
										{{$ticket->issuetype->name ?? ''}}
										@elseif($ticket->type == 2)
											Installation Ticket
										@endif	
									</td>
									<td class="d-none d-lg-table-cell">
										@forelse($ticket->technicians as $assignedTechs)
                                            <span class="badge bg-info">{{ $assignedTechs->name ?? '' }}</span>
										@empty 
										@endforelse
									</td>
									<td class="d-none d-lg-table-cell">{{ $ticket->created_at->format('d M, Y') ?? '' }}</td>
									<td>
										@if($ticket->status == 1)
										<span class="badge bg-danger">Created</span>
										@elseif($ticket->status == 2)
										<span class="badge bg-info">Assigned</span>
										@elseif($ticket->status == 3)
										<span class="badge bg-warning">InProgress</span>
										@elseif($ticket->status == 4)
										<span class="badge bg-success">Solved</span>
										@endif
									</td>
									<td>
										<div class="btn-group mb-1">
											@can('Ticket Comment')
											<a href="{{ route('user.tickets.showComments',encrypt($ticket->id)) }}" class="text-success">
												<button type="button" class="btn btn-outline-success py-1">Comments</button>
											</a>
											@endcan
										</div>
									</td>
								</tr>
								@empty 
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- End Content -->
</div>


@endcomponent