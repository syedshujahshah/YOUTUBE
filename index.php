<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Homepage</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        .navbar button {
            padding: 8px 16px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .video-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .video-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .video-card h3 {
            margin: 10px;
            font-size: 16px;
        }
        .video-card p {
            margin: 0 10px 10px;
            color: #606060;
        }
        @media (max-width: 600px) {
            .navbar input {
                width: 150px;
            }
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>YouTube Clone</h1>
        <input type="text" id="search" placeholder="Search videos...">
        <div>
            <button onclick="redirectTo('login.php')">Login</button>
            <button onclick="redirectTo('signup.php')">Sign Up</button>
        </div>
    </div>
    <div class="container">
        <?php
        include 'db.php';
        $sql = "SELECT * FROM videos ORDER BY upload_date DESC LIMIT 12";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<div class='video-card' onclick='redirectTo(\"video.php?id={$row['id']}\")'>";
            echo "<img src='{$row['thumbnail']}' alt='Thumbnail'>";
            echo "<h3>{$row['title']}</h3>";
            echo "<p>{$row['description']}</p>";
            echo "</div>";
        }
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
