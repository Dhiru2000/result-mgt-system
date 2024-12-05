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
        $sem = $_POST['semester'];

        $addsql = "INSERT INTO `semester` (`semester`) VALUES ('$sem')";
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
    <title>Add Semester</title>
    <style>
        /* General body and background styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff7a18, #af002d);
            margin: 0;
            padding: 0;
        }

        /* Main container with animation and modern styling */
        .container {
            width: 60%;
            margin: 100px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        /* Form title */
        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
        }

        /* Label and input styling */
        label {
            display: inline-block;
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 17px;
            margin-top: 8px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        /* Input field focus effect */
        input:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 10px rgba(106, 17, 203, 0.5);
        }

        /* Button styling */
        button {
            width: 150px;
            padding: 10px;
            font-size: 18px;
            background-color: #6a11cb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Button hover effect */
        button:hover {
            background-color: #2575fc;
            transform: scale(1.05);
        }

        /* Fade-in animation for the form */
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

        /* Media query for responsiveness */
        @media screen and (max-width: 768px) {
            .container {
                width: 85%;
                padding: 25px;
            }

            h2 {
                font-size: 24px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php include "nav.php"; ?>

<?php
    if($showAlert){
        echo '<script>alert("Semester Added Successfully!")</script>';
    }
    if($showError){
        echo '<script>alert("Error! Try Again.")</script>';
    }
?>

    <div class="container">
        <form method="post">
            <h2>Add Semester</h2>

            <div>
                <label for="semester">Semester: </label>
                <input type="text" name="semester" required/>
            </div>

            <div style="text-align: center;">
                <button type="submit">Add</button>
            </div>
        </form>
    </div>

</body>
</html>