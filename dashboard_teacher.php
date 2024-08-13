<?php
include 'connection.php';

// Fetch grades and their associated subjects
$grades_sql = "SELECT * FROM grades";
$grades_result = $conn->query($grades_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-black text-white">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Teacher Dashboard</h1>
        <p class="text-center mb-4">Manage grades and subjects efficiently</p>

        <?php while ($grade = $grades_result->fetch_assoc()): ?>
            <div class="grade-section mt-4">
                <button class="btn btn-primary w-100 grade-btn" type="button" data-bs-toggle="collapse" data-bs-target="#grade<?php echo $grade['id']; ?>">
                    <?php echo $grade['grade_name']; ?>
                </button>
                <div class="collapse" id="grade<?php echo $grade['id']; ?>">
                    <ul class="list-group mt-3">
                        <?php
                        $subjects_sql = "SELECT * FROM subjects WHERE grade_id = " . $grade['id'];
                        $subjects_result = $conn->query($subjects_sql);
                        while ($subject = $subjects_result->fetch_assoc()):
                        ?>
                        <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                            <a href="add_content.php?subject_id=<?php echo $subject['id']; ?>" class="text-white"><?php echo $subject['subject_name']; ?></a>
                            <span>
                                <a href="edit_subject.php?subject_id=<?php echo $subject['id']; ?>" class="btn btn-light">Edit</a>
                                <a href="delete_subject.php?subject_id=<?php echo $subject['id']; ?>" class="btn btn-warning">Delete</a>
                                <a href="add_content.php?subject_id=<?php echo $subject['id']; ?>" class="btn btn-secondary">Add Content</a>
                            </span>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <div class="mt-3">
                        <a href="create_subject.php?grade_id=<?php echo $grade['id']; ?>" class="btn btn-sm btn-success">Add New Subject</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
