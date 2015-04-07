<? include("../dbconnection_3evchey.php"); //connecting Database 
	if($_POST['client_id']=='' && $_POST['project_id']==''){
		header("location: ../home_video.php");	
	}
	$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
	$cca_num = mysql_num_rows($check_client_active);
	$cca_row = mysql_fetch_array($check_client_active);
	if($cca_num==0){
		header("location: home_video.php");	
	}
	$message = "Add New Video";
    if($_POST['Add_videos']==1 && $_POST['video_input']==""){
        $error_msg = '<label class="message red" for="">Without upload any Youtube Link!</label>';
    }
	if($_POST['Add_videos']==1 && $_POST['project_id']!="" && $_POST['video_input']!=""){
		$check_total_version = mysql_query("SELECT * FROM video_under_project WHERE video_project_id =".$_POST['project_id']);
		$check_total_version_num = mysql_num_rows($check_total_version);
        $check_video_Lastupdate = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
        $check_video_Lastupdate_row = mysql_fetch_array($check_video_Lastupdate);		
        //echo $check_total_version_num;
		$videoversion_num = $check_total_version_num+1;
		if($check_video_Lastupdate_row['version']=="Final"){
            $query = mysql_query("UPDATE video_under_project SET notes = '".$_POST['notes']."' WHERE id = ".$check_video_Lastupdate_row['id']);
            //echo "UPDATE video_under_project SET notes = '".$_POST['notes']."' WHERE id = ".$check_video_Lastupdate_row['id'];
        }else{
            $query = mysql_query("INSERT INTO video_under_project VALUE(NULL, ".$_POST['project_id'].", '".$_POST['video_input']."', '".$_POST['version']."', '".$_POST['notes']."', 1, ".$videoversion_num.", NULL)");
        }
		mysql_query("INSERT INTO video_client_addition_request VALUES(NULL, '".mysql_insert_id()."', '".$_POST['script1']."', '".$_POST['script2']."', '".$_POST['logoandimage_email']."', '".$_POST['logoandimage_dropbox']."', '".$_POST['voice_id']."', '".$_POST['voice_comment']."', '".$_POST['audio_comment']."', '".$_POST['contact_info1']."', '".$_POST['contact_info2']."', '".$_POST['contact_info3']."', '".$_POST['contact_info4']."')");
        if(!$query){
			echo  "Cannot Save t his Video to Project.";
			exit;	
		}else{
            $checksamelink = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']." ORDER BY id DESC LIMIT 0,1");
            //echo "SELECT * FROM video_project WHERE id = ".$_POST['project_id']." ORDER BY id DESC LIMIT 0,1<br/>";
            $checksamelinkrow = mysql_fetch_array($checksamelink);
            $complete_msg = '<label class="message green columns omega alpha two" for="">Updated <i class="fa fa-thumbs-up"></i></label>';;
			$name = "Surge Media - Video Dash";
			$frommail = "cs@videodash.surgehost.com.au";
			$mailto = $cca_row['email'];
            if($videoversion_num==1){
    			$mailsubject = 'Surge Media Video Dash - Your Project Is Ready For Review ('.$checksamelinkrow['project_name'].')';
    			$mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '
                <b>Dear '.$cca_row['contact_person'].',</b>
    			<p>We are pleased to inform you that the first draft of your video project by Surge Media is ready for review. <br/>
                The video draft has been uploaded to our Video Dash. <br/>
                Video Dash is an online video management and delivery system designed by Surge Media that makes your video production experience as smooth as possible. <br/>
                Please click on the link below to review your project.<br/>
    			<a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Review your project</a></p>
    			<p>Please review your project carefully and use the timestamp on the video to note down any changes you require on our Video Dash.</p>
                ';
            }else if($videoversion_num==2){
                $mailsubject = 'Surge Media Video Dash - Your Project Is Ready For Review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '
                <b>Dear '.$cca_row['contact_person'].',</b>
                <p>We are pleased to inform you that the changes have been amended and the second draft of your video project is ready for review.<br/>
                    The video draft has been uploaded to our Video Dash. <br/>
                    Video Dash is an online video management and delivery system designed by Surge Media that makes your video production experience as smooth as possible. <br/>
                    Please click on the link below to review your project.<br/>
                    <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">
                        Review your project
                    <a><br/>
                    Please be aware that you have one set of changes remaining. Charges may apply for additional changes.
                </p>
                <p>Please review your project carefully and use the timestamp on the video to note down any changes you require on our Video Dash.</p>
                ';
            }else{
                $mailsubject = 'Surge Media Video Dash - Your video draft is ready to review ('.$checksamelinkrow['project_name'].')';
                $mailtitle = 'Surge Media Video Dash';
                $mailsubtitle = 'Your project is ready for review';
                $mailmessage = '<b>Hi '.$cca_row['contact_person'].',</b>
                <p>We are pleased to inform you that your changes have been amended and a draft of your video project is ready for your review.</p>
                <p>The video draft has been uploaded to our Video Dash.</p>
                <p>Please click on the link below to review your project.<br/>
                <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Review your project</a></p>
                ';
            }

            //echo $_POST['downloadlink'].': '.$checksamelinkrow['download_file'];
            if($_POST['downloadlink']!=""){
                //echo $_POST['downloadlink'];
                if($_POST['downloadlink']!=$checksamelinkrow['download_file']){
                    //echo "UPDATE video_project SET download_file = ".$_POST['downloadlink']." WHERE id = ".$_POST['project_id'];
                    mysql_query("UPDATE video_project SET download_file = '".$_POST['downloadlink']."' WHERE id = ".$_POST['project_id']);
                    $mailsubject = 'Surge Media Video Dash - Your Project Is Ready';
                    $mailtitle = 'Surge Media Video Dash';
                    $mailsubtitle = 'Your project is ready';
                    $mailmessage = '
                    <p>Dear '.$cca_row['contact_person'].'</p>
                    <p>We are pleased to inform you that your final video ['.$checksamelinkrow['project_name'].'] by Surge Media is ready for download.<br/>
                    You can download the final video from our Video Dash by clicking on the link below.<br/>
                    <a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">Final Video</a><br/> 
                    Let us take this opportunity to thank you for choosing <a href="http://surgemedia.com.au">Surge Media</a>. <br/>
                    We look forward to working with you again.</p>
                    ';
                }
            }			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			$headers .="From: ". $name . " <" . $frommail . ">\r\n";
			
            $mail_data = file_get_contents('../email_template/video_download.html');
            $mail_data = str_replace("[mail_title]",  $mailtitle, $mail_data);
            $mail_data = str_replace("[mail_subtitle]",  $mailsubtitle, $mail_data);
            $mail_data = str_replace("[mail_content]",  $mailmessage, $mail_data);
            $the_data_is = date("d M Y");
            $mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);

			mail($mailto, $mailsubject, $mail_data, $headers);										

		}
	}
	$check_video_Lastupdate = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
	$check_video_Lastupdate_row = mysql_fetch_array($check_video_Lastupdate);
	$check_project_name = mysql_query("SELECT * FROM video_project WHERE  id =".$_POST['project_id']);
	$check_project_name_row = mysql_fetch_array($check_project_name);
	include('../inc/youtube_function.php');
