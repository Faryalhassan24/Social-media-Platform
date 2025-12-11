<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// fetch user info
$user_sql = $conn->prepare("SELECT username, email, DateRegistered FROM userdata WHERE user_id = ?");
$user_sql->bind_param("i", $user_id);
$user_sql->execute();
$user_result = $user_sql->get_result();
$user = $user_result->fetch_assoc();

// fetch user's posts
$post_sql = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$post_sql->bind_param("i", $user_id);
$post_sql->execute();
$posts = $post_sql->get_result();

// count posts
$count_sql = $conn->prepare("SELECT COUNT(*) AS total_posts FROM posts WHERE user_id = ?");
$count_sql->bind_param("i", $user_id);
$count_sql->execute();
$count_result = $count_sql->get_result()->fetch_assoc();
$total_posts = $count_result["total_posts"];
?>
<!DOCTYPE html>
<html>

<body>

<h2>Your Profile</h2>

<h3>User Info</h3>
<p><b>Username:</b> <?php echo $user["username"]; ?></p>
<p><b>Email:</b> <?php echo $user["email"]; ?></p>
<p><b>Date Joined:</b> <?php echo $user["DateRegistered"]; ?></p>
<p><b>Total Posts:</b> <?php echo $total_posts; ?></p>

<a href="edit_profile.php">Edit Profile</a>
<br><br>

<h3>Your Posts:</h3>

<?php while ($row = $posts->fetch_assoc()) : ?>
    <div style="border:1px solid #aaa; padding:10px; margin-bottom:10px;">
        <p><?php echo $row["content"]; ?></p>
        <small><?php echo $row["created_at"]; ?></small><br>
        <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> |
        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this post?');">Delete</a>
    </div>
<?php endwhile; ?> 

</body>
</html>
