<?php
include 'connect.php';
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);
error_reporting(0);

$favoritesArray=json_decode($_SESSION['fav_ids'], true);

function number_format_short( $n, $precision = 1 ) {
if ($n < 900) {
	// 0 - 900
	$n_format = number_format($n, $precision);
	$suffix = '';
} else if ($n < 1000000) {
	// 0.9k-850k
	$n_format = number_format(floor($n / 1000), $precision);
	$suffix = 'K';
} else if ($n < 900000000) {
	// 0.9m-850m
	$n_format = number_format($n / 1000000, $precision);
	$suffix = 'M';
} 
// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
// Intentionally does not affect partials, eg "1.50" -> "1.50"
if ( $precision > 0 ) {
	$dotzero = '.' . str_repeat( '0', $precision );
	$n_format = str_replace( $dotzero, '', $n_format );
}
return $n_format.$suffix;
}

function number_format_Ms( $n, $precision = 2 ) {
if ($n < 900) {
	// 0 - 900
	$n_format = number_format($n, $precision);
	$suffix = '';
} else if ($n < 1000000) {
	// 0.9k-850k
	//$n_format = number_format($n / 1000, $precision);
	$n_format = floatval($n / 1000);
    $n_format = substr($n_format, 0, 5);
	$suffix = 'K';
} else if ($n < 900000000) {
	// 0.9m-850m
	//$n_format = number_format($n / 1000000, $precision);
	$n_format = floatval($n / 1000000);
    $n_format = substr($n_format, 0, 5);
	$suffix = 'M';
} 
// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
// Intentionally does not affect partials, eg "1.50" -> "1.50"
if ( $precision > 0 ) {
	$dotzero = '.' . str_repeat( '0', $precision );
	$n_format = str_replace( $dotzero, '', $n_format );
}
return $n_format.$suffix;
}

