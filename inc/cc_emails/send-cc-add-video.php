<?php 
/*========================================
=   Email to Secondary receipients      =
==========================================*/
            $cc_mailsubject = 'Surge Media Video Dash - Your video draft is ready to review ('.$checksamelinkrow['project_name'].')';
            $cc_mailtitle = 'Surge Media Video Dash';
            $cc_mailsubtitle = 'Your project is ready for review';
            $cc_mailmessage = '<b>Hi,</b>
            <p>We just wanted to let you know that a video draft for the project:'.$checksamelinkrow['project_name'].' has been sent to '.$cca_row['contact_person'].'.</p>
            <p>Should you wish to add comments please address this to the main contact for this project. Email:'.$cca_row['email'].'.</p></br>
            <p>Thank you.</p> ';
     ?>