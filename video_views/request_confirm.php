<? include("../dbconnection_3evchey.php"); //connecting Database
session_start();
if($_POST['client_id']=='' && $_POST['project_id']==''){
header("location: ../index.java");
}
$mail_message = "";

$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
if($cca_num==0){
header("location: ../index.java");
}
$projectname = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']);
$projectname_row = mysql_fetch_array($projectname);

$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$last_video_under_project_row = mysql_fetch_array($last_video_under_project);
$forloopcount = 0;

$stop_resubmit_bug = mysql_query("UPDATE video_client_addition_request SET stop_resubmit = 0 WHERE video_id = ".$last_video_under_project_row['id']);

/*=======================================*/
/*          Time feedback of video       */
/*=======================================*/							

for($i=0; $i<1000; $i++){//runing 1000 time to add feedback to array
	if($_POST['feedback_'.$i]!=""){
		$feedback[$forloopcount] = $_POST['feedback_'.$i];
		$feedback_strat[$forloopcount] = $_POST['time_start_'.$i];
		$feedback_end[$forloopcount] = $_POST['time_end_'.$i];
		$feedback_type[$forloopcount] = $_POST['comment_option_'.$i];
		$forloopcount = $forloopcount + 1;
	}
}
/*for($i=0; $i<$forloopcount; $i++){
	$update_video_client_request = mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$feedback_strat[$i]."', '".$feedback_end[$i]."', '".$feedback[$i]."', '".$feedback_type[$i]."')");
	$list_comment .= '<tr><td>'.$feedback_strat[$i].'</td><td>'.$feedback_end[$i].'</td><td>'.$feedback_type[$i].'</td><td>'.$feedback[$i].'</td></tr>';
	//echo "INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')";
}

if($_POST['voice_comment']!=""){
	$update_video_client_addition_request = mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '".$last_video_under_project_row["id"]."', '".$_POST['script1']."', '".$_POST['script2']."', '".$_POST['logoandimage_email']."', '".$_POST['logoandimage_dropbox']."', '".$_POST['voice_id']."', '".$_POST['voice_comment']."', '".$_POST['audio_comment']."', '".$_POST['contact_info1']."', '".$_POST['contact_info2']."', '".$_POST['contact_info3']."', '".$_POST['contact_info4']."')");
	$general_comment = $_POST['voice_comment'];
}
*/


$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1");
$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
include('../inc/youtube_function.php');
$contents_location = "http://gdata.youtube.com/feeds/api/videos?q={".cleanYoutubeLink($last_video_under_project_row['video_link'])."}&alt=json";
$JSON = file_get_contents($contents_location);
$JSON_Data = json_decode($JSON);
$video_lenght = $JSON_Data->{'feed'}->{'entry'}[0]->{'media$group'}->{'yt$duration'}->{'seconds'};
$video_lenght_result = $video_lenght.':000';
$end_time = gmdate("i:s", (int)$video_lenght_result);
?>
<!DOCTYPE html>
<html>
	<? include('../inc/head.php');?>
<?php
/*=======================================*/
/*         Get Feedback Deadline         */
/*=======================================*/							
	function check_deadline($function_v_project_id, $version, $mode){
		$check_deadline = mysql_query("SELECT upload_time FROM video_under_project WHERE video_project_id = ".$function_v_project_id." AND version LIKE '".$version."' AND enabling = 1 ORDER BY id LIMIT 0, 1");
		$check_deadline_row = mysql_fetch_array($check_deadline);
		 $now = time(); // or your date as well
		 $data_format = substr($check_deadline_row['upload_time'], 0, 10);
		 $upload_date = strtotime($data_format);
		 $datediff = $now - $upload_date;
		 if($mode == "deadline"){
		 	return 21 - floor($datediff/(60*60*24));
		 }else{
		 	return date('d-F-Y', strtotime($check_deadline_row['upload_time']));
		 }
		 //return  $data_format ;
	}
?>
	<body class="">
		<? include('client_header.php'); ?>
        <input value="<?php echo $end_time;?>" id="video_end_time" type="hidden">
		<main>
