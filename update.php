<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$post_id = $_GET["id"];

// fetch the post
$sql = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$sql->bind_param("ii", $post_id, $user_id);
$sql->execute();
$result = $sql->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post not found!");
}

// update
if (isset($_POST["updateBtn"])) {
    $content = trim($_POST["content"]);

    $update = $conn->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("sii", $content, $post_id, $user_id);

    if ($update->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Update failed!";
    }
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Edit Post</h2>

<form method="post">
    <textarea name="content" rows="5" cols="40"><?php echo $post["content"]; ?></textarea><br><br>
    <button name="updateBtn">Update</button>
</form>

</body>
</html>
