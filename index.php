<?php
    session_start();
    //Connecting to Database
    $db = mysqli_connect("localhost", "root", "", "codingtest");

    //Initializing some variables which i use later in the code
    $update = false;
    $id = 0;
    $Name = "";
    $Email = "";
    $Designation = "";
    $SalaryDate = "";

    //Checking if the submit button and captcha is pressed.
    if(isset($_POST['submit']) && $_POST['g-recaptcha-response'] != ""){
        $secret = "6LdNK0UcAAAAAAAsBZbifyFjbnHeKIXoycBk7pb0";
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
            //Extracting variables from html code to add them in the database
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $designation = mysqli_real_escape_string($db, $_POST['designation']);
            $salarydate = mysqli_real_escape_string($db, $_POST['salarydate']);

            //Inserting in to the database
            $sql = "INSERT INTO users (name, email, designation, salarydate) VALUES ('$name', '$email', '$designation', '$salarydate')";
            mysqli_query($db, $sql);
            $_SESSION['message'] = "Record has been saved!";
            $_SESSION['msg_type'] = "success";
            }
    }

    //Checking if the delete button is pressed
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        mysqli_query($db, "DELETE FROM users WHERE id=$id");
        $_SESSION['message'] = "Record has been deleted!";
        $_SESSION['msg_type'] = "danger";

    }
    //Checking if the update button is pressed
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $update_name = $_POST['name'];
        $update_email = $_POST['email'];
        $update_designation = $_POST['designation'];
        $update_salarydate = $_POST['salarydate'];

        mysqli_query($db, "UPDATE users SET name='$update_name', email='$update_email', designation='$update_designation', SalaryDate='$update_salarydate' WHERE id=$id");
        $_SESSION['message'] = "Record has been Updated";
        $_SESSION['msg_type'] = "warning";
    }

    //Cecking if the edit button is pressed
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $update = true;
        $result = mysqli_query($db, "SELECT * FROM users WHERE id=$id");
        if(mysqli_num_rows($result)==1){
            $row = $result->fetch_array();
            $Name = $row['name'];
            $Email = $row['email'];
            $Designation = $row['designation'];
            $SalaryDate = $row['SalaryDate'];
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <?php
    
    //Displaying messages
    if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?=$_SESSION['msg_type']?>">
        <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        ?>
    </div>
    <?php endif ?>
    <?php
        
        //Connect to database
        $db = mysqli_connect("localhost", "root", "", "codingtest");
        $results = mysqli_query($db, "SELECT * FROM users");
    ?>

    <!--Displaying the Crud HTML Form-->
        <div class="row justify-content-center">
            <table class="table">
                <thread>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>SalaryDate</th>
                    </tr>
                </thread>
        <?php
        //Fetching all the information available in the database
            while($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['SalaryDate']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
        <?php endwhile; ?>
            </table>
        </div>
        <?php
        function pre_r($array){
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        }
    ?>
    <!--Main Registration Form-->
    <div class="row justify-content-center">
        <div class="row">
            <div class="col"></div>
                <div class="col-20">
                    <div class="card">
                        <div class="card-header text-center">
                            Registration Form
                        </div>
                        <div class="card-body">
                            <form action="index.php" method="POST">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="form-group">
                                    <label for="exampleInputEmail">Name</label>
                                    <input type="text" required class="form-control" name="name" value="<?php echo $Name; ?>" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $Email; ?>" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Designation</label>
                                    <input type="text" class="form-control" name="designation" value="<?php echo $Designation; ?>" placeholder="Enter Designation">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Salary Date</label>
                                    <input type="text" class="form-control" name="salarydate" value="<?php echo $SalaryDate; ?>" placeholder="Enter Salary Date">
                                </div>
                                <div class="g-recaptcha" data-sitekey="6LdNK0UcAAAAABc9JYDKC36uuRiqgeZLXEnhWvDH"></div>
                                <div class="form-group">
                                <?php
                                if($update == true):
                                    ?>
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                <?php   else: ?>
                                    <button type="submit" class="btn btn-primary" name="submit">Register</button>
                                <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
</body>
</html>