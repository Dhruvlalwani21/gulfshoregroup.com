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
}

?>
