<?php
session_start();
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
         <h1>Rapport de mise à jour - The Slap v0.0.1 (beta)</h1>
         <h2>Message au bêta-testeurs</h2>
         <p>Bonjour à toutes et à tous,<br>
            merci de contribuer à l'amélioration de The Slap en étant bêta-testeurs.<br>
            Il est important de rappeler qu'il s'agit encore d'une version de test. Nombre de bugs sont toujours à répértorier, et de fonctionnalités à intégrer.<br>
            Merci de bien vouloir faire remonter tout mauvais fonctionnement du site à : mimounlasuperstar@gmail.com.<br>
            N'hésitez également pas à proposer vos idées pour améliorer le site.<br>
            Merci à vous,<br>
            The Slap.
         </p>
         <h2>Problème connnus</h2>
         <ul>
            <li>Bug graphique : les bords des boutons "s'abonner", "se désabonner" et "modifier le profil" ne sont pas uniformes. </li>
            <li>Optimisation : les requêtes ne se font pas en arrière-plan (ex: like, publication, etc)</li>
            <li>Fonctionnalité : la messagerie n'est toujours pas disponible.</li>
            <li>Fonctionnalité : commenter une publication n'est toujours pas disponnible.</li>
         </ul>
      </div>
   </div>
   </body>
</html>

