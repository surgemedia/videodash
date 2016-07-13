<? 
// echo "cheese -1";
include("../dbconnection_3evchey.php"); //connecting Database
include ('../inc/head.php'); 
error_reporting(-1);
ini_set('display_errors', 'On');
     // echo "cheese 0";

session_start();
$client_id = $_POST['client_id'];
$project_id = $_POST['project_id'];

$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = ".$_POST['client_id']." AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
$projectname = mysql_query("SELECT * FROM video_project WHERE id = ".$_POST['project_id']);
$projectname_row = mysql_fetch_array($projectname);
$upsell_mail = [];

     // echo "cheese 1";

if($_POST['dps1']!=""){
	$upsell_mail[] = 'USB - We can supply a full range of branded and unbranded USBs.';	
}
if($_POST['dps2']!=""){
	$upsell_mail[] = 'DVDs and DATA DISCS - We can supply branded and unbranded DVDs and Data Discs ';	
}
if($_POST['dps3']!=""){
	$upsell_mail[] = 'Youtube - We provide a full Youtube channel style and video upload service.';	
}
if($_POST['dps4']!=""){
	$upsell_mail[] = 'No Thanks';	
}
if($_POST['market1']!=""){
	$upsell_mail[] = 'Surge Media will load your footage and video onto a hard drive provided by you.';	
}
if($_POST['market2']!=""){
	$upsell_mail[] = 'Surge Media will load your footage and video onto a hard drive provied by Surge Media.';	
}
if($_POST['market3']!=""){
	$upsell_mail[] = 'Surge Media will store your footage and video for an annual fee.';	
}
if($_POST['market4']!=""){
	$upsell_mail[] = 'Surge Media will store your final video indefinitley; However your project and footage will be deleted.';	
}
     // echo "cheese 2";

$list_msg = '&msg=c1';
// if(count($upsell_mail)!=0){


	for($i=0; $i<count($upsell_mail); $i++){
		$mailcont .='<li>'.$upsell_mail[$i].'</li>';
	}
	$name = "Surge Media - Video Dash";
	$frommail =  "video@surgemedia.com.au";
	$mailcontent .= '<strong>Client:</strong> '.$cca_row['company_name'].'<br/>';
	$mailcontent .= '<strong>Project:</strong> '.$projectname_row['project_name'].'<br/>';
	$mailcontent .= 'Additional request from client:';
	$mailcontent .= '<ul>';
	$mailcontent .= $mailcont;
	$mailcontent .= '</ul>';
	$mailcontentTOCLIENT .= '
		Dear '.$cca_row['contact_person'].'<br/><br/>
		Thank you for choosing to learn more about Surge Media’s marketing options for your project. <br/>
		We will send you some information on each option within 24 hours. .<br/>
		';
     // echo "cheese 3";

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .="From: ". $name . " <" . $frommail . ">\r\n";
	$mailto = 'video@surgemedia.com.au'; // $cca_row['email'];
	$mailTOCLIENT = $cca_row['email'];
	$mailsubject = ''.$projectname_row['project_name'].' Additional Storage';
	$mailtitle = 'Surge Media Video Dash';
	$mailsubtitle ='Company Promotional Video Marking';
	$mailsubjectTOCLIENT = $projectname_row['project_name'].' Additional Request Confirm Mail';
	$mail_data = file_get_contents('../email_template/upselltosurgemedia.html');
	$mail_data = str_replace("[mail_title]",  $mailtitle, $mail_data);
	$mail_data = str_replace("[mail_subtitle]",  $mailsubtitle, $mail_data);
	$mail_data = str_replace("[mail_content]",  $mailcontent, $mail_data);
	$the_data_is = date("d M Y");
	$mail_data = str_replace("[mail_datandtime]",  $the_data_is, $mail_data);
	$mail_data_c = file_get_contents('../email_template/upselltoclient.html');
	$mail_data_c = str_replace("[mail_title]",  $mailtitle, $mail_data_c);
	$mail_data_c = str_replace("[mail_subtitle]",  $mailsubtitle, $mail_data_c);
	$mail_data_c = str_replace("[mail_content]",  $mailcontentTOCLIENT, $mail_data_c);
	$mail_data_c = str_replace("[mail_datandtime]",  $the_data_is, $mail_data_c);
	// mail($mailto, $mailsubject, $mail_data, $headers);
	 $m->setFrom('video@surgemedia.com.au');
     $m->addTo($cca_row['email']);
     $m->setSubject($mailsubject);
     $m->setMessageFromString('',$mail_data_c);
     $m->setMessageCharset('','UTF-8');
     $ses->sendEmail($m);
    

	 $internal_m = new SimpleEmailServiceMessage();
     $internal_m->setFrom('video@surgemedia.com.au');
     $internal_m->addTo('video@surgemedia.com.au');
     $internal_m->setSubject($mailsubject);
     $internal_m->setMessageFromString('',$mail_data);
     $internal_m->setMessageCharset('','UTF-8');
     $ses->sendEmail($internal_m);

header('Location: video_view.php?ci='.$client_id.'&pi='.$project_id);
     // echo "cheese end";
?>
