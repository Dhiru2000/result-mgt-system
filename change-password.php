<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $og_password = $_POST['ogpass'];
        $curr_password = $_POST['npass'];
        $concurr_password = $_POST['cnpass'];
        $username = $_SESSION['username'];
        // $hash_ogpass = password_hash($og_password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM `admin` WHERE username = '$username' ";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num ==  1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($og_password, $row['password'])) {
                    if (($curr_password == $concurr_password)) {
                        $hash_pass = password_hash($curr_password, PASSWORD_DEFAULT);
                        $sql1 = "UPDATE `admin` SET password = '$hash_pass' WHERE username = '$username'";
                        $result1 = mysqli_query($conn, $sql1);
                        if ($result1) {
                            $showAlert = true;
                        } else {
                            $showError = true;
                        }
                    }
                } else {
                    echo "Passwords do not match";
                }
            }
        } else {
            $showError = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Change Password</title>

    <!-- External CSS for Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
    <style>
        /* Global Styles */
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Container */
        .container {
            width: 60%;
            margin: 80px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Heading Styles */
        h2 {
            text-align: center;
            font-size: 30px;
            color: #3498db;
            margin-bottom: 20px;
        }

        /* Form Elements */
        label {
            font-size: 18px;
            color: #555;
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
            transform: scale(1.05);
        }

        /* Button Styles */
        button {
            background-color: #3498db;
            color: white;
            font-size: 18px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Alert Messages */
        .alert {
            background-color: #f39c12;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        .alert-error {
            background-color: #e74c3c;
        }

        /* Alert Animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            input, button {
                font-size: 16px;
            }

            h2 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <?php include "nav.php"; ?>

    <?php
    if ($showAlert) {
        echo '<div class="alert">Password Updated Successfully!</div>';
    }
    if ($showError) {
        echo '<div class="alert alert-error">Error! Try Again.</div>';
    }
    ?>

    <div class="container">
        <h2>Admin Change Password</h2>

        <form method="post">
            <label for="ogpass">Current Password:</label>
            <input type="password" name="ogpass" id="ogpass" required />

            <label for="npass">New Password:</label>
            <input type="password" name="npass" id="npass" required />

            <label for="cnpass">Confirm New Password:</label>
            <input type="password" name="cnpass" id="cnpass" required />

            <button type="submit">Change Password</button>
        </form>
    </div>

</body>

</html>