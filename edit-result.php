<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";

// Check if the user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: index.php");
    exit;
}

$stid = intval($_GET['stid']);

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $rowid = $_POST['id'];
    $marks = $_POST['marks'];

    $sql = "UPDATE results SET marks = ? WHERE result_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        foreach($rowid as $index => $id) {
            $mrks = $marks[$index];
            mysqli_stmt_bind_param($stmt, "ii", $mrks, $id);
            mysqli_stmt_execute($stmt);
        }
        $showAlert = true;
    } else {
        $showError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Info</title>
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        h2 {
            font-size: 30px;
            text-align: center;
            margin-top: 20px;
            color: #333;
            animation: fadeIn 2s ease-out;
        }

        .container {
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            border: 2px solid #ccc;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.8s ease-out;
        }

        /* Input and Label Styles */
        label {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"], input[type="number"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Button Styles */
        button {
            width: 120px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        button:active {
            background-color: #1e7e34;
            transform: translateY(1px);
        }

        /* Alert Styles */
        .alert {
            text-align: center;
            font-size: 18px;
            padding: 10px;
            color: white;
            background-color: #28a745;
            margin-top: 20px;
            display: none;
            border-radius: 5px;
        }

        .alert-error {
            background-color: #dc3545;
        }

        /* Keyframe Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Flexbox for Results */
        .result-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
            padding: 10px;
            border-radius: 4px;
        }

        .result-item:hover {
            background-color: #f0f0f0;
        }

        /* Smooth Transitions */
        .container input, .container button {
            transition: all 0.3s ease;
        }

        .container input:hover, .container button:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>

    <!-- Alert Messages -->
    <?php
    if ($showAlert) {
        echo '<div class="alert">Record Updated Successfully!</div>';
    }
    if ($showError) {
        echo '<div class="alert alert-error">Error! Try Again.</div>';
    }
    ?>

    <div class="container">
        <h2>Update Result Info</h2>
        
        <form method="post">
            <?php
            // Fetch student details
            $sql = "SELECT student.Name, student.Roll_No, branch.branch, semester.semester
                    FROM results
                    JOIN student ON student.Roll_No = results.roll_no
                    JOIN subjects ON subjects.subj_id = results.subj_id
                    JOIN branch ON branch.branch_id = results.branch_id
                    JOIN semester ON semester.sem_id = results.sem_id
                    WHERE student.reg_id = $stid LIMIT 1";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="result-container">';
                    echo '<div class="result-item"><label>Full Name: </label><span>' . $row['Name'] . '</span></div>';
                    echo '<div class="result-item"><label>Roll No: </label><span>' . $row['Roll_No'] . '</span></div>';
                    echo '<div class="result-item"><label>Class: </label><span>' . $row['branch'] . ' Sem(' . $row['semester'] . ')</span></div>';
                    echo '</div>';
                }
            }
            ?>
            
            <div class="result-container">
                <?php
                // Fetch subject and marks
                $sql = "SELECT results.marks, results.result_id, subjects.subj_name
                        FROM results
                        JOIN student ON student.Roll_No = results.roll_no
                        JOIN subjects ON subjects.subj_id = results.subj_id
                        JOIN branch ON branch.branch_id = results.branch_id
                        JOIN semester ON semester.sem_id = results.sem_id
                        WHERE student.reg_id = $stid";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="result-item">';
                        echo '<label>' . $row['subj_name'] . ':</label>';
                        echo '<input type="hidden" name="id[]" value="' . $row['result_id'] . '">';
                        echo '<input type="number" name="marks[]" value="' . $row['marks'] . '" maxlength="5" required />';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <div style="text-align: right;">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>

    <script>
        // Show alert for success/error dynamically after form submission
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 3000);
    </script>
</body>
</html>