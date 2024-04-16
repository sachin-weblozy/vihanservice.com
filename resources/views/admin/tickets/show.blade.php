@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Ticket Details</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('admin.tickets.index') }}">Tickets</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Ticket Details
                </p>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Ticket ID: {{ $ticket->id ?? '' }}</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                @if($ticket->type == 1)
                                                <span class="badge bg-primary">Remote Service Ticket</span>
                                                @elseif($ticket->type == 2)
                                                <span class="badge bg-primary">Installation & Comissioning Ticket</span>
                                                @elseif($ticket->type == 3)
                                                <span class="badge bg-primary">Field Service Ticket</span>
                                                @endif
                                            </div>
                                            <p>Executive Name: {{ $ticket->user->name }}</p>
                                            <p>Executive Phone: {{ $ticket->user->phone }}</p>
                                            <p><span>Executive Email:</span> {{ $ticket->user->email }}</p>
                                            <br>
                                            <h4 class="product-title">Issue Type: {{ $ticket->issuetype->name ?? '' }}</h4>
                                            <h5 class="product-title mt-2">{{ $ticket->issuespec->name ?? '' }}</h5>
                                            <h6 class="product-title mt-2">{{ $ticket->issuesubspec->name ?? '' }}</h6>
                                            <p class="product-rate">
                                                
                                            </p>
                                            <p class="product-desc mt-5">
                                                {{ $ticket->description ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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


                <div class="col-lg-4">
                    @can('Ticket Assign')
                    <div class="card card-default mb-3">
                        <div class="card-header card-header-border-bottom">
                            <h2>Assign Technician</h2>
                        </div>

                        <div class="card-body">
                            <div class="row ec-vendor-uploads">
                                <div class="col-lg-12">
                                    <div class="ec-vendor-upload-detail">
                                        <form class="row g-3" action="{{ route('admin.tickets.assign',$ticket->id) }}" method="POST">
                                            @csrf 
                                            @method('put')
                                            <div class="col-md-12">
                                                @php
                                                    $selectedTechs = $ticket->technicians->pluck('id')->toArray();
                                                @endphp
                                                <label class="form-label">Select Technician</label>
                                                <select name="technicians[]" id="technician" class="form-control selectpicker form-select" multiple data-live-search="true">
                                                    @forelse($technicians as $technician)
                                                        <option value="{{$technician->id}}" @selected(in_array($technician->id, old('users', $selectedTechs)))>{{ $technician->name }}</option>
                                                    @empty 
                                                    <option value="" selected disabled>Select Technician</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-5">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Change Status</h2>
                        </div>
    
                        <div class="card-body">
                            <div class="row ec-vendor-uploads">
                                <div class="col-lg-12">
                                    <div class="ec-vendor-upload-detail">
                                        <form class="row g-3" action="{{ route('admin.tickets.changeStatus',$ticket->id) }}" method="POST">
                                            @csrf 
                                            @method('put')
                                            <div class="col-md-12">
                                                <label class="form-label">Select Status</label>
                                                <select name="status" id="status" class="form-control form-select">
                                                    <option value="1" @if($ticket->status == 1) selected @endif>Created</option>
                                                    <option value="3" @if($ticket->status == 3) selected @endif>InProgress</option>
                                                    <option value="4" @if($ticket->status == 4) selected @endif>Solved</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($ticket->type == 2 || $ticket->type == 3)
                    <div class="card card-default mt-3">
                        <div class="card-header card-header-border-bottom">
                            <h2>Manage Report</h2>
                        </div>
    
                        <div class="card-body">
                            <div class="row ec-vendor-uploads">
                                <div class="col-lg-12">
                                    @if($ticket->report !== null)
                                    <a href="{{ route('admin.tickets.viewReport',$ticket->id) }}" class="text-white">
                                        <button type="button" class="btn btn-primary">
                                            View Report
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.tickets.editReport',$ticket->id) }}" class="text-white">
                                        <button type="button" class="btn btn-primary">
                                            Edit Report
                                        </button>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.tickets.createReport',$ticket->id) }}" class="text-white">
                                        <button type="button" class="btn btn-primary">
                                            Create new Report
                                        </button>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                
            </div>
            <div class="row">

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
    </div>
    <!-- End Content -->
</div>
<script>
    $('select').selectpicker();
</script>
@endcomponent