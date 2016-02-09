<?php
/*============================================================
                        =            Change Include Path and Include Mail            =
============================================================*/
ini_set("include_path", '/home/videodsurg/php:' . ini_get("include_path"));
//enable all Pear php Mail function, Pear mail and mime, please install in Cpanel client page before use it.
require_once "Mail.php";
include ('Mail/mime.php');
// error_reporting(-1);
// ini_set('display_errors', 'On');
?>
<?php
/*===========================================
     =            Database Connection            =
===========================================*/
include ("../dbconnection_3evchey.php");
//connecting Database
session_start();
if ($_POST['client_id'] == '' && $_POST['project_id'] == '') {
    header("location: ../index.java");
}
else {
    $client_id = $_POST['client_id'];
    $project_id = $_POST['project_id'];
}
include ('../inc/head.php'); 

/*===========================================
                        =            Define Mail Message            =
===========================================*/
$mail_message = "";
/*=======================================*/
            /*       Change Content Details          */
/*=======================================*/
if ($_POST['company_name'] != "") {
    $update_contact = mysql_query("UPDATE Client_Information SET company_name = '" . trim($_POST['company_name']) . "', contact_person = '" . trim($_POST['contact_person']) . "', mobile_number = '" . trim($_POST['mobile_number']) . "', email = '" . trim($_POST['email']) ."', cc_email = '" . trim($_POST['cc_email']) . "' WHERE id = " . $client_id . " AND active_option = 1");
}
$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = " . $client_id . " AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
if ($cca_num == 0) {
    header("location: ../index.java");
}
$projectname = mysql_query("SELECT * FROM video_project WHERE id = " . $project_id);
$projectname_row = mysql_fetch_array($projectname);
/*=================================================*/
    /*       Make video to Final Version and Email   */
/*===============================================*/
if ($_POST['make_video_version_to_final'] == "yes") {
    $l_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = " . $project_id . " AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
    $l_video_under_project_row = mysql_fetch_array($l_video_under_project);
    $version_number_editer = $l_video_under_project_row['version_num'] + 1;
    mysql_query("INSERT INTO video_under_project VALUES(NULL, " . $project_id . ", '" . $l_video_under_project_row['video_link'] . "', 'Final', 'Final Version Confirmed', 1, " . $version_number_editer . ", NULL);");
    $mail_message = '<b>A client has confirmed the final version of their video</b>
Client: ' . $cca_row['company_name'] . "<br/>
Video Project: " . $projectname_row['project_name'];
    $Client_mail_message = '
Hey ' . $cca_row['contact_person'] . ',<br/><br/>
<p>Way to go on confirming your final video.<br/></p>
<p>Your video isn’t quite ready to download yet but hang tight!<br/>
Your high resolution final video is on it’s way.</p>
<p>In the meantime, please be patient, crack open a drink and we will contact you if we have any questions.</p>
<p>Kind Regards,<br/>
Paris Ormerod</p>
';
    $update_mail_subject = "More Change enquiry.";
    $first_draft_title = "Your changes Have Been Submitted";
}
$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = " . $project_id . " AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$last_video_under_project_row = mysql_fetch_array($last_video_under_project);
$forloopcount = 0;
$addition_change_to_mail = '';
$addition_change_to_mail2 = '';
if ($last_video_under_project_row['id'] != "" && $_POST['add_more_changed'] == "yes") {
    mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '" . $last_video_under_project_row['id'] . "', '" . $_POST['script1'] . "', '" . $_POST['script2'] . "', '" . $_POST['logoandimage_email'] . "', '" . $_POST['logoandimage_dropbox'] . "', '" . $_POST['voice_id'] . "', '" . $_POST['voice_comment'] . "', '" . $_POST['audio_comment'] . "', '" . $_POST['contact_info1'] . "', '" . $_POST['contact_info2'] . "', '" . $_POST['contact_info3'] . "', '" . $_POST['contact_info4'] . "')");
    
    //if it's addition comments. add it to databace
    $addition_change_to_mail = 'Additional Change';
    $addition_change_to_mail2 = 'Review it and send quote to client.<br/>';
    //echo "INSERT INTO video_client_addition_request VALUES(NULL, '" . $last_video_under_project_row['id'] . "', '" . $_POST['script1'] . "', '" . $_POST['script2'] . "', '" . $_POST['logoandimage_email'] . "', '" . $_POST['logoandimage_dropbox'] . "', '" . $_POST['voice_id'] . "', '" . $_POST['voice_comment'] . "', '" . $_POST['audio_comment'] . "', '" . $_POST['contact_info1'] . "', '" . $_POST['contact_info2'] . "', '" . $_POST['contact_info3'] . "', '" . $_POST['contact_info4'] . "')";
}
$last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = " . $last_video_under_project_row['id'] . " ORDER BY id DESC LIMIT 0, 1");
$last_video_a_request_row = mysql_fetch_array($last_video_a_request);
/*=======================================*/
            /*          Time feedback of video       */
