@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to User Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Create New Ticket</h1>
                <p class="breadcrumbs"><span>
                    <a href="{{ route('user.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Create New Ticket
                </p>
            </div>
            <div>
                <a href="{{ route('user.tickets.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Create New Ticket</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data">
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
                                        
                                        <div class="row mb-5">
                                            <label for="machine_model" class="form-label">Select Ticket Type*</label>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="type" id="remote" value="1" checked>
                                                    <label class="form-check-label" for="remote">Remote Service Ticket</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="type" id="ic" value="2">
                                                    <label class="form-check-label" for="ic">Installation and Commissioning Ticket</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="type" id="fs" value="3">
                                                    <label class="form-check-label" for="fs">Field Service Ticket</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr><br>
                                        
                                        <div class="row type2">
                                            <div class="col-md-6">
                                                <label for="machine_model" class="form-label">Installed Machine*</label>
                                                <input type="text" class="form-control slug-title" id="machine_model" name="machine_model" placeholder="Type Machine Model Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="machine_serialno" class="form-label">Machine Serial No*</label>
                                                <input type="text" class="form-control slug-title" id="machine_serialno" name="machine_serialno" placeholder="Type Machine Serial No">
                                            </div>
                                        </div>

                                        <div class="row type2">
                                            <div class="col-md-4">
                                                <label class="form-label">Type of Issue*</label>
                                                <select name="issue_type" id="issue_type" class="form-select form-control">
                                                    <option value="" selected disabled>Select</option>
                                                    @forelse($issueTypes as $issuetype)
                                                    <option value="{{ $issuetype->id }}">{{ $issuetype->name ?? '' }}</option>
                                                    @empty 
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What is Faulty?</label>
                                                <select name="issue_specifications" id="issue_specifications" class="form-select form-control">
                                                    <option value="" selected disabled>Select</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What has failed?</label>
                                                <select name="issue_subspecifications" id="issue_subspecifications" class="form-select form-control">
                                                    <option value="" selected disabled>Select</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 type2">
                                            <label for="name" class="form-label">Issue</label>
                                            <input type="text" class="form-control slug-title" id="title" name="title" placeholder="What is the Issue?">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Description/Details*</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Mention the Issue in Detail"></textarea>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="files" class="form-label">Upload Files (Select Multiple Files)</label>
                                                <input type="file" class="form-control slug-title" id="files" name="files[]" multiple>
                                                <div id="progressBar"></div>
                                            </div>
                                            <div class="col-md-6 icon-box001">
                                                <label for="recAudio" class="form-label">Record your voice (explain the issue)</label>
                                                <div class="d-flex">
                                                    <span id="startRecording" class="mdi mdi-microphone" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Start Recording"></span>
                                                    <span id="stopRecording" class="mdi mdi-microphone-off" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Stop Recording"></span>
                                                    <span id="downloadRecording" class="mdi mdi-download" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Download Recording"></span>
                                                    <input type="file" class="form-control slug-title" name="recAudio" id="recAudio">
                                                </div>
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

const startRecordingButton = document.getElementById('startRecording');
        const stopRecordingButton = document.getElementById('stopRecording');
        const downloadRecordingButton = document.getElementById('downloadRecording');
        const recAudioInput = document.getElementById('recAudio');

        let recorder, audioChunks = [];

        startRecordingButton.addEventListener('click', async () => {
            event.preventDefault();
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                recorder = new MediaRecorder(stream);
                recorder.ondataavailable = (e) => {
                    audioChunks.push(e.data);
                };
                recorder.start();
                startRecordingButton.disabled = true;
                stopRecordingButton.disabled = false;
            } catch(err) {
                console.error("Error accessing microphone:", err);
            }
        });

        stopRecordingButton.addEventListener('click', () => {
            event.preventDefault();
            recorder.stop();
            stopRecordingButton.disabled = true;
            downloadRecordingButton.disabled = false;
        });

        downloadRecordingButton.addEventListener('click', () => {
            event.preventDefault();
            const blob = new Blob(audioChunks, { type: 'audio/webm' });
            const url = window.URL.createObjectURL(blob);
            const filename = 'recording.webm';
            const link = document.createElement('a');
            console.log(link);
            link.href = url;
            link.download = filename;
            link.click();
        });

    
    $(document).ready(function() {
        $('input[name="type"]').click(function() {
            var selectedOption = $(this).val();
            if (selectedOption == 2) {
                $('.type2').addClass('d-none');
            } else {
                $('.type2').removeClass('d-none');
            }
        });
    });

    $(document).ready(function() {
        $('#issue_type').change(function() {
            var issuetypeid = $(this).val();
            
            $.ajax({
                type: "GET",
                url: '/user/fetch-specs/' + issuetypeid,
                success: function(data) {
                    $('#issue_specifications').empty();
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