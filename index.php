<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
include 'handlers/db.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Slap</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&family=Roboto+Condensed:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/draft.css">
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
    $sql = "SELECT * FROM `users` WHERE `id`='".$userid."'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_row($result);
    $name = $data[2];
    echo '<div class="credentials_container">
		<a href="profiles" class="credentials_link">Connecté en tant que '.$name.'</a>
		<a href="handlers/disconnect.php" class="credentials_link">Se déconnecter</a>
	</div>';

	}
	else
	{
		echo '<div class="credentials_container">
		<a href="register/" class="credentials_link">Inscription</a>
		<a href="login/" class="credentials_link">Connexion</a>
	</div>';
	}
	?>

	<div class="navigation_bar">

		<div class="navigation_logo">
			<img src="img/logo.png">
		</div>

		<div class="navigation_list">
			<ul>
				<li class="navigation_component"><a href="/">ACCUEIL</a></li>
				<li class="navigation_component"><a href="profiles/">PROFILS</a></li>
				<li class="navigation_component"><a href="messages/">MESSAGES</a></li>
				<li class="navigation_component"><a href="timeline/">BLOGS</a></li>
				<li class="navigation_search"><span class="search_label">RECHERCHER</span></li>
				<form action="search/" method="get" class="search_form">
					<input type="text" name="search_input" class="search_field">	
					<input type="submit" name="search_submit" class="search_submit" value="GO">
				</form>
			</ul>
		</div>

	</div>

	<div class="navigation_adornment">
		<img src="img/nav_adornment.png">
	</div>

	<div class="web_outline">
		<div class="web_content">
			<div class="main_container">
				<div class="the_right_now">
					<?php
					$sql = "SELECT `post`, COUNT(`post`) AS MOST_FREQUENT FROM likes GROUP BY `post` ORDER BY COUNT(`post`) DESC LIMIT 5";
					$post_result = mysqli_query($conn, $sql);
					while($row = $post_result->fetch_array()) 
		            { 
		               $post_id = $row[0];
		               include 'right_now.php'; 
		            }
					?>
					<script type="text/javascript">
						var slideIndex = 0;
						showSlides();

						function showSlides() {
						  var i;
						  var slides = document.getElementsByClassName("rn_status");
						  for (i = 0; i < slides.length; i++) {
						    slides[i].style.display = "none";
						  }
						  slideIndex++;
						  if (slideIndex > slides.length) {slideIndex = 1}
						  slides[slideIndex-1].style.display = "block";
						  setTimeout(showSlides, 10000);
						} 
					</script>
					
				</div>
				<div>
					<div class="the_new_stuff">
					<div class="category_header">
						<span class="category_title_1">quoi</span>
						<span class="category_title_2">DE NEUF?</span>
					</div>
					<div class="ns_banner">
						<a href="news/"><img src="img/test/5.png"></a>
					</div>
				</div>
				<div class="fun_fact">
					<div class="category_header">
						<span class="category_title_1">le</span>
						<span class="category_title_2">FUN FACT</span>
					</div>	
					<div class="fun_fact_container">
						<span>
						<?php
						$sql = "SELECT * FROM funfacts ORDER BY RAND() LIMIT 1";
						$result = mysqli_query($conn, $sql);
						$data = mysqli_fetch_row($result);
						echo $data[1];
						?>
						</span>
					</div>
				</div>
				</div>
			</div>
			<div class="most_popular">
				<div class="category_header">
					<span class="category_title_1">les plus</span>
					<span class="category_title_2">VUS</span>
				</div>
							<div class="most_popular_container">
					<?php
						$sql = "SELECT `user`, COUNT(`user`) AS MOST_FREQUENT FROM visits GROUP BY `user` ORDER BY COUNT(`user`) DESC LIMIT 7";
						$post_result = mysqli_query($conn, $sql);
						while($row = $post_result->fetch_array()) 
			            { 
			               $user = $row[0];
			               include 'popular.php'; 
			            }
					?>
				

				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>