/*=======================================*/
for ($i = 0; $i < 1000; $i++) {
    //runing 1000 time to add feedback to array
    if ($_POST['feedback_' . $i] != "") {
        $feedback[$forloopcount] = $_POST['feedback_' . $i];
        $feedback_strat[$forloopcount] = $_POST['time_start_' . $i];
        $feedback_end[$forloopcount] = $_POST['time_end_' . $i];
        $feedback_type[$forloopcount] = $_POST['comment_option_' . $i];
        $forloopcount = $forloopcount + 1;
    }
}
$comment_remind_mail = 0;
for ($i = 0; $i < $forloopcount; $i++) {
    if ($last_video_a_request_row['stop_resubmit'] != 1) {
        $update_video_client_request = mysql_query("INSERT INTO video_client_request VALUES(NULL, " . $last_video_under_project_row["id"] . ", '" . $feedback_strat[$i] . "', '" . $feedback_end[$i] . "', '" . htmlspecialchars($feedback[$i], ENT_QUOTES) . "', '" . $feedback_type[$i] . "')");
        
        //echo '1 done';
        
    }
    $mail_commect_typs = 'Change To Video';
    if ($feedback_type[$i] == 2) {
        $mail_commect_typs = 'Change To Audio';
    }
    else if ($feedback_type[$i] == 3) {
        $mail_commect_typs = 'Other';
    }
    $list_comment.= '<tr><td>' . $feedback_strat[$i] . '</td><td>' . $feedback_end[$i] . '</td><td>' . $mail_commect_typs . '</td><td>' . htmlspecialchars($feedback[$i], ENT_QUOTES) . '</td></tr>';
    
    //echo "INSERT INTO video_client_request VALUES(NULL, ".$last_video_under_project_row["id"].", '".$_POST['time_start'.$i]."', '".$_POST['time_end'.$i]."', '".$_POST['feedback'.$i]."')";
    $comment_remind_mail = 1;
    //if have any comment, set it 1.
    
}
if ($_POST['old_loop_time'] > 0) {
    for ($j = 0; $j < $_POST['old_loop_time']; $j++) {
        if ($_POST["addfeedback" . $j] != "") {
            $mail_commect_typs = 'Change To Video';
            if ($_POST["addcommentoption" . $j] == 2) {
                $mail_commect_typs = 'Change To Audio';
            }
            else if ($_POST["addcommentoption" . $j] == 3) {
                $mail_commect_typs = 'Other';
            }
            if ($last_video_a_request_row['stop_resubmit'] != 1) {
                mysql_query("INSERT INTO video_client_request VALUES(NULL, " . $last_video_under_project_row["id"] . ", '" . $_POST["addtimestart" . $j] . "', '" . $_POST["addtimeend" . $j] . "', '" . htmlspecialchars($_POST["addfeedback" . $j], ENT_QUOTES) . "', '" . $_POST["addcommentoption" . $j] . "')");
                
                //echo '2 done';
                
            }
            $list_comment.= '<tr><td>' . $_POST["addtimestart" . $j] . '</td><td>' . $_POST["addtimeend" . $j] . '</td><td>' . $mail_commect_typs . '</td><td>' . htmlspecialchars($_POST["addfeedback" . $j], ENT_QUOTES) . '</td></tr>';
        }
    }
    $comment_remind_mail = 1;
    //if have any comment, set it 1.
    
}
if ($_POST['voice_comment'] != "") {
    $update_video_client_addition_request = mysql_query("UPDATE video_client_addition_request SET voice_comment = '" . $_POST['voice_comment'] . "' WHERE id = " . $last_video_a_request_row['id']);
    
    //echo "UPDATE video_client_addition_request SET voice_comment = '".$_POST['voice_comment']."' WHERE id = ".$last_video_a_request_row['id'];
    $general_comment = $_POST['voice_comment'];
    $comment_remind_mail = 1;
    //if have any comment, set it 1.
    
}
if ($list_comment != "" || $general_comment != "") {
    $mail_message = 'A client has submitted their #' . $last_video_under_project_row['version_num'] . ' set of changes.<br/>
' . $addition_change_to_mail2 . '
Client: ' . $cca_row['company_name'] . "<br/>
Video Project: " . $projectname_row['project_name'] . "<br/>
Comment: " . $general_comment . "
<table border=\"1\">
    <tr><th>Start</th><th>End</th><th>Type</th><th>comments</th><tr>
    " . $list_comment . "
</table>
";
}
include ('../inc/youtube_function.php');
$contents_location = "http://gdata.youtube.com/feeds/api/videos?q={" . cleanYoutubeLink($last_video_under_project_row['video_link']) . "}&alt=json";
$JSON = file_get_contents($contents_location);
$JSON_Data = json_decode($JSON);
$video_lenght = $JSON_Data->{'feed'}->{'entry'}[0]->{'media$group'}->{'yt$duration'}->{'seconds'};
$video_lenght_result = $video_lenght . ':000';
$end_time = gmdate("i:s", (int)$video_lenght_result);
/*=============================================================*/
        /*                  More changes then alicated                  */
