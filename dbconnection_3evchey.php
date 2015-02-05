<?
	/*======================================================*/
	/*			       Connect to Database          		*/
	/*======================================================*/

	@ $db = mysql_connect("localhost","bradwong","2201yuen");
	if (!$db)
	{
		echo "Database connection error! Please try again.";
		exit;
	}
	mysql_query("SET NAMES 'utf8'"); 
	mysql_select_db("videodsu_ccdb");


	/*======================================================*/
	/*			       Get all Global Data          		*/
	/*======================================================*/
	
	$list_global_data = mysql_query("SELECT * FROM global_data WHERE value_active = 1");
	$list_global_data_count = mysql_num_rows($list_global_data);
	for($i=0; $i<$list_global_data_count; $i++){
		$list_global_data_row = mysql_fetch_array($list_global_data);
		$global_data[$list_global_data_row['code']]=$list_global_data_row['value'];
	}
?>