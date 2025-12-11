<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// CREATE POST
if (isset($_POST["postBtn"])) {
    $content = trim($_POST["content"]);

    if ($content != "") {
        $sql = $conn->prepare("INSERT INTO posts (user_id, content, created_at) 
                                      VALUES (?, ?, NOW())");
        $sql->bind_param("is", $user_id, $content);
        header("Location: index.php");
        $sql->execute();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">

    <div class="sidebar">
        <div class="part1">
            <h2><?php echo htmlspecialchars($username); ?></h2>
            <a class="side-link" href="profile.php"><i class="fa-regular fa-circle-user"></i> Profile</a>
            <hr>
        </div>

        <div class="part2">
            <div class="top-text">
                <h5>People You May Follow</h5>
                <h6>suggest</h6>
            </div>
            <div class="follow-content"></div>
        </div>

        <div class="part3">
            <hr>
            <a class="side-link" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

   <div class="main">

        <!-- Create Post -->
        <div class="post-box">
            <h3>Create a Post</h3>
            <form method="post">
                <textarea name="content" placeholder="What's on your mind?" rows="5" required></textarea>
                <button name="postBtn">Post</button>
            </form>
        </div>

        <h3>All Posts</h3>
        <div class="posts-container">
            <?php
            $all = $conn->query("SELECT posts.*, userdata.username 
                                 FROM posts 
                                 JOIN userdata ON posts.user_id = userdata.user_id 
                                 ORDER BY posts.id DESC");

            while ($row = $all->fetch_assoc()) {
                echo "<div class='post'>
                        <div class='post-header'>
                            <span class='username'>".htmlspecialchars($row['username'])."</span>
                            <small class='post-time'>".$row['created_at']."</small>
                        </div>
                        <p class='post-content'>".htmlspecialchars($row['content'])."</p>
                      </div>";
            }
            ?>
        </div>

    </div>



    
    <div class="rightbar">
        <h3>Trending</h3>
        <div class="trend-box">
            <p># Nature</p>
            <p># Programming</p>
            <p># Photography</p>
        </div>

        <h3>Notifications</h3>
        <div class="notify-box">
            <p>No new notifications</p>
        </div>
    </div>

</div>
</body>
</html>
