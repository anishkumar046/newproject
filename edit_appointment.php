<?php
session_start();

if (!isset($_SESSION["appointment"])) {
    header("Location: index.php");
    exit();
}

$appt = $_SESSION["appointment"];
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_appointment"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $date = $_POST["date"];
    $department = $_POST["department"];
    $message = trim($_POST["message"]);

    // Update in database
    $conn = new mysqli("localhost", "root", "", "user_db");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("UPDATE appointments SET name=?, email=?, phone=?, appointment_date=?, department=?, message=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $email, $phone, $date, $department, $message, $appt["id"]);

    if ($stmt->execute()) {
        // Update session data
        $_SESSION["appointment"] = [
            "id" => $appt["id"],
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "date" => $date,
            "department" => $department,
            "message" => $message
        ];
        header("Location: dashboard.php");
    exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Appointment</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7f9;
      padding: 40px;
    }
    .form-container {
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
    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      padding: 12px 24px;
      background: #0077b6;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #023e8a;
    }
    .success {
      color: green;
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Edit Your Appointment</h2>

  <?php if ($successMsg): ?>
    <p class="success"><?= $successMsg ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="name" value="<?= htmlspecialchars($appt["name"]) ?>" required>
    <input type="email" name="email" value="<?= htmlspecialchars($appt["email"]) ?>" required>
    <input type="tel" name="phone" value="<?= htmlspecialchars($appt["phone"]) ?>" required>
    <input type="date" name="date" value="<?= htmlspecialchars($appt["date"]) ?>" required>
    
    <select name="department" required>
      <option value="">Select Department</option>
      <option value="general" <?= $appt["department"] === "general" ? "selected" : "" ?>>General Medicine</option>
      <option value="pediatric" <?= $appt["department"] === "pediatric" ? "selected" : "" ?>>Pediatric Care</option>
      <option value="cardiology" <?= $appt["department"] === "cardiology" ? "selected" : "" ?>>Cardiology</option>
      <option value="diagnostic" <?= $appt["department"] === "diagnostic" ? "selected" : "" ?>>Diagnostic Services</option>
    </select>

    <textarea name="message" required><?= htmlspecialchars($appt["message"]) ?></textarea>

    <button type="submit" name="update_appointment">Update Appointment</button>
  </form>
</div>

</body>
</html>
