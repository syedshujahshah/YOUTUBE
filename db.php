<?php
$host = 'localhost';
$dbname = 'dbnudb8bgc98bp';
$username = 'uac1gp3zeje8t';
$password = 'hk8ilpc7us2e';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
?>
