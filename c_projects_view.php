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
		header("location: index.php");	
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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Dashboard</title>
        <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
          <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,400italic' rel='stylesheet' type='text/css'>
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
                <main>

                <section id="search" class="center">
               <!--  <div id="dash_logo">
                	<h1>Video Dash</h1>
                </div> -->
                    <h1 class="">Your Projects</h1>  
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
						$listproject = mysql_query("SELECT * FROM video_project WHERE active_option != 0 ORDER BY active_option");
						$project_num = mysql_num_rows($listproject);
						for($i=0; $i<$project_num; $i++){
							$project_row = mysql_fetch_array($listproject);
							$add_del_class = "";
							$del_btn = '<li><a href="#" class="btn yellow edit" onclick="document.getElementById(\'del'.$i.'\').submit();"><span>Confirmed</span><i class="fa fa-star" ></i></a></li>';
							if($project_row['active_option']==2	){
								$add_del_class = " bombed";
								$del_btn = '<li><a href="#" class="btn blue edit" onclick="document.getElementById(\'enable'.$i.'\').submit();"><span>Enable</span><i class="fa fa-history" ></i></a></li>';
							}
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
									<form action="video_views/client_view.php" id="videoadd'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$cca_row['id'].'">
										<input type="hidden" name="project_id"  value="'.$project_row['id'].'">
									</form>
									<div class="actions">
										<ul>
											<li><a class="btn green add_new" onclick="document.getElementById(\'videoadd'.$i.'\').submit();"><span>View Video</span> <i class="fa fa-video-camera"></i></a></li>
											'.$del_btn.'
										</ul>
									</div>
								</li>
							';
						}
					?>
                    </ul>
                </section>
            </main>
            <? include('../inc/footer.php');?>
        </body>
    </html>