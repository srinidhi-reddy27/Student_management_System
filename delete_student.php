<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $check_sql = "SELECT * FROM students WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Student deleted successfully!";
        } else {
            echo "Error deleting student!";
        }

        $stmt->close();
    } else {
        echo "Student not found!";
    }

    $check_stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>