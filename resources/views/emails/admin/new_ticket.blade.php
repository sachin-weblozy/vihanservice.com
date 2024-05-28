<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation: Your Issue Is Being Addressed</title>
    <style>
    
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial;
            background-color: #f9f9f9;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #D3D3D3;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header img {
            max-width: 150px;
            height: auto;
        }

      
        .content {
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #34495e; 
            text-align: center;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .content .note {
            background-color: #f0f0f0;
            border-left: 4px solid #ffab00;
            padding: 10px;
            margin-bottom: 20px;
        }

  
        .footer {
            text-align: center;
            padding: 20px;
            background: #D3D3D3; 
            color: #000000;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .footer p {
            margin-bottom: 5px;
            font-size: 17px;
        }

    </style>
</head>
<body>
    <div class="container">
      
        <div class="header">
            <img src="https://vihanservice.com/logo2.webp" alt="Company Logo">
        </div>

  
        <div class="content">
            @if($data['ticket_type']==1)
            <h1>New Remote Service Ticket Created</h1>
            @endif

            @if($data['ticket_type']==2)
            <h1>New Installation and Commissioning Ticket Created</h1>
            @endif

            @if($data['ticket_type']==3)
            <h1>New Field Service Ticket Created</h1>
            @endif

            <p>Dear {{ $data['user_name'] ?? '' }},</p>
            <p>Thank you for creating a service request on the Vihan Service Portal. Kindly do wait while we are working on your request. One of our associates will be responding to the issue at the earliest.</p>

            <p>Here are the details of your request:</p>
            
            <ul>
                <li><b>Executive Name:-</b> {{ $data['user_name'] ?? '' }}</li>
                <li><b>Date:-</b> {{ $data['date'] ?? '' }}</li>
                <li><b>Phone Number:-</b> {{ $data['user_phone'] ?? '' }}</li>
                <li><b>Email ID:-</b> {{ $data['user_email'] ?? '' }}</li>
                <li><b>Ticket ID:-</b> {{ $data['ticket_id'] ?? '' }}</li>
            </ul>
            
           
            <p class="note" > <span style="color: #ff0000;">Note: </span>Our Regular Business Hours are Monday – Saturday 8:30 AM IST to 5:40 PM IST {1st/2nd/3rd/4th Sunday WOFF; 1st/3rd Saturday COFF}. The response time maybe higher during WOFF/COFF or after normal business hours. We thank you for your patience.</p>
        </div>

        
        <div class="footer">
            <p><strong> Plant:</strong> &nbsp;&nbsp;Block No 22B, Vasna Chacharvadi, Sarkhej - Bavla Highway, Ahmedabad, GJ 382213. Phone: +91-9099032640 </p>
            <p><strong>Vihan HO:</strong> &nbsp;&nbsp;B 613/614, Navratna Corporate Park, Bopal-Ambli Road, Ahmedabad 380058, GJ</p>
        </div>
        <p><a href="https://vihanservice.com/register">Click here</a> to register on our Service Portal and make use of all features for our machinery.</p>
    </div>
</body>
</html>
