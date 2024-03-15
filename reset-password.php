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
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>

	<title>Reset Password</title>
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
        <section class="pt-105 pb-95 bg-grey" data-type="block">
        <div class="container">
        <div class="row centered-text">
        
        <div class="col-xm-12 col-sm-12 col-md-6 m-auto mb-100">
        
        <div class="p-30 shadow" style="background-color: white; border: 1px solid #EEEEEE;">
        
        <h3 class="w-100 centered-text mb-30 fs-30">Reset Your Password</h3>
        
        <form onsubmit="return false" autocomplete="off">
        <div class="w-100 mb-20" id="login_form">
          <div class="form-group relative has-icon-left mb-0">
            <input type="password" class="form-control form-control-lg input-lg" id="rp_password" placeholder="New password" autocomplete="off" required />
            <div class="form-control-position">
              <i class="fas fa-key"></i>
            </div>
          </div>
          <div class="form-group relative has-icon-left mb-0">
            <input type="password" class="form-control form-control-lg input-lg" id="cfrm_rp_password" placeholder="Confirm new password" autocomplete="off" style="border-bottom: 1px solid #ced4da!important;" required />
            <div class="form-control-position">
              <i class="fas fa-key"></i>
            </div>
          </div>
        </div>
        </form>
        <button type="submit" class="btn btn-primary btn-lg mt-20 no_radius btn-block fs-15" id="ResetButton" onclick="resetPassword()">Reset Password</button>
        
        <input type="hidden" name="account_email" id="account_email" value="<?php echo $email;?>" />
        <input type="hidden" name="token" id="token" value="<?php echo $token;?>" />
        
        </div>
        
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