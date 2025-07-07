<?php
session_start();
include 'db.php';

$err = "";

// Handle Login
if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['name'];
      header("Location: dashboard.php");
      exit();
    } else {
      $err = "Invalid password.";
    }
  } else {
    $err = "No user found with that email.";
  }
}

// Handle Signup
if (isset($_POST['signup'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if ($password !== $confirm) {
    $err = "Passwords do not match.";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);
    if ($stmt->execute()) {
      $_SESSION['user'] = $name;
      header("Location: dashboard.php");
      exit();
    } else {
      $err = $conn->errno === 1062 ? "Email already registered." : "Error: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login & Signup</title>
  <style>
    body {
      font-family: Arial;
      background: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      width: 350px;
    }
    .toggle-btns {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }
    .toggle-btns button {
      padding: 10px;
      width: 45%;
      font-weight: bold;
      cursor: pointer;
      background-color: #2980b9;
      border: none;
      color: white;
      border-radius: 6px;
    }
    form {
      display: none;
    }
    form.active {
      display: block;
    }
    input {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .submit-btn {
      background: #2980b9;
      color: white;
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="toggle-btns">
    <button onclick="showForm('login')">Login</button>
    <button onclick="showForm('signup')">Sign Up</button>
  </div>

  <?php if ($err): ?>
    <div class="error"><?= $err ?></div>
  <?php endif; ?>

  <!-- Login Form -->
  <form id="loginForm" class="active" method="POST">
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button class="submit-btn" name="login">Login</button>
  </form>

  <!-- Signup Form -->
  <form id="signupForm" method="POST">
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="password" name="confirm_password" placeholder="Confirm Password" required />
    <button class="submit-btn" name="signup">Sign Up</button>
  </form>
</div>

<script>
  function showForm(form) {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('signupForm').classList.remove('active');
    document.getElementById(form + 'Form').classList.add('active');
  }
</script>

</body>
</html>
