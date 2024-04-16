<div>
    @if($unassignedTickets->isNotEmpty())
    <li class="dropdown notifications-menu custom-dropdown">
        <button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
            <i class="mdi mdi-ticket-outline"></i>
        </button>

        <div class="card card-default dropdown-notify dropdown-menu-right mb-0">
            <div class="card-header card-header-border-bottom px-3">
                <h2>Tickets waiting to be assigned</h2>
            </div>

            <div class="card-body px-0 py-0">

                <div class="tab-content" id="myNotifications">
                    <div class="tab-pane fade show active" id="home2" role="tabpanel">
                        <ul class="list-unstyled" data-simplebar style="height: 360px">
                            @forelse ($unassignedTickets as $ticket)
                            <li>
                                <div class="media media-message media-notification">

                                    <div
                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                        <i
                                            class="mdi mdi-ticket-outline font-size-20"></i>
                                    </div>

                                    <div class="media-body d-flex justify-content-between">
                                        <div class="message-contents">
                                            <h4 class="title">{{ $ticket->issuetype->name ?? '' }}</h4>
                                            {{-- <p class="last-msg font-size-14">Add Dany Jones as your contact consequat nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim.</p> --}}

                                            <a href="javscript:void(0)" wire:click="assignTicket({{ $ticket->id }})"><span class="my-1 btn btn-sm btn-success">Accept</span></a>
                                            

                                            <span
                                                class="font-size-12 font-weight-medium text-secondary d-block">
                                                <i class="mdi mdi-clock-outline"></i>
                                                @php  $created = $ticket->created_at->diffInMinutes(now()); @endphp
                                                @if($created<120)
                                                {{ $created ?? '' }} mins ago...
                                                @else
                                                @php  $created = $ticket->created_at->diffInHours(now()); @endphp
                                                {{ $created ?? '' }} hrs ago...
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endif
</div>