/*=============================================================*/
$update_mail_subject = "";
//unset the mail subject in begining.
if ($list_comment != "" || $general_comment != "") {
                include('../inc/messages/client-first-draft.php');
}
/*=============================================================*/
        /*      Send Email to advise any update of video Project       */
/*=============================================================*/
if ($comment_remind_mail == 1) {
    // Update mailout to 1 and will stop to send mail while send one mailout in version 1
    if ($last_video_under_project_row['version_num'] == 1 && $last_video_a_request_row['comment_time'] == 0 && $last_video_under_project_row['version'] == 'Draft') {
        
        //IF Client first time comment to video
                include('../inc/messages/client-any-update.php');
        //Update database to stop sendmail duplicate
        
    }
/*=============================================
                =           2nd Set of changes           =
=============================================*/
    if ($last_video_under_project_row['version_num'] == 2 && $last_video_under_project_row['version'] == 'Draft') {
        //IF version number already upload new video to client to review
        if ($last_video_a_request_row['comment_time2'] == 0) {
                include('../inc/messages/client-second-draft.php');
        }
    }
}
$the_data_is = date("d M Y");
$name = "Surge Media - Video Dash";
$frommail = "video@surgemedia.com.au";
$mailto = 'video@surgemedia.com.au';
// $cca_row['email'];
$mailtoclient = $cca_row['email'];
$mailsubject = 'Client\'s #' . $last_video_under_project_row['version_num'] . ' Set Of Changes';
if ($mail_message != "") {
    //Check whether have any email message need to send out
    $mail_data = file_get_contents('../email_template/feedback2Surge.html');
    $mail_data = str_replace("[mail_title]", $mailsubject, $mail_data);
    $mail_data = str_replace("[mail_content]", $mail_message, $mail_data);
    $mail_data = str_replace("[mail_datandtime]", $the_data_is, $mail_data);
    
    //Mail content to Surge Media
    if ($_POST['make_video_version_to_final'] == "yes") {
        $mailsubject = 'Client confirmed the final version.';
    }
    //If client confirm video as Final Version, send mail to Ben and Video Team about it.
    $m->setFrom('video@surgemedia.com.au');
    $m->addTo($mailto);
    $m->setSubject($mailsubject);
    $m->setMessageFromString('',$mail_data);
    $m->setMessageCharset('','UTF-8');
    $ses->sendEmail($m);
}
if ($update_mail_subject != "") {
    $client_mail_data = file_get_contents('../email_template/feedback.html');
    if ($first_draft_title != "") {
        $client_mail_data = str_replace("[mail_title]", $first_draft_title, $client_mail_data);
    }
    $client_mail_data = str_replace("[mail_title]", $update_mail_subject, $client_mail_data);
    $client_mail_data = str_replace("[mail_content]", $Client_mail_message, $client_mail_data);
    $client_mail_data = str_replace("[mail_datandtime]", $the_data_is, $client_mail_data);
    
    //Mail Content to Client
    $m->setFrom('video@surgemedia.com.au');
            $m->addTo($mailtoclient);
            $m->setSubject($update_mail_subject);
            $m->setMessageFromString('',$client_mail_data);
            $m->setMessageCharset('','UTF-8');
           $ses->sendEmail($m);
}
//Stop mailout to keep system work fine if without any remind mail to client.
/*===========================================
Verion Number to show changed Day counter
============================================*/
$stop_comment = "";
$overdeadline_message = "";
$help_text;
$display_draft_timer = false;
if ($last_video_under_project_row['version'] != 'Final') {
    $last_video_a_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = " . $last_video_under_project_row['id'] . " ORDER BY id DESC LIMIT 0, 1");
    $last_video_a_request_row = mysql_fetch_array($last_video_a_request);
    if ($last_video_under_project_row['version_num'] == 1 && $last_video_a_request_row['comment_time'] != 1) {
        $stop_comment_disable = 1;
    }
    if ($last_video_under_project_row['version_num'] == 2 && $last_video_a_request_row['comment_time2'] != 1) {
        $stop_comment_disable = 1;
    }
    $current_draft_comments = mysql_query("SELECT feedback FROM video_client_request WHERE video_id = ". $last_video_under_project_row['id']);
    $current_draft_comments_column = mysql_fetch_array($current_draft_comments);
}

