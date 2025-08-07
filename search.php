<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone - Search</title>
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
        .search-container {
            max-width: 800px;
            margin: 20px auto;
        }
        .search-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .video-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
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
            .video-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <button onclick="redirectTo('index.php')">Home</button>
    </div>
    <div class="search-container">
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search videos..." required>
        </form>
        <div class="video-list">
            <?php
            include 'db.php';
            if (isset($_GET['query'])) {
                $query = $_GET['query'];
                $sql = "SELECT * FROM videos WHERE title LIKE '%$query%' OR description LIKE '%$query%'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='video-card' onclick='redirectTo(\"video.php?id={$row['id']}\")'>";
                    echo "<img src='{$row['thumbnail']}' alt='Thumbnail'>";
                    echo "<h3>{$row['title']}</h3>";
                    echo "<p>{$row['description']}</p>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
