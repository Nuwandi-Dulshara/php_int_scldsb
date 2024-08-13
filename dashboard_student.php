<?php
include 'connection.php';


$grades_sql = "SELECT * FROM grades";
$grades_result = $conn->query($grades_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-black text-white">
    <div class="container mt-5">
        <h1 class="text-center">Welcome to Your Learning Portal</h1>
        <p class="text-center">Explore your subjects by selecting a grade</p>

        <?php while($grade = $grades_result->fetch_assoc()): ?>
            <div class="grade-section mt-4">
                <button class="btn btn-primary w-100 grade-btn" type="button" data-bs-toggle="collapse" data-bs-target="#grade<?php echo $grade['id']; ?>">
                    <?php echo $grade['grade_name']; ?>
                </button>
                <div class="collapse" id="grade<?php echo $grade['id']; ?>">
                    <ul class="list-group mt-3">
                        <?php
                        $subjects_sql = "SELECT * FROM subjects WHERE grade_id = " . $grade['id'];
                        $subjects_result = $conn->query($subjects_sql);
                        while($subject = $subjects_result->fetch_assoc()):
                        ?>
                        <li class="list-group-item bg-dark text-white">
                            <a href="view_content.php?subject_id=<?php echo $subject['id']; ?>" class="text-white"><?php echo $subject['subject_name']; ?></a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
