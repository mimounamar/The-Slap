<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
if (isset($_SESSION['id'])) 
{
	include 'edit.php';
}
else
{
	header('Location : /');
}
?>