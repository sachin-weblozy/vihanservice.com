@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>{{ $issuetype->name }}</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('admin.issue-types.index') }}">Issue Types</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('admin.issue-types.show',$issuetype->id) }}">Specifications</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Specifications List
                </p>
            </div>
            <div>
                @can('Category Create')
                <a href="{{ route('admin.issue-types.subspecs.create',['issueid'=>$issuetype->id,'specsid'=>$spec->id]) }}" class="text-white">
                    <button type="button" class="btn btn-primary" >
                        Add SubSpecification
                    </button>
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
                                        <th>Sr.No.</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($subspecs as $subspec)
                                    <tr>
                                        <td>{{$i ?? ''}}</td>
                                        <td>
                                            {{$subspec->name ?? ''}}
                                        </td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.issue-types.subspecs.edit',['issueid'=>$issuetype->id,'specsid'=>$spec->id,'subspecid'=>$subspec->id]) }}" class="text-success">Edit</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('Category Delete')
                                                    <form action="{{ route('admin.issue-types.subspecs.destroy', $subspec->id) }}" method="POST" class="inline">
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