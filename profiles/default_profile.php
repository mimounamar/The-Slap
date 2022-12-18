<?php
if(!isset($_SESSION)){
  session_start();
}
include '../handlers/db.php';
if (!isset($_GET['page'])) 
{
   $_GET['page'] = 1;
}
if (!isset($_GET['comment_limit'])) 
{
   $_GET['comment_limit'] = 5;
}
$sql = "SELECT * FROM users WHERE id='".$_GET["user"]."'";
$result = mysqli_query($conn, $sql);
$userdata = mysqli_fetch_row($result);

if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
$sql = "SELECT * FROM visits WHERE ip='".$ip_address."' AND user=".$_GET['user'];
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)==0) 
{
   $sql = "INSERT INTO `visits`(`ip`, `user`) VALUES ('".$ip_address."',".$_GET['user'].")";
   $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>The Slap - Profil</title>
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet" />
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&family=Roboto+Condensed:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet" />
   <link rel="stylesheet" href="../css/draft.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
     $id = $data[0];
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
      <div class="profile_header" style='background-image: url("../user_assets/banners/<?php echo $userdata[9];?>");'>
         <div class="profile_picture">
          <?php  echo '<img src="../user_assets/profile_pictures/'.$userdata[8].'">';?>
       </div>
       <div class="profile_status">
         <div class="profile_name">
            <?php 
            $name_lenght = strlen($userdata[1]);
            for ($i=0; $i < $name_lenght ; $i++) 
            { 
               $translation = 1 * $i;
               $translation = strval($translation); 
               if ($userdata[1][$i] == " ") 
               {
                  echo '<img src="../img/letters/space.png" style="transform: translateX(-'.$translation.'px);">';
               }
               else
               {
                  $step[1][$i] = strtolower($userdata[1][$i]);
                  echo '<img src="../img/letters/'.$step[1][$i].'.png" style="transform: translateX(-'.$translation.'px);">';
               }
            }
            ?>
         </div>
         <div class="status_bubble">
            <div class="bubble_text">
               <span class="latest_title"><span class="maj">D</span>ERNIÈRE <span class="maj">M</span>ISE <span class="maj">À</span> <span class="maj">J</span>OUR</span> <br>

               <div class="latest_text">
                <div><img src="../img/glyph_pulse_dot.png"></div>
                <?php
                $sql = "SELECT * FROM statuses WHERE user='".$_GET["user"]."' ORDER BY `id` DESC";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)!=0) 
                {
                  $latest_data = mysqli_fetch_row($result);
                  $latest_status = $latest_data[2];
                  $latest_mood_img = $latest_data[4];
                  $latest_mood_txt = $latest_data[3];
               }
               else
               {
                $latest_status = "Il n'y a rien à voir ici !";
                $latest_mood_img = "11";
                $latest_mood_txt = "distrubed";
             }

             ?>
             <div class="latest_status"><?php echo $latest_status;?></div>
          </div>
       </div>
       <div class="bubble_mood">
         <div class="bubble_mood_container">
            <span id="latest_default_mood">Mood</span><br>
            <img src=<?php echo '"../img/moods/'.$latest_mood_img.'.gif"'?>> <br>
            <span id="latest_actual_mood"><?php echo $latest_mood_txt;?></span>
         </div>
      </div>
   </div>
   <?php
   if (isset($_SESSION['id'])) 
   {
         $sql = "SELECT * FROM `follows` WHERE `followed`='".$_GET["user"]."' AND `follower`='".$userid."'";
         $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result)==0) 
         {
            echo '
            <input type="hidden" name="user_'.$_GET["user"].'" value="'.$_GET["user"].'"</input>
            <input type="image" class="follow" id="submit_'.$_GET["user"].'" src="../img/follow.png" alt="Submit" style="margin:10px">
            ';
         }
         elseif (mysqli_num_rows($result)==1) 
         {
            echo '
            <input type="hidden" name="user_'.$_GET["user"].'" value="'.$_GET["user"].'"</input>
            <input type="image" class="unfollow" id="submit_'.$_GET["user"].'" src="../img/unfollow.png" alt="Submit" style="margin:10px">
            ';
         }
   }
   else
   {
      echo '<a href="../login/"><img src="../img/follow.png"></a>';
   }
   ?>
   <?php
   $sql = "SELECT * FROM `follows` WHERE `followed`='".$_GET["user"]."'";
   $result = mysqli_query($conn, $sql);
   $followers = mysqli_num_rows($result);
   ?>
   <span class="followed_text"><?php echo $userdata[1];?> est suivi(e) par <span class="number_followed_text" id="number_followed_text_<?php echo $_GET["user"];?>"><?php echo $followers;?></span> personnes !</span>
   <script type="text/javascript">
      submit_<?php echo $_GET["user"];?> = document.getElementById('submit_<?php echo $_GET["user"];?>');
      submit_<?php echo $_GET["user"];?>.addEventListener('click', ()=>{
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = ()=>
         {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               var check = xmlhttp.responseText;
               console.log(check);
          }
         };
         if (submit_<?php echo $_GET["user"];?>.className == 'follow') 
         {
            xmlhttp.open("get", "../handlers/?task=follow&followed=<?php echo $_GET["user"];?>", true);
            xmlhttp.send();
            submit_<?php echo $_GET["user"];?>.className = 'unfollow';
            submit_<?php echo $_GET["user"];?>.src = "../img/unfollow.png";
            let number_followed_text_<?php echo $_GET["user"];?> = document.getElementById('number_followed_text_<?php echo $_GET["user"];?>');
            number_followed_text_<?php echo $_GET["user"];?>.innerHTML = parseInt(number_followed_text_<?php echo $_GET["user"];?>.innerHTML)+1;
         }
         else if (submit_<?php echo $_GET["user"];?>.className == 'unfollow') 
         {
            xmlhttp.open("get", "../handlers/?task=unfollow&unfollowed=<?php echo $_GET["user"];?>", true);
            xmlhttp.send();
            submit_<?php echo $_GET["user"];?>.className = 'follow';
            submit_<?php echo $_GET["user"];?>.src = "../img/follow.png";
            let number_followed_text_<?php echo $_GET["user"];?> = document.getElementById('number_followed_text_<?php echo $_GET["user"];?>');
            number_followed_text_<?php echo $_GET["user"];?>.innerHTML = parseInt(number_followed_text_<?php echo $_GET["user"];?>.innerHTML)-1;

         }
            
      });
   </script>
