<?php 

$Client_mail_message = '
		Nice one ' . $cca_row['contact_person'] . '!<br/><br/>
		<p>Baz Luhrmann would be proud!<br/></p>
		<p>Your first set of changes have been submitted and are in the pipeline. </p>
		<p>Just a friendly reminder that you have one set of changes remaining.</p>
		<p>If you have spoken to our video department and your changes are a priority, be assured that they are being addressed.<br/></p>
		<p>In the meantime, please be patient, make some popcorn, watch a movie, and we will contact you if we have any questions.<br/></p>
		<p>Well, that’s a wrap from me. <br/></p>
		<p>Your loving, devoted Post Production Editor,<br/>
		Paris Ormerod</p>
		';
        $update_mail_subject = "Your First Set of Changes";
        $first_draft_title = "Hi-Five! Thank you for submitting your changes.";
        mysql_query("UPDATE video_client_addition_request SET comment_time = 0 WHERE id = " . $last_video_a_request_row['id']);

         ?>