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
    <title>Manage Semester</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/fp1.css?version=51">
    
    <!-- Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />

    <!-- jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <style>
        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #00bcd4, #ff9800); /* Vibrant background */
            margin: 0;
            padding: 0;
        }

        /* Main Box Styling */
        .m2 {
            width: 80%;
            margin: 80px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out forwards; /* Fade-in effect */
            opacity: 0;
        }

        /* Animation for Box */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Table shadow */
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        th {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        tr:hover {
            background-color: #f2f2f2;
            transform: scale(1.03); /* Slight scale-up on hover for effect */
        }

        /* Button Styling */
        .modal-button {
            font-size: 18px;
            background-color: #6a11cb;
            color: white;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            border-radius: 25px; /* Rounded buttons */
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .modal-button:hover {
            background-color: #2575fc;
            transform: translateY(-5px); /* Button lift effect */
        }

        /* Modal Box Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            width: 400px;
            animation: modalFadeIn 0.5s ease-out forwards;
        }

        .modal-header {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .close {
            float: right;
            font-size: 30px;
            color: #aaa;
            cursor: pointer;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .m2 {
                width: 90%;
                padding: 20px;
            }

            table {
                font-size: 14px;
            }

            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <?php include "nav.php";?>

    <div class="m2">
        <h1 style="text-align:center;">Manage Semester</h1>
        <h3 style="margin: 20px; margin-bottom:50px">* View Semesters</h3>

        <table id="tableID" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 60%">Semester</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th style="width: 60%">Semester</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT sem_id, semester FROM semester";
                $result = mysqli_query($conn, $sql);
                $c = 1;
                $num = mysqli_num_rows($result);
                if($num > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <td><?php echo $c;?></td>
                        <td><?php echo $row['semester'];?></td>
                        <td>
                            <button class="modal-button" onclick="openModal('<?php echo $row['sem_id'];?>', '<?php echo $row['semester'];?>')">Edit</button>
                        </td>
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

            // Open modal for editing
            function openModal(semId, semester) {
                document.getElementById('editModal').style.display = 'flex';
                document.getElementById('modal-sem-id').value = semId;
                document.getElementById('modal-semester').value = semester;
            }

            // Close modal
            function closeModal() {
                document.getElementById('editModal').style.display = 'none';
            }
        </script>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">Edit Semester</div>
            <form method="POST" action="edit-semester-action.php">
                <label for="modal-semester">Semester</label>
                <input type="text" name="semester" id="modal-semester" required>
                <input type="hidden" name="sem_id" id="modal-sem-id">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

</body>
</html>