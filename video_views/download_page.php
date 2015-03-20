<? include("../dbconnection_3evchey.php"); //connecting Database
session_start();
if(!$_SESSION['email']){
	echo 'Login Timeout, Please login again';
	exit;
}
//echo $_GET['file'];
$check_link = mysql_query("SELECT * FROM video_project WHERE id = ".$_GET['project']);
$check_link_row = mysql_fetch_array($check_link);
$fileurl = $check_link_row['download_file'];


?>

<!DOCTYPE html>
<html>
	<? include('../inc/head.php');?>
<?
echo '
<script type="text/javascript">
	$(document).ready(function() {
    setTimeout(function() {
            window.open(
               \''.$fileurl.'\',
           \'_blank\' 
        );
     
      }, 2000);
	});
</script>
'
?>
	<body class="">
		<? include('client_header.php'); ?>
		<main>
			<section class="container">
				<h1 class="">File Download</h1>
					<div id="preproduction" class="container">
					<?php //Add container css class to make data display correctly?>
						<h2>More Option:</h2>
						<ul>
							<li class="section contact sixteen columns omega">
								<h4>hard copy request:</h4>
								<p><input type="checkbox" name="DVDs" value="DVDs" class="checkbox">DVDs (AU$ 10 included GST)</p>
								<p><input type="checkbox" name="USBs" value="USBs" class="checkbox">USBs (AU$ 30 included GST)</p>
								<h4>video output request:</h4>
								<p><input type="checkbox" name="FHD" value="FHD" class="checkbox">FHD 1920 x 1080  (AU$ 30 included GST)</p>
								<p><input type="checkbox" name="4K" value="4K" class="checkbox">4K 3840 × 2160  (AU$ 90 included GST)</p>	
								<h4>Addition Storage time:</h4>
								<p><input type="checkbox" name="1y" value="1y" class="checkbox">1 Years (AU$ 100 included GST)</p>
								<p><input type="checkbox" name="3y" value="3y" class="checkbox">3 Years (AU$ 250 included GST)</p>					
							</li>
						</ul>
					</div>

			</section>
		</main>
		<? include('../footer.php');?>
		<div id="overlay_wrapper" onClick="closeAllCards()"></div>
	</body>
</html>