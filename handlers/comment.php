<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
if (isset($_GET) && isset($_SESSION) && $_GET['comment'] != null) 
{

          include 'db.php';
          $sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION["id"]."'";
          $result = mysqli_query($conn, $sql);
          $data = mysqli_fetch_row($result);
          $userid = $data[1];
          $sql = "SELECT * FROM `users` WHERE `id`='".$userid."'";
          $result = mysqli_query($conn, $sql);
          $data = mysqli_fetch_row($result);
          $id = $data[0];
          $_GET['comment'] = mysqli_real_escape_string($conn, $_GET['comment']);
        $sql = "INSERT INTO `comments`(`user`, `post`,`content`,`date`) VALUES ('".$id."','".$_GET["post"]."','".$_GET['comment']."','".date("Y-m-d")."')";
        $result = mysqli_query($conn, $sql);
        echo $sql;
//header("Location: ../profiles/?user=".$_POST["userpage"]);
}
?>