</div>
</div>
<div class="content">
   <div class="profile_content">
      <div class="board" id="board"> <!--START OF BOARD-->
         <div class="board_header">
            <span class="board_title">PUBLICATIONS<span class="board_user">de <?php echo $userdata[1];?></span>
         </div>
         <div id="publications">
         <?php
         $limit = 5;
         $offest = $_GET['page']*5 - 5;
         $sql_post = "SELECT * FROM `statuses` WHERE `user`='".$_GET['user']."' ORDER BY `id` DESC LIMIT ".$offest.", ".$limit;
         $post_result = mysqli_query($conn, $sql_post);
         if (mysqli_num_rows($post_result) == 0) 
         {
            $post_id = False;
            include 'board.php';
         }
         else
         {
            while($row = $post_result->fetch_array()) 
            { 
               $post_id = strval($row[0]); 
               include 'board.php'; 
            }
            $nextpage = $_GET['page']+1;
            echo '<a href="../profiles/?user='.$_GET['user'].'&page='.$nextpage.'" id="next_page" class="next_page">En voir +</a>';
         }
         ?>
         </div>
      </div> <!--END OF BOARD-->

      <div class="widget">
         <div class="widget_header">
            <span class="board_title">WIDGETS<span class="board_user">de <?php echo $userdata[1];?></span>
         </div>
         <iframe src="https://open.spotify.com/embed/track/<?php echo $userdata[10]?>?utm_source=generator&theme=0" width="350" height="235" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
      </div>
   </div>
</div>
</div>
</div>
</body>
</html>

