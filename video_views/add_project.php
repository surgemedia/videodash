<? include("dbconnection_3evchey.php"); //connecting Database 
    include("login.php");
    if($_POST['client_id']==''){
        header("location: home_video.php"); 
    }
    $check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
    $cca_num = mysql_num_rows($check_client_active);
    $cca_row = mysql_fetch_array($check_client_active);
    if($cca_num==0){
        header("location: home_video.php"); 
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
            <? include('inc/head.php');?>
            <body class="">
                <? include('inc/header.php'); ?>
                <main>
                <section class="center">
                    <h1 class="float-left"><?=$message;?></h1>
                    <form action="all_projects.php" id="allprojects" method="post">
                        <input type="hidden" name="client_id"  value="<?=$_POST['client_id'];?>">
                    </form>
                     <a onclick="document.getElementById('allprojects').submit();"><h1 class="back_button"><i class="fa  fa-reply"></i> Client's Projects</h1></a>
                    
                <form action="all_projects.php" method="post" id="video_projects_add"> 
                <ul id="videos" >
                    <li id="add_new_video" class="video_obj featured autoHeight">
                       <!--  <h1 id="client_name_editable" class="title"> -->
                        <input name="client_id" value="<?=$cca_row['id'];?>" type="hidden"/>
                        <input name="new_project_save" value="1" type="hidden"/>
                        <!-- <input value="Add new video project to: <?=$cca_row['company_name'];?>"/> -->
                        <!-- <i class="fa fa-edit"></i> -->
                        <!-- </h1> -->
                        <div class="project_name">
                        <input name="project_name" type="text" placeholder="Project Name:" class="video_link"/>

                        </div>
                        <div class="actions container">
                            <ul>
                                <li>
                                <a id="send_video_client" href="#" class="btn green" onclick="document.getElementById('video_projects_add').submit();"><span>Add New Project</span> <i class="fa fa-send"></i></a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>
                </ul>
                </form>
            </section>
            </main>
                <? include('inc/footer.php');?>
        </body>
    </html>