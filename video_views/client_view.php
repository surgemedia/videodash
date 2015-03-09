<? include("../dbconnection_3evchey.php"); //connecting Database
session_start();
if($_POST['client_id']=='' && $_POST['project_id']==''){
header("location: ../index.java");
}
$mail_message = "";
/*=======================================*/
/*       Change Content Details          */
/*=======================================*/							
if($_POST['company_name']!=""){
	$update_contact = mysql_query("UPDATE Client_Information SET company_name = '".$_POST['company_name']."', contact_person = '".$_POST['contact_person']."', mobile_number = '".$_POST['mobile_number']."', email = '".$_POST['email']."' WHERE id = ".$_POST['client_id']." AND active_option = 1");
}



$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
if($cca_num==0){
header("location: ../index.java");
}
$projectname = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']);
$projectname_row = mysql_fetch_array($projectname);
/*=======================================*/
/*       Make video to Final Version     */
/*=======================================*/							
if($_POST['make_video_version_to_final']=="yes"){
	$l_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
	$l_video_under_project_row = mysql_fetch_array($l_video_under_project);
	$version_number_editer = $l_video_under_project_row['version_num'] + 1;
	mysql_query("INSERT INTO video_under_project VALUES(NULL, ".$_POST['project_id'].", '".$l_video_under_project_row['video_link']."', 'Final', 'Final Version Confirmed', 1, ".$version_number_editer.", NULL);");
	$mail_message = 'Client just confirmed the video as final version. Company is:'.$cca_row['company_name']."<br/>
	their Video Project is: ".$projectname_row['project_name'];
}


$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$last_video_under_project_row = mysql_fetch_array($last_video_under_project);
$forloopcount = 0;


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
for($i=0; $i<$forloopcount; $i++){
	$update_video_client_request = mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$feedback_strat[$i]."', '".$feedback_end[$i]."', '".$feedback[$i]."', '".$feedback_type[$i]."')");
	$mail_commect_typs = 'Change To Video';
	if($feedback_type[$i]==2){
		$mail_commect_typs = 'Change To Audio';
	}else if($feedback_type[$i]==3){
		$mail_commect_typs = 'Other';
	}
	$list_comment .= '<tr><td>'.$feedback_strat[$i].'</td><td>'.$feedback_end[$i].'</td><td>'.$mail_commect_typs.'</td><td>'.$feedback[$i].'</td></tr>';
	//echo "INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')";
}

if($_POST['old_loop_time']>0){
	for($j=0; $j<$_POST['old_loop_time']; $j++){
		if($_POST["addfeedback".$j]!=""){
			$mail_commect_typs = 'Change To Video';
			if($_POST["addcommentoption".$j]==2){
				$mail_commect_typs = 'Change To Audio';
			}else if($_POST["addcommentoption".$j]==3){
				$mail_commect_typs = 'Other';
			}
			mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST["addtimestart".$j]."', '".$_POST["addtimeend".$j]."', '".$_POST["addfeedback".$j]."', '".$_POST["addcommentoption".$j]."')");
			$list_comment .= '<tr><td>'.$_POST["addtimestart".$j].'</td><td>'.$_POST["addtimeend".$j].'</td><td>'.$mail_commect_typs.'</td><td>'.$_POST["addfeedback".$j].'</td></tr>';
		}
	}
}

if($_POST['voice_comment']!=""){
	$update_video_client_addition_request = mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '".$last_video_under_project_row["id"]."', '".$_POST['script1']."', '".$_POST['script2']."', '".$_POST['logoandimage_email']."', '".$_POST['logoandimage_dropbox']."', '".$_POST['voice_id']."', '".$_POST['voice_comment']."', '".$_POST['audio_comment']."', '".$_POST['contact_info1']."', '".$_POST['contact_info2']."', '".$_POST['contact_info3']."', '".$_POST['contact_info4']."')");
	$general_comment = $_POST['voice_comment'];
}

if($forloopcount>0){
	$mail_message = 'We get the new feedback message for Client:'.$cca_row['company_name']."<br/>
	their Video Project is: ".$projectname_row['project_name']."
	Comment: ".$general_comment."
	<table>
		<tr><th>Start</th><th>End</th><th>Type</th><th>comments</th><tr>
		".$list_comment."
	</table>
	";
	
}


$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1");
$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
include('../inc/youtube_function.php');

$contents_location = "http://gdata.youtube.com/feeds/api/videos?q={".cleanYoutubeLink($last_video_under_project_row['video_link'])."}&alt=json";
$JSON = file_get_contents($contents_location);
$JSON_Data = json_decode($JSON);
$video_lenght = $JSON_Data->{'feed'}->{'entry'}[0]->{'media$group'}->{'yt$duration'}->{'seconds'};
$video_lenght_result = $video_lenght.':000';
$end_time = gmdate("i:s", (int)$video_lenght_result);

/*=============================================================*/
/*      Send Email to advise any update of video Project       */
/*=============================================================*/

