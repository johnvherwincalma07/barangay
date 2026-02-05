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
    <title>Bunga Management System - Contact</title>
    <link rel="stylesheet" href="style/homestyle.css">
    <style>
        .contact-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
            border-bottom: 3px solid #007bff;
        }

        .contact-header h1 {
            font-size: 2.5em;
            color: #333;
            margin: 0;
        }

        .contact-header p {
            color: #666;
            font-size: 1.1em;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            border-radius: 8px;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .info-card h3 {
            margin-top: 0;
            font-size: 1.3em;
        }

        .info-card ul {
            padding-left: 20px;
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <main class="contact-container">
        <div class="contact-header">
            <h1>Contact Page</h1>
            <p>Get in touch with Barangay Bunga</p>
        </div>

        <div class="info-cards">
            <article class="info-card">
                <h3>📍 Location</h3>
                <p>Barangay Bunga, Tanza, Cavite</p>
            </article>

            <article class="info-card">
                <h3>🕒 Office Hours</h3>
                <p>Monday – Friday<br>8:00 AM – 5:00 PM</p>
            </article>

            <article class="info-card">
                <h3>📞 Contact</h3>
                <p>Phone: 269-1034<br>Email: <a href="mailto:brgybunga@gmail.com" style="color: white; text-decoration: underline;">brgybunga@gmail.com</a></p>
            </article>

            <article class="info-card">
                <h3>🚨 Emergency Contact</h3>
                <ul>
                    <li>Police: 911</li>
                    <li>Fire Department: 911</li>
                    <li>Medical Emergency: 911</li>
                </ul>
            </article>

            <article class="info-card">
                <h3>🚺 VAWC Support</h3>
                <p>Phone: 123-4567<br>Email: <a href="mailto:vawc@brgybunga.com" style="color: white; text-decoration: underline;">vawc@brgybunga.com</a></p>
            </article>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Barangay Bunga. All rights reserved.</p>
    </footer>
</body>
</html>