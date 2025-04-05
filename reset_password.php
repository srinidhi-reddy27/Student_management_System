<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='reset_password.html';</script>";
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $check_user = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_user->bind_param("s", $username);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows > 0) {
        $update_password = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update_password->bind_param("ss", $hashed_password, $username);

        if ($update_password->execute()) {
            echo "<script>alert('Password reset successful! Please log in.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error updating password. Try again!'); window.location.href='reset_password.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='reset_password.html';</script>";
    }

    $check_user->close();
    $update_password->close();
    $conn->close();
}
?>