<?php
if ($_GET["task"] == "registration") 
{
	include 'register.php';
}
elseif ($_GET["task"] == "login") 
{
	include 'login.php';
}
elseif ($_GET["task"] == "forgot") 
{
	include 'forgot.php';
}
elseif ($_GET["task"] == "edit_password") 
{
	include 'edit_password.php';
}
elseif ($_GET["task"] == "status") 
{
	include 'status.php';
}
elseif ($_GET["task"] == "follow") 
{
	include 'follow.php';
}
elseif ($_GET["task"] == "unfollow") 
{
	include 'unfollow.php';
}
elseif ($_GET["task"] == "like") 
{
	include 'like.php';
}
elseif ($_GET["task"] == "unlike") 
{
	include 'unlike.php';
}
elseif ($_GET["task"] == "delete") 
{
	include 'delete.php';
}
elseif ($_GET["task"] == "edit_profile") 
{
	include 'edit_profile.php';
}
elseif ($_GET["task"] == "comment") 
{
	include 'comment.php';
}
elseif ($_GET["task"] == "more_statuses")
{
	include 'more_statuses.php';
}
elseif ($_GET["task"] == "music_query")
{
	include 'music_query.php';
}
?>