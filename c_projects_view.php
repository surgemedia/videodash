<? include("dbconnection_3evchey.php"); //connecting Database 
	$query_option = "";
	session_start();
	if($_GET['email']!=""){
		$_SESSION['email']=$_GET['email'];
	}
	$query_option = " WHERE email LIKE '".$_SESSION['email']."'";
	$check_client_active = mysql_query("SELECT * FROM Client_Information".$query_option." AND active_option = 1");
	$cca_num = mysql_num_rows($check_client_active);
	$cca_row = mysql_fetch_array($check_client_active);
	if($cca_num==0){
		header('location: /?failed=true');	
	}
	$message = "Add New Video Project";
	if($_POST['new_project_save']==1 && $_POST['project_name']!=""){//test data whether empty
		$query = mysql_query("INSERT INTO video_project VALUE(NULL, ".$_POST['client_id'].", '".$_POST['project_name']."', '".$_POST['client_request']."', ".$_POST['new_project_save'].")");
		if(!$query){
			$message = "Cannot Save this project to system.";
			exit;	
		}else{
			$message = "Success to insert data to database.";
		}
	}
	if($_GET['msg']=='D1'){
		$show_meg = '<label class="message " ><span>Sorry, We could send that email right now </span></label>';
	}
	if($_GET['msg']=='c1'){
		$show_meg = '<label class="message " ><span>Thank you. Your request has been sent to us. We will send you some information on each option within 24 hours.</span> <i class="fa fa-thumbs-up"></i> </label>';
	}
?>
<!DOCTYPE html>
<html>
<? include('inc/head.php');?>
<? include('inc/header.php');?>

            <body >
                <main class="container">

                <section id="search" class="center">
               <!--  <div id="dash_logo">
                	<h1>Video Dash</h1>
                </div> -->
                    <h1 class="">Your Projects</h1>  
                    <?php echo $show_meg;?>
                    <ul id="list" class="list">
                    <?
						//enable or del client
						if($_POST['completeid']!=""){		
							mysql_query("UPDATE video_project SET active_option = 2 WHERE id = ".$_POST['completeid']);
						}
						if($_POST['enableid']!=""){
							mysql_query("");
							mysql_query("UPDATE video_project SET active_option = 1 WHERE id = ".$_POST['enableid']);
						}
						$listproject = mysql_query("SELECT * FROM video_project WHERE active_option != 0 AND Client_id = ".$cca_row['id']." ORDER BY active_option");
						$project_num = mysql_num_rows($listproject);
						for($i=0; $i<$project_num; $i++){
							$project_row = mysql_fetch_array($listproject);
							$add_del_class = "";
							$del_btn = '<li><a href="#" class="btn blue " onclick="document.getElementById(\'del'.$i.'\').submit();"><span>Close Project</span><i class="fa fa-check" ></i></a></li>';
							if($project_row['active_option']==2	){
								$add_del_class = " bombed";
								$del_btn = '<li><a href="#" class="btn blue edit" onclick="document.getElementById(\'enable'.$i.'\').submit();"><span>Reopen Project</span><i class="fa fa-history" ></i></a></li>';
							}
							$last_video_under_project = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$project_row['id']." AND enabling = 1 ORDER BY id DESC LIMIT 0, 1");
							$last_video_under_project_num = mysql_num_rows($last_video_under_project);
							echo '
								<li class="client'.$add_del_class.'">
									<h2 class="title"><a onclick="document.getElementById(\'videoadd'.$i.'\').submit();">  '.$project_row['project_name'].'</a></h2>
									<form action="#" id="del'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="completeid"  value="'.$project_row['id'].'">
									</form>
									<form action="#" id="enable'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="enableid"  value="'.$project_row['id'].'">
									</form>
									<form action="video_views/client_view.java" id="videoadd'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="project_id"  value="'.$project_row['id'].'">
									</form>
									<div class="actions">
										<ul>
											<li>';
											if($last_video_under_project_num!=0){
												echo '
													<a class="btn yellow add_new" onclick="document.getElementById(\'videoadd'.$i.'\').submit();"><span>View Video</span> <i class="fa fa-youtube-play"></i></a>
												';
											}else{
												echo '
													<a class="btn yellow add_new"><span>Please be patient. Your first video draft is uploading.</span> <i class="fa fa fa-clock-o"></i></a>
												';												
											}
							echo '</li>
											
										</ul>
									</div>
								</li>
							';
						}
					?>
                    </ul>
                </section>
            </main>
            <? include('inc/footer.php');?>
        </body>
    </html>