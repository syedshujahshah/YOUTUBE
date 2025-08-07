<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirectTo('login.php');</script>";
    exit();
}
include 'db.php';
$video_id = $_GET['id'];
$sql = "DELETE FROM videos WHERE id='$video_id' AND user_id='{$_SESSION['user_id']}'";
$conn->query($sql);
echo "<script>redirectTo('profile.php');</script>";
?>
<script src="script.js"></script>
