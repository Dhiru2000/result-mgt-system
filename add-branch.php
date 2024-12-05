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
        $branch = $_POST['branch'];

        $addsql = "INSERT INTO `branch` (`branch`) VALUES ('$branch') ";
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
    <title>Add Branch</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(45deg, #FF7A00, #FFD700);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 60%;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #FF7A00;
            box-shadow: 0 0 5px rgba(255, 122, 0, 0.5);
        }

        button {
            background-color: #FF7A00;
            color: white;
            border: none;
            padding: 12px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            align-self: flex-end;
        }

        button:hover {
            background-color: #FFD700;
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
    </style>
</head>
<body>
<?php include "nav.php"; ?>
<?php
    if($showAlert){
        echo '<script>alert("Branch Added Successfully!")</script>';
    }
    if($showError){
        echo '<script>alert("Error! Try Again.")</script>';
    }
?>
    <div class="container">
        <form method="post">
            <h2>Add Branch</h2>

            <label for="branch">Branch Name:</label>
            <input type="text" name="branch" placeholder="Enter branch name" required />

            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>