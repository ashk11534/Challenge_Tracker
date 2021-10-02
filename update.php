<?php session_start(); ?>
<?php include("db_connect.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Challenge</title>
    <link rel="stylesheet" href="css/update.css">
</head>
<body>
    <div class="main-form-update text-center">
        <form action="" method="POST" class="text-center">
            <input type="text" name="task" placeholder="Update Your Challenge" class="form-input" required>
            <input type="submit" name="submit_button" value="UPDATE" class="submit-button">
        </form>
    </div>
    <?php
        if(isset($_POST["task"])){
                $task = $_POST["task"];
                $id = $_SESSION["id"];
                $sql_update = "UPDATE tbl_challenge SET task='$task' WHERE id=$id";
                $res_update = mysqli_query($conn, $sql_update);
                $sql = "SELECT * FROM  tbl_challenge WHERE user_id=$id";
                $res = mysqli_query($conn, $sql);

                if($res_update == TRUE){
                    $count = mysqli_num_rows($res);
                    if($count > 0){
                        while($row = mysqli_fetch_assoc($res)){
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["user_id"] = $row["id"];
                        }
                        
                    } 
                    header("location:"."http://localhost/PHP_PROJECTS/Challenge_Tracker/home.php");
                }
                
        }
    ?>
</body>
</html>