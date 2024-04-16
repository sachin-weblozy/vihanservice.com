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
        <div class="card bg-white profile-content">
            <div class="row">
                @can('Ticket Assign')
                <div class="col-lg-8">
                @else 
                <div class="col-lg-12">
                @endcan
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Ticket ID: {{ $ticket->id ?? '' }}</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <h5 class="product-title">{{ $ticket->title ?? '' }}</h5>
                                            <p class="product-rate">
                                                
                                            </p>
                                            <p class="product-desc">
                                                {{ $ticket->description ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @can('Ticket Assign')
                <div class="col-lg-4">
                    <div class="card card-default">
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
                </div>
                @endcan
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
    </div> <!-- End Content -->
</div>
<script>
    $('select').selectpicker();
</script>
@endcomponent