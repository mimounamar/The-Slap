 <div class="profile_header" style='background-image: url("../user_assets/banners/<?php echo $userdata[9];?>"); border-radius: 10px;'>
         <div class="profile_picture">
          <?php  echo '<a href=../profiles/?user='.$userdata[0].'><img src="../user_assets/profile_pictures/'.$userdata[8].'"></a>';?>
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
      if ($userid == $_GET['user']) {
         echo '<br><a href="../profiles/edit"><img src="../img/edit.png"></a>';
      }
      else
      {
         $sql = "SELECT * FROM `follows` WHERE `followed`='".$_GET["user"]."' AND `follower`='".$userid."'";
         $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result)==0) 
         {
            echo '
            <input type="image" class="follow" id="submit_'.$_GET["user"].'" src="../img/follow.png" alt="Submit" style="margin:10px">
            ';
         }
         elseif (mysqli_num_rows($result)==1) 
         {
            echo '
            <input type="image" class="unfollow" id="submit_'.$_GET["user"].'" src="../img/unfollow.png" alt="Submit" style="margin:10px">
            ';
         }
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
            number_followed_text_<?php echo $_GET["user"];?> = document.getElementById('number_followed_text_<?php echo $_GET["user"];?>');
            number_followed_text_<?php echo $_GET["user"];?>.innerHTML = parseInt(number_followed_text_<?php echo $_GET["user"];?>.innerHTML)+1;
         }
         else if (submit_<?php echo $_GET["user"];?>.className == 'unfollow') 
         {
            xmlhttp.open("get", "../handlers/?task=unfollow&unfollowed=<?php echo $_GET["user"];?>", true);
            xmlhttp.send();
            submit_<?php echo $_GET["user"];?>.className = 'follow';
            submit_<?php echo $_GET["user"];?>.src = "../img/follow.png";
            number_followed_text_<?php echo $_GET["user"];?> = document.getElementById('number_followed_text_<?php echo $_GET["user"];?>');
            number_followed_text_<?php echo $_GET["user"];?>.innerHTML = parseInt(number_followed_text_<?php echo $_GET["user"];?>.innerHTML)-1;

         }
            
      });
   </script>
</div>
</div>
<br>