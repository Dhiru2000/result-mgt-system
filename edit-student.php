<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
$stid = intval($_GET['stid']);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fullname = $_POST['fullname'];
    $rollno = $_POST['rollno'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['birthDate'];
    $status = $_POST['status'];
    $addsql = "UPDATE `student` set student.Name = '$fullname', student.Roll_No = '$rollno', student.Email = '$email', student.Gender='$gender', student.DOB = '$dob', student.status='$status' where student.reg_id = '$stid'";
    $result1 = mysqli_query($conn, $addsql);
    if($result1){
        $showAlert = true;
    }
    else{
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
    <title>Edit Student's Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f06, #4a90e2);
            margin: 0;
            padding: 0;
        }

        /* Main container for the form */
        .main-container {
            width: 70%;
            margin: 30px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Heading style */
        h2 {
            text-align: center;
            font-size: 30px;
            color: #333;
        }

        /* Input field styles */
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input,
        .form-group select {
            padding: 10px;
            font-size: 17px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
            margin-top: 5px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.7);
        }

        /* Radio button style */
        .form-group input[type="radio"] {
            width: auto;
            margin-right: 10px;
        }

        /* Status radio button styling */
        .status-radio label {
            margin-right: 20px;
        }

        /* Update button styling */
        .submit-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff5f6d, #ffc3a0);
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            border: none;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #ffc3a0, #ff5f6d);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Back button styling */
        .back-btn {
            display: inline-block;
            background: transparent;
            color: #4a90e2;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: 2px solid #4a90e2;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 20px;
        }

        .back-btn:hover {
            background: #4a90e2;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-container {
                width: 90%;
                padding: 15px;
            }

            .form-group input,
            .form-group select {
                font-size: 16px;
                padding: 8px;
            }

            .submit-btn,
            .back-btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <?php include "nav.php";?>
    <?php
    if($showAlert){
        echo '<script>alert("Record Updated Successfully!")</script>';
    }
    if($showError){
        echo '<script>alert("Error! Try Again.")</script>';
    }
    ?>
    <div class="main-container">
        <h2>Edit Student Admission Details</h2>
        <form method="post">
            <?php
            $sql = "SELECT student.Name, student.Roll_No, student.reg_id, student.status, student.Email, student.Gender, student.Reg_date, student.DOB, branch.branch, semester.semester from student join branch on student.branch_id = branch.branch_id join semester on student.sem_id = semester.sem_id where student.reg_id = $stid";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num > 0){
                while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input name="fullname" value="<?php echo $row['Name'];?>" />
            </div>

            <div class="form-group">
                <label for="rollno">Roll No:</label>
                <input name="rollno" value="<?php echo $row['Roll_No'];?>" />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $row['Email'];?>" />
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <label><input type="radio" name="gender" value="Male" <?php if($row['Gender'] == 'Male') echo 'checked'; ?> /> Male</label>
                <label><input type="radio" name="gender" value="Female" <?php if($row['Gender'] == 'Female') echo 'checked'; ?> /> Female</label>
                <label><input type="radio" name="gender" value="Other" <?php if($row['Gender'] == 'Other') echo 'checked'; ?> /> Other</label>
            </div>

            <div class="form-group">
                <label for="birthDate">DOB:</label>
                <input type="date" name="birthDate" value="<?php echo $row['DOB'];?>" />
            </div>

            <div class="form-group">
                <label for="branch">Branch:</label>
                <input name="branch" value="<?php echo $row['branch'];?>" readonly />
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <input name="semester" value="<?php echo $row['semester'];?>" readonly />
            </div>

            <div class="form-group">
                <label>Reg Date:</label>
                <span><?php echo $row['Reg_date'];?></span>
            </div>

            <div class="form-group status-radio">
                <label>Status:</label>
                <label><input type="radio" name="status" value="1" <?php if($row['status'] == 1) echo 'checked'; ?> /> Active</label>
                <label><input type="radio" name="status" value="0" <?php if($row['status'] == 0) echo 'checked'; ?> /> Block</label>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="submit-btn">Update</button>
            </div>
            <?php
                }
            }
            ?>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="students.php" class="back-btn">Back to Students List</a>
        </div>
    </div>
</body>
</html>