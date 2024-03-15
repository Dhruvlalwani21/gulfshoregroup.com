<?php
$redirect_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
<div class="modal-dialog modal-xl login-pop-form" role="document">
<div class="modal-content overli" id="registermodal">
<div class="modal-body p-0">
<div class="resp_log_wrap">
<div class="resp_log_thumb" style="background:url(assets/img/florida-2.jpg)no-repeat;"></div>
<div class="resp_log_caption">
<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
<div class="edlio_152">
<ul class="nav nav-pills tabs_system center" id="pills-tab" role="tablist">
<li class="nav-item">
<a class="nav-link active" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
</li>
<li class="nav-item">
<a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false"><i class="fas fa-user-plus mr-2"></i>Register</a>
</li>
<li class="nav-item d-none">
<a class="nav-link" id="pills-forgotpwrod-tab" data-toggle="pill" href="#pills-forgotpwrod" role="tab" aria-controls="pills-forgotpwrod" aria-selected="false"><i class="fas fa-user-plus mr-2"></i>Register</a>
</li>
</ul>
</div>
<div class="tab-content" id="pills-tabContent">
<div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
<div class="login-form">
    <div class="form-group">
    	<div class="input-with-icon">
    		<input type="text" class="form-control" id="login_email" name="login_email" placeholder="Email" />
    		<i class="ti-email"></i>
    	</div>
    </div>
    
    <div class="form-group">
    	<div class="input-with-icon">
    		<input type="password" class="form-control" id="login_password" name="login_password" placeholder="Passwrod" />
    		<i class="ti-unlock"></i>
    	</div>
    </div>
    
    <div class="form-group">
    	<div class="eltio_ol9">
    		<!--div class="eltio_k1">
    			<input id="dd" class="checkbox-custom" name="dd" type="checkbox">
    			<label for="dd" class="checkbox-custom-label">Remember Me</label>
    		</div-->	
    		<div class="eltio_k2 nav-item">
    			<a href="javascript:;" onclick="$('#pills-forgotpwrod-tab').click();">Forgot Password?</a>
    		</div>	
    	</div>
    </div>
    
    <div class="form-group">
    	<button type="submit" class="btn btn-md full-width pop-login" id="LoginButton" onclick="login('<?php echo $redirect_url;?>')">
        <i class="fas fa-sign-in-alt mr-2 fs-17"></i> Login
        </button>
    </div>
</div>
</div>


<div class="tab-pane fade" id="pills-forgotpwrod" role="tabpanel" aria-labelledby="pills-forgotpwrod-tab">
<div class="login-form">
    <div class="form-group">
    	<div class="input-with-icon">
    		<input type="text" class="form-control" id="fp_email" name="fp_email" placeholder="Account Email" />
    		<i class="ti-email"></i>
    	</div>
    </div>
    
    <div class="form-group">
    	<button type="submit" class="btn btn-md full-width pop-login" id="forgotPwrdButton" onclick="requestForPassword('<?php echo $redirect_url;?>')">
        <i class="fas fa-sign-in-alt mr-2 fs-17"></i> Send Reset Link
        </button>
    </div>
</div>
</div>


<div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">
<div class="login-form">
	<div class="form-group">
		<div class="input-with-icon">
			<input type="text" class="form-control" placeholder="Full Name" id="su_fullname" />
			<i class="ti-user"></i>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-with-icon">
			<input type="email" class="form-control" placeholder="Email" id="su_email" />
			<i class="ti-email"></i>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-with-icon">
			<input type="text" class="form-control" placeholder="Phone Number" id="su_phone" />
			<i class="ti-mobile"></i>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-with-icon">
			<input type="password" class="form-control" placeholder="Password" id="su_password" />
			<i class="ti-unlock"></i>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-with-icon">
			<input type="password" class="form-control" placeholder="Confirm Password" id="cfrm_password" />
			<i class="ti-unlock"></i>
		</div>
	</div>
    
	<div class="form-group">
		<div class="eltio_ol9">
			<div class="eltio_k1">
				<label for="dds" class="checkbox-custom-label fs-12">By signing up, you accept the <a href="avascript:;" style="color: #009FEC;">terms and conditions</a></label>
			</div>	
		</div>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-md full-width pop-login" id="RegisterButton" onclick="register('<?php echo $redirect_url;?>')">
        <i class="fas fa-user-plus mr-2 fs-17"></i> Register
        </button>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>







