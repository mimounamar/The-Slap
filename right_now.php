			<?php
			$sql = 'SELECT * FROM statuses WHERE id='.$post_id.'';
			$result = mysqli_query($conn, $sql);
			$data = mysqli_fetch_row($result);
			$rn_date = $data[5];
			$rn_status = $data[2];
			$rn_mood = $data[4];
			$rn_actual_mood = $data[3];
			$rn_user = $data[1];
			$sql = 'SELECT * FROM users WHERE id='.$rn_user.'';
			$result = mysqli_query($conn, $sql);
			$data = mysqli_fetch_row($result);
			$pp = $data[8];
			$name = explode(" ", $data[1]);
			$name = $name[0];
			?>
			<div class="rn_status fade">
						<div class="rn_profile_info">
							<div class="rn_profile_picture">
								<img src="user_assets/profile_pictures/<?php echo $pp?>">
							</div>

							<div class="rn_details">
								<span class="rn_date"><?php echo $rn_date;?></span><br>
								<span class="rn_profile"><?php echo $name;?></span><br>
								<span class="rn_update">a publié :</span>
							</div>
						</div>
						<div class="rn_status_container">
						<span class="rn_status_text"><?php echo $rn_status;?></span>
						<span class="rn_mood"><span id="default_mood">Mood = </span><span id="mood_image"></span><img src="img/moods/<?php echo $rn_mood;?>.gif"><span id="actual_mood"><?php echo $rn_actual_mood;?></span></span>
					</div>
					</div>