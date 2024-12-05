<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pg1.css">
    <title>Search Result</title>
    <style>
        /* Body and background settings */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f06, #4a90e2);
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Main container styling */
        .main {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Input and label styles */
        .in {
            margin-bottom: 20px;
            padding: 10px;
        }

        .in label {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
            color: #333;
        }

        .in select,
        .in input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .in select:focus,
        .in input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.7);
        }

        /* Sexy buttons styling */
        .in4 button,
        .e a {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 18px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #ff5f6d, #ffc3a0);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            text-align: center;
        }

        /* Search button */
        .in4 button {
            cursor: pointer;
            border: none;
            background-color: transparent;
            width: 100%;
        }

        .in4 button:hover {
            background: linear-gradient(135deg, #ffc3a0, #ff5f6d);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Back to Home link button */
        .e a {
            background-color: transparent;
            color: #4a90e2;
        }

        .e a:hover {
            background: #4a90e2;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .main {
                padding: 20px;
            }

            .in label {
                font-size: 16px;
            }

            .in select,
            .in input {
                font-size: 14px;
            }

            .in4 button {
                font-size: 16px;
            }

            .e a {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php
    if ($showAlert) {
        echo '<script>alert("Record Added Successfully!")</script>';
    }
    if ($showError) {
        echo '<script>alert("Error! Try Again.")</script>';
    }
    ?>
    <div class="main">
        <div class="in">
            <form action="result.php" method="post">
                <div class="in1">
                    <label for="branch_id">Branch &nbsp;&nbsp;&nbsp;: &nbsp;</label>
                    <select name="branch_id" id="branch_id" required>
                        <option value="">Select Branch</option>
                        <?php
                        $sql = "SELECT * from `branch`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['branch_id']; ?>" style="font-size:17px"><?php echo $row['branch']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="in2">
                    <label for="sem_id">Semester : &nbsp;</label>
                    <select name="sem_id" id="sem_id" required>
                        <option value="">Select Semester</option>
                        <?php
                        $sql = "SELECT * from `semester`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['sem_id']; ?>" style="font-size:17px"><?php echo $row['semester']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="in3">
                    <label for="">Enter Roll No : </label>
                    <input type="text" required name="stid">
                </div>
                <div class="in4">
                    <button type="submit">Search</button>
                </div>
            </form>
            <div class="e">
                <a href="index.php">Back to Home</a>
            </div>
        </div>
    </div>
</body>

</html>