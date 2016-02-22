<? include("../dbconnection_3evchey.php"); 
	include("login.php");
//connecting Database ?>
<?
	if(!$_POST['client_id']){
		if(!$_POST['addclient']){
			header('Location:http://videodash.surgehost.com.au/home_video.php');//if without request information, back to main page.
		}
	}
			$message = "Client Edit";
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
		$company_icon = $_POST['hiddenlogo'];
	}

//Add data to database
	if($_POST['contact_person']!="" && $_POST['email']!=""){//test data whether empty
		if(!$_POST['addclient']){
			$run_query = "UPDATE Client_Information SET company_name = '".trim($_POST['company_name'])."', contact_person = '".trim($_POST['contact_person'])."', company_icon = '".trim($company_icon)."', mobile_number = '".trim($_POST['mobile_number'])."', tel_number = '".trim($_POST['tel_number'])."', fax_number = '".trim($_POST['fax_number'])."', address_one = '".trim($_POST['address_one'])."', address_two = '".trim($_POST['address_two'])."', state = '".trim($_POST['state'])."', postcode = '".trim($_POST['postcode'])."', email = '".trim($_POST['email'])."', cc_email = '".trim($_POST['cc_email'])."' WHERE id = ".$_POST['client_id'];
		}else{
			$run_query = "INSERT Client_Information VALUES(NULL, 1, '".$_POST['company_name']."', '".$_POST['contact_person']."', '".$company_icon."', '".$_POST['mobile_number']."', '".$_POST['tel_number']."', '".$_POST['fax_number']."','".$_POST['address_one']."', '".$_POST['address_two']."', '".$_POST['state']."', '".$_POST['pastcode']."', '".$_POST['email']."', '".$_POST['cc_email']."')";
		}
		$query = mysql_query($run_query);
		if(!$query){
			echo "Client Record Cannot Update! Please check have not dedicate email record in database";
            // echo "run_query ".$run_query ;
			exit;	
		}else{
			$message = "Success to Update Client.";
		}
	}
	if(!$_POST['client_id']){
		$displayid = mysql_insert_id();
	}else{
		$displayid = $_POST['client_id'];
	}
	$clientdata = mysql_query("SELECT * FROM Client_Information WHERE id = ".$displayid);
	$clientdatarow = mysql_fetch_array($clientdata);
?>
<!DOCTYPE html>
<html>
			<? include('../inc/head.php');?>
            <body class="">
				<? include('../inc/header.php'); ?>
                <main>
                <section class="container">
                <form id="changeClient" enctype="multipart/form-data" action="edit_client.php" method="post">
                    <h1 id="client_name_editable"><input name="company_name" value="<?=$clientdatarow['company_name'];?>" placeholder="Company Name"/></h1>
                    <a href="/home_video.php"><h1 class="back_button"><i class="fa  fa-reply"></i> Clients</h1></a>
                    <div id="client_info" class="container">
                        <div>
                            <ul class="contact">
                                <li >

                                    <span>Contact Name</span><input name="contact_person" value="<?=$clientdatarow['contact_person'];?>"><input type="hidden" value="<?=$_POST['client_id'];?>" name="client_id"/>
                                    <span>Phone (Mobile)</span><input name="mobile_number" value="<?=$clientdatarow['mobile_number'];?>"/>
                                    <span>Phone (TEL)</span><input name="tel_number" value="<?=$clientdatarow['tel_number'];?>"/>
                                    <span>FAX number</span><input name="fax_number" value="<?=$clientdatarow['fax_number'];?>"/>
                                     <span>E-mail</span><input name="email" value="<?=$clientdatarow['email'];?>"/>
                                     <?php /* ?>
                                     <span>Logo</span><img src="<?=$clientdatarow['company_icon'];?>" height="50" width="50"/>
                                     <input type="hidden" name="hiddenlogo" value="<?=$clientdatarow['company_icon'];?>"/>
                                     <span>Upload New Logo</span><input type="file" name="company_icon"/>
                                      <?php */ ?>
                                </li>
                                <li >
                                    <span>Address</span><input name="address_one" value="<?=$clientdatarow['address_one'];?>"/>
                                    <span>Address 2</span><input name="address_two" value="<?=$clientdatarow['address_two'];?>"/>
                                    <span>State</span><input name="state" value="<?=$clientdatarow['state'];?>"/>
                                    <span>Post Code</span><input name="postcode" value="<?=$clientdatarow['postcode'];?>"/>
                                    <span>Secondary Email</span><textarea name="cc_email" placeholder="(separated by commas)"><?=$clientdatarow['cc_email'];?></textarea>
                                    <!-- <span>Delivery Page</span><input name="delivery_page" value="<?=$clientdatarow['delivery_page'];?>" /> -->
                                </li>
                            </ul>
                        </div>
                </form>
                <form action="../home_video.php" id="del" method="post">
                    <input type="hidden" name="delid"  value="<?=$_POST['client_id'];?>"/>
                </form>
                        <div class="actions">
                            <ul>
                                <li><a class="btn yellow" onclick="document.getElementById('changeClient').submit();"><span>Save Client</span><i class="fa fa-edit"></i></a></li>
                                <!-- <li><a href="#" class="btn green"><span>Add Video</span> <i class="fa fa-video-camera"></i></a></li> -->
                                <!-- <li><a href="#" class="btn blue"><span>View Videos</span><i class="fa fa-eye"></i></a></li> -->
                                <li><a class="btn red" onclick="document.getElementById('del').submit();"><span>Delete</span><i class="fa fa-bomb" ></i></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
                </main>
				<? include('../inc/footer.php');?>
            </body>
        </html>