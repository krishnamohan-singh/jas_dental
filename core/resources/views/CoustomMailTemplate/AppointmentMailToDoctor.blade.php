<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Appointment Notification</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 600px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      background: #24378e;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 22px;
      font-weight: bold;
    }
    .content {
      padding: 20px;
    }
    .content h2 {
      color: #24378e;
    }
    .content p {
      font-size: 16px;
      color: #333;
      line-height: 1.5;
    }
    .details {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .details td {
      border: 1px solid #ddd;
      padding: 10px;
      font-size: 16px;
    }
    .details td:first-child {
      font-weight: bold;
      background: #f9f9f9;
    }
    .footer {
      background: #24378e;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">New Appointment Scheduled</div>
    <div class="content">
      <p>Hello <strong>{{$doctor_name}}</strong>,</p>
      <p>A new appointment has been booked for you on {{$site_name}}. Here are the details:</p>
      <table class="details">
        <tr>
          <td>Patient's Name</td>
          <td><strong>{{$patient_name}}</strong></td>
        </tr>
        <tr>
          <td>Patient Email</td>
          <td>{{$patient_email}}</td>
        </tr>
        <tr>
          <td>Patient Phone</td>
          <td>{{$patient_phone}}</td>
        </tr>
        <tr>
          <td>Date and Time</td>
          <td><strong>{{$booking_date}} | {{$time_serial}}</strong></td>
        </tr>
      </table>
    </div>
    <div class="footer">&copy; 2025 {{$site_name}}. All Rights Reserved.</div>
  </div>
</body>
</html>