if ($last_video_under_project_row['version'] != "Final") {
    $downloadfilelink = '<li>';
            if ($stop_comment_disable != 1) {
                $downloadfilelink .= '<a href="javascript:void(0)" class="btn red" onClick="document.getElementById(\'more_change_require\').submit();"><span class="omega alpha">Changes Required</span><i class="fa fa-star"></i></a>';
            }
    $downloadfilelink .= '<a href="javascript:void(0)" class="btn blue" onClick="document.getElementById(\'final_version_confirm\').submit();"><span class="omega alpha">Approve as final*</span></a>';
    $help_text = "<small class='help-text'>*no changes required</small>";
    $downloadfilelink2 = '';
    $downloadfile_message = '';
    $list_day_counter = check_deadline($project_id, $last_video_under_project_row['version'], 'deadline');



    if ($list_day_counter > 0) {
        if ($stop_comment_disable == 1) {
            $overdeadline_message = 'The video draft will be available for ' . check_deadline($project_id, $last_video_under_project_row['version'], 'deadline') . ' days';
            $display_draft_timer = 1;
        }
        else {
            $overdeadline_message = 'Your final video is ready for review.';
            $display_draft_timer = 2;

        }
    }
    else {
        $overdeadline_message = 'Sorry, we have not recevied any changes from you in the last 3 weeks. If you would like to submit changes now,we may charge for the time involved';
        $display_draft_timer = 3;
    }
}
else {
    $overdeadline_message = '';
    if ($projectname_row['download_file'] != "") {
        
        //$downloadfilelink2 = '<li><a href="download_page.php?project='.$projectname_row['id'].'" class="btn yellow fifteen columns big_btn" ><span>Download Video</span><i class="fa fa-star"></i></a></li>';
        /*For New option submit page*/
        $downloadfilelink2 = '
<a href="' . $projectname_row['download_file'] . '" class="btn green wow shake omega alpha" ><span>Download Your Videos for ' . $cca_row['company_name'] . ' - ' . $projectname_row['project_name'] . '</span><i class="fa fa-download"></i></a>';
        $downloadfilelink = '';
    }
    else {
        $downloadfilelink = '<label class="message " ><span></span> </label>';
        $downloadfilelink2 = '';
    }
    
    if ($projectname_row['download_file'] != "") {
        $downloadfile_message = 1;
        //'<br/>Congratulations your video is now ready for downlaod now.'.$file_details_message;
        
    }
    else {
        $downloadfile_message = '<br/>We are editing your video now.' . $file_details_message;
    }
}
?>
<!DOCTYPE html>
<html>
    <?php
    ?>
    <body class="bg-pattern">
        <div class="fullscreen disable_input" id="request_confirm_form">

            <div class="confirmbtn">
                <a href="#" id="cloasesubmit" class="cloasesubmit"><i class="fa fa-times"></i></a>
               <p> If you are happy with your changes,<br>
                Please submit your comments
                </p>
                
                <a class="btn green columns five alpha" onClick="document.getElementById('charge_update').submit();"><span>Submit</span> <i class="fa fa-check"></i></a>
            <small>*Please note that this action can't be undone.</small>
            
            </div>
        </div>
        <?php
        include ('client_header.php'); ?>
        <main>
            <section class="container">
            <h1></h1>
                <?php  //include ('../inc/client-view-project-details.php'); ?>
                <!-- <input type="text" id="searchbox" class="search wow bounceIn"> -->
                <?php
                /*=======================================*/
                    /*         Get Feedback Deadline         */
                /*=======================================*/
                function check_deadline($function_v_project_id, $version, $mode) {
                $check_deadline = mysql_query("SELECT upload_time FROM video_under_project WHERE video_project_id = " . $function_v_project_id . " AND version LIKE '" . $version . "' AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
                $check_deadline_row = mysql_fetch_array($check_deadline);
                $now = time();
                // or your date as well
                $data_format = substr($check_deadline_row['upload_time'], 0, 10);
                $upload_date = strtotime($data_format);
                $datediff = $now - $upload_date;
                if ($mode == "deadline") {
                return 21 - floor($datediff / (60 * 60 * 24));
                }
                else {
                return date('d-F-Y', strtotime($check_deadline_row['upload_time']));
                }

                //return  $data_format ;

                }
                ?>
                <?php
                /*=======================================*/
                /*  Action for Approve for Final Buttons  */
                /*=======================================*/
                ?>          <!-- Approve for Final -->
                <form id="final_version_confirm" action="#" method="post">
                    <input value="<?php echo $client_id; ?>" name="client_id" type="hidden">
                    <input value="<?php echo $project_id; ?>" name="project_id" type="hidden">
                    <input value="yes" name="make_video_version_to_final" type="hidden">
                </form>
                <form id="more_change_require" action="request_confirm.php" method="post">
                    <input value="<?php echo $client_id; ?>" name="client_id" type="hidden">
                    <input value="<?php echo $project_id; ?>" name="project_id" type="hidden">
                    <input value="yes" name="add_more_changed" type="hidden">
                </form>
                <?php 
                if ($projectname_row['download_file'] != "") { ?>
                    <form action="mail_upsell.php" id="addition_request_form" method="post" class="sixteen column">
                    <?php
                    }
                    else { ?>
                    <?php // echo "text"; ?>
                    <form action="#" id="charge_update" method="post" class="sixteen column">
                        <?php
                        } ?>
                        <input value="<?php echo $client_id; ?>" name="client_id" type="hidden">
                        <input value="<?php echo $project_id; ?>" name="project_id" type="hidden">
                        <input value="1" name="charge_change" type="hidden">
                        <ul>
                            <li class="video_obj featured">

                                <h1 class="title main">
                                <?php // echo $cca_row['company_name']; ?>
                               <span class="first"> <?php echo $projectname_row['project_name'] ?></span>
                                <span class="type" ><?php
                                echo $last_video_under_project_row['version']; ?></span>
                                <span class="deadline" ><?php
                                echo check_deadline($project_id, $last_video_under_project_row['version']); ?></span>
                                </h1>
                               
                                <?php
                                // move under youtube
                                $show_form = false;
                               if ($downloadfile_message):
                                  if($downloadfile_message==1) {
                                ?>
                                <h2 class="sub-title">Your final video is ready!</h2>
                                <p> Before you download your video please have a think about:</p>
                                <?php $show_form = true; ?>
                                <?php  } else {
                                ?>
                                <h2 class="sub-title">Thank you, your video has been approved. Your final video is being processed. </h2>
                                <p>You will be notified by email once it is ready for download from this page.</p>
                                <?php $show_form = false; ?>
                                <?php } endif; ?>
                                <?php if ($overdeadline_message): ?>
                                <?php  if(strlen(implode(" ",$current_draft_comments_column))>0 or strlen($last_video_a_request_row['voice_comment'])) {
                                ?>
                                <p>Thank you for submitting your comments on the current draft. We will notify you when the next draft is uploaded.</p>
                                <?php
                                         }
                                ?>
                                <?php
                                endif; ?>
                                <?php
                                if ($downloadfile_message): ?>
                                <?php if ($last_video_under_project_row['version'] != "Final") { ?>
                                <div class="video sixteen columns omega alpha">
                                    <!-- VIMEO EMBED -->
                                    <iframe src="//www.youtube.com/embed/<?php echo cleanYoutubeLink($last_video_under_project_row['video_link']); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                                    <!-- VIMEO EMBED -->
                                </div>
                               
                                <?php } ?>
                                <div id="download_message" class="">
                                    <?php
                                    // if (!$downloadfilelink2) { 
                                    // echo $downloadfilelink;
                                    //  }
                                    if($show_form == true){
                                    include ('../inc/client-view-marketing-form.php');
                                        }
                                     ?>
                
                                     <?php
                                                            if ($downloadfilelink2) {
                                ?>
                                <?php
                                                            echo $downloadfilelink2;
                                ?>
                                <?php
                                                            }
                                ?>
                                <?php
                                endif;
                                if ($last_video_under_project_row['version'] != "Final") {
                                ?>
                                
                                <p>Please select an option below</p>
                               
                                <div id='action_box' class="actions sixteen columns">
                                    <ul>
                                    <li><a href="#Feedbackarea" class=" omega yellow btn">Create Feedback</a></li>
                                   <li> <?php echo $downloadfilelink; //approve final?>
                                   </li>
                                    </ul>
                                        <?php echo $help_text; ?>

                                </div>
                                

                                <div class="video sixteen columns omega alpha" id="youtube_video_div">
                                    
                                    <iframe src="//www.youtube.com/embed/<?php echo cleanYoutubeLink($last_video_under_project_row['video_link']); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                                   
                                </div>
                                <?php
                                } ?>
                                 <?php if($overdeadline_message) { ?>
                                    <p class="message txt">  <?php echo $overdeadline_message; ?></p>  
                                <?php } ?>
                                
                                <?php
                                if ($stop_comment_disable == 1) {
                                ?>
                                     <?php include ('../inc/client-view-comment-section.php'); ?>
                                <?php
                                } ?>
                            </li>
                        </ul>
                    </form>

                    <?php  if ($last_video_under_project_row['version'] != "Final") { ?>
                    
                    <!-- <ul id="videos"> -->
                        <!-- <li><h1>All Video Versions</h1></li> -->
                        <?php
                        $listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =" . $project_id . " ORDER BY enabling, version_num DESC");
                        $video_num = mysql_num_rows($listvideos);
                        for ($i = 0; $i < $video_num; $i++) {
                        $video_row = mysql_fetch_array($listvideos);
                        $show_final_color = $show_final_msg = "";
                        if ($video_row['version'] == "Final") {

                        //$show_final_color = 'style="background: none repeat scroll 0 0 rgba(200, 251, 141, 1);"';
                        $show_final_msg = "Final Video <i class='fa-star fa'></i>";
                        }
                        else {
                        $show_final_msg = "Draft copy <i class='fa-pencil-square-o fa'></i>";
                        }
                        $list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = " . $video_row['id']);
                        $list_video_client_request_num = mysql_num_rows($list_video_client_request);
                        for ($j = 0; $j < $list_video_client_request_num; $j++) {
                        $list_video_client_request_row = mysql_fetch_array($list_video_client_request);
                        $show_feedback_type = $list_video_client_request_row['feedback_type'];
                        if ($list_video_client_request_row['feedback_type'] == 1) {
                        $show_feedback_type = 'Changes To Video';
                        $show_feedback_type_class = 'changes-video';
                        }
                        else if ($list_video_client_request_row['feedback_type'] == 2) {
                        $show_feedback_type = 'Changes To Audio';
                        $show_feedback_type_class = 'changes-audio';
                        }
                        else if ($list_video_client_request_row['feedback_type'] == 3) {
                        $show_feedback_type = 'Other';
                        $show_feedback_type_class = 'changes-other';
                        }
                        $list_video_feedback[$i].= "
                    <li class='" . $show_feedback_type_class . "'><time>" . $list_video_client_request_row['time_start'] . "&#47;" . $list_video_client_request_row['time_end'] . "</time>
                <small><b>" . $show_feedback_type . "</b>" . $list_video_client_request_row['feedback'] . "</small></li>
                ";
                //list all request information display in page

                }
                $list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = " . $video_row['id'] . " ORDER BY id DESC LIMIT 0, 1");
                $list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
                $stop_resubmit_bug = mysql_query("UPDATE video_client_addition_request SET stop_resubmit = 0 WHERE id = " . $list_video_client_addition_request_row['id']);
                if ($show_final_msg) {
                $new_final_message = "";
                //'<label class="message">'.$show_final_msg.'</label>';

                }
                //$obj_template = include ('../inc/video-draft-object.php');

                //echo $obj_template;

                }
                ?>
            <!-- </ul> -->

                <?php } ?>
   
        </section>
    </main>
    <?php
    include ('../footer.php'); ?>
    <div id="overlay_wrapper" onClick="closeAllCards()"></div>
</body>
</html>