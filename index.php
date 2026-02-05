<?php   
include('connection.php');
include('homeheader.php');
include('homenav.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Bunga Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HOMEPAGE STYLES -->
    <link rel="stylesheet" href="style/homestyle.css">

    <!-- Optional: Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Hero typing effect -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
</head>
<body>

<!-- HERO SECTION -->
<div class="hero">

    <!-- Background Image -->
    <div class="hero-bg">
        <img src="images/brgy.jpg" alt="Barangay Background">
        <div class="hero-overlay"></div>
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <span class="shape circle"></span>
            <span class="shape square"></span>
            <span class="shape triangle"></span>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="hero-content">
        <img src="images/bgLogo.png" alt="Barangay Logo" class="hero-logo">

        <h1 class="typed-text"></h1>

        <p>
            BARANGAY BUNGA, TANZA, CAVITE<br>
            Open Hours: Monday – Friday (8:00 AM – 5:00 PM)<br>
            brgybunga@gmail.com | 269-1034
        </p>

        <a href="#about" class="about-btn">ABOUT US</a>
    </div>

</div>

<!-- STATISTICS SECTION -->
<section class="stats-section">
    <h2>📊 Barangay Statistics</h2>
    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Residents</h3>
            <p class="stat-number">12,450</p>
        </div>
        <div class="stat-card">
            <h3>Households</h3>
            <p class="stat-number">2,890</p>
        </div>
        <div class="stat-card">
            <h3>Barangay Programs</h3>
            <p class="stat-number">45</p>
        </div>
        <div class="stat-card">
            <h3>Community Projects</h3>
            <p class="stat-number">18</p>
        </div>
    </div>
</section>

<!-- QUICK INFO CARDS -->
<section class="info-cards">

    <div class="info-card">
        <h3>📍 Location</h3>
        <p>Barangay Bunga, Tanza, Cavite</p>
    </div>

    <div class="info-card">
        <h3>🕒 Office Hours</h3>
        <p>Monday – Friday<br>8:00 AM – 5:00 PM</p>
    </div>

    <div class="info-card">
        <h3>📞 Contact</h3>
        <p>269-1034<br>brgybunga@gmail.com</p>
    </div>

</section>

<!-- ABOUT SECTION -->
<section id="about" class="about-section">
    <div class="about-container">
        <div class="about-left">
            <img src="images/bgLogo.png" alt="Barangay Bunga Logo" class="about-image">
        </div>
        <div class="about-right">
            <h2>About Barangay Bunga</h2>
            <p>
                Barangay Bunga is a vibrant and progressive community located in Tanza, Cavite.
                Guided by strong leadership and community cooperation, the barangay continuously
                strives to deliver transparent governance, efficient public service, and sustainable
                development for all residents.
            </p>
        </div>
    </div>
</section>


<!-- BARANGAY OFFICIALS SECTION -->
<section id="officials" class="officials-section">
    <h2>🏛️ Barangay Officials</h2>
    <p>Meet the leaders of Barangay Bunga who serve and guide our community.</p>

    <div class="officials-container" style="display: flex; flex-wrap: wrap; justify-content: space-around;">

        <!-- Barangay Captain -->
        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Barangay Captain" style="max-width: 80%; height: auto;">
            <h3>Juan Dela Cruz</h3>
            <span>Barangay Captain</span>
        </div>

        <!-- Kagawad / Council Members -->
        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Kagawad 1" style="max-width: 60%; height: auto;">
            <h3>Maria Santos</h3>
            <span>Kagawad</span>
        </div>

        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Kagawad 2" style="max-width: 60%; height: auto;">
            <h3>Pedro Reyes</h3>
            <span>Kagawad</span>
        </div>

        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Kagawad 3" style="max-width: 60%; height: auto;">
            <h3>Luisa Mendoza</h3>
            <span>Kagawad</span>
        </div>

        <!-- Secretary / Treasurer -->
        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Barangay Secretary" style="max-width: 60%; height: auto;">
            <h3>Antonio Lim</h3>
            <span>Barangay Secretary</span>
        </div>

        <div class="official-card" style="flex: 1 1 30%; margin: 10px; text-align: center;">
            <img src="images/officials.png" alt="Barangay Treasurer" style="max-width: 60%; height: auto;">
            <h3>Cristina Cruz</h3>
            <span>Barangay Treasurer</span>
        </div>

    </div>
</section>



<!-- MAP SECTION -->
<section class="map-section">
    <h2>📍 Find Us</h2>
    <p>Locate Barangay Bunga easily using the interactive map below.</p>

    <div class="map-container">
        <iframe
            src="https://www.google.com/maps?q=Barangay%20Bunga%20Tanza%20Cavite&output=embed"
            loading="lazy"
            allowfullscreen>
        </iframe>
    </div>
</section>

<?php include('mainfooter.php'); ?>

<!-- ================= HERO TYPING EFFECT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Typed('.typed-text', {
            strings: [
                'WELCOME TO BARANGAY BUNGA',
                'Your Community, Your Voice',
                'Transparent Governance & Services'
            ],
            typeSpeed: 60,
            backSpeed: 40,
            loop: true
        });
    });
</script>

</body>
</html>
