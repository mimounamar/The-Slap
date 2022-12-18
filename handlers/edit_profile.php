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
include 'db.php';
$sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION["id"]."'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_row($result);
$userid = $data[1];
if ($_POST['username'] != null) 
{
	$sql = "SELECT * FROM `users` WHERE `username`='".$_POST['username']."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) == 0) 
	{
		$_POST['username'] = mysqli_real_escape_string($conn, $_POST['username']);
		$sql = $sql = "UPDATE `users` SET `username`='".$_POST['username']."' WHERE `id`='".$userid."'";
		$result = mysqli_query($conn, $sql);
	}
}
if ($_POST['name'] != null) 
{
		$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
		$sql = "UPDATE `users` SET `name`='".$_POST['name']."' WHERE `id`='".$userid."'";
		$result = mysqli_query($conn, $sql);
}
if ($_POST['password'] != null) 
{
		$_POST['password'] = mysqli_real_escape_string($conn, $_POST['password']);
    	$hashed_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
		$sql = "UPDATE `users` SET `password`='".$hashed_password."' WHERE `id`='".$userid."'";
		$result = mysqli_query($conn, $sql);
}
if ($_POST['mail'] != null) 
{
	$sql = "SELECT * FROM `users` WHERE `mail`='".$_POST['mail']."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) == 0) 
	{
		$_POST['mail'] = mysqli_real_escape_string($conn, $_POST['mail']);
		$sql = "UPDATE `users` SET `mail`='".$_POST['mail']."' WHERE `id`='".$userid."'";
		$result = mysqli_query($conn, $sql);
	}
}
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0)
{
 	if ($_FILES['profile_picture']['size'] <= 3000000)
        {
 			$fileInfo = pathinfo($_FILES['profile_picture']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $allowedExtensions))
            {
            	$new_name = generateRandomString()."_".basename($_FILES['profile_picture']['name']);
                move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../user_assets/profile_pictures/' .$new_name);
                $new_name = mysqli_real_escape_string($conn, $new_name);
				$sql = "UPDATE `users` SET `picture`='".$new_name."' WHERE `id`='".$userid."'";
				$result = mysqli_query($conn, $sql);
            }
        }
}
if (isset($_FILES['banner']) && $_FILES['banner']['error'] == 0)
{
 	if ($_FILES['banner']['size'] <= 3000000)
        {
 			$fileInfo = pathinfo($_FILES['banner']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $allowedExtensions))
            {
            	$new_name = generateRandomString()."_".basename($_FILES['banner']['name']);
                move_uploaded_file($_FILES['banner']['tmp_name'], '../user_assets/banners/' .$new_name);
                $new_name = mysqli_real_escape_string($conn, $new_name);
				$sql = "UPDATE `users` SET `banner`='".$new_name."' WHERE `id`='".$userid."'";
				$result = mysqli_query($conn, $sql);
            }
        }
}
if ($_POST['music_results'] != null) 
{
	$_POST['music_results'] = mysqli_real_escape_string($conn, $_POST['music_results']);
	$sql = "UPDATE `users` SET `widget_id`='".$_POST['music_results']."' WHERE `id`='".$userid."'";
	$result = mysqli_query($conn, $sql);
}
header('Location: ../profiles')
?>