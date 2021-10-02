<?php session_start(); ?>
<?php include("db_connect.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <section class="main">
        <div class="main-heading text-center">
            <h1>Login</h1>
            <p class="logged-in"><?php 
                if(isset($_SESSION["logged_in"])){
                   echo $_SESSION["logged_in"]; 
                }
                
            ?></p>
        </div>
        <div class="main-form">
            <form action="" method="POST" class="text-center">
                <input type="email" name="email" placeholder="Email Address" autocomplete="off" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <input type="submit" name="login_button" value="Login" class="submit-button">
            </form>
        </div>
    </section>
    <?php
        if(isset($_POST["login_button"])){
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);
                if($count > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["user_id"] = $row["id"];
                        $_SESSION["user_image"] = $row["user_image"];
                        unset($_SESSION["logged_in"]);
                        header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker/home.php");
                    }
                    
                }
                else{
                    $_SESSION["not_logged_in"] = "Failed to login. Please sign up first.";
                    header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker/signup.php");
                }
                
            }
            
        }
        else{
            unset($_SESSION["email"]);
        }
        
    ?>
</body>
</html>