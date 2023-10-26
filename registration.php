 <?php
 session_start();
 if (isset($_SESSION["user"])) {
    header("Location: index.html");
 }
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
    if(isset($_POST["submit"])) {
        $fullName = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["repeat_password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();

        if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) ) {
            array_push($errors, "All fields are required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 charactes long ");
        }
        if ($password!==$passwordRepeat) {
            array_push($errors, "Password does not match ");
        }

        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);

        if ($rowCount > 0) {
            array_push($errors, "Email alredy exists!");
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo  "<div style='' class ='alert alert-danger'><div class='im'> $error </div></div>";
            }   
        }
        else{
            $sql = "INSERT INTO users (full_name , email , password) VALUES (?,?,? ) ";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div style='position: relative; display: flex; height: 6.5vh; align-items: center;justify-content: center;' class='alert alert-success'>You are registered successfully.</div>";
            } else{
                die("Something went wrong ");
            }
        }
    }

        ?><br>
        <form action="registration.php" method="post">
        <div id="form-group">
                <input type="text" id="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div id="form-group">
                <input type="email"id="form-control" name="email" placeholder="Email:">
            </div>
            <div id="form-group">
                <input type="password"id="form-control" name="password" placeholder="Password:">
            </div>
            <div id="form-group">
                <input type="text" id="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div id="form-btn">
                <input type="submit" style="width: 20%;background-color: #C0C0C0; height:5vh ; border:0;
                cursor:pointer; border-radius: 10px" id="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Alredy regestered <a href="login.php">Login here</a></p></div>

    </div>


    <style>
        #form-group{
            background-color: #fff;
            width: 95%;
            height: 6vh;
            border-radius: 1px;
            border: 0.5px solid #1E90FF;
            border-radius: 15px;
            margin-bottom: 30px;
            transition: border 0.2;
            
        }
        #form-control{
            width: 94%;
            position: relative;
            left: 3%;
            height: 5vh;
            border: 0;
            outline: 0;
            background-color: transparent;
        }
        .alert-success{
            width: 95%;
            height: 7vh;
            border-radius: 15px;
            background-color: #90EE90;
        }
        .alert-danger{
            width: 95%;
            height: 7vh;
            border-radius: 15px;
            background-color: #FF6347;
            margin-bottom: 10px;
        }
        .im{
            position: relative; display: flex; height: 6.5vh; align-items: center;justify-content: center;
        }
        #btn-primary{
            width: 30%;
            background-color: #C0C0C0;
        }
    </style>
</body>
</html>