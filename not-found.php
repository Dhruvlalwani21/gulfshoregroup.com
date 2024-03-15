<?php
include 'connect.php';
$page = 'home';

$selMeta = "SELECT * FROM metas WHERE page='$page'"; 
$metaRslts = mysqli_query($conn,$selMeta);
$row = mysqli_fetch_array($metaRslts);
$page_title = $row['title'];
$meta_description = $row['meta_description'];
?>
<!DOCTYPE HTML>
<head>
    <base href="/" />
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>

	<title>Page Not Found | South Florida Real Estate</title>
    <link rel="icon" href="i/favicon.png" type="image/x-icon"><!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900" rel="stylesheet"/>
	
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
	
    <?php include_once 'styles.php';?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet" />
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
        
        <!-- Contact 2 -->
        
        <!-- ============================ User Dashboard ================================== -->
		<section class="error-wrap">
			<div class="container">
				<div class="row justify-content-center">
					
					<div class="col-lg-6 col-md-10">
						<div class="text-center">
							
							<img src="assets/img/404.png" class="img-fluid" alt="">
							<p>The page you are looking for does not exist.</p>
							<a class="btn btn-theme" href="/">Back To Home</a>
							
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!-- ============================ User Dashboard End ================================== -->
			

        <?php
        include 'footer.php';
        ?>
        
         
</div>
</body>