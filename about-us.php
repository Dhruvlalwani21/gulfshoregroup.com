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
    
    <title>About First1 | South Florida Real Estate</title>
	
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
        
        <div class="page-title" style="background:#f4f4f4 url(assets/img/florida-2.jpg);" data-overlay="5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
							<ol class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">About Us</li>
							</ol>
							<h2 class="breadcrumb-title">About Us - Who We Are?</h2>
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
							<h2 class="w-100 xs-fs-20">About MVP Realty</h2>
                            <div class="w-100">
                            <div class="mb-15" style="height: 5px; width: 120px; background-color: #09AFFF;"></div>
                            </div>
							<p class="fs-18 w-100">
                            With 700+ Realtors and over 20 branch real estate offices, MVP Realty proudly serves home buyers and sellers throughout all of Florida. 
                            Through our work in these renowned locales, we have earned a high-quality reputation as a dedicated real estate team with a proven track record 
                            of success and award-winning business practices.
                            Our service mentality is highlighted in our responsiveness, accessibility and attention to detail. When some agents were struggling,
                             we were thriving, and here are just a few highlights we are particularly proud of:
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
        				<h2 class=" xs-fs-20">KNOWLEDGE</h2>
        				<p class="fs-18">As a dedicated real estate agents, we are qualified to guide you in buying or selling a home. We believe in using our skills in finance,
                         contracts, negotiation and marketing to your best advantage.</p> 
        			</div>
        		</div>
        		
        		<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/real-estate-agency-property.png" class="img-fluid" alt="" style="max-height: 250px;" />
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
        
        	<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 order-md-1 order-2 xs-mt-20 sm-mt-20">
        		<div class="text-center">
        			<img src="assets/img/integrity.png" class="img-fluid" alt="" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">02</div>
        			<h2 class=" xs-fs-20">INTEGRITY</h2>
        			<p class="fs-18">Buying or selling a home is one of the most important transactions in the lives of many people. Because of that, it is important that 
                    you work with someone you trust and feel is a market expert with integrity. 
                    People trust our agents with their most-valuable asset. It's a responsibility we take very seriously. We know that your success is our success.
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
        				<h2 class=" xs-fs-20">LOCAL EXPERTISE</h2>
        				<p class="fs-18">We offer local market knowledge that's tailored to meet your needs. We know the neighborhoods, schools, market conditions, 
                        zoning regulations and the economy throughout each Florida city. We will do the leg work, keeping you up-to-date with new listings and conditions 
                        as they impact the market. We will make the process as pleasurable and stress-free an experience for you as possible.</p> 
        			</div>
        		</div>
        		
        		<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/experts-concept-illustration.jpg" class="img-fluid" alt="" />
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
        			<img src="assets/img/successful-businessman-celebrating-victory_1150-39772.jpg" class="img-fluid" alt="" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">04</div>
        			<h2 class=" xs-fs-20">SUCCESS</h2>
        			<p class="fs-18">We don't measure our success through awards received or achievements, but through the satisfaction of our clients. Whether you are
                     looking to buy or sell your home, we will provide sound and trustworthy advice to help you achieve your real estate goals.
                    </p>
        		</div>
        	</div>
        	
        </div>
        </div>
        </section>
        <!-- ============================ Property Tag End ================================== -->
        
        
        
        <section class="pt-0">
        <div class="container">
        <div class="row align-items-center justify-content-between">
        
        	<div class="col-12">
       		<p class="fs-18">Let us guide you through the complexities of buying or selling your home, eliminating hassles and stress. 
               We look forward to being a part of a new and exciting chapter in your life!
            </p>
            
            <a class="btn btn-primary mt-20" href="contact-us">Contact us</a>
        	</div>
        	
        </div>
        </div>
        </section>
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    
    </div>
</body>
</html>