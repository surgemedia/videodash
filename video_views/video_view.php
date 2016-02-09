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
<a href="' . $projectname_row['download_file'] . '"id="download_button" class="btn yellow wow" ><span>Download Your Videos Here</span><i class="fa fa-download"></i></a>';
        $downloadfilelink = '';
    } 

?>
<!DOCTYPE html>
<html>
	<?php
include ('../inc/head.php'); ?>
	<body class="">
    	<main>
		    <section id="download_center" class="container">
				<h1 class="title main">
                <span class="first"> <?php echo $cca_row['company_name']; ?></span>
                <span><?php echo $projectname_row['project_name'] ?></span> 
                 </h1>
                <p>Your final video download</p>

					<?php echo $downloadfilelink2; ?>
                    <small><span>my  zip won't open? </span><a href="http://www.kekaosx.com/en/">Mac</a> | <a href="http://www.7-zip.org/download.html">Windows</a></small>
            </section>
		</main>
		<?php include ('../inc/footer.php'); ?>
		<div id="overlay_wrapper" onClick="closeAllCards()"></div>
	</body>
</html>