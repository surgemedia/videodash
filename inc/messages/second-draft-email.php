<?php 
$mailsubject = 'Surge Media Video Dash - Your Project Is Ready For Review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '
                <b>Dear '.$cca_row['contact_person'].',<br/></b>
                <p>We are pleased to inform you that your changes have been amended and the second draft of your video project:'.$checksamelinkrow['project_name'].' is ready for review. via Video Dash<br/>
                    The video draft has been uploaded to our Video Dash. <br/>
                    Video Dash is an online video management and delivery system designed by Surge Media that makes your video production experience as smooth as possible. <br/>
                    Please click on the link below to review your project.<br/><br/>
                    <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">
                        Review your project
                    <a><br/>
                </p>
                <p>
                <br/>
                    Please be aware that you have one set of changes remaining. Charges may apply for additional changes.
                </p>
                <p>Please review your project carefully and use the timestamp on the video to note down any changes you require.</p>
                ';
 ?>