?>

<!DOCTYPE html>
<html>
    <? include('../inc/head.php');?>
            <body class="">
                <? include('../inc/header.php'); ?>
                <main>
                
                <section class="container">
                    <h1 class="float-left container"><?=$message;?></h1>
                    <?php if($complete_msg): ?>
                        <?php echo $complete_msg; ?>
                    <?php endif; ?>
                    <form action="http://videodash.surgehost.com.au/all_projects.php" method="post" id="back_to_project">
                    	<input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                    </form>
                    
               
                <ul  >
                    <li id="add_new_video" class="video_obj featured">
                     <!-- <a onClick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> All Projects</h1></a> -->

                    	<form action="add_video.php" method="post" id="add_video">
                        <h1 id="client_name_editable" class="title">

                    	<input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                    	<input name="project_id" value="<?=$_POST['project_id'];?>" type="hidden"/>
                    	<input name="Add_videos" value="1" type="hidden"/>
                        <!-- <input type="text" value="Upload new video version"> -->
                        <!-- <i class="fa fa-edit"></i> -->
                        </h1>
                        <?php echo $error_msg;?>
                        <div class="section sixteen columns omega alpha">
                            <? $video_display_code = '//www.youtube.com/embed/KAYfuAROKV8';
								if($check_video_Lastupdate_row['video_link']!=""){
									$video_display_code = '//www.youtube.com/embed/'.cleanYoutubeLink($check_video_Lastupdate_row['video_link']);
                                    $showvideovalue = 'value="http://www.youtube.com/?v='.cleanYoutubeLink($check_video_Lastupdate_row['video_link']).'"';
								}
							?>

                        <input id="realtime_link" name="video_input" type="text" placeholder="Youtube link: http://www.youtube.com/?v=<?=$video_display_code;?>" class="video_link columns sixteen" <?php echo $showvideovalue; ?> >
                        <div id="put_new_youtube"></div>

                        <div class="video sixteen columns omega alpha">
                            <!-- VIMEO EMBED -->
                            <?if($check_video_Lastupdate_row['video_link']!=""){?>
                                <iframe id="calendar" src="<?php echo $video_display_code;?>" frameborder="0" allowfullscreen></iframe>
                            <? }else{ ?>
                                <i class="fa fa-video-camera blank_video"></i>
                            <? } ?>
                            <!-- VIMEO EMBED -->