<?
$forloopcount = 0;
for($i=0; $i<1000; $i++){//runing 1000 time to add feedback to array
	if($_POST['feedback_'.$i]!=""){
		$feedback[$forloopcount] = $_POST['feedback_'.$i];
		$feedback_strat[$forloopcount] = $_POST['time_start_'.$i];
		$feedback_end[$forloopcount] = $_POST['time_end_'.$i];
		$feedback_type[$forloopcount] = $_POST['comment_option_'.$i];
		$forloopcount = $forloopcount + 1;
	}
}
for($j=0; $j<$forloopcount; $j++){
	if($j==0){
		$addcommenttimes .= '<ul id="time-comment_first">
		<li>
		<input value="'.$forloopcount.'" name="old_loop_time" type="hidden"/>
		</li>';	
	}
	$select_type1 = '';
	$select_type2 = '';
	$select_type3 = '';
	if($feedback_type[$j]=='1'){
		$select_type1 = 'selected="selected"';
	}
	if($feedback_type[$j]=='2'){
		$select_type2 = 'selected="selected"';
	}
	if($feedback_type[$j]=='3'){
		$select_type3 = 'selected="selected"';
	}
	$addcommenttimes .= '
		<li  class="container">
		<div class="controls">
			<span class="timeline_picker">
				<label for="start">Start</label>
				<input value="'.$feedback_strat[$j].'" name="addtimestart'.$j.'">
			</span>
				<span class="timeline_picker end">
				<label for="start">End</label>
			<input value="'.$feedback_end[$j].'" name="addtimeend'.$j.'">
			</span>
			<select name="addcommentoption'.$j.'"  class="five columns">
				<option value="1" '.$select_type1.'>Changes To Video</option>
				<option value="2" '.$select_type2.'>Changes To Audio</option>
				<option value="3" '.$select_type3.'>Other</option>
			</select>
		</div>
		<textarea rows="5" cols="30" name="addfeedback'.$j.'" class="fourteen columns">'.$feedback[$j].'</textarea>
		</li>	
	';
}
$addcommenttimes .= '</ul>';
?>							
    <form id="charge_update" action="client_view.java" method="post">
        <input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
        <input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
        <input value="1" name="charge_change" type="hidden">

		<section class="container">
			
			<ul id="videos" >         
					<li class="video_obj featured">
						<h1 class="title">
                        
						<?php echo $cca_row['company_name'];?> - <?php echo $projectname_row['project_name']?> - <span><?php echo $last_video_under_project_row['version']; ?>  (<? echo check_deadline($_POST['project_id'], $last_video_under_project_row['version']); ?>)</span>
						</h1>
						<?php 
						if($_POST['add_more_changed']=='yes'){
							echo '
								<label class="message blue">There may be a fee for additional changes. Please submit feedback and we will send you a quote as soon as possible.</label>
							';
						}else if($last_video_a_request_row['comment_time2']==0){  ?>
						<label class="message blue">Please confirm your changes</label>
						<?php } else { ?>
						<label class="message blue">Please double check your changes, these are your last changes.</label>
						<?php } ?>
						<?php echo $overdeadline_message;?>
						<div class="video sixteen columns">
							<!-- VIMEO EMBED -->
							<iframe  src="//www.youtube.com/embed/<?=cleanYoutubeLink($last_video_under_project_row['video_link']);?>?rel=0" frameborder="0" allowfullscreen></iframe>
							<!-- VIMEO EMBED -->
						</div>

						<div class="comment_check">
						<label class="title" for="">Your Notes</label>
						<ul id="comments-general" class="container">
							
							<li>
							<textarea name="voice_comment" id="general-comment" class="fifteen columns" cols="30" rows="10" placeholder="General Comments on the Video"><?php echo $_POST['voice_comment']; ?></textarea>
							</li>
							</ul>
                            <?php echo $addcommenttimes; ?>
							<ul id="time-comments">
								
							</ul>
							<div class="submit-actions">
							<a href="javascript:void(0)" onClick="NewTimelineComment()" class="btn blue columns five alpha"><span>add more timeline comments</span> <i class="fa fa-clock-o"></i></a>
							<a class="btn green columns five alpha" onClick="document.getElementById('charge_update').submit();"><span>submit all comments</span> <i class="fa fa-send"></i></a>
							</div>
						</div>
					</li>
					<?php
						if($_POST['add_more_changed']=='yes'){
							echo '<input name="add_more_changed" value="yes" type="hidden">';
						}
					?>
           
			</section>
            </form>
			</main>
			<? include('../footer.php');?>
			<div id="overlay_wrapper" onClick="closeAllCards()"></div>
		</body>
	</html>