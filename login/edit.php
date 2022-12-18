<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Slap - Feed</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&family=Roboto+Condensed:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="../css/draft.css">
</head>
<body>
<div class="page">
	<div class="credentials_container">
		<a href="../register/" class="credentials_link">Inscription</a>
		<a href="../login/" class="credentials_link">Connexion</a>
	</div>

	<div class="navigation_bar">

		<div class="navigation_logo">
			<img src="../img/logo.png">
		</div>

		<div class="navigation_list">
			<ul>
				<li class="navigation_component"><a href="../">ACCUEIL</a></li>
				<li class="navigation_component"><a href="../profiles/">PROFILS</a></li>
				<li class="navigation_component"><a href="../messages/">MESSAGES</a></li>
				<li class="navigation_component"><a href="../timeline">BLOGS</a></li>
				<li class="navigation_search"><span class="search_label">RECHERCHER</span></li>
				<form action="search/" method="get" class="search_form">
					<input type="text" name="search_input" class="search_field">	
					<input type="submit" name="search_submit" class="search_submit" value="GO">
				</form>
			</ul>
		</div>

	</div>

	<div class="navigation_adornment">
		<img src="../img/nav_adornment.png">
	</div>

	<div class="web_outline">
		<div class="web_content">
			<div class="content_header">
            <img src="../img/login.png" />
         </div>
         <div class="content">
            <div class="form_container">
        
               <div class="form_header">
                  <img src="../img/forgot.png" />
               </div>
               <div class="form_fields">
                  <form action="../handlers/?task=edit_password" method="post">
                     <label for="password">Nouveau mot de passe</label>
                     <input type="password" name="password" id="password" required /><br>
                     <label for="verif">Vérification du mot de passe</label>
                     <input type="password" name="verif" id="verif" required /><br>
                     <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
                     <input type="image" src="../img/submit.png" alt="Submit" style="margin:10px">
                  </form>
               </div>
               <br>
            </div>
         </div>
</body>
</html>