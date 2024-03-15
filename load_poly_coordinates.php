<?php
include 'connect.php';  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

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
return $n_format . $suffix;
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
    $n_format = substr($n_format, 0, 4);
	$suffix = 'M';
} 
// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
// Intentionally does not affect partials, eg "1.50" -> "1.50"
if ( $precision > 0 ) {
	$dotzero = '.' . str_repeat( '0', $precision );
	$n_format = str_replace( $dotzero, '', $n_format );
}
return $n_format . $suffix;
}


function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y){
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
    if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
       $c = !$c;
  }
  return $c;
}

function manipulatePoints($addUp,$allData,$ListingId,$ListingKeyNumeric,$StandardStatus,$PropertyAddress,$StreetName,$BathroomsFull,$BathroomsTotalInteger,$BedroomsTotal,$StreetNumber,$StreetSuffix,$StreetDirSuffix,$StreetNumberNumeric,$City,$PostalCode,$Longitude,$Latitude,$DefaultPic,$ListPrice,$List_Price,$GarageSpaces,$LivingArea,$favDsply,$unfDsply){
    
    if(strpos($Latitude, '-') !== false){
       $Latitude=floatval($Latitude-$addUp); 
    }else{
       $Latitude=floatval($Latitude+$addUp); 
    } 
    
    /**
    if(strpos($Longitude, '-') !== false){
       $Longitude=floatval($Longitude-$addUp); 
    }else{
       $Longitude=floatval($Longitude+$addUp); 
    }
    **/
    $dataToAdd=$Latitude.'#'.$Longitude;
    if(!in_array($dataToAdd,$allData)){
    $ppty_data='{"ListingId": "'.$ListingId.'", "ListingKeyNumeric": "'.$ListingKeyNumeric.'", "StandardStatus": "'.$StandardStatus.'", "PropertyAddress": "'.$PropertyAddress.'", 
    "StreetName": "'.$StreetName.'", "BathroomsFull": "'.$BathroomsFull.'", "BathroomsTotalInteger": "'.$BathroomsTotalInteger.'", "BedroomsTotal": "'.$BedroomsTotal.'", 
    "StreetNumber": "'.$StreetNumber.'", "StreetSuffix": "'.$StreetSuffix.'", "StreetDirSuffix": "'.$StreetDirSuffix.'", "StreetNumberNumeric": "'.$StreetNumberNumeric.'", 
    "City": "'.$City.'", "PostalCode": "'.$PostalCode.'", "Longitude": "'.$Longitude.'", "Latitude": "'.$Latitude.'", "DefaultPic": "'.$DefaultPic.'", "DefaultPic": "'.$DefaultPic.'", 
    "ListPrice": "'.$ListPrice.'", "List_Price": "'.$List_Price.'", "GarageSpaces": "'.number_format($GarageSpaces,0).'", "LivingArea": "'.number_format($LivingArea,0).'", "fav_display": "'.$favDsply.'", "unfav_display": "'.$unfDsply.'" }';
     
    return array('ppty_data'=>$ppty_data, 'Latitude'=>$Latitude, 'Longitude'=>$Longitude); 
    }else{
    $addUp+=0.000020;
    return manipulatePoints($addUp,$allData,$ListingId,$ListingKeyNumeric,$StandardStatus,$PropertyAddress,$StreetName,$BathroomsFull,$BathroomsTotalInteger,$BedroomsTotal,$StreetNumber,$StreetSuffix,$StreetDirSuffix,$StreetNumberNumeric,$City,$PostalCode,$Longitude,$Latitude,$DefaultPic,$ListPrice,$List_Price,$GarageSpaces,$LivingArea,$favDsply,$unfDsply);  
    }
}

