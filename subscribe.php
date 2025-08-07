<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirectTo('login.php');</script>";
    exit();
}
include 'db.php';
$user_id = $_SESSION['user_id'];
$channel_id = $_GET['id'];
$sql = "SELECT * FROM subscriptions WHERE user_id='$user_id' AND channel_id='$channel_id'";
if ($conn->query($sql)->num_rows > 0) {
    $sql = "DELETE FROM subscriptions WHERE user_id='$user_id' AND channel_id='$channel_id'";
} else {
    $sql = "INSERT INTO subscriptions (user_id, channel_id) VALUES ('$user_id', '$channel_id')";
}
$conn->query($sql);
echo "<script>redirectTo('index.php');</script>";
?>
<script src="script.js"></script>
