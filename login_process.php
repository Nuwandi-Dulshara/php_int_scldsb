<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE user_id='$user_id' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if (strpos($user_id, 'T') === 0) {
            echo "<script>alert('You are a teacher, you have successfully logged in.'); window.location.href='dashboard_teacher.php';</script>";
        } elseif (strpos($user_id, 'S') === 0) {
            echo "<script>alert('You are a student, you have successfully logged in.'); window.location.href='dashboard_student.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid User ID or Password'); window.location.href='login.php';</script>";
    }
}

$conn->close();
?>

