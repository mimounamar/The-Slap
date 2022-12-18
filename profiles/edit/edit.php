<?php
include '../../handlers/db.php';
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
      <link rel="stylesheet" href="../../css/draft.css" />
   </head>
   <body>
      <div class="page">
   <?php
    if (isset($_SESSION["id"]))
    {
     $sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION["id"]."'";
     $result = mysqli_query($conn, $sql);
     $data = mysqli_fetch_row($result);
     $userid = $data[1];
     if($userid == 31){
      header('Location: /');
     }
     $sql = "SELECT * FROM `users` WHERE `id`='".$userid."'";
     $result = mysqli_query($conn, $sql);
     $data = mysqli_fetch_row($result);
     $id = $data[0];
     $name = $data[2];
     echo '<div class="credentials_container">
     <a href="../../profiles" class="credentials_link">Connecté en tant que '.$name.'</a>
     <a href="../../handlers/disconnect.php" class="credentials_link">Se déconnecter</a>
     </div>';

  }
  else
  {
   echo '<div class="credentials_container">
   <a href="../../register/" class="credentials_link">Inscription</a>
   <a href="../../login/" class="credentials_link">Connexion</a>
   </div>';
}
?>
      <div class="navigation_bar">
         <div class="navigation_logo">
            <img src="../../img/logo.png" />
         </div>
         <div class="navigation_list">
            <ul>
               <li class="navigation_component"><a href="/">ACCUEIL</a></li>
               <li class="navigation_component"><a href="/profiles/">PROFILS</a></li>
               <li class="navigation_component"><a href="/messages/">MESSAGES</a></li>
               <li class="navigation_component"><a href="/timeline/">BLOGS</a></li>
               <li class="navigation_search"><span class="search_label">RECHERCHER</span></li>
               <form action="/search/" method="get" class="search_form">
                  <input type="text" name="search_input" class="search_field" />
                  <input type="submit" name="search_submit" class="search_submit" value="GO" />
               </form>
            </ul>
         </div>
      </div>
      <div class="navigation_adornment">
         <img src="../../img/nav_adornment.png" />
      </div>
      <div class="web_outline">
      <div class="web_content">
         <div class="content">
            <div class="form_container">
               <div class="good_message">Pour modifier des données, complétez les champs correspondants. Pour laisser tel quel, laissez vide.</div>
               <div class="edit_form_header">
               </div>
               <div class="edit_form_fields">
                  <form action="../../handlers/?task=edit_profile" method="post" enctype="multipart/form-data">
                     <label>Votre nom d'utilisateur actuel est <b><?php echo $data[2]?></b> :</label>
                     <input type="text" name="username" id="username"><br>
                     <div class="discret_message" id="username_message"></div><br>
                     <label>Votre adresse mail actuelle est <b><?php echo $data[4]?></b> :</label>
                     <input type="mail" name="mail" id="mail"><br>
                     <div class="discret_message" id="mail_message"></div><br>
                     <label>Vos noms et prénoms actuels sont <b><?php echo $data[1]?></b> :</label>
                     <input type="text" name="name" id="name"><br>
                     <div class="discret_message" id="name_message"></div><br>
                     <label>Modifiez votre mot de passe :</label>
                     <input type="password" name="password" id="password">
                     <input type="password" name="password_check" id="password_check"><br>
                     <div class="discret_message" id="password_message"></div><br>
                     <label>Modifiez votre photo de profil <b>(png et jpeg seulement, 3 Mo max)</b> :</label>
                     <input type="file" name="profile_picture"><br>
                     <label>Modifiez votre bannière <b>(png et jpeg seulement, 3 Mo max)</b> :</label>
                     <input type="file" name="banner"><br>
                     <label>Modifiez la musique associée à votre widget</label>
                     <input type="text" name="music_search" id="music_search"><br>
                     <div class="music_results_container" id="music_results_container">

                     </div>
                     <input type="image" src="../../img/submit.png" alt="Submit" id="submit" style="margin:10px">
                  </form>
                   <script src="../../scripts/edit.js"></script>
                   <script src="../../scripts/music_search.js"></script>
               </div>
               <br>
            </div>
         </div>
      </div>
   </body>
</html>