<!-- Get Info -->
<!-- Get Info -->
<div class="modal fade text-left" id="GetInfo" tabindex="-1" role="dialog" aria-labelledby="GetInfo" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="GetInfo"><i class="ti-info-alt fs-18 pr-5"></i> Get Property Information</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body xs-pl-15 xs-pr-15">

<div class="w-100 p-6 xs-p-0"> 
<?php 
if($fullname){
    $nameOut = $fullname;
}else{
    $nameOut = '';
}
?>
<div class="form-group fleft w-100">
<input class="form-control p-25 no_radius" placeholder="Full Name" name="info_name" id="info_name" maxlength="100" value="<?php echo $nameOut;?>" />
</div>
<div class="form-group fleft w-100">
<input class="form-control p-25 no_radius" placeholder="Email" name="info_email" id="info_email" maxlength="100" value="<?php echo $logged_email?>" />
</div>
<div class="form-group fleft w-100">
<input class="form-control p-25 no_radius" placeholder="Phone Number" name="info_phone" id="info_phone" maxlength="100" value="<?php echo $phone_number;?>" />
</div>
<div class="form-group fleft w-100">
<textarea class="form-control p-25 no_radius" name="info_message" id="info_message" placeholder="Your message here..." style="resize: none!important; height: 150px!important; overflow: auto!important;"></textarea>
</div>
<div class="form-group fleft w-100">
<input type="hidden" name="info_mls_number" id="info_mls_number" value="" />
            
<button class="btn btn-primary no_radius fright" id="InfoButton" onclick="getPropertyInfo()"><i class="fas fa-envelope"></i> &nbsp;Get Info</button>
</div>

</div>
</div>
</div>
</div>
</div> 
<!-- Get Info -->
<!-- Get Info -->





<!-- Schedule A Tour -->
<!-- Schedule A Tour -->
<div class="modal fade text-left" id="TourModal" tabindex="-1" role="dialog" aria-labelledby="TourModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="TourModal"><i class="ti-alarm-clock fs-18 pr-5"></i> Schedule A Tour</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body xs-pl-15 xs-pr-15">

<div class="w-100 p-15 xs-p-5"> 

<div class="form-group fleft w-100">
<label id="form_lbl">Full Name</label>
<input class="form-control no_radius" placeholder="Full Name" name="tour_name" id="tour_name" maxlength="100" value="<?php echo $fullname;?>" />
</div>
<div class="form-group fleft w-100">
<label id="form_lbl">Email</label>
<input class="form-control no_radius" placeholder="Email" name="tour_email" id="tour_email" maxlength="100" value="<?php echo $logged_email;?>" />
</div>
<div class="form-group fleft w-100">
<label id="form_lbl">Phone Number</label>
<input class="form-control no_radius" placeholder="Phone Number" name="tour_phone" id="tour_phone" maxlength="100" value="<?php echo $phone_number;?>" />
</div>
<div class="form-group fleft w-100 relative">
<label id="form_lbl">Move In Date</label>
<select class="form-control no_radius" id="move_in_date" name="move_in_date" style="height: 50px;">
<option value="ASAP">ASAP</option>
<option value="In 1 Month">In 1 Month</option>
<option value="Within 3 Months">Within 3 Months</option>
<option value="Within 6 Months">Within 6 Months</option>
</select>
</div>

<div class="row">
<div class="col-md-6 dsply_inline_blck">
<div class="form-group fleft w-100 relative">
<label id="form_lbl">Tour Date</label>
<input class="form-control p-25 no_radius" placeholder="Tour Date" name="tour_date" id="tour_date" maxlength="100" />
</div>
</div>

<div class="col-md-6 dsply_inline_blck">
<div class="form-group fleft w-100">
<label id="form_lbl">Tour Time</label>
<input class="form-control p-25 no_radius" placeholder="Tour Time" name="tour_time" id="tour_time" maxlength="100" />
</div>
</div>
</div>

