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
	if($_POST['Add_videos']==1 && $_POST['project_id']!=""){//test data whether empty
		$check_total_version = mysql_query("SELECT * FROM video_under_project WHERE video_project_id =".$_POST['project_id']);
		$check_total_version_num = mysql_num_rows($check_total_version);
		echo $check_total_version_num;
		$videoversion_num = $check_total_version_num+1;
		$query = mysql_query("INSERT INTO video_under_project VALUE(NULL, ".$_POST['project_id'].", '".$_POST['video_input']."', '".$_POST['version']."', '".$_POST['notes']."', 1, ".$videoversion_num.")");
		if(!$query){
			$message = "Cannot Save this Video to Project.";
			exit;	
		}else{
			$message = "Success to insert data to database.";
			$name = "Surge Media - Video Dash";
			$frommail = "cs@videodash.surgehost.com.au";
			$mailto = 'webproduction@surgemedia.com.au'; // $cca_row['email'];
			$mailsubject = 'Your Video was completed!';
			$mailmessage = '<p>Dear '.$cca_row['contact_person'].'</p>
			<p>We are completely to edit your video. Please login to:<br/>
			<a href="http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'">http://videodash.surgehost.com.au/c_projects_view.php?email='.$cca_row['email'].'</a> to take a look and make comments.</p>
			<p>Kind Regards</p>
			<p>Video Dash @ Surge Media</p>
			';			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			$headers .="From: ". $name . " <" . $frommail . ">\r\n";
			
			mail($mailto, $mailsubject, $mailmessage, $headers);										

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
                    <h1 class="float-left"><?=$message;?></h1>
                    <form action="http://videodash.surgehost.com.au/all_projects.php" method="post" id="back_to_project">
                    	<input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                    </form>
                     <a onClick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> All Projects</h1></a>
                    
               
                <ul  >
                    <li id="add_new_video" class="video_obj featured">
                    	<form action="add_video.php" method="post" id="add_video">
                        <h1 id="client_name_editable" class="title">
                    	<input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                    	<input name="project_id" value="<?=$_POST['project_id'];?>" type="hidden"/>
                    	<input name="Add_videos" value="1" type="hidden"/>
                        <!-- <input type="text" value="Upload new video version"> -->
                        <!-- <i class="fa fa-edit"></i> -->
                        </h1>
                        <div class="section sixteen columns omega alpha">
                            <? $video_display_code = 'KAYfuAROKV8';
								if($check_video_Lastupdate_row['video_link']!=""){
									$video_display_code = cleanYoutubeLink($check_video_Lastupdate_row['video_link']);
								}
							?>
                        <input name="video_input" type="text" placeholder="Youtube link: http://www.youtube.com/?v=<?=$video_display_code.$check_video_Lastupdate_row['video_link'];?>" class="video_link">
                        <div class="video sixteen columns omega alpha">
                            <!-- VIMEO EMBED -->
                            <iframe  src="//www.youtube.com/embed/<?=$video_display_code;?>" frameborder="0" allowfullscreen></iframe>
                            <!-- VIMEO EMBED -->
<!--                        <script>
                        get_video('#video_input','#video_iframe');
                        </script>-->
                        </div>
                        </div>
                        <div class="actions sixteen columns omega alpha">
                        <div id="draft_version" class="draft_check"><input type="checkbox" name="version" value="Draft"  <? if($check_video_Lastupdate_row['version']=="Draft"){ echo "checked";}?> ><span>Draft Verison</span></div>
                        <div id="draft_version2" class="draft_check"><input type="checkbox" name="version" value="Draft2" <? if($check_video_Lastupdate_row['version']=="Draft2"){ echo "checked";}?> ><span>Draft 2 Verison</span></div>
                        <div id="final_version" class="draft_check"><input type="checkbox" name="version" value="Draft"  <? if($check_video_Lastupdate_row['version']=="Draft"){ echo "checked";}?> ><span>Final Verison</span></div>
                            <label class="title" for="">Director's Notes</label>
                            <textarea name="notes" id="" cols="30" rows="10" placeholder="<?=$check_video_Lastupdate_row['notes'];?>"></textarea>
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
                    <li><h1>Previous Versions</h1></li>
                    <?
						$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." ORDER BY enabling, version_num DESC");
						$video_num = mysql_num_rows($listvideos);
						for($i=0; $i<$video_num; $i++){
							$video_row = mysql_fetch_array($listvideos);
							$list_video_client_request = mysql_query("SELECT * FROM video_client_request WHERE video_id = ".$video_row ['id']);

							$list_video_client_request_num = mysql_num_rows($list_video_client_request);
							for($j=0; $j<$list_video_client_request_num; $j++){
								$list_video_client_request_row = mysql_fetch_array($list_video_client_request);
								$list_video_feedback[$i] .="
									<li><time>".$list_video_client_request_row['time_start']."&#47;".$list_video_client_request_row['time_end']."</time><small>".$list_video_client_request_row['feedback']."</small></li>
								";
							}
							$list_video_client_addition_request = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$video_row ['id']." ORDER BY id LIMIT 0, 1");
							$list_video_client_addition_request_row = mysql_fetch_array($list_video_client_addition_request);
							echo '
								<li class="video_obj five columns" onclick="expandCard($(this))">
									<span class="ver_number">'.$video_row['version_num'].'</span>
									<h3 class="title">'.$check_project_name_row['project_name'].'</h3>
									<div class="video draft">
										<iframe width="500" height="400" src="//www.youtube.com/embed/'.cleanYoutubeLink($video_row['video_link']).'" frameborder="0" allowfullscreen></iframe>
									</div>
									<div class="feedback_wrapper">
										<h4>Notes</h4>
										<ul class="pasttimestamps">
											<li>Your Notes<small>'.$video_row['notes'].'</small></li>
											<li>Client feedback<small></small></li>
											'.$list_video_feedback[$i].'
										</ul>
										
									</div>
                                    <span class="audio_comment">
                                        '.$list_video_client_addition_request_row['audio_comment'].'
                                    </span>
								</li>
							';
						}
					?>
                    </ul>
                </section>
            </main>
            <? include('../footer.php');?>
            <div id="overlay_wrapper" onclick="closeAllCards()"></div>
        </body>
    </html>
 