<?php
include("database.php");
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create Post</title>
</head>
<body>
    <form action="#" method="post">
        <label for="post">Write a Post</label>
        <textarea name="post" id="post" placeholder="Write a post..."></textarea> <br>
        <button name="postcontent" id="postcontent">Post!</button>
    </form>
</body>
</html>

<?php
if(isset($_POST["postcontent"])) {
    $content = $_POST["post"];
    $username = $_SESSION["user_id"];

    $sql = "INSERT INTO `posts` ('user_id' , 'content' , 'created_at')
            VALUES ('$user_id' , '$content' , NOW() )";

    mysqli_query($conn, $sql);

    header("location: index.php");
}


?>