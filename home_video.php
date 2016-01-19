<? 
	include("dbconnection_3evchey.php"); //connecting Database 
	include("login.php");
?>
<?
	//enable or del client
	if($_POST['delid']!=""){		
		mysql_query("UPDATE Client_Information SET active_option = 0 WHERE id = ".$_POST['delid']);
	}
	if($_POST['enableid']!=""){
		mysql_query("");
		mysql_query("UPDATE Client_Information SET active_option = 1 WHERE id = ".$_POST['enableid']);
	}
?>
<!DOCTYPE html>
<html>
			<? include('inc/head.php');?>
            <body class="">
				<? include('inc/header.php'); ?>
                <main>
                <section id="search" class="center">
                    <h1 class="">Our Clients</h1>  
                    <div class="controls">
                        <a href="video_views/add_client.php" class="blue btn">Add New Client  <i class="fa fa-plus"></i></a>
                        <a href="all_Non_Comment_projects.php" class="blue btn">All Expired Video  <i class="fa fa-exclamation-triangle"></i></a>
                    </div>
                    <input type="text" id="searchbox" class="search wow pulse">

                    <ul id="list" class="list">
                    <?
						$listclient = mysql_query("SELECT * FROM Client_Information ORDER BY active_option DESC");
						$client_num = mysql_num_rows($listclient);
						for($i=0; $i<$client_num; $i++){
							$client_row = mysql_fetch_array($listclient);
							$add_del_class = "";
							$del_btn = '<li><a href="#" class="btn red edit" onclick="document.getElementById(\'del'.$i.'\').submit();"><span>Delete</span><i class="fa fa-bomb" ></i></a></li>';
							if($client_row['active_option']==0){
								$add_del_class = " bombed";
								$del_btn = '<li><a href="#" class="btn blue edit" onclick="document.getElementById(\'enable'.$i.'\').submit();"><span>Reopen Client</span><i class="fa fa-history" ></i></a></li>';
							}
							echo '
								<li class="client'.$add_del_class.'" >
									<img src="'.$client_row['company_icon'].'" alt="" height="50" width="50">
									<h2 class="title"><a onclick="document.getElementById(\'videoadd'.$i.'\').submit();">'.$client_row['id'].'). '.$client_row['company_name'].'</a></h2>
									<form action="#" id="del'.$i.'" method="post">
										<input type="hidden" name="delid"  value="'.$client_row['id'].'">
									</form>
									<form action="#" id="enable'.$i.'" method="post">
										<input type="hidden" name="enableid"  value="'.$client_row['id'].'">
									</form>
									<form action="video_views/edit_client.php" id="edit'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$client_row['id'].'">
									</form>
									<form action="all_projects.php" id="videoadd'.$i.'" method="post">
										<input type="hidden" name="client_id"  value="'.$client_row['id'].'">
									</form>
									<div class="actions">
										<ul>
											';
							if($add_del_class != " bombed"){				
								echo '
									<li><a class="btn green add_new" onclick="document.getElementById(\'videoadd'.$i.'\').submit();"><span>View Projects</span> <i class="fa fa-eye"></i></a></li>
									<li><a class="btn yellow edit" onclick="document.getElementById(\'edit'.$i.'\').submit();"><span>Edit</span><i class="fa fa-edit"></i></a></li>
								';
							}
							echo $del_btn.'
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