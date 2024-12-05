<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
else{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $subjname = $_POST['subjname'];
        $subjcode = $_POST['subjcode'];
        $status = 1;
        $addsql = "INSERT INTO subjects (subj_name, subj_code, status) VALUES ('$subjname','$subjcode','$status') ";
        $result = mysqli_query($conn, $addsql);
        if($result){
            $showAlert = true;
        }
        else{
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Add Subjects</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        
        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }

        .error {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 100px auto;
            background: linear-gradient(135deg, #f7b7a3, #ff9bb2);
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
            animation: fadeIn 1.5s ease-out;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            font-size: 18px;
            color: #fff;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            border-radius: 8px;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #ff6347;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #ff6347;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff4500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>

    <?php
        if($showAlert){
            echo '<div class="alert">Subject Added Successfully!</div>';
        }
        if($showError){
            echo '<div class="error">Error! Try Again.</div>';
        }
    ?>

    <div class="container">
        <form method="post">
            <h2>Add Subject</h2>

            <div class="form-group">
                <label for="subjname">Subject Name:</label>
                <input name="subjname" type="text" placeholder="Enter Subject Name" required>
            </div>

            <div class="form-group">
                <label for="subjcode">Subject Code:</label>
                <input name="subjcode" type="text" placeholder="Enter Subject Code" required>
            </div>

            <button type="submit">Add</button>
        </form>
    </div>

    <script>
        // Show alerts when actions are performed
        if (document.querySelector('.alert')) {
            setTimeout(function() {
                document.querySelector('.alert').style.display = 'none';
            }, 3000);
        }

        if (document.querySelector('.error')) {
            setTimeout(function() {
                document.querySelector('.error').style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>