<?php
session_start();
session_destroy();
echo "<script>redirectTo('index.php');</script>";
?>
<script src="script.js"></script>
