<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'db_config.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM students LIMIT $start, $limit";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(*) FROM students";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Student Records</h2>
        
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
        <button class="add-btn" onclick="openAddStudentModal()">Add Student</button>
        <div class="table-wrapper">
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Roll No</th>
                    <th>Email</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["roll_no"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td>
                            <?php if (!empty($row['file_path'])): ?>
                            <a href="<?php echo $row['file_path']; ?>" target="_blank">Download</a>
                            <?php else: ?>
                                No File
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="update-btn" onclick="openUpdateStudentModal(<?= $row['id'] ?>, '<?= $row['name'] ?>', '<?= $row['roll_no'] ?>', '<?= $row['email'] ?>')">Update</button>
                            <button class="delete-btn" data-id="<?= htmlspecialchars($row['id']) ?>">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddStudentModal()">×</span>
            <h2>Add Student</h2>
            <form action="add_student.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="roll_no">Roll No:</label>
                <input type="text" id="roll_no" name="roll_no" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="file">Upload File (.pdf, .docx):</label>
                <input type="file" name="file" accept=".pdf,.docx" required>

                <button type="submit">Add Student</button>
                <button type="button" onclick="closeAddStudentModal()">Cancel</button>
            </form>
        </div>
    </div>

    <div id="updateStudentModal" class="modal" enctype="multipart/form-data">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateStudentModal()">×</span>
            <h2>Update Student</h2>
            <form action="update_student.php" method="POST">
                <input type="hidden" id="update_id" name="update_id">
                
                <label for="update_name">Name:</label>
                <input type="text" id="update_name" name="update_name" required>

                <label for="update_roll_no">Roll No:</label>
                <input type="text" id="update_roll_no" name="update_roll_no" required>

                <label for="update_email">Email:</label>
                <input type="email" id="update_email" name="update_email" required>

                <label for="file">Upload File (.pdf, .docx):</label>
                <input type="file" name="file" accept=".pdf,.docx">

                <button type="submit">Update</button>
                <button type="button" onclick="closeUpdateStudentModal()">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>