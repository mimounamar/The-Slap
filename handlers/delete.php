<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
include 'db.php';
if ($_GET['deleted'] != null) 
{
	$sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION['id']."'";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_row($result);
	$userid = $data[1];
	$sql = "SELECT * FROM `statuses` WHERE `id`='".$_GET['deleted']."'";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_row($result);
	if ($data[1] == $userid ) 
	{
		$sql = "DELETE FROM `statuses` WHERE `id`='".$_GET['deleted']."'";
		$result = mysqli_query($conn, $sql);
		echo $sql;
	}
}
header('Location: ../profiles');
?>