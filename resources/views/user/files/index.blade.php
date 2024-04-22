@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Files</h1>
                <p class="breadcrumbs"><span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Files
                </p>
            </div>
        </div>
        <div class="row">
            @forelse($files as $file)
            <div class="col-lg-6 col-xl-6 mb-24px">
                <div class="ec-user-card card card-default p-4">
                    <a href="{{ route('user.files.show',encrypt($file->id)) }}" class="view-detail"></a>
                    <a href="{{ route('user.files.show',encrypt($file->id)) }}" target="_blank" class="media text-secondary">
                        <img src="{{ asset('assets/img/user/file.png') }}" class="mr-3 img-fluid" alt="file">

                        <div class="media-body">
                            <h5 class="mt-3 mb-2 text-dark">{{ $file->name ?? '' }}</h5>

                            <ul class="list-unstyled">
                                <li class="d-flex mb-1">
                                    <i class="mdi mdi-update mr-1"></i>
                                    <span>{{ $file->created_at ?? '' }}</span>
                                </li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            No File Found
            @endforelse
        </div>
    </div>
    
    <!-- End Content -->
</div>


@endcomponent