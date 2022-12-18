<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
if (isset($_POST["username"]) && isset($_POST["password"])) {
	include 'db.php';
	$_POST['username'] = mysqli_real_escape_string($conn, $_POST['username']);
    $sql = "SELECT * FROM `users` WHERE `username`='".$_POST["username"]."'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_row($result);
    if (password_verify($_POST["password"], $data[3]) && $data[7]!="pending")
    {
    	$session_id = generateRandomString();
    	$sql = "INSERT INTO `sessions`(`id`, `user`) VALUES ('".$session_id."','".$data[0]."')";
    	$result = mysqli_query($conn, $sql);
    	$_SESSION["id"]=$session_id;
    	header("Location: /");
    }
    else
    {
    	header("Location: /login/?message=error_credentials");
    }
}
?>