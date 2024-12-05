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
        $marks = array();
        $branch_id = $_POST['branch'];
        $sem_id = $_POST['semester'];
        $st_id = $_POST['studentid'];
        $mark = $_POST['marks'];

        $sql = "SELECT subjects.subj_name, subjects.subj_id FROM subject_comb join subjects on subjects.subj_id = subject_comb.subj_id WHERE subject_comb.sem_id = $sem_id order by subjects.subj_name";
        $result = mysqli_query($conn, $sql);
        $sid1 = array();

        while($row = mysqli_fetch_assoc($result)){
            array_push($sid1, $row['subj_id']);
        }

        for($i = 0; $i < count($mark); $i++){
            $mar = $mark[$i];
            $sid = $sid1[$i];
            $sql = "INSERT INTO results (roll_no, branch_id, sem_id, subj_id, marks) VALUES ('$st_id','$branch_id', '$sem_id', '$sid', '$mar')";
            $result = mysqli_query($conn, $sql);

            if($result){
                $showAlert = true;
            }
            else{
                $showError = true;
            }
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
    <title>Declare Result</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-out;
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

        h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
            background-color: #f1f1f1;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        select:focus, button:focus {
            border-color: #5c6bc0;
            outline: none;
        }

        button {
            background-color: #5c6bc0;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3f51b5;
        }

        .alert {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error {
            padding: 10px;
            background-color: #f44336;
            color: white;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include "nav.php"; ?>

<?php
    if($showAlert){
        echo '<div class="alert">Result Declared Successfully!</div>';
    }
    if($showError){
        echo '<div class="error">Error! Try Again.</div>';
    }
?>

<div class="container">
    <form method="post">
        <h2>Declare Result</h2>

        <div class="form-group">
            <label for="branch">Branch:</label>
            <select name="branch" class="branch_id" id="branch">
                <option value="">Select Branch</option>
                <?php 
                $sql = "SELECT * FROM `branch`";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                ?>
                    <option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="semester">Semester:</label>
            <select class="clid" name="semester" id="classid" onChange="getStudent(this.value)">
                <option value="">Select Semester</option>
                <?php 
                $sql = "SELECT * FROM `semester`";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                ?>
                    <option value="<?php echo $row['semester']; ?>"><?php echo $row['semester']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="studentid">Student Name:</label>
            <select class="stid" name="studentid" id="studentid" onChange="getresult(this.value)">
                <!-- Student options will be populated by AJAX -->
            </select>
        </div>

        <div class="form-group" id="reslt">
            <!-- Results will be displayed here -->
        </div>

        <div class="form-group">
            <label for="subject">Subjects:</label>
            <div id="subject">
                <!-- Subjects will be displayed here -->
            </div>
        </div>

        <button type="submit">Declare Result</button>
    </form>
</div>

<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script>
    function getStudent(val) {
        var branch_id = $(".branch_id").val();
        var abh = branch_id + '$' + val;
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'classid=' + abh,
            success: function(data){
                $("#studentid").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'classid1=' + abh,
            success: function(data){
                $("#subject").html(data);
            }
        });
    }

    function getresult(val) {
        var branch_id = $(".branch_id").val();
        var clid = $(".clid").val();
        var stid = $(".stid").val();
        var abh = clid + '$' + val + '$' + branch_id;
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'studclass=' + abh,
            success: function(data){
                $("#reslt").html(data);
            }
        });
    }
</script>

</body>
</html>