if($mail_message!=""){
			$name = "Surge Media - Video Dash";
			$frommail = "cs@videodash.surgehost.com.au";
			$mailto = 'webproduction@surgemedia.com.au'; // $cca_row['email'];
			$mailsubject = 'New Update of Client request in Video Dash';
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			$headers .="From: ". $name . " <" . $frommail . ">\r\n";

			$mail_data = file_get_contents('../email_template/feedback.html');
			$mail_data = str_replace("[mail_title]",  $mailsubject, $mail_data);
			$mail_data = str_replace("[mail_content]",  $mail_message, $mail_data);
			$the_data_is = date("d M Y");
			$mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);

			
			mail($mailto, $mailsubject, $mail_data, $headers);										
}

?>
<!DOCTYPE html>
<html>
	<? include('../inc/head.php');?>
	<body class="">
		<? include('client_header.php'); ?>
		<main>
		<section class="container">
			<h1 class="">My Dashboard</h1>
				<div id="preproduction" class="container">
				<?php //Add container css class to make data display correctly?>
					<h2>Video Project Details</h2>
					<ul>
						<li class="section contact five columns omega">
						<?php //Make contact data field in left side?>
                            <input value="<?php echo $end_time;?>" id="video_end_time" type="hidden">
							<span class="small_title">Project name</span>
							<input value="<?php echo $cca_row['company_name'];?> - <?php echo $projectname_row['project_name']?>" disabled>
<?
							/*=======================================*/
							/*       Change Content Details          */
							/*=======================================*/							
?>
							<span class="small_title">Contact Info</span>
                            <form action="#" method="post">
                            <input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
                            <input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
							<input placeholder="Name" name="company_name" value="<?php echo $cca_row['company_name'];?>"/>
							<input placeholder="contact name" name="contact_person" value="<?php echo $cca_row['contact_person'];?>"/>
							<input placeholder="Phone" name="mobile_number" value="<?php echo $cca_row['mobile_number'];?>"/>
							<input placeholder="Email" name="email" value="<?php echo $cca_row['email'];?>"/>
                            <input class="btn green"  type="submit" value="Change Contact Details"/>
                            </form>
						</li>
						<li class="section ten columns omega alpha">
						<?php //Make introduction field in right side?>
                        <p><strong>How to review your project</strong></p>
						<p>At Surge Media we like to make your video project experience as smooth as possible. but giving you a clear overview of where we are at with your project and giving you an easy way to supply feedback and track the changes. 
                        </p>
                        <p>As part of your project you will receive 2 sets of changes before we render out the final version so it is important to make sure that you use the feedback system to your advantage. 
                        </p>
                        <p><strong>DRAFT 1 - (3 WEEKS) </strong> - Provide us with a complete list of ALL requested changes. Use the timestamp in the video to make sure that our editors know where the change needs to ba applied.
                        </p>
                        <p><strong>DRAFT 2 - (3 WEEKS)</strong> This stage is mostly used to finetune the video before we present you with the final version.
                        </p>
                        <p><strong>FINAL</strong> - The final version is there for you to download from the dashboard. Please note that if you still want to make additional changes you will be charged for the time involved.
                        </p>
						</li>
					</ul>
				</div>
				<!-- <input type="text" id="searchbox" class="search wow bounceIn"> -->
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
<?php
/*=======================================*/
/*  From to Make video to Final Version  */
/*=======================================*/							
?>
<form id="final_version_confrim" action="#" method="post">
        <input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
        <input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
        <input value="yes" name="make_video_version_to_final" type="hidden">
</form>
<?php if($last_video_under_project_row['version']!="Final"){
		$downloadfilelink = '<li><a href="javascript:void(0)" class="btn yellow" onClick="document.getElementById(\'final_version_confrim\').submit();"><span>APPROVE AS FINAL</span><i class="fa fa-star"></i></a></li>';
		$downloadfile_message = '';
		$list_day_counter = check_deadline($_POST['project_id'], $last_video_under_project_row['version'], 'deadline');
		if($list_day_counter>0){
			$overdeadline_message = '<h2>You have '.check_deadline($_POST['project_id'], $last_video_under_project_row['version'], 'deadline').'  days left to submit your feedback</h2>';
		}else{
			$overdeadline_message = '<h2>Sorry, We have not got any change request in last 3 weeks, If you need any change of your video, we will charge for time involved.</h2>';
		}
               
	  }else{
	  	$overdeadline_message = '';
	  	if($projectname_row['download_file']!=""){
	  		$downloadfilelink = '<li><a href="javascript:void(0)" class="btn yellow" ><span>Download Video</span><i class="fa fa-star"></i></a></li>';
	  	}else{
	  		$downloadfilelink = '<li><a class="message yellow" ><span>Video Delivery Now, Will Message you when completed.</span><i class="fa fa-star"></i></a></li>';
	  	}
	  	if($projectname_row['download_file']!=""){
	  		$downloadfile_message = '<label class="message" for="">Congratulations your video is now ready for downlaod now.</label>';
	  	}else{
	  		$downloadfile_message = '<label class="message blue" for="">We are editing your video now.</label>';
	  	}
	  }
