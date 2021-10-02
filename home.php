<?php
    session_start();
?>
<?php include("db_connect.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Challenge</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="main">
        <div class="main-heading text-center">
            <h1>Track Your Challenge</h1>
                <p>Welcome <?php 
                    if(isset($_SESSION["email"])){
                        echo $_SESSION["email"];
                    }
                    else{
                        header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker");
                    }
                ?></p>
                <p>
                    <?php
                        if(isset($_SESSION["user_image"])){
                            $user_image = $_SESSION["user_image"];
                            echo "<img src='uploads/$user_image' class='user-image'>";
                        }
                    ?>
                </p>
                <a href="http://localhost/PHP_PROJECTS/Challenge_Tracker"><input type="submit" name="logout_button" value="Logout" class="logout-button"></a>
        </div>
        <div class="main-form">
            <form action="" method="POST" class="text-center">
                <input type="text" name="task" placeholder="Enter Your Challenge" class="form-input" required>
                <input type="submit" name="submit_button" value="+" class="submit-button">
            </form>
        </div>
    </section>
    <section class="data">
        <div class="data-list">
                <ul>
                <?php 
                    $user_id = $_SESSION["user_id"];
                    $sql_2 = "SELECT * FROM tbl_challenge WHERE user_id=$user_id ORDER BY id DESC";
                    $res_2 = mysqli_query($conn, $sql_2);
                    $count = mysqli_num_rows($res_2);
                    if($count > 0){
                        while($row = mysqli_fetch_assoc($res_2)){
                            $id = $row["id"];
                            $update_url = "update.php";
                            echo "<form action='' method='POST'>";
                            echo "<li>".$row["task"]
                            ."<input type='hidden' name='id' value=$id>"
                            ."<input type='submit' name='delete_button' value='DELETE' class='delete-button'>"
                            ."<input type='submit' name='update_button' value='UPDATE' class='update-button'>"
                            ."</li>";
                            echo "</form>";

                        }
                    }
                    
                    ?>
                </ul>
        </div>
    </section>
    <?php 
        if(isset($_POST["submit_button"])){
            $task = $_POST["task"];
            $user_id = $_SESSION["user_id"];
            $sql = "INSERT INTO tbl_challenge(task, user_id) VALUES('$task', $user_id)";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                header("Refresh:0; url=http://localhost/PHP_PROJECTS/Challenge_Tracker/home.php");
            }
        }
        if(isset($_POST["delete_button"])){
            if(isset($_POST["id"])){
                $id = $_POST["id"];
                $sql_del = "DELETE FROM tbl_challenge where id=$id";
                $del_res = mysqli_query($conn, $sql_del);
                if($del_res == TRUE){
                    header("Refresh:0; url=http://localhost/PHP_PROJECTS/Challenge_Tracker/home.php");
                }
            }
        }
        if(isset($_POST["update_button"])){
            if(isset($_POST["id"])){
                $id = $_POST["id"];
                $_SESSION["id"] = $id;
                header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker/update.php");
            }
        }
    ?>
</body>
</html>