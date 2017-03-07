<? include("../dbconnection_3evchey.php"); //connecting Database ?>
<? include("../inc/login_logic.php"); // Admin Login?>
<?
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    if(!$_POST['client_id']){
        if(!isset($_POST['addclient'])){
            header('Location:http://videodash.surgehost.com.au/home_video.php');//if without request information, back to main page.
        }
    }
 $no_logo = "";
   $message = false;
   $run_query;
    $time = time();
    $cc_email = $_POST['cc_email'];

//Add data to database
    if($_POST['contact_person']!="" && $_POST['email']!=""){//test data whether empty
        if(!isset($_POST['addclient'])){

            $run_query = "UPDATE `Client_Information` SET " ;
            if(isset($_POST['company_name'])){  $run_query .= " `company_name` ='".trim($_POST['company_name'])."', " ; }
             if(isset($_POST['contact_person'])){ $run_query .= " `contact_person` ='".trim($_POST['contact_person'])."', " ; }
             if(isset($_POST['mobile_number'])){ $run_query .= " `mobile_number` ='".trim($_POST['mobile_number'])."', " ; }
             if(isset($_POST['tel_number'])){ $run_query .= " `tel_number` ='".trim($_POST['tel_number'])."', " ; }
             if(isset($_POST['fax_number'])){ $run_query .= " `fax_number` ='".trim($_POST['fax_number'])."', " ; }
             if(isset($_POST['address_one'])){ $run_query .= " `address_one` ='".trim($_POST['address_one'])."', " ; }
             if(isset($_POST['address_two'])){ $run_query .= " `address_two` ='".trim($_POST['address_two'])."', " ; }
             if(isset($_POST['state'])){ $run_query .= " `state` ='".trim($_POST['state'])."', " ; }
             if(isset($_POST['postcode'])){ $run_query .= " `postcode` ='".trim($_POST['postcode'])."', "; }
             if(isset($_POST['email'])){ $run_query .= " `email` ='".trim($_POST['email'])."', " ; }
             if(isset($_POST['cc_email'])){ $run_query .= " `cc_email` ='".trim($_POST['cc_email'])."', " ; }
             if(isset($cc_email)){ $run_query .= " `delivery_page` ='".$_POST['delivery_page']."' " ; }
            $run_query .= "WHERE `id` = '".$_POST['client_id']."' ";

        }else{
            $run_query = "INSERT Client_Information VALUES(NULL, 1, '";
            $run_query .= $_POST['company_name']."', '";
            $run_query .= $_POST['contact_person']."', '";
            $run_query .= $no_logo."', '";
            $run_query .= $_POST['mobile_number']."', '";
            $run_query .= $_POST['tel_number']."', '";
            $run_query .= $_POST['fax_number']."', '";
            $run_query .= $_POST['address_one']."', '";
            $run_query .= $_POST['address_two']."', '";
            $run_query .= $_POST['state']."', '";
            $run_query .= $_POST['postcode']."', '";
            $run_query .= $_POST['email']."', '";
            $run_query .= $_POST['cc_email']."', '";
            $run_query .= $_POST['delivery_page']."')";
        }
        $query = mysql_query($run_query);
        if(!$query){
            $message = "Oops that didn't work, check all the fields";
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
    //print_r($run_query);
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
                    <a class="blue btn" href="/home_video.php"><i class="fa fa-reply"></i> Clients</a>
                    <div id="client_info" class="container">
                        <div>
                            <ul class="contact">
                                <li >

                                    <span>Contact Name</span><input name="contact_person" value="<?=$clientdatarow['contact_person'];?>"><input type="hidden" value="<?=$_POST['client_id'];?>" name="client_id"/>
                                    <span>Phone (Mobile)</span><input name="mobile_number" value="<?=$clientdatarow['mobile_number'];?>"/>
                                    <span>Phone (TEL)</span><input name="tel_number" value="<?=$clientdatarow['tel_number'];?>"/>
                                    <span>FAX number</span><input name="fax_number" value="<?=$clientdatarow['fax_number'];?>"/>
                                     <span>E-mail</span><input name="email" value="<?=$clientdatarow['email'];?>"/>
                        
                                </li>
                                <li >
                                    <span>Address</span><input name="address_one" value="<?=$clientdatarow['address_one'];?>"/>
                                    <span>Address 2</span><input name="address_two" value="<?=$clientdatarow['address_two'];?>"/>
                                    <span>State</span><input name="state" value="<?=$clientdatarow['state'];?>"/>
                                    <span>Post Code</span><input name="postcode" value="<?=$clientdatarow['postcode'];?>"/>
                                    <span>Secondary Email</span><textarea name="cc_email" placeholder="(separated by commas)"><?=$clientdatarow['cc_email'];?></textarea>
                                     <span>Delivery Page</span>
                                                     <select  name="delivery_page" >
                                                     <?php 
                                                        switch ($clientdatarow['delivery_page']){ 
                                                        case '1': 
                                                $select = '<option selected value="1">Default Page (Marketing &amp; Storage Options)</option>';
                                                $select .= '<option value="2">Just Download (No Options)</option>';
                                                 $select .=  '<option value="3">Just Marketing Options</option>';
                                                         break;    
                                                                 case '2':
                                                $select = '<option  value="1">Default Page (Marketing &amp; Storage Options)</option>';
                                                $select .= '<option selected value="2">Just Download (No Options)</option>';
                                                 $select .=  '<option value="3">Just Marketing Options</option>';
                                                         break;
                                                         case '3': 
                                                $select = '<option value="1">Default Page (Marketing &amp; Storage Options)</option>';
                                                $select .= '<option value="2">Just Download (No Options)</option>';
                                                 $select .=  '<option selected value="3">Just Marketing Options</option>';
                                                          break; 
                                                        default: 
                                                $select = '<option selected value="1">Default Page (Marketing &amp; Storage Options)</option>';
                                                $select .= '<option value="2">Just Download (No Options)</option>';
                                                 $select .=  '<option value="3">Just Marketing Options</option>';
                                                        break;
                                                             }
                                                             echo $select;
                                                         ?>
                                                                </select>


                                    
                                    
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
                           <?php if($message){ ?>
                            <p> <?php   echo $message ?></p>
                          <?php  } ?>
                        </div>
                    </div>
                </section>
                </main>
                <? include('../inc/footer.php');?>
            </body>
        </html>