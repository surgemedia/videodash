<!DOCTYPE html>
<html>
    <?php
include ('../inc/head.php');
?>
    <body class="">
        <?php
echo '<pre class="code"><code>';
ini_set("include_path", '/home/videodsurg/php:' . ini_get("include_path"));
require_once "Mail.php";
include ('Mail/mime.php');
include ("../dbconnection_3evchey.php");
 //connecting Database
if ($_POST['client_id'] == '' && $_POST['project_id'] == '') {
    header("location: ../home_video.php");
}
$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = " . $_POST['client_id'] . " AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
$checksamelink = mysql_query("SELECT * FROM video_project WHERE id = " . $_POST['project_id'] . " ORDER BY id DESC LIMIT 0,1");

//echo "SELECT * FROM video_project WHERE id = ".$_POST['project_id']." ORDER BY id DESC LIMIT 0,1<br/>";
$checksamelinkrow = mysql_fetch_array($checksamelink);

// echo $checksamelinkrow['project_name'].$cca_row['contact_person'];
if ($cca_num == 0) {
    header("location: ../home_video.php");
}
$message = "Add New Video";
if ($_POST['Add_videos'] == 1 && $_POST['video_input'] == "") {
    $error_msg = '<label class="message red" for="">Without upload any Youtube Link!</label>';
}
if ($_POST['Add_videos'] == 1 && $_POST['project_id'] != "" && $_POST['video_input'] != "") {
    $check_total_version = mysql_query("SELECT * FROM video_under_project WHERE video_project_id =" . $_POST['project_id']);
    $check_total_version_num = mysql_num_rows($check_total_version);
    $check_video_Lastupdate = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =" . $_POST['project_id'] . " AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
    $check_video_Lastupdate_row = mysql_fetch_array($check_video_Lastupdate);
    
    //echo $check_total_version_num;
    $videoversion_num = $check_total_version_num + 1;
    if ($check_video_Lastupdate_row['version'] == "Final") {
        $query = mysql_query("UPDATE video_under_project SET notes = '" . htmlspecialchars($_POST['notes'], ENT_QUOTES) . "' WHERE id = " . $check_video_Lastupdate_row['id']);
        
        //echo "UPDATE video_under_project SET notes = '".$_POST['notes']."' WHERE id = ".$check_video_Lastupdate_row['id'];
        
    } 
    else {
        $query = mysql_query("INSERT INTO video_under_project VALUE(NULL, " . $_POST['project_id'] . ", '" . $_POST['video_input'] . "', '" . $_POST['version'] . "', '" . htmlspecialchars($_POST['notes'], ENT_QUOTES) . "', 1, " . $videoversion_num . ", NULL)");
    }
    mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '" . mysql_insert_id() . "', '" . $_POST['script1'] . "', '" . $_POST['script2'] . "', '" . $_POST['logoandimage_email'] . "', '" . $_POST['logoandimage_dropbox'] . "', '" . $_POST['voice_id'] . "', '" . $_POST['voice_comment'] . "', '" . $_POST['audio_comment'] . "', '" . $_POST['contact_info1'] . "', '0', '" . $_POST['contact_info3'] . "', '" . $_POST['contact_info4'] . "')");
    if (!$query) {
        echo "INSERT INTO video_under_project VALUE(NULL, " . $_POST['project_id'] . ", '" . $_POST['video_input'] . "', '" . $_POST['version'] . "', '" . htmlspecialchars($_POST['notes'], ENT_QUOTES) . "', 1, " . $videoversion_num . ", NULL)";
        echo "Cannot Save this Video to Project.";
        exit;
    } 
    else {
        $checksamelink = mysql_query("SELECT * FROM video_project WHERE id = " . $_POST['project_id'] . " ORDER BY id DESC LIMIT 0,1");
        
        //echo "SELECT * FROM video_project WHERE id = ".$_POST['project_id']." ORDER BY id DESC LIMIT 0,1<br/>";
        $checksamelinkrow = mysql_fetch_array($checksamelink);
        $complete_msg = '<label class="message green columns omega alpha two" for="">Updated <i class="fa fa-thumbs-up"></i></label>';;
        $name = "Surge Media - Video Dash";
        $mailto = $cca_row['email'];
        $cc_mailto = $cca_row['cc_email'];
        
        /*===============================
        =            Email 1            =
        ===============================*/
        if ($videoversion_num == 1) {
            include ('../inc/messages/first-draft-email.php');
            
            /*===============================
            =            Email 2            =
            ===============================*/
        } 
        else if ($videoversion_num == 2) {
            include ('../inc/messages/second-draft-email.php');
        } 
        else {
            
            /*===============================
            =            Email 3            =
            ===============================*/
            include ('../inc/messages/third-draft-email.php');
        }
        
        /*==========================================================================================================
            =    If Download Link Exsists  send it to main contact        =
        =============================================================================================================*/
        if ($_POST['downloadlink'] != "") {
            
            //echo $_POST['downloadlink'];
            if ($_POST['downloadlink'] != $checksamelinkrow['download_file']) {
                include ('../inc/messages/final-download.php');
            }
        }
        $mail_data = file_get_contents('../email_template/video_download.html');
        $mail_data = str_replace("[mail_title]", $mailtitle, $mail_data);
        $mail_data = str_replace("[mail_subtitle]", $mailsubtitle, $mail_data);
        $mail_data = str_replace("[mail_content]", $mailmessage, $mail_data);
        $the_data_is = date("d M Y");
        $mail_data = str_replace("[mail_datandtime]", $the_data_is, $mail_data);
        
        $m->setFrom('video@surgemedia.com.au');
        
        //Send to Mail
        $m->addTo($mailto);
        
        //Send to Subject
        $m->setSubject($mailsubject);
        
        //Send to html data
        $m->setMessageFromString('', $mail_data);
        $m->setMessageCharset('', 'UTF-8');
        $ses->sendEmail($m);
        
        /*========================================
        =   Email to Secondary receipients      =
        ==========================================*/
        
        //Get Data
        include ('../inc/cc_emails/send-cc-add-video.php');
        
        //Sending email to seconfary recipients
        $mail_data = file_get_contents('../email_template/video_download.html');
        
        //Replace Title in tempalte
        $mail_data = str_replace("[mail_title]", $cc_mailtitle, $mail_data);
        
        //Replace Subtile in Template
        $mail_data = str_replace("[mail_subtitle]", $cc_mailsubtitle, $mail_data);
        
        //Replace content and with content
        $mail_data = str_replace("[mail_content]", $cc_mailmessage, $mail_data);
        $the_data_is = date("d M Y");
        
        //replace dataandtime with current data and time.
        $mail_data = str_replace("[mail_datandtime]", $the_data_is, $mail_data);
        
        $m->setFrom('video@surgemedia.com.au');
        
        //Send to CC
        $m->addTo($cc_mailto);
        
        //Set Subject
        $m->setSubject($cc_mailsubject);
        
        //Set HTML
        $m->setMessageFromString('', $mail_data);
        
        //Set Charsset
        $m->setMessageCharset('', 'UTF-8');
        
        //Send Email
        $ses->sendEmail($m);
    }
}
$check_video_Lastupdate = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =" . $_POST['project_id'] . " AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
$check_video_Lastupdate_row = mysql_fetch_array($check_video_Lastupdate);
$check_project_name = mysql_query("SELECT * FROM video_project WHERE  id =" . $_POST['project_id']);
$check_project_name_row = mysql_fetch_array($check_project_name);
include ('../inc/youtube_function.php');
echo '</pre></code>';
?>
        <?php
