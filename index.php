<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

if (isset($_POST["postBtn"])) {
    $content = trim($_POST["content"]);
    $imagePath = null;
    $videoPath = null;

    if (!empty($_FILES['post_image']['name'])) {

        $imgName = time() . '_' . basename($_FILES['post_image']['name']);
        $imgTmp  = $_FILES['post_image']['tmp_name'];

        $imagePath = "uploads/" . $imgName;  
        move_uploaded_file($imgTmp, $imagePath);
    }

   

    if (!empty($_FILES['post_video']['name'])) {
        $vidName = time() . '_' . basename($_FILES['post_video']['name']);
        $vidTmp  = $_FILES['post_video']['tmp_name'];
        $videoPath = "upload/" . $vidName;
        move_uploaded_file($vidTmp, $videoPath);
    }

    if ($content != "" || $imagePath || $videoPath) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, content, post_image, post_video, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $user_id, $content, $imagePath, $videoPath);
        $stmt->execute();
        header("Location: index.php");
        exit();
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
                    <h3>People You May Follow</h3>
                    <h5>suggest</h5>
                </div>
                <div class="follow-content">
                    <?php
                    $users = $conn->query("SELECT * FROM userdata WHERE user_id != $user_id");
                    if ($users->num_rows > 0) {
                        while ($row = $users->fetch_assoc()) {
                            echo "<div class='follow-user'>";
                            echo "<span>" . htmlspecialchars($row['username']) . "</span>";
                            echo " <button class='follow-button'>Follow</button>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No users to suggest.</p>";
                    }
                    ?>
                </div>
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
                <form method="post" enctype="multipart/form-data">
                    <textarea name="content" placeholder="What's on your mind?" rows="4"></textarea>

                    <input type="file" id="imageUpload" name="post_image" accept="image/*" hidden>
                    <label for="imageUpload" class="image-icon"><i class="fa-solid fa-image"></i></label>

                    <input type="file" id="videoUpload" name="post_video" accept="video/*" hidden>
                    <label for="videoUpload" class="video-icon"><i class="fa-solid fa-video"></i></label>

                    <!-- <div id="preview-box"></div> -->
                    <button name="postBtn">Post</button>
                </form>
            </div>

            <h3>All Posts</h3>
            <div class="posts-container">
                <?php
                $all = $conn->query("SELECT posts.*, userdata.username FROM posts 
                                 JOIN userdata ON posts.user_id = userdata.user_id 
                                 ORDER BY posts.id DESC");
                while ($row = $all->fetch_assoc()) {
                    echo "<div class='post'>
                        <div class='post-header'>
                            <span class='username'>" . htmlspecialchars($row['username']) . "</span>
                            <small class='post-time'>" . $row['created_at'] . "</small>
                        </div>
                        <p class='post-content'>" . htmlspecialchars($row['content']) . "</p>";

                    if ($row['post_image']) {
                        echo "<img src='" . htmlspecialchars($row['post_image']) . "' style='max-width:30%; margin-top:8px; border-radius:8px;'>";
                    }
                    if ($row['post_video']) {
                        echo "<video src='" . htmlspecialchars($row['post_video']) . "' controls style='max-width:30%; margin-top:8px; border-radius:8px;'></video>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div class="rightbar">
            <div class="search">
                <input type="text" placeholder="search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
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

    <!-- <script>
        const imageInput = document.getElementById("imageUpload");
        const videoInput = document.getElementById("videoUpload");
        const previewBox = document.getElementById("preview-box");

        imageInput.addEventListener("change", function() {
           previewBox.innerHTML = "";
            const file = this.files[0];
            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file); //Temporary browser URL create
                img.style.maxWidth = "50%";
                previewBox.appendChild(img);
            }
            videoInput.value = "";
        });

        videoInput.addEventListener("change", function() {
            previewBox.innerHTML = "";
            const file = this.files[0];
            if (file) {
                const video = document.createElement("video");
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.style.maxWidth = "50%";
                previewBox.appendChild(video);
            }
            imageInput.value = "";
        });
    </script> -->
    <script src="Follow-request.js"></script>
</body>

</html>