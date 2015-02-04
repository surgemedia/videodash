<?
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<title>Untitled Document</title>
</head>

<body>
<script type='text/javascript'>
function ajax(){
        $.ajax({
                url: 'http://videodash.surgehost.com.au/video_views/reset_loop_time.php',
                data: {name: 'looptimes'},
                dataType: "jsonp",
                jsonp: 'callback',
                jsonpCallback: 'jsonpCallback',
                success: function() {
                        
                }
        });
}
function jsonpCallback(data){
		var reset_looptimes = data.looptimes;
		$('#testing').text(reset_looptimes)	
}

</script>
<input type='button' value='click' onclick='ajax();'/>
<div id="testing"></div>
</body>
</html>