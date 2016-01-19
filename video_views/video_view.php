<?php

/*===========================================
=            Database Connection            =
===========================================*/
include ("../dbconnection_3evchey.php");
 //connecting Database
session_start();
    // $client_id = '15';
    $client_id = $_GET['ci'];
    // $project_id = '92';
    $project_id = $_GET['pi'];

$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = " . $client_id . " AND active_option = 1");
$cca_row = mysql_fetch_array($check_client_active);

$projectname = mysql_query("SELECT * FROM video_project WHERE id = " . $project_id);
$projectname_row = mysql_fetch_array($projectname);


    if ($projectname_row['download_file'] != "") {
        $downloadfilelink2 = '
<a href="' . $projectname_row['download_file'] . '" class="btn green wow omega alpha" ><span>Download Your Videos Here</span><i class="fa fa-download"></i></a>';
        $downloadfilelink = '';
    } 

?>
<!DOCTYPE html>
<html>
	<?php
include ('../inc/head.php'); ?>
	<body class="">
    	<main>
		    <section class="container">
				<h1 class="title"><?php echo $cca_row['company_name']; ?> - <?php echo $projectname_row['project_name'] ?> </h1>
                <div id="download_message" class="light_blue_box">
					<?php echo $downloadfilelink2; ?>
                </div>
            </section>
		</main>
		<?php include ('../footer.php'); ?>
		<div id="overlay_wrapper" onClick="closeAllCards()"></div>
	</body>
</html>