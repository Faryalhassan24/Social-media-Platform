<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
<a href="logout.php">Logout</a>

<hr>

<h3>Create a Post</h3>
<form action="add_post.php" method="POST">
    <textarea name="content" rows="4" cols="40" required></textarea><br><br>
    <button name="post">Post</button>
</form>

<hr>

<h3>All Posts</h3>


</body>
</html>


<?php

$sql = "SELECT posts.content, posts.created_at, userdata.username
        FROM posts
        JOIN userdata ON posts.user_id = userdata.user_id
        ORDER BY posts.id DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<p><b>".$row["username"]."</b>: ".$row["content"]." <br>
          <small>".$row["created_at"]."</small></p><hr>";
}




// $sql = "SELECT posts.id, posts.content, posts.created_at, userdata.username 
//         FROM posts
//         JOIN users ON posts.username = usersdata.username
//         ORDER BY posts.id DESC";

// $result = mysqli_query($conn, $sql);

// // $rownum = mysqli_num_rows($result);

// while ($row = mysqli_fetch_assoc($result)) {
//     echo "<p><b>{$row['username']}</b>: {$row['content']}</p>";
//     echo "<small>{$row['created_at']}</small><br>";

//     echo "<a href='edit_post.php?id={$row['id']}'>Edit</a> | ";
//     echo "<a href='delete_post.php?id={$row['id']}'>Delete</a>";
//     echo "<hr>";
// }


// $name = $_SESSION["username"];

// echo "<br>welcome '$name' you are logged in!<br>";



// echo "<h2> Here are the number of entries in the database</h2>";

// $sql = "SELECT * FROM `userdata`";
// $result = mysqli_query($conn, $sql);


// $rownum = mysqli_num_rows(($result));
// echo $rownum;

// echo "<br>";

// // $row =  mysqli_fetch_assoc($result);

// // var_dump($row);
// // echo "<br>";


// while ($row = mysqli_fetch_assoc($result)) {
//     echo $row['username'] . " " . $row['email'];
//     echo "<br>";
// }





?>