include ('../inc/header.php'); ?>
        <main>

            <section class="container">
                <h1 class="float-left container"><?php echo $message; ?></h1>
                <?php
if ($complete_msg): ?>
                <?php
    echo $complete_msg; ?>
                <?php
endif; ?>
                <form action="http://videodash.surgehost.com.au/all_projects.php" method="post" id="back_to_project">
                    <input name="client_id" value="<?php echo $cca_row['id']; ?>" type="hidden"/>
                </form>


                <ul  >
                    <li id="add_new_video" class="video_obj featured">
                        <!-- <a onClick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> All Projects</h1></a> -->
                        <form action="add_video.php" method="post" id="add_video">
                            <h1 id="client_name_editable" class="title">
                            <input name="client_id" value="<?php echo $cca_row['id']; ?>" type="hidden"/>
                            <input name="project_id" value="<?php echo $_POST['project_id']; ?>" type="hidden"/>
                            <input name="Add_videos" value="1" type="hidden"/>
                            <!-- <input type="text" value="Upload new video version"> -->
                            <!-- <i class="fa fa-edit"></i> -->
                            </h1>
                            <?php
echo $error_msg; ?>
                            <div class="section sixteen columns omega alpha">
                                <?php
$video_display_code = '//www.youtube.com/embed/KAYfuAROKV8';
if ($check_video_Lastupdate_row['video_link'] != "") {
    $video_display_code = '//www.youtube.com/embed/' . cleanYoutubeLink($check_video_Lastupdate_row['video_link']);
    $showvideovalue = 'value="http://www.youtube.com/?v=' . cleanYoutubeLink($check_video_Lastupdate_row['video_link']) . '"';
}
?>
                                <input id="realtime_link" name="video_input" type="text" placeholder="Youtube link: http://www.youtube.com/?v=<?php echo $video_display_code; ?>" class="video_link columns sixteen" <?php
