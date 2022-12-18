<?php
$sql = 'SELECT * FROM users WHERE id='.$user;
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_row($result);
?>				
	
					<div class="popular_profile">
						<a href="profiles/?user=<?php echo $data[0];?>">
							<img src="user_assets/profile_pictures/<?php echo $data[8]?>"><br>
							<span><?php echo $data[1];?></span>
						</a>
					</div>