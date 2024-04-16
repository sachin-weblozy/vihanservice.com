@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Edit Video</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Edit Video</p>
            </div>
            <div>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Edit Video</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.videos.update',$video->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-md-12">
                                            <label for="question" class="form-label">Question*</label>
                                            <input type="text" class="form-control slug-title" id="question" name="question" placeholder="Enter Question" value="{{ old('question',$faq->question) }}" required>
                                        </div>
                                        <div class="col-md-12 mb-25">
                                            <label for="answer" class="form-label">Answer*</label>
                                            <textarea id="answer" name="answer" class="form-control" rows="4" placeholder="Enter Answer" required>{{ old('answer',$faq->answer) }}</textarea>
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
            </div>
        </div>
    </div> <!-- End Content -->
</div>


@endcomponent