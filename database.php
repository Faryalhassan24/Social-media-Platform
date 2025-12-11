<?php
$dbhost = "localhost";
$dbserver = "root";
$password = "";
$dbname = "loginsystem";
$conn = "";

try {
    $conn = mysqli_connect($dbhost, $dbserver, $password, $dbname);
} catch (mysqli_sql_exception) {
    echo "Database error";
}


if ($conn) {
    echo "";
} else {
    echo "Database connection failed";
}

?>


