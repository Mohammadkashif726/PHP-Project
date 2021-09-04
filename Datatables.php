<?php
    //Connecting to database
    $db = mysqli_connect("localhost", "root", "", "codingtest");
    $result = mysqli_query($db, "SELECT * FROM users ORDER BY ID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"/>
</head>
<body>
    <br></br>
    <div class="container">
        <h3 align="center">Database Jquery Plugin with php Mysql and Bootstrap</h3>
        <br />
        <!--Displaying the data in HTML Format For Searching and Sorting-->
        <form method="post" action="export.php">
            <input type="submit" name="export" class="btn justify-center btn-primary" value="CSV EXPORT" />
        </form>
        <div class="table-responsive">
            <table id="employee_data" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Designation</td>
                    <td>SalaryDate</td>
                </tr>
            </thead>
            <?php
            while($row = mysqli_fetch_array($result))
            {
                echo '
                <tr>
                    <td>'.$row["name"].'</td>
                    <td>'.$row["email"].'</td>
                    <td>'.$row["designation"].'</td>
                    <td>'.$row["SalaryDate"].'</td>
                </tr>
                ';
            }
            ?>
            </table>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#employee_data').DataTable();
    })
</script>