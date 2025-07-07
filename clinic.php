<?php
session_start(); // If using session for login/logout

// Connect to the database
$host = "localhost";
$user = "root"; // change if needed
$password = ""; // change if you have a password
$dbname = "user_db";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$formMessage = ""; // Initialize it

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["book_appointment"])) {
    if (!isset($_SESSION["user"])) {
        // Not logged in
        $formMessage = "Please log in to book an appointment.";
    } else {
        // Logged in, proceed with booking
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $date = $_POST["date"];
        $department = $_POST["department"];
        $message = trim($_POST["message"]);

        $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, appointment_date, department, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $date, $department, $message);

        if ($stmt->execute()) {
            $_SESSION['appointment'] = [
                "id" => $stmt->insert_id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "date" => $date,
                "department" => $department,
                "message" => $message
            ];

            header("Location: dashboard.php");
            exit();
        } else {
            $formMessage = "Error booking appointment. Please try again.";
        }

        $stmt->close();
    }

    $conn->close();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MED ZONE CLINIC</title>
<style>
/* style.css - Professional Responsive Design for MED ZONE CLINIC */

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background: #f4f7f9;
  color: #333;
  line-height: 1.6;
}
html{
   scroll-behavior: smooth;
}

header {
  background: #0077b6;
  color: white;
  padding: 15px 40px;
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.logo {
  display: flex;
  align-items: center;
}

.logo h1 {
  font-size: 1.5rem;
  margin-left: 10px;
}

.logo img {
  width: 40px;
  height: 40px;
}

nav ul {
  display: flex;
  list-style: none;
}

nav ul li {
  margin-left: 25px;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s;
  font-size: 1.1rem;
}

nav a:hover {
  color: #90e0ef;
}

.hero {
  background: url('doctor-background.jpg') center/cover no-repeat;
  position: relative;
  color: white;
  text-align: center;
  padding: 120px 20px;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(0,119,182,0.85) 0%, rgba(0,180,216,0.85) 100%);
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  margin: 0 auto;
}

.hero h2 {
  font-size: 3rem;
  margin-bottom: 20px;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

.hero .btn {
  margin-top: 20px;
  background: white;
  color: #0077b6;
  padding: 15px 30px;
  border: none;
  font-weight: bold;
  border-radius: 30px;
  text-decoration: none;
  transition: all 0.3s;
  display: inline-block;
  font-size: 1.1rem;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.hero .btn:hover {
  background: #caf0f8;
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

section {
  padding: 60px 20px;
  max-width: 1200px;
  margin: auto;
}

h2 {
  font-size: 2.2rem;
  color: #023e8a;
  margin-bottom: 30px;
  text-align: center;
}

.main-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.service-card {
  background: white;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  transition: transform 0.3s ease;
}

.service-card:hover {
  transform: translateY(-10px);
}

.service-card h3 {
  color: #0077b6;
  font-size: 1.5rem;
  margin-bottom: 15px;
}

.service-card p {
  color: #555;
  margin-bottom: 15px;
}

.service-card i {
  font-size: 3rem;
  color: #48cae4;
  margin-bottom: 20px;
  display: block;
}

.features {
  background: #e9f5fb;
  padding: 80px 20px;
}

.features-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

.feature-box {
  text-align: center;
  padding: 30px 20px;
}

.feature-box i {
  font-size: 2.5rem;
  color: #0077b6;
  margin-bottom: 20px;
}

.feature-box h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: #023e8a;
}

#services ul {
  list-style-type: none;
  margin-top: 20px;
}

#services li {
  background: white;
  margin-bottom: 10px;
  padding: 15px 20px;
  border-radius: 6px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  display: flex;
  align-items: center;
}

#services li:before {
  content: "✓";
  color: #0077b6;
  font-weight: bold;
  margin-right: 15px;
}

.gallery-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.gallery-container img {
  width: 100%;
  height: 200px;
  border-radius: 10px;
  object-fit: cover;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
}

