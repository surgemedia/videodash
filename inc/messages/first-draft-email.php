<?php 
$mailsubject = 'Surge Media Video Dash - Your Project Is Ready For Review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '
                <b>Dear '.$cca_row['contact_person'].',</b><br/><br/>
                <p>We are pleased to inform you that the first draft of your video project:'.$checksamelinkrow['project_name'].' by Surge Media is ready for review. <br/>
                The video draft has been uploaded to our Video Dash. <br/>
                Video Dash is an online video management and delivery system designed by Surge Media that makes your video production experience as smooth as possible. <br/>
                Please click on the link below to review your project.<br/><br/>
                <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Review your project</a><br/></p>
                <p><br/>Please review your project carefully and use the timestamp on the video to note down any changes you require on our Video Dash.</p>
                ';
 ?>