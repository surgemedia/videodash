<? include("dbconnection_3evchey.php"); //connecting Database 
	include("login.php");

	$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
	$cca_num = mysql_num_rows($check_client_active);
	$cca_row = mysql_fetch_array($check_client_active);
	if($cca_num==0){
		header("location: home_video.php");	
	}
	$message = "Add New Video Project";
	if($_POST['new_project_save']==1 && $_POST['project_name']!=""){//test data whether empty
		$query = mysql_query("INSERT INTO video_project VALUE(NULL, ".$_POST['client_id'].", '".$_POST['project_name']."', '".$_POST['client_request']."', 1, '')");
		if(!$query){
			$message = "Cannot Save this project to system.";
			exit;	
		}else{
			$message = "Success to insert data to database.";
		}
	}
?>
<!DOCTYPE html>
<html>
			<? include('inc/head.php');?>
            <body class="">
				<? include('inc/header.php'); ?>
                <main class="container">
                <section id="search" class="center">
                    <h1 class=""><?php echo $cca_row['company_name']; //Display company name?> Projects</h1>  
                    <form action="add_project.php" id="projectadd" method="post">
                        <input type="hidden" name="client_id"  value="<?=$_POST['client_id'];?>">
                    </form>
                    <div class="controls">
                    	<a class="blue btn" onclick="window.history.back();"><span>Back</span><i class="fa fa-reply"></i></a>

                    	<a class="blue btn" onclick="document.getElementById('projectadd').submit();"><span>Add New Project</span><i class="fa fa-archive"></i></a>

                     <!-- <a onClick="document.getElementById('back_to_project').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> Back</h1></a> -->
                    
                    </div>
                    <input type="text" id="searchbox" class="search wow bounceIn">
                    <ul id="list" class="list">
                    <?
						//enable or del client
						if($_POST['delid']!=""){		
							mysql_query("UPDATE video_project SET active_option = 0 WHERE id = ".$_POST['delid']);
						}
						if($_POST['enableid']!=""){
							mysql_query("");
							mysql_query("UPDATE video_project SET active_option = 1 WHERE id = ".$_POST['enableid']);
						}
						$listproject = mysql_query("SELECT * FROM video_project WHERE Client_id = ".$_POST['client_id']." ORDER BY active_option DESC ,id DESC");
						$project_num = mysql_num_rows($listproject);
						for($i=0; $i<$project_num; $i++){
							$project_row = mysql_fetch_array($listproject);
							$history = mysql_query("SELECT * FROM video_under_project WHERE video_project_id = ".$project_row['id']); 
							$history_num = mysql_num_rows($history);
							$history_li_tag="";
							for($k=0; $k<$history_num; $k++){
								$history_row = mysql_fetch_array($history);
								$date=date_create($history_row['upload_time']);
								
								$history_li_tag.="<li>
																		<span>".$history_row['version']."-".$history_row['version_num'].", </span>
																		<b>".date_format($date,"d/m/Y H:i:s")."</b>
																		 </li>";
							}
							$add_del_class = "";
							$del_btn = '<li><a href="#" class="btn red edit" onclick="document.getElementById(\'del'.$i.'\').submit();"><span>Close </span><i class="fa fa-bomb" ></i></a></li>';
							if($project_row['active_option']==0){
								$add_del_class = " bombed";
								$del_btn = '<li><a href="#" class="btn blue edit" onclick="document.getElementById(\'enable'.$i.'\').submit();"><span>Reopen Project</span><i class="fa fa-history" ></i></a></li>';
							}
							echo '
								<li class="client'.$add_del_class.'">
									<h2 class="title"><a onclick="document.getElementById(\'videoadd'.$i.'\').submit();">  '.$project_row['id'].'.) '.$project_row['project_name'].'</a><ul class="history">'.$history_li_tag.'</ul></h2>
									<form action="#" id="del'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="delid"  value="'.$project_row['id'].'">
									</form>
									<form action="#" id="enable'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="enableid"  value="'.$project_row['id'].'">
									</form>
									<form action="edit_project.php" id="edit'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="project_id"  value="'.$project_row['id'].'">
									</form>
									<form action="video_views/add_video.php" id="videoadd'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="project_id"  value="'.$project_row['id'].'">
									</form>
									<div class="actions">
										<ul>';
							if($add_del_class != " bombed"){				
								echo '<li><a class="btn blue add_new" onclick="document.getElementById(\'videoadd'.$i.'\').submit();"><span>Add New Video</span> <i class="fa fa-video-camera"></i></a></li>';
							}
							echo $del_btn.'
										</ul>
									</div>
								</li>
							';
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