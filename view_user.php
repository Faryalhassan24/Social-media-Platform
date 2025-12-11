<?php
session_start();
include("database.php");

if (!isset($_GET["id"])) {
    die("User not found.");
}

$user_id = $_GET["id"];

// fetch user info
$sql = $conn->prepare("SELECT username, email, DateRegistered FROM userdata WHERE user_id = ?");
$sql->bind_param("i", $user_id);
$sql->execute();
$user = $sql->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// fetch user's posts
$post_sql = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$post_sql->bind_param("i", $user_id);
$post_sql->execute();
$posts = $post_sql->get_result();
?>
<!DOCTYPE html>
<html>
<body>

<h2><?php echo $user['username']; ?>'s Profile</h2>
<p><b>Email:</b> <?php echo $user["email"]; ?></p>
<p><b>Joined:</b> <?php echo $user["DateRegistered"]; ?></p>

<h3>Posts:</h3>

<?php while ($row = $posts->fetch_assoc()) : ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <p><?php echo $row["content"]; ?></p>
        <small><?php echo $row["created_at"]; ?></small>
    </div>
<?php endwhile; ?>

</body>
</html>
