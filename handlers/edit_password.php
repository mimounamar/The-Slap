<?php
if (isset($_POST["password"]) && isset($_POST["id"])) 
{
	include 'db.php';
    $sql = "SELECT * FROM `credentials_forgot` WHERE `id`='".$_POST["id"]."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)!=0) 
    {
    	$data = mysqli_fetch_row($result);
    	$hashed_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    	$sql = "UPDATE `users` SET `password`='".$hashed_password."' WHERE `mail`='".$data[1]."'";
    	$result = mysqli_query($conn, $sql);
    	$sql = "DELETE FROM `credentials_forgot` WHERE `id`='".$_POST["id"]."'";
    	$result = mysqli_query($conn, $sql);
    	header("Location: /login/?message=changed");
    }
}
?>