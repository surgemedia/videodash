<?php 
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
 ?>