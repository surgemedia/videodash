<?php 
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
                $downloadfilelink .= '<a href="javascript:void(0)" class="btn red" onClick="document.getElementById(\'more_change_require\').submit();"><span class="omega alpha"> Changes Required</span><i class="fa fa-star"></i></a>';
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
        
    }
    else {
        $downloadfile_message = '<br/>We are editing your video now.' . $file_details_message;
    }
}
 ?>