?>            

			     
			<form id="charge_update" action="request_confirm.java" method="post" class="sixteen column">
					<input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
					<input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
					<input value="1" name="charge_change" type="hidden">
					<ul>
					<li class="video_obj featured">
						<h2>
						<?php echo $cca_row['company_name'];?> - <?php echo $projectname_row['project_name']?> - <span><?php echo $last_video_under_project_row['version']; ?>  (<? echo check_deadline($_POST['project_id'], $last_video_under_project_row['version']); ?>)</span>
						</h2>
						<?php echo $overdeadline_message;?>
						<div class="video sixteen columns omega alpha">
							<!-- VIMEO EMBED -->
							<iframe src="//www.youtube.com/embed/<?=cleanYoutubeLink($last_video_under_project_row['video_link']);?>?rel=0" frameborder="0" allowfullscreen></iframe>
							<!-- VIMEO EMBED -->
						</div>
						<div id='action_box' class="actions sixteen columns">
                         <?php echo $downloadfile_message; ?>
							<textarea disabled="true" name="" id="project_message" class="sixteen columns" cols="30" rows="5">Versions included:
1 x MP4  - 1280 x 720 - h264 - suitable for youtube
1 x MP4  - 640 x480 h264 idea for uploading to your website.
                            
Other Formats
Please contact our video production team if you request a different formats DVD's etc 
(video@surgemedia.com.au)

Extended storate
Your Data will be stored for 6 months. Please contact if your request any copy.
                            </textarea>
							<ul>
								<li><a id="required_button" href="javascript:void(0)" class="btn red"><span>Changes Required</span> <i class="fa fa-refresh"></i></a></li>
                                <?php echo $downloadfilelink; ?>
							</ul>
						</div>
						<div id="changes_required">
						<label class="title label_stop_float" for="">Your Notes</label>
						<ul id="comments-general" class="container">
							
							<li>
							<textarea name="voice_comment" id="general-comment" class="eleven columns" cols="30" rows="10" placeholder="General Comments on the Video"><?php echo $last_video_a_request_row['voice_comment']; ?></textarea>
							</li>
							</ul>
							<ul id="time-comments">
								
							</ul>
							<div class="submit-actions">
							<a href="javascript:void(0)" onClick="NewTimelineComment()" class="btn blue columns five alpha"><span>Add More Timeline Comments</span> <i class="fa fa-clock-o"></i></a>
							<a class="btn green columns five alpha" onClick="document.getElementById('charge_update').submit();"><span>Submit All Comments</span> <i class="fa fa-send"></i></a>
							</div>
						</div>
					</li>
					</ul>
                </form>

          
				
				<ul id="videos">
				<li><h1>Previous Versions</h1></li>
					<?
					$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." ORDER BY enabling, version_num DESC");
					$video_num = mysql_num_rows($listvideos);
					for($i=0; $i<$video_num; $i++){
					$video_row = mysql_fetch_array($listvideos);
					$list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = ".$video_row ['id']);
					$list_video_client_request_num = mysql_num_rows($list_video_client_request);
					for($j=0; $j<$list_video_client_request_num; $j++){
					$list_video_client_request_row = mysql_fetch_array($list_video_client_request);
					$show_feedback_type = $list_video_client_request_row['feedback_type'];
					if($list_video_client_request_row['feedback_type']==1){
						$show_feedback_type = 'Changes To Video';
					}else if($list_video_client_request_row['feedback_type']==2){
						$show_feedback_type = 'Changes To Audio';
					}else if($list_video_client_request_row['feedback_type']==3){
						$show_feedback_type = 'Other';
					}
					$list_video_feedback[$i] .="
					<li><time>".$list_video_client_request_row['time_start']."&#47;".$list_video_client_request_row['time_end']."</time>
					<small>[".$show_feedback_type."]".$list_video_client_request_row['feedback']."</small></li>
					";//list all request information display in page
					}
					$list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$video_row['id']." ORDER BY id DESC LIMIT 0, 1");
					$list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
					echo '
					<li class="video_obj five columns" onclick="expandCard($(this))">
						<span class="ver_number">'.$video_row['version_num'].'</span>
						<h3 class="title">'.$check_project_name_row['project_name'].'</h3>
						<div class="video draft">
							<iframe width="500" height="400" src="//www.youtube.com/embed/'.cleanYoutubeLink($video_row['video_link']).'?rel=0" frameborder="0" allowfullscreen></iframe>
						</div>
						<div class="feedback_wrapper">
							<h4>Notes</h4>
							<ul class="pasttimestamps">
								<li>Notes<small>'.$video_row['notes'].'</small></li>
								<li>Your feedback<small>'.$list_video_client_addition_request_row['voice_comment'].'</small></li>
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