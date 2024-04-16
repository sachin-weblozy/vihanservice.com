@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Add User</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Add User</p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Add User</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.users.store') }}" method="POST">
                                        @csrf
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full name</label>
                                            <input type="text" class="form-control slug-title" id="name" name="name" placeholder="Full Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control slug-title" id="email" name="email" placeholder="Email ID" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control slug-title" id="phone" name="phone" placeholder="Phone Number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="company" class="form-label">Company</label>
                                            <input type="text" class="form-control slug-title" id="company" name="company" placeholder="Company Name">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" class="form-control slug-title" id="password" name="password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Select Role</label>
                                            <select name="roles" id="role" class="form-select" required>
                                                <option value="" selected disabled>Select Role</option>
                                                @forelse($roles as $role)
                                                    @if($role->name!='superadmin')
                                                    <option value="{{$role->name}}">{{ $role->name }}</option>
                                                    @endif
                                                @empty 
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Select files to allow access</label>
                                            <select name="files[]" id="files" class="form-control selectpicker form-select" multiple data-live-search="true" style="border:1px solid #eeeeee;">
                                                @forelse($files as $file)
                                                    <option value="{{$file->id}}">{{ $file->name }}</option>
                                                @empty 
                                                <option value="" selected disabled>Select Files</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-4">
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
    $('select').selectpicker();
</script>
@endcomponent