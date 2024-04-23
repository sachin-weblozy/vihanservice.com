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
                <a href="{{ route('user.tickets.index') }}" class="btn btn-primary"> View All
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Edit Ticket ID: {{ $ticket->id ?? '' }}</h2>
                    </div>
                    @if(old('type')==2)
                    <script>
                        $(document).ready(function() {
                            $('.type2').addClass('d-none');
                            $('.type0').removeClass('d-none');
                        });
                    </script>
                    @endif
                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('user.tickets.update',encrypt($ticket->id)) }}" method="POST" id="audioForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="name" class="form-label">Executive Name*</label>
                                                <input type="text" class="form-control slug-title" id="name" name="name" value="{{ old('name') ?? $ticket->user->name }}" placeholder="Full Name" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="phone" class="form-label">Phone*</label>
                                                <input type="text" class="form-control slug-title" id="phone" name="phone" value="{{ old('phone') ?? $ticket->user->phone }}" placeholder="Phone Number" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="email" class="form-label">Email*</label>
                                                <input type="email" class="form-control slug-title" id="email" name="email" value="{{ old('email') ?? $ticket->user->email }}" placeholder="Email Address" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="company" class="form-label">Company*</label>
                                                <input type="text" class="form-control slug-title" id="company" name="company" value="{{ old('company') ?? $ticket->user->company }}" placeholder="Enter Company Name" readonly>
                                            </div>
                                        </div>
                                        <hr><br>

                                        @if($ticket->type !=2)
                                        <div class="row type2">
                                            <div class="col-md-6">
                                                <label for="machine_model" class="form-label">Installed Machine*</label>
                                                <input type="text" class="form-control slug-title" id="machine_model" name="machine_model" value="{{ old('machine_model') ?? $ticket->machine_model }}" placeholder="Type Machine Model Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="machine_serialno" class="form-label">Machine Serial No*</label>
                                                <input type="text" class="form-control slug-title" id="machine_serialno" name="machine_serialno" value="{{ old('machine_serialno') ?? $ticket->machine_serial }}" placeholder="Type Machine Serial No">
                                            </div>
                                        </div>

                                        <div class="row type2">
                                            <div class="col-md-4">
                                                <label class="form-label">Type of Issue*</label>
                                                <select name="issue_type" id="issue_type" class="form-select form-control">
                                                    <option value="" selected disabled>Select</option>
                                                    @forelse($issueTypes as $issuetype)
                                                    <option value="{{ $issuetype->id }}" @if($ticket->issue_type_id == $issuetype->id) selected @endif>{{ $issuetype->name ?? '' }}</option>
                                                    @empty 
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What is the Fault?</label>
                                                <select name="issue_specifications" id="issue_specifications" class="form-select form-control">
                                                    <option value="{{ $ticket->issue_specs_id }}" @if($ticket->issue_specs_id == $issuetype->id) selected @endif>{{ $ticket->issuespec->name ?? '' }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">What has failed?</label>
                                                <select name="issue_subspecifications" id="issue_subspecifications" class="form-select form-control">
                                                    <option value="{{ $issuetype->id }}" @if($ticket->issue_subspecs_id == $issuetype->id) selected @endif>{{ $ticket->issuesubspec->name ?? '' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 type2">
                                            <label for="name" class="form-label">Issue</label>
                                            <input type="text" class="form-control slug-title" id="title" name="title" placeholder="What is the Issue?" value="{{ old('title') ?? $ticket->title }}">
                                        </div>
                                        @endif
                                        @if($ticket->type ==2)
                                        <div class="row type0">
                                            <label class="form-label">Installation Date</label>
                                            <div class="col-md-6">
                                                <label class="form-label">From?</label>
                                                <input type="date" id="inst-start-date" name="inst_start_date" value="{{ $ticket->inst_start ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">To?</label>
                                                <input type="date" id="inst-end-date" name="inst_end_date" value="{{ $ticket->inst_end ?? '' }}">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12">
                                            <label class="form-label">Description/Details*</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Mention the Issue in Detail">{{ old('description') ?? $ticket->description }}</textarea>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="files" class="form-label">Upload Files (Select Multiple Files)</label>
                                                <input type="file" class="form-control slug-title mb-0" id="files" name="files[]" multiple>
                                                <small class="mt-0">Add more files</small>
                                                <p>Uploaded Files:</p>
                                                @forelse($files as $file)
                                                <p><a href="{{ asset('uploads/ticket_files/'.$ticket->id.'/'.basename($file)) }}" target="_blank">{{ basename($file) }}</a></p>
                                                @empty 
                                                No file found 
                                                @endforelse
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

    document.addEventListener('DOMContentLoaded', function() {
        const uploadForm = document.getElementById('uploadForm');
        const progressBar = document.getElementById('progressBar');
    
        uploadForm.addEventListener('submit', function(event) {
            event.preventDefault();
    
            const formData = new FormData(this);
    
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/upload');
    
            xhr.upload.addEventListener('progress', function(event) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBar.style.width = percentComplete + '%';
            });
    
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Files uploaded successfully!');
                    } else {
                        alert('Upload failed: ' + response.message);
                    }
                } else {
                    alert('Upload failed: ' + xhr.statusText);
                }
            };
    
            xhr.onerror = function() {
                alert('Network error occurred.');
            };
    
            xhr.send(formData);
        });
    });
    
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
                $('.type0').removeClass('d-none');
            } else {
                $('.type2').removeClass('d-none');
                $('.type0').addClass('d-none');
            }
            });

            var today = new Date().toISOString().split('T')[0];
            document.getElementById("inst-start-date").setAttribute("min", today);
            document.getElementById("inst-end-date").setAttribute("min", today);
            document.getElementById("inst-start-date").addEventListener("change", function() {
                // When the start date changes, update the minimum date of the end date input
                var startDate = document.getElementById("inst-start-date").value;
                document.getElementById("inst-end-date").setAttribute("min", startDate);
            });
        });
    
    
        $(document).ready(function() {
            $('#issue_type').change(function() {
                var issuetypeid = $(this).val();
                
                $.ajax({
                    type: "GET",
                    url: '/admin/fetch-specs/' + issuetypeid,
                    success: function(data) {
                        $('#issue_specifications').empty();
                        $('#issue_subspecifications').empty();
                        $('#issue_specifications').append('<option value="" selected disabled>Select</option>');
                        $('#issue_subspecifications').append('<option value="" selected disabled>Select</option>');
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
                    url: '/admin/fetch-subspecs/' + issuespecid,
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