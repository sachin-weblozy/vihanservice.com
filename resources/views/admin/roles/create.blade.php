@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Add Role</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Add Role</p>
            </div>
            <div>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Add Role</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.roles.store') }}" method="POST">
                                        @csrf
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Role name</label>
                                            <input type="text" class="form-control slug-title" id="name" name="name">
                                        </div>
                                        <div class="col-md-12 mb-25">
                                            <label class="form-label">Permissions</label>
                                            <div class="form-checkbox-box">
                                                @forelse($permissions as $permission)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="permissions[]" value="{{$permission->name}}">
                                                    <label>{{ $permission->name }}</label>
                                                </div>
                                                @empty 
                                                no permission found, please create new permission 
                                                @endforelse
                                            </div>
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