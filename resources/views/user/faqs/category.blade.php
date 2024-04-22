@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Select Category</h1>
                <p class="breadcrumbs"><span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>FAQs
                </p>
            </div>
        </div>
        <div class="row">
            
            @forelse($faqs as $faq)
                <div class="col-12">
					<div class="ec-user-card card card-default p-4 mb-3">
                        <a href="{{ route('user.faqs.show', encrypt($faq->id)) }}" class="view-detail"></a>
                        <a href="{{ route('user.faqs.show', encrypt($faq->id)) }}" class="media text-secondary">
    
                            <div class="media-body">
                                <h5 class="mt-2 mb-2 text-dark">{{ $faq->name }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
            No Category found
            @endforelse
        </div>
    </div>
    
    <!-- End Content -->
</div>


@endcomponent