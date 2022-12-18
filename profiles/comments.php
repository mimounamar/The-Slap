<div class="board_comment">
                  <div class="board_comment_profile">
                     <?php
                        $sql = "SELECT * FROM `users` WHERE `id`='".$commentator_id."'";
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_row($result);
                        echo '<img src="../user_assets/profile_pictures/'.$data[8].'">';
                     ?>
                  </div>
                  <div class="board_comment_text">
                     <span> <a href=<?php echo '"../profiles?user='.$data[0].'"'; ?>><?php echo $data[1];?></a> <?php echo $comment; ?></span><br>
                  </div>
               </div>