.gallery-container img:hover {
  transform: scale(1.05);
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-width: 600px;
  margin: 0 auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

form input,
form textarea {
  padding: 15px;
  border-radius: 6px;
  border: 1px solid #ddd;
  font-size: 16px;
  transition: border 0.3s ease;
}

form input:focus,
form textarea:focus {
  border-color: #0077b6;
  outline: none;
}

form textarea {
  resize: vertical;
  min-height: 150px;
}

form button {
  background: #0077b6;
  color: white;
  padding: 15px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
}

form button:hover {
  background: #023e8a;
}

footer {
  text-align: center;
  padding: 30px 20px;
  background: #03045e;
  color: white;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto 20px auto;
  text-align: left;
}

.footer-column h3 {
  font-size: 1.2rem;
  margin-bottom: 20px;
  color: #90e0ef;
}

.footer-column p, .footer-column a {
  color: #ccc;
  margin-bottom: 10px;
  display: block;
  text-decoration: none;
}

.footer-column a:hover {
  color: white;
}

.copyright {
  border-top: 1px solid rgba(255,255,255,0.1);
  padding-top: 20px;
  color: #aaa;
  font-size: 0.9rem;
}

/* Responsive tweaks */
@media (max-width: 768px) {
  header {
    padding: 15px 20px;
  }
  
  .header-container {
    flex-direction: column;
  }
  
  nav ul {
    margin-top: 15px;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  nav ul li {
    margin: 5px 10px;
  }
  
  .hero h2 {
    font-size: 2rem;
  }
  
  h2 {
    font-size: 1.8rem;
  }
  
  .service-card, form {
    padding: 20px;
  }
}

/* Add Font Awesome for icons */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
</style>

</head>
<body>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('appointmentForm');
    const msg = document.getElementById('formMessage');

    if (msg.textContent.includes('successfully')) {
      setTimeout(() => {
        form.reset();
      }, 100); // Reset shortly after page load
    }
  });


  const isLoggedIn = <?= isset($_SESSION["user"]) ? 'true' : 'false' ?>;


</script>


  <header>
    <div class="header-container">
      <div class="logo">
        <img src="https://t3.ftcdn.net/jpg/04/83/17/70/360_F_483177001_2f5bi2HdCXfqKuMoHwbfkCWhCFa4k3pX.jpg" alt="Med Zone Logo">
        <h1>MED ZONE CLINIC PATNA</h1>
      </div>
      <nav>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#contact">Contact</a></li>
          <?php if (isset($_SESSION["user"])): ?>
            <li><a href="logout.php">Sign Out</a></li>
          <?php else: ?>
            <li><a href="signup.php">Sign In</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <section id="home" class="hero">
    <div class="hero-content">
      <h2>Your Health, Our Priority</h2>
      <p>Experience advanced healthcare with compassionate service. Our expert doctors are committed to providing personalized care for you and your family.</p>
      <a href="#contact" class="btn">Book Your Appointment Today</a>
    </div>
  </section>

  <section id="main-services">
    <h2>Our Specialized Services</h2>
    <p class="section-desc">Comprehensive healthcare solutions tailored to your needs</p>
    
    <div class="main-content">
      <div class="service-card">
        <i class="fas fa-user-md"></i>
        <h3>General Medicine</h3>
        <p>Our experienced physicians provide comprehensive care for a wide range of medical conditions, from routine check-ups to managing chronic diseases.</p>
      </div>
      
      <div class="service-card">
        <i class="fas fa-baby"></i>
        <h3>Pediatric Care</h3>
        <p>Specialized healthcare for infants, children, and adolescents, focusing on growth, development, and preventive care.</p>
      </div>
      
      <div class="service-card">
        <i class="fas fa-heartbeat"></i>
        <h3>Cardiology</h3>
        <p>Advanced cardiac care including diagnostic tests, preventive screenings, and management of heart conditions.</p>
      </div>
      
      <div class="service-card">
        <i class="fas fa-stethoscope"></i>
        <h3>Diagnostic Services</h3>
        <p>State-of-the-art laboratory and imaging services to accurately diagnose medical conditions and monitor treatment progress.</p>
      </div>
    </div>
  </section>

  <section class="features">
    <div class="features-container">
      <div class="feature-box">
        <i class="fas fa-clock"></i>
        <h3>Extended Hours</h3>
        <p>Available when you need us, including evenings and weekends</p>
      </div>
      
      <div class="feature-box">
        <i class="fas fa-user-nurse"></i>
        <h3>Expert Staff</h3>
        <p>Experienced healthcare professionals dedicated to your well-being</p>
      </div>
      
      <div class="feature-box">
        <i class="fas fa-tablet-alt"></i>
        <h3>Modern Technology</h3>
        <p>Advanced medical equipment for accurate diagnosis and treatment</p>
      </div>
      
      <div class="feature-box">
        <i class="fas fa-home"></i>
        <h3>Home Visits</h3>
        <p>Healthcare services delivered at your doorstep when needed</p>
      </div>
    </div>
  </section>

  <section id="about">
    <h2>About Med Zone Clinic</h2>
    <p>Founded in 2020, Med Zone Clinic has been a trusted healthcare provider in Patna for over 5 years. Our mission is to deliver accessible, high-quality medical care with a patient-centered approach.</p>
    <p>Led by Dr. Md. Shamim, our team of qualified healthcare professionals is committed to serving the community with compassion and excellence. We continuously upgrade our facilities and knowledge to offer the best medical care possible.</p>
  </section>

  <section id="gallery">
    <h2>Our Clinic Gallery</h2>
    <div class="gallery-container">
      <img src="doctor on work.jpeg" alt="Doctor at Work">
      <img src="baby.jpeg" alt="Pediatric Care">
      <img src="doctor cheakup.jpeg" alt="Medical Procedure">
      <img src="Injection.jpeg" alt="Lab Area">
      <img src="ground.jpeg" alt="Waiting Area">
      <img src="pulse.jpeg" alt="Medical Team">
      <img src="doctor at work.jpeg">
      <img src="WhatsApp Image 2025-05-20 at 5.47.09 PM.jpeg">
      
    </div>
  </section>

  <section id="services">
    <h2>Our Services</h2>
    <ul>
      <li>General Check-ups and Consultations</li>
      <li>Comprehensive Diagnostic Tests</li>
      <li>Child and Maternal Care Services</li>
      <li>Vaccinations and Immunizations</li>
      <li>Chronic Disease Management</li>
      <li>Health Education and Counseling</li>
      <li>Emergency Medical Services</li>
      <li>Specialized Referral Services</li>
    </ul>
  </section>

  

  <section id="contact">
    <p id="loginRequiredMsg" style="color: red; font-weight: bold; text-align: center; display: none;">
  Please log in first to book an appointment.
