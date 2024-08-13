<?php
include 'connection.php';

$topic_id = $_GET['topic_id'];

// Fetch topic details
$topic_sql = "SELECT topics.name AS topic_name, subjects.name AS subject_name, subjects.grade
              FROM topics
              JOIN subjects ON topics.subject_id = subjects.id
              WHERE topics.id = $topic_id";
$topic_result = $conn->query($topic_sql);
$topic = $topic_result->fetch_assoc();

// Fetch videos
$videos_sql = "SELECT * FROM videos WHERE topic_id = $topic_id";
$videos_result = $conn->query($videos_sql);

// Fetch PDFs
$pdfs_sql = "SELECT * FROM pdfs WHERE topic_id = $topic_id";
$pdfs_result = $conn->query($pdfs_sql);

// Fetch assignments
$assignments_sql = "SELECT * FROM assignments WHERE topic_id = $topic_id";
$assignments_result = $conn->query($assignments_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student View Content</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Grade: <?php echo htmlspecialchars($topic['grade']); ?></h1>
        <h2>Subject: <?php echo htmlspecialchars($topic['subject_name']); ?></h2>
        <h3>Topic: <?php echo htmlspecialchars($topic['topic_name']); ?></h3>

        <h4>Videos</h4>
        <?php if ($videos_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($video = $videos_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <a href="<?php echo htmlspecialchars($video['url']); ?>" target="_blank">
                            <?php echo htmlspecialchars($video['url']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No videos available.</p>
        <?php endif; ?>

        <h4>PDFs</h4>
        <?php if ($pdfs_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($pdf = $pdfs_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <a href="<?php echo htmlspecialchars($pdf['file_path']); ?>" target="_blank">
                            <?php echo htmlspecialchars($pdf['file_path']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No PDFs available.</p>
        <?php endif; ?>

        <h4>Assignments</h4>
        <?php if ($assignments_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($assignment = $assignments_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <a href="<?php echo htmlspecialchars($assignment['file_path']); ?>" target="_blank">
                            <?php echo htmlspecialchars($assignment['file_path']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No assignments available.</p>
        <?php endif; ?>

        <a href="student_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
