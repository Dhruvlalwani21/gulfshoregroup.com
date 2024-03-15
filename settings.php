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
	<meta charset="utf-8" />
    <base href="/" />
	<meta name="author" content="Oluwapaso" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    
	<title>Settings | South Florida Real Estate</title> 
	
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
        
        <!-- Contact 2 -->
        <section class="pt-50 xs-pt-40 pb-95 bg-grey contact_2" data-type="block">
        <div class="container">
        <div class="row centered-text">
            <div class="col-lg-6 float_none m-auto text-left">
                <h2 class="bold mb-25 fs-35 xs-fs-25 text-left" data-type="text">Profile Info</h2>
                <div class="w-100 bg-white p-30 xs-pl-20 xs-pr-20 shadow" style="border: 1px solid #EFEFEF;">
                    <form method="post" id="contactForm" name="contactForm" onsubmit="return false">
                        <p id="error-msg"></p>
                        <div id="simple-msg"></div>
                        <div class="row text-left">
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="prfl_fname" class="text-muted form-label">Full Name*</label>
                                    <input name="prfl_fname" id="prfl_fname" type="text" class="form-control" value="<?php echo $fullname;?>" placeholder="Enter your full name*"/>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="prfl_email" class="text-muted form-label">Email*</label>
                                    <input name="prfl_email" id="prfl_email" type="email" class="form-control" value="<?php echo $logged_email;?>" placeholder="Enter your email*"/>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="prfl_phone" class="text-muted form-label">Phone</label>
                                    <input name="prfl_phone" id="prfl_phone" type="phone" class="form-control" value="<?php echo $phone_number;?>" placeholder="Enter your phone number"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="send" class="btn btn-contact no_radius action-2 fs-15 regular" id="updateProfile" onclick="updateMyProfile()"><i class="fas fa-upload"></i> Update Profile</button>
                            </div>
                            
                            <div class="col-md-12 mt-15">
                            <a href="javascript:;" onclick="$('#pills-forgotpwrod-tab').click(); $('#pills-login-tab').hide(); $('#pills-signup-tab').hide();" 
                            data-toggle="modal" data-target="#login">Want to reset your password?</a>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <!-- end row -->
        </div>
        <!-- end container -->
        </section>

        <?php
        include 'footer.php';
        ?>
        
        <script type="text/javascript">
        function updateMyProfile(){
            var user_id = '<?php echo $user_id;?>';
            var fullname = encodeURIComponent($("#prfl_fname").val().trim());
            var email = $("#prfl_email").val().trim();
            var phone = encodeURIComponent($("#prfl_phone").val().trim());
            
            if(validateEmail(email)){
            if(email!='' && fullname!='' && phone!=''){ 
            $('#updateProfile').attr('disabled',true);
            $('#updateProfile').html('Please wait...').addClass('disabled'); 
            email=encodeURIComponent(email);    
            var dataString = 'user_id='+user_id+'&fullname='+fullname+'&email='+email+'&phone='+phone;
            //alert(dataString)
            $.ajax({
            url: "update_profile.php",
            type: "POST",
            dataType: "json",
            data: dataString,
            timeout: 120000,
            error: function(xhr, status, error){
            $('#updateProfile').attr('disabled',false);
            $('#updateProfile').html('<i class="fas fa-upload"></i> &nbsp;Update Profile').removeClass('disabled');   
            $.notify({ icon: 'fas fa-exclamation-triangle', message: xhr.responseText},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } });
            },
            success: function(data){
            $('#updateProfile').attr('disabled',false);
            $('#updateProfile').html('<i class="fas fa-upload"></i> &nbsp;Update Profile').removeClass('disabled');    
            var dataData=data.data;
            if(dataData=='Done'){   
            $.notify({ icon: 'fas fa-check-circle', message: 'Profile successfully updated'},{ type: 'success', timer: 4000, placement: { from: "top", align: "center" } }); 
            }else{ 
             $.notify({ icon: 'fas fa-exclamation-triangle', message: dataData},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } }); 
            }
            
            }
            
            }); 
            
            }else{
            $.notify({ icon: 'fas fa-exclamation-triangle', message: 'All feilds are required.'},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } }); 
            }
            
            }else{
              $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Provide a valid email.'},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } });
            } 
        }

        </script>
</div>
</body>