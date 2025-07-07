<?php
session_start();

if (!isset($_SESSION["appointment"])) {
    // No appointment data? Redirect to homepage
    header("Location: index.php");
    exit();
}

$appt = $_SESSION["appointment"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Appointment Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7f9;
      padding: 40px;
    }
    .dashboard {
      max-width: 600px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #0077b6;
      margin-bottom: 20px;
    }
    .info {
      margin: 15px 0;
      font-size: 1.1em;
    }
    .label {
      font-weight: bold;
      color: #023e8a;
    }
    a.btn {
      display: inline-block;
      margin-top: 30px;
      text-align: center;
      padding: 12px 24px;
      background: #0077b6;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    a.btn:hover {
      background: #023e8a;
    }
  </style>
</head>
<body>

<div class="dashboard">
  <h2>Appointment Confirmed</h2>
  <div class="info"><span class="label">Appointment ID:</span> <?= $appt["id"] ?></div>
  <div class="info"><span class="label">Name:</span> <?= htmlspecialchars($appt["name"]) ?></div>
  <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($appt["email"]) ?></div>
  <div class="info"><span class="label">Phone:</span> <?= htmlspecialchars($appt["phone"]) ?></div>
  <div class="info"><span class="label">Date:</span> <?= htmlspecialchars($appt["date"]) ?></div>
  <div class="info"><span class="label">Department:</span> <?= htmlspecialchars($appt["department"]) ?></div>
  <div class="info"><span class="label">Message:</span> <?= nl2br(htmlspecialchars($appt["message"])) ?></div>

  <a class="btn" href="clinic.php">Back to Home</a>
  <a class="btn" href="edit_appointment.php">Edit Appointment</a>
</div>

</body>
</html>
