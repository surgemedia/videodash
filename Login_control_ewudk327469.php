<?
	$adminuser_id=strtolower($_SERVER['PHP_AUTH_USER']);
	$adminpassword=$_SERVER['PHP_AUTH_PW'];		
	//Server Dialog box to check username and password if user directly want to login to this page.

	$_SESSION['adminuser'] = $adminuser_id;
	$_SESSION['adminpwd'] = $adminpassword;
	//double pointing to increase security level.

	$sqlog="select * from Admin_Login where username_email='".$_SESSION['adminuser']."' and admin_md5password='".md5($_SESSION['adminpwd'])."' AND account_active = 1";
	//check with database about the username password whether correct. and ensure the account is active or not.

	$query = mysql_query($sqlog);//run query

	if(!mysql_num_rows($query)) //check the result if fault.
	{
		Header("WWW-authenticate: basic realm=\"Video Dash - Control Panel Login\"");
		Header("HTTP/1.0 401 Unauthorized");
		$title="Login Fault!";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<blockquote>
			Your Login Details are not correct! Please try again.
		</blockquote>
<?
		exit;//display 401 error to client and exit to disable any coding display.
	}
?>