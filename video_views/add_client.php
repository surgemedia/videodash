
<? include("../dbconnection_3evchey.php"); //connecting Database ?>
<? include("../inc/login_logic.php"); // Admin Login?>
<?
//Upload Logo
	$time = time();

	$target_path = "../Client_Logo/";
	
	if($_FILES['company_icon']["size"]!=""){
		$target_path = $target_path . basename($time.$_FILES['company_icon']['name']); 
			if(move_uploaded_file($_FILES['company_icon']['tmp_name'], $target_path)){
				echo "";
			} else{
				echo "There was an error uploading the file, please try again!<br />";
			}
		$company_icon = "http://videodash.surgehost.com.au/Client_Logo/".($time.$_FILES['company_icon']['name']);
	}else{
		$company_icon = "";
	}

?>
<!DOCTYPE html>
<html>
			<? include('../inc/head.php');?>
            <body class="">
				<? include('../inc/header.php'); ?>
                <main>
                <form id="NewClient" enctype="multipart/form-data" action="edit_client.php" method="post">
                <input type="hidden" value="1" name="addclient">
                 <section  class="center ">
                    <h1 id="client_name_editable"><input type="text" name="company_name" placeholder="Company Name"></h1>
                    <a href="/home_video.php"><h1 class="back_button"><i class="fa  fa-reply"></i> Clients</h1></a>
                    <div id="client_info" class="container card_backing">
                        <div>
                            <ul class="contact">
                                <li>

                                    <span>Name</span><input name="contact_person">
                                    <span>Phone (Mobile)</span><input name="mobile_number">
                                    <span>Phone (TEL)</span><input name="tel_number">
                                    <span>FAX number</span><input name="fax_number">
                                     <span>E-mail</span><input name="email">
                                
                                </li>
                                <li>
                                    <span>Address</span><input name="address_one">
                                    <span>Address 2</span><input name="address_two">
                                    <span>State</span><input name="state">
                                    <span>Post Code</span><input name="pastcode">
                                    <span>Secondary Email</span><textarea name="cc_email" placeholder="(separated by commas)"><?=$clientdatarow['cc_email'];?></textarea>
                                </li>
                            </ul>
                        </div>
                        <div class="actions">
                            <ul>
                                <li><a href="#" class="btn yellow" onClick="document.getElementById('NewClient').submit();"><span>Save Client</span><i class="fa fa-edit"></i></a></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </section>
                </form>
                </main>
				<? include('../inc/footer.php');?>
            </body>
        </html>