</p>
    <h2>Book an Appointment</h2>
    <form id="appointmentForm" method="POST" action="">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <input type="tel" name="phone" placeholder="Your Phone Number" required />
      <input type="date" name="date" required />
      <select name="department">
        <option value="">Select Department</option>
        <option value="general">General Medicine</option>
        <option value="pediatric">Pediatric Care</option>
        <option value="cardiology">Cardiology</option>
        <option value="diagnostic">Diagnostic Services</option>
      </select>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit" name="book_appointment" <?= !isset($_SESSION["user"]) ? 'title="Log in to enable this"' : '' ?>>
  Book Appointment
</button>
    </form>
    <p id="formMessage" style="color:<?= strpos($formMessage, 'successfully') !== false ? 'green' : 'red' ?>; text-align:center; margin-top:20px;">
  <?= $formMessage ?>
</p>

  </section>

  <footer>
    <div class="footer-content">
      <div class="footer-column">
        <h3>Med Zone Clinic</h3>
        <p>Azmat Colony Prakash Nagar</p>
        <p> Phulwari Sharif Patna, Bihar 800001</p>
        <p>Near Dipali Garden</p>
        <p>Phone: 9304609073 </p>
        <p>Email: almrn528@rediffmail.com</p>
      </div>
      
      <div class="footer-column">
        <h3>Working Hours</h3>
        <p>Monday-Friday: 8:00 AM - 8:00 PM</p>
        <p>Saturday: 8:00 AM - 6:00 PM</p>
        <p>Sunday: 06:00 AM - 9:00 AM</p>
        <p>Emergency Services: 24/7</p>
      </div>
      
      <div class="footer-column">
        <h3>Quick Links</h3>
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="#services">Services</a>
        <a href="#contact">Book Appointment</a>
      </div>
    </div>
    
    <div class="copyright">
      <p>&copy; 2025 Med Zone Clinic Patna. All rights reserved.</p>
    </div>
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('appointmentForm');
  const loginMsg = document.getElementById('loginRequiredMsg');

  form.addEventListener('submit', function (e) {
    if (!isLoggedIn) {
      e.preventDefault();
      loginMsg.style.display = 'block';
      form.scrollIntoView({ behavior: 'smooth' }); // Optional: scroll to form
    }
  });
});

  </script>
</body>
</html>