<div class="form-group fleft w-100">
<input type="hidden" name="tour_mls_number" id="tour_mls_number" value="" />
<button class="btn btn-primary no_radius fright" id="TourButton" onclick="scheduleATour()"><i class="fas fa-clock"></i> &nbsp;Schedule Tour</button>
</div>

</div>
</div>
</div>
</div>
</div> 
<!-- Schedule A Tour -->
<!-- Schedule A Tour -->






<!-- MLS Communities -->
<!-- MLS Communities -->
<div class="modal fade text-left" id="MLS_Communities" tabindex="-1" role="dialog" aria-labelledby="MLS_Communities" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1000px!important;">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="MLS_Communities"><i class="fas fa-city fs-18 pr-5"></i> Select Communities</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

<div class="w-100"> 

<div class="modal_comm_list w-100 fleft mb-20" id="city_list">
<div id="ctop"> [ <a href="javascript:;" onclick="scrollToModalDiv('abc_cont','100')">ABC</a> ] [ <a href="javascript:;" onclick="scrollToModalDiv('def_cont','100')">DEF</a> ] 
[ <a href="javascript:;" onclick="scrollToModalDiv('ghi_cont','100')">GHI</a> ] [ <a href="javascript:;" onclick="scrollToModalDiv('jkl_cont','100')">JKL</a> ] 
[ <a href="javascript:;" onclick="scrollToModalDiv('mno_cont','100')">MNO</a> ] [ <a href="javascript:;" onclick="scrollToModalDiv('pqr_cont','100')">PQR</a> ] 
[ <a href="javascript:;" onclick="scrollToModalDiv('stu_cont','100')">STU</a> ] [ <a href="javascript:;" onclick="scrollToModalDiv('vwx_cont','100')">VWX</a> ] 
[ <a href="javascript:;" onclick="scrollToModalDiv('yz_cont','100')">YZ</a> ] [ <a href="javascript:;" onclick="scrollToModalDiv('numchar_cont','100')">0-9</a> ]</div>

<div class="letterCont fleft w-100" style="display: none;" id="abc_cont">
<div class="cLetters"><span>ABC</span></div>
<div class="w-100" id="streamed_abc"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="def_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>DEF</span></div>
<div class="w-100" id="streamed_def"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="ghi_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>GHI</span></div>
<div class="w-100" id="streamed_ghi"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="jkl_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>JKL</span></div>
<div class="w-100" id="streamed_jkl"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="mno_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>MNO</span></div>
<div class="w-100" id="streamed_mno"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="pqr_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>PQR</span></div>
<div class="w-100" id="streamed_pqr"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="stu_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>STU</span></div>
<div class="w-100" id="streamed_stu"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="vwx_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>VWX</span></div>
<div class="w-100" id="streamed_vwx"></div>
</div>

<div class="letterCont fleft w-100" style="display: none;" id="yz_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>YZ</span></div>
<div class="w-100" id="streamed_yz"></div>
</div>
        
<div class="letterCont fleft w-100" style="display: none;" id="numchar_cont">
<a class="ctoplnk" href="javascript:;" onclick="scrollToModalDiv('ctop','100')">Top</a>
<div class="cLetters"><span>0-9</span></div>
<div class="w-100" id="streamed_numchar"></div>
</div>

</div>
            
</div>

</div>
</div>
</div>
</div> 
<!-- MLS Communities -->
<!-- MLS Communities -->


<!-- share property -->
<!-- share property -->
<div class="modal fade text-left" id="shareProperty" tabindex="-1" role="dialog" aria-labelledby="shareProperty" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="shareProperty"><i class="fas fa-envelope fs-18 pr-5"></i> Share property</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

<div class="w-100"> 

<div class="form-group fleft w-100">
<label class="w-100 semibold">Your Email</label>
<input class="form-control p-25 no_radius" placeholder="Your Email" name="share_from_email" id="share_from_email" maxlength="100" value="<?php echo $logged_email;?>" />
</div>

<div class="form-group fleft w-100">
<label class="w-100 semibold">Recipient's email</label>
<input class="form-control p-25 no_radius" placeholder="Recipient's email" name="share_to_email" id="share_to_email" maxlength="100" value="" />
<small class="w-100">Separate multiple addresses with a comma.</small>
</div>

