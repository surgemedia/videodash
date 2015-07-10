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
	$message = "My Dashboard";
	if($_POST['Add_Comments']==1 && $_POST['project_id']!=""){//test data whether empty
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
		}
	}
	$check_video_Lastupdate = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
	$check_video_Lastupdate_row = mysql_fetch_array($check_video_Lastupdate);
	$check_project_name = mysql_query("SELECT * FROM video_project WHERE  id =".$_POST['project_id']);
	$check_project_name_row = mysql_fetch_array($check_project_name);
	
	$last_video_comment = mysql_query("SELECT * FROM video_client_addition_request WHERE video_id = ".$check_video_Lastupdate_row['id']." ORDER BY id DESC LIMIT 0, 1");
	$last_video_comment_row = mysql_fetch_array($last_video_comment);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Dashboard</title>
        <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js">
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css">
                <link rel="stylesheet" href="/css/layout.css">
                <link rel="stylesheet" href="/css/skeleton.css">
                <link rel="stylesheet" href="/css/style.css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script type="text/javascript" src="/js/jquery.backgroundvideo.min.js"></script>
                <script type="text/javascript" src="/js/wow.min.js"></script>
                <script type="text/javascript" src="/js/website.js"></script>
            </head>
            <body class="">
                <header>
                    <div class="center wow fadeInDown">
                        <div class="logo"><img src="" alt=""></div>
                        <nav>
                            <ul class="nav">
                                <li><a href="/home_video.html">Home</a></li>
                                <li><a href="/home_video.html">Clients</a></li>
                                <li><a href="/home_video.html">Contact</a></li>

                            </ul>
                        </nav>
                    </div>
                </header>
            <form action="http://videodash.surgehost.com.au/c_projects_view.php" method="post" id="back_to_project">
                <input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
            </form>
                <main>
                <form action="#" method="post" id="add_all_comments">
                <section class="center">
                    <h1 class="float-left"><?=$message;?></h1>
                     <a onclick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i>All My Video Projects</h1></a>
                    <div id="preproduction">
                        <h2>Preproduction</h2>
                        <ul>
                            <li class="section">
                                <div>
                                    <span>Script</span>
                                    <ul>
                                        <li><span>1</span><input type="checkbox" name="script1" value="1" <? if($last_video_comment['script1']==1){ echo 'checked="checked"';}?>></li>
                                        <li><span>2</span><input type="checkbox" name="script2" value="1" <? if($last_video_comment['script2']==1){ echo 'checked="checked"';}?>></li>
                                    </ul>

                                </div>
                                <div>
                                    <span>Logos and Images</span>
                                    <ul>
                                        <li><span>email</span><input type="checkbox" name="logoandimage_email" value="1"  <? if($last_video_comment['logoandimage_email']==1){ echo 'checked="checked"';}?>></li>
                                        <li><span>dropbox</span><input type="checkbox" name="logoandimage_dropbox" value="1"  <? if($last_video_comment['logoandimage_dropbox']==1){ echo 'checked="checked"';}?>></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="section">

                                <span>Voice Over Info</span>
                                <div id="voice_choice">
                                <select name="voice_id" id="voice_id">
                                	<option value="" selected="selected">No Audio Presenter</option>
                                	<?
										$voice_id = mysql_query("SELECT * FROM voice_talent WHERE avaliable = 1");
										$voice_id_num = mysql_num_rows($voice_id);
										for($i=0; $i<$voice_id_num; $i++){
											$voice_id_row = mysql_fetch_array($voice_id);
											$selected = "";
											if($voice_id_row['id']==$last_video_comment['voice_id']){
												$selected = ' selected="selected"';
											}
											echo '<option value="'.$voice_id_row['id'].'"'.$selected.'>'.$voice_id_row['voice_name'].'</option>';
										}
									?>
                                </select>
                                <span id="chosen">Adam</span>
                            </div>
                            <div id="voice_comment">
                                <textarea name="voice_comment" id="" cols="30" rows="10"></textarea>
                            </div>
                        </li>
                        <li class="section contact">

                            <span>Contact Info</span>
                            <input name="contact_info1" value="<?=$last_video_comment['contact_info1'];?>">
                            <input name="contact_info2" value="<?=$last_video_comment['contact_info2'];?>">
                            <input name="contact_info3" value="<?=$last_video_comment['contact_info3'];?>">
                            <input name="contact_info4" value="<?=$last_video_comment['contact_info4'];?>">
                        </li>
                    </ul>
                </div>
                <!-- <input type="text" id="searchbox" class="search wow bounceIn"> -->
                <ul id="videos" >
                    <li class="video_obj featured">
                    	<input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                    	<input name="project_id" value="<?=$_POST['project_id'];?>" type="hidden"/>
                    	<input name="Add_Comments" value="1" type="hidden"/>

                        <h1 class="title">
                        <?=$check_project_name_row['project_name']?> - <span>Draft <?=$check_video_Lastupdate_row['version_num'];?></span>
                        </h1>
                        <div class="video">
                            <!-- VIMEO EMBED -->
                            <iframe width="560" height="315" src="//www.youtube.com/embed/<?=$check_video_Lastupdate_row['video_link'];?>" frameborder="0" allowfullscreen></iframe>
                            <!-- VIMEO EMBED -->
                        </div>

                        <div id='action_box' class="actions">
                            <label class="title" for="">Director's Notes</label>
                            <textarea disabled="true" name="" id="" cols="30" rows="10"><?=$check_video_Lastupdate_row['notes'];?></textarea>
                            <ul>
                                <li><a id="required_button" href="javascript:void(0)" class="btn red"><span>Changes Required</span> <i class="fa fa-refresh"></i></a></li>
                                <li><a href="#" class="btn yellow"><span>Final Video</span><i class="fa fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div id="changes_required">
                            <label class="title" for="">Your Notes</label>
                            <ul class="showjqloop">
                            	<script type="text/javascript">
									var loop_counter = 2;
									for(var i=0; i<loop_counter; i++){
										document.write('<li> <span class="timeline_picker"> <label for="start">Start</label> <input type="text" value="0:00"> </span> <span class="timeline_picker end"> <label for="start">End</label> <input type="text" value="02:59"> </span> <textarea name="" id="" cols="30" rows="5"></textarea></li>');
									}
									var shownumber = 0;
									function loop_num_add(add_number){
										shownumber = loop_counter + add_number;
									}
									$(document).ready(loop_num_add);
								</script>
                            </ul>

                            <a id="Add_Another_Time" class="btn blue" onClick="loop_num_add(1);"><span>Add Another Time
                            <script type="text/jscript">
								document.write(shownumber);
							</script>
                            </span> <i class="fa fa-clock-o"></i></a>
                            <textarea name="audio_comment" id="" cols="30" rows="5">Audio Comment:</textarea>
                            <a id="new_timestamp" class="btn green" onclick="document.getElementById('add_all_comments').submit();"><span>Submit Notes</span> <i class="fa fa-send"></i></a>
                        </div>
                    </li>
              </ul>
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
            </section>
        </form>
                <section id="search" class="center">
                    <li><h1>Previous Versions</h1></li>
                    <ul id="videos">
                    <?
						$listvideos = mysql_query("SELECT * FROM video_under_project WHERE  video_project_id =".$_POST['project_id']." ORDER BY enabling, version_num DESC");
						$video_num = mysql_num_rows($listvideos);
						for($i=0; $i<$video_num; $i++){
							$video_row = mysql_fetch_array($listvideos);
							echo '
								<li class="video_obj">
									<span class="ver_number">'.$video_row['version_num'].'</span>
									<h3 class="title">'.$check_project_name_row['project_name'].'</h3>
									<div class="video draft">
										<iframe width="500" height="400" src="//www.youtube.com/embed/'.$video_row['video_link'].'" frameborder="0" allowfullscreen></iframe>
									</div>
									<div class="feedback_wrapper">
										<h4>Notes</h4>
										<ul class="pasttimestamps">
											<li>Your Notes<small>'.$video_row['notes'].'</small></li>
											<li>Client feedback<small></small></li>
										</ul>
										<span class="audio_comment">
										Audio Comment: Add Canned Llama Sounds
										</span>
									</div>
								</li>
							';
						}
					?>
                    </ul>
                </section>
            </main>
            <footer>
                <div class="logo"><img src="" alt=""></div>
                <nav>
                    <ul class="nav">
                        <li>
                            <a href="#"></a>
                            <a href="#"></a>
                            <a href="#"></a>
                            <a href="#"></a>
                            <a href="#"></a>
                        </li>
                    </ul>
                </nav>

            </footer>
        </body>
    </html>
 