<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
include '../handlers/db.php';
if (!isset($_GET["user"]) && isset($_SESSION["id"])) 
{
	include 'editable_profile.php';
}
elseif (isset($_GET["user"]) && !isset($_SESSION["id"]))
		{
		    $sql = "SELECT * FROM users WHERE id='".$_GET["user"]."'";
		    $result = mysqli_query($conn, $sql);
		    if (mysqli_num_rows($result)==1)
		    {
				include 'default_profile.php';
		    }
		    else
		    {
		    	include '404.php';
		    }
		}
elseif (isset($_GET["user"]) && isset($_SESSION["id"])) {
		$sql = "SELECT * FROM sessions WHERE id='".$_SESSION["id"]."'";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_row($result);
		if (mysqli_num_rows($result)==1)
		{
			if($data[1] == $_GET["user"])
			{ 
				include 'editable_profile.php';
			}
			else
			{
				$sql = "SELECT * FROM users WHERE id='".$_GET["user"]."'";
			    $result = mysqli_query($conn, $sql);
			    if (mysqli_num_rows($result)==1)
			    {
					include 'default_profile.php';
			    }
			    else
			    {
			    	include '404.php';
			    }
			}
		}
	
	
}
else
{
	header("Location: ../login/");
}
?>