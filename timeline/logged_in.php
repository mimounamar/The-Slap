<?php
if (!isset($_GET['page'])) 
{
   $_GET['page'] = 1;
}
?>
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
	?>

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
			<div class="main_container">
				<div class="tl_container">
					<div class="publish_container">
						<div class="publish_header">
							<span class="publish_title">PARTAGEZ<span class="publish_user">vos pensées</span>
						</div>
						<div class="publish_content">
							<form id="status_form">
								<input type="text" name="publish_query" class="publish_query" required>
								<div class="discret_message" id="text_message"></div><br>
								<span class="mood_text">Mood=</span>
								<input type="text" name="mood_query" class="mood_query" required><br><br>
								<div class="discret_message" id="mood_message"></div><br>
								<span class="mood_text">Médias</span>
								<div class="discret_message" id="attachement_message"></div>
								<input type="file" id="publish_attachement" name="publish_attachement" class="publish_attachement"><br>
								<div class="mood_selector_container">
									<?php
									$fi = new FilesystemIterator('../img/moods', FilesystemIterator::SKIP_DOTS);
									$fi = iterator_count($fi);
									for ($i=1; $i < $fi; $i++) 
									{ 
										echo '<input type="radio" name="mood_selector" class="mood_selector" id="'.$i.'" value="'.$i.'" required><label for="'.$i.'"><img src="../img/moods/'.$i.'.gif"></label>';
										if ($i%5 == 0) {
											echo "<br><br>";
										}
									}
									?>
									
								</div>
								<br> <div style="text-align: center;"><input type="image" id="submit" src="../../img/submit.png" alt="Submit"></div>
							</form><br>
						</div>
					</div>
					<script src="../scripts/publish.js"></script>
					<div class="board">
                  <div class="board_header">
                     <span class="board_title">PUBLICATIONS<span class="board_user">récentes</span>
                  </div>
                  <?php
                  $sql = 'SELECT `followed` FROM follows WHERE follower = '.$userid;
                  $result = mysqli_query($conn, $sql);
                  $array = array();		
		            while($row = $result->fetch_array()) 
		            { 
		               array_push($array, $row[0]); 
		            }
    					$array = implode("','",$array);
    					$limit = 25;
         				$offest = $_GET['page']*25 - 25;
    					$sql = "SELECT * FROM statuses WHERE user IN ('".$array."') ORDER BY id DESC LIMIT ".$offest.", ".$limit;
    					$post_result = mysqli_query($conn, $sql);
    					if (mysqli_num_rows($post_result) == 0) 
			         {
			         	$data[2] = "Il n'y a rien à voir ici.";
                     $data[4] = "11";
                     $data[3] = "distrubed";
			            echo '<div class="board_content"><div class="board_status_text">'.$data[2].'</div></div>';
			         }
			         else
			         {
			            while($row = $post_result->fetch_array()) 
			            { 
			               $post_id = $row[0];
			               $_GET['user'] =  $row[1];
			               include '../profiles/board.php'; 
			            }
			            $nextpage = $_GET['page']+1;
			         echo '<a href="../timeline/?page='.$nextpage.'" class="next_page" style="color:black;">En voir +</a>';
			         }
                  ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>