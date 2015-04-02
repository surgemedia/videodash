<li class="video_obj five columns <?php echo $show_final_color ?>" onclick="expandCard($(this))">
	<span class="ver_number"><?php echo $video_row['version_num'] ?></span>
	<h3 class="title"><?php echo $check_project_name_row['project_name'] ?></h3>
	<div class="video draft">
		<iframe width="500" height="400" src="//www.youtube.com/embed/<?php echo cleanYoutubeLink($video_row['video_link']); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
	</div>
	<div class="feedback_wrapper">
		<?php echo $new_final_message ?>
		<ul class="pasttimestamps">
			<li class="director"><h3>Directors Notes</h3><small><?php  echo $video_row['notes'] ?></small></li>
			<li><h3>Your feedback</h3><small><?php echo $list_video_client_addition_request_row['voice_comment'] ?></small></li>
			<?php echo $list_video_feedback[$i]; ?>
		</ul>
	</div>
</li>