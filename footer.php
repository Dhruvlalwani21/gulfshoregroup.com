
<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer style-2">
<div class="footer-middle">
<div class="container">
	<div class="row">
		
		<div class="col-lg-5 col-md-5">
			<div class="footer_widget">
				<img src="assets/img/mvp-realty-logo.png" style="height: 65px; width: auto;" class="img-footer small mb-2" alt="First1 south florida real estate" />
				<h4 class="extream mb-3">Sign up for newsletter</h4>
                <p>We'll never spam or sell your details. You unsubscribe whenever you'd like.</p>
				<div class="foot-news-last">
                    <form onsubmit="return false" autocomplete="off">
					<div class="input-group">
					  <input type="text" class="form-control" placeholder="Email Address" name="news_email" id="news_email" autocomplete="off" />
						<div class="input-group-append">
							<button type="button" class="input-group-text theme-bg b-0 text-light pointer" onclick="newsSubscription()">Subscribe</button>
						</div>
					</div>
                    </form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-7 ml-auto">
			<div class="row">
			
				<div class="col-lg-8 col-md-8">
					<div class="footer_widget">
						<h4 class="widget_title">Top Cities</h4>
						<ul class="footer-menu">
                            <?php
                            foreach ($cityData as $row){
                            $nav_city_name = $row['name'];
                            $nav_city_slug = $row['slug'];
                            ?>
                            <div class="col-lg-6 col-md-6 pl-0 dsply_inline_blck fleft">
							<li><a href="city/<?php echo $nav_city_slug;?>"><?php echo $nav_city_name;?></a></li>
                            </div>
                            <?php
                            }
                            ?>
						</ul>
					</div>
				</div> 
		
				<div class="col-lg-4 col-md-4">
					<div class="footer_widget">
						<h4 class="widget_title">Useful Links</h4>
						<ul class="footer-menu">
							<li class=""><a href="/">Home</a></li>
                    		<!--li><a href="buy">Buy</a></li>
                    		<li><a href="sell">Sell</a></li-->
                    		<li><a href="mls-search">MLS Search</a></li>
                    		<li><a href="about-us">About Us</a></li>
                    		<li><a href="contact-us">Contact Us</a></li>
                            <?php
                            if(!isset($_SESSION['user_id'])){
                            ?>
                    		<li>
                    			<a href="#" data-toggle="modal" data-target="#login">
                    				<i class="fas fa-sign-in-alt mr-1"></i><span class="dn-lg">Sign In</span>
                    			</a>
                    		</li>
                            <?php
                            }else{
                            ?>
                    		<li>
                    			<a href="logout.php">
                    				<i class="fas fa-sign-out-alt mr-1"></i><span class="dn-lg">Logout</span>
                    			</a>
                    		</li>
                            <?php   
                            }
                            ?>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
</div>

<div class="footer-bottom">
<div class="container">
	<div class="row align-items-center">
		<div class="col-lg-12 col-md-12 text-center">
			<p class="mb-0">&copy; Copyright <?php echo date("Y");?> First1.us All rights reserved.</p>
		</div>
	</div>
</div>
</div>
</footer>
<!-- ============================ Footer End ================================== -->

<!-- Log In Modal -->
<input type="hidden" name="advnc_sort_by" id="advnc_sort_by" value="price-asc" />
<?php include_once 'modals.php';?> 

<a id="back2Top" class="top-scroll" title="Back to top" href="javascript:;"><i class="ti-arrow-up"></i></a>



<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ion.rangeSlider.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/slick.js"></script>
<script src="assets/js/slider-bg.js"></script>
<script src="assets/js/lightbox.js"></script> 
<script src="assets/js/imagesloaded.js"></script>
<script src="assets/js/daterangepicker.js"></script>
<script src="assets/js/custom.js?v=<?php echo APPVERSION;?>"></script>
<script src="assets/js/notify.js"></script>
<script src="assets/js/match-height.js" type="text/javascript"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/picker.js" type="text/javascript"></script>
<script src="assets/js/picker.date.js" type="text/javascript"></script>
<script src="assets/js/picker.time.js" type="text/javascript"></script>
<script src="assets/js/moment-with-locales.min.js" type="text/javascript"></script>
<script src="assets/js/scripts.js?v=<?php echo APPVERSION;?>"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->