$minLat=$_POST["minLat"]; 
$maxLat=$_POST["maxLat"]; 
$minLng=$_POST["minLng"]; 
$maxLng=$_POST["maxLng"]; 
$xmls_number=filterThis($_POST["mls_number"]);
$location=filterThis($_POST["location"]);
$property_type=$_POST["property_type"];
$status=$_POST["status"];  
$bedrooms=$_POST["beds"];  
$bathrooms=$_POST["baths"];  
$min_price=$_POST["min_price"];  
$max_price=$_POST["max_price"];     
$min_sq_ft=$_POST["min_sq_ft"]; 
$max_sq_ft=$_POST["max_sq_ft"]; 
$min_year=$_POST["min_year"]; 
$max_year=$_POST["max_year"];
$garage=$_POST['garage'];
$stories=$_POST["stories"];
$email=$_POST["email"]; 
$pool=$_POST["pool"];  
$waterfront=$_POST["waterfront"];
$polyList=$_POST['polyList'];  

$allLat=array();
$allLng=array();
$expldHash=explode('#',$polyList);

foreach($expldHash as $latLng){
    if($latLng!=''){
      $expldLatLng=explode(',',$latLng);
      $lat=$expldLatLng[0]; 
      $lng=$expldLatLng[1]; 
      array_push($allLat, $lat);
      array_push($allLng, $lng);
    }
}


if($location!='Any' && $location!=''){
  
  $search = explode(" ",$location);
  $each = "";
  foreach($search AS $keyword){
        $each .=" OR (City LIKE '$keyword%' OR PostalCode LIKE '%$keyword%' OR Neighborhood LIKE '%$keyword%' OR SubdivisionName LIKE '%$keyword%')"; 
  }
    
  //$each = substr($each, 0, -3); /** remove last OR **/
  
  $qry_loc=" (City LIKE '$location%' OR PostalCode LIKE '%$location%' OR Neighborhood LIKE '$location%' OR SubdivisionName LIKE '$location%') "; //.$each; 
  $orderCase = "CASE WHEN PropertyAddress LIKE '%$location%' THEN 0  
                     WHEN City LIKE '%$location%' THEN 1  
                     WHEN PostalCode LIKE '%$location%' THEN 2 
                     ELSE 3
                END,"; 
}else{
  $qry_loc=" city!='0' "; /** since city could be empty **/ 
}

if($property_type!='Any' && $property_type!=''){
  
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
   
  $qry_type=" AND $open$ppty_qry$close ";  
  //$qry_type = " AND PropertyClass='$property_type' ";   
}else{
  $qry_type="";  
}

// PropertyClass='ResidentialIncome' /** Rental Investments **/
 
if($bedrooms!='Any' && $bedrooms!=''){ 
  if(strpos($bedrooms, '+') !== false){
    $bedz=str_replace('+','',$bedrooms);
    $qry_beds=" AND BedroomsTotal>=$bedz"; 
  }else{
    $qry_beds=" AND BedroomsTotal=$bedrooms"; 
  }  
}else{
  $qry_beds="";  
}

