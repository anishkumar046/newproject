<?php
session_start();
include("db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $pass = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user["password"])) {
            $_SESSION["user"] = $name;
            header("Location: clinic.php");
            exit();
        } else {
            $error = "Invalid name or password!";
        }
    } else {
        $error = "Invalid name or password!";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .registration-form {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      width: 350px;
    }

    .registration-form h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus {
      border-color: #2575fc;
    }

    .submit-btn {
      width: 100%;
      padding: 10px;
      background: #2575fc;
      border: none;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background: #1a5ed1;
    }

    .login-link {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    .login-link a {
      color: #2575fc;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="registration-form">
    <h2>Log In</h2>
   <form method="POST" action="">
  <div class="form-group">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" required />
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required />
  </div>
  <button type="submit" class="submit-btn">Login</button>
</form>

<?php if (!empty($error)): ?>
  <p style="color:red; text-align:center;"><?= $error ?></p>
<?php endif; ?>


  </div>
</body>
</html>
