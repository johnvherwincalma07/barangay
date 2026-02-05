<?php  
include 'connection.php';
include 'homeheader.php';
include 'homenav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact page for Barangay Bunga Portal.">
    <title>Bunga Management System - About</title>
    <link rel="stylesheet" href="style/homestyle.css">
    <style>

    .about-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }   
    .about-hero {
        text-align: center;
        margin-bottom: 40px;
    }
    .about-hero h1 {
        font-size: 2.5em;
        color: #333;
        margin-bottom: 10px;
    }
    .about-hero .subtitle {
        color: #666;
        font-size: 1.2em;
    }
    .about-section {
        margin-bottom: 30px;
    }
    .about-section h2 {
        color: #007bff;
        margin-bottom: 15px;
    }
    .about-section p {
        color: #555;
        line-height: 1.6;
    }
    .values-list {
        list-style-type: none;
        padding: 0;
    }
    .values-list li {
        margin-bottom: 10px;
        color: #555;
    }

    </style>
</head>
<body>
    <div class="about-container">
        <section class="about-hero">
            <h1>About Barangay Bunga</h1>
            <p class="subtitle">Serving Our Community with Excellence</p>
        </section>

        <section class="about-content">
            <div class="about-section">
                <h2>Our Mission</h2>
                <p>To provide transparent, efficient, and community-centered governance that improves the quality of life for all residents of Barangay Bunga.</p>
            </div>

            <div class="about-section">
                <h2>Our Vision</h2>
                <p>A progressive barangay where every resident has access to quality services, opportunities, and a safe, sustainable community.</p>
            </div>

            <div class="about-section">
                <h2>About Us</h2>
                <p>Barangay Bunga is committed to fostering community development through responsive local governance, environmental stewardship, and inclusive participation. Our portal serves as a bridge between the local government and residents, promoting transparency and accessibility.</p>
            </div>

            <div class="about-section">
                <h2>Core Values</h2>
                <ul class="values-list">
                    <li><strong>Integrity:</strong> Honest and transparent governance</li>
                    <li><strong>Service:</strong> Dedicated to community welfare</li>
                    <li><strong>Excellence:</strong> Quality in all endeavors</li>
                    <li><strong>Unity:</strong> Collaborative community spirit</li>
                </ul>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Barangay Bunga. All rights reserved.</p>
    </footer>
</body>
</html>