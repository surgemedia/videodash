<?php 
$mailsubject = 'Surge Media Video Dash - Your Video Is Ready For Review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your video is ready for review';
                $mailmessage = '
                <p>Dear '.$cca_row['contact_person'].',</p></br>
                <p>We are pleased to inform you that the first draft of your video project: <b>'.$checksamelinkrow['project_name'].'</b> is ready for review and has been uploaded to Video Dash.</p> </br>
                <p>Video Dash is an online video management and delivery system designed by Surge Media to make your video production experience as smooth as possible.</p></br>
                <p><a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Click to review your video</a></p></br>
                <p>Please make sure to review your project carefully and use the video timestamp to note down any changes in Video Dash.</p>
                ';
 ?>