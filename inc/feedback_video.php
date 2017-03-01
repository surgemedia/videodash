<?php 
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
    $mail_message = '
    <h1>'.$cca_row['company_name'].' - '.$projectname_row['project_name'].' - Change Request</h1></br>
    <p>Change request - #'.$last_video_under_project_row['version_num'].'</p><br/>
    <p>Client: ' . $cca_row['company_name'] . '</p><br/>
    <p>Video Project: ' . $projectname_row['project_name'] . '</p><br/>
    <p>General comment: ' . $general_comment . '</p>
    <table border=\"1\">
        <tr>
            <th>Start</th>
            <th>End</th>
            <th>Type</th>
            <th>comments</th>
        <tr>
        ' . $list_comment . '
    </table>
";
}
 ?>