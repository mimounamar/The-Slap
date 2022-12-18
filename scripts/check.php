<?php
include '../handlers/db.php';
if ($_REQUEST['field']=='username') 
{
	$sql = 'SELECT * FROM users WHERE username="'.$_REQUEST['text'].'"';
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	echo $num;
}
elseif ($_REQUEST['field']=='mail') 
{
	$sql = 'SELECT * FROM users WHERE mail="'.$_REQUEST['text'].'"';
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	echo $num;
}
?>