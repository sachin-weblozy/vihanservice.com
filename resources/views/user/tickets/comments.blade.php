@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Ticket ID: {{ $ticket->id ?? '' }}</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span><a href="{{ route('user.tickets.index') }}">Tickets</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Ticket Comments
                </p>
            </div>
        </div>
        <div class="card bg-white profile-content">

            <div class="row comment">
                <div class="">
                    <div class="chat_box">
                        <div class="head">
                            <div class="user">
                                <div class="name">
                                    <h4>Issue Type: {{ $ticket->issuetype->name ?? '' }}</h4>
                                    {{-- <p>{{  }}</p> --}}
                                </div>
                            </div>
                            <ul class="bar_tool">
                                <a href="{{ route('user.tickets.index') }}" class="btn btn-primary"> Back</a>
                            </ul>
                        </div>

                        @livewire('comments', ['ticket_id' => $ticket->id])
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Content -->
</div>
@endcomponent