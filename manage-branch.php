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
    <title>Manage Branch</title>
    <link rel="stylesheet" type="text/css" href="css/fp1.css?version=51">
    <!-- Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <!-- jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff7a00, #ffd700);
            margin: 0;
            padding: 0;
        }

        .m2 {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 1.5s forwards;
        }

        h1 {
            text-align: center;
            font-size: 35px;
            margin-bottom: 20px;
            color: #333;
        }

        h3 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 50px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ff7a00;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        a {
            color: #ff7a00;
            text-decoration: none;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #ffd700;
            transform: scale(1.2);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* DataTable Styles */
        .dataTables_wrapper {
            padding: 20px;
        }

        .dataTables_paginate {
            text-align: center;
        }

        .dataTables_filter input {
            padding: 7px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <div class="m2">
        <h1>Manage Branch</h1>
        <h3>* View Branches</h3>
        <table id="tableID" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 60%">Branch</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th style="width: 60%">Branch</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT branch.branch_id, branch.branch FROM branch";
                $result = mysqli_query($conn, $sql);
                $c = 1;
                $num = mysqli_num_rows($result);
                if($num > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $c;?></td>
                            <td><?php echo $row['branch'];?></td>
                            <td><a href="edit-branch.php?bid=<?php echo $row['branch_id'];?>"><i class="fa fa-edit" title="Edit Record"></i></a></td>
                        </tr>
                        <?php
                        $c++;
                    }
                }
                ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#tableID').DataTable();
            });
        </script>
    </div>
</body>
</html>