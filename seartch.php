<?php
include("database.php");
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Search Users</h2>

<form method="get">
    <input type="text" name="q" placeholder="Enter username..." required>
    <button>Search</button>
</form>

<?php
if (isset($_GET["q"])) {
    $q = "%" . $_GET["q"] . "%";

    $sql = $conn->prepare("SELECT user_id, username FROM userdata WHERE username LIKE ?");
    $sql->bind_param("s", $q);
    $sql->execute();
    $result = $sql->get_result();

    echo "<h3>Results:</h3>";

    while ($row = $result->fetch_assoc()) {
        echo "<p><a href='view_user.php?id={$row['user_id']}'>" . $row['username'] . "</a></p>";
    }
}
?>

</body>
</html>
