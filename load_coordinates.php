<?php
include 'connect.php';  
$favoritesArray=json_decode($_SESSION['fav_ids'], true);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(1);
error_reporting(0);

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

function manipulatePoints($addUp,$allData,$MLSNumber,$matrix_unique_id,$Status,$PropertyAddress,$BathsTotal,$BedsTotal,$Longitude,$Latitude,$DefaultPic,$badge,$CurrentPrice,$Current_Price,$City,$GarageSpaces,$SubCondoName,$TotalArea,$favDsply,$unfDsply,$AllPixList,$ListOfficeName,$pager){
    
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
    $ppty_data='{"MLSNumber": "'.$MLSNumber.'", "matrix_unique_id": "'.$matrix_unique_id.'", "Status": "'.$Status.'", "PropertyAddress": "'.$PropertyAddress.'", 
    "BathsTotal": "'.$BathsTotal.'", "BedroomsTotal": "'.$BedsTotal.'", "Longitude": "'.$Longitude.'", "Latitude": "'.$Latitude.'", "DefaultPic": "'.$DefaultPic.'", "Badge": "'.$badge.'", 
    "CurrentPrice": "'.$CurrentPrice.'", "Current_Price": "'.$Current_Price.'", "City": "'.$City.'", "GarageSpaces": "'.number_format($GarageSpaces,0).'", "SubCondoName": "'.$SubCondoName.'", 
    "TotalArea": "'.number_format($TotalArea,0).'", "fav_display": "'.$favDsply.'", "unfav_display": "'.$unfDsply.'", "AllPixList": "'.$AllPixList.'", "ListOfficeName": "'.$ListOfficeName.'", "pager": "'.$pager.'" }';
    
    return array('ppty_data'=>$ppty_data, 'Latitude'=>$Latitude, 'Longitude'=>$Longitude); 
    }else{
    $addUp+=0.000020;
    return manipulatePoints($addUp,$allData,$MLSNumber,$matrix_unique_id,$Status,$PropertyAddress,$BathsTotal,$BedsTotal,$Longitude,$Latitude,$DefaultPic,$badge,$CurrentPrice,$Current_Price,$City,$GarageSpaces,$SubCondoName,$TotalArea,$favDsply,$unfDsply,$AllPixList,$ListOfficeName,$pager);  
    }
}

