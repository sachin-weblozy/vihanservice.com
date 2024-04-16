@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Tickets List</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Tickets
                </p>
            </div>
            <div>
                @can('Ticket Create')
                <a href="{{ route('admin.tickets.create') }}" class="text-white">
                    <button type="button" class="btn btn-primary" >
                        Create new Ticket
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
                                        <th>ID</th>
                                        <th>Vendor</th>
                                        <th>Issue</th>
                                        <th>Raised on</th>
                                        <th>Type</th>
                                        <th>Time Elapsed</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tickets as $ticket)
                                    <tr>
                                        <td>{{$ticket->id ?? ''}}</td>
                                        <td>{{$ticket->user->name ?? ''}}</td>
                                        <td>
                                            @if($ticket->type != 2)
                                            {{$ticket->issuetype->name ?? ''}}
                                            @elseif($ticket->type == 2)
                                                Installation Ticket
                                            @endif
                                        </td>
                                        <td>{{ $ticket->created_at->format('d/m/Y') ?? '' }}</td>
                                        <td>
                                            @if($ticket->type == 1)
                                            <span class="badge bg-primary">Remote Service</span>
                                            @elseif($ticket->type == 2)
                                            <span class="badge bg-primary">Installation & Comissioning</span>
                                            @elseif($ticket->type == 3)
                                            <span class="badge bg-primary">Field Service</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php  $diff_in_hours = $ticket->created_at->diffInHours($ticket->solved_at); @endphp
                                            {{ $diff_in_hours ?? '' }} hrs
                                        </td>
                                        <td>
                                            @if($ticket->status == 1)
                                            <span class="badge bg-danger">Created</span>
                                            @elseif($ticket->status == 2)
                                            <span class="badge bg-info">Assigned</span>
                                            @elseif($ticket->status == 3)
                                            <span class="badge bg-warning">InProgress</span>
                                            @elseif($ticket->status == 4)
                                            <span class="badge bg-success">Solved</span>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse($ticket->technicians as $assignedTechs)
                                            <span class="badge bg-info">{{ $assignedTechs->name ?? '' }}</span>
                                            @empty 
                                            @endforelse
                                        </td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                @can('Ticket Comment')
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.tickets.showComments',$ticket->id) }}" class="text-success">Comments</a></button>
                                                @endcan
                                                <button type="button" class="btn btn-outline-success"><a href="{{ route('admin.tickets.show',$ticket->id) }}" class="text-success">Details</a></button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    @can('Ticket Edit')
                                                    <a class="dropdown-item" href="{{ route('admin.tickets.edit',$ticket->id) }}">Edit</a>
                                                    @endcan
                                                    @can('Ticket Delete')
                                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline">
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