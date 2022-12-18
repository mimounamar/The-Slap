<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
if (isset($_SESSION["id"])) 
{
   header("Location: /profiles");
}
elseif (isset($_GET["task"]) && $_GET["task"]=="edit_password") 
{
   include 'edit.php';
}
elseif (!isset($_GET["task"]))
{
   include 'unlogged.php';
}
else
{
   header("Location: /profiles");
}
?>