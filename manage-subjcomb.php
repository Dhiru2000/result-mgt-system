<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}
if (isset($_GET['acid'])) {
    $acid = intval($_GET['acid']);
    $status = 1;
    $sql = "UPDATE subject_comb set status = $status where comb_id = $acid";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;
}

if (isset($_GET['did'])) {
    $did = intval($_GET['did']);
    $status = 0;
    $sql = "UPDATE subject_comb set status = $status where comb_id = $did";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subject Combinations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(120deg, #f6d365, #fda085);
            color: #333;
        }

        .container {
            width: 90%;
            margin: auto;
            margin-top: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        h1, h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: #fff;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        table tbody tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        table a {
            text-decoration: none;
            color: #3498db;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        table a:hover {
            color: #2980b9;
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
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <?php
    if ($showAlert) {
        echo '<script>alert("Subject status updated successfully!")</script>';
    }
    ?>
    <div class="container">
        <h1>Manage Subject Combinations</h1>
        <h3>* View and Manage Subject Combinations</h3>
        <table id="tableID" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT branch.branch, semester.semester, subjects.subj_name, subject_comb.comb_id as scid, subject_comb.status 
                        FROM subject_comb 
                        JOIN branch ON subject_comb.branch_id = branch.branch_id 
                        JOIN semester ON subject_comb.sem_id = semester.sem_id 
                        JOIN subjects ON subjects.subj_id = subject_comb.subj_id 
                        ORDER BY semester";
                $result = mysqli_query($conn, $sql);
                $c = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$c}</td>
                            <td>{$row['branch']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$row['subj_name']}</td>
                            <td>" . ($row['status'] == 1 ? 'Active' : 'Blocked') . "</td>
                            <td>";
                    if ($row['status'] == 0) {
                        echo "<a href='manage-subjcomb.php?acid={$row['scid']}' onclick='return confirm(\"Do you really want to activate this subject?\");'>
                                <i class='fa fa-check' title='Activate Record'></i>
                              </a>";
                    } else {
                        echo "<a href='manage-subjcomb.php?did={$row['scid']}' onclick='return confirm(\"Do you really want to deactivate this subject?\");'>
                                <i class='fa fa-times' title='Deactivate Record'></i>
                              </a>";
                    }
                    echo "</td>
                          </tr>";
                    $c++;
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