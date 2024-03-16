<?php
include 'connect.php';
$page = 'home';

$selMeta = "SELECT * FROM metas WHERE page='$page'";  
$metaRslts = mysqli_query($conn,$selMeta);
$row = mysqli_fetch_array($metaRslts);
$page_title = $row['title'];
$meta_description = $row['meta_description'];
$favoritesArray=json_decode($_SESSION['fav_ids'], true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta name="google-site-verification" content="NYG8-9kV_iAx2C3tkjoLf1MdGsgIHssLU_7NQtWkiTs" />
	<meta charset="utf-8" />
	<meta name="author" content="Dhruv Lalwani" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    <link rel="manifest" href="manifest.json">
    <title><?php echo $page_title;?></title>
	
    <?php include_once 'styles.php';?>   
    <script type="text/javascript">
    var email = '<?php echo $logged_email;?>';
    var logged_email = email;
    </script>
  
      <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1VDEW2DPN8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1VDEW2DPN8');
</script>
   <!-- Google tag completed-->

</head>

<body class="yellow-skin">

	 <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
<div class="d-flex justify-content-center">
  <div class="spinner-border preloader" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>
	
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
	
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
        <!-- Start Navigation -->
		<div class="header header-transparent change-logo">
			<div class="container">
				<?php
                $itsHome = "Yes";
                include_once 'nav.php';
                ?>
			</div>
		</div>
		<!-- End Navigation -->
		<div class="clearfix"></div>
		<!-- ============================================================== -->
		<!-- Top header  -->
		<!-- ============================================================== -->
		
		
		<!-- ============================ Hero Banner  Start================================== -->
		<div class="hero_banner image-cover" style="background:#f6f6f6 url(assets/img/florida-2.jpg) no-repeat; position: relative;" data-overlay="1">
				<div style="position: absolute; background-color: rgb(0 0 0 / 40%); top: 0; left: 0; bottom: 0; right: 0; z-index: 0;"></div>
                <div class="container">
					
					<h2 class="font-normal text-center mb-1">
                    We Are <strong><i class="theme-cl f-style" style="color: #09AFFF!important;">#1</i></strong><br />
                    Because We Put You <strong><i class="theme-cl f-style" style="color: #09AFFF!important;">First</i></strong></h2>
					<div class="mb-4 text-mlixer fs-20" style="color: yellow;"></div>
	
						<div class="row justify-content-center">
							<div class="col-lg-12 col-md-12 relative" style="z-index: 99!important;">
							
								<div class="full_search_box nexio_search lightanic_search hero_search-radius style-2">
									<div class="search_hero_wrapping xs-pt-10 sm-pt-10">
									<div class="row">
							
										<div class="col-lg-4 col-md-12 col-sm-12 small-padd relative">
                                            <form class="w-100 relative" autocomplete="off">
											<div class="form-group relative quick">
												<div class="input-with-icon">
													<input type="text" class="form-control b-0 b-r" onkeyup="quickSearch(this.value,'lite')" id="advnc_state_or_city" placeholder="Enter a community, Addreess or Zip Code..." autocomplete="off" />
													<i class="ti-search"></i>
                                                    <img src="assets/img/loader.gif" class="quick_srch_img" />
												</div>
											</div>
                                            </form>
										</div>
										
										<div class="col-lg-2 col-md-4 col-sm-12 xs-mt-0 sm-mt-0 md-mt-10 small-padd">
											<div class="form-group">
												<div class="input-with-icon">
                                                    <select class="form-control" id="advnc_city" name="advnc_city">
                                                    <option value="">All cities</option>
                                                    <option value="Ave Maria">Ave Maria</option>
                                                    <option value="Bonita Springs">Bonita Springs</option>
                                                    <option value="Cape Coral">Cape Coral</option>
                                                    <option value="Estero">Estero</option>
                                                    <option value="Fort Myers">Fort Myers</option>
                                                    <option value="Immokalee">Immokalee</option>
                                                    <option value="Lehigh Acres">Lehigh Acres</option>
                                                    <option value="Marco Island">Marco Island</option>
                                                    <option value="Naples">Naples</option>
                                                    </select>
													<i class="ti-location-pin"></i>
												</div>
											</div>
										</div>
                                        
                                        <div class="col-lg-2 col-md-4 col-sm-12 xs-mt-0 sm-mt-0 md-mt-10 small-padd">
											<div class="form-group">
												<div class="input-with-icon">
                                                    <select class="form-control" name="min_price" id="min_price" onchange="compareMaxOption(this.value,'max_price')">
                                                    <option value="Any" selected="selected">Min Price</option>
                                                    <?php include 'price_list.php';?>
                                                    </select>
													<i class="ti-money"></i>
												</div>
											</div>
										</div>
                                        
                                        <div class="col-lg-2 col-md-4 col-sm-12 xs-mt-0 sm-mt-0 md-mt-10 small-padd">
											<div class="form-group">
												<div class="input-with-icon">
                                                    <select class="form-control" name="max_price" id="max_price" onchange="compareMinOption(this.value,'min_price')">
                                                    <option value="Any" selected="selected">Max Price</option>
                                                    <?php include 'price_list.php';?>
                                                    </select>
													<i class="ti-money"></i>
												</div>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-12 col-sm-12 small-padd xs-mt-0 sm-mt-0 md-mt-10 md-fright">
                                            <div class="col-lg-12 col-md-4 col-12 p-0 md-fright">
											<div class="form-group">
												<a href="javascript:;" onclick="homeSearch()" class="btn search-btn">Quick Search</a>
											</div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						    
                            <script type="text/javascript">
                            function homeSearch(){
                                var location=encodeURIComponent($("#advnc_state_or_city").val().trim());
                                var city = $("#advnc_city").val().trim();
                                var min_price=encodeURIComponent($("#min_price").val().trim());
                                var max_price=encodeURIComponent($("#max_price").val().trim()); 
                                
                                if(location=='' || location=='All'){ location='Any'; }
                                window.location.href='search.php?location='+location+'&mls_number=&min_price='+min_price+'&max_price='+max_price+'&property_type=&city='+city+'&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-asc&pagination=get&page=1';
                            }
                            </script>
								        
                            <div class="col-12 mt-10 pl-0 xs-pr-0 relative" style="z-index: -1!important;">
                            <b class="fs-18">
                            <a href="mls-search" class="btn p-10 pl-20 pr-10 xs-mw-100 xs-mb-15 xs-mt-10 xs-pr-0" style="background-color: #027cff; color: white;"><i class="ti-search fs-13"></i> Advanced MLS Search</a>
                            <a class="btn p-10 pl-20 pr-10 ml-15 xs-mw-100 xs-ml-0" href="map-search.php?location=Any&communities=&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&sort=price-asc&gated=&gulf_access=&ref=&sort=price-asc&page=1&pagination=get&dfltLat=&dfltLng=&aNord=&aEst=&aSud=&aOvest=&zoom=11" style="background-color: #027cff; color: white;"><i class="ti-location-pin fs-13"></i> Map Search</a>
                            </b>
                            </div>	
						</div>
					</div>
				</div>
                
			</div>
		<!-- ============================ Hero Banner End ================================== -->

		<!-- ============================ Our Awards Start ================================== -->
        
        
		<section class="p-0 relative">
			<div class="col-10 sm-col-12 xs-col-12" style="margin: auto; float: none; padding: 0px;">
				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 xs-pl-0 xs-pr-0">
					
						<div class="_awards_group fleft w-100" id="tabs">	
                        <h4 class="w-100 p-25 centered-text xs-pl-10 xs-pr-10">
                        <b><i class="ti-star"></i> Featured cities </b> <span style="font-weight: normal;">click city name for more information</span>
                        <div class="float_none m-auto mt-10" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                        </h4>
					        <nav class="w-100">
            					<div class="nav nav-tabs nav-fill city-list" class="w-100" id="nav-tab" role="tablist">
                                    <?php
                                    $counter = 0;
                                    if($noNavCity>0){
                                    foreach ($cityData as $row){
                                    $city_name = $row['name'];
                                    $tabName_1 = preg_replace('#[^A-Za-z0-9]#', '-', $city_name);
                                    
                                    if($counter==0){
                                        $acitve = ' active';
                                    }else{
                                        $acitve = '';
                                    }
                                    ?>
            						<a class="nav-item nav-link <?php echo $acitve;?>" id="<?php echo $tabName_1;?>-tab" data-toggle="tab" href="#<?php echo $tabName_1;?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $city_name;?></a>
                                    <?php
                                    $counter++;
                                    }
                                    }
                                    ?>
            					</div>
            				</nav>
            				<div class="tab-content w-100 xs-pl-10 xs-pr-10" id="nav-tabContent">
                                <?php
                                $counterX = 0;
                                foreach($cityData as $row){
                                $cityName = $row['name'];
                                $hdrImg = $row['header_img'];
                                $page_title = $row['page_title'];
                                $city_slug = $row['slug'];
                                $content = strip_tags($row['content']);
                                $communities = $row['communities'];
                                
                                $tabName_2 = preg_replace('#[^A-Za-z0-9]#', '-', $cityName);
                                
                                if($counterX==0){
                                    $acitveX = ' active';
                                }else{
                                    $acitveX = '';
                                }
                                ?>
            					<div class=" tab-pane w-100 fade show <?php echo $acitveX;?>" id="<?php echo $tabName_2;?>" role="tabpanel" aria-labelledby="<?php echo $tabName_2;?>-tab">
            				<div class="row align-items-center justify-content-between">
                            <div class="fcidiv col-xl-5 col-lg-5 col-md-6 col-sm-12">	<img class="fcimg" src="admin/templates/cities/<?php echo $hdrImg;?>" loading="lazy" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=Failed+To+Load+Image')" style="float: left; margin-right: 20px; margin-bottom: 1px;" /></div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">      <p class="inner_cont" class="p-0 xs-fs-14"><?php echo $content;?></p></div>
                              </div>  
                                <div class="w-100 fleft mt-20">
                                <h3 class="w-100 centered-text xs-fs-20"> <?php echo $cityName;?> Communities</h3>
                                <div class="float_none m-auto mt-10" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                                
                                <div class="w-100 fleft mt-20 centered-text">
                                <div class="col-12 float_none m-auto">
                                <div class="w-100 fleft text-left">
                                <?php
                                $xpld = explode(',',$communities);
                                $ctCnt = 1;
                                foreach($xpld as $commWtNumb){
                                    if($ctCnt<=12){
                                    $nameXpld = explode(':',$commWtNumb);
                                    if($commWtNumb!=""){
                                    $commName = $nameXpld[1];
                                    

                                $comname = preg_replace('#[^A-Za-z0-9]#', '-', $commName);


                                    echo '<div class="fleft dsply_inline_blck col-lg-3 col-md-6 xs-pl-0 xs-pr-0 fs-16 mb-15">
                                    <a href="community/'.urlencode($comname).'/homes/price-asc/1" class="pb-5 ellipses-1-line" style="border-bottom: 1px dashed #09AFFF;"><i class="ti-angle-double-right" style="color: #09AFFF;"></i> '.$commName.'</a>
                                    </div>';
                                    }
                                    $ctCnt++;
                                    }
                                }
                                ?>
                                </div>
                                
                                <div class="col-12 fleft mt-15 text-left xs-fs-15">
                                <a href="city/<?php echo $city_slug;?>" style="color: #FF5F11;"><i class="ti-hand-point-right"></i> See all communities in <?php echo $cityName;?></a>
                                </div>
                                </div>
                                </div>
                                </div>
            					</div>
                                <?php
                                $counterX++;
                                }
                                ?>
            				</div>
						</div>
						
					</div>
				</div>
			</div>
		</section>
        
		<!-- ============================ Our Awards End ================================== -->
		
		<!-- ============================ List Tag Start ================================== -->
		<section>
			<div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="eplios_tags">
							<div class="tags-1"><i class="ti-shine"></i></div>
							<h2 class="w-100 xs-fs-20">SW Florida Real Estate Search</h2>
                            <div class="w-100">
                            <div class="mb-15" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                            </div>
							<p class="fs-18 w-100">
                            Our website features the best real estate search for homes, condos, land and foreclosure properties available. It is the only site you will ever need! 
                            It is easy-to-use and updated by the official Realtor&reg;'s database every 15 minutes.  
                            </p>
                            <p class="fs-18 w-100">
                            You can save searches, and get daily email alerts of new listings, price changes, sold data, and market reports. Our Interactive Map Search allows you 
                            to view properties on a map or refine your search by drawing the boundaries around the area you desire.
                            </p>
						</div>
					</div>
					
					<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
						<div class="text-center">
							<img src="assets/img/florida-2.jpg" loading="lazy" class="img-fluid shadow" alt="" />
						</div>
					</div>
                    
                    <div class="col-12 mt-15 pl-0 pr-0 mt-40">
                    <h2 class="col-12 xs-fs-20">SW Florida Homes for Sale</h2>
                    <div class="col-12">
                    <div class="fleft mb-15" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                    </div>
                    <?php
                    $link_prefix = '&property_type=Homes&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-asc&pagination=get&page=1';
                    ?>
					<ul class="eplios_list w-100">
						<li><a href="search.php?location=Any&mls_number=&min_price=&max_price=<?php echo $link_prefix;?>"><i class="ti-search"></i> All listings</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=&max_price=100000<?php echo $link_prefix;?>"><i class="ti-search"></i> Under $100,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=100000&max_price=200000<?php echo $link_prefix;?>"><i class="ti-search"></i> $100,000 - $200,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=200000&max_price=300000<?php echo $link_prefix;?>"><i class="ti-search"></i> $200,000 - $300,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=300000&max_price=400000<?php echo $link_prefix;?>"><i class="ti-search"></i> $300,000 - $400,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=400000&max_price=500000<?php echo $link_prefix;?>"><i class="ti-search"></i> $400,000 - $500,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=500000&max_price=600000<?php echo $link_prefix;?>"><i class="ti-search"></i> $500,000 - $600,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=600000&max_price=700000<?php echo $link_prefix;?>"><i class="ti-search"></i> $600,000 - $700,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=700000&max_price=800000<?php echo $link_prefix;?>"><i class="ti-search"></i> $700,000 - $800,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=800000&max_price=900000<?php echo $link_prefix;?>"><i class="ti-search"></i> $800,000 - $900,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=900000&max_price=1000000<?php echo $link_prefix;?>"><i class="ti-search"></i> $900,000 - $1,000,000</a></li>
                        <li><a href="search.php?location=Any&mls_number=&min_price=1000000&max_price=<?php echo $link_prefix;?>"><i class="ti-search"></i> Over $1,000,000</a></li>
					</ul>
                    </div>
					
				</div>
			</div>
		</section>
		<!-- ============================ Property Tag End ================================== -->
		
		<!-- ============================ Properties Start ================================== -->
        <section class="pt-0 min">
        <div class="container p-0 lg-mxw-97 xs-pl-15 xs-pr-15 sm-pl-15 sm-pr-15">
        
        	<div class="row justify-content-center">
        		<div class="col-lg-7 col-md-10 text-center">
        			<div class="sec-heading center mb-4">
        				<h2>Featured Listings</h2>
        				<p>Today's featured SW florida listings</p>
        			</div>
        		</div>
        	</div>
        	
        	<div class="row justify-content-center">
        		<div class="w-100 fleft sm-text-center">
                <?php
                $selFeatured = "SELECT matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, other_fields_json FROM properties WHERE Status='Active' AND ListPrice>0 AND (PropertyClass='RES' OR PropertyClass='RIN') ORDER BY RAND() LIMIT 9";  
                $ftrdRslts = mysqli_query($conn,$selFeatured);
                $ftrdExst = mysqli_num_rows($ftrdRslts);
                
                if($ftrdExst>0){
                while($rowFtrd = mysqli_fetch_array($ftrdRslts)){
                extract($rowFtrd);
                $link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
                
                $otherFieldsJson = json_decode($other_fields_json); 
                $ListOfficeName = $otherFieldsJson->ListOfficeName;
                $ListOfficePhone = $otherFieldsJson->ListOfficePhone;
                    
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
                
                ?>

        		<!-- Single Property -->
        		<div class="col-lg-4 col-md-6 col-sm-10 xs-mb-15 sm-mb-15 fleft dsply_inline_blck sm-float_none">
        				<div class="match-height property-listing property-2">
        					
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
                                            <img src="<?php echo $pix;?>" id="<?php echo $MLSNumber;?>" loading="lazy" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="<?php echo $link;?>" />
                                            </a>
                                                       <div class="card-img-overlay">
                                    <div class="btn fright like" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
                       <i class="fa-regular fa-thumbs-up"></i>
                                    </div>
                                    </div>
                                            </div>                                            
                                            <?php                                                                                   
                                            }    
                                            $pixCounter++; 
                                        }
                                        }else{
                                        ?>
            							<div>
                                        <a href="javascript:;" data-href="listings/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                        <img src="<?php echo $DefaultPic;?>" loading="lazy" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="<?php echo $link;?>" />
                                        </a>
                                            <div class="card-img-overlay" >
                                    <div class="btn fright like" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
                       <i class="fa-regular fa-thumbs-up"></i>
                                    </div>
                                    </div>
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
                                            <a href="listings/<?php echo $MLSNumber;?>/<?php echo $link;?>" class="w-100 prt-link-detail">
                                            <div class="w-100"><?php echo $SubCondoName;?></div>
                                            <div class="w-100 fs-14 medium" style="color: #535353;"><i class="ti-location-pin"></i> <?php echo $PropertyAddress;?></div>
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
                                <div class=" w-100 fs-11 text-left">
      								<?php echo $ListOfficeName;?>
       							</div>
        					</div>
        					
        					<div class="listing-detail-footer"> 
        						<div class="w-100" id="listing_footer" style="left: 5px;">
            						<div class="p-0 mt-5 mb-2">
                                 
                                    <div class="add_rem_loader_<?php echo $MLSNumber;?> col-3 centered-text fleft p-10" style="display: none;">
                                    <div class="btn fleft w-100"><img src="assets/img/loader.gif" class="float_none" style="width: 15px; height: 15px; cursor: pointer;" /></div>
                                    </div>
                                    
                                    <span class="p-2" onclick="openGetInfo('<?php echo $MLSNumber;?>')">
                                    <a href="#" class="btn btn-primary btn-lg btn-block">Get Information</a>
                                    </span>
                                    
                                    <span class="p-2" onclick="openTourModal('<?php echo $MLSNumber;?>')">
          <a href="#" class="btn btn-primary btn-lg btn-block">Sechedule a Tour</a>
                                    </span>
                                   
                                    </div>
            					</div>
        					</div>
        					
        				</div>
        			</div>
        		<!-- End Single Property -->
        		<?php
                }
                
                }else{
                ?>
                <div class="fleft w-100 mt-20 p-50 centered-text">No featured listings found.</div>
                <?php
                }
                ?>
                </div>
                
                <div class="row mt-30">
					<div class="col-lg-12 col-md-12 col-sm-12 text-center">
						<a href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-asc&pagination=get&page=1" class="btn shadow" style="background-color: #09AFFF; color: white;"><i class="ti-hand-point-right"></i> Show More Properties</a>
					</div>
				</div>
        	</div>
        	
        </div>
        </section>
		<!-- ============================ Properties End ================================== -->
		
		
			<!-- ============================ List Tag Start ================================== -->
			<section class="pt-50">
			<div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="eplios_tags">
							<div class="tags-1">01</div>
							<h2 class="xs-fs-20">Buying a SW Florida Home</h2>
							<p class="fs-18">Fabulous new homes come on the market every day in SW Florida and many are sold before they've even been advertised. 
                            If you're looking for real estate in this area, you can beat other home buyers to the hottest new homes on the market by following these steps:</p>
                            <a href="buy" class="btn exliou theme-bg mt-2 semibold shadow">Read More</a>
						</div>
					</div>
					
					<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
						<div class="text-center">
							<img src="assets/img/house-searching.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
						</div>
					</div>
					
				</div>
			</div>
			</section>
			<!-- ============================ Property Tag End ================================== -->
			
			<!-- ============================ List Tag Start ================================== -->
			<section class="pt-0">
			<div class="container">
			<div class="row align-items-center justify-content-between">
			
				<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 order-md-1 order-2">
					<div class="text-center">
						<img src="assets/img/balance-work-home-illustration-tiny.jpg" loading="lazy" class="img-fluid" alt="" style="max-height: 300px;" />
					</div>
				</div>
				
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
					<div class="eplios_tags right">
						<div class="tags-2">02</div>
						<h2 class="xs-fs-20">Free Home Evaluation For Home Sellers</h2>
						<p class="fs-18">
                        Request a free home evaluation, A well-priced home will generate competing offers and drive up the final sale value. Our free market analysis takes into account currently listed and sold 
                        comparable homes in your area and provides you with a detailed evaluation that puts it all in perspective.</p>
						<a href="sell" class="btn exliou theme-bg mt-2 semibold shadow">Read More</a>
					</div>
				</div>
				
			</div>
		   </div>
		  </section>
		 <!-- ============================ Property Tag End ================================== -->
			
		
		<!-- ============================ Smart Testimonials ================================== -->
		<section class="gray-simple">
			<div class="container">
			
				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-8">
						<div class="sec-heading center">
							<h2>Client Testimonials</h2>
							<p>See what other people say about us.</p>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="item-slide space">
							
							<!-- Single Item -->
							<div class="single_items">
								<div class="_testimonial_wrios">
									<div class="_testimonial_flex">
										<div class="_testimonial_flex_first">
											<div class="_tsl_flex_capst">
												<h5>Susan D. Murphy</h5>
												<div class="_ovr_posts"><span>Buyer</span></div>
												<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>5.0</div>
											</div>
										</div>
										<div class="_testimonial_flex_first_last">
											<div class="_tsl_flex_thumb">
												<img src="assets/img/c-1.png" class="img-fluid" alt="">
											</div>
										</div>
									</div>
									
									<div class="facts-detail">
										<p>Ben and Terry moved us up the property ladder by helping us buy a vacation home then sell it and later purchase a larger one. 
                                        They found us just the right neighborhood and even got us a great deal on a house full of furniture. All of this from 1500 miles away. 
                                        I can't imagine anyone doing it better than Ben and Terry do at Gulf Coast Associates.
                                        </p>
									</div>
								</div>
							</div>
							
							<!-- Single Item -->
							<div class="single_items">
								<div class="_testimonial_wrios">
									<div class="_testimonial_flex">
										<div class="_testimonial_flex_first">
											<div class="_tsl_flex_capst">
												<h5>Michael &amp; Lynn Kadow</h5>
												<div class="_ovr_posts"><span>Seller</span></div>
												<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>5.0</div>
											</div>
										</div>
										<div class="_testimonial_flex_first_last">
											<div class="_tsl_flex_thumb">
												<img src="assets/img/c-1.png"  loading="lazy"  class="img-fluid" alt="">
											</div>
										</div>
									</div>
									
									<div class="facts-detail">
										<p>We contacted Terry and Ben through their website in 2010. They effectively introduced us to the SW Florida lifestyle. Terry was wonderful to work with and went above and beyond to help us find the property with the specific attributes and environment we were searching for in our home. Their website provided the essential information we needed to pursue our dreams.</p>
									</div>
								</div>
							</div>
							
							<!-- Single Item -->
							<div class="single_items">
								<div class="_testimonial_wrios">
									<div class="_testimonial_flex">
										<div class="_testimonial_flex_first"> 
											<div class="_tsl_flex_capst">
												<h5>Gail Hunyar</h5>
												<div class="_ovr_posts"><span>Buyer</span></div>
												<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>5.0</div>
											</div>
										</div>
										<div class="_testimonial_flex_first_last">
											<div class="_tsl_flex_thumb">
												<img src="assets/img/c-1.png"  loading="lazy" class="img-fluid" alt="">
											</div>
										</div>
									</div>
									
									<div class="facts-detail">
										<p>Terry & Ben are great at what they do. I did work for them years ago when they first started Metro. Years of experience pay off. Of course, Terry doesn't "look" like she can have many years of experience. Fantastic, very experienced couple who will make sure you get the house of your dreams with the best possible loan.</p>
									</div>
								</div>
							</div>
							
							<!-- Single Item -->
							<div class="single_items">
								<div class="_testimonial_wrios">
									<div class="_testimonial_flex">
										<div class="_testimonial_flex_first">
											<div class="_tsl_flex_capst">
												<h5>Michelle Jones</h5>
												<div class="_ovr_posts"><span>Buyer</span></div>
												<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>5.0</div>
											</div>
										</div>
										<div class="_testimonial_flex_first_last">
											<div class="_tsl_flex_thumb">
												<img src="assets/img/c-1.png" class="img-fluid" alt="">
											</div>
										</div>
									</div>
									
									<div class="facts-detail">
										<p> Terry & Ben are simply AWESOME! Please call them when looking for a home in SW Florida. Fellow Canadians, don't go anywhere else but here. Thanks so much for your help. We are very excited to hang out in beautiful Southwest Florida.</p>
									</div>
								</div>
							</div>
							
							<!-- Single Item -->
							<div class="single_items">
								<div class="_testimonial_wrios">
									<div class="_testimonial_flex">
										<div class="_testimonial_flex_first">
											<div class="_tsl_flex_capst">
												<h5>Bob Lewis</h5>
												<div class="_ovr_posts"><span>Buyer</span></div>
												<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>5.0</div>
											</div>
										</div>
										<div class="_testimonial_flex_first_last">
											<div class="_tsl_flex_thumb">
												<img src="assets/img/c-1.png"  loading="lazy" class="img-fluid" alt="">
											</div>
										</div>
									</div>
									
									<div class="facts-detail">
										<p>Ben and Terry laid out a large number of condos for us to look at in different areas based on our requests. We found one building we really liked but needed to think about it. Within a week they identified a foreclosure in the building that was not on the market yet and we flew down that next weekend and bought it on the spot.</p>
									</div>
								</div>
							</div>
						
						</div>
					</div>
				</div>
				
			</div>
		</section>
        <ul class="fixed_streamed_search absolute shadow p-0" id="streamed_search"></ul>
		<!-- ============================ Smart Testimonials End ================================== -->
	 
		<?php include "call_to_action.php"?>
		
    <?php include_once 'footer.php';?> 
	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->
    
    <script type="text/javascript">
        
    $(function() {
     
     $(".list-img-slide img").one("load", function() {
        var MLSNumber = $(this).attr('id');
        var screen = $(window).width();
        
        if(screen>767){
            var height = $(this).height();   
        }else{
            var height = 240;
        }
        
        $("#list_view_flex_"+MLSNumber).attr("style","height: "+height+"px;").attr('class','list_view_flex relative');
     }).each(function() {
      if(this.complete) { 
          $(this).trigger('load'); // For jQuery >= 3.0 
      }
     });
     
    });

        
    $(document).ready(function() {
        
        $(".match-height").matchHeight();
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
    
    
        // Configure/customize these variables.
        var showChar = 200;  // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more...";
        var lesstext = "Show less";
        
    
        $('.inner_cont').each(function(){
            var content = $(this).html();
            
            if(content.length > showChar){
     
                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);
     
                var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
     
                $(this).html(html);
            }
     
        });
     
        $(".morelink").click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
    </script>
</body>
</html>


