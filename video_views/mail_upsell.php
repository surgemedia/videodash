<? include("../dbconnection_3evchey.php"); //connecting Database
session_start();
$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
$projectname = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']);
$projectname_row = mysql_fetch_array($projectname);
if($_POST['usb_option']!=""){
	if($_POST['USB_value']!=""){
		$usb_value = $_POST['USB_value'];
	}else{
		$usb_value = 1;
	}
	$upsell_mail[] = $_POST['usb_option'].' TOTAL: '.$usb_value.' PCS';
}
if($_POST['dvd_option']!=""){
	if($_POST['dvd_value']!=""){
		$usb_value = $_POST['dvd_value'];
	}else{
		$usb_value = 1;
	}
	$upsell_mail[] = $_POST['dvd_option'].' TOTAL: '.$usb_value.' PCS';
}
if($_POST['dps1']!=""){
	$upsell_mail[] = 'Allows collect raw footage on a supplied hard drive';	
}
if($_POST['dps2']!=""){
	$upsell_mail[] = 'Supply a hard drive with raw footage';	
}
if($_POST['dps3']!=""){
	$upsell_mail[] = 'Store raw footage and final project for a period of 5 years';	
}
if($_POST['dps4']!=""){
	$upsell_mail[] = 'Keep an uncompressed 1920 x1080 final video file indefinitely and on hand for requirement.';	
}
if($_POST['market1']!=""){
	$upsell_mail[] = 'Upload project to Client Youtube channel';	
}
if($_POST['market2']!=""){
	$upsell_mail[] = 'Style Youtube channel';	
}
if($_POST['market3']!=""){
	$upsell_mail[] = 'Advertise video on Youtube.';	
}
if($_POST['Remarketing']!=""){
	$upsell_mail[] = 'Remarketing';	
}
if($_POST['Television']!=""){
	$upsell_mail[] = 'Television';	
}
if(count($upsell_mail)!=0){
	for($i=0; $i<count($upsell_mail); $i++){
		$mailcont .='<li>'.$upsell_mail[$i].'</li>';
	}
	$mailcontent .= 'Client:'.$cca_row['company_name'].'<br/>';
	$mailcontent .= 'Project:'.$projectname_row['project_name'].'<br/>';
	$mailcontent .= 'Addition request for Client:';
	$mailcontent .= '<ul>';
	$mailcontent .= $mailcont;
	$mailcontent .= '</ul>';
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .="From: ". $name . " <" . $frommail . ">\r\n";
	$mailto = 'video@surgemedia.com.au, webproduction@surgemedia.com.au'; // $cca_row['email'];
	$mailsubject = 'CLIENT #'.$projectname_row['project_name'].' Upsell – TO SURGE';
	$mail_data = file_get_contents('../email_template/feedback.html');
	$mail_data = str_replace("[mail_title]",  $mailsubject, $mail_data);
	$mail_data = str_replace("[mail_content]",  $mailcontent, $mail_data);
	$the_data_is = date("d M Y");
	$mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);
	mail($mailto, $mailsubject, $mail_data, $headers);
}


?>
