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
        $branch_id = $_POST['branch'];
        $sem_id = $_POST['semester'];
        $subj_id = $_POST['subject'];
        $stat = 1;
        $addsql = "INSERT INTO `subject_comb` (`branch_id`, `sem_id`, `subj_id`, `status`) VALUES ('$branch_id','$sem_id','$subj_id', '$stat')";

        $result = mysqli_query($conn, $addsql);
        if ($result) {
            $showAlert = true;
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
    <title>Add Subject Combination</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(120deg, #f6d365, #fda085);
            color: #333;
        }

        .container {
            width: 70%;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 20px 40px;
            margin-top: 80px;
            animation: fadeIn 1s ease-in-out;
        }

        .container h2 {
            text-align: center;
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        .form-group select:focus {
            border-color: #3498db;
            outline: none;
        }

        .btn-container {
            text-align: right;
            margin-top: 20px;
        }

        .btn-container button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-container button:hover {
            background: #2980b9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
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
if ($showAlert) {
    echo '<script>alert("Record Added Successfully!")</script>';
}
if ($showError) {
    echo '<script>alert("Error! Try Again.")</script>';
}
?>
<div class="container">
    <h2>Add Subject Combination</h2>
    <form method="post">
        <div class="form-group">
            <label for="branch">Branch</label>
            <select name="branch" id="branch">
                <option value="">Select Branch</option>
                <?php 
                $sql = "SELECT * from `branch`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['branch_id'] . '">' . $row['branch'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>
            <select name="semester" id="semester">
                <option value="">Select Semester</option>
                <?php 
                $sql = "SELECT * from `semester`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['sem_id'] . '">' . $row['semester'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <select name="subject" id="subject">
                <option value="">Select Subject</option>
                <?php 
                $stat = 1;
                $sql = "SELECT * from `subjects` where subjects.status = '$stat'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['subj_id'] . '">' . $row['subj_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="btn-container">
            <button type="submit">Add</button>
        </div>
    </form>
</div>
</body>
</html>