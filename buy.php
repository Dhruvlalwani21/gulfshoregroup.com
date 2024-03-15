<?php
include 'connect.php';
$page = 'home';

$selMeta = "SELECT * FROM metas WHERE page='$page'";  
$metaRslts = mysqli_query($conn,$selMeta);
$row = mysqli_fetch_array($metaRslts);
$page_title = $row['title'];
$meta_description = $row['meta_description'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    
    <title>Buy Property | South Florida Real Estate</title>
	
    <?php include_once 'styles.php';?>
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
        
        <div class="page-title" style="background:#f4f4f4 url(assets/img/florida-3.jpg);" data-overlay="5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
							<h2 class="breadcrumb-title">Buying a Florida Home</h2>
						</div>
						
					</div>
				</div>
			</div>
		</div>
        
        <section>
			<div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="eplios_tags">
							<h2 class="w-100 xs-fs-20">Buying a Florida Home</h2>
                            <div class="w-100">
                            <div class="mb-15" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                            </div>
							<p class="fs-18 w-100">
                            Fabulous new homes come on the market every day in Florida and many are sold before they've even been advertised. If you're looking for real estate in this area, 
                            you can beat other home buyers to the hottest new homes on the market by following these steps:
                            </p>
						</div>
					</div>
				</div>
			</div>
		</section>
        
        
        <!-- ============================ List Tag Start ================================== -->
        <section class="pt-0">
        <div class="container">
        	<div class="row align-items-center justify-content-between">
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="eplios_tags">
        				<div class="tags-1">01</div>
        				<h2 class=" xs-fs-20">Search Homes Right Now.</h2>
        				<p class="fs-18">Use the search tool to browse the wide variety of single-family homes, duplexes and condominiums on the local real estate market.</p> 
                        <a class="btn btn-primary mt-20" href="mls-search">MLS Search</a>
        			</div>
        		</div>
        		
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
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
        
        	<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12order-md-1 order-2 xs-mt-20 sm-mt-20">
        		<div class="text-center">
        			<img src="assets/img/subscriber-concept-illustration.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">02</div>
        			<h2 class=" xs-fs-20">Sign up.</h2>
        			<p class="fs-18">Sign up for a search and let your dream home come to you. Members can also create saved searches, collect their favorites and sign up
                     for instant email alerts when new homes that fit their criteria come on the market.
                    </p>
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
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="eplios_tags">
        				<div class="tags-1">03</div>
        				<h2 class=" xs-fs-20">Learn About the Community.</h2>
        				<p class="fs-18">Learn About the Community and homes in the surrounding area before you invest. Refer to the Featured Areas section for community information.</p> 
        			</div>
        		</div>
        		
        		<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/happy-freelancer-with.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
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
        
        	<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12order-md-1 order-2 xs-mt-20 sm-mt-20">
        		<div class="text-center">
        			<img src="assets/img/financial-analysts-doing.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">04</div>
        			<h2 class=" xs-fs-20">Use the Mortgage Calculator.</h2>
        			<p class="fs-18">Use the mortgage calculator to figure out what your mortgage payments will be on the home you want.</p>
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
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="eplios_tags">
        				<div class="tags-1">05</div>
        				<h2 class=" xs-fs-20">Connect to a Professional.</h2>
        				<p class="fs-18"> Contact us anytime you need to know more about the area or any property that interests you. 
                        When you're ready to take the next step toward purchasing a home, we're here to help.</p> 
                        <a class="btn btn-primary mt-20" href="contact-us">Contact us</a>
        			</div>
        		</div>
        		
        		<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/woman-receiving-mail-reading.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
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
        
        	<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12order-md-1 order-2 xs-mt-20 sm-mt-20">
        		<div class="text-center">
        			<img src="assets/img/online-world-concept.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">06</div>
        			<h2 class=" xs-fs-20">Out-of-Country Purchases.</h2>
        			<p class="fs-18">We can help you buy property here, even if you're in another country.</p>
        		</div>
        	</div>
        	
        </div>
        </div>
        </section>
        <!-- ============================ Property Tag End ================================== -->
        
        
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    
    </div>
</body>
</html>