<?php

require_once 'connection.php'; 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['video']) && !empty($_FILES['video']['name'][0])) {
        $topic_id = $_POST['topic_id'];
        $uploaded_files = $_FILES['video'];
        
        $upload_directory = 'uploads/videos/'; 
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true);
        }

        foreach ($uploaded_files['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($uploaded_files['name'][$key]);
            $file_path = $upload_directory . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                $stmt = $conn->prepare("INSERT INTO videos (topic_id, filename) VALUES (?, ?)");
                $stmt->bind_param("is", $topic_id, $file_name);
                $stmt->execute();
            } else {
                echo "Failed to upload file: $file_name<br>";
            }
        }
        $stmt->close();
        $conn->close();
        
        echo "<script>
                alert('Video(s) successfully uploaded!');
                window.location.href = 'add_content.php'; // Redirect to the add content page
              </script>";
    } else {
        echo "No video files uploaded.";
    }
} else {
    echo "Invalid request method.";
}
?>
