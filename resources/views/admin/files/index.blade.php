@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Files List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Files
                </p>
            </div>
            <div>
                @can('File Create')
                <button type="button" class="btn btn-primary" >
                    <a href="{{ route('admin.files.create') }}" class="text-white">Upload Files</a>
                </button>
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
                                        <th>Sr.No.</th>
                                        <th>Name</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($files as $file)
                                    <tr>
                                        <td>{{ $i ?? '' }}</td>
                                        <td>{{ $file->name ?? '' }}</td>
                                        <td>{{ $file->created_at ?? '' }}</td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.files.show',$file->id) }}" class="text-success" target="_blank">Open</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    {{-- @can('File Edit')
                                                    <a class="dropdown-item" href="{{ route('admin.files.edit',$file->id) }}">Edit</a>
                                                    @endcan  --}}
                                                    @can('File Delete')
                                                    <form action="{{ route('admin.files.destroy', $file) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <a type="submit" class="dropdown-item" onclick='this.parentNode.submit(); return false;'>Delete</a>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
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