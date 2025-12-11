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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="signin.css">
    <title>Login</title>
    <link rel="stylesheet" href="signin.css">
</head>

<body>
    <div class="navbar">
       
    </div>


<div class="bodycontainer">



    <div class="login-container">

        <h1 class="project-title">FAKEBOOK</h1>
        <p class="subtitle">Welcome back!</p>

        <?php if ($msg != ""): ?>
            <p class="error-msg"><?php echo $msg; ?></p>
        <?php endif; ?>

        <form method="post" class="login-form">

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button name="Login" class="btn-login">Login</button>

        </form>

        <p class="signup-link">
            Don’t have an account? <a href="signup.php">Sign up</a>
        </p>

        <button id="themeToggle" class="theme-btn">🌙</button>


        

    </div>
</div>
<script>
            document.getElementById("themeToggle").addEventListener("click", () => {
                document.body.classList.toggle("dark");

                // Change button text
                if (document.body.classList.contains("dark")) {
                    document.getElementById("themeToggle").innerText = "💡";
                } else {
                    document.getElementById("themeToggle").innerText = "🌙";
                }
            });
        </script>
</body>

</html>