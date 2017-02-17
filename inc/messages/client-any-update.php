<?php 

$Client_mail_message = '
		<p>Hi ' . $cca_row['contact_person'] . '!</p><br/>
		
		<p>Your changes have been submitted and are in the pipeline.</p>
		<p>Please contact your creative director if you need to discuss your changes in more detail.</p>
		<p>We will contact you if we have any queries regarding your changes.</p>
		';
        $update_mail_subject = "Surge Media Video Dash - Change request confirmation";
        $first_draft_title = "Surge Media Video Dash";
        $update_mail_subtitle = "Change request confirmation";
        mysql_query("UPDATE video_client_addition_request SET comment_time = 0 WHERE id = " . $last_video_a_request_row['id']);

         ?>