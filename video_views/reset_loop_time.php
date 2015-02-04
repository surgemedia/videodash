<?
    header("content-type: text/javascript");
	session_start();
	if($_SESSION['looptimes']<=2){
		$_SESSION['looptimes']=2;
	}
	$_SESSION['looptimes'] = $_SESSION['looptimes']  + 1;
	$ret['looptimes']  = $_SESSION['looptimes'];
	echo $_GET['callback']. '(' . json_encode($ret) . ');';
?>