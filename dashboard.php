<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}
include "includes/connection.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .top-bar {
            background-color: #0056b3;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        .top-bar h1 {
            margin: 0;
            font-size: 24px;
        }

        .top-bar p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .dashboard-item {
            text-align: center;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border-radius: 10px;
            padding: 20px;
            width: 250px;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .dashboard-item p {
            font-size: 20px;
            margin: 10px 0 0;
            font-weight: bold;
        }

        .dashboard-item a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
            transition: color 0.3s;
        }

        .dashboard-item a:hover {
            color: #ffe135;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #0056b3;
            color: white;
            margin-top: 30px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <h1>Kathmandu Model College</h1>
        <p>Bagbazar, Kathmandu, Nepal</p>
    </div>

    <h1>Welcome, Admin!</h1>
    <div class="dashboard-container">
        <div class="dashboard-item">
            <div>No. of Students</div>
            <p id="s1"></p>
            <a href="manage-students.php">Manage Students</a>
        </div>
        <div class="dashboard-item">
            <div>Semesters Listed</div>
            <p id="s2"></p>
            <a href="manage-sem.php">Manage Semesters</a>
        </div>
        <div class="dashboard-item">
            <div>Branches Listed</div>
            <p id="s3"></p>
            <a href="manage-branch.php">Manage Branches</a>
        </div>
        <div class="dashboard-item">
            <div>Subjects Listed</div>
            <p id="s4"></p>
            <a href="manage-subjects.php">Manage Subjects</a>
        </div>
        <div class="dashboard-item">
            <div>Results Declared</div>
            <p id="s5"></p>
            <a href="manage-results.php">Manage Results</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Kathmandu Model College | All Rights Reserved</p>
    </footer>

    <script>
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        const obj1 = document.getElementById("s1");
        const obj2 = document.getElementById("s2");
        const obj3 = document.getElementById("s3");
        const obj4 = document.getElementById("s4");
        const obj5 = document.getElementById("s5");

        <?php
        $sql1 = "SELECT reg_id from student";
        $result1 = mysqli_query($conn, $sql1);
        $num1 = mysqli_num_rows($result1);

        $sql2 = "SELECT sem_id from semester";
        $result2 = mysqli_query($conn, $sql2);
        $num2 = mysqli_num_rows($result2);

        $sql3 = "SELECT branch_id from branch";
        $result3 = mysqli_query($conn, $sql3);
        $num3 = mysqli_num_rows($result3);

        $sql4 = "SELECT subj_id from subjects";
        $result4 = mysqli_query($conn, $sql4);
        $num4 = mysqli_num_rows($result4);

        $sql5 = "SELECT distinct roll_no from results";
        $result5 = mysqli_query($conn, $sql5);
        $num5 = mysqli_num_rows($result5);
        ?>
        animateValue(obj1, 0, <?php echo $num1; ?>, 800);
        animateValue(obj2, 0, <?php echo $num2; ?>, 800);
        animateValue(obj3, 0, <?php echo $num3; ?>, 800);
        animateValue(obj4, 0, <?php echo $num4; ?>, 800);
        animateValue(obj5, 0, <?php echo $num5; ?>, 800);
    </script>
</body>

</html>