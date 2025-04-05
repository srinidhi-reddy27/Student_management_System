<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $roll_no = trim($_POST["roll_no"]);
    $email = trim($_POST["email"]);

    $check_sql = "SELECT * FROM students WHERE roll_no = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $roll_no);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Roll No already exists!'); window.history.back();</script>";
    } else {
        $file_path = "";
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = basename($_FILES["file"]["name"]);
            $target_file = $target_dir . time() . "_" . $file_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($file_type, ['pdf', 'docx'])) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $file_path = $target_file;
                } else {
                    echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Only .pdf and .docx files are allowed.'); window.history.back();</script>";
                exit;
            }
        }

        $sql = "INSERT INTO students (name, roll_no, email, file_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $roll_no, $email, $file_path);

        if ($stmt->execute()) {
            echo "<script>alert('Student Added Successfully!'); window.location.href='display.php';</script>";
        } else {
            echo "<script>alert('Error adding student. Please try again.'); window.location.href='display.php';</script>";
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>