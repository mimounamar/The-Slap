<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
if (isset($_GET) && isset($_SESSION)) 
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
         $sql = "SELECT * FROM `follows` WHERE `followed`='".$_GET["followed"]."' AND `follower`='".$id."'";
                  $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result)==0 && $_GET["followed"] != $id){
        $sql = "INSERT INTO `follows`(`follower`, `followed`) VALUES ('".$id."','".$_GET["followed"]."')";
        $result = mysqli_query($conn, $sql);
        echo('Done');
}
//header("Location: ../profiles/?user=".$_POST["followed"]);
}
?>