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
    
    <title>Sell Property | South Florida Real Estate</title>
	
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
        
        <div class="page-title" style="background:#f4f4f4 url(assets/img/piotr-chrobot-6oUsyeYXgTg-unsplash.jpg);" data-overlay="5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
							<h2 class="breadcrumb-title">Start the selling process off right</h2>
						</div>
						
					</div>
				</div>
			</div>
		</div>
        
        
        <!-- ============================ List Tag Start ================================== -->
        <section>
        <div class="container">
        	<div class="row align-items-center justify-content-between">
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="eplios_tags">
        				<div class="tags-1">01</div>
        				<h2 class=" xs-fs-20">Request a Free Home Evaluation</h2>
        				<p class="fs-18"> A well-priced home will generate competing offers and drive up the final sale value. Our free market analysis takes into account currently 
                        listed and sold comparable homes in your area and provides you with a detailed evaluation that puts it all in perspective.</p> 
                        <a class="btn btn-primary mt-20" href="contact-us">Contact Us</a>
        			</div>
        		</div>
        		
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/balance-work-home-illustration-tiny.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
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
        			<img src="assets/img/house-sale-illustration.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
        		</div>
        	</div>
        	
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 order-1">
        		<div class="eplios_tags right">
        			<div class="tags-2">02</div>
        			<h2 class=" xs-fs-20">Size Up The Competition</h2>
        			<p class="fs-18">Use the search tools on this site to get an idea of the competition in your area.</p>
                    <a class="btn btn-primary mt-20" href="mls-search">MLS Search</a>
        		</div>
        	</div>
        	
        </div>
        </div>
        </section>
        <!-- ============================ Property Tag End ================================== -->
  
        
        
        <!-- ============================ List Tag Start ================================== -->
        <section class="xs-pt-0 sm-pt-0">
        <div class="container">
        	<div class="row align-items-center justify-content-between">
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="eplios_tags">
        				<div class="tags-1">03</div>
        				<h2 class=" xs-fs-20">Connect with a Professional</h2>
        				<p class="fs-18">When you're ready to take the next step toward selling your home; we're here to help. Our tried and true marketing plan will take the guesswork 
                        out of selling your home. We'll make sure your listing gets the best exposure and reaches the right buyer-whether they're out of state, in another country, 
                        or right around the corner.</p> 
                        <a class="btn btn-primary mt-20" href="contact-us">Contact Us</a>
        			</div>
        		</div>
        		
        		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        			<div class="text-center">
        				<img src="assets/img/woman-receiving-mail-reading.jpg" class="img-fluid" alt="" style="max-height: 300px;" />
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