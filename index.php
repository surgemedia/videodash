<!DOCTYPE html>
<?
session_start();
$_SESSION['email'] = "";
?>
<html>
<? include('inc/head.php');?>
<? include('dbconnection_3evchey.php'); ?>
<? include('Login_index_asw12d41527.php');// security file name.?> 
<body class="">
<main>
	<div class="logindiv">
    	<div class="logobox_loginpage wow bounceIn">
        	<h1>Video Dash</h1>
        	<div id="credit"><small ><a href="https://www.surgemedia.com.au" target="_blank">by Surge Media</a><i class="surgelogo"></i></small> </div>
        </div>
        <div class="loginbox wow flipInX">
        <form action="c_projects_view.php" method="get">
        	<label>User Name(Email):</label>
        	<input name="email" class="textfield">
            <input type="submit" value="LOGIN" class="button btn blue"></div>
        </form>
        </div>
    </div>
</main>
</body>
</html>