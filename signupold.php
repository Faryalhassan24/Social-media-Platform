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

        // check email exists
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
<html>

<head>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="signin.css">
</head>

<body>
    <div class="login-container">
        <h2 class="project-title">Sign Up To FAKEBOOK</h2>
        <p><?php echo $message; ?></p>

        <form method="post" class="login-form">
            <input type="text" name="username" placeholder="username" required class=""><br><br>
            <input type="email" name="email" placeholder="email" required><br><br>
            <input type="password" name="password" placeholder="password" required><br><br>
            <button name="Signup">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>