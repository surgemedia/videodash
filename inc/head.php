<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Video Dash</title>
<link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js" > </script>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css">
<link rel="stylesheet" href="/css/layout.css">
<link rel="stylesheet" href="/css/skeleton.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/fonts/stylesheet.css">
<style>
	div#lb-banner {
   display:none;
}
#big-video-wrap { background-color:rgb(215, 254, 250);}
body {
	padding-top:3em;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/wow.min.js"></script>
<script type="text/javascript" src="/js/website.js"></script>
<script type='text/javascript'>
(function (d, t) {
  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
  bh.type = 'text/javascript';
  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=h5plfv5xykxqalaiinj7uq';
  s.parentNode.insertBefore(bh, s);
  })(document, 'script');
</script>

<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once 'aws/ses.class.php';
$m = new SimpleEmailServiceMessage();
$ses = new SimpleEmailService('AKIAIOH2AUGQJV3XLOEA', 'OoQW1hMMMeWJMb094RUyrBRKWQEQjfeMjTPkvd2+');
?>

</head>
