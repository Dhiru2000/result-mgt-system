<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Results</title>
    <link rel="stylesheet" type="text/css" href="css/fp1.css?version=51">

    <!-- Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />

    <!-- jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <style>
        /* Modern background */
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Main container */
        .m2 {
            width: 90%;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        /* Heading styles */
        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 30px;
        }

        h3 {
            text-align: center;
            color: #34495e;
            margin-bottom: 50px;
        }

        /* Table styles */
        #tableID {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #tableID th, #tableID td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #tableID th {
            background-color: #3498db;
            color: #fff;
        }

        /* Hover effects */
        #tableID tbody tr:hover {
            background-color: #ecf0f1;
            cursor: pointer;
        }

        /* Table actions icons */
        .fa-edit {
            color: #2ecc71;
            font-size: 18px;
            transition: 0.3s;
        }

        .fa-edit:hover {
            color: #27ae60;
        }

        /* Active and Blocked status */
        .status-active {
            color: #27ae60;
            font-weight: bold;
        }

        .status-blocked {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Datatable initialization */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 0 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>

    <div class="m2">
        <h1>Manage Results</h1>
        <h3>* View Students' Result</h3>
        <table id="tableID" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Roll No.</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Reg Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Roll No.</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Reg Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT distinct student.Name, student.Roll_No, student.Reg_date, student.status, student.reg_id, branch.branch, semester.semester 
                        from results 
                        join student on results.roll_no = student.Roll_No 
                        join branch on branch.branch_id = results.branch_id 
                        join semester on semester.sem_id = results.sem_id";
                $result = mysqli_query($conn, $sql);
                $c = 1;
                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $c; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Roll_No']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['Reg_date']; ?></td>
                            <td>
                                <?php 
                                if ($row['status'] == 1) {
                                    echo "<span class='status-active'>Active</span>";
                                } else {
                                    echo "<span class='status-blocked'>Blocked</span>";
                                }
                                ?>
                            </td>
                            <td><a href="edit-result.php?stid=<?php echo $row['reg_id']; ?>"><i class="fa fa-edit" title="Edit Record"></i></a></td>
                        </tr>
                        <?php
                        $c++;
                    }
                }
                ?>
            </tbody>
        </table>

        <script>
            /* Initialization of datatable */
            $(document).ready(function() {
                $('#tableID').DataTable();
            });
        </script>
    </div>
</body>
</html>