@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>FAQs for {{ $faqcategory->name ?? '' }}</h1>
                <p class="breadcrumbs"><span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>FAQs Category
                    <span><i class="mdi mdi-chevron-right"></i></span>FAQs for {{ $faqcategory->name ?? '' }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
					@php $i=1; @endphp
					@forelse($faqs as $faq)
					<div class="accordion-item my-3">
					  <h2 class="accordion-header" id="heading{{ $faq->id }}">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="@if($i==1)true @else false @endif" aria-controls="collapse{{ $faq->id }}">
						  {{ $faq->question }}
						</button>
					  </h2>
					  <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse @if($i==1)show @endif" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							{{ $faq->answer }}
						</div>
					  </div>
					</div>
					@php $i++; @endphp
					@empty
					No FAQ found
					@endforelse
				</div>
            </div>
        </div>
    </div>
    
    <!-- End Content -->
</div>


@endcomponent