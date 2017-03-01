<?php 
//Update the videp project with download link
                    mysql_query("UPDATE video_project SET download_file = '".$_POST['downloadlink']."' WHERE id = ".$_POST['project_id']);
                    $mailsubject = 'Surge Media Video Dash - Your Video Is Ready';
                    $mailtitle = 'Surge Media Video Dash';
                    $mailsubtitle = 'Your video is ready';
                    $mailmessage = '
                    <p>Hi '.$cca_row['contact_person'].'</p>
                    <p>We are pleased to inform you that your final video <b>('.$checksamelinkrow['project_name'].')</b>, is ready for download from Video Dash.</p><br/>
                    <p><a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Click to download your video</a></p><br/> 
                    <p>Please contact us if you have any issue downloading your video.</p>
                    ';
?>