echo $showvideovalue; ?> >
                                <div id="put_new_youtube"></div>
                                <div class="video sixteen columns omega alpha">
                                    <!-- VIMEO EMBED -->
                                    <?php
if ($check_video_Lastupdate_row['video_link'] != "") { ?>
                                    <iframe id="calendar" src="<?php
    echo $video_display_code; ?>" frameborder="0" allowfullscreen></iframe>
                                    <?php
} 
else { ?>
                                    <i class="fa fa-video-camera blank_video"></i>
                                    <?php
} ?>
                                   
                                </div>
                            </div>
                            <div class="actions sixteen columns omega alpha">
                                <div id="draft_version" class="draft_check"><input type="radio" name="version" value="Draft"  <?php
if ($check_video_Lastupdate_row['version'] != "Final") {
    echo "checked";
} ?> ><span>Draft Version</span></div>
                                <div id="final_version" class="draft_check"><input type="radio" name="version" value="Final"  <?php
if ($check_video_Lastupdate_row['version'] == "Final") {
    echo "checked";
} ?> ><span>Final Version</span></div>
                                <?php

// if($check_video_Lastupdate_row['version']=="Final"){

?>
                                <label class="title" for="">Download Video Link</label>
                                <input name="downloadlink" type="text" placeholder="Dropbox File Link" class="video_link sixteen columns omega alpha" value="<?php
echo $check_project_name_row['download_file'] ?>">
                                <?php

// }

?>
                                <label class="title" for="">Director's Notes</label>
                                <textarea name="notes" id="" cols="30" class="sixteen columns omega alpha" rows="10" placeholder="<?php echo $check_video_Lastupdate_row['notes']; ?>">The video draft is a low resolution version of your video production. Please note that the colour has been graded and the audio has not been mastered, therefore the draft may look low quality. The final version of your video project will be rendered out in high resolution. Use Video Dash to view your project and make changes as we do not accept changes via the phone or email. However if you are having trouble using Video Dash, please contact us directly.</textarea>
                                <ul>
                                    <li>
                                        <a onClick="document.getElementById('add_video').submit();" class="btn green" ><span>Send to Client</span> <i class="fa fa-send"></i></a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                   </li>

                </ul>

    
                <ul id="videos">
                    <?php
$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =" . $_POST['project_id'] . " ORDER BY enabling, version_num DESC");
$video_num = mysql_num_rows($listvideos);
for ($i = 0; $i < $video_num; $i++) {
    $video_row = mysql_fetch_array($listvideos);
    $show_final_color = $show_final_msg = "";
    if ($video_row['version'] == "Final") {
        $show_final_color = 'style="background: none repeat scroll 0 0 rgba(200, 251, 141, 1);"';
        $show_final_msg = "[Final]";
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
    $list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = " . $video_row['id'] . " ORDER BY id LIMIT 0, 1");
    $list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
    if ($list_video_client_addition_request_row['voice_comment'] != "" || $list_video_feedback[$i] != "") {
        if ($i == 0) {
            echo '<li><h1>Current Drafts</h1></li>';
        }
        include ('../inc/video-draft-object.php');
    }
}
?>
        </ul>
    </section>
</main>
<?php
include ('../footer.php'); ?>
<div id="overlay_wrapper" onClick="closeAllCards()"></div>
</body>
</html>
<script>
    $(document).ready(function(){
        $("#realtime_link").keyup(function(){
            var query = $("#realtime_link").val();
            query2 = query.split("?v=").pop();
            document.getElementById('calendar').src = "//www.youtube.com/embed/"+query2;
        });
    });
</script>