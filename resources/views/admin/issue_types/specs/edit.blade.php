@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>{{ $specification->name }}</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('admin.issue-types.index') }}">Issue Types</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('admin.issue-types.show',$issuetype->id) }}">{{ $issuetype->name }}</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Edit Specification
                </p>
            </div>
            <div>
                <a href="{{ route('admin.issue-types.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Edit Specification</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.issue-types.specs.update',$specification->id) }}" method="POST" id="myForm">
                                        @csrf
                                        @method('put')
                                        <div class="col-md-12">
                                            <label for="specs" class="form-label">Specification</label>
                                            <input type="text" class="form-control slug-title" id="specs" name="specs" value="{{ old('specs') ?? $specification->name }}">
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
        </div>
    </div> <!-- End Content -->
</div>

<script>
    function addInput() {
        var inputContainer = document.getElementById('inputContainer');
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'subspecs[]'; // Using array notation to capture multiple inputs
        input.placeholder = 'Enter sub specification';
        inputContainer.appendChild(input);
        inputContainer.appendChild(document.createElement('br')); // Adding a line break for spacing
    }
</script>
@endcomponent