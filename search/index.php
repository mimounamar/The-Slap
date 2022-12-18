<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
include '../handlers/db.php';
if (!isset($_GET['page'])) 
{
   $_GET['page'] = 1;
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <title>The Slap</title>
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&family=Roboto+Condensed:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet" />
      <link rel="stylesheet" href="../css/draft.css" />
   </head>
   <body>
      <div class="page">
      <?php
   if (isset($_SESSION["id"]))
   {
   include '../handlers/db.php';
    $sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION["id"]."'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_row($result);
    $userid = $data[1];
    $sql = "SELECT * FROM `users` WHERE `id`='".$userid."'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_row($result);
    $name = $data[2];
    echo '<div class="credentials_container">
      <a href="../profiles" class="credentials_link">Connecté en tant que '.$name.'</a>
      <a href="../handlers/disconnect.php" class="credentials_link">Se déconnecter</a>
   </div>';

   }
   else
   {
      echo '<div class="credentials_container">
      <a href="../register/" class="credentials_link">Inscription</a>
      <a href="../login/" class="credentials_link">Connexion</a>
   </div>';
   }
   ?>
      <div class="navigation_bar">
         <div class="navigation_logo">
            <img src="../img/logo.png" />
         </div>
         <div class="navigation_list">
            <ul>
               <li class="navigation_component"><a href="../">ACCUEIL</a></li>
               <li class="navigation_component"><a href="../profiles">PROFILS</a></li>
               <li class="navigation_component"><a href="../messages/">MESSAGES</a></li>
               <li class="navigation_component"><a href="../timeline/">BLOGS</a></li>
               <li class="navigation_search"><span class="search_label">RECHERCHER</span></li>
               <form action="../search/" method="get" class="search_form">
                  <input type="text" name="search_input" class="search_field" />
                  <input type="submit" name="search_submit" class="search_submit" value="GO" />
               </form>
            </ul>
         </div>
      </div>
      <div class="navigation_adornment">
         <img src="../img/nav_adornment.png" />
      </div>
      <div class="web_outline">
      <div class="web_content">
         <?php
         if (isset($_GET['search_input'])) 
         {
            $limit = 5;
            $offest = $_GET['page']*5 - 5;
            $sql = "SELECT * FROM `users` WHERE `name` LIKE '%".$_GET["search_input"]."%' OR `username` LIKE '%".$_GET["search_input"]."%' LIMIT ".$offest.", ".$limit;
            $prof_result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($prof_result) == 0) 
            {
               echo '<div class="bad_message">Aucun résultat correpondant à votre recherche.</div>';
            }
            else
            {
               while($userdata = $prof_result->fetch_array()) 
               { 
                  $_GET["user"] = $userdata[0];
                  include 'user.php';
               }
               $nextpage = $_GET['page']+1;
               echo '<a href="../search/?search_input='.$_GET['search_input'].'&page='.$nextpage.'" class="next_page" style="color:black;">En voir +</a>';
            }
         }
         ?>
      </div>
   </div>
   </body>
</html>

