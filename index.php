<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/connection.php';
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    
    $sql = "Select * from admin where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) { 
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: dashboard.php");
            } else {
                $showError = "Invalid Credentials";
            }
        }
    } else {
        $showError = "Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRMS</title>
    <link rel="shortcut icon" href="sample/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: blue;
            color: white;
            font-size: 22px;
            padding: 15px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav img {
            width: 60px;
            height: 60px;
        }

        nav .title {
            font-size: 24px;
        }

        nav .location {
            font-size: 14px;
        }

        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            gap: 20px;
        }

        .box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            flex: 1;
            max-width: 500px;
            min-width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .box h2 {
            font-size: 28px;
            color: blue;
            margin-bottom: 20px;
            border-bottom: 2px solid blue;
            display: inline-block;
            padding-bottom: 5px;
        }

        .box form input,
        .box form button {
            width: 80%;
            max-width: 350px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .box form input:focus {
            border-color: blue;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 255, 0.5);
        }

        .box form button {
            background-color: blue;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s ease-in-out;
        }

        .box form button:hover {
            background-color: darkblue;
            transform: scale(1.1);
        }

        /* Search Result and Ranking Student Button Animation */
        .box a {
            display: inline-block;
            padding: 10px 20px;
            background-color: blue;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s ease-in-out;
        }

        .box a:hover {
            background-color: darkblue;
            transform: scale(1.1);
        }

        /* Slider styles */
        .slider-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background-color: #333;
        }

        .slider {
            display: flex;
            transition: transform 1s ease-in-out;
        }

        .slide {
            min-width: 100%;
            color: white;
            padding: 10px 20px; /* Reduced padding */
            text-align: center;
            font-size: 14px; /* Reduced font size */
            line-height: 1.4; /* Adjusted line height */
        }

        .slide h3 {
            font-size: 18px; /* Reduced font size for headings */
            margin-bottom: 10px;
        }

        .slide ul {
            list-style-type: none;
            padding: 0;
            font-size: 14px; /* Reduced font size */
            line-height: 1.4; /* Adjusted line height */
            margin-top: 10px;
        }

        .slide ul li {
            font-size: 16px; /* Reduced font size for list items */
            padding: 5px 0;
            font-weight: bold;
            color: white; /* White color for program names */
        }

        .about-text p {
            font-size: 14px; /* Reduced font size */
            line-height: 1.4; /* Adjusted line height */
        }

        .slider-buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 18px; /* Adjusted font size */
            border: none;
            padding: 8px;
            cursor: pointer;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .slider {
                font-size: 12px;
            }

            .slide h3 {
                font-size: 16px; /* Further reduced font size for smaller screens */
            }

            .program-list li {
                font-size: 14px; /* Reduced font size */
            }

            .about-text p {
                font-size: 12px; /* Reduced font size for smaller screens */
            }
        }
    </style>
</head>

<body>
    <nav>
        <img src="logo2.jpg">
        <span class="title">Kathmandu Model College</span>
        <span class="location">Bagbazar, Kathmandu</span>
    </nav>

    <div class="container">
        <div class="box">
            <h2>For Students</h2>
            <p>Search your result quickly and easily.</p>
            <a href="find-result.php">Search Result</a>
        </div>

        <div class="box">
            <h2>Admin Login</h2>
            <form action="" method="post">
                <input type="text" name="username" id="username" placeholder="Enter Username" required>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <h3>Kathmandu Model College (KMC) in affiliation with Tribhuvan University</h3>
                <p>is steadfastly dedicated to nurturing the next generation of leaders.</p>
            </div>

            <div class="slide">
                <h3>Contact Information</h3>
                <p>Bagbazar, Kathmandu, Nepal</p>
                <p>Email: info@kmcen.edu.np</p>
                <p>Phone: +977 9811234567, 01-5345678, 01-5378901</p>
            </div>

            <div class="slide">
                <h3>Our Programs</h3>
                <ul class="program-list">
                    <li>BCA</li>
                    <li>BA</li>
                    <li>BBA</li>
                    <li>BBM</li>
                </ul>
            </div>

            <div class="slide">
                <div class="about-text">
                    <h3>About Kathmandu Model College</h3>
                    <p>Kathmandu Model College is one of the leading educational institutions in Nepal...</p>
                    <p>Offering a variety of undergraduate and postgraduate programs designed to prepare students for the challenges of the modern world.</p>
                </div>
            </div>
        </div>
        <div class="slider-buttons">
            <button onclick="previousSlide()">&#10094;</button>
            <button onclick="nextSlide()">&#10095;</button>
        </div>
    </div>

    <script>
        let currentSlide = 0;

        function showSlide(index) {
            const slides = document.querySelectorAll('.slide');
            const totalSlides = slides.length;

            if (index >= totalSlides) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = totalSlides - 1;
            } else {
                currentSlide = index;
            }

            const slider = document.querySelector('.slider');
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function previousSlide() {
            showSlide(currentSlide - 1);
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        setInterval(nextSlide, 5000);
    </script>
</body>

</html>