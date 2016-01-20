<?php 
//Update the videp project with download link
                    mysql_query("UPDATE video_project SET download_file = '".$_POST['downloadlink']."' WHERE id = ".$_POST['project_id']);
                    $mailsubject = 'Surge Media Video Dash - Your Project Is Ready';
                    $mailtitle = 'Surge Media Video Dash';
                    $mailsubtitle = 'Your project is ready';
                    $mailmessage = '
                    <p>Dear '.$cca_row['contact_person'].'</p>
                    <p>We are pleased to inform you that your final video:['.$checksamelinkrow['project_name'].'] by Surge Media is ready for download.<br/>
                    You can download the final video from our Video Dash by clicking on the link below.<br/><br/>
                    <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Final Video</a><br/> 
                    Let us take this opportunity to thank you for choosing <a href="http://surgemedia.com.au">Surge Media</a>. <br/>
                    We look forward to working with you again.</p>';
?>