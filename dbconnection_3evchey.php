<?
	@ $db = mysql_connect("localhost","videodsu_adminsu","lNcnNdValKLQ");
	if (!$db)
	{
		echo "Database connection error! Please try again.";
		exit;
	}
	mysql_query("SET NAMES 'utf8'"); 
	mysql_select_db("videodsu_ccdb");
?>