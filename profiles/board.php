   <?php
   if (!isset($post_id) && !isset($_GET['user'])) {
      $post_id = $_POST["post_id"];
      $_GET['user'] = $_POST['user'];
      include '../handlers/db.php';
   }
   if (!function_exists('str_contains')) {
      function str_contains(string $haystack, string $needle): bool
      {
          return '' === $needle || false !== strpos($haystack, $needle);
      }
  }
   ?>
   <div class="board_content" id="public_<?php echo $post_id?>">
            <div class="board_left">
               <?php
                  $sql = "SELECT * FROM `users` WHERE `id`='".$_GET['user']."'";
                  $result = mysqli_query($conn, $sql);
                  $data = mysqli_fetch_row($result);
                  echo '<img src="../user_assets/profile_pictures/'.$data[8].'">';
               ?>
            </div>
            <div class="board_right">
               <div class="board_status">
               <?php
                  $sql = "SELECT * FROM `statuses` WHERE `user`='".$_GET['user']."' AND `id`='".$post_id."' ORDER BY `id` DESC";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result)!=0) 
                  {
                     $data = mysqli_fetch_row($result);
                  }
                  else
                  {
                     $data[2] = "Il n'y a rien à voir ici.";
                     $data[4] = "11";
                     $data[3] = "distrubed";
                  }
               ?>
                  <div class="board_status_text">
                     <?php echo $data[2];
                     if(str_contains($data[6], "image"))
                     {
                        echo '<br><br><img class="attachement" src=../user_assets/attachements/'.$data[7].'>';
                     }
                     elseif(str_contains($data[6], "video"))
                     {
                        echo '<br><br><video controls class="attachement"> <source src=../user_assets/attachements/'.$data[7].'>';
                     }
                     ?>
                  </div>
                  <div class="board_mood_container">
                     <span id="board_default_mood">Mood</span><br>
                     <img src=<?php echo '"../img/moods/'.$data[4].'.gif"'?>><br>
                     <span id="board_actual_mood"><?php echo $data[3];?></span>
                  </div>
                </div>
               <?php
                  $sql = "SELECT * FROM `comments` WHERE `post`='".$data[0]."' ORDER BY `id` DESC LIMIT 3";
                  $c_result = mysqli_query($conn, $sql);
                  $data = mysqli_fetch_row($result);
                  if(mysqli_num_rows($result)!= 0)
                  {
                     while($row = $c_result->fetch_array()) 
                     { 
                        $commentator_id = $row[2];
                        $comment = $row[3];
                        include 'comments.php';
                     }
                  }
               ?>
               <input type="text" name="comment_field_<?php echo $post_id;?>" id="comment_field_<?php echo $post_id;?>" class="comment_field">
               <br><div class="discret_message" id="comment_message_<?php echo $post_id;?>"></div><br>
               <div class="board_interaction"> 
                  <div class="board_like">
                     <?php
                        if (isset($_SESSION['id'])) 
                        {
                           if ($_GET['user'] != $userid) 
                           {
                              $sql = "SELECT * FROM `likes` WHERE `post`='".$post_id."' AND `user`='".$userid."'";
                              $result = mysqli_query($conn, $sql);
                              if (mysqli_num_rows($result)==0) 
                              {
                                 echo '
                                 <input type="image" class="like" id="submit_'.$post_id.'" src="../img/like.png" alt="Submit" style="margin:10px">
                                 ';
                              }
                              elseif (mysqli_num_rows($result)==1) 
                              {
                                 echo '
                                 <input type="image" class="dislike" id="submit_'.$post_id.'" src="../img/dislike.png" alt="Submit" style="margin:10px">
                                 ';
                              }
                           }
                           elseif ($_GET['user'] == $userid) 
                           {
                              echo '
                              <input type="image" class="delete" id="submit_'.$post_id.'" src="../img/delete.png" alt="Submit" style="margin:10px">
                              ';
                           }


                        }
                        else
                        {
                           echo '<form><a href="../login/"><img src="../img/like.png"></a></form>';
                        }
                     ?>    
                  </div>
                  <div class="board_icomment">
                     <?php
                     if (isset($_SESSION['id'])) 
                     {
                        if ($userid != $_GET['user']) 
                        {
                           echo '
                                 <input type="image" class="comment" id="comment_submit_'.$post_id.'" src="../img/comment.png" alt="Submit" style="margin:10px">
                                 ';
                        }
                        elseif ($userid == $_GET['user']) 
                        {
                           echo '
                           <script type="text/javascript">
                           comment_field_'.$post_id.' = document.getElementById("comment_field_'.$post_id.'");
                           comment_field_'.$post_id.'.style.visibility = "hidden";
                        </script>
                                 ';
                        }
                     }
                     else
                     {
                        echo '<form><a href="../login/"><img src="../img/comment.png"></a></form>';
                     }
                     ?>
                  </div>
               </div>
               <br>
               <?php 
                  $sql = "SELECT * FROM `likes` WHERE `post`='".$post_id."'";
                  $result = mysqli_query($conn, $sql);
                  $likes = mysqli_num_rows($result);
               ?>
               <span class="liked_text"><span id="number_liked_text_<?php echo $post_id;?>"><?php echo $likes;?></span> utilisateurs ont aimé cette publication</span><br>
               <script type="text/javascript">
                  submit_<?php echo $post_id;?> = document.getElementById('submit_<?php echo $post_id;?>');
                  if (submit_<?php echo $post_id;?>){
                     submit_<?php echo $post_id;?>.addEventListener('click', ()=>{
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = ()=>
                        {
                           if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                              var check = xmlhttp.responseText;
                              console.log(check);
                         }
                        };
                        if (submit_<?php echo $post_id;?>.className == 'like') 
                        {
                           xmlhttp.open("get", "../handlers/?task=like&liked=<?php echo $post_id;?>", true);
                           xmlhttp.send();
                           submit_<?php echo $post_id;?>.className = 'dislike';
                           submit_<?php echo $post_id;?>.src = "../img/dislike.png";
                           number_liked_text_<?php echo $post_id;?> = document.getElementById('number_liked_text_<?php echo $post_id;?>');
                           number_liked_text_<?php echo $post_id;?>.innerHTML = parseInt(number_liked_text_<?php echo $post_id;?>.innerHTML)+1;
                        }
                        else if (submit_<?php echo $post_id;?>.className == 'dislike') 
                        {
                           xmlhttp.open("get", "../handlers/?task=unlike&unliked=<?php echo $post_id;?>", true);
                           xmlhttp.send();
                           submit_<?php echo $post_id;?>.className = 'like';
                           submit_<?php echo $post_id;?>.src = "../img/like.png";
                           number_liked_text_<?php echo $post_id;?> = document.getElementById('number_liked_text_<?php echo $post_id;?>');
                           number_liked_text_<?php echo $post_id;?>.innerHTML = parseInt(number_liked_text_<?php echo $post_id;?>.innerHTML)-1;
                        }
                        else if (submit_<?php echo $post_id;?>.className == 'delete') 
                        {
                           xmlhttp.open("get", "../handlers/?task=delete&deleted=<?php echo $post_id;?>", true);
                           xmlhttp.send();
                           deleted_<?php echo $post_id;?> = document.getElementById('public_<?php echo $post_id?>');
                           deleted_<?php echo $post_id;?> .innerHTML="";
                           
                        }
                     });
                  }
               </script>
               <script type="text/javascript">
                   comment_field_<?php echo $post_id;?> = document.getElementById('comment_field_<?php echo $post_id;?>');
                   comment_message_<?php echo $post_id;?> = document.getElementById('comment_message_<?php echo $post_id;?>')
                   comment_submit_<?php echo $post_id;?> = document.getElementById('comment_submit_<?php echo $post_id;?>');
                   if (comment_field_<?php echo $post_id;?> && comment_message_<?php echo $post_id;?> && comment_submit_<?php echo $post_id;?>)
                   {
                     comment_field_<?php echo $post_id;?>.addEventListener('input',(e)=>{
                        if (e.target.value.length>=200)
                        {
                           comment_message_<?php echo $post_id;?>.innerHTML='Votre commentaire ne doit pas dépasser les 200 caratères';
                           comment_submit_<?php echo $post_id;?>.style.visibility = 'hidden';
                        }
                        else
                        {
                           comment_message_<?php echo $post_id;?>.innerHTML='';
                           comment_submit_<?php echo $post_id;?>.style.visibility = 'visible';
                        }
                     });
                     comment_submit_<?php echo $post_id;?>.addEventListener('click',(e)=>{
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = ()=>
                        {
                           if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                              var check = xmlhttp.responseText;
                              console.log(check);
                         }
                        };
                      xmlhttp.open("get", "../handlers/?task=comment&post=<?php echo $post_id;?>&comment="+comment_field_<?php echo $post_id;?>.value, true);
                      xmlhttp.send();
                      comment_field_<?php echo $post_id;?>.value='';
                     });
                   }

               </script>
            </div>
         </div>