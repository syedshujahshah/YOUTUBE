<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Upload Video</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }
        .upload-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .upload-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .upload-container input, .upload-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .upload-container button {
            width: 100%;
            padding: 10px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .upload-container button:hover {
            background-color: #cc0000;
        }
        @media (max-width: 600px) {
            .upload-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Video</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Video Title" required>
            <textarea name="description" placeholder="Video Description" required></textarea>
            <input type="file" name="video" accept="video/*" required>
            <input type="file" name="thumbnail" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
        <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<script>redirectTo('login.php');</script>";
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'db.php';
            $user_id = $_SESSION['user_id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $video = $_FILES['video']['name'];
            $thumbnail = $_FILES['thumbnail']['name'];
            $video_path = "uploads/Videos/" . basename($video);
            $thumbnail_path = "uploads/Thumbnails/" . basename($thumbnail);
            move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path);
            $sql = "INSERT INTO videos (user_id, title, description, video_path, thumbnail, upload_date) VALUES ('$user_id', '$title', '$description', '$video_path', '$thumbnail_path', NOW())";
            if ($conn->query($sql)) {
                echo "<script>alert('Video Uploaded!'); redirectTo('profile.php');</script>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
