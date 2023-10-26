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
    <title>Login Form</title>
</head>
<body>
    <div class="container">
        <?php
    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user ) {
            if (password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user"] = "yes";

                header("Location: index.html");
                die();
            } else{
            echo "<div class='alert alert-danger' style='width: 95%;
            height: 7vh;
            border-radius: 15px;
            background-color: #FF6347;
            margin-bottom: 10px;'><div class='im'> Password does not match </div> </div>";
            }
        } else {
            echo "<div class='alert alert-danger' style='width: 95%;
            height: 7vh;
            border-radius: 15px;
            background-color: #FF6347;
            margin-bottom: 10px;'><div class='im'> Email does not match </div> </div>";
        }
    }
        ?>
        <form action="login.php" method="post">
        <div id="form-group">
                <input type="email" placeholder="Enter Email:" name="email" id="form-control">
            </div>
            <div id="form-group">
                <input type="password" placeholder="Enter Password:" name="password" id="form-control">
            </div>
            <div id="form-btn">
                <input type="submit" value="Login" name="login" style="width: 20%;background-color: #C0C0C0; height:5vh ; border:0;
                cursor:pointer; border-radius: 10px" id="btn btn-primary">
            </div>
        </form>
        <div><p>Not Registered yet <a href="registration.php">Register Here</a></p></div>
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
            height: 5.5vh;
            border: 0;
            outline: 0;
            background-color: transparent;
        }
        body{
            padding: 50px;
        }

        .container{
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        #form-group{
            margin-bottom: 30px
        }
        .im{
            position: relative; display: flex; height: 6.5vh; align-items: center;justify-content: center;
        }



    </style>
</body>
</html>