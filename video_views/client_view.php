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
$mail_message = '<b>A client has confirmed the final version of their video</b>
Client: '.$cca_row['company_name']."<br/>
Video Project: ".$projectname_row['project_name'];
}
$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$last_video_under_project_row = mysql_fetch_array($last_video_under_project);
$forloopcount = 0;
$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1");
$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
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
$comment_remind_mail = 0;
for($i=0; $i<$forloopcount; $i++){
if($last_video_a_request_row['stop_resubmit']!=1){
$update_video_client_request = mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$feedback_strat[$i]."', '".$feedback_end[$i]."', '".$feedback[$i]."', '".$feedback_type[$i]."')");
//echo '1 done';
}
$mail_commect_typs = 'Change To Video';
if($feedback_type[$i]==2){
$mail_commect_typs = 'Change To Audio';
}else if($feedback_type[$i]==3){
$mail_commect_typs = 'Other';
}
$list_comment .= '<tr><td>'.$feedback_strat[$i].'</td><td>'.$feedback_end[$i].'</td><td>'.$mail_commect_typs.'</td><td>'.$feedback[$i].'</td></tr>';
//echo "INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')";
$comment_remind_mail = 1; //if have any comment, set it 1.
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
if($last_video_a_request_row['stop_resubmit']!=1){
mysql_query("INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST["addtimestart".$j]."', '".$_POST["addtimeend".$j]."', '".$_POST["addfeedback".$j]."', '".$_POST["addcommentoption".$j]."')");
//echo '2 done';
}
$list_comment .= '<tr><td>'.$_POST["addtimestart".$j].'</td><td>'.$_POST["addtimeend".$j].'</td><td>'.$mail_commect_typs.'</td><td>'.$_POST["addfeedback".$j].'</td></tr>';
}
}
$comment_remind_mail = 1; //if have any comment, set it 1.
}
if($_POST['voice_comment']!=""){
$update_video_client_addition_request = mysql_query("UPDATE video_client_addition_request SET voice_comment = '".$_POST['voice_comment']."' WHERE id = ".$last_video_a_request_row['id']);
$general_comment = $_POST['voice_comment'];
$comment_remind_mail = 1; //if have any comment, set it 1.
}
if($forloopcount>0){
$mail_message = 'A client has submitted their final set of changes.<br/>
Client: '.$cca_row['company_name']."<br/>
Video Project: ".$projectname_row['project_name']."
Comment: ".$general_comment."
<table>
	<tr><th>Start</th><th>End</th><th>Type</th><th>comments</th><tr>
	".$list_comment."
</table>
";
}
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
$update_mail_subject = ""; //unset the mail subject in begining.
if($comment_remind_mail == 1){// Update mailout to 1 and will stop to send mail while send one mailout in version 1
if($last_video_a_request_row['comment_time']==0 && $last_video_under_project_row['version']=='Draft'){
//IF Client first time comment to video
$Client_mail_message ='
Dear '.$cca_row['contact_person'].'<br/><br/>
Thank you for submitting your first set of changes. <br/>
Just a friendly reminder that you have one set of changes remaining. <br/>
We will contact you if we have any questions.<br/>
Thank you<br/>
';
$update_mail_subject = "Your First Set of Changes";
mysql_query("UPDATE video_client_addition_request SET comment_time = 1 WHERE id = ".$last_video_a_request_row['id']);
//Update database to stop sendmail duplicate
}
if($last_video_under_project_row['version_num']==2 && $last_video_under_project_row['version']=='Draft'){
//IF version number already upload new video to client to review
if($last_video_a_request_row['comment_time2']==0){
$Client_mail_message ='
Dear '.$cca_row['contact_person'].'<br/><br/>
Thank you for submitting your second set of changes.  <br/>
Just a friendly reminder that these are your final changes.  <br/>
If you require more, please contact us as charges may apply.  <br/>
We will contact you if we have any questions.  <br/>
Thank you.  <br/>
';
mysql_query("UPDATE video_client_addition_request SET comment_time2 = 1 WHERE id = ".$last_video_a_request_row['id']);
//Update database to stop sendmail duplicate
$update_mail_subject = "Your Second Set of Changes";
}
}
}
$the_data_is = date("d M Y");
$name = "Surge Media - Video Dash";
$frommail = "cs@videodash.surgehost.com.au";
$mailto = 'video@surgemedia.com.au, webproduction@surgemedia.com.au'; // $cca_row['email'];
$mailtoclient =  $cca_row['email'];
$mailsubject = 'CLIENT #'.$last_video_under_project_row['version_num'].' CHANGES – TO SURGE';
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .="From: ". $name . " <" . $frommail . ">\r\n";
if($mail_message!=""){ //Check whether have any email message need to send out
$mail_data = file_get_contents('../email_template/feedback.html');
$mail_data = str_replace("[mail_title]",  $mailsubject, $mail_data);
$mail_data = str_replace("[mail_content]",  $mail_message, $mail_data);
$mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);
//Mail content to Surge Media
if($_POST['make_video_version_to_final']=="yes"){
$mailsubject = 'Client confirmed the final version.';
}//If client confirm video as Final Version, send mail to Ben and Video Team about it.
mail($mailto, $mailsubject, $mail_data, $headers);
}
if($update_mail_subject!=""){
$client_mail_data = file_get_contents('../email_template/feedback.html');
$client_mail_data = str_replace("[mail_title]",  $update_mail_subject, $client_mail_data);
$client_mail_data = str_replace("[mail_content]",  $Client_mail_message, $client_mail_data);
$client_mail_data = str_replace("[mail_datandtime]",  $the_data_is, $client_mail_data);
//Mail Content to Client
mail($mailtoclient, $update_mail_subject, $client_mail_data, $headers);
}//Stop mailout to keep system work fine if without any remind mail to client.
/*===========================================
Verion Number to show changed Day counter
============================================*/
if($last_video_under_project_row['version']!="Final"){
$downloadfilelink = '<li><a href="javascript:void(0)" class="btn yellow" onClick="document.getElementById(\'final_version_confrim\').submit();"><span class="omega alpha">Approve as final</span><i class="fa fa-star"></i></a></li>';
$downloadfilelink2 = '';
$downloadfile_message = '';
$list_day_counter = check_deadline($_POST['project_id'], $last_video_under_project_row['version'], 'deadline');
if($list_day_counter>0){
$overdeadline_message = 'You have '.check_deadline($_POST['project_id'], $last_video_under_project_row['version'], 'deadline').'  days left to submit your feedback';
}else{
$overdeadline_message = 'Sorry, We have not recieved any changes from you in last 3 weeks, If you need any changes of your video, we will charge for time involved.';
}
}else{
$overdeadline_message = '';
if($projectname_row['download_file']!=""){
//$downloadfilelink2 = '<li><a href="download_page.php?project='.$projectname_row['id'].'" class="btn yellow fifteen columns big_btn" ><span>Download Video</span><i class="fa fa-star"></i></a></li>';
/*For New option submit page*/
$downloadfilelink2 = '
<a href="'.$projectname_row['download_file'].'" class="btn green wow shake omega alpha" ><span>Download Your Videos for '.$cca_row['company_name'].' - '.$projectname_row['project_name'].'</span><i class="fa fa-download"></i></a>';
$downloadfilelink = '';
}else{
$downloadfilelink = '<label class="message " ><span>Please be patiate we will notifiy you when you can download your new video </span> <i class="fa fa-thumbs-up"></i> </label>';
$downloadfilelink2 = '';
}
/* REMOVED -
$file_details_message = '
<h4>VIDEO DASH – SUPPLYING OPTIONS</h4>
<h5>FINAL VIDEO DOWNLOAD</h5>
<p>There are two versions of your final video. <br/>
	1 x MP4 1280x720 pixels – This is ideal for Youtube and video sharing sites. <br/>
	1 x MP4 640x360 pixel – This is ideal for uploading to the web<br/>
	<br/>
	If you require different formats, please contact our video production team – <br/>
	<a href="video@surgemedia.com.au">video@surgemedia.com.au</a>
</p>
<p><b>Below are extra options for supplying your project file.</b></p>
<h5>USB</h5>
<p>Surge Media has a few options regarding USB storage and branding.
	<ul>
		<li>USB Logo branded – A USB branded with your logo printed on both sides. </li>
		<li>USB Plain – A USB with no branding.</li>
	</ul>
</p>
<h5>DVD AND DATA DISC</h5>
<p>Surge Media has a few options regarding DVDs and Data discs. Please be aware that a menu is not included on the DVD.
	<ul>
		<li>DVD Printed Disc – A DVD disc with your logo and project name printed onto the disc. </li>
		<li>DVD Plain – A DVD disc with no logo.</li>
		<li>DVD COVER – A cover designed and printed for your DVD case. You can choose between two designs. </li>
		<li>Data Disc Printed – A Data disc with your logo and project name printed onto the disc.</li>
		<li>Data Disc Plain - A Data disc with no logo.</li>
	</ul>
</p>
<h5>DATA AND PROJECT STORAGE</h5>
<p>Surge Media has a few options regarding your RAW footage. If your project is a motion graphics, this may not apply.
	<ul>
		<li>Surge Media allows you to collect your raw footage on a supplied hard drive  - $50.00</li>
		<li>Surge Media will supply a hard drive with your raw footage for your collection - $20.00</li>
		<li>Surge Media will store your raw footage and final project for a period of 5 years - $60.00</li>
		<li>Surge Media will keep an uncompressed 1920 x1080 final video file indefinitely and it will be on hand for your requirement. Please be aware that after 3 months your project will be archived and a fee will be charged to retrieve your file. </li>
	</ul>
</p>
<h5>MARKETING </h5>
<p>YOUTUBE is the second most used search engine in the world. A video on Youtube is capable of reaching a global audience, increasing awareness of your company.
	<ul>
		<li>Surge Media will upload your project to your Youtube channel - $19.95</li>
		<li>Surge Media will style your Youtube channel. This includes your display picture, banner, channel name and video upload - $102.00</li>
		<li>Surge Media will advertise your video on Youtube. This option is tailored to your project so by choosing this option, a meeting will be arranged with Surge Media’s marketing coordinator. </li>
	</ul>
</p>
<p>REMARKETING can help you reach people who have previously visited your website. Your ads will appear to a visitor of your website as they browse other sites.
	<ul>
		<li>This option is tailored to your project. To find out how you can use Remarketing, a meeting will be arranged with a Surge Media web developer.</li>
	</ul>
</p>
<p>TELEVISION is a great way to advertise your project to a national audience while being able to organise your advertisements according to your target audience.
	<ul>
		<li>Surge Media will organize for your project to be advertised on Channel 7, Channel 10 or 31 Digital. Since this option includes various choices for timeslots, pricing, length, a meeting will be arranged with Surge Media’s marketing coordinator. </li>
	</ul>
</p>
';
*/
if($projectname_row['download_file']!=""){
$downloadfile_message = 1; //'<br/>Congratulations your video is now ready for downlaod now.'.$file_details_message;
}else{
$downloadfile_message = '<br/>We are editing your video now.'.$file_details_message;
}
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
						
						<p>At Surge Media we like to make your video project experience as smooth as possible by giving you a clear overview of where we are at with your project and giving you an easy way to supply feedback and track changes.
						</p>
						<p>As part of your project you will receive 2 sets of changes before we render out the final version so it is important to make sure that you use the feedback system to your advantage.
						</p>
						<p><strong>DRAFT 1 - (3 WEEKS) </strong> Provide us with a complete list of ALL requested changes. Use the video timestamp to make sure that our editors know where the changes need to be applied.
						</p>
						<p><strong>DRAFT 2 - (3 WEEKS)</strong> This stage is mostly used to finetune the video before we present you with the final version.
						</p>
						<p><strong>FINAL</strong> The final version will be there for you to download from the dashboard. Please note that if you still want to make additional changes, charges may apply.
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
					$check_deadline = mysql_query("SELECT upload_time FROM video_under_project WHERE video_project_id = ".$function_v_project_id." AND version LIKE '".$version."' AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
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
			<?php if(!$downloadfile_message){ ?>
			<form id="charge_update" action="request_confirm.java" method="post" class="sixteen column">
				<?php }else{ ?>
				<form action="mail_upsell.php" id="addition_request_form" method="post" class="sixteen column">
					<?php } ?>
					<input value="<?=$_POST['client_id'];?>" name="client_id" type="hidden">
					<input value="<?=$_POST['project_id'];?>" name="project_id" type="hidden">
					<input value="1" name="charge_change" type="hidden">
					<ul>
						<li class="video_obj featured">
							
							<h1 class="title"><?php echo $cca_row['company_name'];?> - <?php echo $projectname_row['project_name']?> - <span><?php echo $last_video_under_project_row['version']; ?>  (<? echo check_deadline($_POST['project_id'], $last_video_under_project_row['version']); ?>)</span>
							</h1>
							
							<?php if($overdeadline_message) : ?>
							<label class="message red" for="">
								<?php echo $overdeadline_message; ?>
							</label>
							<?php endif; ?>
							<?php if($downloadfile_message) : ?>
							<div id="download_message" class="light_blue_box">
								
								<h2>Your Final Videos Are Ready To Download</h2>
								<?php if($downloadfilelink2) { ?>
								<?php echo $downloadfilelink2; ?>
								<?php } else { ?>
								<?php echo $downloadfilelink; ?>
								<?php } ?>
								<p>There are two versions of your final video. </p>
								<p>1 x MP4 1280x720 pixels – This is ideal for Youtube and video sharing sites.</p>
								<p>1 x MP4 640x360 pixel – This is ideal for uploading to the web</p>
								
								<a class="btn blue" href="mailto:video@surgemedia.com.au"><span>Need a new different formats? Please Contact Our Video Production Team </span><i class="fa fa-envelope"></i></a>
								<hr>
								<h3>Supplying Options</h3>
								<p><b>Below are extra options for supplying your project file.</b></p>
								<h2>USB</h2>
								<p>Surge Media has a few options regarding USB storage and branding.</p>
								<ul>
									<li>
										<input id="option_brandusb" name="usb_option" type="radio" value="1">USB Logo branded &#45; A USB branded with your logo printed on both sides.
									</li>
									<li>
										<input id="option_plainusb" name="usb_option" type="radio" value="2">USB Plain &#45; A USB with no branding.
									</li>
								</ul>
								<div id="brandusb" class="disable_input">
									<select name="usb_type">
										<option value="">Please Select your USB products for request:</option>
										<option value="Alloy USB Card">Alloy USB Card</option>
										<option value="Focus USB Flash Drive">Focus USB Flash Drive</option>
										<option value="Carbon USB Flash Drive">Carbon USB Flash Drive</option>
										<option value="Kinetic USB Flash Drive">Kinetic USB Flash Drive</option>
										<option value="Focus USB Flash Drive">Focus USB Flash Drive</option>
										<option value="Rotator USB Flash Drive">Rotator USB Flash Drive</option>
										<option value="Executive USB Flash Drive">Executive USB Flash Drive</option>
										<option value="Classic USB Flash Drive">Classic USB Flash Drive</option>
										<option value="Trix USB Flash Drive">Trix USB Flash Drive</option>
										<option value="Ellipse USB Flash Drive">Ellipse USB Flash Drive</option>
										<option value="Halo USB Flash Drive">Halo USB Flash Drive</option>
										<option value="Pod USB Flash Drive">Pod USB Flash Drive</option>
										<option value="Flip USB Flash Drive">Flip USB Flash Drive</option>
										<option value="Image USB Flash Drive">Image USB Flash Drive</option>
									</select>
									<div class="option">
									Order Value:
									<select name="USB_value">
										<option value="">Please select order PCS of USB</option>
										<option value="25">25 PCS</option>
										<option value="50">50 PCS</option>
										<option value="100">100 PCS</option>
										<option value="250">250 PCS</option>
									</select>
									</div>
								</div>
								<div id="plainusb" class="disable_input">
									<select name="usb_color">
										<option value="">Please Select your USB color:</option>
										<option value="White">White</option>
										<option value="Black">Black</option>
										<option value="Red">Red</option>
										<option value="Green">Green</option>
										<option value="Blue">Blue</option>
										<option value="Yellow">Yellow</option>
									</select>
									<div class="option">
									Order Value:
									<select name="USB_value_color">
										<option value="">Please select order PCS of USB</option>
										<option value="25">25 PCS</option>
										<option value="50">50 PCS</option>
										<option value="100">100 PCS</option>
										<option value="250">250 PCS</option>
									</select>
									</div>
								</div>
								<a class="btn red" target="_blank" href="http://videodash.surgehost.com.au/img/SURGE-USB-CATALOGUE.pdf"><span>Download our Price Guide</span> <i class="fa fa-file-pdf-o"></i></a>
								<a class="btn blue" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
								<hr>
								<h2>DVD and Data Disc</h2>
								<p>Surge Media has a few options regarding DVDs and Data discs. Please be aware that a menu is not included on the DVD. </p>
								<ul>
									<li>
										<input name="dvd_option_1" type="checkbox" value="DVD Printed Disc">
										DVD Printed Disc  A DVD disc with your logo and project name printed onto the disc.<br/>
										<div class="option"> Order Value:
											<select name="dvd_value1">
												<option value="">Please select order PCS of DVD</option>
												<option value="10">10 PCS</option>
												<option value="20">20 PCS</option>
												<option value="50">50 PCS</option>
												<option value="100">100 PCS</option>
											</select>
										</div>
									</li>
									<li>
										<input name="dvd_option_2" type="checkbox" value="DVD Plain">
										DVD Plain &#45; A DVD disc with no logo.<br/>
										<div class="option">Order Value:
											<select name="dvd_value2">
												<option value="">Please select order PCS of DVD</option>
												<option value="10">10 PCS</option>
												<option value="20">20 PCS</option>
												<option value="50">50 PCS</option>
												<option value="100">100 PCS</option>
											</select>
										</div>
									</li>
									
									<li>
										<input name="dvd_option_3" type="checkbox" value="Data Disc Printed">
										Data Disc Printed &#45; A Data disc with your logo and project name printed onto the disc.<br/>
										<div class="option">Order Value:
											<select name="dvd_value3">
												<option value="">Please select order PCS of DVD</option>
												<option value="10">10 PCS</option>
												<option value="20">20 PCS</option>
												<option value="50">50 PCS</option>
												<option value="100">100 PCS</option>
											</select>
										</div>
									</li>
									<li>
										<input name="dvd_option_4" type="checkbox" value="Data Disc Plain">
										Data Disc Plain &#45;A Data disc with no logo.<br/>
										<div class="option">Order Value:
											<select name="dvd_value4">
												<option value="">Please select order PCS of DVD</option>
												<option value="10">10 PCS</option>
												<option value="20">20 PCS</option>
												<option value="50">50 PCS</option>
												<option value="100">100 PCS</option>
											</select>
										</div>
									</li>
									<li>
										<input name="dvd_option_5" type="checkbox" value="DVD COVER">
										DVD Cover &#45; A cover designed and printed for your DVD case. You can choose between two designs.<br/>
										<div class="option">Order Value:
											<select name="dvd_value5">
												<option value="">Please select order PCS of DVD</option>
												<option value="10">10 PCS</option>
												<option value="20">20 PCS</option>
												<option value="50">50 PCS</option>
												<option value="100">100 PCS</option>
											</select>
										</div>
									</li>
								</ul>
								
								<a class="btn blue newline" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
								<hr>
								<h2>Data And Project Storage</h2>
								<p>Surge Media has a few options regarding your RAW footage. If your project is a motion graphics, this may not apply.</p>
								<ul>
									<li><input name="dps1" value="1" type="checkbox"/>Surge Media allows you to collect your raw footage on a supplied hard drive  - <span class="price">$50.00</span></li>
									<li><input name="dps2" value="1" type="checkbox"/>Surge Media will supply a hard drive with your raw footage for your collection - <span class="price">$20.00</span></li>
									<li><input name="dps3" value="1" type="checkbox"/>Surge Media will store your raw footage and final project for a period of 5 years - <span class="price">$60.00</span></li>
									<li><input name="dps4" value="1" type="checkbox"/>Surge Media will keep an uncompressed 1920 x1080 final video file indefinitely and it will be on hand for your requirement. Please be aware that after 3 months your project will be archived and a fee will be charged to retrieve your file. </li>
								</ul>
								<a class="btn blue newline" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
								<hr>
								<h2>Marketing</h2>
								<p><u>Youtube</u></p>
								<p>Youtube is the second most used search engine in the world. A video on Youtube is capable of reaching a global audience, increasing awareness of your company.
								</p>
								<ul>
									<li><input name="market1" value="1" type="checkbox"/>Surge Media will upload your project to your Youtube channel - <span class="price">$19.95</span></li>
									<li><input name="market2" value="1" type="checkbox"/>Surge Media will style your Youtube channel. This includes your display picture, banner, channel name and video upload - <span class="price">$102.00</span></li>
									<li><input name="market3" value="1" type="checkbox"/>Surge Media will advertise your video on Youtube. This option is tailored to your project so by choosing this option, a meeting will be arranged with Surge Media’s marketing coordinator. </li>
								</ul>
								<a class="btn blue newline" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
								<hr>
								<p><u>Remarketing</u></p>
								<p>Remarketing can help you reach people who have previously visited your website. Your ads will appear to a visitor of your website as they browse other sites.
								</p><p>
								<input name="Remarketing" value="1" type="checkbox"/>This option is tailored to your project. To find out how you can use Remarketing, a meeting will be arranged with a Surge Media web developer.
								<a class="btn blue newline" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
							</p>
							<hr>
							<p><u>Television</u></p>
							<p>Television is a great way to advertise your project to a national audience while being able to organise your advertisements according to your target audience.
								
								</p><p><input name="Television" value="1" type="checkbox"/>Surge Media will organize for your project to be advertised on Channel 7, Channel 10 or 31 Digital. Since this option includes various choices for timeslots, pricing, length, a meeting will be arranged with Surge Media’s marketing coordinator.
								
							</p>

							<a class="btn blue newline" href="#" onClick="document.getElementById('addition_request_form').submit();"><span>Sounds awesome! Sign me up</span> <i class="fa fa-envelope"></i></a>
							
						</div>
						<?php endif;
						if($last_video_under_project_row['version']!="Final"){
						?>
						<div class="video sixteen columns omega alpha">
							<!-- VIMEO EMBED -->
							<iframe src="//www.youtube.com/embed/<?=cleanYoutubeLink($last_video_under_project_row['video_link']);?>?rel=0" frameborder="0" allowfullscreen></iframe>
							<!-- VIMEO EMBED -->
						</div>
						<?php } ?>
						<div id='action_box' class="actions sixteen columns">
							<ul>
								<?php echo $downloadfilelink; ?>
							</ul>
						</div>
						<?php
												$stop_comment = "";
												//echo $last_video_under_project_row['version_num']. $last_video_a_request_row['comment_time'];
												if($last_video_under_project_row['version']!='Final'){
														$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$last_video_under_project_row['id']." ORDER BY id DESC LIMIT 0, 1");
														$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
														if($last_video_under_project_row['version_num']==1 && $last_video_a_request_row['comment_time']!=1){
															$stop_comment_disable = 1;
														}
														if($last_video_under_project_row['version_num']==2 && $last_video_a_request_row['comment_time2']!=1){
															$stop_comment_disable = 1;
																		}
													}
													if($stop_comment_disable==1){
						?>
						<div id="changes_required">
							<label class="title label_stop_float" for="">Your Feedback</label>
							<ul id="comments-general" class="container">
								
								<li>
									<textarea name="voice_comment" id="general-comment" class="fifteen columns" cols="30" rows="10" placeholder="General Comments on the Video"><?php echo $last_video_a_request_row['voice_comment']; ?></textarea>
								</li>
							</ul>
							<ul id="time-comments">
								<script>NewTimelineComment();</script>
							</ul>
							<div class="submit-actions">
								<a href="javascript:void(0)" onClick="NewTimelineComment()" class="btn blue columns five alpha"><span>add more timeline comments</span> <i class="fa fa-clock-o"></i></a>
								<a class="btn green columns five alpha" onClick="document.getElementById('charge_update').submit();"><span>submit all comments</span> <i class="fa fa-send"></i></a>
							</div>
						</div>
						<?php }?>
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
				$show_final_color = $show_final_msg = "";
				if($video_row['version']=="Final"){
				//$show_final_color = 'style="background: none repeat scroll 0 0 rgba(200, 251, 141, 1);"';
				$show_final_msg = "Final Video <i class='fa-star fa'></i>";
				}else{
				$show_final_msg = "Draft copy <i class='fa-pencil-square-o fa'></i>";
				}
				$list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = ".$video_row ['id']);
				$list_video_client_request_num = mysql_num_rows($list_video_client_request);
				for($j=0; $j<$list_video_client_request_num; $j++){
				$list_video_client_request_row = mysql_fetch_array($list_video_client_request);
				$show_feedback_type = $list_video_client_request_row['feedback_type'];
				if($list_video_client_request_row['feedback_type']==1){
				$show_feedback_type = 'Changes To Video';
				$show_feedback_type_class = 'changes-video';
				}else if($list_video_client_request_row['feedback_type']==2){
				$show_feedback_type = 'Changes To Audio';
				$show_feedback_type_class = 'changes-audio';
				}else if($list_video_client_request_row['feedback_type']==3){
				$show_feedback_type = 'Other';
				$show_feedback_type_class = 'changes-other';
				}
				$list_video_feedback[$i] .="
				<li class='".$show_feedback_type_class."'><time>".$list_video_client_request_row['time_start']."&#47;".$list_video_client_request_row['time_end']."</time>
				<small><b>".$show_feedback_type."</b>".$list_video_client_request_row['feedback']."</small></li>
				";//list all request information display in page
				}
				$list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$video_row['id']." ORDER BY id DESC LIMIT 0, 1");
				$list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
				$stop_resubmit_bug = mysql_query("UPDATE video_client_addition_request SET stop_resubmit = 1 WHERE id = ".$list_video_client_addition_request_row['id']);
				if($show_final_msg) {
				$new_final_message = ""; //'<label class="message">'.$show_final_msg.'</label>';
				}
				$obj_template = include('inc/video-draft-object.php');
				echo $obj_template;
				}
				?>
			</ul>
		</section>
		</main>
		<? include('../footer.php');?>
		<div id="overlay_wrapper" onClick="closeAllCards()"></div>
	</body>
</html>