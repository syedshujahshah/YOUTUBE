<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Profile</title>
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
        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .profile-container h2 {
            margin-bottom: 20px;
        }
        .profile-container button {
            padding: 10px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .video-list {
            margin-top: 20px;
        }
        .video-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .video-item img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            margin-right: 10px;
        }
        @media (max-width: 600px) {
            .profile-container {
                margin: 10px;
                padding: 15px;
            }
            .video-item img {
                width: 80px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <button onclick="redirectTo('index.php')">Home</button>
        <button onclick="redirectTo('upload.php')">Upload Video</button>
        <button onclick="redirectTo('logout.php')">Logout</button>
    </div>
    <div class="profile-container">
        <h2>Your Profile</h2>
        <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<script>redirectTo('login.php');</script>";
        } else {
            include 'db.php';
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM users WHERE id='$user_id'";
            $user = $conn->query($sql)->fetch_assoc();
            echo "<p>Username: {$user['username']}</p>";
            echo "<p>Email: {$user['email']}</p>";
            echo "<h3>Your Videos</h3>";
            $sql = "SELECT * FROM videos WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            echo "<div class='video-list'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='video-item'>";
                echo "<img src='{$row['thumbnail']}' alt='Thumbnail'>";
                echo "<div><h4>{$row['title']}</h4><p>{$row['description']}</p>";
                echo "<button onclick='redirectTo(\"edit_video.php?id={$row['id']}\")'>Edit</button>";
                echo "<button onclick='redirectTo(\"delete_video.php?id={$row['id']}\")'>Delete</button></div>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
