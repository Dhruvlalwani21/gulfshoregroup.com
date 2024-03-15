<?php
include 'connect.php';
$page = 'home';
$favoritesArray=json_decode($_SESSION['fav_ids'], true);

if(isset($_GET['page'])){
$page=$_GET['page'];

$limit = 20;
$pageNumber = intval($_GET['page']);

$sqlTTL = "SELECT COUNT(MLSNumber) AS total_records FROM saves WHERE user_id='$user_id'"; 
$ttlRslt = mysqli_query($conn,$sqlTTL); 
$rowQ = mysqli_fetch_assoc($ttlRslt); 
$total_records = $rowQ['total_records'];

$start_from = ($page-1) * $limit;
$toSel = 'p.matrix_unique_id, p.MLSNumber, p.BathsTotal, p.BedsTotal, p.City, p.CurrentPrice, p.GarageSpaces, p.PropertyAddress, p.Status, p.TotalArea, p.DefaultPic, p.AllPixList';
$sqlPpty = "SELECT f.MLSNumber, $toSel FROM saves AS f JOIN properties p ON f.MLSNumber = p.MLSNumber WHERE f.user_id='$user_id' ORDER BY f.save_id ASC LIMIT $start_from, $limit";
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
    
    <title>Favorite Listings | MVP Realty</title>
	
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
        
        <section class="gray pt-4">
        
        <div class="container">
        
        <div class="row m-0">
        	<div class="short_wraping no_radius shadow">
        		<div class="row align-items-center">
        	
        			<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
        				<div class="shorting_pagination xs-p-0">
        					<div class="shorting_pagination_laft xs-p-5">
        						<h4 class="xs-fs-18 xs-mb-0 xs-p-0"><?php echo $total_records;?> favorite listings</h4>
        					</div>
        				</div>
        			</div>
        			
        		</div>
        	</div>
        </div>
        
        <div class="row">
        	
        	<!-- property Sidebar --> 
        	<div class="col-lg-12 col-md-12 col-sm-12">
        		<div class="row justify-content-center">
        		  
                  
                    
                    
                    <input type="hidden" id="loc" value="" />
                    <input type="hidden" id="total_records" value="<?php echo $total_records;?>" />
                    <?php
                    if($noProperties>0){
                    
                    while($row = mysqli_fetch_array($pptyRslt)){
                    extract($row);
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
                    
                    if(in_array($MLSNumber, $favoritesArray)){
                        $favDsply=' display: none;';
                        $unfDsply=' display: inline-block;';
                    }else{ 
                        $favDsply=' display: inline-block;';
                        $unfDsply=' display: none;';  
                    }             
                    
                    if($Status == 'Active'){
                        $statusColor = '#009500';
                        $badge = '';
                    }else if($Status == 'Sold'){
                        $statusColor = 'red';
                        $badge = '<div class="_exlio_125" style="background-color: #EA7500; color: white;">Sold</div>';
                    }else if($Status == 'Pending'){
                        $statusColor = 'orange';
                        $badge = '<div class="_exlio_125">Pending</div>';
                    }
                     
                    if($location!=''){
                      if(stripos($PropertyAddress, $location) !== false) {
                        $PropertyAddress = str_ireplace($location,'<span id="highlight" style="padding-left: 3px; padding-right: 3px;">'.$location.'</span>',$PropertyAddress);
                      }else{
                        $expldLoc = explode(" ",$location);
                        foreach($expldLoc as $highlight){
                            $PropertyAddress = str_ireplace($highlight,'<span id="highlight">'.$highlight.'</span>',$PropertyAddress);
                        }
                      }
                    }
                    ?>
        			<!-- Single Property -->
        			<div class="col-lg-4 col-md-6 col-sm-12">
        				<div class="match-height property-listing property-2">
        					
        					<div class="listing-img-wrapper h-100">
        						<?php echo $badge;?>
        						<div class="list-img-slide">
            						<div class="click">
                                        <?php
                                        if($AllPixList !=''){
                                        $ecPix = explode(',',$AllPixList);
                                        $pixCounter = 0;                                    
                                        foreach($ecPix as $pix){
                                            if($pix!='' && $pixCounter>0){
                                            ?>
                							<div>
                                            <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                            <img src="<?php echo $pix;?>" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto" alt="" />
                                            </a>
                                            </div>                                            
                                            <?php                                                                                   
                                            }
                                            $pixCounter++; 
                                        }
                                        }else{
                                        ?>
            							<div>
                                        <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                        <img src="<?php echo $DefaultPic;?>" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto" alt="" />
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
        							<div class="_card_list_flex">
        								<div class="_card_flex_01">
        									<h4 class="listing-name verified">
                                            <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>" class="prt-link-detail">
                                            <?php echo $PropertyAddress;?>
                                            </a>
                                            </h4>
        								</div>
        							</div>
        							<div class="_card_list_flex  mb-1">
        								<div class="_card_flex_01">
        									<h6 class="listing-card-info-price mb-0 p-0" style="color: #0076AE;">$<?php echo number_format($CurrentPrice,0);?></h6> 
        								</div>
        							</div>
        						</div>
        					</div>
        					
        					<div class="price-features-wrapper">
        						<div class="list-fx-features">
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="assets/img/bed.svg" width="13" alt="" /></div><?php echo $BedsTotal;?> Beds
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="assets/img/bathtub.svg" width="13" alt="" /></div><?php echo $BathsTotal;?> Baths
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="assets/img/car.svg" width="13" alt="" /></div><?php echo $GarageSpaces;?> Car Garage
        							</div>
        							<div class="listing-card-info-icon">
        								<div class="inc-fleat-icon"><img src="assets/img/move.svg" width="13" alt="" /></div><?php echo number_format($TotalArea,0);?> sqft
        							</div>
        						</div>
        					</div>
        					
        					<div class="listing-detail-footer"> 
        						<div class="w-100" id="listing_footer" style="left: 5px;">
            						<div class="col-12 p-0 mt-5 mb-5 fleft dsply_inline_blck">
                                    
                                    <div class="col-3 fleft p-10 dsply_inline_blck" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
                                    <div class="btn fleft w-100" data-toggle="tooltip" title="Add To Favorites">
                                    <i class="ti-thumb-up"></i>
                                    </div>
                                    </div>
                                    
                                    <div class="col-3 fleft p-10 dsply_inline_blck" onclick="remFrmFav('<?php echo $MLSNumber;?>')" id="rem-frm-fav-<?php echo $MLSNumber;?>" style="<?php echo $unfDsply;?>">
                                    <div class="btn fleft w-100" style="background-color: #FF8484!important; color: white!important;" data-toggle="tooltip" title="Remove From Favorites">
                                    <i class="ti-thumb-down"></i>
                                    </div>
                                    </div>
                                    
                                    <div class="add_rem_loader_<?php echo $MLSNumber;?> col-3 centered-text fleft p-10" style="display: none;">
                                    <div class="btn fleft w-100"><img src="assets/img/loader.gif" class="float_none" style="width: 15px; height: 15px; cursor: pointer;" /></div>
                                    </div>
                                    
                                    <span class="col-3 fleft p-10 dsply_inline_blck" onclick="openGetInfo('<?php echo $MLSNumber;?>')">
                                    <div class="btn fleft w-100" data-toggle="tooltip" title="Get More Information">
                                    <i class="ti-email"></i>
                                    </div>
                                    </span>
                                    
                                    <span class="col-3 fleft p-10 dsply_inline_blck" onclick="openTourModal('<?php echo $MLSNumber;?>')">
                                    <div class="btn fleft w-100" data-toggle="tooltip" title="Schedule a Tour">
                                    <i class="ti-alarm-clock"></i>
                                    </div>
                                    </span>
                                    <span class="col-3 fleft p-10 dsply_inline_blck">
                                    <div class="btn fleft w-100" data-toggle="tooltip" title="View Details">
                                    <i class="ti-eye"></i>
                                    </div>
                                    </span>
                                    </div>
            					</div>
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
                    $ftrdComm .= $row['communities'];
                    ?>
					<a class="col-md-4 pl-0 fleft dsply_inline_blck mb-15" href="#"><?php echo $city_name;?></a>
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
					<a class="col-md-6 pl-0 fleft dsply_inline_blck mb-15"  data-toggle="tab" href="#"><?php echo $commName;?></a>
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
        	 
        </div>
        </div>	
        </section>
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    
    <script src="assets/js/PaginationForGet.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function(){
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
    </script>
    </div>
</body>
</html>

<?php
}else{
    echo '<script type="text/javascript">window.location.href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1";</script>';
}
?>