<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["update_id"];
    $name = $_POST["update_name"];
    $roll_no = $_POST["update_roll_no"];
    $email = $_POST["update_email"];
    $file_path = ""; // Handle file upload if provided

    // Handle file upload (optional in update)
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
                $sql = "UPDATE students SET name=?, roll_no=?, email=?, file_path=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $name, $roll_no, $email, $file_path, $id);
            } else {
                echo "<script>alert('Failed to upload file.'); window.location.href='display.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Only .pdf and .docx files are allowed.'); window.location.href='display.php';</script>";
            exit;
        }
    } else {
        $sql = "UPDATE students SET name=?, roll_no=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $roll_no, $email, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Student Updated Successfully!'); window.location.href='display.php';</script>";
    } else {
        echo "<script>alert('Error updating student!'); window.location.href='display.php';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Update Student</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="update_id" value="<?php echo isset($_POST['update_id']) ? $_POST['update_id'] : ''; ?>">
            <label for="update_name">Name:</label>
            <input type="text" name="update_name" value="<?php echo isset($_POST['update_name']) ? $_POST['update_name'] : ''; ?>" required>

            <label for="update_roll_no">Roll No:</label>
            <input type="text" name="update_roll_no" value="<?php echo isset($_POST['update_roll_no']) ? $_POST['update_roll_no'] : ''; ?>" required>

            <label for="update_email">Email:</label>
            <input type="email" name="update_email" value="<?php echo isset($_POST['update_email']) ? $_POST['update_email'] : ''; ?>" required>

            <label for="file">Upload File (.pdf, .docx) (Optional):</label>
            <input type="file" name="file" accept=".pdf,.docx">

            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='display.php'">Back</button>
        </form>
    </div>
</body>
</html>