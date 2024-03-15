<?php
include 'connect.php';
$page = 'home';
$favoritesArray=json_decode($_SESSION['fav_ids'], true);
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
$gulf_access=$_GET["gulf_access"];
$ref=$_GET["ref"];
$sort_by=$_GET["sort"];
$page=$_GET['page'];
$dfltLat=$_GET['dfltLat'];
$dfltLng=$_GET['dfltLng'];
$aNord=$_GET['aNord'];
$aEst=$_GET['aEst'];
$aSud=$_GET['aSud'];
$aOvest=$_GET['aOvest'];
$zoom=$_GET['zoom'];

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
$dflt_params='location='.$location.'&mls_number='.$xmls_number.'&min_price='.$min_price.'&max_price='.$max_price.'&property_type='.$property_type.'&city='.$city.'&zipcode='.$zipcode.'&beds='.str_replace('+','%2B',$bedrooms).'&baths='.str_replace('+','%2B',$bathrooms).'&min_sq_ft='.$min_sq_ft.'&max_sq_ft='.$max_sq_ft.'&min_year='.$min_year.'&garage='.str_replace('+','%2B',$garage).'&just_listed='.$just_listed.'&include_sold='.$include_sold.'&foreclosure='.$foreclosure.'&short_sale='.$short_sale.'&pool='.$pool.'&spa='.$spa.'&guest_house='.$guest_house.'&waterfront='.$waterfront.'&sort='.$sort_by.'&gated='.$gated.'&page='.$page.'&pagination='.$pagination; 


if($location!='Any' && $location!=''){
  
  $search = explode(" ",$location);
  $each = "";
  foreach($search AS $keyword){
        $each .=" OR (City LIKE '$keyword%' OR PostalCode LIKE '%$keyword%' OR Development LIKE '$keyword%' OR DevelopmentName LIKE '$keyword%')"; 
  }
    
  //$each = substr($each, 0, -3); /** remove last OR **/
  
  $qry_loc=" (City LIKE '%$location%' OR PostalCode LIKE '%$location%' OR Development LIKE '%$location%' OR DevelopmentName LIKE '%$location%') "; //.$each; 
  $orderCase = "CASE WHEN PropertyAddress LIKE '%$location%' THEN 0  
                     WHEN City LIKE '%$location%' THEN 1  
                     WHEN PostalCode LIKE '%$location%' THEN 2 
                     ELSE 3
                END,"; 
}else{
  $qry_loc=" city!='0' "; /** since city could be empty **/ 
}


if($city!='Any' && $city!=''){
    $qry_city = " City LIKE '%$city%' ";
}

