<!DOCTYPE html>
<?
session_start();
$_SESSION['email'] = "";
?>
<html>
<? include('inc/head.php');?>
<? include('dbconnection_3evchey.php'); ?>
<? include('Login_index_asw12d41527.php');// security file name.?>
<!-- <link rel="stylesheet" type="text/css" href="css/bigvideo.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="css/video-js.css">  -->
<body class="">

<main>
    <div class="wow fadeInDown">
    <div class="logindiv container">
        <div class="logobox_loginpage ">
            <h1>Surge Media</h1>
            <h2>Video Dash</h2>
            <div id="credit"><small ><a href="https://www.surgemedia.com.au" target="_blank">by Surge Media</a><i class="surgelogo"></i></small></div>
        </div>
        <div class="loginbox ">
        <form action="c_projects_view.php" method="get">
            <label>Login (your email address):</label>
            <input name="email" class="textfield">
            <input type="submit" value="Login" class="button btn yellow">
            <?php if($_GET["failed"] == true ){ ?>
             <p class="error">That email is incorrect</p>
            <?php } ?>
        </div>
        </form>
    </div>
    </div>
    </div>

</main>
<? include('inc/footer.php');?>
    <a id="admin-login" href="http://videodash.surgehost.com.au/home_video.java"><i class="fa fa-lock"></i></a>

</body>
</html>