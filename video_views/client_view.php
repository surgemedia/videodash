<? include("../dbconnection_3evchey.php"); //connecting Database
session_start();
if($_POST['client_id']=='' && $_POST['project_id']==''){
header("location: ../index.php");
}
$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
if($cca_num==0){
header("location: ../index.php");
}
$projectname = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']);
$projectname_row = mysql_fetch_array($projectname);
$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$last_video_under_project_row = mysql_fetch_array($last_video_under_project);

if($_POST['add_comments']==1){
for($i=0; $i<$_POST['looptimes']; $i++){
if($_POST['feedback'.$i]!=""){
$update_video_client_request = mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')");
//echo "INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')";
}
}
$update_video_client_addition_request = mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '".$last_video_under_project_row["id"]."', '".$_POST['script1']."', '".$_POST['script2']."', '".$_POST['logoandimage_email']."', '".$_POST['logoandimage_dropbox']."', '".$_POST['voice_id']."', '".$_POST['voice_comment']."', '".$_POST['audio_comment']."', '".$_POST['contact_info1']."', '".$_POST['contact_info2']."', '".$_POST['contact_info3']."', '".$_POST['contact_info4']."')");
$_SESSION['looptimes']=0;
//echo "INSERT INTO video_client_addition_request VALUES(NULL, ".$last_video_under_project_row["id"].", ".$_POST['script1'].", ".$_POST['script2'].", ".$_POST['logoandimage_email'].", ".$_POST['logoandimage_dropbox'].", ".$_POST['voice_id'].", '".$_POST['voice_comment']."', '".$_POST['audio_comment']."', '".$_POST['contact_info1']."', '".$_POST['contact_info2']."', '".$_POST['contact_info3']."', '".$_POST['contact_info4']."')";
}
$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1");
$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
//echo "SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1";
include('../inc/youtube_function.php');

$contents_location = "http://gdata.youtube.com/feeds/api/videos?q={".cleanYoutubeLink($last_video_under_project_row['video_link'])."}&alt=json";
$JSON = file_get_contents($contents_location);
$JSON_Data = json_decode($JSON);
$video_lenght = $JSON_Data->{'feed'}->{'entry'}[0]->{'media$group'}->{'yt$duration'}->{'seconds'};
$video_lenght_result = $video_lenght.':000';
?>
<!DOCTYPE html>
<html>
	<? include('../inc/head.php');?>
	<body class="">
		<? include('client_header.php'); ?>
		<main>
		<section class="center">
			<h1 class="">My Dashboard<?php echo $video_lenght_result; ?></h1>
			<form id="client_view_update" action="client_view.php" method="post">
				<div id="preproduction">
					<h2>Video Project Details</h2>
					<input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
					<input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
					<input value="1" name="add_comments" type="hidden">
					<ul>
						<li class="section contact">
							<span class= "contact_info">Contact Info</span>
							<input placeholder="Project Name" value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
							<input placeholder="Name" name="contact_info1" value="<?=$last_video_a_request_row['contact_info1'];?>">
							<input placeholder="Email" name="contact_info2" value="<?=$last_video_a_request_row['contact_info2'];?>">
							<input placeholder="Phone" name="contact_info3" value="<?=$last_video_a_request_row['contact_info3'];?>">
							<input placeholder="???" name="contact_info4" value="<?=$last_video_a_request_row['contact_info4'];?>">
						</li>
						<li class="section">
						<p>
							At Surge Media we like to make your video project experience as smooth as possible. but giving you a clear overview of where we are at with your project and giving you an easy way to supply feedback and track the changes. 
 </p>
<p>As part of your project you will receive 2 sets of changes before we render out the final version so it is important to make sure that you use the feedback system to your advantage. 
 </p>
 <p>
<strong>DRAFT 1 - (3 WEEKS) </strong> - Provide us with a complete list of ALL requested changes. Use the timestamp in the video to make sure that our editors know where the change needs to ba applied.
 </p>
<strong>DRAFT 2 - (3 WEEKS)</strong> This stage is mostly used to finetune the video before we present you with the final version.
 <p>
