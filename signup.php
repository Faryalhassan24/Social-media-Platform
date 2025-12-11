<?php
include("database.php");

$message = "";

if (isset($_POST["Signup"])) {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($username == "" || $email == "" || $password == "") {
        $message = "All fields are required!";
    } else {

        $check = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists!";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $sql = $conn->prepare("INSERT INTO userdata (username, email, password) VALUES (?, ?, ?)");
            $sql->bind_param("sss", $username, $email, $hashed);

            if ($sql->execute()) {
                $message = "Registration successful! <a href='login.php'>Login now</a>";
            } else {
                $message = "Registration failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Signup</title>
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="signup.css">
</head>

<body>

<div class="bodycontainer">

    <div class="login-container">

        <h1 class="project-title">FAKEBOOK</h1>
        <p class="subtitle">Create your account</p>

        <?php if ($message != ""): ?>
            <p class="error-msg"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="post" class="login-form">

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button name="Signup" class="btn-login">Sign Up</button>

        </form>

        <p class="signup-link">
            Already have an account? <a href="login.php">Log in</a>
        </p>

        <button id="themeToggle" class="theme-btn">🌙</button>

    </div>
</div>

<script>
document.getElementById("themeToggle").addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        document.getElementById("themeToggle").innerText = "💡";
    } else {
        document.getElementById("themeToggle").innerText = "🌙";
    }
});
</script>

</body>
</html>
