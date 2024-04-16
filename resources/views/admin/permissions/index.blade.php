@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Permissions List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Permissions
                </p>
            </div>
            <div>
                @can('Permission Create')
                <a href="{{ route('admin.permissions.create') }}" class="text-white">
                    <button type="button" class="btn btn-primary" >Add Permission</button>
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
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->name ?? ''}}</td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.permissions.show',$permission->id) }}" class="text-success">Details</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    @can('Permission Edit')
                                                    <a class="dropdown-item" href="{{ route('admin.permissions.edit',$permission->id) }}">Edit</a>
                                                    @endcan 
                                                    {{-- @can('Permission Delete')
                                                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <a type="submit" class="dropdown-item" onclick='this.parentNode.submit(); return false;'>Delete</a>
                                                    </form>
                                                    @endcan --}}
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