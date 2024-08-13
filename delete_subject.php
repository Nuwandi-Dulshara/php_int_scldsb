<?php
include 'connection.php';

$subject_id = $_GET['subject_id'];

$sql = "DELETE FROM subjects WHERE id = '$subject_id'";

if ($conn->query($sql) === TRUE) {
    header('Location: dashboard_teacher.php');
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
