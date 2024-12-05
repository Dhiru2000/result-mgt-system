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
        $fullname = $_POST['fullname'];
        $rollno = $_POST['rollno'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $dob = $_POST['birthDate'];
        $branch = $_POST['branch'];
        $sem = $_POST['semester'];
        $status = 1;
        $addsql = "INSERT INTO student (Name, Roll_No, Email, Gender, DOB, branch_id, Reg_date, sem_id, status) VALUES ('$fullname','$rollno', '$email', '$gender', '$dob', '$branch', current_timestamp(), '$sem', '$status') ";
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
    <title>Add Students</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fc4a1a, #f7b733);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #222;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 18px;
            margin-bottom: 8px;
            color: #555;
        }

        input, select {
            padding: 12px;
            margin: 12px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input:focus, select:focus {
            border-color: #f7b733;
            box-shadow: 0 0 8px rgba(247, 183, 51, 0.5);
        }

        .radio-group {
            display: flex;
            gap: 25px;
            margin-bottom: 20px;
        }

        .radio-group label {
            font-size: 16px;
            color: #555;
        }

        button {
            background-color: #f7b733;
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            align-self: center;
            margin-top: 25px;
        }

        button:hover {
            background-color: #fc4a1a;
            transform: translateY(-5px);
        }

        button:active {
            background-color: #e74100;
            transform: translateY(0);
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hover effects for input fields */
        input:hover, select:hover {
            border-color: #f7b733;
            box-shadow: 0 0 8px rgba(247, 183, 51, 0.4);
        }
    </style>
</head>
<body>
<?php include "nav.php"; ?>
<?php
    if($showAlert){
        echo '<script>alert("Record Added Successfully!")</script>';
    }
    if($showError){
        echo '<script>alert("Error! Try Again.")</script>';
    }
    ?>
    <div class="container">
      <form method="post">
      <h2>Add Student Details</h2>
      
      <label for="fullname">Full Name:</label>
      <input name="fullname" required="required" placeholder="Enter full name" />

      <label for="rollno">Roll No:</label>
      <input name="rollno" required="required" placeholder="Enter Roll No" />

      <label for="email">Email:</label>
      <input type="email" name="email" required="required" placeholder="Enter email" />

      <div class="radio-group">
        <label><input type="radio" name="gender" value="Male" /> Male</label>
        <label><input type="radio" name="gender" value="Female" /> Female</label>
        <label><input type="radio" name="gender" value="Other" /> Other</label>
      </div>

      <label for="birthDate">Date of Birth:</label>
      <input type="date" name="birthDate" required="required" />

      <label for="branch">Branch:</label>
      <select name="branch" id="branch" required="required">
        <option value="">Select Branch</option>
        <?php 
        $sql = "SELECT * from branch";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
        ?>
            <option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch'];?></option>
        <?php } ?>
      </select>

      <label for="semester">Semester:</label>
      <select name="semester" id="semester" required="required">
        <option value="">Select Semester</option>
        <?php 
        $sql = "SELECT * from semester";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
        ?>
            <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['semester'];?></option>
        <?php } ?>
      </select>

      <button type="submit">Add</button>

  </form>
    </div>
</body>
</html>