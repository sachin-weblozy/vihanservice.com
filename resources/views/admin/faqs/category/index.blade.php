@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>FAQ Categories List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>FAQs
                </p>
            </div>
            <div>
                @can('FAQ Create')
                <button type="button" class="btn btn-primary" >
                    <a href="{{ route('admin.faq-categories.create') }}" class="text-white">Add FAQ Category</a>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($faqs as $faq)
                                    <tr>
                                        <td>{{ $i ?? '' }}</td>
                                        <td>{{ $faq->name ?? '' }}</td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success"><a href="#" class="text-success">More</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    @can('FAQ Edit')
                                                    <a class="dropdown-item" href="{{ route('admin.faq-categories.edit',$faq->id) }}">Edit</a>
                                                    @endcan 
                                                    @can('FAQ Delete')
                                                    <form action="{{ route('admin.faq-categories.destroy', $faq) }}" method="POST" class="inline">
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