<?php
include 'connect.php'; 
if(isset($_GET['email']) && $_GET['email']!='' && isset($_GET['token']) && $_GET['token']!=''){
$email = $_GET['email'];
$token = $_GET['token'];

$page = 'home';

$selMeta = "SELECT * FROM metas WHERE page='$page'";  
$metaRslts = mysqli_query($conn,$selMeta);
$row = mysqli_fetch_array($metaRslts);
$page_title = $row['title'];
$meta_description = $row['meta_description'];
?>
<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Oluwapaso" />
	<meta name="description" content="<?php echo $meta_description;?>"/>

	<title><?php echo $page_title;?></title>
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
        <section class="pt-105 pb-95 bg-light" data-type="block">
        <div class="container">
        <div class="row centered-text fs-18" style="color: #EC7600;">
        
        <div class="col-xm-12 col-sm-12 col-md-8 m-auto mb-100">
        <?php
        $getToken="SELECT token FROM reg_tokens WHERE email='".$email."' AND token='$token'";
        $tokRslt=mysqli_query($conn,$getToken) or die(mysqli_error());
        $tokenExist=mysqli_num_rows($tokRslt);
        if($tokenExist>0){
         
        $upUser="UPDATE users SET status='Active' WHERE email='$email'";
        $upUserRslt=mysqli_query($conn,$upUser) or die(mysqli_error($conn));
        
        if($upUserRslt){
        $delToken="DELETE FROM reg_tokens WHERE email='".$email."'"; //del previous tokens
        $delRslt=mysqli_query($conn,$delToken) or die(mysqli_error($conn));
        ?>
        <div class="mt-6 mb-6 centered-text">
        <div class="centered-text w-100 fleft mb-20"><img class="float_none" style="width: 100px; height: auto;" src="assets/img/accepted.png" /></div>
        Verification was successful. You can now <a href="javascript:;" href="#" data-toggle="modal" data-target="#login" style="color: #09AFFF;">Login</a> and enjoy full website features.
        </div>
        <?php
        }else{
        ?>
        <div class="mt-6 mb-6 centered-text">
        <div class="centered-text w-100 fleft mb-20"><img class="float_none" style="width: 100px; height: auto;" src="assets/img/error.png" /></div>
        Unable to complete verification. #Execution Error.
        </div>
        <?php
        }
        
        }else{
        ?>
        <div class="mt-6 mb-6 centered-text">
        <div class="centered-text w-100 fleft mb-20"><img class="float_none" style="width: 100px; height: auto;" src="assets/img/error.png" /></div>
        Unable to complete verification. #Invalid Token.
        </div>
        <?php
        }
        ?>
        </div>
        </div>
        
        </div>
        </section>

        <?php
        include 'footer.php';
        
        }else{
            echo 'Fatal error';
        }
        ?>
</div>
</body>