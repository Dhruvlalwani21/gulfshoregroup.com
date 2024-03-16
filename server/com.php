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

if(isset($_GET['slug']) && isset($_GET['type']) && isset($_GET['sort'])){
$slug = $_GET['slug'];
$sort_by=$_GET["sort"];
$property_type = strtolower($_GET['type']);
$page=$_GET['page'];
$limit = 16;
$pageNumber = intval($_GET['page']);

$selComm = "SELECT * FROM all_communities WHERE name='$slug'";  
$comRslts = mysqli_query($conn,$selComm);  
$noCom = mysqli_num_rows($comRslts);

if($noCom>0){
$rowCom = mysqli_fetch_array($comRslts);
extract($rowCom);
$prepend = $unique_id.":";

$selMyComm = "SELECT page_title, meta_description, content, header_img, header_thumb FROM communities WHERE name='$prepend$slug'";  
$myRslts = mysqli_query($conn,$selMyComm);  
$noMyCom = mysqli_num_rows($myRslts);

$rowMyCom = mysqli_fetch_array($myRslts);
$page_title = $rowMyCom['page_title'];
$meta_description = $rowMyCom['meta_description'];
$content = $rowMyCom['content'];
$header_img = $rowMyCom['header_img'];
$header_thumb = $rowMyCom['header_thumb'];

if(!$header_img || !file_exists('admin/templates/communities/'.$header_img)){
    $headerImg = 'assets/img/florida-2.jpg';
}else{
    $headerImg = 'admin/templates/communities/'.$header_img;
}



$qry_loc=" (Development LIKE '%$name%' OR DevelopmentName LIKE '%$name%') "; //.$each; 
$orderCase = "CASE WHEN Development LIKE '%$name%' THEN 0  
                 WHEN DevelopmentName LIKE '%$name%' THEN 1  
                 ELSE 3
            END,"; 

if($property_type!='Any' && $property_type!=''){
  if($property_type=='homes'){
  $ppty_qry = " PropertyClass='RES' AND Status='Active' ";
  }else if($property_type=='condos'){
  $ppty_qry = " CommunityType LIKE '%Condo%' AND Status='Active' ";
  }else if($property_type=='land'){
  $ppty_qry = " PropertyClass='LOT' AND Status='Active' ";
  }else if($property_type=='sold'){
  $ppty_qry = " Status='Sold'";
  }else{
  $ppty_qry = " PropertyClass='RES' AND Status='Active' ";
  }
                 
  $qry_type=" AND $ppty_qry "; 
  //$qry_type=" AND $open$ppty_qry$close ";  
  //$qry_type = " AND PropertyClass='$property_type' ";   
}else{
  $qry_type="";  
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
 $sort_by="price-asc";
}

 
$query=$qry_loc.$qry_type;


$sqlTTL = "SELECT COUNT(MLSNumber) AS total_records FROM properties WHERE $query"; 
$ttlRslt = mysqli_query($conn,$sqlTTL) or die(mysqli_error($conn));; 
$rowQ = mysqli_fetch_assoc($ttlRslt); 
$total_records = $rowQ['total_records'];


$start_from = ($page-1) * $limit;
$toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList';
$sqlPpty = "SELECT $toSel FROM properties WHERE $query ORDER BY $orderCase $order_by LIMIT $start_from, $limit"; //
$pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
$noProperties = mysqli_num_rows($pptyRslt);

$resproperties = array();
    while ($rowM = mysqli_fetch_assoc($pptyRslt)) {
        $resproperties[] = array(
            'matrix_unique_id' => $rowM['matrix_unique_id'],
            'MLSNumber' => $rowM['MLSNumber'],
            'BathsTotal' => $rowM['BathsTotal'],
            'BedsTotal' => $rowM['BedsTotal'],
            'City' => $rowM['City'],
            'CurrentPrice' => $rowM['CurrentPrice'],
            'GarageSpaces' => $rowM['GarageSpaces'],
            'PropertyAddress' => $rowM['PropertyAddress'],
            'Status' => $rowM['Status'],
            'SubCondoName' => $rowM['SubCondoName'],
            'TotalArea' => $rowM['TotalArea'],
            'DefaultPic' => $rowM['DefaultPic'],
            'AllPixList' => $rowM['AllPixList'],
            'MatrixModifiedDT' => $rowM['MatrixModifiedDT'],
            'other_fields_json' => $rowM['other_fields_json']
        );
    }

    // Prepare response array
    $response = array(
        'properties' => $resproperties,
        'total_records' => $total_records
    );

    // Encode response as JSON and output
    echo json_encode($response);



}else{
    echo "No Communities Found"  ;
}
}else{
    echo "Request Error" ;
}

?>