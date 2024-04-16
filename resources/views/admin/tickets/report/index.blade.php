@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Reports List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Tickets
                </p>
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
                                        <th>TicketID</th>
                                        <th>Ticket Number</th>
                                        <th>Last Updated</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($reports as $report)
                                    <tr>
                                        <td>{{$i ?? ''}}</td>
                                        <td>{{$report->ticket_id ?? ''}}</td>
                                        <td>{{$report->report_number ?? ''}}</td>
                                        <td>{{ $report->updated_at->format('d M, Y') ?? '' }}</td>
                                        <td>
                                            @if($report->type == 1)
                                            <span class="badge bg-primary">Remote Service</span>
                                            @elseif($report->type == 2)
                                            <span class="badge bg-primary">Installation & Comissioning</span>
                                            @elseif($report->type == 3)
                                            <span class="badge bg-primary">Field Service</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.tickets.viewReport', $report->ticket_id) }}" class="text-success">View</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('admin.tickets.editReport', $report->ticket_id) }}">Edit</a>
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