<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
</head>
<body oncontextmenu="return false"  onselectstart="return false">
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
			<?php include('includes/store-categories.php'); ?>
                        <?php include('includes/featured-products.php'); ?>
			<div class="clear"></div>
		</div>
		<div id="body_right" class="body_right">
			<?php
			$gallery_string = $query = '';
			$search_strings = array();
			$total_results = 0;
			//create search query
			if(!empty($_GET['ke'])){
				$search_keywords = trim($_GET['ke']);
				if($search_keywords=="bathroom" || $search_keywords=="Bathroom" )
				{
					$query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`Notepad2`) AGAINST(\''.mysql_real_escape_string($search_keywords).',Wall Tile*\' IN BOOLEAN MODE) AND (Heading LIKE "WALL" OR Heading LIKE "DECORATIVE")  AND WebExport LIKE \'YES\' AND is_active=\'1\' AND';
					//$query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`SupplierName`,`Notepad2`) AGAINST(\''.mysql_real_escape_string($search_keywords).',Wall Tile*\' IN BOOLEAN MODE) AND `Size`=250.300600 AND (Heading ="WALL" OR Heading="DECORATIVE") AND';
					
					//echo $query;
					//exit;
				}
                               else if($search_keywords=="Kitchen" || $search_keywords=="kitchen" )
				{
					$query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`Notepad2`) AGAINST(\''.mysql_real_escape_string($search_keywords).',Wall Tile*\' IN BOOLEAN MODE) AND (Heading LIKE "WALL" OR Heading LIKE "DECORATIVE")  AND WebExport LIKE \'YES\' AND is_active=\'1\' AND';
				}
                              else if($search_keywords == "Outdoor" || $search_keywords=="outdoor")
                                {
                                    $query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`Notepad2`) AGAINST(\''.mysql_real_escape_string($search_keywords).'\' IN BOOLEAN MODE) AND (`Use` LIKE "EXTFLOOR" OR `Use` LIKE "INT&EXT")  AND WebExport LIKE \'YES\' AND is_active=\'1\' AND';
					
                                }
                               else if($search_keywords == "Internal" || $search_keywords=="internal")
                                {
                                    $query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`Notepad2`) AGAINST(\''.mysql_real_escape_string($search_keywords).',Wall Tile*\' IN BOOLEAN MODE) AND (`Use` LIKE "FLOOR&WALL" OR `Use` LIKE "INT&EXT")  AND WebExport LIKE \'YES\' AND is_active=\'1\' AND';
					
                                }
                               else if($search_keywords == "Pool" || $search_keywords=="Pool")
                                {
                                    $query .= 'MATCH(`Code`,`Desc`,`CategoryDescription`,`Notepad2`,`Heading`,`Use`) AGAINST(\''.mysql_real_escape_string($search_keywords).'\' IN BOOLEAN MODE) AND (`Heading` LIKE "POOL" OR `Use` LIKE "POOL")  AND WebExport LIKE \'YES\' AND is_active=\'1\'   AND';
					
                                }
                                else{
                                    $query .= "`Code` LIKE '%$search_keywords%'  AND WebExport LIKE 'YES' AND is_active=1 OR `Desc` LIKE '%$search_keywords%' AND WebExport LIKE 'YES' AND is_active=1  OR `CategoryDescription` LIKE '%$search_keywords%'  AND WebExport LIKE 'YES' AND is_active=1 OR WebExport LIKE 'YES' AND is_active=1 OR `Notepad2` LIKE '%$search_keywords%'  AND WebExport LIKE 'YES' AND is_active=1 AND ";
                                                                     
				}
				$search_strings[] = '"'.$search_keywords.'"';
			}
			//normal search
			if(!empty($_GET['ca'])){
				$search_category = trim($_GET['ca']);
				$query .= '`Use`=\''.mysql_real_escape_string($search_category).'\' AND ';
				$query_use = mysql_query("SELECT * FROM shop_use WHERE Code='$search_category' AND is_active='1'");
				if($queried_use=mysql_fetch_array($query_use)) {
					$search_strings[] = $queried_use['Description'];
				}
			}
			if(!empty($_GET['su'])){
				$search_surface = trim($_GET['su']);
				$query .= '`Surface`=\''.mysql_real_escape_string($search_surface).'\' AND ';
				$query_surface = mysql_query("SELECT * FROM shop_surface WHERE Code='$search_surface' AND is_active='1'");
				if($queried_surface=mysql_fetch_array($query_surface)) {
					$search_strings[] = $queried_surface['Description'];
				}
			}
			if(!empty($_GET['co'])){
				$search_colour = trim($_GET['co']);
				$query .= '`Colour`=\''.mysql_real_escape_string($search_colour).'\' AND ';
				$query_colour = mysql_query("SELECT * FROM shop_colour WHERE Code='$search_colour' AND is_active='1'");
				if($queried_colour=mysql_fetch_array($query_colour)) {
					$search_strings[] = $queried_colour['Description'];
				}
			}
			if(!empty($_GET['si'])){
				$search_size = trim($_GET['si']);
				$query .= '`Size`=\''.mysql_real_escape_string($search_size).'\' AND ';
                                $query_size = mysql_query("SELECT * FROM shop_size WHERE Code='$search_size' AND is_active='1'");
				if($queried_size=mysql_fetch_array($query_size)) {
					$search_strings[] = $queried_size['Description'];
				}
			}
			//advanced search
			if(!empty($_GET['pe'])){
				$search_peirating = trim($_GET['pe']);
				$query .= '`PeiRating`=\''.mysql_real_escape_string($search_peirating).'\' AND ';
				$query_peirating = mysql_query("SELECT * FROM shop_peirating WHERE Code='$search_peirating' AND is_active='1'");
				if($queried_peirating=mysql_fetch_array($query_peirating)) {
					$search_strings[] = $queried_peirating['Description'];
				}
			}
			if(!empty($_GET['ty'])){
				$search_type = trim($_GET['ty']);
				$query .= '`Type`=\''.mysql_real_escape_string($search_type).'\' AND ';
				$query_type = mysql_query("SELECT * FROM shop_type WHERE Code='$search_type' AND is_active='1'");
				if($queried_type=mysql_fetch_array($query_type)) {
					$search_strings[] = $queried_type['Description'];
				}
			}
			if(!empty($_GET['pa'])){
				$search_pattern = trim($_GET['pa']);
				$query .= '`Pattern`=\''.mysql_real_escape_string($search_pattern).'\' AND ';
				$query_pattern = mysql_query("SELECT * FROM shop_pattern WHERE Code='$search_pattern' AND is_active='1'");
				if($queried_pattern=mysql_fetch_array($query_pattern)) {
					$search_strings[] = $queried_pattern['Description'];
				}
			}
			if(!empty($_GET['ma'])){
				$search_material = trim($_GET['ma']);
				$query .= '`Material`=\''.mysql_real_escape_string($search_material).'\' AND ';
				$query_material = mysql_query("SELECT * FROM shop_material WHERE Code='$search_material' AND is_active='1'");
				if($queried_material=mysql_fetch_array($query_material)) {
					$search_strings[] = $queried_material['Description'];
				}
			}
			if(!empty($_GET['th'])){
				$search_thickness = trim($_GET['th']);
				$query .= '`Thickness`=\''.mysql_real_escape_string($search_thickness).'\' AND ';
				$query_thickness = mysql_query("SELECT * FROM shop_thickness WHERE Code='$search_thickness' AND is_active='1'");
				if($queried_thickness=mysql_fetch_array($query_thickness)) {
					$search_strings[] = $queried_thickness['Description'];
				}
			}
			if(!empty($_GET['ed'])){
				$search_edge = trim($_GET['ed']);
				$query .= '`Edge`=\''.mysql_real_escape_string($search_edge).'\' AND ';
				$query_edge = mysql_query("SELECT * FROM shop_edge WHERE Code='$search_edge' AND is_active='1'");
				if($queried_edge=mysql_fetch_array($query_edge)) {
					$search_strings[] = $queried_edge['Description'];
				}
			}
			if(!empty($_GET['sl'])){
				$search_sliprating = trim($_GET['sl']);
				$query .= '`SlipRating`=\''.mysql_real_escape_string($search_sliprating).'\' AND ';
				$query_sliprating = mysql_query("SELECT * FROM shop_sliprating WHERE Code='$search_sliprating' AND is_active='1'");
				if($queried_sliprating=mysql_fetch_array($query_sliprating)) {
					$search_strings[] = $queried_sliprating['Description'];
				}
			}
			if(!empty($_GET['pr'])){
				$search_pricerange = trim($_GET['pr']);
				//$query .= '`SlipRating`=\''.mysql_real_escape_string($search_sliprating).'\' AND ';
				$query .= '(RetailPriceM2 <= '.$search_pricerange.') AND';
				
					$search_strings[] = "Max Price $".$search_pricerange;
				
			}
			
			//for showing search query
			$search_query_string = '';
			if(!empty($search_strings)) {
				$search_strings_length = count($search_strings);
				if($search_strings_length>1) {
					$i = 1;
					foreach($search_strings as $key => $value) {
						if($i==$search_strings_length) { //last string
							$search_query_string .= 'and '.$value;
						} else if(($i+1)==$search_strings_length) { //2nd last
							$search_query_string .= $value.' ';
						} else { //not last
							$search_query_string .= $value.', ';
						}
						$i++;
					}
				} else {
					$search_query_string .= $search_strings[0];
				}
//				echo $query.'<br/>';
//				echo "SELECT * FROM shop_webitems WHERE $query WebExport='YES' AND is_active='1'".'<br/>'; exit;
				$reset_query =  substr($query, 0, -4);
				$result_webitems = mysql_query("SELECT * FROM shop_webitems WHERE ".$reset_query) or die(mysql_error());
	
				
				
				$total_results = mysql_num_rows($result_webitems);
				
				//page numbers				
				$pagenumbers = '';
				$results_per_page = 20;				
				$total_pages = ceil($total_results/$results_per_page);
				if(!empty($_GET['p'])){$page=trim($_GET['p']);}else{$page=1;}
				$end_row = $page*$results_per_page;
				$start_row = ($end_row-$results_per_page);
				if($total_pages>1) {
					$pagenumbers .= '<div class="pagenumbers">';
					if($page>1){$pagenumbers.='<div class="prev"><a href="tile-finder.php?'.$_parse_url['query'].'&p='.($page-1).'" title="Prev">Prev</a></div>';}
					for($i=1;$i<=$total_pages;$i++) {
						if($i==$page){$page_class='page_selected';}else{$page_class='page';}
						$pagenumbers .= '<div class="'.$page_class.'"><a href="tile-finder.php?'.$_parse_url['query'].'&p='.$i.'" title="'.$i.'">'.$i.'</a></div>';						
					}
					if($page<$total_pages){$pagenumbers.='<div class="next"><a href="tile-finder.php?'.$_parse_url['query'].'&p='.($page+1).'" title="Next">Next</a></div>';}
					$pagenumbers .= '<div class="clear"></div></div>';
				}
			}
			
			?>
            
			<div id="blackheading" class="blackheading">Search results › <span><?php echo trim($search_query_string); ?></span></div>
			<div id="gallery" class="gallery">
				<?php
				//gallery
				if($total_results>0) {
					$five_counter = 0;
					$gallery_string .= '<div class="gallery_top">'.$total_results.' results.<div class="clear"></div></div>';
					$gallery_string .= $pagenumbers.'<div class="clear"></div>';
					$result_webitems = mysql_query("SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE ".$query." WebExport LIKE 'YES' AND is_active=1 ORDER BY pricesum ASC LIMIT ".$start_row.",".$results_per_page."") or die(mysql_error());
					//echo "SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE $query WebExport='YES' AND is_active='1' ORDER BY pricesum ASC LIMIT $start_row,$results_per_page";
					//exit;
					
					while($row_webitems = mysql_fetch_array($result_webitems)) {
						$item_id = $row_webitems['item_id'];
						$item_code = $row_webitems['Code'];
						$item_name = $row_webitems['Desc'];
						$item_size = $row_webitems['Size'];
                                                $item_RetailPricePce = $row_webitems['RetailPricePce'];
						$result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_size."' AND is_active=1");
						if($row_size_check = mysql_fetch_array($result_size_check)) {
							$item_display_size = $row_size_check['Description'];
						} else { $item_display_size=''; }
						//$gallery_string .= $row_webitems['Desc'].'<br/>';
						$item_pcsm2 = floatval($row_webitems['PcsM2']);
						$item_unit = $row_webitems['Unit'];
//                                                if($item_id == 694){
////                                                    echo "item_pcsm2".$item_pcsm2;
////                                                    echo "<br/>";
////                                                    echo "item_unit".$item_unit;
//                                                }
						if($item_pcsm2>0&&$item_pcsm2!=''){ //sell in m2
							$item_webpricem2 = $row_webitems['WebPriceM2'];
							$item_retailpricem2 = $row_webitems['RetailPriceM2'];
							if(!empty($item_webpricem2)) {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							    $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}
							/*if($item_webpricem2!="") {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							
								$item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}*/
							
							$item_rrp = floatval($item_retailpricem2);
							$item_unit='m&sup2;';
						} /*else {
							$item_unit = str_replace('M2','m&sup2;',$item_unit);
						}*/
               /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
//                if($item_pcsm2==0&&$item_unit=='PCS'){ 
//                        if(!empty($item_webpricem2)) {
//                                $item_buy = floatval($item_webpricem2);
//			} else { //if web price value does not exist, use 20% off from retail price
//                               	$item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
//				$item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
//			}
//                        $item_retailpricem2 = $row_webitems['RetailPriceM2'];
//			$item_rrp = floatval($item_retailpricem2);
//			$item_unit='pcs';
//		}
		
		if($item_pcsm2==0 || $item_pcsm2==''){ 
                    $item_webpricepce = $row_webitems['WebPricePce'];
                    $item_retailpricepce = $row_webitems['RetailPricePce'];
                        if(!empty($item_webpricepce)) {
                            
                                $item_buy = floatval($item_webpricepce);
			} else { //if web price value does not exist, use 20% off from retail price
                               	$item_web_discount_amount = floatval($item_retailpricepce)*0.2; //20% of retail price
				$item_buy = floatval($item_retailpricepce)-$item_web_discount_amount;
			}
                        $item_retailpricepce = $row_webitems['RetailPricePce'];
			$item_rrp = floatval($item_retailpricepce);
			$item_unit='pcs';
		}
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$item_save = $item_rrp-$item_buy;
						if($item_save<0){$item_buy=0.00;}
						$item_images = unserialize($row_webitems['images']);
						$images_dir = 'images/items/';
						$image1 = $image1_imgsrc = '';
						$image1 = $images_dir.$item_images[0];
//                                              echo "Here".$image1;
						if(is_file($image1)) {
							$image1_imgsrc = '<img src="'.$images_dir.$item_images[0].'" alt="'.$item_name.'" border="0" />';
						} else {
							$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'" border="0" />';
						}
						//*****Flag Images****
						$img_s= '';
						if($row_webitems['Country']=='SPAIN')
						{
							$img_s='<img src="images/Spain.png" title="Spain"/>';
						}
						else if($row_webitems['Country']=='ITALY')
						{
							$img_s='<img src="images/Italy.png" title="Italy"/>';
						}else{
							$img_s= '';
						}
						
						//*****Flag Images****
						$gallery_string .= 
						'<div class="thumb">
							<div class="thumbnail" style="position:relative;"><a href="detail.php?id='.$item_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a>
							';
						if(!is_file($image1)){
							$gallery_string .= '
	                            <span style="position:absolute; top:0px; left:0px;">Code:'.$row_webitems['InternalCode'].'<br/>Description:'.$row_webitems['InternalDesc'].'</span>
							';
						}
						$gallery_string .= '</div>
							<div class="size">'.$item_display_size.'</div>
							<div class="code">'.$row_webitems['Code'].'</div>
							<div class="name"><a href="detail.php?id='.$item_id.'" title="More info">'.$row_webitems['Desc'].'</a></div>
							';
							/*<div class="price_info">
								<div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
								<div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
								<div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
								<div class="clear"></div>
							</div>*/
						$gallery_string .=  '
                                                        <div><a href="#" >'.$img_s.'</a></div>
							<div id="addtocart_button_'.$item_id.'" class="button"><!--<a href="javascript:void(0);" title="add to cart" onclick="addToCart(\''.$_shop_user_id_encoded.'\',\''.$_shop_user_session.'\',\''.$item_code.'\',1,\''.$item_id.'\',\''.$item_buy.'\');">add to cart</a>-->
                                                            <a href="detail.php?id='.$item_id.'" title="'.$item_name.'">View details</a></div>
							<div id="addtocart_feedback_'.$item_id.'" class="feedback">Item added</div>
							<div class="clear"></div>
						</div>';
						$five_counter++;
						if($five_counter==5) {
							$gallery_string .= '<div class="clear"></div>';
							$five_counter = 0;
						}
					}
					$gallery_string .= '<div class="clear"></div><div style="position:relative; height:80px;"><div class="gallery_top">'.$total_results.' results.<div class="clear"></div></div>'.$pagenumbers.'</div>';
				} else {
					$gallery_string .= '<div class="gallery_top">No tiles to list.</div>';
				}
				echo $gallery_string;
				?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php 
include('includes/end_body.php'); 
echo '<!-- search_material: '.$search_material.' -->';
if(!empty($search_peirating)||!empty($search_type)||!empty($search_pattern)||
	!empty($search_material)||!empty($search_thickness)||!empty($search_edge)||!empty($search_sliprating)) {
	echo '<script>moreTileFinderOptions(\'show\');</script>'; //show advanced search options
}
?>
</body>
</html>