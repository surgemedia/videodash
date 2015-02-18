<?
$adminuser_id=strtolower($_SERVER['PHP_AUTH_USER']);
$adminpassword=$_SERVER['PHP_AUTH_PW'];			
$_SESSION['adminuser'] = $adminuser_id;
$_SESSION['adminpwd'] = $adminpassword;

$sqlog="select * from adminlogin where username='".$_SESSION['adminuser']."' and password='".md5($_SESSION['adminpwd'])."' AND enabling = 1";
$query = mysql_query($sqlog);
if(!mysql_num_rows($query)) {
Header("WWW-authenticate: basic realm=\"Citylink Control Login\"");
Header("HTTP/1.0 401 Unauthorized");
$title="登入失敗";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<blockquote>
請輸入正確的用戶名稱及碼作登入!!
</blockquote>
<?
exit;
}
?>
