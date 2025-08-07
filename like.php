<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirectTo('login.php');</script>";
    exit();
}
include 'db.php';
$user_id = $_SESSION['user_id'];
$video_id = $_GET['id'];
$sql = "SELECT * FROM likes WHERE user_id='$user_id' AND video_id='$video_id'";
if ($conn->query($sql)->num_rows > 0) {
    $sql = "DELETE FROM likes WHERE user_id='$user_id' AND video_id='$video_id'";
} else {
    $sql = "INSERT INTO likes (user_id, video_id) VALUES ('$user_id', '$video_id')";
}
$conn->query($sql);
echo "<script>redirectTo('video.php?id=$video_id');</script>";
?>
<script src="script.js"></script>
