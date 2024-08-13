<?php
include 'connection.php';

$subject_id = $_POST['subject_id'];
$topic_name = $_POST['topic_name'];

$sql = "INSERT INTO topics (subject_id, name) VALUES ('$subject_id', '$topic_name')";
if ($conn->query($sql) === TRUE) {
    header("Location: add_content.php?subject_id=$subject_id");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
