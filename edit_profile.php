.<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// fetch user info
$sql = $conn->prepare("SELECT username, email FROM userdata WHERE user_id = ?");
$sql->bind_param("i", $user_id);
$sql->execute();
$user = $sql->get_result()->fetch_assoc();

// update user info
if (isset($_POST["updateProfile"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($password == "") {
        $update = $conn->prepare("UPDATE userdata SET username = ?, email = ? WHERE user_id = ?");
        $update->bind_param("ssi", $username, $email, $user_id);
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE userdata SET username = ?, email = ?, password = ? WHERE user_id = ?");
        $update->bind_param("sssi", $username, $email, $hashed, $user_id);
    }

    if ($update->execute()) {
        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
         <link rel="stylesheet" href="settings.css">
    </head>
<body>

<!DOCTYPE html>
<html>
<body>

<h2>Edit Profile</h2>

<form method="post">
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

    <input type="password" name="password" placeholder="New Password (optional)"><br><br>

    <button name="updateProfile">Save Changes</button>
</form>

</body>
</html>

