@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>FAQ Detail</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>FAQ Detail
                </p>
            </div>
            <div>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>{{ $faq->question ?? '' }}</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <h5>{{ $faq->answer ?? '' }}</h5>
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