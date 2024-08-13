<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];
    $grade_id = $_POST['grade_id'];

    $sql = "INSERT INTO subjects (subject_name, grade_id) VALUES ('$subject_name', '$grade_id')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard_teacher.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$grade_id = $_GET['grade_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-black text-white">
    <div class="container mt-5">
        <h1 class="text-center">Create New Subject</h1>
        <form method="POST" action="create_subject.php">
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" required>
            </div>
            <input type="hidden" name="grade_id" value="<?php echo $grade_id; ?>">
            <button type="submit" class="btn btn-primary w-100">Add Subject</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