<strong>FINAL</strong> - The final version is there for you to download from the dashboard. Please note that if you still want to make additional changes you will be changed for the time involved.
						</p>
							<?php /* ?>
							<div>
								<span>Script</span>
								<ul>
									<li><span>I have emailed this</span><input type="checkbox" name="script1" value="1" <? if($last_video_a_request_row['script1']==1){ echo 'checked="checked"';}?> ></li>
									<li><span>I put it in our shared dropbox</span><input type="checkbox" name="script2" value="1" <? if($last_video_a_request_row['script2']==1){ echo 'checked="checked"';}?>></li>
								</ul>
							</div>
							<div>
								<span>Logos and Images</span>
								<ul>
									<li><span>I have emailed this</span><input type="checkbox" name="logoandimage_email" value="1" <? if($last_video_a_request_row['logoandimage_email']==1){ echo 'checked="checked"';}?> ></li>
									<li><span>I put it in our shared dropbox</span><input type="checkbox" name="logoandimage_dropbox" value="1" <? if($last_video_a_request_row['logoandimage_dropbox']==1){ echo 'checked="checked"';}?> ></li>
								</ul>
							</div>
							<?php */ ?>
						</li>
						<?php /* ?>
						<li class="section">
							
							<span>Voice Over Info</span>
							<div id="voice_choice">
								<select name="voice_id" id="">
									<option value="">Please select your audio talent</option>
									<?
									$list_vt = mysql_query("SELECT * FROM voice_talent WHERE avaliable = 1");
									$list_vt_num = mysql_num_rows($list_vt);
									for($i=0; $i<$list_vt_num; $i++){
									$list_vt_row = mysql_fetch_array($list_vt);
									$showselect = "";
									if($list_vt_row['id'] == $last_video_a_request_row['voice_id']){ $showselect = 'selected="selected"';}
									echo '<option value="'.$list_vt_row['id'].'" '.$showselect.'>'.$list_vt_row['voice_name'].'</option>';
									}
									?>
								</select>
								<span id="chosen">Adam</span>
							</div>
							<div id="voice_comment">
								<textarea name="voice_comment" id="" cols="30" rows="10"><?=$last_video_a_request_row['voice_comment'];?></textarea>
							</div>
							
						</li>
						<?php */ ?>
					</ul>
				</div>
				<!-- <input type="text" id="searchbox" class="search wow bounceIn"> -->
				<ul id="videos" >
					<li class="video_obj featured">
						<h1 class="title">
						<?=$projectname_row['project_name']?> - <span>Draft <?=$last_video_under_project_row["version_num"];?></span>
						</h1>
						<div class="video">
							<!-- VIMEO EMBED -->
							<iframe width="500" height="400" src="//www.youtube.com/embed/<?=cleanYoutubeLink($last_video_under_project_row['video_link']);?>?rel=0" frameborder="0" allowfullscreen></iframe>
							<!-- VIMEO EMBED -->
						</div>
						<div id='action_box' class="actions">
							<label class="title" for="">Director's Notes</label>
							<textarea disabled="true" name="" id="" cols="30" rows="10"><?=$last_video_under_project_row['notes']?></textarea>
							<ul>
								<li><a id="required_button" href="javascript:void(0)" class="btn red"><span>Changes Required</span> <i class="fa fa-refresh"></i></a></li>
								<li><a href="#" class="btn yellow"><span>Final Video</span><i class="fa fa-star"></i></a></li>
							</ul>
						</div>
						<div id="changes_required">
						<label class="title" for="">Your Notes</label>
						<ul id="comments-general" class="container">
							
							<li>
							<textarea name="" id="general-comment" class="ten columns" cols="30" rows="10">General Comments on the Video</textarea>
							</li>
							</ul>
							<ul id="time-comments">
								<script>N4ewTimelineComment();</script>
							</ul>
							<div class="submit-actions eight columns">
							<a href="javascript:void(0)" onClick="NewTimelineComment()" class="btn blue columns five"><span>Add Another Time</span> <i class="fa fa-clock-o"></i></a>
							<a class="btn green columns five" onClick="document.getElementById('client_view_update').submit();"><span>Submit All Comments</span> <i class="fa fa-send"></i></a>
							</div>
						</div>
					</li>
				</form>
				<li><h1>Previous Versions</h1></li>
				<ul id="videos">
					<?
					$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." ORDER BY enabling, version_num DESC");
					$video_num = mysql_num_rows($listvideos);
					for($i=0; $i<$video_num; $i++){
					$video_row = mysql_fetch_array($listvideos);
					$list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = ".$video_row ['id']);
					$list_video_client_request_num = mysql_num_rows($list_video_client_request);
					for($j=0; $j<$list_video_client_request_num; $j++){
					$list_video_client_request_row = mysql_fetch_array($list_video_client_request);
					$list_video_feedback[$i] .="
					<li><time>".$list_video_client_request_row['time_start']."&#47;".$list_video_client_request_row['time_end']."</time><small>".$list_video_client_request_row['feedback']."</small></li>
					";
					}
					$list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$video_row['id']." ORDER BY id LIMIT 0, 1");
					$list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
					echo '
					<li class="video_obj" onclick="expandCard($(this))">
						<span class="ver_number">'.$video_row['version_num'].'</span>
						<h3 class="title">'.$check_project_name_row['project_name'].'</h3>
						<div class="video draft">
							<iframe width="500" height="400" src="//www.youtube.com/embed/'.cleanYoutubeLink($video_row['video_link']).'?rel=0" frameborder="0" allowfullscreen></iframe>
						</div>
						<div class="feedback_wrapper">
							<h4>Notes</h4>
							<ul class="pasttimestamps">
								<li>Notes<small>'.$video_row['notes'].'</small></li>
								<li>Your feedback<small></small></li>
								'.$list_video_feedback[$i].'
							</ul>
							
						</div>
						<span class="audio_comment">
						'.$list_video_client_addition_request_row['audio_comment'].'
						</span>
					</li>
					';
					}
					?>
				</ul>
			</section>
			</main>
			<? include('../footer.php');?>
			<div id="overlay_wrapper" onclick="closeAllCards()"></div>
		</body>
	</html>