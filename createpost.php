<?php
include("database.php");
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

if (isset($_POST["postBtn"])) {
    $content = trim($_POST["content"]);
    $user_id = $_SESSION["user_id"];
    $imagePath = null;
    $videoPath = null;


    if (!empty($_FILES['post_image']['name'])) {

        $imgName = time() . '_' . basename($_FILES['post_image']['name']);
        $imgTmp  = $_FILES['post_image']['tmp_name'];

        $imagePath = "uploads/" . $imgName;
        move_uploaded_file($imgTmp, $imagePath);
    }

    // VIDEO UPLOAD
    if (!empty($_FILES['post_video']['name'])) {
        $vidName = time() . '_' . basename($_FILES['post_video']['name']);
        $vidTmp  = $_FILES['post_video']['tmp_name'];
        $videoPath = "upload/" . $vidName;
        move_uploaded_file($vidTmp, $videoPath);
    }

    // INSERT INTO DATABASE
    if ($content != "" || $imagePath || $videoPath) {
        $sql = "INSERT INTO posts (user_id, content, post_image, post_video, created_at) 
                VALUES ('$user_id','$content','$imagePath','$videoPath',NOW())";
        mysqli_query($conn, $sql);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>

<body>

    <form action="#" method="post" enctype="multipart/form-data">
        <label for="post">Write a Post</label><br>
        <textarea name="content" id="post" placeholder="Write a post..." rows="5" required></textarea> <br><br>

        <label>Upload Image:</label>
        <input type="file" name="post_image" accept="image/*"><br><br>

        <label>Upload Video:</label>
        <input type="file" name="post_video" accept="video/*"><br><br>

        <button name="postBtn" id="postBtn">Post!</button>
    </form>

</body>

</html>