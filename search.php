<?php
include 'connect.php';
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);
//error_reporting(1);
$page = 'home';
$favoritesArray=json_decode($_SESSION['fav_ids'], true);

if(isset($_GET['location']) && isset($_GET['property_type']) && isset($_GET['page']) && isset($_GET['pagination'])){

$xmls_number=$_GET["mls_number"];
$location=filterThis($_GET["location"],$conn);
$property_type=$_GET["property_type"]; 
$min_price=$_GET["min_price"];  
$max_price=$_GET["max_price"];  
$city=filterThis($_GET["city"],$conn);
$zipcode=filterThis($_GET["zipcode"],$conn);  
$bedrooms=$_GET["beds"];  
$bathrooms=$_GET["baths"];     
$min_sq_ft=$_GET["min_sq_ft"]; 
$max_sq_ft=$_GET["max_sq_ft"]; 
$min_year=$_GET["min_year"]; 
$garage=$_GET["garage"];
$just_listed=$_GET["just_listed"];
$include_sold=$_GET["include_sold"];
$foreclosure=$_GET['foreclosure'];
$short_sale=$_GET["short_sale"];
$pool=$_GET["pool"];   
$spa=$_GET["spa"];
$guest_house=$_GET["guest_house"];
$waterfront=$_GET["waterfront"];    
$gated=$_GET["gated"];
$communities=$_GET["communities"];
$gulf_access=$_GET["gulf_access"];
$ref=$_GET["ref"];
$sort_by=$_GET["sort"];
$page=$_GET['page'];
$pagination=$_GET['pagination'];

if(isset($_SESSION['logged_email']) && $user_id!=''){
$sqlUserSearch = "SELECT search_id FROM user_searches WHERE user_id='$user_id' AND location='$location' AND min_price='$min_price' AND max_price='$max_price' AND property_type='$property_type'";  
$usrSrchRslt=mysqli_query($conn, $sqlUserSearch) or die(mysqli_error($conn)); 
$searched=mysqli_num_rows($usrSrchRslt); 
$date = date("Y-m-d H:i:s"); 

if($searched == '0'){
    $addSearch="INSERT INTO user_searches(user_id, location, min_price, max_price, property_type, date) VALUES('$user_id', '$location', '$min_price', '$max_price', '$property_type', '$date')";
}else{
    $rowSrch = mysqli_fetch_array($usrSrchRslt);
    $search_id = $rowSrch['search_id'];
    
    $addSearch = "UPDATE user_searches SET date='$date' WHERE search_id='$search_id' AND user_id='$user_id'"; 
}
    $addSrchRslt=mysqli_query($conn, $addSearch) or die(mysqli_error($conn));    
}

$limit = 20;
$pageNumber = intval($_GET['page']);
$dflt_params='location='.$location.'&mls_number='.$xmls_number.'&min_price='.$min_price.'&max_price='.$max_price.'&property_type='.$property_type.'&city='.$city.'&zipcode='.$zipcode.'&beds='.str_replace('+','%2B',$bedrooms).'&baths='.str_replace('+','%2B',$bathrooms).'&min_sq_ft='.$min_sq_ft.'&max_sq_ft='.$max_sq_ft.'&min_year='.$min_year.'&garage='.str_replace('+','%2B',$garage).'&just_listed='.$just_listed.'&include_sold='.$include_sold.'&foreclosure='.$foreclosure.'&short_sale='.$short_sale.'&pool='.$pool.'&spa='.$spa.'&guest_house='.$guest_house.'&waterfront='.$waterfront.'&sort='.$sort_by.'&gated='.$gated.'&communities='.$communities.'&gulf_access='.$gulf_access.'&ref='.$ref.'&sort='.$sort_by.'&page='.$page.'&pagination='.$pagination.'&dfltLat='.$dfltLat.'&dfltLng='.$dfltLng.'&aNord=&aEst=&aSud=&aOvest=&zoom=14';

if($location!='Any' && $location!=''){
  
  $search = explode(" ",$location);
  $each = "";
  foreach($search AS $keyword){
        //$each .=" OR (City LIKE '$keyword%' OR PostalCode LIKE '%$keyword%' OR Development LIKE '$keyword%' OR DevelopmentName LIKE '$keyword%' OR PropertyAddress LIKE '%$keyword%')"; 
  }
    
  //$each = substr($each, 0, -3); /** remove last OR **/
  
  $qry_loc=" (City LIKE '%$location%' OR PostalCode LIKE '%$location%' OR Development LIKE '%$location%' OR DevelopmentName LIKE '%$location%' OR PropertyAddress LIKE '%$location%') "; //.$each; 
  $orderCase = "CASE WHEN PropertyAddress LIKE '%$location%' THEN 0  
                     WHEN City LIKE '%$location%' THEN 1  
                     WHEN PostalCode LIKE '%$location%' THEN 2 
                     ELSE 3
                END,"; 
}else{
  $qry_loc=" city!='0' "; /** since city could be empty **/ 
}

if($city!='Any' && $city!=''){
    $qry_city = " City='$city' ";
}

if($zipcode!='Any' && $zipcode!=''){
    $qry_zipcode = " PostalCode='$zipcode' ";
}

if($communities && $communities!=''){
    
    $xpldComm = explode(',',$communities);
    $commIdArr = array();
    
    foreach($xpldComm as $comms){
        if($comms!=''){
            $xplId = explode(":", $comms);
            $commID = $xplId[0];
            array_push($commIdArr,$commID);
        }
    }
    $commIdArr = implode("','",$commIdArr);

    $selComm = "SELECT name FROM all_communities WHERE community_id IN ('".$commIdArr."')";  
    $commRslts = mysqli_query($conn,$selComm);  
    $noComm = mysqli_num_rows($commRslts);
    $commArray=array();
        
    if($noComm>0){
        while($rowCm = mysqli_fetch_assoc($commRslts)){
            $commName = $rowCm['name'];
            array_push($commArray, $commName);
        } 
        
        $commNameArr = implode("','",$commArray);
        $qry_comm = "(Development IN ('$commNameArr') OR DevelopmentName IN ('$commNameArr'))";
    }else{
        $qry_comm = "";
    }
    
}else{
    $qry_comm = "";
}

if($property_type!='Any' && $property_type!=''){
  
  /**
  $expld=explode(',',$property_type); 
  $pptyTypCnt=1;
  $ppty_qry='';
  foreach($expld as $pptyType){
    if($pptyType!=''){
      if($pptyTypCnt>1){
        $or=' OR ';
        $open="(";
        $close=")";
      }else{
        $or='';
        $open="";
        $close="";
      }
      
      if($pptyType!='Rental Investments' && $pptyType!='Land/Lot' && $pptyType!='Manufactured On Land' && $pptyType!='Rooms for Rent'){
      $ppty_qry.= " $or PropertySubType='$pptyType' ";
      }else if($pptyType=='Land/Lot'){
      $ppty_qry.= " $or PropertyClass='Land' ";
      }else if($pptyType=='Manufactured On Land'){
      $ppty_qry.= " $or PropertyClass='ManufacturedInPark' ";
      }else if($pptyType=='Rental Investments'){
      $ppty_qry.= " $or PropertyClass='ResidentialIncome' ";
      }else if($pptyType=='Rooms for Rent'){
      $ppty_qry.= " $or PropertyClass='ResidentialLease' ";
      }
      
      $pptyTypCnt++;
    }
  }
  **/
  if($property_type=='Homes'){
  $ppty_qry = " PropertyClass='RES' ";
  }else if($property_type=='Condos'){
  $ppty_qry = " CommunityType LIKE '%Condo%' ";
  }else if($property_type=='Land'){
  $ppty_qry = " PropertyClass='LOT' ";
  }else if($property_type=='Commercial'){
  $ppty_qry = " PropertyClass='COM' ";
  }else if($property_type=='Multi-Family'){
  $ppty_qry = " CommunityType LIKE '%Multi-Family%' ";
  }else if($property_type=='Town Homes'){
  $ppty_qry = " CommunityType LIKE '%Town Homes%' ";
  }else if($property_type=='Dock'){
  $ppty_qry = " PropertyClass='DOCK' ";
  }
                 
  $qry_type=" AND $ppty_qry "; 
  //$qry_type=" AND $open$ppty_qry$close ";  
  //$qry_type = " AND PropertyClass='$property_type' ";   
}else{
  
  if($ref == 'quick'){
    $qry_type=" AND (PropertyClass='RES' OR PropertyClass='RIN')";  
  }else{
    $qry_type="";  
  }
  
}


if($bedrooms!='Any' && $bedrooms!=''){ 
  if(strpos($bedrooms, '+') !== false){
    $bedz=str_replace('+','',$bedrooms);
    $qry_beds=" AND BedsTotal>=$bedz"; 
  }else{
    $qry_beds=" AND BedsTotal=$bedrooms"; 
  }  
}else{
  $qry_beds="";  
}

if($bathrooms!='Any' && $bathrooms!=''){
  if(strpos($bathrooms, '+') !== false){
    $bathz=str_replace('+','',$bathrooms);
    $qry_baths=" AND BathsTotal>=$bathz"; 
  }else{
    $qry_baths=" AND BathsTotal=$bathrooms"; 
  }
    
}else{
  $qry_baths="";  
}

if($garage!='Any' && $garage!=''){ 
  if(strpos($garage, '+') !== false){
    $garageX=str_replace('+','',$garage);
    $qry_garage=" AND GarageSpaces>=$garageX"; 
  }else{
    $qry_garage=" AND GarageSpaces=$garage"; 
  }  
}else{
  $qry_garage="";  
}


if(($min_price!='Any' && $min_price!='') || ($max_price!='Any' && $max_price!='')){
if(($min_price!='Any' && $min_price!='') && ($max_price=='Any' || $max_price=='')){
 $qry_min_max_pri_join=" AND (ListPrice>=$min_price AND ListPrice>0)"; 
}else if(($min_price=='Any' || $min_price=='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND (ListPrice<=$max_price AND ListPrice>0)"; 
}else if(($min_price!='Any' && $min_price!='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND (ListPrice>=$min_price AND ListPrice<=$max_price AND ListPrice>0)";   
}  
}else{
 $qry_min_max_pri_join=" AND ListPrice>0";
} 


if(($min_sq_ft!='Any' && $min_sq_ft!='') || ($max_sq_ft!='Any' && $max_sq_ft!='')){
if(($min_sq_ft!='Any' && $min_sq_ft!='') && ($max_sq_ft=='Any' || $max_sq_ft=='')){
 $qry_lot_size=" AND TotalArea>=$min_sq_ft"; 
}else if(($min_sq_ft=='Any' || $min_sq_ft=='') && ($max_sq_ft!='Any' && $max_sq_ft!='')){
 $qry_lot_size=" AND TotalArea<=$max_sq_ft"; 
}else if(($min_sq_ft!='Any' && $min_sq_ft!='') && ($max_sq_ft!='Any' && $max_sq_ft!='')){
 $qry_lot_size=" AND (TotalArea>=$min_sq_ft AND TotalArea<=$max_sq_ft)";   
}  
}


if($min_year!='Any' && $min_year!=''){ 
  $qry_year_built=" AND YearBuilt>=$min_year"; 
}else{
  $qry_year_built="";  
}


if($just_listed=='Yes'){
  $qry_jst_listed=" AND DOM<=3";  /** Three days **/
}else{
  $qry_jst_listed="";  
} 


if($include_sold=='Yes'){
  $qry_status=" AND (Status='Active' OR Status='Pending' OR Status='Pending With Contingencies' OR Status='Application In Progress' OR Status='Sold')";  
}else{
  $qry_status=" AND Status='Active'";   
} 


if($foreclosure=='Yes'){
  $qry_foreclsre=" AND ForeclosedREOYN='1'";  
}else{
  $qry_foreclsre="";   
} 


if($short_sale=='Yes'){
  $qry_ss=" AND PotentialShortSaleYN='1'";  
}else{
  $qry_ss="";  
} 


if($short_sale=='Yes'){
  $qry_ss=" AND PotentialShortSaleYN='1'";  
}else{
  $qry_ss="";  
} 


if($pool=='Yes'){
  $qry_pool=" AND (PrivatePoolYN='1' OR Amenities LIKE '%pool%')";  
}else{
  $qry_pool="";  
} 


if($spa=='Yes'){
  $qry_spa=" AND PrivateSpaYN='1'";  
}else{
  $qry_spa="";  
} 


if($guest_house=='Yes'){
  $qry_gee_house=" AND (GuestHouseDesc!='' OR AdditionalRooms LIKE '%guest%')";  
}else{
  $qry_gee_house="";  
} 

if($waterfront=='Yes'){
  $qry_waterfrnt=" AND (WaterfrontDesc!='None' AND WaterfrontYN='1')";  
}else{
  $qry_waterfrnt="";  
}


if($gated=='Yes'){
  $qry_gated=" AND (CommunityType LIKE '%Gated%' AND CommunityType!='Non-Gated')";  
}else{
  $qry_gated="";  
} 

if($gulf_access=='Yes'){
  $qry_gulf=" AND GulfAccessYN='1'";  
}else{
  $qry_gulf="";  
} 


if($sort_by=="sqft-asc"){
 $order_by="CAST(TotalArea AS SIGNED) ASC";   
}else if($sort_by=="sqft-desc"){
 $order_by="CAST(TotalArea AS SIGNED) DESC";   
}else if($sort_by=="baths-asc"){
 $order_by="BathsTotal ASC";    
}else if($sort_by=="baths-desc"){
 $order_by="BathsTotal DESC";    
}else if($sort_by=="beds-asc"){
 $order_by="BedsTotal ASC";    
}else if($sort_by=="beds-desc"){
 $order_by="BedsTotal DESC";    
}else if($sort_by=="garages-asc"){
 $order_by="GarageSpaces ASC";    
}else if($sort_by=="garages-desc"){
 $order_by="GarageSpaces DESC";    
}else if($sort_by=="price-asc"){
 $order_by="CAST(ListPrice AS SIGNED) ASC";   
}else if($sort_by=="price-desc"){
 $order_by="CAST(ListPrice AS SIGNED) DESC";   
}else if($sort_by=="built-asc"){
 $order_by="YearBuilt ASC";   
}else if($sort_by=="built-desc"){
 $order_by="YearBuilt DESC";   
}else if($sort_by=="new-asc"){
 $order_by="DOM ASC";   
}else if($sort_by=="new-desc"){
 $order_by="DOM DESC";   
}else{ /** not set **/
 $order_by="CAST(ListPrice AS SIGNED) ASC"; 
 $sort_by = 'price-asc';  
}

/** if type is not residentials and rentals, no need for beds and baths check or swimming pool and other features **/
if($xmls_number==''){
    
    if($location!='Any' && $location!=''){ /** quick search **/
        $final_loc_qry = $qry_loc; 
    }else{
        if($city!='Any' && $city!=''){ /** Using city **/
            if($communities && $communities!=''){
            $final_loc_qry = "$qry_city AND $qry_comm";
            }else{
            $final_loc_qry = $qry_city; 
            }  
        }else if($zipcode!='Any' && $zipcode!=''){ /** Using zip Code **/
            $final_loc_qry = $qry_zipcode; 
        }else{ /** both empty **/
            $final_loc_qry = " city!='0' "; 
        }
    }
    
    if($property_type=='Land' && $property_type=='Dock'){
      $query=$final_loc_qry.$qry_type.$qry_min_max_pri_join.$qry_lot_size.$qry_year_built.$qry_jst_listed.$qry_status.$qry_foreclsre.$qry_ss.$qry_waterfrnt.$qry_gated.$qry_gulf; 
    }else{
      $query=$final_loc_qry.$qry_type.$qry_beds.$qry_baths.$qry_garage.$qry_min_max_pri_join.$qry_lot_size.$qry_year_built.$qry_jst_listed.$qry_status.$qry_foreclsre.$qry_ss.$qry_pool.$qry_spa.$qry_gee_house.$qry_waterfrnt.$qry_gated.$qry_gulf;
    }
    
    
}else{ /** ignore other queries and seach mls number only **/
$query=" MLSNumber='$xmls_number'";
}

$sqlTTL = "SELECT COUNT(MLSNumber) AS total_records FROM properties WHERE $query"; 
$ttlRslt = mysqli_query($conn,$sqlTTL); 
$rowQ = mysqli_fetch_assoc($ttlRslt); 
$total_records = $rowQ['total_records'];

$start_from = ($page-1) * $limit;
$toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, MatrixModifiedDT, other_fields_json';
$sqlPpty = "SELECT $toSel FROM properties WHERE $query ORDER BY $orderCase $order_by LIMIT $start_from, $limit"; //
$pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
$noProperties = mysqli_num_rows($pptyRslt);

if($xmls_number!=''){
if($noProperties>0){
$rowM = mysqli_fetch_array($pptyRslt);
extract($rowM);
$link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);

echo '<script type="text/javascript">window.location.href="homes-for-sale/'.$xmls_number.'/'.$link.'";</script>';
return;
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/" />
	<meta charset="utf-8" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    <title>Search Result | MVP Realty</title>
	
    <?php include_once 'styles.php';?>
    <script type="text/javascript">
    var curr_page='<?php echo $pageNumber;?>'; 
    var lm='<?php echo $limit;?>';
    var email = '<?php echo $logged_email;?>';
    var logged_email = '<?php echo $logged_email;?>';
    </script>
    
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
		<!-- ============================================================== -->
        
        <section class="gray pt-4 xs-pb-20 sm-pb-20">
        
        <div class="container">
        
        <div class="row m-0">
        	<div class="short_wraping no_radius shadow">
        		<div class="row align-items-center">
        	
        			<div class="col-lg-8 col-md-6 col-sm-12 col-sm-12">
                        <ul class="shorting_grid">
							
						</ul>
        				<div class="shorting_pagination xs-pb-0">
        					<div class="shorting_pagination_laft">
        						 <h4 class="fs-18"><a href="map-search.php?<?php echo $dflt_params;?>" class="medium fs-16" style="color: #008FD5;"><span class="ti-map-alt"></span>Map View</a>&nbsp;|&nbsp;<?php echo number_format($total_records,0);?> listings found</h4>
        					</div>
        				</div>
        			</div>
        	
        			<div class="col-lg-4 col-md-6 col-sm-12 col-sm-6">
        				<div class="shorting-right">
        					<label>Sort By:</label>
        					<div class="dropdown show">
        						<a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        							<span class="selection" id="selected_sorts"></span>
        						</a>
        						<div class="drp-select dropdown-menu">
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="price-desc" onclick="$('#advnc_sort_by').val('price-desc'); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Highest price</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="price-asc" onclick="$('#advnc_sort_by').val('price-asc'); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Lowest Price</a> 
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="sqft-desc" onclick="$('#advnc_sort_by').val('sqft-desc'); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Largest square footage</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="sqft-asc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Lowest square footage</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="beds-desc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Largest beds</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="beds-asc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Smallest beds</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="baths-desc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Largest baths</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="baths-asc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Smallest baths</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="built-desc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Year built new first</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="built-asc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Year built old first</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="new-desc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-down fs-13"></i> Sort by Newest listings first</a>
                                    <a class="dropdown-item" href="JavaScript:Void(0);" id="new-asc" onclick="$('#advnc_sort_by').val(this.id); AdvanceSearch('Side')"><i class="ti-arrow-up fs-13"></i> Sort by Oldest listings first</a>
                    
        						</div>
        					</div>
        				</div>
        			</div>
        			
        		</div>
        	</div>
        </div>
        
        <div class="row">
        	
        	<!-- property Sidebar --> 
        	<div class="col-lg-8 col-md-12 col-sm-12">
        		<div class="row justify-content-center">
        		  
                  
                    
                    
                    <input type="hidden" id="loc" value="" />
                    <?php
                    $today = strtotime(date("Y-m-d"));
                    if($noProperties>0){
                    
                    while($row = mysqli_fetch_array($pptyRslt)){
                    extract($row);
                    
                    $otherFieldsJson = json_decode($other_fields_json); 
                    $ListOfficeName = $otherFieldsJson->ListOfficeName;
                    $ListOfficePhone = $otherFieldsJson->ListOfficePhone;
                    
                    $MxModifiedDT = strtotime($MatrixModifiedDT);
                    $hotDiff = $today - $MxModifiedDT;
                    $justListed = floor($hotDiff / ( 60 * 60 ));
                    
                    if($justListed<=24){
                        if($justListed<1){
                            $domOut = 'New Hot';
                        }else{
                            $domOut = "New $justListed hours ago";
                        }
                        $domBadge = '<span class="_exlio_125 _list_blickes types shadow no_radius" style="background-color: #FFE2C6; color: #EA7500;"><i class="fas fa-fire"></i> &nbsp;'.$domOut.'</span>';
                    }else{
                        $domBadge = '';
                    }

                    //'ListingId,ListingKeyNumeric,StandardStatus,PropertyAddress,StreetName,StreetNumber,StreetSuffix,StreetDirSuffix,StreetNumberNumeric,City,PostalCode,DefaultPic,ListPrice,BedroomsTotal,BathroomsFull,BathroomsTotalInteger,GarageSpaces,LivingArea';
                    
                    $link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
                     
                    if(!$BedsTotal){
                        $BedsTotal = '0';
                    }
                    
                    if(!$BathsTotal){
                        $BathsTotal = '0';
                    }
                    
                    if(!$Parking){
                        $Parking = '0';
                    }
                    
                    $BathsTotal = str_replace('.00','',$BathsTotal);
                    $GarageSpaces = str_replace('.00','',$GarageSpaces);
                    
                    
                    
                    if($Status == 'Active'){
                        $statusColor = '#009500';
                        $badge = $domBadge;
                    }else if($Status == 'Sold'){
                        $statusColor = 'red';
                        $badge = '<div class="_exlio_125" style="background-color: #EA7500; color: white;">Sold</div>';
                    }else if($Status == 'Pending'){
                        $statusColor = 'orange';
                        $badge = '<div class="_exlio_125">Pending</div>';
                    }else if($Status == 'Application In Progress'){
                        $badge = '<div class="_exlio_125">Application In Progress</div>';
                    }else if($Status == 'Pending With Contingencies'){
                        $badge = '<div class="_exlio_125">Pending With Contingencies</div>';
                    }
                    
                    /**
                    if($location!=''){
                      if(stripos($PropertyAddress, $location) !== false) {
                        $PropertyAddress = str_ireplace($location,'<span id="highlight" style="padding-left: 3px; padding-right: 3px;">'.$location.'</span>',$PropertyAddress);
                      }else{
                        $expldLoc = explode(" ",$location);
                        foreach($expldLoc as $highlight){
                            $PropertyAddress = str_ireplace($highlight,'<span id="highlight">'.$highlight.'</span>',$PropertyAddress);
                        }
                      }
                    }*/
                    ?>
        			<!-- Single Property -->
        		   <div class="col-lg-6 col-md-6 col-sm-10 xs-mb-15 sm-mb-15 fleft dsply_inline_blck sm-float_none">
        				<div class="card match-height property-listing property-2">
        					
        					<div class="listing-img-wrapper h-100">
        						<?php echo $badge;?>
        						<div class="list-img-slide">
            						<div class="click">
                                        <?php
                                        if($AllPixList !=''){
                                        $ecPix = explode(',',$AllPixList);
                                        $counPix = count($ecPix);
                                        if($counPix>2){
                                            $sgt = 0;
                                        }else{
                                            $sgt = -1;
                                        }
                                        
                                        $pixCounter = 0;                                    
                                        foreach($ecPix as $pix){
                                            if($pix!='' && $pixCounter>$sgt){
                                            ?>
                							<div>
                                            <a href="javascript:;" data-href="<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                            <img src="../first1.us/<?php echo $pix;?>" id="<?php echo $MLSNumber;?>" loading="lazy" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="" />
                                            </a>
                                                     
                                            </div>                                            
                                            <?php                                                                                   
                                            }    
                                            $pixCounter++; 
                                        }
                                        }else{
                                        ?>
            							<div>
                                        <a href="javascript:;" data-href="listings/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                        <img src="../first1.us/<?php echo $DefaultPic;?>" loading="lazy" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="" />
                                        </a>
                                          
                                        </div>
                                        <?php
                                        }
                                        ?>
            						</div>
                                    
            					</div>
                                
        					</div>

        					
        					<div class="listing-detail-wrapper mt-1">
        						<div class="listing-short-detail-wrap">
                       <div className="card-info">
      <span className='card-name'><a class="prt-link-detail" href=""><?php echo $SubCondoName;?></a></span>
      <span className='card-location'><i class="ti-location-pin"></i> <?php echo $PropertyAddress;?></span>
      <span className='card-price'>$<?php echo number_format($CurrentPrice,0);?></span>
      <div className="card-extra"></div>
  </div>
        			
        						</div>
        					</div>
        					
        					<div class="price-features-wrapper">
        						<div class="list-fx-features">
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="../first1.us/assets/img/bed.svg" width="13" alt="" /></div><?php echo $BedsTotal;?> Beds
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="../first1.us/assets/img/bathtub.svg" width="13" alt="" /></div><?php echo $BathsTotal;?> Baths
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="../first1.us/assets/img/car.svg" width="13" alt="" /></div><?php echo $GarageSpaces;?> Car Garage
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="../first1.us/assets/img/move.svg" width="13" alt="" /></div><?php echo number_format($TotalArea,0);?> sqft
        							</div>
        						</div>
                                <div class=" w-100 fs-11 text-left">
      								<?php echo $ListOfficeName;?>
       							</div>
        					</div>
                  <div className="card-btns">
    <div className="btn-g1">  
    <button className='card-btn'  onclick="openGetInfo('<?php echo $MLSNumber;?>')" >Contact us</button>
      <button className='card-btn favbtn'  onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>"  ><i class="fa-regular fa-heart"></i></button></div>
      <button className='card-btn' onclick="openTourModal('<?php echo $MLSNumber;?>')">Schedule Tour</button>
  </div>
        				</div>
        			</div>
                    <!-- Single Property Ends -->
                    <?php
                    }
                    
                    }else{
                    echo '<div style="width: 100%; float: left; text-align: center; padding-top: 30px; padding-bottom: 30px;">
                    Sorry, there are no results that match your search. Please try different search criteria..
                    <div class="fleft w-100 mt-20 centered-text"><a href="mls-search" class="btn btn-primary">MLS Search</a></div>
                    </div>';
                    ?>
                    
                    <div class="col-md-12 fleft">
                    <div class="w-100 p-25 fleft bg-white shadow">
                    <h4 class="w-100 fleft">Featured Cities.</h4>
                    <?php
                    $selCity = "SELECT * FROM cities WHERE city_id!='' ORDER BY name ASC";  
                    $cityRslts = mysqli_query($conn,$selCity);  
                    $noCity = mysqli_num_rows($cityRslts);
                    $data = $cityRslts->fetch_all(MYSQLI_ASSOC);
                    
                    $ftrdComm = '';
                    if($noCity>0){
                    foreach ($data as $row){
                    $city_name = $row['name'];
                    $city_slug = $row['slug'];
                    $ftrdComm .= $row['communities'];
                    ?>
					<a class="col-md-4 pl-0 fleft dsply_inline_blck mb-15" href="city/<?php echo $city_slug;?>"><?php echo $city_name;?></a>
                    <?php
                    }
                    }
                    ?>
                    </div>
                    </div>
                    
                    
                    
                    <div class="col-md-12 fleft mt-40">
                    <div class="w-100 p-25 fleft bg-white shadow">
                    <h4 class="w-100 fleft">Featured Communities.</h4>
                    <?php
                    $expldComm = explode(',',$ftrdComm);
                    shuffle($expldComm);
                    
                    $countMax = 1;
                    foreach ($expldComm as $comm){
                    
                    if($countMax<=60 && $comm!=''){
                    $more_expl = explode(':',$comm);
                    $commID = $more_expl['0'];
                    $commName = $more_expl['1'];
                    ?>
					<a class="col-md-6 pl-0 fleft dsply_inline_blck mb-15" href="community/<?php echo urlencode($commName);?>/homes/price-asc/1"><?php echo $commName;?></a>
                    <?php
                    
                    $countMax++;
                    }else{
                        break;
                    }
                    }
                    ?>
                    </div>
                    </div>
                    
                    <?php  
                    }
                    ?>
                    
                    
                  <div class="col-md-12 fleft mt-15">
                  <div class="tr-pagination tr-section w-100 fleft">
                    <ul class="pagination centered-text"></ul>       
                  </div>
                  </div> 
                    
        		</div>	
        	</div>
        	
            <div class="col-lg-4 col-md-12 col-sm-12">
                <?php
                include_once 'side_search.php';
                
                $silde_limit = "3";
                include_once 'side_listings.php';
                ?>
        		<!-- Sidebar End -->
        	</div>
        	
        </div>
        </div>	
        </section>
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include('footer.php');?>  
    
   <script src="../first1.us/assets/js/PaginationForPath.js" type="text/javascript"></script>
    <script type="text/javascript">
    
    var Location='<?php echo $location;?>';
    var xmls_number='<?php echo $xmls_number;?>';
    var city='<?php echo $city;?>';
    var zipcode='<?php echo $zipcode;?>';
    var property_type='<?php echo $property_type;?>';
    var min_price='<?php echo $min_price;?>';
    var max_price='<?php echo $max_price;?>';
    var bedrooms='<?php echo $bedrooms;?>';
    var bathrooms='<?php echo $bathrooms;?>'; 
    var min_sq_ft='<?php echo $min_sq_ft;?>';
    var max_sq_ft='<?php echo $max_sq_ft;?>';
    var min_year='<?php echo $min_year;?>';
    var garage='<?php echo $garage;?>';
    var just_listed='<?php echo $just_listed;?>';
    var include_sold='<?php echo $include_sold;?>';
    var foreclosure='<?php echo $foreclosure;?>';
    var short_sale='<?php echo $short_sale;?>';
    var pool='<?php echo $pool;?>';
    var spa='<?php echo $spa;?>';
    var guest_house='<?php echo $guest_house;?>';
    var water_front='<?php echo $waterfront;?>';
    var gated='<?php echo $gated;?>';
    var communities='<?php echo $communities;?>';
    var gulf_access='<?php echo $gulf_access;?>';
    var ref='<?php echo $ref;?>';
    var sort='<?php echo $sort_by;?>';
    var page='<?php echo $page;?>';
    var pagination='<?php echo $pagination;?>';

    $(document).ready(function(){
    $(".match-height").matchHeight();
    setPagination(); 
    
    setSrchValue(Location,xmls_number,city,zipcode,property_type,min_price,max_price,bedrooms,bathrooms,min_sq_ft,max_sq_ft,min_year,garage,just_listed,include_sold,foreclosure,short_sale,pool,spa,guest_house,water_front,gated,communities,gulf_access,ref,sort);  
    
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
    });
    </script>
    </div>
</body>
</html>

<?php
}else{
    echo '<script type="text/javascript">window.location.href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&pagination=get&page=1";</script>';
}
?>