if($zipcode!='Any' && $zipcode!=''){
    $qry_zipcode = " PostalCode='$zipcode' ";
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
 $qry_min_max_pri_join=" AND ListPrice>=$min_price"; 
}else if(($min_price=='Any' || $min_price=='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND ListPrice<=$max_price"; 
}else if(($min_price!='Any' && $min_price!='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND (ListPrice>=$min_price AND ListPrice<=$max_price)";   
}  
}else{
 $qry_min_max_pri_join="";
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
}


/** if type is not residentials and rentals, no need for beds and baths check or swimming pool and other features **/
if($xmls_number==''){
    
    if($location!='Any' && $location!=''){ /** quick search **/
        $final_loc_qry = $qry_loc; 
    }else{
        if($city!='Any' && $city!=''){ /** Using city **/
            $final_loc_qry = $qry_city;   
        }else if($zipcode!='Any' && $zipcode!=''){ /** Using zip Code **/
            $final_loc_qry = $qry_zipcode; 
        }else{ /** both empty **/
            $final_loc_qry = " city!='0' "; 
        }
    }
    
    if($property_type=='Land' && $property_type=='Dock'){
      $query=$final_loc_qry.$qry_type.$qry_min_max_pri_join.$qry_lot_size.$qry_year_built.$qry_jst_listed.$qry_status.$qry_foreclsre.$qry_ss.$qry_waterfrnt.$qry_gated.$gulf_access; 
    }else{
      $query=$final_loc_qry.$qry_type.$qry_beds.$qry_baths.$qry_garage.$qry_min_max_pri_join.$qry_lot_size.$qry_year_built.$qry_jst_listed.$qry_status.$qry_foreclsre.$qry_ss.$qry_pool.$qry_spa.$qry_gee_house.$qry_waterfrnt.$qry_gated.$gulf_access;
    }
    
    
}else{ /** ignore other queries and seach mls number only **/
$query=" MLSNumber='$xmls_number'";
}

$updateUrl = 'No';
//if($dfltLat == '' || $dfltLng == '' || $SWLng == '' || $SWLat == '' || $NELng == '' || $NELat == ''){

if($dfltLat == '' || $dfltLng == ''){
    
$dfltLat = '26.1503648';
$dfltLng = '-81.7946717';
$aNord = ''; //-82.0918049
$aEst = ''; //26.5252099
$aSud = ''; //-81.8996320
$aOvest = ''; //26.7700000
$zoom='11';
$updateUrl = 'Yes';

if($location!='Any' && $location!='any' && $location!=''){
        $mapAdd = str_replace(',FL','',$location);
        $mapAdd = str_replace(', FL','',$mapAdd);
        $mapAdd = str_replace('FL','',$mapAdd);
        $mapAdd = $mapAdd.', FL, USA';
        
        $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($mapAdd)."&key=".WEBMAPAPI."&sensor=true";
        $xml = simplexml_load_file($request_url);
        
        if($xml){
        $status = $xml->status;
        if($status=="OK"){
          $dfltLat = $xml->result->geometry->location->lat;
          $dfltLng = $xml->result->geometry->location->lng;
        }
        }
}else if($city!=''){

$sqlCoord = "SELECT Longitude, Latitude FROM cities WHERE name='$city'"; //, SWLng, SWLat, NELng, NELat 
$coordRslt = mysqli_query($conn,$sqlCoord); 
$cityFound = mysqli_num_rows($coordRslt);

if($cityFound>0){
    
    $rowCoor = mysqli_fetch_assoc($coordRslt);
    $Longitude = $rowCoor['Longitude'];
    $Latitude = $rowCoor['Latitude'];
    /**
    $SWLng = $rowCoor['SWLng'];
    $SWLat = $rowCoor['SWLat'];
    $NELng = $rowCoor['NELng'];
    $NELat = $rowCoor['NELat'];
    **/
    if($Longitude!='' && $Latitude!=''){
        $dfltLat = $Latitude;
        $dfltLng = $Longitude;
        
        /**
        $dfltSWLng = $SWLng;
        $dfltSWLat = $SWLat;
        $dfltNELng = $NELng;
        $dfltNELat = $NELat;
        **/
    }else{
        $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($city.", FL, USA")."&key=".WEBMAPAPI."&sensor=true";
        $xml = simplexml_load_file($request_url);
        //print_r($xml);
        if($xml){
        $status = $xml->status;
        if($status=="OK"){
          $dfltLat = $xml->result->geometry->location->lat;
          $dfltLng = $xml->result->geometry->location->lng;
          
          /**
          $dfltSWLng = $xml->result->geometry->viewport->southwest->lng;
          $dfltSWLat = $xml->result->geometry->viewport->southwest->lat;
          $dfltNELng = $xml->result->geometry->viewport->northeast->lng;
          $dfltNELat = $xml->result->geometry->viewport->northeast->lat;
          **/
          
          $upCoord = "UPDATE cities SET Longitude='$dfltLng', Latitude='$dfltLat' WHERE name='$city'"; 
          $upRslt = mysqli_query($conn,$upCoord) or die(mysqli_error($conn));
        }
        }
    }

}

}else if($zipcode!=''){
        $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($zipcode)."&key=".WEBMAPAPI."&sensor=true";
        $xml = simplexml_load_file($request_url);
        //print_r($xml);
        if($xml){
        $status = $xml->status;
        if($status=="OK"){
          $dfltLat = $xml->result->geometry->location->lat;
          $dfltLng = $xml->result->geometry->location->lng;
        }
        }
}
}    
/**
$sqlTTL = "SELECT COUNT(MLSNumber) AS total_records FROM properties WHERE $query"; 
$ttlRslt = mysqli_query($conn,$sqlTTL); 
$rowQ = mysqli_fetch_assoc($ttlRslt); 
$total_records = $rowQ['total_records'];

$start_from = ($page-1) * $limit;
$toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, Longitude,Latitude, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList';
$sqlPpty = "SELECT $toSel FROM properties WHERE $query ORDER BY $orderCase $order_by LIMIT $start_from, $limit"; //
$pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
$noProperties = mysqli_num_rows($pptyRslt);
**/
$mapData='{"properties": []}';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    
    <title>Search Result | MVP Realty</title>
	
    <?php include_once 'styles.php';?>
    
    <script type="text/javascript">
    var curr_page='<?php echo $pageNumber;?>'; 
    var lm='<?php echo $limit;?>';
    var listSize = 20;
    var sort='<?php echo $sort_by;?>';
    var email = '<?php echo $logged_email;?>';
    var logged_email = '<?php echo $logged_email;?>';
    var mapData = '<?php echo $mapData;?>';
    var map_data = '<?php echo $mapData;?>';
    var dfltLat = '<?php echo $dfltLat;?>';
    var dfltLng = '<?php echo $dfltLng;?>';
    var aNord = '<?php echo $aNord;?>';
    var aEst = '<?php echo $aEst;?>';
    var aSud = '<?php echo $aSud;?>';
    var aOvest = '<?php echo $aOvest;?>'; 
    var zoomLevel = '<?php echo $zoom;?>';
    var updateUrl = '<?php echo $updateUrl;?>';


    if(updateUrl == 'Yes'){
        pushUrl(dfltLat, dfltLng, aNord, aEst, aSud, aOvest, zoomLevel);
    }
    
    function pushUrl(lat, lng, aNord, aEst, aSud, aOvest, zoomLevel){
        
        var currLoc = window.location.href;
        var originalLoc = currLoc.split('#')[0];
        var page_num = currLoc.split('#')[1];
        var locNoCoord = originalLoc.split('&dfltLat')[0];
        
        var pageNum = '';
        if(page_num){
            pageNum = "#"+page_num;
        }
        
        var newURL = locNoCoord+'&dfltLat='+lat+'&dfltLng='+lng+'&aNord='+aNord+'&aEst='+aEst+'&aSud='+aSud+'&aOvest='+aOvest+'&zoom='+zoomLevel+''+pageNum;
        history.pushState(null, null, newURL);
    }
    </script>
    <link href="assets/css/jsonPagination.css" rel="stylesheet"/>
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
		<div class="header always-fixed">
			<div class="container">
            <style type="text/css">
            .static-logo{display: none!important; opacity: 0!important; width: 0px!important; height: 0px!important; }
            </style>
				<?php include_once 'nav.php'; ?>
			</div>
		</div>
		<!-- End Navigation -->
		<div class="clearfix"></div>
		<!-- ============================================================== -->
        
        <div class="home-map-banner half-map">
        
        <div class="fs-left-map-box relative">
        <div class="home-map fl-wrap relative">
        	<div class="hm-map-container fw-map relative" style="height: calc(100vh - 80px); bottom: 0;">
        		<div id="map"></div>
                <a href="search.php?<?php echo $dflt_params;?>" style="position: absolute; top: 60px; left: 10px; z-index: 999999!important;">
                <button class="btn white fs-14 mb-fleft p-8" id="card_view_btn" style="background-color: white; color: #626262;">
                <i class="fas fa-angle-double-left"></i> <span class="hddn_map_txt">List View</span>
                </button>
                </a>
                
            <div class="fleft p-8 fw-bold" id="listings_found">
            <span id="no_listing_fnd"></span> listings found
            </div>
            
            <div id="map_loader"><img src="assets/img/loader.gif" /></div>
        	</div>
        </div>
        </div>
        
        <div class="fs-inner-container bg-light pt-80">
        <div class="fs-content pl-4 pr-4">
        
        	<div class="row">
        		<div class="col-lg-12 col-md-12">
        			<div class="sty_1523">
        				<div class="_mp_filter center mb-3">
        					<div class="_mp_filter_first">
        					<div class="shorting-right fleft">
            				<h6 class="totalFound">0 Listings Found</h6>
            				</div>
        					</div>
        					<div class="_mp_filter_last">
        						<a href="#" class="map_filter min" data-toggle="modal" data-target="#mapFilter"><i class="fa fa-sliders-h mr-2"></i>&nbsp; More Filters</a>
        					</div>
        				</div>
        				
        			</div>
        		</div>
        	</div>
        	
        	<!--- All List -->
        	<div class="row justify-content-center" id="ppty_lists">
        		<!-- Single Property -->
        		 
        		<!-- End Single Property --> 
       		    <div class="w-100 justify-content-center" id="streamed_ppty"></div>
                <div class="nothing-found w-100 centered-text p-40" style="display: none;"> No listing found in this area, move map to load more lstings.</div>
        	</div>
        	
        </div>
        </div>
        
        </div>
        <div class="clearfix"></div>        
		<!-- Top header  -->
		<!-- ============================================================== -->
    <style type="text/css">footer{ display: none!important; height: 0px!important; }</style>
    <?php include_once 'footer.php';?>  
    
    <script src="assets/js/jsonPagination.js?v=<?php echo APPVERSION;?>" type="text/javascript"></script>
	<!-- Map -->
	<script src="https://maps.google.com/maps/api/js?key=<?php echo WEBMAPAPI;?>&sensor=false&libraries=places,drawing&dummy=.js"></script><!-- AIzaSyAhslYaXxH3ycFvxtw6bIifl0D6K_Y4DYk -->
    <script src="assets/js/markerwithlabel.js" type="text/javascript"></script>
    <script src="assets/js/markerclusterer.js" type="text/javascript"></script>
        
    <script type="text/javascript">
    /** used in speed_test.js **/
    /** used in speed_test.js **/ 
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
    /** used in speed_test.js **/
    /** used in speed_test.js **/
    
    $(document).ready(function(){
    localStorage.setItem('ScrollTop', 'Yes'); /** Initail setting **/
    $(".match-height").matchHeight();
    
    setMapSrchValue(Location,xmls_number,city,zipcode,property_type,min_price,max_price,bedrooms,bathrooms,min_sq_ft,max_sq_ft,min_year,garage,just_listed,include_sold,foreclosure,short_sale,pool,spa,guest_house,water_front,gated,communities,gulf_access,ref,sort);  
    
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
    
    <script src="assets/js/speed_test.js?v=<?php echo APPVERSION;?>"></script>
    
    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', speedTest.init);
    </script>
    </div>
    
    
    
    <!-- map Filter -->
    <!-- map Filter -->
    <div class="modal fade text-left" id="mapFilter" tabindex="-1" role="dialog" aria-labelledby="mapFilter" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title fs-18" id="mapFilter"><i class="fas fa-sliders-h fs-18 pr-5"></i> Filter Search</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body xs-p-0">
    
    <div class="w-100 p-15 xs-p-5 pt-0">  
    <div class="fleft w-100">
    
    <form autocomplete="off" class="w-100">
    <div class="col-md-4 fleft dsply_inline_blck">
    <div class="form-group">
    <label id="form_lbl">Property type</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_property_type" name="advnc_property_type">
        <option value="" selected="selected">Select Property Type</option>
        <option value="Homes">Homes</option>
        <option value="Condos">Condos</option>
        <option value="Land">Vacant Land</option>
        <option value="Commercial">Commercial</option>
        <option value="Multi-Family">Multi-Family</option>
        <option value="Town Homes">Town Homes</option>
        <option value="Dock">Boat Dock</option>
        </select>
    	<i class="ti-list-ol"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-4 fleft dsply_inline_blck">
    <div class="form-group">
    <label id="form_lbl">City</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_city" name="advnc_city" onchange="reloadComm(this.value)">
        <option value="" selected="selected">Select City</option>
        <option value="Marco Island">Marco Island</option>
        <option value="Naples">Naples</option>
        <option value="Ave Maria">Ave Maria</option>
        <option value="Immokalee">Immokalee</option>
        <option value="Bonita Springs">Bonita Springs</option>
        <option value="Estero">Estero</option>
        <option value="Fort Myers">Fort Myers</option>
        <option value="Cape Coral">Cape Coral</option>
        <option value="Lehigh Acres">Lehigh Acres</option>
        </select>
    	<i class="fas fa-city"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-1 fleft centered-text dsply_inline_blck">
    <div class="form-group">
    <label id="form_lbl">.</label>
    <label id="form_lbl" class="mt-10 w-100">-OR-</label>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group">
    <label id="form_lbl">Zip code</label>
    <div class="input-with-icon">
    	<input type="text" class="form-control no_radius" id="advnc_zipcode" name="advnc_zipcode" placeholder="e.g. 34109,34110" autocomplete="off" />
    	<i class="ti-map-alt"></i>
    </div> 
    </div>
    </div>
    </form>
    </div>
    
    <div class="fleft w-100">
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <input id="just_listed" class="checkbox-custom" name="just_listed" type="checkbox" />
    <label for="just_listed" class="checkbox-custom-label">Just Listed</label>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <input id="include_sold" class="checkbox-custom" name="include_sold" type="checkbox" />
    <label for="include_sold" class="checkbox-custom-label">Include Sold</label>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <input id="foreclosure" class="checkbox-custom" name="foreclosure" type="checkbox" />
    <label for="foreclosure" class="checkbox-custom-label">Foreclosure</label>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <input id="short_sale" class="checkbox-custom" name="short_sale" type="checkbox" />
    <label for="short_sale" class="checkbox-custom-label">Short Sale</label>
    </div>
    </div>
    
    </div>
    
    
    
    
    <div class="fleft w-100 mt-15">
    
    <div class="fleft col-12 mb-5">
    <div class="w-100 fs-13" style="border-bottom: 2px dashed #009CE8; color: #009CE8;"><b>ADVANCED SEARCH:</b></div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Min Price</label>
    <div class="input-with-icon">
    	<input type="number" class="form-control no_radius" id="advnc_min_price" name="advnc_min_price" placeholder="Minimum price" autocomplete="off" />
    	<i class="fas fa-dollar-sign"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Max Price</label>
    <div class="input-with-icon">
    	<input type="number" class="form-control no_radius" id="advnc_max_price" name="advnc_max_price" placeholder="Maximum price" autocomplete="off" />
    	<i class="fas fa-dollar-sign"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Beds</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_beds" name="advnc_beds">
        <option value="Any" selected="">Any # of beds</option>
        <option value="1">1 Bed</option>
        <option value="1+">1+ Beds</option>
        <option value="2+">2+ Beds</option>
        <option value="3+">3+ Beds</option>
        <option value="4+">4+ Beds</option>
        <option value="5+">5+ Beds</option>
        <option value="6+">6+ Beds</option>
        <option value="7+">7+ Beds</option>
        <option value="8+">8+ Beds</option>
        <option value="9+">9+ Beds</option>
        <option value="10+">10+ Beds</option>
        </select>
    	<i class="fas fa-bed"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Baths</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_baths" name="advnc_baths">
        <option value="Any" selected="">Any # of baths</option>
        <option value="1">1 Bath</option>
        <option value="1+">1+ Baths</option>
        <option value="2+">2+ Baths</option>
        <option value="3+">3+ Baths</option>
        <option value="4+">4+ Baths</option>
        <option value="5+">5+ Baths</option>
        <option value="6+">6+ Baths</option>
        <option value="7+">7+ Baths</option>
        <option value="8+">8+ Baths</option>
        <option value="9+">9+ Baths</option>
        <option value="10+">10+ Baths</option>
        </select>
    	<i class="fas fa-bath"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Min Living Area Sq.Ft</label>
    <div class="input-with-icon">
    	<input type="number" class="form-control no_radius" id="advnc_min_sq_ft" name="advnc_min_sq_ft" placeholder="Minimum Sq.Ft" autocomplete="off" />
    	<i class="fas fa-ruler-combined"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Max Living Area Sq.Ft</label>
    <div class="input-with-icon">
    	<input type="number" class="form-control no_radius" id="advnc_max_sq_ft" name="advnc_max_sq_ft" placeholder="Minimum Sq.Ft" autocomplete="off" />
    	<i class="fas fa-ruler-combined"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Year Built</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_min_year" name="advnc_min_year">
        <option value="Any" selected="">Any year</option>
        <option value="1990">1990 + </option>
        <option value="2000">2000 + </option>
        <option value="2005">2005 + </option>
        <option value="2010">2010 + </option>
        <option value="2015">2015 + </option>
        <option value="2016">2016 + </option>
        <option value="2017">2017 + </option>
        <option value="2018">2018 + </option>
        <option value="2019">2019 + </option>
        <option value="2020">2020 + </option>
        <option value="2021">2021 + </option>
        </select>
    	<i class="fas fa-calendar-alt"></i>
    </div>
    </div>
    </div>
    
    <div class="col-md-3 fleft dsply_inline_blck">
    <div class="form-group mt-10">
    <label id="form_lbl">Garage Spaces</label>
    <div class="input-with-icon">
    	<select class="form-control no_radius" id="advnc_no_garage" name="advnc_no_garage">
        <option value="Any" selected="">Any # of garage</option>
        <option value="1">1</option>
        <option value="1+">1+</option>
        <option value="2+">2+</option>
        <option value="3+">3+</option>
        <option value="4+">4+</option>
        <option value="5+">5+</option>
        <option value="6+">6+</option>
        <option value="7+">7+</option>
        <option value="8+">8+</option>
        <option value="9+">9+</option>
        <option value="10+">10+</option>
        </select>
    	<i class="fas fa-car"></i>
    </div>
    </div>
    </div>
    
    </div>
    
    
    <div class="fleft w-100">
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
        <div class="form-group mt-10">
            <input id="pool" class="checkbox-custom" name="pool" type="checkbox" />
    		<label for="pool" class="checkbox-custom-label">Pool</label>
        </div>
        </div>
         
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
        <div class="form-group mt-10">
            <input id="spa" class="checkbox-custom" name="spa" type="checkbox" />
    		<label for="spa" class="checkbox-custom-label">Spa</label>
        </div>
        </div>
         
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
        <div class="form-group mt-10">
            <input id="guest_house" class="checkbox-custom" name="guest_house" type="checkbox" />
    		<label for="guest_house" class="checkbox-custom-label">Guest House</label>
        </div>
        </div>
         
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
        <div class="form-group mt-10">
            <input id="gated" class="checkbox-custom" name="gated" type="checkbox" />
    		<label for="gated" class="checkbox-custom-label">Gated Community</label>
        </div>
        </div>
         
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck xs-pl-15 sm-pl-15">
        <div class="form-group mt-10">
            <input id="waterfront" class="checkbox-custom" name="waterfront" type="checkbox" />
    		<label for="waterfront" class="checkbox-custom-label">Waterfront</label>
        </div>
        </div>
         
        <div class="col-lg-3 col-md-4 fleft dsply_inline_blck xs-pl-15 sm-pl-15">
        <div class="form-group mt-10">
            <input id="gulf_access" class="checkbox-custom" name="gulf_access" type="checkbox" />
    		<label for="gulf_access" class="checkbox-custom-label">Gulf Access</label>
        </div>
        </div>
            
    </div>
     
    
    <div class="fleft w-100 mt-15 xs-pr-15 sm-pr-15 mb-25">
    <div class="btn btn-primary fright" onclick="filterMapSearch()"><i class="ti-search"></i> Search</div>
    </div>
    <input type="hidden" id="serch_ref" name="serch_ref" value="quick" />
    
    
    </div>
    
    </div>
    </div>
    </div>
    </div> 
    <!-- map Filter -->
    <!-- map Filter -->
    
    <div id="mob_srch_fxd_flter">
    <a style="color: white;" role="button" href="#" data-toggle="modal" data-target="#mapFilter">
    <i class="fa fa-sliders-h ml-2"></i>
    </a>
    </div>
    
    
</body>
</html>

<?php
}else{
    echo '<script type="text/javascript">window.location.href="map-search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&gulf_access=&ref=quick&pagination=get&page=1";</script>';
}
?>