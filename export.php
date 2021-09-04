<?php
if(isset($_POST['export'])){
    $db = mysqli_connect("localhost", "root", "", "codingtest");
    $result = mysqli_query($db, "SELECT * FROM users ORDER BY ID DESC");
    header('Content-Type: text/csv; charset=utf8');
    header('Content-Disposition: attachement; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('id', 'name', 'email', 'designation', 'SalaryDate'));
    while($row = mysqli_fetch_assoc($result)){
        fputcsv($output, $row);
    }
    fclose($output);
}

?>