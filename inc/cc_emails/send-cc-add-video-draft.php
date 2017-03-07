<?php 
/*========================================
=   Email to Secondary receipients      =
==========================================*/
            $cc_mailsubject = 'Surge Media Video Dash - Your video is ready to review ('.$checksamelinkrow['project_name'].')';
            $cc_mailtitle = 'Surge Media Video Dash';
            $cc_mailsubtitle = 'Your project is ready for review';
            $cc_mailmessage = "Hi there,<br/>
            <p>We just wanted to let you know that a video draft for the project: <b>(".$checksamelinkrow['project_name'].")</b> is ready for review.<p> <br/>          
            <p>Please submit any change requests to the designated contact for this project: <a href='mailto:".$cca_row['email']."'>".$cca_row['email']."</a></p> <br/>
            <p>Click to view video (<a href='".$_POST['video_input']."'>link to Youtube URL</a>)</p>";
            //$cca_row['contact_person']
     ?>