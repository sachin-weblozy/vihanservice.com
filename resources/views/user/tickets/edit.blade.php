@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Edit Ticket</h1>
                <p class="breadcrumbs"><span><a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Edit Ticket</p>
            </div>
            <div>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Edit Ticket</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('user.tickets.update',$ticket->id) }}" method="POST" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name" class="form-label">Executive Name*</label>
                                                <input type="text" class="form-control slug-title" id="name" name="name" value="{{ Auth::user()->name ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone*</label>
                                                <input type="text" class="form-control slug-title" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email" class="form-label">Email*</label>
                                                <input type="email" class="form-control slug-title" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" readonly>
                                            </div>
                                        </div>
                                        <hr><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="machine_model" class="form-label">Installed Machine*</label>
                                                <input type="text" class="form-control slug-title" id="machine_model" name="machine_model" placeholder="Type Machine Model Name" value="{{ old('machine_model',$ticket->machine_model) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="machine_serialno" class="form-label">Machine Serial No*</label>
                                                <input type="text" class="form-control slug-title" id="machine_serialno" name="machine_serialno" placeholder="Type Machine Serial No" value="{{ old('machine_model',$ticket->machine_serial) }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Type of Issue*</label>
                                                <select name="issue_type" id="issue_type" class="form-select form-control">
                                                    @forelse($issueTypes as $issuetype)
                                                    <option value="{{ $issuetype->id }}" @if($issuetype->id == $ticket->issue_type_id) selected @endif>{{ $issuetype->name ?? '' }}</option>
                                                    @empty 
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What is Faulty?</label>
                                                <select name="issue_specifications" id="issue_specifications" class="form-select form-control">
                                                    @forelse($issueSpecs as $issuespecs)
                                                    <option value="{{ $issuespecs->id }}" @if($issuespecs->id == $ticket->issue_specs_id) selected @endif>{{ $issuespecs->name ?? '' }}</option>
                                                    @empty 
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What has failed?</label>
                                                <select name="issue_subspecifications" id="issue_subspecifications" class="form-select form-control">
                                                    @forelse($issueSubSpecs as $issuesubspecs)
                                                    <option value="{{ $issuesubspecs->id }}" @if($issuesubspecs->id == $ticket->issue_subspecs_id) selected @endif>{{ $issuesubspecs->name ?? '' }}</option>
                                                    @empty 
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Issue</label>
                                            <input type="text" class="form-control slug-title" id="title" name="title" placeholder="What is the Issue?" value="{{ old('title',$ticket->title) }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Description/Details*</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Mention the Issue in Detail">{{ old('description',$ticket->description) }}</textarea>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="files" class="form-label">Upload Files (Select Multiple Files)</label>
                                                <input type="file" class="form-control slug-title" id="files" name="files" multiple>
                                            </div>
                                            <div class="col-md-6 icon-box001">
                                                <label for="files" class="form-label">Record Your Voice</label>
                                                <span class="iconbx mdi mdi-microphone px-3"></span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
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
    $(document).ready(function() {
        $('#issue_type').change(function() {
            var issuetypeid = $(this).val();
            
            $.ajax({
                type: "GET",
                url: '/user/fetch-specs/' + issuetypeid,
                success: function(data) {
                    $('#issue_specifications').empty();
                    $('#issue_subspecifications').empty();
                    $('#issue_specifications').append('<option value="" selected disabled>Select</option>');
                    $.each(data, function(key, value) {
                        $('#issue_specifications').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $('#issue_specifications').change(function() {
            var issuespecid = $(this).val();
            
            $.ajax({
                type: "GET",
                url: '/user/fetch-subspecs/' + issuespecid,
                success: function(data) {
                    $('#issue_subspecifications').empty();
                    $('#issue_subspecifications').append('<option value="" selected disabled>Select</option>');
                    $.each(data, function(key, value) {
                        $('#issue_subspecifications').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });

</script>
@endcomponent