$minLat=$_POST["minLat"]; 
$maxLat=$_POST["maxLat"]; 
$minLng=$_POST["minLng"]; 
$maxLng=$_POST["maxLng"]; 
$listSize=$_POST['listSize'];
$xmls_number=$_POST["mls_number"];
$location=$_POST["location"];
$property_type=$_POST["property_type"]; 
$min_price=$_POST["min_price"];  
$max_price=$_POST["max_price"];  
$city=$_POST["city"];  
$zipcode=$_POST["zipcode"];  
$bedrooms=$_POST["beds"];  
$bathrooms=$_POST["baths"];     
$min_sq_ft=$_POST["min_sq_ft"]; 
$max_sq_ft=$_POST["max_sq_ft"]; 
$min_year=$_POST["min_year"]; 
$garage=$_POST["garage"];
$just_listed=$_POST["just_listed"];
$include_sold=$_POST["include_sold"];
$foreclosure=$_POST['foreclosure'];
$short_sale=$_POST["short_sale"];
$pool=$_POST["pool"];   
$spa=$_POST["spa"];
$guest_house=$_POST["guest_house"];
$waterfront=$_POST["waterfront"];    
$gated=$_POST["gated"];
$communities=$_POST["communities"];
$gulf_access=$_POST["gulf_access"];
$ref=$_POST["ref"];
$sort_by=$_POST["sort"];
$page=$_POST['page'];
$pagination=$_POST['pagination'];

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
 $qry_min_max_pri_join=" AND ListPrice>=$min_price"; 
}else if(($min_price=='Any' || $min_price=='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND ListPrice<=$max_price"; 
}else if(($min_price!='Any' && $min_price!='') && ($max_price!='Any' && $max_price!='')){
 $qry_min_max_pri_join=" AND (ListPrice>=$min_price AND ListPrice<=$max_price)";   
}  
}else{
 $qry_min_max_pri_join=" AND ListPrice>0";
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
 
$toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, Latitude, Longitude, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, MatrixModifiedDT, other_fields_json';
$sql = "SELECT $toSel FROM properties WHERE $query AND Latitude>=$minLat AND Latitude<=$maxLat AND Longitude<=$maxLng AND Longitude>=$minLng ORDER BY $order_by";
$rs=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
$noListngs=mysqli_num_rows($rs);
 
$allData=array();
$listData=array();

if($noListngs>0){ 
$counter=1;
$resetCount=1;
$pager=1;
$today = strtotime(date("Y-m-d"));

while ($row = mysqli_fetch_array($rs)){ 
    if($counter==1){
        $comma='';
    }else{
        $comma=',';
    } 
    extract($row);
    
    $otherFieldsJson = json_decode($other_fields_json); 
    $ListOfficeName = $otherFieldsJson->ListOfficeName;
    $ListOfficePhone = $otherFieldsJson->ListOfficePhone;

    $Current_Price=number_format($CurrentPrice,0);
    $CurrentPrice=number_format_Ms($CurrentPrice,2);
    
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
    
    if(in_array($MLSNumber, $favoritesArray)){
        $favDsply=' display: none;';
        $unfDsply=' display: inline-block;';
    }else{ 
        $favDsply=' display: inline-block;';
        $unfDsply=' display: none;';  
    }             
    
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
    $badge = str_replace('"', '\"',$badge);

$dataToAdd=$Latitude.'#'.$Longitude;

if($Latitude!='' && $Longitude!=''){
    //matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, other_fields_json
     
    if(!in_array($dataToAdd,$allData)){
    array_push($allData, $dataToAdd); 
    $ppty_data.=$comma.'{"MLSNumber": "'.$MLSNumber.'", "matrix_unique_id": "'.$matrix_unique_id.'", "Status": "'.$Status.'", "PropertyAddress": "'.$PropertyAddress.'", 
    "BathsTotal": "'.$BathsTotal.'", "BedroomsTotal": "'.$BedsTotal.'", "Longitude": "'.$Longitude.'", "Latitude": "'.$Latitude.'", "DefaultPic": "'.$DefaultPic.'", "Badge": "'.$badge.'", 
    "CurrentPrice": "'.$CurrentPrice.'", "Current_Price": "'.$Current_Price.'", "City": "'.$City.'", "GarageSpaces": "'.number_format($GarageSpaces,0).'", "SubCondoName": "'.$SubCondoName.'", 
    "TotalArea": "'.number_format($TotalArea,0).'", "fav_display": "'.$favDsply.'", "unfav_display": "'.$unfDsply.'", "AllPixList": "'.$AllPixList.'", "ListOfficeName": "'.$ListOfficeName.'", "pager": "'.$pager.'" }';
    
    }else{
         
    $manipulated=manipulatePoints(0.000020,$allData,$MLSNumber,$matrix_unique_id,$Status,$PropertyAddress,$BathsTotal,$BedsTotal,$Longitude,$Latitude,$DefaultPic,$badge,$CurrentPrice,$Current_Price,$City,$GarageSpaces,$SubCondoName,$TotalArea,$favDsply,$unfDsply,$AllPixList,$ListOfficeName,$pager);  
    $pptyData=$manipulated['ppty_data'];
    $mani_lat=$manipulated['Latitude'];
    $mani_lng=$manipulated['Longitude'];
    
    $data_To_Add=$mani_lat.'#'.$mani_lng;
    array_push($allData, $data_To_Add);
    
    $ppty_data.=','.$pptyData;
    }
    
    if($resetCount<$listSize){
        $resetCount++;
    }else{
        $resetCount=1;
        $pager++;
    }
}
$counter++; 
}


$mapData='{"properties": ['.$ppty_data.']}';

$restlArray=array('data'=>'Done', 'ppty_data'=>$mapData, 'query'=>$query);  

echo json_encode($restlArray); 

}else{
$restlArray=array('data'=>'No results found'); 
echo json_encode($restlArray);    
}   
?>