<?php 
/*========================================
=   Email to Secondary receipients      =
==========================================*/
            $cc_mailsubject = 'Surge Media Video Dash - Your Video Is Ready - ('.$checksamelinkrow['project_name'].')';
            $cc_mailtitle = 'Surge Media Video Dash';
            $cc_mailsubtitle = 'Your Video Is Ready - ('.$checksamelinkrow['project_name'].')';
            $cc_mailmessage = '<b>Hi there,</b>
            <p>We just wanted to let you know that the final video <b>('.$checksamelinkrow['project_name'].')</b> download link has been emailed to '.$cca_row['contact_person'].' who is the designated contact for this project.</p>
            <p>Please contact them on '.$cca_row['email'].' to obtain a copy of the video.</p></br>
            <p>Thank you.</p> ';
     ?>
    