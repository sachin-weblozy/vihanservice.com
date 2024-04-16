@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>User List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>User
                </p>
            </div>
            <div>
                @can('User Create')
                <a href="{{ route('admin.users.create') }}" class="text-white">
                    <button type="button" class="btn btn-primary" >Add User</button>
                </a>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="ec-vendor-list card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="responsive-data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Join On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td><img class="vendor-thumb" src="{{ $user->profile_photo_url ?? '' }}" alt="user profile" /></td>
                                        <td>{{$user->name ?? ''}}</td>
                                        <td>{{$user->email ?? ''}}</td>
                                        <td>{{$user->phone ?? ''}}</td>
                                        <td>
                                            @forelse($user->getRoleNames() as $role)
                                            <span class="badge bg-primary">{{$role}}</span>
                                            @empty
                                            @endforelse
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.users.show',$user->id) }}" class="text-success">Details</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    @can('User Edit')
                                                    <a class="dropdown-item" href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
                                                    @endcan
                                                    @can('User Delete')
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <a type="submit" class="dropdown-item" onclick='this.parentNode.submit(); return false;'>Delete</a>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</div>


@endcomponent