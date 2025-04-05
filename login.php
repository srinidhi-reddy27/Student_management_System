<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo "Received: Username=$username, Password=$password<br>";

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "Query executed, rows found: " . $result->num_rows . "<br>";

    if ($row = $result->fetch_assoc()) {
        echo "User found: " . $row['username'] . ", Password hash: " . $row['password'] . "<br>";
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: display.php");
            exit();
        } else {
            echo "<script>alert('Invalid password');window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found');window.location.href='login.html';</script>";
    }
}
?>