if($bathrooms!='Any' && $bathrooms!=''){
  if(strpos($bathrooms, '+') !== false){
    $bathz=str_replace('+','',$bathrooms);
    $qry_baths=" AND BathroomsFull>=$bathz"; 
  }else{
    $qry_baths=" AND BathroomsFull=$bathrooms"; 
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

if($min_price!='Any' && $min_price!=''){
  $qry_min_pri=" AND ListPrice>=$min_price";  
}else{
  $qry_min_pri="";  
}

if($max_price!='Any' && $max_price!=''){
  $qry_max_pri=" AND ListPrice<=$max_price";  
}else{
  $qry_max_pri="";  
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
 $qry_lot_size=" AND LivingArea>=$min_sq_ft"; 
}else if(($min_sq_ft=='Any' || $min_sq_ft=='') && ($max_sq_ft!='Any' && $max_sq_ft!='')){
 $qry_lot_size=" AND LivingArea<=$max_sq_ft"; 
}else if(($min_sq_ft!='Any' && $min_sq_ft!='') && ($max_sq_ft!='Any' && $max_sq_ft!='')){
 $qry_lot_size=" AND (LivingArea>=$min_sq_ft AND LivingArea<=$max_sq_ft)";   
}  
}

if(($min_year!='Any' && $min_year!='') || ($max_year!='Any' && $max_year!='')){
if(($min_year!='Any' && $min_year!='') && ($max_year=='Any' || $max_year=='')){
 $qry_year_built=" AND YearBuilt>=$min_year"; 
}else if(($min_year=='Any' || $min_year=='') && ($max_year!='Any' && $max_year!='')){
 $qry_year_built=" AND YearBuilt<=$max_year"; 
}else if(($min_year!='Any' && $min_year!='') && ($max_year!='Any' && $max_year!='')){
 $qry_year_built=" AND (YearBuilt>=$min_year AND YearBuilt<=$max_year)";   
}  
}

if($stories!='Any' && $stories!=''){ 
  if(strpos($stories, '+') !== false){
    $storiz=str_replace('+','',$stories);
    $qry_stories=" AND StoriesTotal>=$storiz"; 
  }else{
    $qry_stories=" AND StoriesTotal=$stories"; 
  }  
}else{
  $qry_stories="";  
}

if($hoa=='Yes'){
  $qry_hoa=" AND hoa>0";  
}else{
  $qry_hoa=" AND (hoa='0.0' OR hoa<1 OR hoa='')";  
}

if($pool=='Yes'){
  $qry_pool=" AND PoolPrivateYN='1'";  
}else{
  $qry_pool="";  
} 

if($waterfront=='Yes'){
  $qry_waterfrnt=" AND (WaterfrontFeatures!='None' AND WaterfrontFeatures!='')";  
}else{
  $qry_waterfrnt="";  
}

if($sort_by=="sqft-asc"){
 $order_by="CAST(LivingArea as DECIMAL(10,5)) ASC";   
}else if($sort_by=="sqft-desc"){
 $order_by="CAST(LivingArea as DECIMAL(10,5)) DESC";   
}else if($sort_by=="lot-asc"){
 $order_by="CAST(LivingArea as DECIMAL(10,5)) ASC";   
}else if($sort_by=="lot-desc"){
 $order_by="CAST(LivingArea as DECIMAL(10,5)) DESC";   
}else if($sort_by=="baths-asc"){
 $order_by="BathroomsFull ASC";    
}else if($sort_by=="baths-desc"){
 $order_by="BathroomsFull DESC";    
}else if($sort_by=="beds-asc"){
 $order_by="BedroomsTotal ASC";    
}else if($sort_by=="beds-desc"){
 $order_by="BedroomsTotal DESC";    
}else if($sort_by=="garages-asc"){
 $order_by="GarageSpaces ASC";    
}else if($sort_by=="garages-desc"){
 $order_by="GarageSpaces DESC";    
}else if($sort_by=="price-asc"){
 $order_by="ListPrice ASC";   
}else if($sort_by=="price-desc"){
 $order_by="ListPrice DESC";   
}else if($sort_by=="built-asc"){
 $order_by="YearBuilt ASC";   
}else if($sort_by=="built-desc"){
 $order_by="YearBuilt DESC";   
}else if($sort_by=="new-asc"){
 $order_by="OriginalEntryTimestamp ASC";   
}else if($sort_by=="new-desc"){
 $order_by="OriginalEntryTimestamp DESC";   
}else{ /** not set **/
 $order_by="ListPrice ASC";   
}
                    
/** if type is not residentials and rentals, no need for beds and baths check or swimming pool and other features **/
if($xmls_number==''){
    
if($property_type=='Land/Lot' && $property_type=='Commercial/Industry'){
  $query=$qry_loc.$qry_type.$qry_min_max_pri_join.$qry_lot_size." AND StandardStatus='Active'"; 
}else if($property_type=='Residential Income'){
  $query=$qry_loc.$qry_type.$qry_garage.$qry_min_max_pri_join.$qry_lot_size.$qry_shortlet.$qry_ac.$qry_security.$qry_pool.$qry_handicap." AND StandardStatus='Active'"; 
}else{
  $query=$qry_loc.$qry_type.$qry_beds.$qry_baths.$qry_garage.$qry_min_max_pri_join.$qry_lot_size.$qry_year_built.$qry_stories.$qry_pool.$qry_waterfrnt." AND StandardStatus='Active'";
}
    
}else{ /** ignore other queries and seach mls number only **/
$query=" ListingId='$xmls_number'";
}
    
$checkFavs = "SELECT ListingId FROM saves WHERE email='$email' AND ListingId!='' ";
$favRslt = mysqli_query($conn,$checkFavs) or die(mysqli_error($conn));
$favExist = mysqli_num_rows($favRslt);  
$favoritesArray=array();

if($favExist>0){
while($row=mysqli_fetch_array($favRslt)){
extract($row);

array_push($favoritesArray,$ListingId);
}
}else{
array_push($favoritesArray,"No Favs");   
}

 
$toSel = 'ListingId,ListingKeyNumeric,StandardStatus,PropertyAddress,StreetName,StreetNumber,StreetSuffix,StreetDirSuffix,StreetNumberNumeric,City,PostalCode,Longitude,Latitude,DefaultPic,ListPrice,BedroomsTotal,BathroomsFull,BathroomsTotalInteger,GarageSpaces,LivingArea';
$sql = "SELECT $toSel FROM properties WHERE $query AND StateOrProvince='CA' AND Latitude>=$minLat AND Latitude<=$maxLat AND Longitude<=$maxLng AND Longitude>=$minLng";
$rs=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
$noListngs=mysqli_num_rows($rs);   

$allData=array();

if($noListngs>0){ 
$counter=1;
while ($row = mysqli_fetch_array($rs)){ 
    if($counter==1){
        $comma='';
    }else{
        $comma=',';
    } 
    extract($row);
    //'ListingId,ListingKeyNumeric,StandardStatus,PropertyAddress,StreetName,StreetNumber,StreetSuffix,StreetDirSuffix,StreetNumberNumeric,City,PostalCode,DefaultPic,ListPrice,BedroomsTotal,BathroomsFull,BathroomsTotalInteger,GarageSpaces,LivingArea';
    
    $List_Price=number_format($ListPrice,0);
    $ListPrice=number_format_Ms($ListPrice,2);
    
    if(in_array($ListingId, $favoritesArray)){
        $favDsply=' display: none;';
        $unfDsply=' display: inline-block;';
    }else{ 
        $favDsply=' display: inline-block;';
        $unfDsply=' display: none;';  
    }
    
    $l_st_num=trim(preg_replace("/[^0-9]/","",$StreetNumberNumeric));
    $l_st_nam=trim(preg_replace("/[^A-Za-z]/","-",$StreetName));
    $l_st_suf=trim(preg_replace("/[^A-Za-z]/","-",$StreetDirSuffix));
    $l_cty=trim(preg_replace("/[^A-Za-z]/","-",$City));
    $l_zip=trim(preg_replace("/[^0-9]/","",$PostalCode));
                                          
    if($l_st_num!=''){                    
        $l_st_num=$l_st_num.'-';          
    }                                     
                                          
    if($l_st_nam!=''){                    
        $l_st_nam=$l_st_nam.'-';          
    }                                     
                                          
    if($l_cty!=''){      
        $l_st_suf=$l_st_suf.'-';          
    }                                     
                                          
    if($l_cty!='' && $l_zip!=''){      
        $l_cty=$l_cty.'-';          
    }               
    
    if($StandardStatus == 'Active'){
        $statusColor = '#009500';
    }else if($StandardStatus == 'Closed'){
        $statusColor = 'red';
        $StandardStatus = 'Sold';
    }
                                                        
    $propertyLink=$l_st_num.$l_st_nam.$l_st_suf.$l_cty.'San-Diego-'.$l_zip;
    $propertyLink = str_replace('--','-',$propertyLink);
    $propertyLink = str_replace('--','-',$propertyLink);
    
    $PropertyAddress = trim($PropertyAddress);
    $PropertyAddress = str_replace('"',"'",$PropertyAddress);
    $PropertyAddress=trim(preg_replace("/[^A-Za-z0-9]/","-",$PropertyAddress));
    $PropertyAddress = str_replace('--','-',$PropertyAddress);
    $PropertyAddress = str_replace('--','-',$PropertyAddress);


$vertices_x = $allLng;    // x-coordinates of the vertices of the polygon
$vertices_y = $allLat; // y-coordinates of the vertices of the polygon
$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
$longitude_x = $Longitude;  // x-coordinate of the point to test
$latitude_y = $Latitude;    // y-coordinate of the point to test

if($Latitude!='' && $Longitude!=''){
    
    if(is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
    $dataToAdd=$latitude.'#'.$longitude;
    
    if(!in_array($dataToAdd,$allData)){
    array_push($allData, $dataToAdd); 
    $ppty_data.=$comma.'{"ListingId": "'.$ListingId.'", "ListingKeyNumeric": "'.$ListingKeyNumeric.'", "StandardStatus": "'.$StandardStatus.'", "PropertyAddress": "'.$PropertyAddress.'", 
    "StreetName": "'.$StreetName.'", "BathroomsFull": "'.$BathroomsFull.'", "BathroomsTotalInteger": "'.$BathroomsTotalInteger.'", "BedroomsTotal": "'.$BedroomsTotal.'", 
    "StreetNumber": "'.$StreetNumber.'", "StreetSuffix": "'.$StreetSuffix.'", "StreetDirSuffix": "'.$StreetDirSuffix.'", "StreetNumberNumeric": "'.$StreetNumberNumeric.'", 
    "City": "'.$City.'", "PostalCode": "'.$PostalCode.'", "Longitude": "'.$Longitude.'", "Latitude": "'.$Latitude.'", "DefaultPic": "'.$DefaultPic.'", "DefaultPic": "'.$DefaultPic.'", 
    "ListPrice": "'.$ListPrice.'", "List_Price": "'.$List_Price.'", "GarageSpaces": "'.number_format($GarageSpaces,0).'", "LivingArea": "'.number_format($LivingArea,0).'", "fav_display": "'.$favDsply.'", "unfav_display": "'.$unfDsply.'" }';
    
    }
    /**
    }else{
         
    $manipulated=manipulatePoints(0.000020,$allData,$ListingId,$ListingKeyNumeric,$StandardStatus,$PropertyAddress,$StreetName,$BathroomsFull,$BathroomsTotalInteger,$BedroomsTotal,$StreetNumber,$StreetSuffix,$StreetDirSuffix,$StreetNumberNumeric,$City,$PostalCode,$Longitude,$Latitude,$DefaultPic,$ListPrice,$List_Price,$GarageSpaces,$LivingArea,$favDsply,$unfDsply);  
    $pptyData=$manipulated['ppty_data'];
    $mani_lat=$manipulated['Latitude'];
    $mani_lng=$manipulated['Longitude'];
    
    $data_To_Add=$mani_lat.'#'.$mani_lng;
    array_push($allData, $data_To_Add);
    
    $ppty_data.=','.$pptyData;
    }
    
    }
    **/
    
}
$mapData='{"properties": ['.$ppty_data.']}';

$restlArray=array('data'=>'Done', 'ppty_data'=>$mapData);  

}

echo json_encode($restlArray); 

}else{
$restlArray=array('data'=>'No results found'); 
echo json_encode($restlArray);    
}   
?>