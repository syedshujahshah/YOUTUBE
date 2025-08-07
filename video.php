<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Watch Video</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .navbar {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .video-container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }
        .video-player {
            flex: 2;
        }
        .video-player video {
            width: 100%;
            border-radius: 8px;
        }
        .video-info h2 {
            margin: 10px 0;
        }
        .video-info button {
            padding: 8px 16px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .comments {
            margin-top: 20px;
        }
        .comments textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .related-videos {
            flex: 1;
        }
        .related-video {
            display: flex;
            margin-bottom: 10px;
        }
        .related-video img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            margin-right: 10px;
        }
        @media (max-width: 800px) {
            .video-container {
                flex-direction: column;
            }
            .related-videos {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <button onclick="redirectTo('index.php')">Home</button>
    </div>
    <div class="video-container">
        <div class="video-player">
            <?php
            include 'db.php';
            $video_id = $_GET['id'];
            $sql = "SELECT * FROM videos WHERE id='$video_id'";
            $video = $conn->query($sql)->fetch_assoc();
            echo "<video controls><source src='{$video['video_path']}' type='video/mp4'></video>";
            echo "<div class='video-info'>";
            echo "<h2>{$video['title']}</h2>";
            echo "<p>{$video['description']}</p>";
            session_start();
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM likes WHERE video_id='$video_id' AND user_id='$user_id'";
                $liked = $conn->query($sql)->num_rows > 0;
                $sql = "SELECT * FROM subscriptions WHERE channel_id='{$video['user_id']}' AND user_id='$user_id'";
                $subscribed = $conn->query($sql)->num_rows > 0;
                echo "<button onclick='redirectTo(\"like.php?id=$video_id\")'>" . ($liked ? "Unlike" : "Like") . "</button>";
                echo "<button onclick='redirectTo(\"subscribe.php?id={$video['user_id']}\")'>" . ($subscribed ? "Unsubscribe" : "Subscribe") . "</button>";
            }
            ?>
            <div class="comments">
                <h3>Comments</h3>
                <form action="video.php?id=<?php echo $video_id; ?>" method="POST">
                    <textarea name="comment" placeholder="Add a comment..." required></textarea>
                    <button type="submit">Comment</button>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
                    $comment = $_POST['comment'];
                    $sql = "INSERT INTO comments (video_id, user_id, comment, comment_date) VALUES ('$video_id', '$user_id', '$comment', NOW())";
                    $conn->query($sql);
                }
                $sql = "SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.video_id='$video_id'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<p><strong>{$row['username']}</strong>: {$row['comment']}</p>";
                }
                ?>
            </div>
        </div>
        <div class="related-videos">
            <h3>Related Videos</h3>
            <?php
            $sql = "SELECT * FROM videos WHERE id != '$video_id' ORDER BY RAND() LIMIT 5";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='related-video' onclick='redirectTo(\"video.php?id={$row['id']}\")'>";
                echo "<img src='{$row['thumbnail']}' alt='Thumbnail'>";
                echo "<div><h4>{$row['title']}</h4></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