<!--                        <script>
                        get_video('#video_input','#video_iframe');
                        </script>-->
                        </div>
                        </div>
                        <div class="actions sixteen columns omega alpha">
                        <div id="draft_version" class="draft_check"><input type="radio" name="version" value="Draft"  <? if($check_video_Lastupdate_row['version']!="Final"){ echo "checked";}?> ><span>Draft Version</span></div>
                        <div id="final_version" class="draft_check"><input type="radio" name="version" value="Final"  <? if($check_video_Lastupdate_row['version']=="Final"){ echo "checked";}?> ><span>Final Version</span></div>
                            <? if($check_video_Lastupdate_row['version']=="Final"){ ?>
                                <label class="title" for="">Download Video Link</label>
                                <input name="downloadlink" type="text" placeholder="Dropbox File Link" class="video_link sixteen columns omega alpha" value="<?php echo $check_project_name_row['download_file']?>">
                            <? } ?>
                            <label class="title" for="">Director's Notes</label>
                            <textarea name="notes" id="" cols="30" class="sixteen columns omega alpha" rows="10" placeholder="<?=$check_video_Lastupdate_row['notes'];?>">For the video draft, a low resolution version is rendered out for your review.
Please note that the picture and colour quality may look low quality.
The colour has not been graded and the audio has not been mastered.
The final version of your video project will be rendered out in high resolution.
Please watch the video carefully and note down any changes you require.</textarea>
                            <ul>
                                <li>
                                 <a onClick="document.getElementById('add_video').submit();" class="btn green" ><span>Send to Client</span> <i class="fa fa-send"></i></a>
                                </li>
                            </ul>
						</form>
                        </div>
                        
<!--                        <div id="changes_required">
                            <label class="title" for="">Your Notes</label>
                            <ul>
                                <li>
                                    <span class="timeline_picker">
                                    <label for="start">Start</label>
                                    <input type="text" value="0:00">
                                    </span>
                                    <span class="timeline_picker end">
                                    <label for="start">End</label>
                                    <input type="text" value="02:59">
                                    </span>
                                    <textarea name="" id="" cols="30" rows="5">
                                    </textarea>
                                </li>
                                <li>
                                    <span class="timeline_picker">
                                    <label for="start">Start</label>
                                    <input type="text" value="0:00">
                                    </span>
                                    <span class="timeline_picker end">
                                    <label for="start">End</label>
                                    <input type="text" value="02:59">
                                    </span>
                                    <textarea name="" id="" cols="30" rows="5">
                                    </textarea>
                                </li>

                            </ul>
                            <a href="#" id="new_timestamp" class="btn blue"><span>Add Another Time</span> <i class="fa fa-clock-o"></i></a>
                            <textarea name="" id="" cols="30" rows="5">Audio Comment:
                            </textarea>
                            <a id="new_timestamp" class="btn green"><span>Submit Notes</span> <i class="fa fa-send"></i></a>
                        </div>
-->                    </li>
                    


                </ul>
        
                   
                    <ul id="videos">
                    <?
						$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." ORDER BY enabling, version_num DESC");
						$video_num = mysql_num_rows($listvideos);
                        for($i=0; $i<$video_num; $i++){
							$video_row = mysql_fetch_array($listvideos);
                            $show_final_color = $show_final_msg = "";
                            if($video_row['version']=="Final"){
                                $show_final_color = 'style="background: none repeat scroll 0 0 rgba(200, 251, 141, 1);"';
                                $show_final_msg = "[Final]";
                            }
							$list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = ".$video_row ['id']);

							$list_video_client_request_num = mysql_num_rows($list_video_client_request);
							for($j=0; $j<$list_video_client_request_num; $j++){
                    $list_video_client_request_row = mysql_fetch_array($list_video_client_request);
                    $show_feedback_type = $list_video_client_request_row['feedback_type'];
                    if($list_video_client_request_row['feedback_type']==1){
                        $show_feedback_type = 'Changes To Video';
                        $show_feedback_type_class = 'changes-video';

                    }else if($list_video_client_request_row['feedback_type']==2){
                        $show_feedback_type = 'Changes To Audio';
                        $show_feedback_type_class = 'changes-audio';
                    }else if($list_video_client_request_row['feedback_type']==3){
                        $show_feedback_type = 'Other';
                        $show_feedback_type_class = 'changes-other';
                    }
                    $list_video_feedback[$i] .="
                    <li class='".$show_feedback_type_class."'><time>".$list_video_client_request_row['time_start']."&#47;".$list_video_client_request_row['time_end']."</time>
                    <small><b>".$show_feedback_type."</b>".$list_video_client_request_row['feedback']."</small></li>
                    ";//list all request information display in page
                    }
							$list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$video_row ['id']." ORDER BY id LIMIT 0, 1");
							$list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);

							if($list_video_client_addition_request_row['voice_comment']!="" || $list_video_feedback[$i]!=""){
                                if($i==0){
                                    echo '<li><h1>Current Drafts</h1></li>';
                                }
                                include('../inc/video-draft-object.php');
                                
                            }
						}
					?>
                    </ul>
                </section>
            </main>
            <? include('../footer.php');?>
            <div id="overlay_wrapper" onClick="closeAllCards()"></div>
        </body>
    </html>
<script>
    $(document).ready(function(){

        $("#realtime_link").keyup(function(){
            var query = $("#realtime_link").val();
            query2 = query.split("?v=").pop();
            document.getElementById('calendar').src = "//www.youtube.com/embed/"+query2;
        });
    });
</script> 