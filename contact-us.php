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
    
    <title>Contact us | MVP Realty</title>
	
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
        
        <section class="pt-105 xs-pt-15 xs-pb-15 pb-95 bg-light contact_2" data-type="block">
        <div class="container xs-p-10">
        <div class="row bg-white shadow p-50 xs-p-15" style="border: 1px solid #EAEAEA;">
            <div class="col-lg-6">
                <h2 class="bold mb-25 fs-35 xs-fs-25 xs-mb-10 text-left" data-type="text">Get in Touch</h2>
                <p class="text-muted mb-40 text-left" data-type="rich_text">
                Email us with any question or inquiries or call (239) 992-9119. We would be happy to answer your questions.
                </p>
        
                <div>
                    <form method="post" id="contactForm" name="contactForm" onsubmit="return false">
                        <p id="error-msg"></p>
                        <div id="simple-msg"></div>
                        <div class="row text-left">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="msg_name" class="text-muted form-label" data-type="label">Name*</label>
                                    <input name="msg_name" id="msg_name" type="text" class="form-control" placeholder="Enter name*" data-type="input"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="msg_email" class="text-muted form-label" data-type="label">Email*</label>
                                    <input name="msg_email" id="msg_email" type="email" class="form-control" placeholder="Enter email*" data-type="input"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="msg_phone" class="text-muted form-label" data-type="label">Phone</label>
                                    <input name="msg_phone" id="msg_phone" type="phone" class="form-control" placeholder="Enter phone number" data-type="input"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="msg_subject" class="text-muted form-label" data-type="label">Subject</label>
                                    <input type="text" class="form-control" id="msg_subject" name="msg_subject" placeholder="Enter Subject.." data-type="input"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-4 pb-2">
                                    <label for="message" class="text-muted form-label" data-type="label">Message*</label>
                                    <textarea name="message" id="message" rows="4" class="form-control textarea" placeholder="Enter your message here...*" data-type="input"></textarea>
                                </div>
        
                                <button type="submit" name="send" class="btn btn-contact action-2 fs-15 regular" id="sendMessageX" data-type="button" onclick="sendMessage()"><i class="fas fa-envelope"></i> Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
        
            </div>
            <!-- end col -->
        
            <div class="col-lg-5 xs-mt-30 ml-auto">
                <div class="mt-5 mt-lg-0 text-left">
                    <div class="fleft w-100 mb-30">
                    <div class="fleft w-100 centered-text">
                    <img src="assets/img/contact.png" onerror="this.src='https://via.placeholder.com/550';" class="img-fluid float_none d" data-type="image" />
                    </div>
                    </div>
                    <p class="text-muted mt-40 mb-30"><i class="fas fa-envelope mr-5"></i> <a href="mailto:office@first1.us" data-type="link">office@first1.us</a></p>
                    <p class="text-muted mb-30"><i class="fas fa-phone mr-5"></i> <a href="tel:(239) 992-9119" data-type="link">(239) 992-9119</a></p>
                    <p class="text-muted mb-30"><i class="fas fa-map-marker mr-5"></i> <span data-type="text"><?php echo WEBADDRESS;?></span></p>
                    <ul class="list-inline pt-10 text-left">
                        <li class="list-inline-item mr-10">
                            <a href="" class="social-icon rounded-circle" data-type="link">
                            <i class="fab fa-facebook fs-20" data-type="icon"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-10">
                            <a href="" class="social-icon rounded-circle" data-type="link">
                            <i class="fab fa-twitter fs-20" data-type="icon"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="" class="social-icon rounded-circle" data-type="link">
                            <i class="fab fa-instagram fs-20" data-type="icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        </div>
        <!-- end container -->
        </section>
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    
    
    <script type="text/javascript">
    function sendMessage(){
        var msg_name=encodeURIComponent($('#msg_name').val().trim());
        var msg_email=$('#msg_email').val().trim(); 
        var msg_phone=encodeURIComponent($('#msg_phone').val().trim()); 
        var msg_subject=encodeURIComponent($('#msg_subject').val().trim()); 
        var message=encodeURIComponent($('#message').val().trim());  
                                            
        if(validateEmail(msg_email)){
        msg_email=encodeURIComponent(msg_email);    
        
        if((msg_name!='') && (message!='')){
            
        document.getElementById("sendMessageX").setAttribute('disabled',true);
        $("#sendMessageX").html("Sending... Please wait");  
             
        var dataString ='name='+msg_name+'&email='+msg_email+'&message='+message+'&phone='+msg_phone+'&subject='+msg_subject; 
        //alert(dataString);
        //return false;
        $.ajax({
        url: "send_contact_msg.php",
        type: "POST",
        dataType: "json",
        data: dataString,
        timeout: 120000,
        error: function(xhr, status, error){
        document.getElementById("sendMessageX").removeAttribute('disabled');
        $("#sendMessageX").html('<i class="fas fa-envelope"></i> &nbsp;Send Message');      
        $.notify({ icon: 'fas fa-exclamation-triangle', message: error },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" }  });
        },
        success: function(data){ 
        document.getElementById("sendMessageX").removeAttribute('disabled');
        $("#sendMessageX").html('<i class="fas fa-envelope"></i> &nbsp;Send Message');        
        var dataData=data.data;      
        if(dataData=='Done'){  
        $.notify({ icon: 'fas fa-check', message: 'Message successfully sent. One of our top agents will respond to you shortly' },{ type: 'success', timer: 4000, placement: { from: "top", align: "center" } }); 
        $('#message').val('');
        }else{        
        $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Unable to send message. '+dataData },{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } });    
        } 
        } 
        });     
        }else{
         $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Fields marked with asterisk are required.'},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } }); 
        }
             
        }else{
         $.notify({ icon: 'fas fa-exclamation-triangle', message: 'Provide a valid email address.'},{ type: 'danger', timer: 4000, placement: { from: "top", align: "center" } }); 
        } 
    }
    </script>   
    </div>
</body>
</html>