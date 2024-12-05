<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
$bid = intval($_GET['bid']);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $branch = $_POST['branch'];
    $addsql = "UPDATE `branch` set branch.branch = '$branch' where branch_id = '$bid' ";
    $result = mysqli_query($conn, $addsql);
    if($result){
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
    <title>Update Branch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Main container for the form */
        .main-container {
            width: 60%;
            margin: 80px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Heading style */
        h2 {
            text-align: center;
            font-size: 30px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form input styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 17px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.7);
        }

        /* Button styling */
        .submit-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff5f6d, #ffc3a0);
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #ffc3a0, #ff5f6d);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-container {
                width: 90%;
                padding: 20px;
            }

            .form-group input {
                font-size: 16px;
                padding: 10px;
            }

            .submit-btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <?php
    if($showAlert){
        echo '<script>alert("Branch Updated Successfully!")</script>';
    }
    if($showError){
        echo '<script>alert("Error! Try Again.")</script>';
    }
    ?>
    <div class="main-container">
        <h2>Update Branch Information</h2>
        <form method="post">
            <?php
            $sql = "SELECT branch.branch_id, branch.branch from branch where branch.branch_id = $bid";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num > 0){
                while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="form-group">
                <label for="branch">Branch:</label>
                <input name="branch" value="<?php echo $row['branch']; ?>" />
            </div>
            <?php
                }
            }
            ?>
            <div style="text-align: center;">
                <button type="submit" class="submit-btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>