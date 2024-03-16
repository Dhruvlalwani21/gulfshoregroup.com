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

$url = $_SERVER['REQUEST_URI'];

$urlarr=explode('/', $url);

if($urlarr[1] && $urlarr[2] && $urlarr[3] && $urlarr[4]){

$slug=$urlarr[2];
$type=$urlarr[3];
$sort=$urlarr[4];

if($urlarr[5]){
$page=$urlarr[5];
}
}else{
 echo '<script type="text/javascript">window.location.href="/";</script>';  
}

if($slug && $type && $sort){
$sort_by=$sort;
$property_type = strtolower($type);
$limit = 16;
$pageNumber = intval($page);

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
$ttlRslt = mysqli_query($conn,$sqlTTL) or die(mysqli_error($conn));
$rowQ = mysqli_fetch_assoc($ttlRslt); 
$total_records = $rowQ['total_records'];


$start_from = ($page-1) * $limit;
$toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList';
$sqlPpty = "SELECT $toSel FROM properties WHERE $query ORDER BY $orderCase $order_by LIMIT $start_from, $limit"; //
$pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
$noProperties = mysqli_num_rows($pptyRslt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
    <base href="/" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    
    <title><?php echo $page_title;?></title>
	
    <?php include_once 'styles.php';?>
    
    <script type="text/javascript">
    var curr_page='<?php echo $pageNumber;?>'; 
    var lm='<?php echo $limit;?>';
    var email = '<?php echo $logged_email;?>';
    var logged_email = '<?php echo $logged_email;?>';
    var sort = '<?php echo $sort_by;?>';
    </script>
    
    <?php
    if($noProperties<1){
        
        if($property_type == 'homes'){
        echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/condos/price-asc/1";</script>';       
        }else if($property_type == 'condos'){
        echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/land/price-asc/1";</script>';     
        }else if($property_type == 'land'){
        echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/sold/price-asc/1";</script>';     
        }
    
    }
    ?>
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
        
        <div class="page-title" style="background:#f4f4f4 url(<?php echo $headerImg;?>);" data-overlay="5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
                            <h2 class="breadcrumb-title"><?php echo $page_title;?></h2>
							<ol class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page"><?php echo $name;?></li>
							</ol>
						</div>
						
					</div>
				</div>
			</div>
		</div>
        
        <section class="gray pt-4 xs-pb-15">
            <div class="container xs-mxw-95">
            
                <div class="row">
        	
            	<!-- property Sidebar --> 
            	<div class="col-lg-8 col-md-12 col-sm-12">
                
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <form autocomplete="off">
                    <div class="form-group relative">
                        <label id="form_lbl">Quick search</label>
                    	<div class="input-with-icon">
                    		<input type="text" class="form-control no_radius" onkeyup="quickSearch(this.value)" id="advnc_state_or_city" name="advnc_state_or_city" placeholder="Enter a Community Name, Development, Street, Address or Zip Code" />
                    		<i class="ti-location-pin"></i>
                            <img src="assets/img/loader.gif" class="quick_srch_img" />
                    	</div>
                        <ul class="w100 absolute shadow p-0" id="streamed_search">
                        </ul>
                    </div>
                    </form>
                    </div>
                    </div>
                    
                    
                    
                
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20 mt-30" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <h4 class="w-100 fs-18"><?php echo $name;?> Florida Predefined Property Search</h4>
                    
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=Yes&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> New Listings <span class="badge badge-primary">NEW</span></a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=3%2B&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> 3+ Bedroom Homes for Sale</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=Yes&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> <?php echo $name;?> Foreclosures</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=Condos&city=&zipcode=&beds=2%2B&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> 2+ Bedroom Condos for Sale</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=Yes&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> <?php echo $name;?> Short Sales</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=1500000&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> Luxury Homes and Condos</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&status=Sold&pagination=get&page=1"><i class="ti-search fs-13"></i> Sold Properties</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=<?php echo $name;?>&mls_number=&min_price=&max_price=&property_type=Condos&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=Yes&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> Waterfront Homes and Condos</a>
                    
                    </div>
                    
                    <?php
                    if($noMyCom>0){
                    ?>
                    <div class="col-md-12 fleft mt-30">
                    <img src="admin/templates/communities/<?php echo $header_img;?>" onerror="$(this).attr('src','https://via.placeholder.com/300x200.png?text=No+community+image+added+yet')" style="float: left; height: 200px; width: auto; max-width: 100%; margin-right: 20px; margin-top: 10px; border-bottom: 12px solid white; margin-bottom: 0px!important;" />
                    <span class="fs-17" id="post_content"><?php echo $content;?></span>
                    </div>
                    <?php
                    }
                    ?>
                    </div>
                    
                    
                    <div class="row justify-content-center pt-20 pb-20 mt-30" style=" margin-right: -30px;">
                    <div class="w-100 fleft">
                    <div class="col-12 pl-0">
                    	<div class="short_wraping no_radius shadow">
                    		<div class="row align-items-center">
                    	
                    			<div class="col-lg-5 col-md-6 col-sm-12 col-sm-12">
                    				<div class="shorting_pagination">
                    					<div class="shorting_pagination_laft">
                                            <!--h4 class="fs-18">< ?php echo $name;?> Listings</h4-->
                    						 <h4 class="fs-18">
                                             <?php
                                             $color = '#595959';
                                             if($homes_for_sale>0){
                                             if($property_type == 'homes'){
                                                $hm_color = '#009EEA';
                                             }else{ $hm_color =  $color; }
                                             ?>
                                             <a href="community/<?php echo $name?>/homes/price-asc/1" class="medium fs-16" style="color: <?php echo $hm_color;?>;">Homes</a>&nbsp;|&nbsp;
                                             <?php
                                             }
                                             
                                             if($condos_for_sale>0){
                                             if($property_type == 'condos'){
                                                $con_color = '#009EEA';
                                             }else{ $con_color =  $color; }
                                             ?>
                                             <a href="community/<?php echo $name?>/condos/price-asc/1" class="medium fs-16" style="color: <?php echo $con_color;?>;">Condos</a>&nbsp;|&nbsp;
                                             <?php
                                             }
                                             
                                             if($lands_for_sale>0){
                                             if($property_type == 'land'){
                                                $lnd_color = '#009EEA';
                                             }else{ $lnd_color =  $color; }
                                             ?>
                                             <a href="community/<?php echo $name?>/land/price-asc/1" class="medium fs-16" style="color: <?php echo $lnd_color;?>;">Land</a>&nbsp;|&nbsp;
                                             <?php
                                             }
                                             
                                             if($property_type == 'sold'){
                                                $sld_color = '#009EEA';
                                             }else{ $sld_color =  $color; }
                                             ?>
                                             <a href="community/<?php echo $name?>/sold/price-asc/1" class="medium fs-16" style="color: <?php echo $sld_color;?>;">Sold</a>
                                             </h4>
                    					</div>
                    				</div>
                    			</div>
                    	
                    			<div class="col-lg-7 col-md-6 col-sm-12 col-sm-6">
                    				<div class="shorting-right">
                    					<label>Sort By:</label>
                    					<div class="dropdown show">
                    						<a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    							<span class="selection" id="selected_sorts"></span>
                    						</a>
                    						<div class="drp-select dropdown-menu">
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="price-desc" onclick="$('#advnc_sort_by').val('price-desc'); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Highest price</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="price-asc" onclick="$('#advnc_sort_by').val('price-asc'); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Lowest Price</a> 
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="sqft-desc" onclick="$('#advnc_sort_by').val('sqft-desc'); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Largest square footage</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="sqft-asc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Lowest square footage</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="beds-desc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Largest beds</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="beds-asc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Smallest beds</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="baths-desc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Largest baths</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="baths-asc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Smallest baths</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="built-desc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Year built new first</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="built-asc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Year built old first</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="new-desc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-down fs-13"></i> Sort by Newest listings first</a>
                                                <a class="dropdown-item" href="JavaScript:Void(0);" id="new-asc" onclick="$('#advnc_sort_by').val(this.id); sortBy()"><i class="ti-arrow-up fs-13"></i> Sort by Oldest listings first</a>
                                
                    						</div>
                    					</div>
                    				</div>
                    			</div>
                    			
                    		</div>
                    	</div>
                    </div>
                    
                    <input type="hidden" id="loc" value="" />
                    <input type="hidden" id="total_records" value="<?php echo $total_records;?>" />
                    <?php include_once 'community-listings.php';?>
                    
                    <div class="col-md-12 pl-0 fleft mt-15">
                    <div class="tr-pagination tr-section w-100 fleft">
                        <ul class="pagination centered-text"></ul>       
                    </div>
                    </div>
                    </div>
                    </div>
                    
                    
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20 mt-30" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
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
                    
                </div>
                
                
                
                
                
                
                <div class="col-lg-4 xs-pl-0 xs-pr-0 sm-pl-0 sm-pr-0 md-pl-0 md-pr-0 md-mt-30 col-md-12 col-sm-12">
                <div class="page-sidebar p-20 shadow no_radius">
                <h4 class="w-100 centered-text fs-17"><?php echo $name;?> Real Estate</h4>
                
                <div class="totalsNav w-100"> 
                <a href="community/<?php echo $name;?>/homes/price-asc/1" rel="nofollow"> 
                <span class="frs">Homes For Sale</span><span class="snd"><?php echo $homes_for_sale;?></span><span class="trd">$<?php echo number_format_short($homes_min_price);?> - $<?php echo number_format_short($homes_max_price);?></span> 
                </a> 
                <a href="community/<?php echo $name;?>/condos/price-asc/1" rel="nofollow"> 
                <span class="frs">Condos For Sale</span><span class="snd"><?php echo $condos_for_sale;?></span><span class="trd">$<?php echo number_format_short($condos_min_price);?> - $<?php echo number_format_short($condos_max_price);?></span> 
                </a> 
                
                <a href="community/<?php echo $name;?>/land/price-asc/1" rel="nofollow"> 
                <span class="frs">Land For Sale</span><span class="snd"><?php echo $lands_for_sale;?></span><span class="trd">$<?php echo number_format_short($lands_min_price);?> - $<?php echo number_format_short($lands_max_price);?></span> 
                </a> 
                
                <a href="community/<?php echo $name;?>/sold/price-asc/1" rel="nofollow">
                <span class="frs">Sold</span><span class="snd"><?php echo $sold;?></span><span class="trd">$<?php echo number_format_short($min_sold_price);?> - $<?php echo number_format_short($max_sold_price);?></span> 
                </a> 
                </div>
    
                <div class="w-100 mt-15 centered-text">
                Last updated at <?php echo date("m-d-Y g:i a", strtotime($last_updated));?>
                </div>
                </div>
                 
                
                <?php 
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
    <?php include_once 'footer.php';?>  

    <script src="assets/js/PaginationForPath.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    
    $(".dropdown-menu #"+sort).addClass('active');
    $("#selected_sorts").html($(".dropdown-menu #"+sort).html());
   
    $(".match-height").matchHeight();
    setPagination(); 
    
    
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
    
    
    function formatToCurrency(amount) {
      amount = parseFloat(amount);
      return "$" + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
    };
    
    function sortBy(){
        var sortBy = $("#advnc_sort_by").val();
        var loc = window.location.href;
        var spltLoc = loc.split('/');
        var link = spltLoc[0]+'/'+spltLoc[1]+'/'+spltLoc[2]+'/'+spltLoc[3]+'/'+spltLoc[4]+'/'+spltLoc[5]+'/'+sortBy+'/1';
        window.location.href=link;
    }
    </script>
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