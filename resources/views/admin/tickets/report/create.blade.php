@component('layouts.admin', [
    'pretitle' => 'Dashboard',
    'pagetitle' => 'Welcome to Admin Dashboard'
])

<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Create New Report</h1>
                <p class="breadcrumbs"><span>
                    <a href="{{ route('admin.dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    Create New Report
                </p>
            </div>
            <div>
                {{-- <a href="{{ route('admin.users.index') }}" class="btn btn-primary"> View Ticket Details</a> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Create New Report | Ticket ID: {{ $ticket->id }}</h2>
                    </div>

                    <div class="card-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-12">
                                <div class="ec-vendor-upload-detail">
                                    <form class="row g-3" action="{{ route('admin.tickets.storeReport') }}" method="POST" id="audioForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="ticketid" value="{{ $ticket->id }}">
                                            <div class="col-md-6">
                                                <label for="machine_model" class="form-label">Installed Machine*</label>
                                                <input type="text" class="form-control slug-title" id="machine_model" name="machine_model" placeholder="Type Machine Model Name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="machine_serialno" class="form-label">Machine Serial No*</label>
                                                <input type="text" class="form-control slug-title" id="machine_serialno" name="machine_serialno" placeholder="Type Machine Serial No" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="name" class="form-label">Customer Name*</label>
                                                <input type="text" class="form-control slug-title" id="name" name="name" value="{{ $ticket->user->name ?? '' }}" placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <hr><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="invoice_number" class="form-label">Invoice Number(if any)</label>
                                                <input type="text" class="form-control slug-title" id="invoice_number" name="invoice_number" placeholder="Type Invoice Number">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="invoice_date" class="form-label">Date</label>
                                                <input type="date" class="form-control slug-title" id="invoice_date" name="invoice_date">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="purchase_order_number" class="form-label">Purchase Order Number(if any)</label>
                                                <input type="text" class="form-control slug-title" id="purchase_order_number" name="purchase_order_number" placeholder="Type Purchase Order Number">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="purchase_order_date" class="form-label">Date</label>
                                                <input type="date" class="form-control slug-title" id="purchase_order_date" name="purchase_order_date">
                                            </div>
                                        </div>

                                        @if($ticket->type == 3)
                                        <div class="row mb-5">
                                            <label for="machine_model" class="form-label">Mode of Service?</label>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="service_mode" id="onfield" value="1" checked>
                                                    <label class="form-check-label" for="onfield">On Field</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="service_mode" id="phonesupport" value="2">
                                                    <label class="form-check-label" for="phonesupport">Phone Support</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="service_mode" id="remoteconnect" value="3">
                                                    <label class="form-check-label" for="remoteconnect">Remote Connect</label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="asset_number" class="form-label">Asset Number(if any)</label>
                                                <input type="text" class="form-control slug-title" id="asset_number" name="asset_number" placeholder="Type Asset Number">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($ticket->type ==2)
                                                <label for="installation_date" class="form-label">Date of Installation*</label>
                                                @elseif($ticket->type ==3)
                                                <label for="installation_date" class="form-label">Date of Service*</label>
                                                @endif
                                                <input type="date" class="form-control slug-title" id="installation_date" name="installation_date">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="location" class="form-label">Location</label>
                                                <input type="text" class="form-control slug-title" id="location" name="location" placeholder="Type Location">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="machine_model" class="form-label">Is machine under warranty?</label>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="warranty" id="remote" value="1" checked>
                                                    <label class="form-check-label" for="remote">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="warranty" id="ic" value="2">
                                                    <label class="form-check-label" for="ic">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            @if($ticket->type ==2)
                                            <label for="machine_model" class="form-label">AMC Required?</label>
                                            @elseif($ticket->type ==3)
                                            <label for="machine_model" class="form-label">AMC Present?</label>
                                            @endif
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="amc" id="remote" value="1" checked>
                                                    <label class="form-check-label" for="remote">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="" type="radio" name="amc" id="ic" value="2">
                                                    <label class="form-check-label" for="ic">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12 mb-3">
                                            @if($ticket->type ==2)
                                            <label for="machine_model" class="form-label">Installation Notes</label>
                                            @elseif($ticket->type ==3)
                                            <label for="machine_model" class="form-label">Services Performed</label>
                                            @endif
                                            <textarea class="form-control" rows="3" name="installation_note" id="tinymce-default"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="machine_model" class="form-label">Spare Parts Required?</label>
                                            <textarea class="form-control" rows="3" name="spare_parts" id="tinymce-default"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="machine_model" class="form-label">Customer Notes</label>
                                            <textarea class="form-control" rows="3" name="customer_notes" id="tinymce-default"></textarea>
                                        </div>

                                        <div class="row mt-5">
                                            <label for="" class="form-label">Vihan Service Engineer Details</label>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="eng1name" class="form-label">Engineer 1 Name*</label>
                                                    <input type="text" class="form-control" id="eng1name" name="eng1name" placeholder="Enter Name" required>
                                                </div>
                                                <div>
                                                    <label for="eng1phone" class="form-label">Engineer 1 Phone*</label>
                                                    <input type="text" class="form-control" id="eng1phone" name="eng1phone" placeholder="Enter Phone" required>
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Engineer 1 Signature*</label>
                                                    <div class="signature-pad" id="signature-pad1">
                                                        <canvas class="signature-canvas" id="signature-canvas1"></canvas>
                                                    </div>
                                                    <button id="clear-btn1">Clear Signature</button>
                                                    <input type="hidden" id="signature-image1" name="eng1sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="eng2name" class="form-label">Engineer 2 Name</label>
                                                    <input type="text" class="form-control" id="eng2name" name="eng2name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="eng2phone" class="form-label">Engineer 2 Phone</label>
                                                    <input type="text" class="form-control" id="eng2phone" name="eng2phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Engineer 2 Signature</label>
                                                    <div class="signature-pad" id="signature-pad2">
                                                        <canvas class="signature-canvas" id="signature-canvas2"></canvas>
                                                    </div>
                                                    <button id="clear-btn2">Clear Signature</button>
                                                    <input type="hidden" id="signature-image2" name="eng2sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="eng3name" class="form-label">Engineer 3 Name</label>
                                                    <input type="text" class="form-control" id="eng3name" name="eng3name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="eng3phone" class="form-label">Engineer 3 Phone</label>
                                                    <input type="text" class="form-control" id="eng3phone" name="eng3phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Engineer 3 Signature</label>
                                                    <div class="signature-pad" id="signature-pad3">
                                                        <canvas class="signature-canvas" id="signature-canvas3"></canvas>
                                                    </div>
                                                    <button id="clear-btn3">Clear Signature</button>
                                                    <input type="hidden" id="signature-image3" name="eng3sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="eng4name" class="form-label">Engineer 4 Name</label>
                                                    <input type="text" class="form-control" id="eng4name" name="eng4name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="eng4phone" class="form-label">Engineer 4 Phone</label>
                                                    <input type="text" class="form-control" id="eng4phone" name="eng4phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Engineer 4 Signature</label>
                                                    <div class="signature-pad" id="signature-pad4">
                                                        <canvas class="signature-canvas" id="signature-canvas4"></canvas>
                                                    </div>
                                                    <button id="clear-btn4">Clear Signature</button>
                                                    <input type="hidden" id="signature-image4" name="eng4sign" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-5">
                                            <label for="" class="form-label">Customer Details</label>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="cust1name" class="form-label">Executive 1 Name*</label>
                                                    <input type="text" class="form-control" id="cust1name" name="cust1name" placeholder="Enter Name" required>
                                                </div>
                                                <div>
                                                    <label for="cust1phone" class="form-label">Executive 1 Phone*</label>
                                                    <input type="text" class="form-control" id="cust1phone" name="cust1phone" placeholder="Enter Phone" required>
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Executive 1 Signature*</label>
                                                    <div class="signature-pad" id="cxsignature-pad1">
                                                        <canvas class="signature-canvas" id="cxsignature-canvas1"></canvas>
                                                    </div>
                                                    <button id="cxclear-btn1">Clear Signature</button>
                                                    <input type="hidden" id="cxsignature-image1" name="cust1sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="cust2name" class="form-label">Executive 2 Name</label>
                                                    <input type="text" class="form-control" id="cust2name" name="cust2name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="cust2phone" class="form-label">Executive 2 Phone</label>
                                                    <input type="text" class="form-control" id="cust2phone" name="cust2phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Executive 2 Signature</label>
                                                    <div class="signature-pad" id="cxsignature-pad2">
                                                        <canvas class="signature-canvas" id="cxsignature-canvas2"></canvas>
                                                    </div>
                                                    <button id="cxclear-btn2">Clear Signature</button>
                                                    <input type="hidden" id="cxsignature-image2" name="cust2sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="cust3name" class="form-label">Executive 3 Name</label>
                                                    <input type="text" class="form-control" id="cust3name" name="cust3name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="cust3phone" class="form-label">Executive 3 Phone</label>
                                                    <input type="text" class="form-control" id="cust3phone" name="cust3phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Executive 3 Signature</label>
                                                    <div class="signature-pad" id="cxsignature-pad3">
                                                        <canvas class="signature-canvas" id="cxsignature-canvas3"></canvas>
                                                    </div>
                                                    <button id="cxclear-btn3">Clear Signature</button>
                                                    <input type="hidden" id="cxsignature-image3" name="cust3sign" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 border border-primary rounded py-3 border-3">
                                                <div>
                                                    <label for="cust4name" class="form-label">Executive 4 Name</label>
                                                    <input type="text" class="form-control" id="cust4name" name="cust4name" placeholder="Enter Name">
                                                </div>
                                                <div>
                                                    <label for="cust4phone" class="form-label">Executive 4 Phone</label>
                                                    <input type="text" class="form-control" id="cust4phone" name="cust4phone" placeholder="Enter Phone">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label">Executive 4 Signature</label>
                                                    <div class="signature-pad" id="cxsignature-pad4">
                                                        <canvas class="signature-canvas" id="cxsignature-canvas4"></canvas>
                                                    </div>
                                                    <button id="cxclear-btn4">Clear Signature</button>
                                                    <input type="hidden" id="cxsignature-image4" name="cust4sign" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            
                                        </div>
                                        <div class="col-md-12 mt-4">
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
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/tinymce/tinymce.min.js" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let options = {
        selector: '#tinymce-default',
        height: 250,
        menubar: false,
        statusbar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
        }
        options.skin = 'oxide';
        options.content_css = 'light';
        tinyMCE.init(options);
    });

    for (let i = 1; i < 5; i++) {
        let canvas = document.getElementById('signature-canvas'+i);
        let ctx = canvas.getContext('2d');
        let clearBtn = document.getElementById('clear-btn'+i);
        let signatureImage = document.getElementById('signature-image'+i);

        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        // Set pen color and thickness (adjust as needed)
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.moveTo(lastX, lastY);
        lastX = e.offsetX;
        lastY = e.offsetY;
        ctx.lineTo(lastX, lastY);
        ctx.stroke();
        }

        function clearCanvas() {
            event.preventDefault();
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            signatureImage.value = "";
        }

        canvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        lastX = e.offsetX;
        lastY = e.offsetY;
        });

        canvas.addEventListener('mousemove', draw);

        canvas.addEventListener('mouseup', () => {
        isDrawing = false;
        // Convert canvas to image and store in hidden input
        signatureImage.value = canvas.toDataURL('image/png');
        });

        clearBtn.addEventListener('click', clearCanvas);
    }
    


    for (let j = 1; j < 5; j++) {
        let cxcanvas = document.getElementById('cxsignature-canvas'+j);
        let cxctx = cxcanvas.getContext('2d');
        let cxclearBtn = document.getElementById('cxclear-btn'+j);
        let cxsignatureImage = document.getElementById('cxsignature-image'+j);

        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        function draw(e) {
        if (!isDrawing) return;
        cxctx.beginPath();
        // Set pen color and thickness (adjust as needed)
        cxctx.strokeStyle = '#000';
        cxctx.lineWidth = 2;
        cxctx.moveTo(lastX, lastY);
        lastX = e.offsetX;
        lastY = e.offsetY;
        cxctx.lineTo(lastX, lastY);
        cxctx.stroke();
        }

        function clearCanvas() {
            event.preventDefault();
            cxctx.clearRect(0, 0, cxcanvas.width, cxcanvas.height);
            cxsignatureImage.value = "";
        }

        cxcanvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        lastX = e.offsetX;
        lastY = e.offsetY;
        });

        cxcanvas.addEventListener('mousemove', draw);

        cxcanvas.addEventListener('mouseup', () => {
        isDrawing = false;
        // Convert cxcanvas to image and store in hidden input
        cxsignatureImage.value = cxcanvas.toDataURL('image/png');
        });

        cxclearBtn.addEventListener('click', clearCanvas);
    }


    
</script>
@endcomponent