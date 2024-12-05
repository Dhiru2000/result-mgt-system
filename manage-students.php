<?php
session_start();
$showAlert = false;
$showError = false;
include "includes/connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
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
    <title>Manage Students</title>
    <link rel="stylesheet" type="text/css" href="css/fp1.css?version=51">
    
    <!-- Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    
    <!-- jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <!-- Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <!-- Animation CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* Global styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Page container */
        .m2 {
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            animation: fadeInUp 1s ease-out;
            text-align: center;
        }

        /* College name styling */
        .college-name {
            font-size: 32px;
            color: #283593;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeInDown 1.5s ease-out;
        }

        /* Title Styling */
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4CAF50;
            animation: fadeInUp 1s ease-out;
        }

        /* Subtitle styling */
        h3 {
            font-size: 20px;
            margin-bottom: 50px;
            color: #555;
            animation: fadeInUp 1.5s ease-out;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        /* Page load animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Centered content */
        .content {
            margin-top: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Navbar Style (scrollable) */
        .navbar {
            background-color: #283593;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: inline-block;
            font-size: 16px;
        }

        .navbar a:hover {
            background-color: #ff6347;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    
    <div class="m2 animate__animated animate__fadeInUp">
        <!-- College Name -->
        <div class="college-name animate__animated animate__fadeInDown">Kathmandu Model College</div>

        <!-- Manage Students Title -->
        <h1>Manage Students</h1>
        <h3>* View Students Info</h3>
        
        <!-- Data Table -->
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
$sql = "SELECT student.Name, student.Roll_No, student.Reg_date, student.status, student.reg_id, branch.branch, semester.semester 
        FROM student 
        JOIN branch ON student.branch_id = branch.branch_id 
        JOIN semester ON student.sem_id = semester.sem_id";
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
            <td><?php echo ($row['status'] == 1) ? "Active" : "Blocked"; ?></td>
            <td><a href="edit-student.php?stid=<?php echo $row['reg_id']; ?>"><i class="fa fa-edit" title="Edit Record"></i></a></td>
        </tr>
        <?php
        $c++;
    }
}
?>
            </tbody>
        </table>

        <!-- DataTable Initialization -->
        <script>
            $(document).ready(function() {
                $('#tableID').DataTable();
            });
        </script>
    </div>
</body>
</html>