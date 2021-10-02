<?php session_start();?>
<?php include("db_connect.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <section class="main">
        <div class="main-heading text-center">
            <h1>Signup</h1>
            <p class="error"><?php 
                if(isset($_SESSION["not_logged_in"])){
                    echo $_SESSION["not_logged_in"];
                }
                else{
                    if(isset($_SESSION["exist_user"])){
                        echo $_SESSION["exist_user"];
                    }
                }
                 
            ?></p>
        </div>
        <div class="main-form">
            <form action="" method="POST" class="text-center" enctype="multipart/form-data">
                <input type="email" name="email" placeholder="Email Address" autocomplete="off" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <input type="file" name="user_image" class="form-input" required>
                <input type="submit" name="signup_button" value="Signup" class="submit-button">
            </form>
        </div>
    </section>
    <?php
        if(isset($_POST["signup_button"])){
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $search_user_sql = "SELECT * FROM login WHERE email='$email'";
            $res_search_user = mysqli_query($conn, $search_user_sql);
            if($res_search_user == TRUE){
                $count = mysqli_num_rows($res_search_user);
                if($count > 0){
                    $_SESSION["exist_user"] = "This user already exists.";
                    unset($_SESSION["not_logged_in"]);
                    header("Refresh:0, url=http://localhost/PHP_PROJECTS/Challenge_Tracker/signup.php");
                }
                else{
                    $user_image = $_FILES["user_image"]["name"];
                    $user_image_name_extension = end(explode('.', $user_image));
                    $user_image_name = "user_image-".rand(000, 999).".".$user_image_name_extension;
                    $source_path = $_FILES["user_image"]["tmp_name"];
                    $destination_path = "uploads/".$user_image_name;
                    $uploaded = move_uploaded_file($source_path, $destination_path);
                    $sql = "INSERT INTO login(email, password,user_image) VALUES('$email', '$password', '$user_image_name')";
                    $res = mysqli_query($conn, $sql);
        
                    if($res == TRUE){
                        unset($_SESSION["no_logged_in"]);
                        $_SESSION["logged_in"] = "You can now login.";
                        header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker"); 
                    }
                }
            }
           
            
        }
    ?>
</body>
</html>