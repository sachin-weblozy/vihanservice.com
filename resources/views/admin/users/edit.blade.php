@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Edit User</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Edit User</p>
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
                        <h2>Edit User</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.users.update',$user->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full name</label>
                                            <input type="text" class="form-control slug-title" id="name" name="name" value="{{ old('name',$user->name) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control slug-title" id="email" name="email" value="{{ old('email',$user->email) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control slug-title" id="phone" name="phone" value="{{ old('phone',$user->phone) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="company" class="form-label">Company*</label>
                                            <input type="text" class="form-control slug-title" id="company" name="company" placeholder="Enter Company Name"  value="{{ old('company',$user->company) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Select Role</label>
                                            <select name="roles" id="role" class="form-select">
                                                <option value="" selected disabled>Select Role</option>
                                                @forelse($roles as $role)
                                                    @if($role->name!='superadmin')
                                                    <option value="{{$role->name}}" @foreach($user->getRoleNames() as $userrole) @if($role->name == $userrole) selected @endif @endforeach>{{ $role->name }}</option>
                                                    @endif
                                                @empty 
                                                @endforelse
                                            </select>
                                        </div>
                                        {{-- @role('superadmin') --}}
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" class="form-control slug-title" id="password" name="password">
                                        </div>
                                        {{-- @endrole --}}

                                        <div class="col-md-12">
                                            @php
                                                $selectedFiles = $user->files->pluck('id')->toArray();
                                            @endphp
                                            <label class="form-label">Select files to allow access</label>
                                            <select name="files[]" id="files" class="form-control selectpicker form-select" multiple data-live-search="true">
                                                @forelse($files as $file)
                                                    <option value="{{$file->id}}" @selected(in_array($file->id, old('files', $selectedFiles)))>{{ $file->name }}</option>
                                                @empty 
                                                <option value="" selected disabled>Select Files</option>
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
        </div>
    </div> <!-- End Content -->
</div>


<script>
    $('select').selectpicker();
</script>
@endcomponent