<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
include 'db.php';
$sql = 'DELETE FROM sessions WHERE id="'.$_SESSION['id'].'"';
$result = mysqli_query($conn, $sql);
session_destroy();
header('Location: ../');
?>