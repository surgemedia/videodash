<?php 
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
		
		$mail_message_asana = "<p><b>Video Project: </b>" . $projectname_row['project_name'] . "</p><br/>"."<p><b>Comment: </b> ". $general_comment . "</p><br/><br/>".$list_comment_asana."<br/><br/>";
} 



?>