if(isset($_GET['MLSNumber']) && isset($_GET['address'])){
$MLSNumber = $_GET['MLSNumber'];
$address=$_GET["address"];

if(isset($_SESSION['logged_email']) && $user_id!=''){
$sqlViewed = "SELECT view_id FROM user_views WHERE MLSNumber='$MLSNumber' AND user_id='$user_id'";  
$vwdrslt=mysqli_query($conn, $sqlViewed) or die(mysqli_error($conn)); 
$viewed=mysqli_num_rows($vwdrslt); 

//if($viewed == '0'){
    $date = date("Y-m-d H:i:s"); 
    $addView="INSERT INTO user_views(MLSNumber, user_id, date) VALUES('".$MLSNumber."', '".$user_id."', '".$date."')";
    $addRslt=mysqli_query($conn, $addView) or die(mysqli_error($conn));    
//}
}

$sql = "SELECT * FROM properties WHERE MLSNumber='$MLSNumber'";  
$rs=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
$noListngs=mysqli_num_rows($rs); 

$title = str_replace('-',' ',$address);

if($noListngs>0){  
$row = mysqli_fetch_array($rs);
extract($row);
$otherFieldsJson = json_decode($other_fields_json);
$propMeta = substr($PropertyInformation, 0, 155);
$ElementarySchool = $otherFieldsJson->ElementarySchool;
$ListOffice_MUI = $otherFieldsJson->ListOffice_MUI;
$ListOfficeMLSID = $otherFieldsJson->ListOfficeMLSID;
$ListOfficeName = $otherFieldsJson->ListOfficeName;
$ListOfficePhone = $otherFieldsJson->ListOfficePhone;
$ListAgent_MUI = $otherFieldsJson->ListAgent_MUI;
$ListAgentDirectWorkPhone = $otherFieldsJson->ListAgentDirectWorkPhone;
$ListAgentFullName = $otherFieldsJson->ListAgentFullName;
$ListAgentMLSID = $otherFieldsJson->ListAgentMLSID;
$TaxDesc = $otherFieldsJson->TaxDesc;
$TaxDistrictType = $otherFieldsJson->TaxDistrictType;
$Taxes = $otherFieldsJson->Taxes;
$TaxYear = $otherFieldsJson->TaxYear;
$HOADesc = $otherFieldsJson->HOADesc;
$HOAFee = $otherFieldsJson->HOAFee;
$HOAFeeFreq = $otherFieldsJson->TaxYear;
$VirtualTour = $otherFieldsJson->VirtualTourURL;
$VirtualTourURL2 = $otherFieldsJson->VirtualTourURL2;
$View = $otherFieldsJson->View;

if(!$VirtualTour){
    $VirtualTour = $VirtualTourURL2;
}

$PrivatePool = "";
$PrivateSpa = "";
$Waterfront = "";
$Cable = "";
if($PrivatePoolYN = '1'){ $PrivatePool = "Yes"; }
if($PrivateSpaYN = '1'){ $PrivateSpa = "Yes"; }
if($WaterfrontYN = '1'){ $Waterfront = "Yes"; }
if($CableAvailableYN = '1'){ $Cable = "Yes"; }

if(in_array($MLSNumber, $favoritesArray)){
    $favDsply=' display: none;';
    $unfDsply=' display: inline-block;';
}else{ 
    $favDsply=' display: inline-block;';
    $unfDsply=' display: none;';  
}

$today = strtotime(date("Y-m-d"));
$MxModifiedDT = strtotime($MatrixModifiedDT);
$hotDiff = $today - $MxModifiedDT;
$justListed = floor($hotDiff / ( 60 * 60 ));

if($justListed<=24){
    if($justListed<1){
        $domOut = 'New Hot';
    }else{
        $domOut = "New $justListed hours ago";
    }
    $domBadge = '<span class="_list_blickes types shadow no_radius" style="background-color: #FFE2C6; color: #EA7500;"><i class="fas fa-fire"></i> &nbsp;'.$domOut.'</span>';
}else{
    $DateAddedTT = strtotime($DateAdded);
    $hotxDiff = $today - $DateAddedTT;
    $date_added = $hotxDiff / ( 60 * 60 );
    $finalDom = intval($DOM + $date_added);
    $domBadge = '<span class="_list_blickes types shadow no_radius" style="background-color: #CEEFFF; color: #006FA4;">'.$finalDom.' Days On Market</span>';
}

if(!$BedsTotal){
    $BedsTotal = '0';
}

if(!$BathsTotal){
    $BathsTotal = '0';
}

if(!$GarageSpaces){
    $GarageSpaces = '0';
}

if(!$TotalArea){
    $TotalArea = '0';
}
?>
                                        
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
    <base href="/" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $propMeta;?>"/>
    
    <title><?php echo "$SubCondoName | $title";?></title>
	
    <?php include_once 'styles.php';?>
    
    <script type="text/javascript">
    var user_id = '<?php echo $user_id;?>';
    var email = '<?php echo $logged_email;?>';
    var logged_email = '<?php echo $logged_email;?>';

    var propLat = parseFloat('<?php echo $Latitude;?>'); /** must parse as float **/
    var propLng = parseFloat('<?php echo $Longitude;?>'); /** must parse as float **/
    var gooleMapAPI = parseFloat('<?php echo WEBMAPAPI;?>'); /** must parse as float **/
    </script>
    <link rel="stylesheet" href="assets/css/plugins/magnifypopup.css" />
    <?php
    if($PropertyClass == 'LOT'){
        echo '<style type="text/css">
        .homes_only{ display: none!important; }
        .docks_only{ display: none!important; }</style>';
    }else if($PropertyClass == 'DOCK'){
        echo '<style type="text/css">
        .homes_only{ display: none!important; }
        .land_only{ display: none!important; }</style>';
    }else{
        echo '<style type="text/css">
        .docks_only{ display: none!important; }
        .land_only{ display: none!important; }
        </style>';
    }
    ?>
    <style type="text/css">
    html{ overflow-x: visible!important; }
    </style>
</head>

<body class="yellow-skin">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader"></div>
	
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
	
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
        <!-- Start Navigation -->
		<div class="header change-logo">
			<div class="container">
				<?php include_once 'nav.php';?>
			</div>
		</div>
		<!-- End Navigation -->
		<div class="clearfix"></div>
        <!-- Top header  -->
		<!-- ============================================================== -->
 
        <!-- ============================ Gallery Start ================================== -->
        <section class="gallery_parts p-0">
			<div class="w-100" style="overflow-x: hidden!important;">
				<div class="row align-items-center relative xs-ml-0 xs-mr-0" style="background-color: #383838;">
                    <?php
                    $expldPix = explode(',',$AllPixList);
                    $all_pix = count($expldPix);
                    //listings_images/64XX-Everglades-BLVD-Naples-FL-34120-45951126-221067849-0.jpeg,listings_images/64XX-Everglades-BLVD-Naples-FL-34120-45951126-221067849-1.jpeg,listings_images/64XX-Everglades-BLVD-Naples-FL-34120-45951126-221067849-2.jpeg,
                    
                    if(!file_exists($DefaultPic)){
                        $DefaultPic = 'https://via.placeholder.com/550x400.png?text=Loading+Pictures+From+MLS';
                    }
                    
                    if($all_pix>3 && $AllPixDownloaded == 'Yes'){
                    $secondPix = $expldPix[2];
                    $thirdPix = $expldPix[3];
                    
                    if(!$secondPix){
                        $secondPix = $DefaultPic;
                    }
                    
                    if(!$thirdPix){
                        $thirdPix = $DefaultPic;
                    }
                    
                    if($all_pix>4){
                    ?>
					<div class="col-lg-8 col-md-12 col-sm-12 p-0 ppty_pix_left">
						<div class="gg_single_part left w-100 relative"> 
                    	<a href="<?php echo $DefaultPic;?>" data-caption="1/<?php echo intval($all_pix-2);?>" class="mfp-gallery centered-text">
                        <img src="<?php echo $DefaultPic;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='https://via.placeholder.com/550x400.png?text=Loading+Pictures+From+MLS'" />
                        </a>
                        <div class="absolute p-6 pl-10 pr-10 fs-11" style="background-color: #009BE6; color: white; z-index: 99; bottom: 4px; right: 4px;">
                        <i class="fas fa-image"></i> Click image to see all <?php echo intval($all_pix-2);?> pictures.
                        </div>
                        </div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 p-0 absolute ppty_pix_right" style="right: 0; top: 0; bottom: 0;">
						<div class="gg_single_part-right min mb-1">
                        <a href="<?php echo $secondPix;?>" data-caption="2/<?php echo intval($all_pix-2);?>" class="mfp-gallery">
                        <img src="<?php echo $secondPix;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='<?php echo $DefaultPic;?>';" />
                        </a>
                        </div>
						<div class="gg_single_part-right min">
                        <a href="<?php echo $thirdPix;?>" data-caption="3/<?php echo intval($all_pix-2);?>" class="mfp-gallery">
                        <img src="<?php echo $thirdPix;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='<?php echo $DefaultPic;?>';" />
                        </a>
                        </div>
					</div>
                    <?php
                    }else{
                    ?>
					<div class="col-lg-6 col-md-12 col-sm-12 p-0 ppty_pix_left">
						<div class="gg_single_part left w-100 relative"> 
                    	<a href="<?php echo $DefaultPic;?>" data-caption="1/<?php echo intval($all_pix-2);?>" class="mfp-gallery centered-text">
                        <img src="<?php echo $DefaultPic;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='https://via.placeholder.com/550x400.png?text=Loading+Pictures+From+MLS'" />
                        </a>
                        </div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 p-0 ppty_pix_left">
						<div class="gg_single_part left w-100 relative"> 
                    	<a href="<?php echo $secondPix;?>" data-caption="2/<?php echo intval($all_pix-2);?>" class="mfp-gallery">
                        <img src="<?php echo $secondPix;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='<?php echo $DefaultPic;?>';" />
                        </a>
                        </div>
					</div>
                    <?php   
                    }
                    $imgCount = 0;
                    foreach($expldPix as $picture){
                    if($picture!='' && $imgCount>3){
                    ?>
                	<a href="<?php echo $picture;?>" data-caption="<?php echo $imgCount;?>/<?php echo intval($all_pix-2);?>" class="mfp-gallery centered-text"></a>
                    <?php
                    }
                    $imgCount++;
                    }
                    ?>
                    <?php
                    }else{
                    ?>
                    <div class="col-12 p-0 ppty_pix_left">
						<div class="gg_single_part left w-100 relative">
                        <a href="<?php echo $DefaultPic;?>" class="mfp-gallery">
                        <img src="<?php echo $DefaultPic;?>" class="img-fluid mx-auto" alt="<?php echo $PropertyAddress;?>" onerror="this.src='https://via.placeholder.com/550x400.png?text=Loading+Pictures+From+MLS';" />
                        </a>
                        </div>
					</div>
                    <?php
                    }
                    ?>
				</div>
			</div>
		</section> 
        <!-- ============================ Gallery Ends ================================== -->
        
        
        <!-- ============================ Property Detail Start ================================== -->
        <section class="gray xs-pt-30 sm-pt-30">
        <div class="container">
        	<div class="row">
        		
        		<!-- property main detail -->
        		<div class="col-lg-8 col-md-12 col-sm-12">
        			
        			<div class="property_info_detail_wrap exlio_wrap mb-4">
        				
        				<div class="property_info_detail_wrap_first">
        					<div class="pr-price-into">
        						<div class="_card_list_flex mb-2">
        							<div class="_card_flex_01">
        								<?php
                                        if($Status=='Sold' || $Status=='Pending' || $Status=='Pending With Contingencies' || $Status=='Application In Progress'){
                                        ?>
                                        <span class="_list_blickes _netork"><?php echo $Status;?></span>
                                        <?php
                                        }else if($Status=='Active'){
                                        ?>
        								<span class="_list_blickes types shadow no_radius" style="background-color: #00A600; color: white;">Active</span>
                                        <?php
                                        echo $domBadge;
                                        
                                        if($PotentialShortSaleYN == '1'){
                                            echo '<span class="_list_blickes _netork shadow no_radius"><i class="ti-check"></i> &nbsp;Short Sale</span>';
                                        }
                                        
                                        if($ForeclosedREOYN == '1'){
                                            echo '<span class="_list_blickes _netork shadow no_radius ml-5"><i class="fas fa-gavel fs-15"></i> &nbsp;Foreclosure</span>';
                                        }
                                        }
                                        ?> 
        							</div>
        						</div>
        						<h2 class="w-100"><?php echo $SubCondoName;?></h2>
        						<div class="w-100"><i class="lni-map-marker"></i> <?php echo $PropertyAddress;?></div>
                                <div class="w-100"><i class="ti-layout-menu-v"></i> <b>MLS #:</b> <?php echo $MLSNumber;?></div>
    
        					</div>
        				</div>
        				
        				<div class="property_detail_section">
        					<div class="prt-sect-pric">
                                <h3 class="w-100 text-right xs-text-left sm-text-left md-text-left">$<?php echo number_format($CurrentPrice,0);?></h3>
        						<ul class="_share_lists light">
        							<li onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>" data-toggle="tooltip" title="Add to favorite listings">
                                    <a href="javascript:;"><i class="far fa-thumbs-up"></i></a>
                                    </li>
        							<li onclick="remFrmFav('<?php echo $MLSNumber;?>')" id="rem-frm-fav-<?php echo $MLSNumber;?>" style="<?php echo $unfDsply;?>" data-toggle="tooltip" title="Remove from favorite listings">
                                    <a href="javascript:;"><i class="fas fa-thumbs-down"></i></a>
                                    </li>
                                    <li class="add_rem_loader_<?php echo $MLSNumber;?> dsply_inline_blck centered-text" style="display: none;">
                                    <img src="assets/img/loader.gif" class="float_none" style="width: 15px; height: 15px; cursor: pointer;" />
                                    </li>
        							<li data-toggle="tooltip" title="Share to email"><a href="javascript:;" onclick="$('#shareProperty').modal('show')"><i class="fa fa-envelope"></i></a></li>
        							<li data-toggle="tooltip" title="Share on social media"><a href="javascript:;" onclick="$('#socialModal').modal('show')"><i class="fa fa-share"></i></a></li>
        						</ul>
        					</div>
        				</div>
        				
        			</div>
        			
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4">
        				<div class="_prtis_list_header">
        					<ul>
        						<li>
        							<div class="content_thumb"><img src="assets/img/bed.svg" alt="" /></div>
        							<div class="content">
        								<span class="dark"><?php echo number_format($BedsTotal,0);?> Bedrooms</span>
        								<span class="title">Bedrooms</span>
        							</div>
        						</li>
        						<li>
        							<div class="content_thumb"><img src="assets/img/bath.svg" alt="" /></div>
        							<div class="content">
        								<span class="dark"><?php echo number_format($BathsTotal,0);?> Bathrooms</span>
        								<span class="title">Bathrooms</span>
        							</div>
        						</li>
        						<li>
        							<div class="content_thumb"><img src="assets/img/car.svg" alt="" /></div>
        							<div class="content">
        								<span class="dark"><?php echo number_format($GarageSpaces,0);?> Garage</span>
        								<span class="title">Car Garage</span>
        							</div>
        						</li>
        						<li>
        							<div class="content_thumb"><img src="assets/img/area.svg" alt="" /></div>
        							<div class="content">
        								<span class="dark"><?php echo number_format($TotalArea,0);?> Sq Ft</span>
        								<span class="title">Living Area</span>
        							</div>
        						</li>
        					</ul>
        				</div>
        				<div class="_prtis_list_body" style="word-break: break-all!important;">
        					<ul class="deatil_features">
        						<li><strong><?php echo $PropertyType;?></strong>Property Type</li>
        						<li><strong><?php echo $YearBuilt;?></strong>Year Built</li>
        						<li><strong><?php echo $Status;?></strong>Status</li>
        						<li class="homes_only"><strong><?php echo number_format($BathsFull,0);?></strong>Baths Full</li>
        						<li class="homes_only"><strong><?php echo number_format($BathsHalf,0);?></strong>Baths Half</li>
        						<li class="homes_only"><strong><?php echo number_format($BedsTotal,0);?></strong>Beds Total</li>
        						<li class="homes_only"><strong><?php echo $BuildingDesign;?></strong>Building Design</li>
        						<li class="homes_only"><strong><?php echo $BuildingDesc;?></strong>Building Description</li>
        						<li class="homes_only"><strong><?php echo $Cable;?></strong>Cable</li>
        						<li><strong><?php echo $Construction?></strong>Construction</li>
        						<li class="homes_only"><strong><?php echo $Cooling;?></strong>Cooling</li>
        						<li class="homes_only"><strong><?php echo $Electric;?></strong>Electric</li>
        						<li class="homes_only"><strong><?php echo $Flooring;?></strong>Flooring</li>
        						<li class="homes_only"><strong><?php echo $Heat;?></strong>Heat</li>
        						<li class="homes_only"><strong><?php echo $NumUnitFloor;?></strong>Number of Unit Floor</li>
        						<li class="docks_only"><strong><?php echo $NumberDockHighDoors;?></strong>Dock High Doors</li>
        						<li class="docks_only"><strong><?php echo $NumberOfBays;?></strong>Number of Bays</li>
        						<li class="docks_only"><strong><?php echo $NumUnitFloor;?></strong>NumUnit Floor</li>
        						<li class="docks_only"><strong><?php echo $NumberofLoadingDoors;?></strong>Number of Loading Doors</li>
        						<li class="land_only"><strong><?php echo number_format($LandSqFt,0);?></strong>Land SqFt</li>
        						<li class="land_only"><strong><?php echo $LotType;?></strong>Lot Type</li>
        						<li class="land_only"><strong><?php echo $LotUnit;?></strong>Lot Unit</li>
        						<li class="land_only"><strong><?php echo $NumberOfParcelsLots;?></strong>Number of Parcels Lots</li>
        						<li class="land_only"><strong>$<?php echo number_format($PricePerAcre,0);?></strong>Price Per Acre</li>
        						<li class="homes_only"><strong><?php echo $PrivatePool;?></strong>Private Pool</li>
        						<li class="homes_only"><strong><?php echo $PrivateSpa;?></strong>Private Spa</li>
        						<li class="homes_only"><strong><?php echo $TotalFloors;?></strong>Total Floors</li>
        						<li class="homes_only"><strong><?php echo $UnitCount;?></strong>Unit Count</li>
        						<li class="homes_only"><strong><?php echo $UnitFloor;?></strong>Unit Floor</li>
        						<li class="homes_only"><strong><?php echo $UnitNumber;?></strong>Unit Number</li>
        						<li class="homes_only"><strong><?php echo $UnitsinBuilding;?></strong>Units in Building</li>
        						<li class="homes_only"><strong><?php echo $UnitsinComplex;?></strong>Units in Complex</li>
        						<li class="homes_only"><strong><?php echo $UtilitiesAvailable;?></strong>Utilities Available</li>
        						<li><strong><?php echo $View;?></strong>View</li>
        						<li><strong><?php echo $Water;?></strong>Water</li>
        						<li><strong><?php echo $Waterfront;?></strong>Waterfront</li>
                                
        					</ul>
        				</div>
        			</div>
        			
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4">
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Remarks</h4>
        				</div>
        				<div class="_prtis_list_body">
        					<p class="fs-17"><?php echo $PropertyInformation;?></p>
        				</div>
        			</div>
        			
                    <?php
                    if($Amenities!='' && $Amenities!='None' && $Amenities!='Other'){
                    ?>
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Amenities</h4>
        				</div>
        				
        				<div class="_prtis_list_body"> 
                            <?php
                            $xpldAmm = explode(',',$Amenities);
                            ?>
                            <ul class="avl-features third">
                                <?php 
                                foreach($xpldAmm as $ame){
                                    if($ame!=''){
                                        echo '<li class="active">'.$ame.'</li>';
                                    }
                                }
                                ?>
        					</ul>
        				</div>
        				
        			</div>
        			<?php
                    }
                    ?>
                    
                    <?php
                    if($InteriorFeatures!='' && $InteriorFeatures!='None' && $InteriorFeatures!='Other'){
                    ?>
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Interior Features</h4>
        				</div>
        				
        				<div class="_prtis_list_body"> 
                            <?php
                            $xpldInter = explode(',',$InteriorFeatures);
                            ?>
                            <ul class="avl-features third">
                                <?php 
                                foreach($xpldInter as $intrFtrs){
                                    if($intrFtrs!=''){
                                        echo '<li class="active">'.$intrFtrs.'</li>';
                                    }
                                }
                                ?>
        					</ul>
        				</div>
        				
        			</div>
        			<?php
                    }
                    ?>
                    
                    
                    <?php
                    if($ExteriorFeatures!='' && $ExteriorFeatures!='None' && $ExteriorFeatures!='Other'){
                    ?>
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4 homes_only">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Exterior Features</h4>
        				</div>
        				
        				<div class="_prtis_list_body"> 
                            <?php
                            $xpldExtr = explode(',',$ExteriorFeatures);
                            ?>
                            <ul class="avl-features third">
                                <?php 
                                foreach($xpldExtr as $extrFtrs){
                                    if($extrFtrs!=''){
                                        echo '<li class="active">'.$extrFtrs.'</li>';
                                    }
                                }
                                ?>
        					</ul>
        				</div>
        				
        			</div>
                    <?php
                    }
                    ?>
                    
                    <?php
                    if($Equipment!='' && $Equipment!='None'){
                    ?>
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4 homes_only">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Equipments</h4>
        				</div>
        				
        				<div class="_prtis_list_body"> 
                            <?php
                            $xpldEqp= explode(',',$Equipment);
                            ?>
                            <ul class="avl-features third">
                                <?php 
                                foreach($xpldEqp as $equip){
                                    if($equip!=''){
                                        echo '<li class="active">'.$equip.'</li>';
                                    }
                                }
                                ?>
        					</ul>
        				</div>
        				
        			</div>
                    <?php
                    }
                    ?>
        			
                    
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Descriptions</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
        					<ul class="deatil_features">
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $AdditionalRooms;?></strong>Additional Rooms</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $BedroomDesc;?></strong>Bedroom Description</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $CoolingRemarks;?></strong>Cooling</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $CommunityType;?></strong>Community Type</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $Pets;?></strong>Pets</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $PetsLimitOther;?></strong>Pets Limits</li>
                                
                            </ul>
                        </div>
                    </div>
                    
                    
                    <?php
                    if($VirtualTour!=''){
                    ?>
        			<!-- Single Block Wrap -->								
        			<div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Virtual Tour</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
        					<div class="property_video">
        						<div class="thumb">
        							<img class="pro_img img-fluid w100" src="<?php echo $DefaultPic;?>" alt="<?php echo $PropertyAddress;?>" />
                                    <a href="<?php echo $VirtualTour;?>" class="theme-cl popup-video">
        							<div class="overlay_icon">
        								<div class="bb-video-box">
        									<div class="bb-video-box-inner">
        										<div class="bb-video-box-innerup"> 
                                                    <i class="ti-control-play fs-25"></i>
        										</div>
        									</div>
        								</div>
        							</div>
                                    </a>
        						</div>
        					</div>     
        				</div>
        				
        			</div>
                    <?php
                    }
                    ?> 
        			
        			<!-- Single Block Wrap -->
        			<div class="_prtis_list mb-4">
        			
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Property Location</h4>
        				</div>
        			
        				<div class="_prtis_list_body p-0">
        					<!--div class="map-container" id="map_canvas" style="width:100%; height:450px;"></div-->
                            <div class="google_map_shortcode_wrapper not_editable">
                              <div id="gmapzoomplus_sh" class="smallslidecontrol shortcode_control not_editable" data-toggle="tooltip" title="Zoom In"><i class="fas fa-plus not_editable"></i></div>
                              <div id="gmapzoomminus_sh" class="smallslidecontrol shortcode_control not_editable" data-toggle="tooltip" title="Zoom Out"><i class="fas fa-minus not_editable"></i></div>
                              <div class="google_map_poi_marker not_editable">
                                 <div class="google_poish not_editable tooltip-web" id="transport" data-toggle="tooltip" title="Transports"><i class="fas fa-car action-1 not_editable"></i></div>
                                 <div class="google_poish not_editable tooltip-web" id="supermarkets" data-toggle="tooltip" title="Shopping Malls"><i class="fas fa-shopping-cart action-1 fs-14 not_editable"></i></div>
                                 <div class="google_poish not_editable tooltip-web" id="schools" data-toggle="tooltip" title="Schools"><i class="fas fa-user-graduate action-1 fs-14 not_editable"></i></div>
                                 <div class="google_poish not_editable tooltip-web" id="restaurant" data-toggle="tooltip" title="Restaurants"><i class="fas fa-pizza-slice action-1 fs-14 not_editable"></i> </div>
                                 <div class="google_poish not_editable tooltip-web" id="gym" data-toggle="tooltip" title="Gym"><i class="fas fa-dumbbell action-1 fs-14 not_editable"></i></div>
                                 <div class="google_poish not_editable tooltip-web" id="hospitals" data-toggle="tooltip" title="Hospitals"><i class="far fa-hospital action-1 fs-14 not_editable"></i></div>
                              </div>
                              <div id="slider_enable_street_sh" class="not_editable tooltip-web" data-toggle="tooltip" title="Street View"> <i class="fas fa-location-arrow not_editable"></i></div>
                              <div id="googleMap_shortcode" class="not_editable" data-cur_lat="<?php echo $Latitude;?>" data-cur_long="<?php echo $Longitude;?>" style="position: relative; overflow: hidden;">
                              </div>
                           </div>
        				</div>
        				
        			</div>
        			
        			<!-- Single Block Wrap -->
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Walk Scores</h4>
        				</div>
        				
        				<div class="_prtis_list_body"> 
                        <div class="_walk_score_wrap">
                        <?php
                         function getWalkScore($lat, $lon, $address) {
                          $address=urlencode($address);
                          $url = "https://api.walkscore.com/score?format=json&address=$address&lat=$lat&lon=$lon&transit=1&bike=1&wsapikey=".WEBWALKSCOREAPI; 
                          $str = @file_get_contents($url);
                          return $str;
                         }
                        
                         $address = stripslashes($PropertyAddress);
                         $json = getWalkScore($Latitude,$Longitude,$address);
                         $data = json_decode($json);
                        ?>
                        <!-- Single Item -->
                        <div class="_walk_score_list">
                        	<div class="_walk_score_flex">
                        		<div class="_walk_score_view">
                        			<h4 class="view_walk"><?php echo $data->walkscore;?></h4>
                        		</div>
                        		<div class="_walk_score_caption">
                        			<h5>Walk Scores</h5>
                        			<span><?php echo $data->description;?></span>
                        		</div>
                        	</div>
                        </div>
                        
                        <!-- Single Item -->
                        <div class="_walk_score_list">
                        	<div class="_walk_score_flex">
                        		<div class="_walk_score_view">
                        			<h4 class="view_walk"><?php echo $data->bike->score;?></h4>
                        		</div>
                        		<div class="_walk_score_caption">
                        			<h5>Bikeable Scores</h5>
                        			<span><?php echo $data->bike->description;?></span>
                        		</div>
                        	</div>
                        </div>
                        
                        <!-- Single Item -->
                        <?php
                        if($data->transit->score!=''){
                        ?>
                        <div class="_walk_score_list">
                        	<div class="_walk_score_flex">
                        		<div class="_walk_score_view">
                        			<h4 class="view_walk"><?php echo $data->transit->score;?></h4>
                        		</div>
                        		<div class="_walk_score_caption">
                        			<h5>Transit Scores</h5>
                        			<span><?php echo $data->transit->description;?></span>
                        		</div>
                        	</div>
                        </div>
                        <?php
                        }
                        ?>
                        </div>
        				</div>
        				
        			</div> 
        			
                    <?php
                    if($ElementarySchool!='' || $MiddleSchool!='' || $HighSchool!=''){
                    ?>					
        			<!-- Single Block Wrap -->
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Schools</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
        					<ul class="deatil_features">
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $ElementarySchool;?></strong>Elementary School</li>
                                <li style="min-width: 100%; max-width: 100%;"><strong><?php echo $MiddleSchool;?></strong>Middle School</li>
                                <li style="min-width: 100%; max-width: 100%;"><strong><?php echo $HighSchool;?></strong>High School</li>
                            </ul>
                        </div>
                    </div>
        			<?php
                    }
                    ?>
                    							
        			<!-- Single Block Wrap -->
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Taxes</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
        					<ul class="deatil_features">
                                <li style="min-width: 100%; max-width: 100%;"><strong>$<?php echo number_format($Taxes,0);?></strong>Taxes</li>
                                <li style="min-width: 100%; max-width: 100%;"><strong><?php echo $TaxYear;?></strong>Tax Year</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $TaxDesc;?></strong>Tax Description</li>
                                <li style="min-width: 100%; max-width: 100%;"><strong><?php echo $TaxDistrictType;?></strong>Tax District Type</li>
                            </ul>
                        </div>
                    </div>
        			 							
        			<!-- Single Block Wrap -->
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Home Owner Association</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
        					<ul class="deatil_features">
                                <li style="min-width: 100%; max-width: 100%;"><strong>$<?php echo number_format($HOAFee,0);?></strong>HOA Fee</li>
        						<li style="min-width: 100%; max-width: 100%;"><strong><?php echo $HOADesc;?></strong>HOA Description</li>
                                <li style="min-width: 100%; max-width: 100%;"><strong><?php echo $HOAFeeFreq;?></strong>HOA Fee Freq</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="_prtis_list mb-4">
        				
        				<div class="_prtis_list_header min">
        					<h4 class="m-0">Disclaimer</h4>
        				</div>
        				
        				<div class="_prtis_list_body">
                            <div class="w-100 dsply_inline_blck">
        					The source of this real property information is the copyrighted and proprietary database compilation of the M.L.S. of Naples, Inc. 
                            Copyright <?php echo date("Y");?> M.L.S. of Naples, Inc. All rights reserved. The accuracy of this information is not warranted or guaranteed. 
                            This information should be independently verified if any person intends to engage in a transaction in reliance upon it.
                            </div>
                            
                            <div class="w-100 dsply_inline_blck pt-15">
                            <div class="w-100"><i class="far fa-building"></i> <b>Listed By:</b> <?php echo $ListAgentFullName;?><br /><?php echo $ListOfficeName;?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="_prtis_list mb-4 centered-text">
                    <div class="col-md-7 m-auto p-30 xs-p-10">
                    <h4 class="w-100 p-10 xs-p-0 xs-fs-16">Ask Question Or Schedule a Tour <br/>It's Free!</h4>
                    <ul class="nav nav-pills sider_tab" id="pillss-tab" role="tablist">
					  <li class="nav-item" data-toggle="tooltip" title="Get More Information About This Property">
						<a class="nav-link no_radius pointer" style="background-color: #09AFFF;" onclick="openGetInfo('<?php echo $MLSNumber;?>')"><i class="ti-email"></i>&nbsp; Get More Info</a>
					  </li>
					  <li class="nav-item" data-toggle="tooltip" title="Schedule a Tour On This Property">
						<a class="nav-link no_radius pointer" style="background-color: #09AFFF;" onclick="openTourModal('<?php echo $MLSNumber;?>')"><i class="ti-calendar"></i>&nbsp; Schedule Tour</a>
					  </li>
					</ul>
                    </div>
                    </div>
                    
        		</div>
        		
        		<!-- property Sidebar -->
        		<div class="col-lg-4 col-md-12 col-sm-12">
        			<div class="property-sidebar side_stiky">
        				<div class="sider_blocks_wrap shadow hide_for_mobile">
        					<div class="side-booking-header">
        						<ul class="nav nav-pills sider_tab" id="pillss-tab" role="tablist">
        						  <li class="nav-item" data-toggle="tooltip" title="Get More Information About This Property">
        							<a class="nav-link no_radius pointer" style="background-color: #09AFFF;" onclick="openGetInfo('<?php echo $MLSNumber;?>')"><i class="ti-email"></i>&nbsp; Get More Info</a>
        						  </li>
        						  <li class="nav-item" data-toggle="tooltip" title="Schedule a Tour On This Property">
        							<a class="nav-link no_radius pointer" style="background-color: #09AFFF;" onclick="openTourModal('<?php echo $MLSNumber;?>')"><i class="ti-calendar"></i>&nbsp; Schedule Tour</a>
        						  </li>
        						</ul>
        					</div>
        				</div>
                        
                        <div class="sider_blocks_wrap shadow">
							<div class="side-booking-header">
								<h4 class="m-0">Mortgage Calculator</h4>
							</div>
							
							<div class="sider-block-body p-3">
								<div class="form-group" data-toggle="tooltip" title="Property Listing Price">
									<div class="input-with-icon">
                                        <input type="number" class="form-control" min="1" name="mortgage_price" id="mortgage_price" placeholder="Price" value="<?php echo intval($ListPrice);?>" onkeyup="calculateMortgage()" onchange="calculateMortgage()" />
										<i class="ti-money"></i>
									</div>
								</div>
								
								<div class="form-group" data-toggle="tooltip" title="Mortgage Down Payment in Percentage (%)">
									<div class="input-with-icon">
										<input type="number" class="form-control" min="0" name="mortgage_downpay" id="mortgage_downpay" placeholder="Down Payment (%)" value="20" onkeyup="calculateMortgage()" onchange="calculateMortgage()" />
										<i class="fas fa-percent fs-13"></i>
									</div>
								</div>
								
								<div class="form-group" data-toggle="tooltip" title="Mortgage Terms in Years">
									<div class="input-with-icon">
										<input type="number" class="form-control" min="1" name="mortgage_terms" id="mortgage_terms" placeholder="Term (Year)" value="30" onkeyup="calculateMortgage()" onchange="calculateMortgage()" />
										<i class="ti-calendar"></i>
									</div>
								</div>
								
								<div class="form-group" data-toggle="tooltip" title="Mortgage Rate in Percentage (%)">
									<div class="input-with-icon">
										<input type="number" class="form-control" min="0" name="mortgage_rate" id="mortgage_rate" placeholder="Rate (%)" value="2.5" onkeyup="calculateMortgage()" onchange="calculateMortgage()" />
										<i class="fas fa-percent fs-13"></i>
									</div>
								</div>
								<div class="mortgage mb-2" id="mortgage_value"></div>
							</div>
						</div>
                        
                        
                        
                        <div class="sidebar-widgets">
                        	
                        	<h4>Similar Property</h4>
                        	
                        	<div class="sidebar_featured_property">
                       	    <?php include 'similar_properties.php';?>
                        	</div>
                        	
                        </div>
        			</div>
        		</div>
        		
        	</div>
        </div>
        </section>
        <!-- ============================ Property Detail Ends ================================== -->
		
        <?php include "call_to_action.php"?>
        <!-- ============================================================== -->
        <?php include_once 'footer.php';?>
        <script type="text/javascript">
        
        $(function(){        
        $('.popup-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            disableOn: 300
        });
        });
        
        $(document).ready(function(){
            
        initMapx();
        
        /** get date **/
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth()).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        /** get date **/
        
        $('#tour_date').pickadate({
        // Escape any 'rule' characters with an exclamation mark (!).
        format: 'mm-dd-yyyy',
        formatSubmit: 'mm-dd-yyyy',
        min: [yyyy,mm,dd],
        today: 'Today',
        beforeShow: function(input, inst) {
            inst.dpDiv.css({
                marginTop: -input.offsetHeight + 'px', 
                marginLeft: input.offsetWidth + 'px'
            });
        }
        });
        
        $('#tour_time').pickatime({
           min: [9,0],
           max: [19,0]
        });
        
        calculateMortgage();
        
        
        
        $(".deatil_features li strong").each(function(){
        if($(this).text() == ''){
            $(this).parent('li').remove();
        }
        }); 
        });
        
        
        function calculateMortgage(){
        	
            var price = $("#mortgage_price").val();
            var downpay = $("#mortgage_downpay").val();
            var terms = $("#mortgage_terms").val();
            var rate = $("#mortgage_rate").val();
            
            if(!price || !downpay || !terms || !rate){
            $.notify({ icon: 'fas fa-exclamation-triangle', message: 'All feilds are required' },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } });
            return false;
            }
        		
        	if (price != "0" && terms != "0"  && rate != "0" ){ 
        	
            if(downpay>0){
               var downPrcntVal = (downpay/100) * price;
               var principal = price - downPrcntVal;
            }else{
               var principal = price;
            } 
            
        	var t_years = eval(terms*12) 
        	var t_interest = eval(rate/1200); 
        	var t = eval(1.0 /(Math.pow((1+t_interest),t_years))); 
        		
        		if(t < 1){ 
        			var payment = eval((principal*t_interest)/(1-t)); 
        		} else { 
        			var payment = eval(amt/$t_years); 
        		} 
        		
        	var total = payment.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
        	$("#mortgage_value").html('$'+total+' Monthly Payment'); 
        	
        	}else{
            $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Rate, Price and Terms must be greater than 0.' },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } });
        	}
        		
        }
        
        
        /** map **/
        /** When the window has finished loading create our google map below **/
        
        var poi_marker_array = [];
        var poi_type = '';
        function initMapx(){
            poi_marker_array = [];
            $('.poi_active').removeClass('poi_active'); /** incase of refresh button **/
            
            var curent_gview_lat = jQuery('#googleMap_shortcode').attr('data-cur_lat');
            var curent_gview_long = jQuery('#googleMap_shortcode').attr('data-cur_long');
            var viewPlace = new google.maps.LatLng(curent_gview_lat, curent_gview_long);
            
            var mapOptions = {
                zoom: 15,
                center: viewPlace,
                
                flat: false,
                noClear: false,
                scrollwheel: false,
                draggable: true,
                streetViewControl: false,
                disableDefaultUI: true,
                gestureHandling: 'cooperative',
                    
                styles: [{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [ { "color": "#444444" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "color": "#f2f2f2" } ] }, { "featureType": "landscape", "elementType": "labels.text", "stylers": [ { "visibility": "on" }, { "hue": "#ff0000" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": -100 }, { "lightness": 45 } ] }, { "featureType": "road.highway", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "color": "#0CC3F8" }, { "visibility": "on" } ] } ]
               };
            var mapElement = document.getElementById('googleMap_shortcode');
            var map = new google.maps.Map(mapElement, mapOptions);
            
            var Marker = new google.maps.Marker({
                position: viewPlace,
                map: map,
                icon: 'assets/img/home-icon-google-map.png'
            }); 
            Marker.setAnimation(google.maps.Animation.BOUNCE);
        
            if (typeof(panorama_sh) === 'undefined') {
                var panorama_sh;
            }
            panorama_sh = map.getStreetView();
            panorama_sh.setPosition(viewPlace);
            panorama_sh.setPov(({
                heading: 0,
                pitch: 0
            }));
            
            wpestate_initialize_poi(map);
            
            $('#slider_enable_street_sh').on('click', function() {
                var cur_lat = $('#googleMap_shortcode').attr('data-cur_lat');
                var cur_long = $('#googleMap_shortcode').attr('data-cur_long');
                /** var myLatLng = new google.maps.LatLng(cur_lat, cur_long); **/
                var myLatLng = viewPlace;
                panorama_sh.setPosition(myLatLng);
                panorama_sh.setVisible(true);
                $('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').hide();
            });
            
            google.maps.event.addListener(panorama_sh, "closeclick", function() {
                $('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').show();
            });
            
            if(document.getElementById('gmapzoomplus_sh')){
                $('#gmapzoomplus_sh').on('click', function(){
                    "use strict";
                    var current = parseInt(map.getZoom(), 10);
                    current++;
                    if(current > 20){
                        current = 20;
                    }
                    map.setZoom(current);
                });
            }
            
            if(document.getElementById('gmapzoomminus_sh')){
                $('#gmapzoomminus_sh').on('click', function(){
                    "use strict";
                    var current = parseInt(map.getZoom(), 10);
                    current--;
                    if(current < 0){
                        current = 0;
                    }
                    map.setZoom(current);
                });
            }
        }
        
        
        var wpestate_initialize_poi = function(map_for_poi){
        
            var poi_service = new google.maps.places.PlacesService(map_for_poi);
            var already_serviced = '';
            var show_poi = '';
            var map_bounds = map_for_poi.getBounds();
            var selector = '.google_poish';
            
            $(selector).on('click', function(event) {
                event.stopPropagation();
                poi_type = $(this).attr('id');
                var position = map_for_poi.getCenter();
                var show_poi = wpestate_return_poi_values(poi_type);
                if ($(this).hasClass('poi_active')) {
                    wpestate_show_hide_poi(poi_type, 'hide');
                } else {
                    already_serviced = wpestate_show_hide_poi(poi_type, 'show'); 
                    if (already_serviced === 1) {
                        var request = {
                            location: position,
                            types: show_poi,
                            bounds: map_bounds,
                            radius: 2500,
                        };
                        poi_service.nearbySearch(request, function(results, status) {
                            wpestate_googlemap_display_poi(results, status, map_for_poi);
                        });
                    }
                }
                $(this).toggleClass('poi_active');
            });
            var wpestate_return_poi_values = function(poi_type) {
                var show_poi;
                switch (poi_type) {
                    case 'transport':
                        show_poi = ['bus_station', 'airport', 'train_station', 'subway_station'];
                        break;
                    case 'supermarkets':
                        show_poi = ['grocery_or_supermarket', 'shopping_mall'];
                        break;
                    case 'schools':
                        show_poi = ['school', 'university'];
                        break;
                    case 'restaurant':
                        show_poi = ['restaurant'];
                        break;
                    case 'gym':
                        show_poi = ['gym'];
                        break;
                    case 'hospitals':
                        show_poi = ['hospital'];
                        break;
                }
                return show_poi;
            };
            var wpestate_googlemap_display_poi = function(results, status, map_for_poi) {
                var place, poi_marker;
                if (google.maps.places.PlacesServiceStatus.OK == status) {
                    for (var i = 0; i < results.length; i++) {
                        poi_marker = wpestate_create_poi_marker(results[i], map_for_poi);
                        poi_marker_array.push(poi_marker);
                    }
                }
            };
            var wpestate_create_poi_marker = function(place, map_for_poi) {
                var marker = new google.maps.Marker({
                    map: map_for_poi,
                    position: place.geometry.location,
                    show_poi: poi_type,
                    icon: 'assets/img/icons/' + poi_type + '.png'
                });
                var boxText = document.createElement("div");
                var infobox_poi = new InfoBox({
                    content: boxText,
                    boxClass: "estate_poi_box",
                    pixelOffset: new google.maps.Size(-30, -70),
                    zIndex: null,
                    maxWidth: 275,
                    closeBoxMargin: "-13px 0px 0px 0px",
                    closeBoxURL: "",
                    infoBoxClearance: new google.maps.Size(1, 1),
                    pane: "floatPane",
                    enableEventPropagation: false
                });
                google.maps.event.addListener(marker, 'mouseover', function(event) {
                    infobox_poi.setContent(place.name);
                    infobox_poi.open(map_for_poi, this);
                });
                google.maps.event.addListener(marker, 'mouseout', function(event) {
                    if (infobox_poi !== null) {
                        infobox_poi.close();
                    }
                });
                return marker;
            };
            var wpestate_show_hide_poi = function(poi_type, showhide) {
                var is_hiding = 1;
                for (var i = 0; i < poi_marker_array.length; i++) {
                    if (poi_marker_array[i].show_poi === poi_type) {
                        if (showhide === 'hide') {
                            poi_marker_array[i].setVisible(false);
                        } else {
                            poi_marker_array[i].setVisible(true);
                            is_hiding = 0;
                        }
                    }
                }
                return is_hiding;
            };
        };
        
        
        
        function shareProperty(){
            var uniq_id=encodeURIComponent($("#share_mls_number").val().trim()); 
            var from_email = $("#share_from_email").val().trim();
            var to_email = $("#share_to_email").val().trim();
            var message=encodeURIComponent($("#share_to_message").val().trim());
            
            if(to_email.indexOf(',') !== -1){
                var spltTos = to_email.split(',');
                for(var i = 0; i<spltTos.length; i++){
                    if(spltTos[i]!=''){
                       if(!validateEmail(spltTos[i])){
                        $.notify({ icon: 'fas fa-exclamation-triangle', message: 'One of the recipient email is not valid' },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
                        return false;
                       }
                    }
                }
            }
            
            if(validateEmail(from_email)){
            var from_email=encodeURIComponent(from_email);
            if((from_email!='') && (uniq_id!='') && (to_email!='')){
            var dataString ='uniq_id='+uniq_id+'&from_email='+from_email+'&to_email='+to_email+'&message='+message; 
            //alert(dataString)
            $('#ShareButton').attr('disabled',true);  
            $('#ShareButton').html('Please wait...').addClass('disabled'); 
           
            $.ajax({
            url: "share_property.php",
            type: "POST",
            dataType: "json",
            data: dataString,
            timeout: 120000,
            error: function(xhr, status, error){
            $('#ShareButton').attr('disabled',false);  
            $('#ShareButton').html('<i class="fas fa-envelope"></i> &nbsp;Share').removeClass('disabled'); 
            $.notify({ icon: 'fas fa-exclamation-triangle', message: xhr.responseText },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
            },
            success: function(data){  
            var dataData=data.data; 
            $('#ShareButton').attr('disabled',false);  
            $('#ShareButton').html('<i class="fas fa-envelope"></i> &nbsp;Share').removeClass('disabled');   
            if(dataData=='Done'){
            $("#share_to_email").val('');
            $("#shareProperty").modal("hide");
            $.notify({ icon: 'fas fa-check', message: 'Property successfully shared.' },{ type: 'success', timer: 4000, placement: { from: "top", align: "center" }  }); 
            }else{
            
            $('#page_loader').hide();     
            $.notify({ icon: 'fas fa-exclamation-triangle', message: dataData },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
              
            } 
            }
            
            });
            }else{ 
            $.notify({ icon: 'fas fa-exclamation-triangle', message: 'From and to address are required.' },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  }); 
            }  
            }else{
             $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Provide a valid email.'},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } }); 
            } 
        }
        
        
        function getAreaPriceAlerts(city,price){
            var email = $("#get_city_price_alerts").val().trim();
            if(validateEmail(email)){
            email = encodeURIComponent(email);
            city = encodeURIComponent(city);
            price = encodeURIComponent(price);
             
            $('#getCityAlerts').attr('disabled',true);  
            $('#getCityAlerts').html('Loading...').addClass('disabled'); 
            
            var dataString ='email='+email+'&city='+city+'&price='+price; 
            //alert(dataString)
            $('#page_loader').show();
            $.ajax({
            url: "get_city_price_alerts.php",
            type: "POST",
            dataType: "json",
            data: dataString,
            timeout: 120000,
            error: function(xhr, status, error){
            $('#getCityAlerts').attr('disabled',false);  
            $('#getCityAlerts').html('Get Alerts').removeClass('disabled'); 
            $.notify({ icon: 'fas fa-exclamation-triangle', message: xhr.responseText },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
            },
            success: function(data){  
            var dataData=data.data; 
            $('#getCityAlerts').attr('disabled',false);  
            $('#getCityAlerts').html('Get Alerts').removeClass('disabled'); 
              
            if(dataData=='Done'){ 
            
            $.notify({ icon: 'fas fa-check', message: 'Subscribed successfully' },{ type: 'success', timer: 4000, placement: { from: "top", align: "center" }  }); 
            
            }else{
            
            $('#page_loader').hide();     
            $.notify({ icon: 'fas fa-exclamation-triangle', message: dataData },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
              
            } 
            }
            
            });
            }else{ 
            $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Provide a valid email address.' },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  }); 
            }
        }
        </script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo WEBMAPAPI;?>&libraries=places"></script>
        <script src="assets/js/infobox.min-1.0.js" type="text/javascript"></script>
         
        <div id="mob_srch_fxd_info">
        <a onclick="openGetInfo('<?php echo $MLSNumber;?>')"><i class="ti-email"></i>&nbsp; Get More Info</a>
        </div>
        
        <div id="mob_srch_fxd_tour">
        <a onclick="openTourModal('<?php echo $MLSNumber;?>')"><i class="ti-calendar"></i>&nbsp; Schedule Tour</a>
        </div>				  
                                  
    </div>
</body>
</html>
<?php

}else{
    echo '<script type="text/javascript">window.location.href="/";</script>';  
}


}else{
    echo '<script type="text/javascript">window.location.href="/";</script>';  
}
?>