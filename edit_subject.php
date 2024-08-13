<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];
    $subject_id = $_POST['subject_id'];

    $sql = "UPDATE subjects SET subject_name = '$subject_name' WHERE id = '$subject_id'";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard_teacher.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$subject_id = $_GET['subject_id'];
$subject_sql = "SELECT * FROM subjects WHERE id = $subject_id";
$subject_result = $conn->query($subject_sql);
$subject = $subject_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-black text-white">
    <div class="container mt-5">
        <h1 class="text-center">Edit Subject</h1>
        <form method="POST" action="edit_subject.php">
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo $subject['subject_name']; ?>" required>
            </div>
            <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
            <button type="submit" class="btn btn-primary w-100">Update Subject</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
