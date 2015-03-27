<? include("dbconnection_3evchey.php"); //connecting Database 
	include("login.php");
?>
<!DOCTYPE html>
<html>
			<? include('inc/head.php');?>
            <body class="">
				<? include('inc/header.php'); ?>
                <main>
                <section id="search" class="center">
                    <h1 class="">Not comment Projects</h1>  
                    <form action="add_project.php" id="projectadd" method="post">
                        <input type="hidden" name="client_id"  value="<?=$_POST['client_id'];?>">
                    </form>
                    <div class="controls">
                    	<a class="blue btn" onclick="window.history.back();"><span>Back</span><i class="fa fa-reply"></i></a>

                     <!-- <a onClick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> Back</h1></a> -->
                    
                    </div>
                    <input type="text" id="searchbox" class="search wow bounceIn">
                    <ul id="list" class="list">
					<?php
                    /*=======================================*/
                    /*         Get Feedback Deadline         */
                    /*=======================================*/							
                        function check_deadline($function_v_project_id, $version, $mode){
                            $check_deadline = mysql_query("SELECT upload_time FROM video_under_project WHERE video_project_id = ".$function_v_project_id." AND version LIKE '".$version."' AND enabling = 1 ORDER BY id LIMIT 0, 1");
                            $check_deadline_row = mysql_fetch_array($check_deadline);
                             $now = time(); // or your date as well
                             $data_format = substr($check_deadline_row['upload_time'], 0, 10);
                             $upload_date = strtotime($data_format);
                             $datediff = $now - $upload_date;
                             if($mode == "deadline"){
                                return 21 - floor($datediff/(60*60*24));
                             }else{
                                return date('d-F-Y', strtotime($check_deadline_row['upload_time']));
                             }
                             //return  $data_format ;
                        }
                    ?>
                    <?
						//enable or del client
						if($_POST['delid']!=""){		
							mysql_query("UPDATE video_project SET active_option = 0 WHERE id = ".$_POST['delid']);
						}
						$listproject = mysql_query("SELECT VP.active_option AS active_option, VP.id AS id, VP.Client_id AS Client_id, VP.project_name AS project_name FROM video_project AS VP LEFT JOIN Client_Information AS CI ON VP.Client_id = CI.id WHERE CI.active_option = 1 AND VP.active_option = 1");
						$project_num = mysql_num_rows($listproject);
						for($i=0; $i<$project_num; $i++){
							$project_row = mysql_fetch_array($listproject);
							$add_del_class = "";
							$del_btn = '<li><a href="#" class="btn red edit" onclick="document.getElementById(\'del'.$i.'\').submit();"><span>Delete</span><i class="fa fa-bomb" ></i></a></li>';
							if($project_row['active_option']==0){
								$add_del_class = " bombed";
								$del_btn = '<li><a href="#" class="btn blue edit" onclick="document.getElementById(\'enable'.$i.'\').submit();"><span>Enable</span><i class="fa fa-history" ></i></a></li>';
							}
							$check_non_comment = mysql_query("SELECT * FROM video_under_project WHERE version LIKE 'Final' AND video_project_id = ".$project_row['id']);
							if(mysql_num_rows($check_non_comment)){
								
							}else{
								$check_non_comment2 = mysql_query("SELECT * FROM video_under_project WHERE version LIKE 'Draft2' AND video_project_id = ".$project_row['id']);
								$check_non_comment_row = mysql_fetch_array($check_non_comment2);
								if($check_non_comment_row['version']=='Draft2'){
									$class_v_add ='Draft2';
								}else{
									$class_v_add ='Draft';
								}
								$outdateing = check_deadline($project_row['id'], $class_v_add, "deadline");
								if($class_v_add == 'Draft'){
									$check_avaliable = mysql_query("SELECT * FROM  video_under_project WHERE version LIKE 'Draft' AND video_project_id = ".$project_row['id']);
									$check_avaliable_num = mysql_num_rows($check_avaliable);
								}
								if($class_v_add == 'Draft' && $check_avaliable_num==0){
									
								}else{
									echo '
										<li class="client'.$add_del_class.'">
											<h2 class="title"><a onclick="document.getElementById(\'videoadd'.$i.'\').submit();">  '.$project_row['project_name'].'['.$class_v_add.': OVER '.$outdateing.' days not comments.]</a></h2>
											<form action="#" id="del'.$i.'" method="post">
												<input type="hidden" name="delid"  value="'.$project_row['id'].'">
											</form>
											<form action="video_views/add_video.php" id="videoadd'.$i.'" method="post">
												<input type="hidden" name="client_id"  value="'.$project_row['Client_id'].'">
												<input type="hidden" name="project_id"  value="'.$project_row['id'].'">
											</form>
											<div class="actions">
												<ul>';
									if($add_del_class != " bombed"){				
										echo '<li><a class="btn green add_new" onclick="document.getElementById(\'videoadd'.$i.'\').submit();"><span>New Video</span> <i class="fa fa-video-camera"></i></a></li>';
									}
									echo $del_btn.'
												</ul>
											</div>
										</li>
									';
								}
							}
						}
					?>
                    </ul>
                   
                   <!--  
											<li><a class="btn grey edit" onclick="document.getElementById(\'edit'.$i.'\').submit();"><span>Edit</span><i class="fa fa-edit"></i></a></li>
                    -->
                </section>
            </main>
				<? include('inc/footer.php');?>
        </body>
    </html>