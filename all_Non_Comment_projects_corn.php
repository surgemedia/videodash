<? include("dbconnection_3evchey.php"); //connecting Database 
?>
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
									
									$message = '
										<tr>
											<th>'.$project_row['project_name'].'</th>
											<th>'.$class_v_add.'</th>
											<th>OVER '.$outdateing.' days</th>
										</tr>
									';
									
								}
							}
						}
						if($message!=""){
							$name = "Surge Media - Over Deadlie";
							$frommail = "cs@videodash.surgehost.com.au";
							$mailto = 'webproduction@surgemedia.com.au'; // $cca_row['email'];
							$mailsubject = 'Video without comments over 3 weeks';
							$headers = "MIME-Version: 1.0\r\n";
							$headers .= "Content-type: text/html; charset=utf-8\r\n";						
							$headers .="From: ". $name . " <" . $frommail . ">\r\n";
							$mail_message = '
									<p>Below Video Project already over 3 weeks without any comments</p>
									<table>
										<tr>
											<th>Project Name</th>
											<th>Project Version</th>
											<th>Overrun time</th>
										</tr>
										'.$message.'
									</table>
							';
							$mail_data = file_get_contents('email_template/mail_template.html');
							$mail_data = str_replace("[mail_title]",  $mailsubject, $mail_data);
							$mail_data = str_replace("[mail_content]",  $mail_message, $mail_data);
							$the_data_is = date("d M Y");
							$mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);

							mail($mailto, $mailsubject, $mail_data, $headers);	
						}
					?>
