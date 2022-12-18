<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <title>The Slap - Connexion</title>
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
      <div class="credentials_container">
         <a href="../register/" class="credentials_link">Inscription</a>
         <a href="../login" class="credentials_link">Connexion</a>
      </div>
      <div class="navigation_bar">
         <div class="navigation_logo">
            <img src="../img/logo.png" />
         </div>
         <div class="navigation_list">
            <ul>
               <li class="navigation_component"><a href="../">ACCUEIL</a></li>
               <li class="navigation_component"><a href="../profiles/">PROFILS</a></li>
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
         <div class="content_header">
            <img src="../img/login.png" />
         </div>
         <div class="content">
            <div class="form_container">
                <?php
                    if(isset($_GET["message"])){
                        if($_GET["message"]=="sent")
                        {
                            echo "
                            <div class='good_message'>Votre requête a été prise en compte. Veuillez vérifier votre adresse mail pour modifier vos identifiants. </div>
                            ";
                        }
                        elseif($_GET["message"]=="error_credentials")
                        {
                            echo "
                            <div class='bad_message'>Vos identifiants sont incorrects. Veuillez réessayer ou demandez à les réinitialiser. </div>
                            ";
                        }
                        elseif($_GET["message"]=="changed")
                        {
                            echo "
                            <div class='good_message'>Vos identifiants ont été modifiés. Vous pouvez vous connecter en les utilisant. </div>
                            ";
                        }
                        }

               ?>
               <div class="form_header">
                  <img src="../img/id.png" />
               </div>
               <div class="form_fields">
                  <form action="../handlers/?task=login" method="post">
                     <label for="username">Nom d'utilisateur</label>
                     <input type="text" name="username" id="username" value="tori.vega" required /><br>
                     <label for="password">Mot de passe</label>
                     <input type="password" name="password" id="password" required /><br>
                     <input type="image" src="../img/submit.png" alt="Submit" style="margin:10px">
                  </form>
               </div>
               <div class="form_header">
                  <img src="../img/forgot.png" />
               </div>
               <div class="form_fields">
                  <form action="../handlers/?task=forgot" method="post">
                     <label for="mail">Adresse mail</label>
                     <input type="mail" name="mail" id="mail" required /><br>
                     <input type="image" src="../img/submit.png" alt="Submit" style="margin:10px">
                  </form>
               </div>
               <br>
            </div>
         </div>
      </div>
   </body>
   <script type="text/javascript">
       document.getElementById("password").defaultValue = "Test123";
   </script>
</html>

