<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// DELETE POST
if (isset($_GET["delete"])) {
    $pid = $_GET["delete"];

    $sql = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $sql->bind_param("ii", $pid, $user_id);
    $sql->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $username; ?>'s Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">

    <div class="sidebar">
        <h2><?php echo htmlspecialchars($username); ?></h2>
        <a class="side-link" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a class="side-link" href="settings.php"><i class="fa-solid fa-gear"></i>Setting</a>
        <a class="side-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main">
        <h3>Your Posts</h3>

        <div class="posts-container">
            <?php
            $myposts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC");
            $myposts->bind_param("i", $user_id);
            $myposts->execute();
            $result = $myposts->get_result();

            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='post'>
                        <p>" . htmlspecialchars($row["content"]) . "</p>
                        <small>".$row["created_at"]."</small>
                        <div class='post-actions'>
                            <a href='update.php?id=".$row["id"]."'><i class='fa-solid fa-pen'></i> Edit Post</a>
                            <a href='profile.php?delete=".$row["id"]."'><i class='fa-solid fa-trash'></i> Delete</a>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No posts yet!</p>";
            }
            ?>
        </div>
    </div>

</div>
</body>
</html>
