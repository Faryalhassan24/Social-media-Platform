<?php
include("database.php");
session_start();

$msg = "";

if (isset($_POST["Login"])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit();
        } else {
            $msg = "Incorrect password!";
        }

    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
<h2>Login</h2>
<p><?php echo $msg; ?></p>

<form method="post">
    <input type="email" name="email" placeholder="email" required><br><br>
    <input type="password" name="password" placeholder="password" required><br><br>
    <button name="Login">Login</button>
</form>

<p>Don’t have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>
