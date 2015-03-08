<!DOCTYPE html>
<?
session_start();
$_SESSION['email'] = "";
?>
<html>
<? include('inc/head.php');?>
<? include('dbconnection_3evchey.php'); ?>
<? include('Login_index_asw12d41527.php');// security file name.?>
<link rel="stylesheet" type="text/css" href="css/bigvideo.css">
<link rel="stylesheet" type="text/css" href="css/video-js.css"> 
<script src="/js/video.js"></script>
<script src="/js/bigvideo.js"></script>
<body class="">
<main>
<script>
$(function() {
    var BV = new $.BigVideo();
    BV.init();
    BV.show('video/water.webm',{ambient:true});
});
</script>

    <div class="wow fadeInDown">
	<div class="logindiv container">
    	<div class="logobox_loginpage ">
        	<h1>Surge Media</h1>
            <h2>Video Dash</h2>
        	<div id="credit"><small ><a href="https://www.surgemedia.com.au" target="_blank">by Surge Media</a><i class="surgelogo"></i></small></div>
        </div>
        <div class="loginbox ">
        <form action="c_projects_view.php" method="get">
        	<label>User Name(Email):</label>
        	<input name="email" class="textfield">
            <input type="submit" value="Login" class="button btn blue">
        </div>
        </form>
    </div>
    </div>
    </div>
</main>
</body>
</html>