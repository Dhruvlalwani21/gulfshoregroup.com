<?php
include 'connect.php';
$page = 'home';
error_reporting(E_ALL);
ini_set('display_errors', 0);
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
    
    <title>MLS Search | MVP Realty</title>
	
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
        
        <section class="pt-50 xs-pt-40 pb-95 bg-light" data-type="block">
        <div class="container">
        <div class="row bg-white col-md-10 float_none m-auto shadow p-20 pt-40 pb-40 xs-pt-20 xs-pl-5 xs-pr-5" style="border: 1px solid #EAEAEA;">
            <div class="col-md-12 fleft fs-25"><h2 class="bold w-100 mb-25 xs-fs-20 xs-mb-10 text-left" data-type="text">Advanced MLS Search</h2></div>
            
            <div class="fleft w-100">
            <div class="col-md-12 fleft">
            <form autocomplete="off">
            <div class="form-group relative">
                <label id="form_lbl">Quick search</label>
            	<div class="input-with-icon">
            		<input type="text" class="form-control no_radius" onkeyup="quickSearch(this.value)" id="advnc_state_or_city" name="advnc_state_or_city" placeholder="Enter a Community Name, Development, Street, Address or Zip Code" autocomplete="off" />
            		<i class="ti-location-pin"></i>
                    <img src="assets/img/loader.gif" class="quick_srch_img" />
            	</div>
                <ul class="w100 absolute shadow p-0" id="streamed_search"></ul>
            </div>
            </form>
            </div>
            </div>
            
            
            
            
            
            <div class="fleft w-100 mt-15">
            
            <div class="fleft col-12 mb-5">
            <div class="w-100 fs-13" style="border-bottom: 2px dashed #009CE8; color: #009CE8;"><b>SEARCH CRITERIA:</b></div>
            </div>
            
            <div class="col-lg-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Property type</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_property_type" name="advnc_property_type">
                    <option value="" selected="selected">Select Property Type</option>
                    <option value="Homes">Homes</option>
                    <option value="Condos">Condos</option>
                    <option value="Land">Vacant Land</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Multi-Family">Multi-Family</option>
                    <option value="Town Homes">Town Homes</option>
                    <option value="Dock">Boat Dock</option>
                    </select>
            		<i class="ti-list-ol"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">City</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_city" name="advnc_city" onchange="reloadComm(this.value)">
                    <option value="" selected="selected">Select City</option>
                    <option value="Marco Island">Marco Island</option>
                    <option value="Naples">Naples</option>
                    <option value="Ave Maria">Ave Maria</option>
                    <option value="Immokalee">Immokalee</option>
                    <option value="Bonita Springs">Bonita Springs</option>
                    <option value="Estero">Estero</option>
                    <option value="Fort Myers">Fort Myers</option>
                    <option value="Cape Coral">Cape Coral</option>
                    <option value="Lehigh Acres">Lehigh Acres</option>
                    </select>
            		<i class="fas fa-city"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-1 fleft centered-text dsply_inline_blck xs-pl-0">
            <div class="form-group mt-10">
                <label id="form_lbl">.</label>
                <label id="form_lbl" class="mt-10 w-100">-OR-</label>
            </div>
            </div>
            
            <div class="col-lg-3 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Zip code</label>
            	<div class="input-with-icon">
            		<input type="text" class="form-control no_radius" id="advnc_zipcode" name="advnc_zipcode" placeholder="e.g. 34109,34110" autocomplete="off" />
            		<i class="ti-map-alt"></i>
            	</div>
            </div>
            </div>
            </div>
            
            <div class="fleft w-100">
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="just_listed" class="checkbox-custom" name="just_listed" type="checkbox" />
				<label for="just_listed" class="checkbox-custom-label">Just Listed</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="include_sold" class="checkbox-custom" name="include_sold" type="checkbox" />
				<label for="include_sold" class="checkbox-custom-label">Include Sold</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="foreclosure" class="checkbox-custom" name="foreclosure" type="checkbox" />
				<label for="foreclosure" class="checkbox-custom-label">Foreclosure</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="short_sale" class="checkbox-custom" name="short_sale" type="checkbox" />
				<label for="short_sale" class="checkbox-custom-label">Short Sale</label>
            </div>
            </div>
            
            </div>
            
            
            
            
            <div class="fleft w-100 mt-15">
            
            <div class="fleft col-12 mb-5">
            <div class="w-100 fs-13" style="border-bottom: 2px dashed #009CE8; color: #009CE8;"><b>ADVANCED SEARCH:</b></div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Min Price</label>
          	    <div class="input-with-icon">
            		<input type="number" class="form-control no_radius" id="advnc_min_price" name="advnc_min_price" placeholder="Minimum price" autocomplete="off" />
            		<i class="fas fa-dollar-sign"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Max Price</label>
          	    <div class="input-with-icon">
            		<input type="number" class="form-control no_radius" id="advnc_max_price" name="advnc_max_price" placeholder="Maximum price" autocomplete="off" />
            		<i class="fas fa-dollar-sign"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Beds</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_beds" name="advnc_beds">
                    <option value="Any" selected="">Any # of beds</option>
                    <option value="1">1 Bed</option>
                    <option value="1+">1+ Beds</option>
                    <option value="2+">2+ Beds</option>
                    <option value="3+">3+ Beds</option>
                    <option value="4+">4+ Beds</option>
                    <option value="5+">5+ Beds</option>
                    <option value="6+">6+ Beds</option>
                    <option value="7+">7+ Beds</option>
                    <option value="8+">8+ Beds</option>
                    <option value="9+">9+ Beds</option>
                    <option value="10+">10+ Beds</option>
                    </select>
            		<i class="fas fa-bed"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Baths</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_baths" name="advnc_baths">
                    <option value="Any" selected="">Any # of baths</option>
                    <option value="1">1 Bath</option>
                    <option value="1+">1+ Baths</option>
                    <option value="2+">2+ Baths</option>
                    <option value="3+">3+ Baths</option>
                    <option value="4+">4+ Baths</option>
                    <option value="5+">5+ Baths</option>
                    <option value="6+">6+ Baths</option>
                    <option value="7+">7+ Baths</option>
                    <option value="8+">8+ Baths</option>
                    <option value="9+">9+ Baths</option>
                    <option value="10+">10+ Baths</option>
                    </select>
            		<i class="fas fa-bath"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Min Living Area Sq.Ft</label>
          	    <div class="input-with-icon">
            		<input type="number" class="form-control no_radius" id="advnc_min_sq_ft" name="advnc_min_sq_ft" placeholder="Minimum Sq.Ft" autocomplete="off" />
            		<i class="fas fa-ruler-combined"></i>
            	</div>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Max Living Area Sq.Ft</label>
          	    <div class="input-with-icon">
            		<input type="number" class="form-control no_radius" id="advnc_max_sq_ft" name="advnc_max_sq_ft" placeholder="Minimum Sq.Ft" autocomplete="off" />
            		<i class="fas fa-ruler-combined"></i>
            	</div>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Year Built</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_min_year" name="advnc_min_year">
                    <option value="Any" selected="">Any year</option>
                    <option value="1990">1990 + </option>
                    <option value="2000">2000 + </option>
                    <option value="2005">2005 + </option>
                    <option value="2010">2010 + </option>
                    <option value="2015">2015 + </option>
                    <option value="2016">2016 + </option>
                    <option value="2017">2017 + </option>
                    <option value="2018">2018 + </option>
                    <option value="2019">2019 + </option>
                    <option value="2020">2020 + </option>
                    <option value="2021">2021 + </option>
                    </select>
            		<i class="fas fa-calendar-alt"></i>
            	</div>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-6 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <label id="form_lbl">Garage Spaces</label>
            	<div class="input-with-icon">
            		<select class="form-control no_radius" id="advnc_no_garage" name="advnc_no_garage">
                    <option value="Any" selected="">Any # of garage</option>
                    <option value="1">1</option>
                    <option value="1+">1+</option>
                    <option value="2+">2+</option>
                    <option value="3+">3+</option>
                    <option value="4+">4+</option>
                    <option value="5+">5+</option>
                    <option value="6+">6+</option>
                    <option value="7+">7+</option>
                    <option value="8+">8+</option>
                    <option value="9+">9+</option>
                    <option value="10+">10+</option>
                    </select>
            		<i class="fas fa-car"></i>
            	</div>
            </div>
            </div>
            
            </div>
            
            
            <div class="fleft w-100">
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="pool" class="checkbox-custom" name="pool" type="checkbox" />
				<label for="pool" class="checkbox-custom-label">Pool</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="spa" class="checkbox-custom" name="spa" type="checkbox" />
				<label for="spa" class="checkbox-custom-label">Spa</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="guest_house" class="checkbox-custom" name="guest_house" type="checkbox" />
				<label for="guest_house" class="checkbox-custom-label">Guest House</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck">
            <div class="form-group mt-10">
                <input id="gated" class="checkbox-custom" name="gated" type="checkbox" />
				<label for="gated" class="checkbox-custom-label">Gated Community</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck xs-pl-15 sm-pl-15">
            <div class="form-group mt-10">
                <input id="waterfront" class="checkbox-custom" name="waterfront" type="checkbox" />
				<label for="waterfront" class="checkbox-custom-label">Waterfront</label>
            </div>
            </div>
             
            <div class="col-lg-3 col-md-4 fleft dsply_inline_blck xs-pl-15 sm-pl-15">
            <div class="form-group mt-10">
                <input id="gulf_access" class="checkbox-custom" name="gulf_access" type="checkbox" />
				<label for="gulf_access" class="checkbox-custom-label">Gulf Access</label>
            </div>
            </div>
                
            </div>
            
            <div class="fleft w-100 mt-15">
            
            <div class="fleft col-12 mb-5">
            <div class="w-100 fs-13 pointer" id="toggle_cities" onclick="toggle_cities()" style="border-bottom: 2px dashed #009CE8; color: #009CE8;"><b><i class="fas fa-chevron-right"></i> CLICK HERE TO SELECT COMMUNITIES:</b></div>
            </div>
            
            <div class="mls_city_cont col-md-12 fleft dsply_inline_blck" style="display: none;" id="cities_cont">
            <div class="w-100 fleft mt-15" id="city_list">
            <div id="ctop"> [ <a href="javascript:;" onclick="scrollToDiv('abc_cont','100')">ABC</a> ] [ <a href="javascript:;" onclick="scrollToDiv('def_cont','100')">DEF</a> ] 
            [ <a href="javascript:;" onclick="scrollToDiv('ghi_cont','100')">GHI</a> ] [ <a href="javascript:;" onclick="scrollToDiv('jkl_cont','100')">JKL</a> ] 
            [ <a href="javascript:;" onclick="scrollToDiv('mno_cont','100')">MNO</a> ] [ <a href="javascript:;" onclick="scrollToDiv('pqr_cont','100')">PQR</a> ] 
            [ <a href="javascript:;" onclick="scrollToDiv('stu_cont','100')">STU</a> ] [ <a href="javascript:;" onclick="scrollToDiv('vwx_cont','100')">VWX</a> ] 
            [ <a href="javascript:;" onclick="scrollToDiv('yz_cont','100')">YZ</a> ] [ <a href="javascript:;" onclick="scrollToDiv('numchar_cont','100')">0-9</a> ]</div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="abc_cont">
            <div class="cLetters"><span>ABC</span></div>
            <div class="w-100" id="streamed_abc"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="def_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>DEF</span></div>
            <div class="w-100" id="streamed_def"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="ghi_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>GHI</span></div>
            <div class="w-100" id="streamed_ghi"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="jkl_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>JKL</span></div>
            <div class="w-100" id="streamed_jkl"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="mno_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>MNO</span></div>
            <div class="w-100" id="streamed_mno"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="pqr_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>PQR</span></div>
            <div class="w-100" id="streamed_pqr"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="stu_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>STU</span></div>
            <div class="w-100" id="streamed_stu"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="vwx_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>VWX</span></div>
            <div class="w-100" id="streamed_vwx"></div>
            </div>
            
            <div class="letterCont fleft w-100" style="display: none;" id="yz_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>YZ</span></div>
            <div class="w-100" id="streamed_yz"></div>
            </div>
                    
            <div class="letterCont fleft w-100" style="display: none;" id="numchar_cont">
            <a class="ctoplnk" href="javascript:;" onclick="scrollToDiv('ctop','100')">Top</a>
            <div class="cLetters"><span>0-9</span></div>
            <div class="w-100" id="streamed_numchar"></div>
            </div>
            
            </div>
            <div class="w-100 fleft" style="display: none;" id="city_error"></div>
            </div>
            </div>
             
            <div class="fleft w-100 mt-15">
            
            <div class="fleft col-12 mb-5">
            <div class="w-100 fs-13" style="border-bottom: 2px dashed #009CE8; color: #009CE8;"><b>MLS SEARCH:</b></div>
            </div>
            
            <div class="col-lg-4 col-md-12 fleft dsply_inline_blck">
            <form autocomplete="off">
            <div class="form-group mt-10">
                <label id="form_lbl">MLS Number</label>
          	    <div class="input-with-icon">
            		<input type="number" class="form-control no_radius" id="advnc_mls_number" name="advnc_mls_number" placeholder="Enter MLS Number" autocomplete="off" />
            		<i class="fas fa-server"></i>
            	</div>
            </div>
            </form>
            </div>
            
            <div class="fleft w-100 mt-15 xs-pr-15 sm-pr-15 md-pr-15">
            <div class="btn btn-primary fright" onclick="AdvanceSearch('MLS')"><i class="ti-search"></i> Search</div>
            </div>
            </div>
        </div>
        <!-- end row -->
        </div>
        <!-- end container -->
        </section>
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    
    <script type="text/javascript">
    
    function reloadComm(value){
        if($('#cities_cont').is(':visible')){
            $(".letterCont").hide();
            $(".letterCheckBox").remove();
            loadMLSCityCommunities('MLS');
        }
    }
    
    function toggle_cities(){
        $('#cities_cont').toggle(function(){
          
            $(".letterCont").hide();
            $(".letterCheckBox").remove();
            
          if($('#cities_cont').is(':visible')){
            $('#toggle_cities').html('<b><i class="fas fa-chevron-down"></i> CLICK HERE TO SELECT COMMUNITIES:</b>'); 
            loadMLSCityCommunities('MLS');
          }else{
            $('#toggle_cities').html('<b><i class="fas fa-chevron-right"></i> CLICK HERE TO SELECT COMMUNITIES:</b>');  
          }
        });
    }
    
    </script>
    </div>
</body>
</html>