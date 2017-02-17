<?php
/*============================================================
                        =            Change Include Path and Include Mail            =
============================================================*/
ini_set("include_path", '/home/videodsurg/php:' . ini_get("include_path"));
//enable all Pear php Mail function, Pear mail and mime, please install in Cpanel client page before use it.
//require_once "Mail.php";
//include ('Mail/mime.php');
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
include('../inc/update-company.php');
/*=================================================*/
    /*       Make video to Final Version and Email   */
/*===============================================*/
include('../inc/make-video-final.php');
/*=======================================*/
   /*          Time feedback of video       */
/*=======================================*/
 include('../inc/timeline-feedback.php');
/*==========================================
=            Post Voice Comment            =
==========================================*/
include('../inc/voice-comment.php');
include ('../inc/youtube_function.php');
$contents_location = "http://gdata.youtube.com/feeds/api/videos?q={" . cleanYoutubeLink($last_video_under_project_row['video_link']) . "}&alt=json";
$JSON = file_get_contents($contents_location);
$JSON_Data = json_decode($JSON);
$video_lenght = $JSON_Data->{'feed'}->{'entry'}[0]->{'media$group'}->{'yt$duration'}->{'seconds'};
$video_lenght_result = $video_lenght . ':000';
$end_time = gmdate("i:s", (int)$video_lenght_result);
/*=============================================================*/
        /*        More changes then alicated        
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
    if ($last_video_under_project_row['version_num'] == 1 && 
        $last_video_a_request_row['comment_time'] == 0 &&
         $last_video_under_project_row['version'] == 'Draft') {
        
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
// $cc_contact = 
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
    $client_mail_data = str_replace("[mail_subtitle]", $update_mail_subtitle, $client_mail_data);
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
 include('../inc/change_day_counter.php');
?>

<!DOCTYPE html>
<html>
<pre>
    <?php // print_r($cca_row['delivery_page']); ?>
</pre>







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
                    <!-- upsell form for final video -->
                    <form action="mail_upsell.php" id="addition_request_form" method="post" class="sixteen column">
                    <?php
                    }
                    else { ?>
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
                                     /*===============================================
                                     =            The Final Download Page            =
                                     ===============================================*/ 
                                     include('../inc/final-page-form-trigger.php');
                                ?>
                                <?php
                                if ($downloadfile_message): ?>
                                <?php 
                                    //if video isn't final show the video to review
                                if ($last_video_under_project_row['version'] != "Final") { ?>
                                <div class="video sixteen columns omega alpha">   
                                    <iframe src="//www.youtube.com/embed/<?php echo cleanYoutubeLink($last_video_under_project_row['video_link']); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                                </div>
                               
                                <?php } ?>
                                <div id="download_message" class="">
                                    <?php
                                       if($show_form == true){ 
                                            if($cca_row['delivery_page'] == 3){
                                                //just marketing
                                            include ('../inc/client-view-marketing-form-3.php');
                                            }
                                            if($cca_row['delivery_page'] == 2){
                                                //just download button
                                             include ('../inc/client-view-marketing-form-2.php');
                                            }
                                            if($cca_row['delivery_page'] == 1){
                                                //Default page both forms
                                               include ('../inc/client-view-marketing-form-1.php');
                                            }

                                        }
                                       
                                       if ($downloadfilelink2) { echo $downloadfilelink2; }
                                
                                endif;
                                if ($last_video_under_project_row['version'] != "Final") {
                                ?>
                                
                                <p>Please select an option below</p>
                               
                                <div id='action_box' class="actions sixteen columns">
                                    <ul>
                                    <?php if($stop_comment_disable == 1){ ?>
                                    <li><a href="#Feedbackarea" class=" omega yellow btn">Create Feedback</a>
                                    </li>
                                    <?php } ?>
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