<div class="form-group fleft w-100">
<label class="w-100 semibold">Include message (optional)</label>
<textarea class="form-control p-25 no_radius" name="share_to_message" id="share_to_message" placeholder="Your message here..." style="resize: none!important; height: 150px!important; overflow: auto!important;">Check out this home I found on First1.us.</textarea>
</div>
<div class="form-group fleft w-100">
<input type="hidden" name="share_mls_number" id="share_mls_number" value="<?php echo $MLSNumber;?>" />
            
<button class="btn btn-primary no_radius fright" id="ShareButton" onclick="shareProperty()"><i class="fas fa-envelope"></i> &nbsp;Share</button>
</div>

</div>
</div>
</div>
</div>
</div> 
<!-- share property -->
<!-- share property -->

<!-- Send Homes -->
<!-- Send Homes -->
<div class="modal fade text-left" id="sendMeHomes" tabindex="-1" role="dialog" aria-labelledby="sendMeHomes" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="sendMeHomes"><i class="fas fa-envelope fs-18 pr-5"></i> Subscribe To Property Alert</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

<div class="w-100 p-15 xs-p-5"> 

<div class="form-group fleft w-100">
<label class="w-100 semibold">Your Email</label>
<input class="form-control p-25 no_radius" placeholder="Your Email" name="subscribe_email" id="subscribe_email" maxlength="100" value="<?php echo $logged_email;?>" />
</div>

<div class="form-group fleft w-100">
<input type="hidden" name="subscribe_listing_class" id="subscribe_listing_class" value="<?php echo $PropertyClass;?>" />
            
<button class="btn btn-primary no_radius fright" id="SubButton" onclick="sendMeHomes()"><i class="fas fa-envelope"></i> &nbsp;Subscribe</button>
</div>

</div>
</div>
</div>
</div>
</div> 
<!-- Send Homes -->
<!-- Send Homes -->

<!-- Property Social -->
<!-- Property Social -->
<div class="modal fade text-left" id="socialModal" tabindex="-1" role="dialog" aria-labelledby="socialModal" aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title fs-18" id="socialModal"><i class="fas fa-share-alt fs-18 pr-5"></i> Share property</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

<div class="w-100 fleft">

<div class="fleft dsply_inline_blck col-md-3 centered-text pointer" onclick="shareOnFacebook()">
<div class="w-100 fleft centered-text">
<div id="shareBtn" class="float_none m-auto centered-text" style="background-color: #007CB9;"><i class="fab fa-facebook fs-25 color-white"></i></div>
</div>
<div class="w-100 fleft centered-text fs-16">
Facebook
</div>
</div>

<div class="fleft dsply_inline_blck col-md-3 centered-text pointer" onclick="shareOnTwitter()">
<div class="w-100 fleft centered-text">
<div id="shareBtn" class="float_none m-auto centered-text" style="background-color: #04ADFF;"><i class="fab fa-twitter fs-25 color-white"></i></div>
</div>
<div class="w-100 fleft centered-text fs-16">
Twitter
</div>
</div>


<div class="fleft dsply_inline_blck col-md-3 centered-text pointer">
<a href="https://api.whatsapp.com/send/?phone&text=Check out this home I found on First1.us <?php echo $redirect_url;?>&app_absent=0" target="_blank">
<div class="w-100 fleft centered-text">
<div id="shareBtn" class="float_none m-auto centered-text" style="background-color: #00CE00;"><i class="fab fa-whatsapp fs-25 color-white"></i></div>
</div>
<div class="w-100 fleft centered-text fs-16">
Whatsapp
</div>
</a>
</div>

<div class="fleft dsply_inline_blck col-md-3 centered-text pointer" onclick="copyToClipboard('#hidden_link')">
<div id="hidden_link" style="height: 0px; width: 0px; max-width: 0px!important; opacity: 0;"><?php echo $redirect_url;?></div>
<div class="w-100 fleft centered-text">
<div id="shareBtn" class="float_none m-auto centered-text" style="background-color: #FF8C1A;"><i class="fas fa-link fs-25 color-white"></i></div>
</div>
<div class="w-100 fleft centered-text fs-16">
Copy Link
</div>
</div>

</div>

</div>
</div>
</div>
</div> 
<!-- Property Social -->
<!-- Property Social -->


