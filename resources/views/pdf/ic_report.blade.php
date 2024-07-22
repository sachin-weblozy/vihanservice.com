<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <title>Report_{{ $report->report_number }}</title>

    <style>
        table {
            /* border-collapse: collapse; */
            table-layout: fixed;
            width: 100%;
            page-break-inside: always;
        }

        table, th, td {
            border-collapse: collapse;
        }

        .page-break {
            page-break-after: always;
        }

        .fs-24 { font-size: 24px; }
        .fs-16 { font-size: 16px; }
        .fs-18 { font-size: 18px; }
        .fs-14 { font-size: 14px; }

        * {
            margin: 0;
            /* padding: 0; */
            box-sizing: border-box;
        }

        .body1 {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            height: 100%;
            color: #3e434e;
            background-size: cover;
            background-repeat: no-repeat;
            background-position:center;
            padding: 25px 0px;
        }

        .bg-primary { background-color: #006dbb; }
        .bg-accent { background-color: #f9c846; }
        .bg-dark { background-color: #204262; }
        .bg-light { background-color: #f8f8f8; }
        .text-white { color: #fff; }
        .text-muted { color: #ebebeb; }

        a {
            color: #3e434e;
        }

        td {
            vertical-align: top;
        }

        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .mt-20 { margin-top: 20px; }
        .mt-30 { margin-top: 30px; }
        .mt-40 { margin-top: 40px; }

        .p-0 {
            padding: 0;
        }

        .pl-0 { padding-left: 0px; }
        .pl-20 { padding-left: 20px; }

        .pt-0 { padding-top: 0px; }
        .pb-0 { padding-bottom: 0px; }
        .pr-0 { padding-right: 0px; }

        .text-left { text-align: left; }
        .text-start { text-align: left; }
        .text-right { text-align: right; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }

        thead td {
            background: grey;
            color: #fff;
            padding: 5px;
            vertical-align: middle;
        }

        th {
            padding: 0 5px;
        }

        td {
            padding: 5px;
            border: 1px solid grey;
        }

        p:not(:last-child) {
            margin-bottom: 10px;
        }

        .info-content { margin-top: 15px;line-height: 1.5; }

        .fw-700 { font-weight: 700; }
        
        .v-middle { vertical-align: middle; }

        .b-muted { border-color: #cfcfcf; }
        .b-l { border-left-width: 1px; border-left-style: solid; }

        .order-table thead tr th {
            padding-top: 5px;
            padding-bottom: 10px;
        }

        .table-bordered, .table-bordered td {
            border: 1px solid grey;
        }

        .border-0 {
            border: 0;
        }

        .border-1 {
            border: 1px solid grey;
        }

        .border-l-0 {
            border-left: 0 !important;
        }

        .border-r-0 {
            border-right: 0 !important;
        }


    </style>
</head>
<body class="body1">
    <div class="p10">
        <header id="header">
            <div style=" text-align:left; ">
                <div style="">
                    <p style="margin-bottom: 10px;">
                        <a href="#"><img src="logo.png" style="" alt="" width=""></a>
                    </p>
                </div>
            </div>
            <div style="position: fixed; top:30; right:20; text-align:right">
                <p style="font-weight:700; font-size:16px; font-family: 'Poppins', sans-serif;">{{ $report->report_number ?? '' }}</p>
            </div>
        </header>
    
        <div class="" id="content" style="margin-top: 10px;">
            <div style="margin:auto;">
                <p style="text-align: center;"><b>VIHAN ENGINEERING PVT. LTD.</b></p>
                @if($report->type ==2)
                <p style="text-align: center;">INSTALLATION REPORT FOR NEW PROJECTS / MACHINES/ EQUIPMENTS</p>
                @elseif($report->type ==3)
                <p style="text-align: center;">FIELD SERVICE REPORT FOR PROJECTS / MACHINES/ EQUIPMENTS</p>
                @endif
            </div>
            <br>
            <div style="margin: 0px 20px;">
                <p><span>TO: PURCHASE DEPT./MAINTENANCE DEPARTMENT</span><span style="float: right;">DATE: {{ date('d.m.y') }}</span></p>
            </div>
    
            <table class="mt-20 order-table border-1" style="padding:0px 10 0px 10; margin-left:8px; width:98%; max-height:100px;">
                <tbody>
                    @php $i=1; @endphp
                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>DESCRIPTION OF MACHINE / EQUIPMENT:</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->machine_model ?? '' }}
                        </td>
                    </tr>
                    {{-- <div style="max-width: 100px;">
                        {!! $report->installation_notes ?? '' !!}
                    </div> --}}
                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>MACHINE / EQUIPMENT SERIAL NO.</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->machine_serialno ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>CUSTOMER NAME:</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->cust_name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>CUSTOMER COMPANY NAME:</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->ticket->user->company ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            <b>INVOICE NO (IF ANY):</b>
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            {{ $report->invoice_number ?? '' }}
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            <b>DATE:</b>
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            {{ $report->invoice_date ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:12%;" colspan="1">
                            <b>PURCHASE ORDER NO:</b>
                        </td>
                        <td align="left" style="width:12%;" colspan="1">
                            {{ $report->purchase_order ?? '' }}
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            <b>DATE:</b>
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            {{ $report->purchase_order_date ?? '' }}
                        </td>
                    </tr>

                    @if($report->type ==3)
                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>MODE OF SERVICE:</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            @if($report->service_mode==1)
                            On Field
                            @elseif($report->service_mode==2)
                            Phone Support
                            @elseif($report->service_mode==3)
                            Remote Connect
                            @endif
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>ASSET NUMBER (IF ANY): </b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->asset_number ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            @if($report->type ==3)
                            <b>DATE OF SERVICE:</b>
                            @elseif($report->type ==2)
                            <b>DATE OF INSTALLATION:</b>
                            @endif
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            {{ $report->installation_date ?? '' }}
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            <b>LOCATION:</b>
                        </td>
                        <td align="left" style="width:23%;" colspan="1">
                            {{ $report->location ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>IS THE MACHINE UNDER STANDARD WARRANTY?</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            @if($report->under_warranty == 1) Yes @endif 
                            @if($report->under_warranty == 2) No @endif 
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            <b>WARRANTY PERIOD:</b>
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            {{ $report->warranty_period ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            @if($report->type ==3)
                            <b>AMC PRESENT:</b>
                            @elseif($report->type ==2)
                            <b>AMC REQUIRED:</b>
                            @endif
                        </td>
                        <td align="left" style="width:46%;" colspan="2">
                            @if($report->amc_required == 1) Yes @endif 
                            @if($report->amc_required == 2) No @endif 
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="center" style="width:92%;" colspan="4">
                            @if($report->type ==3)
                            <b>SERVICES PERFORMED:</b>
                            @elseif($report->type ==2)
                            <b>INSTALLATION NOTES:</b>
                            @endif

                            <div>
                                {!! $report->installation_notes ?? '' !!}
                            </div>
                        </td>
                        {{-- <td align="left" style="width:46%;" colspan="2">
                            <div style="">
                                
                            </div>
                        </td> --}}
                    </tr>
                    
                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="center" style="width:92%;" colspan="4">
                            <b>SPARES REQUIRED?</b>

                            <div>
                                {!! $report->spare_parts ?? '' !!}
                            </div>
                        </td>
                        
                    </tr>

                    <tr>
                        <td align="left" style="width:8%;" colspan="1">
                            {{ $i }} @php $i++; @endphp
                        </td>
                        <td align="center" style="width:92%;" colspan="4">
                            <b>CUSTOMER NOTES:</b>
                            <div>
                                {!! $report->customer_notes ?? '' !!}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="width:100%;" colspan="5" style="text-align: center;">
                            <b>Signed By Vihan Service Engineer</b>
                        </td>
                    </tr>
                    @if($report->eng1_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->eng1_name ?? '' }} <br> {{ $report->eng1_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->eng1_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->eng2_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->eng2_name ?? '' }} <br> {{ $report->eng2_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->eng2_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->eng3_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->eng3_name ?? '' }} <br> {{ $report->eng3_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->eng3_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->eng4_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->eng4_name ?? '' }} <br> {{ $report->eng4_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->eng4_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td align="left" style="width:100%;" colspan="5" style="text-align: center;">
                            <b>Signed By Customer Representative</b>
                        </td>
                    </tr>
                    @if($report->cust1_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->cust1_name ?? '' }} <br> {{ $report->cust1_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->cust1_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->cust2_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->cust2_name ?? '' }} <br> {{ $report->cust2_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->cust2_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->cust3_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->cust3_name ?? '' }} <br> {{ $report->cust3_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->cust3_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif
                    @if($report->cust4_name)
                    <tr>
                        <td align="left" style="width:40%;" colspan="3" style="text-align: center;">
                            {{ $report->cust4_name ?? '' }} <br> {{ $report->cust4_phone ?? '' }}
                        </td>
                        <td align="left" style="width:60%;" colspan="2" style="text-align: center;">
                            <img src="{{ $report->cust4_sign ?? '' }}" alt="" width="30%">
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
            
            <table class="mt-20 table custom-table" style="padding:0px 10 0px 10; margin-left:8px; width:98%;">
                <tbody>
                    <tr>
                        <p>
                            <b>Disclaimer</b> <br><br>
                            @if($report->type==2)
                            This Service Report ("Report") has been prepared by Vihan Engineering Pvt. Ltd. for the purpose of documenting the Installation & Commissioning of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }}.
                            <br>
                            <b>Accuracy</b>: While utmost care has been taken to ensure the accuracy of the information contained in this Report, Vihan Engineering Pvt. Ltd. cannot guarantee that all details are error-free or complete. Users of this Report should independently verify any critical information. 
                            <br>
                            <b>Scope</b>: This Report is specific to the Installation & Commissioning of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }} as conducted by Vihan Engineering Pvt. Ltd. It may not encompass all aspects of the overall project or system integration unless explicitly stated. 
                            <br>
                            <b>Liability</b>: Vihan Engineering Pvt. Ltd. shall not be liable for any direct, indirect, incidental, special, or consequential damages arising out of or in any way connected with the use of this Report, including but not limited to any lost profits, loss of business, or interruption of operations. 
                            <br>
                            <b>Regulatory Compliance</b>: It is the responsibility of the end-user or client to ensure that the installation and the operation of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }} comply with all applicable regulatory requirements, industry standards, and local codes. 
                            <br>												
                            <b>Modification</b>: Any modifications or alterations made to {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }} after the completion of the Installation & Commissioning may affect its performance and safety. Vihan Engineering Pvt. Ltd. recommends consulting with authorized personnel before making any changes. 
                            <br>												
                            <b>Confidentiality</b>: This Report contains proprietary information belonging to Vihan Engineering Pvt. Ltd. and may not be reproduced, distributed, or disclosed to third parties without prior written consent. By accessing or using this Report, you agree to be bound by the terms and conditions set forth in this disclaimer. If you do not agree with any part of this disclaimer, you must not use this Report. 				
                            <br><br>                                                  
                            For inquiries or clarification regarding this disclaimer or the contents of this Report, please contact Vihan Engineering's Service Department. 
                            <br><br>


                            @elseif($report->type==3)

                            This Service Report ("Report") has been prepared by Vihan Engineering Pvt. Ltd. for the purpose of documenting the Field Service of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }}.
                            <br>
                            <b>Accuracy</b>: While utmost care has been taken to ensure the accuracy of the information contained in this Report, Vihan Engineering Pvt. Ltd. cannot guarantee that all details are error-free or complete. Users of this Report should independently verify any critical information. 
                            <br>
                            <b>Scope</b>: This Report is specific to the Field Service of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }} as conducted by Vihan Engineering Pvt. Ltd. It may not encompass all aspects of the overall project or system integration unless explicitly stated. 
                            <br>
                            <b>Liability</b>: Vihan Engineering Pvt. Ltd. shall not be liable for any direct, indirect, incidental, special, or consequential damages arising out of or in any way connected with the use of this Report, including but not limited to any lost profits, loss of business, or interruption of operations. 
                            <br>
                            <b>Regulatory Compliance</b>: It is the responsibility of the end-user or client to ensure that the operation of {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }} comply with all applicable regulatory requirements, industry standards, and local codes. 
                            <br>												
                            <b>Modification</b>: Any modifications or alterations made to {{ $report->machine_model ?? '' }} - {{ $report->machine_serialno ?? '' }}     after the completion of the Field Service may affect its performance and safety. Vihan Engineering Pvt. Ltd. recommends consulting with authorized personnel before making any changes. 
                            <br>												
                            <b>Confidentiality</b>: This Report contains proprietary information belonging to Vihan Engineering Pvt. Ltd. and may not be reproduced, distributed, or disclosed to third parties without prior written consent. By accessing or using this Report, you agree to be bound by the terms and conditions set forth in this disclaimer. If you do not agree with any part of this disclaimer, you must not use this Report. 								
                            <br><br>                                                  
                            For inquiries or clarification regarding this disclaimer or the contents of this Report, please contact Vihan Engineering's Service Department. 													
                            <br><br>
                            @endif
                            <b>Vihan Engineering Pvt. Ltd. </b>
                            <br>
                            Date: {{ date('d.m.y') }}
                            <br><br>
                            

                        </p>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
