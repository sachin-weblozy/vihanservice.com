@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Ticket Details</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('user.tickets.index') }}">Tickets</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Ticket Details
                </p>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Ticket ID: {{ $ticket->id ?? '' }}</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <h4 class="product-title">{{ $ticket->issuetype->name ?? '' }}</h4>
                                            <h5 class="product-title mt-2">{{ $ticket->issuespec->name ?? '' }}</h5>
                                            <h6 class="product-title mt-2">{{ $ticket->issuesubspec->name ?? '' }}</h6>
                                            @if($ticket->type == 2)
                                            <p class="product-rate">
                                                Installation Bracket: {{ $ticket->inst_start ?? '' }} - {{ $ticket->inst_end ?? '' }}
                                            </p>
                                            @endif
                                            <p class="product-desc mt-5">
                                                {{ $ticket->description ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card mt-4 trk-order">
								<div class="p-4 text-center text-white text-lg bg-dark rounded-top">
									<span class="text-uppercase">Tracking Order No - </span>
									<span class="text-medium">34VB5540K83</span>
								</div>
								<div
									class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped
											Via:</span> UPS Ground</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span>
										Checking Quality</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Expected
											Date:</span> DEC 09, 2021</div>
								</div>
								<div class="card-body">
									<div
										class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-cart"></i></div>
											</div>
											<h4 class="step-title">Confirmed Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-tumblr-reblog"></i></div>
											</div>
											<h4 class="step-title">Processing Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-gift"></i></div>
											</div>
											<h4 class="step-title">Product Dispatched</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-truck-delivery"></i></div>
											</div>
											<h4 class="step-title">On Delivery</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-hail"></i></div>
											</div>
											<h4 class="step-title">Product Delivered</h4>
										</div>
									</div>
								</div>
							</div> --}}
                        </div>
                    </div>

					<div class="card card-default mt-3">
                        <div class="card-header card-header-border-bottom">
                            <h2>Uploaded Files</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            @forelse($files as $file)
                                            <p><a href="{{ asset('uploads/ticket_files/'.$ticket->id.'/'.basename($file)) }}" target="_blank">{{ basename($file) }}</a></p>
                                            @empty 
                                            No file found 
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- End Content -->
</div>

@endcomponent