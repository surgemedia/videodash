<?php 
$mailsubject = 'Surge Media Video Dash - Your video draft is ready to review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '<b>Hi '.$cca_row['contact_person'].',</b>
                <p>We are pleased to inform you that your changes have been amended and a draft of your video project:'.$checksamelinkrow['project_name'].' is ready for your review.</p>
                <p>The video draft has been uploaded to our Video Dash.</p>
                <p>Please click on the link below to review your project.<br/>
                <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Review your project</a></p> ';
                 ?>