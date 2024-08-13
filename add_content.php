<?php
include 'connection.php';

// Fetch subject details
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;
$subject_sql = "SELECT * FROM subjects WHERE id = $subject_id";
$subject_result = $conn->query($subject_sql);

if ($subject_result && $subject_result->num_rows > 0) {
    $subject = $subject_result->fetch_assoc();
} else {
    $subject = null;
    echo "<p class='text-center text-danger'>Subject not found.</p>";
    exit;
}

// Fetch topics for the subject
$topics_sql = "SELECT * FROM topics WHERE subject_id = $subject_id";
$topics_result = $conn->query($topics_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-black text-white">
    <div class="container mt-5">
        <?php if ($subject): ?>
            <h1 class="text-center mb-4">Add Content for <?php echo htmlspecialchars($subject['subject_name']); ?></h1>
            <a href="view_content.php?subject_id=<?php echo $subject_id; ?>" class="btn btn-info mb-4">View Content</a>
            <p class="text-center mb-4">Manage topics, videos, PDFs, and assignments</p>

            <!-- Add new topic form -->
            <div class="mb-4">
                <form action="add_topic.php" method="post">
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    <div class="mb-3">
                        <label for="topic_name" class="form-label">New Topic</label>
                        <input type="text" class="form-control" id="topic_name" name="topic_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Topic</button>
                </form>
            </div>

            <!-- List of topics with options to manage content -->
            <ul class="list-group">
                <?php while ($topic = $topics_result->fetch_assoc()): ?>
                <li class="list-group-item bg-dark text-white">
                    <h5><?php echo htmlspecialchars($topic['name']); ?></h5>

                    <!-- Upload videos -->
                    <div class="mb-3">
                    <form action="upload_video.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                        <div class="mb-3">
                            <label for="video-<?php echo $topic['id']; ?>" class="form-label">Upload Video</label>
                            <input type="file" class="form-control" id="video-<?php echo $topic['id']; ?>" name="video[]" multiple>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit Video(s)</button>
                        </form>


                        <!-- Display and manage uploaded videos -->
                        <div id="uploaded-videos-<?php echo $topic['id']; ?>">
                            <?php
                            $videos_sql = "SELECT * FROM videos WHERE topic_id = " . $topic['id'];
                            $videos_result = $conn->query($videos_sql);
                            while ($video = $videos_result->fetch_assoc()):
                            ?>
                            <div class="mt-2" id="video-<?php echo $video['id']; ?>">
                                <p><?php echo htmlspecialchars($video['filename']); ?></p>
                                <a href="update_video.php?video_id=<?php echo $video['id']; ?>" class="btn btn-warning">Update</a>
                                <a href="javascript:void(0)" onclick="deleteVideo(<?php echo $video['id']; ?>)" class="btn btn-danger">Delete</a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Upload PDFs -->
                    <div class="mb-3">
                        <form action="upload_pdf.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                            <div class="mb-3">
                                <label for="pdf-<?php echo $topic['id']; ?>" class="form-label">Upload PDF</label>
                                <input type="file" class="form-control" id="pdf-<?php echo $topic['id']; ?>" name="pdf[]" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit PDF(s)</button>
                        </form>

                        <!-- Display and manage uploaded PDFs -->
                        <div>
                            <?php
                            $pdfs_sql = "SELECT * FROM pdfs WHERE topic_id = " . $topic['id'];
                            $pdfs_result = $conn->query($pdfs_sql);
                            while ($pdf = $pdfs_result->fetch_assoc()):
                            ?>
                            <div class="mt-2">
                                <p><?php echo htmlspecialchars($pdf['filename']); ?></p>
                                <a href="update_pdf.php?pdf_id=<?php echo $pdf['id']; ?>" class="btn btn-warning">Update</a>
                                <a href="delete_pdf.php?pdf_id=<?php echo $pdf['id']; ?>" class="btn btn-danger">Delete</a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Upload assignments -->
                    <div class="mb-3">
                        <form action="upload_assignment.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                            <div class="mb-3">
                                <label for="assignment-<?php echo $topic['id']; ?>" class="form-label">Upload Assignment</label>
                                <input type="file" class="form-control" id="assignment-<?php echo $topic['id']; ?>" name="assignment[]" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Assignment(s)</button>
                        </form>

                        <!-- Display and manage uploaded assignments -->
                        <div>
                            <?php
                            $assignments_sql = "SELECT * FROM assignments WHERE topic_id = " . $topic['id'];
                            $assignments_result = $conn->query($assignments_sql);
                            while ($assignment = $assignments_result->fetch_assoc()):
                            ?>
                            <div class="mt-2">
                                <p><?php echo htmlspecialchars($assignment['filename']); ?></p>
                                <a href="update_assignment.php?assignment_id=<?php echo $assignment['id']; ?>" class="btn btn-warning">Update</a>
                                <a href="delete_assignment.php?assignment_id=<?php echo $assignment['id']; ?>" class="btn btn-danger">Delete</a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a href="edit_topic.php?topic_id=<?php echo $topic['id']; ?>" class="btn btn-warning">Edit Topic</a>
                        <a href="delete_topic.php?topic_id=<?php echo $topic['id']; ?>" class="btn btn-danger">Delete Topic</a>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-center text-danger">No content available.</p>
        <?php endif; ?>
    </div>
    <script>
    // JavaScript for handling video uploads and deletion
    document.querySelectorAll('form[id^="upload-video-form-"]').forEach(function(form) {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData(this);

        fetch('upload_video.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                var topicId = this.querySelector('input[name="topic_id"]').value;
                var uploadedVideosContainer = document.getElementById('uploaded-videos-' + topicId);
                data.forEach(video => {
                    var videoDiv = document.createElement('div');
                    videoDiv.classList.add('mt-2');
                    videoDiv.id = 'video-' + video.id;
                    videoDiv.innerHTML = `
                        <p>${video.filename}</p>
                        <a href="update_video.php?video_id=${video.id}" class="btn btn-warning">Update</a>
                        <a href="javascript:void(0)" onclick="deleteVideo(${video.id})" class="btn btn-danger">Delete</a>
                    `;
                    uploadedVideosContainer.appendChild(videoDiv);
                });
                this.querySelector('input[type="file"]').value = ''; // Clear the input field after upload
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
