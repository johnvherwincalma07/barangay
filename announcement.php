<?php  
include('connection.php');
include('homeheader.php');
include('homenav.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bunga Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/homestyle.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #announcement {
        max-width: 1200px;
        margin: 40px auto;
        padding: 40px 20px;
    }

    #announcement h2 {
        font-size: 2.5rem;
        color: #2c3e50;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 700;
    }

    #announcement > p {
        text-align: center;
        color: #555;
        font-size: 1.1rem;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .announcement-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .announcement-item {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 30px;
        color: white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .announcement-item::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .announcement-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    .announcement-item h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .announcement-item p {
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
        color: #fff;
    }
</style>
<body>

    <section id="announcement">
        <h2>Announcements</h2>
        <p>
            Welcome to the Barangay Bunga Announcement Page! Stay tuned for the latest news and updates about our community events, programs, and important notices. We are committed to keeping our residents informed and engaged.
        </p>

        <div class="announcement-list">
            <div class="announcement-item">
                <h3>Community Clean-Up Drive</h3>
                <p>Date: July 15, 2024</p>
                <p>Join us for a community clean-up drive to keep our barangay clean and green! Volunteers are welcome.</p>
            </div>
            <div class="announcement-item">
                <h3>Health and Wellness Fair</h3>
                <p>Date: August 5, 2024</p>
                <p>Free health check-ups and wellness activities for all residents. Don't miss out on this opportunity to prioritize your health!</p>
            </div>
            <div class="announcement-item">
                <h3>Barangay Fiesta Celebration</h3>
                <p>Date: September 10-12, 2024</p>
                <p>Celebrate our annual barangay fiesta with fun activities, food stalls, and cultural performances. Everyone is invited!</p>
            </div>  

        </div>

    </section>
    
    <footer style="text-align: center; background-color: #2c3e50; color: white; padding: 15px 0; position:sticky; bottom:0; width:100%;">
        &copy; 2025 Barangay Bunga. All rights reserved.
    </footer>

</body>
</html>