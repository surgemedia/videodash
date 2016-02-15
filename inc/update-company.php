<?php 
if ($_POST['company_name'] != "") {
    // $update_contact = mysql_query("UPDATE Client_Information SET company_name = '" . trim($_POST['company_name']) . "', contact_person = '" . trim($_POST['contact_person']) . "', mobile_number = '" . trim($_POST['mobile_number']) . "', email = '" . trim($_POST['email']) ."', cc_email = '" . trim($_POST['cc_email']) . "' WHERE id = " . $client_id . " AND active_option = 1");
}
$check_client_active = mysql_query("SELECT * FROM Client_Information WHERE id = " . $client_id . " AND active_option = 1");
$cca_num = mysql_num_rows($check_client_active);
$cca_row = mysql_fetch_array($check_client_active);
if ($cca_num == 0) {
    header("location: ../index.java");
}
$projectname = mysql_query("SELECT * FROM video_project WHERE id = " . $project_id);
$projectname_row = mysql_fetch_array($projectname);
 ?>