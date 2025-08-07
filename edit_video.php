<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Edit Video</title>
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
        .edit-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .edit-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .edit-container input, .edit-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .edit-container button {
            width: 100%;
            padding: 10px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-container button:hover {
            background-color: #cc0000;
        }
        @media (max-width: 600px) {
            .edit-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Video</h2>
        <?php
        session_start();
        include 'db.php';
        if (!isset($_SESSION['user_id'])) {
            echo "<script>redirectTo('login.php');</script>";
            exit();
        }
        $video_id = $_GET['id'];
        $sql = "SELECT * FROM videos WHERE id='$video_id' AND user_id='{$_SESSION['user_id']}'";
        $video = $conn->query($sql)->fetch_assoc();
        if (!$video) {
            echo "<script>redirectTo('profile.php');</script>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $sql = "UPDATE videos SET title='$title', description='$description' WHERE id='$video_id'";
            if ($conn->query($sql)) {
                echo "<script>alert('Video Updated!'); redirectTo('profile.php');</script>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
        <form action="edit_video.php?id=<?php echo $video_id; ?>" method="POST">
            <input type="text" name="title" value="<?php echo $video['title']; ?>" required>
            <textarea name="description" required><?php echo $video['description']; ?></textarea>
            <button type="submit">Update</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
