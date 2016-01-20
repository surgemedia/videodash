<?php 

     $Client_mail_message = '
			Hey Hey ' . $cca_row['contact_person'] . '!<br/><br/>
			<p>Steven Spielberg would be proud!</p>
			<p>Your second set of changes have been submitted and are in the pipeline. If you have spoken to our Video Department and your changes are a priority, be assured that they are being addressed. </p>
			<p>Also, just a friendly reminder that these are your final changes.</p>
			<p>In the meantime please be patient, have a choc top, watch a movie and we will contact you if we have any queries.<p>
			<p>Well, that’s a wrap from me. <br/>
			Your caring, dedicated Post Production Editor,<br/>
			Paris Ormerod</p>
			';
            mysql_query("UPDATE video_client_addition_request SET comment_time2 = 0 WHERE id = " . $last_video_a_request_row['id']);
            
            //Update database to stop sendmail duplicate
            $update_mail_subject = "Your Second Set of Changes";
             ?>