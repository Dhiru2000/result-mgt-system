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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
    <!-- Include FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #f6d365, #fda085);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .m2 {
            margin: 50px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            font-size: 2.5em;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        h3 {
            text-align: center;
            color: #444;
            margin-bottom: 30px;
            font-size: 1.2em;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            color: #45a049;
        }
        /* Add animation */
        .table-container {
            opacity: 0;
            animation: fadeIn 1.5s forwards;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <div class="m2 table-container">
        <h1>Manage Subjects</h1>
        <h3>* View Subjects</h3>
        <table id="tableID" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT subjects.subj_id,subjects.subj_name, subjects.subj_code , subjects.status from subjects";
                $result = mysqli_query($conn, $sql);
                $c = 1;
                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $c; ?></td>
                            <td><?php echo $row['subj_name']; ?></td>
                            <td><?php echo $row['subj_code']; ?></td>
                            <td><?php echo ($row['status'] == 1) ? "Active" : "Inactive"; ?></td>
                            <td><a href="edit-subjects.php?subid=<?php echo $row['subj_id']; ?>"><i class="fa fa-edit" title="Edit Record"></i></a></td>
                        </tr>
                <?php
                        $c++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        /* Initialization of DataTable */
        $(document).ready(function() {
            $('#tableID').DataTable();
        });
    </script>
</body>
</html>