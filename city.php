<?php
include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(1);  



if(isset($_GET['slug'])){

$slug = $_GET['slug'];



}else{
$url=$_SERVER['REQUEST_URI'];

$urlarr=explode('/', $url);

if($urlarr[2]){
$slug=$urlarr[2];
}

}

if($slug){



$selCity = "SELECT * FROM cities WHERE slug='$slug'";  
$cityRslts = mysqli_query($conn,$selCity);  
$noCity = mysqli_num_rows($cityRslts);

if($noCity>0){
$rowCity = mysqli_fetch_array($cityRslts);
extract($rowCity);

$xpldComm = explode(',',$communities);
$commIdArr = array();

foreach($xpldComm as $comms){
    if($comms!=''){
        $xplId = explode(":", $comms);
        $commID = $xplId[0];
        array_push($commIdArr,$commID);
    }
}
$commIdArr = implode("','",$commIdArr);

$selComm = "SELECT * FROM all_communities WHERE community_id IN ('".$commIdArr."')";  
$commRslts = mysqli_query($conn,$selComm);  
$noComm = mysqli_num_rows($commRslts);

if($noComm>0){
    $commData = "";
    $commArray=array();
    while($rowCm = mysqli_fetch_assoc($commRslts)){
        array_push($commArray, $rowCm);
    }
    
    $restlArray=array('data'=>'Done', 'communities'=>$commData);
}else{
    $restlArray=array('data'=>'Error: no community found in this city.');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="author" content="Oluwapaso" />
     <base href="/" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="<?php echo $meta_description;?>"/>
    
    <title>Gulf Shore Group | <?php echo $page_title;?></title>
	
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
        
        <div class="page-title" style="background:#f4f4f4 url(admin/templates/cities/<?php echo $header_img;?>);" data-overlay="5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
                            <h2 class="breadcrumb-title"><?php echo $page_title;?></h2>
							<ol class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page"><?php echo $name;?></li>
							</ol>
						</div>
						
					</div>
				</div>
			</div>
		</div>
        
        <section class="gray pt-4 xs-pb-15">
            <div class="container xs-mxw-95">
            
                <div class="row">
        	
            	<!-- property Sidebar --> 
            	<div class="col-lg-8 col-md-12 col-sm-12">
                
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <form autocomplete="off">
                    <div class="form-group relative">
                        <label id="form_lbl">Quick search</label>
                    	<div class="input-with-icon">
                    		<input type="text" class="form-control no_radius" onkeyup="quickSearch(this.value)" id="advnc_state_or_city" name="advnc_state_or_city" placeholder="Enter a Community Name, Development, Street, Address or Zip Code" />
                    		<i class="ti-location-pin"></i>
                            <img src="assets/img/loader.gif" class="quick_srch_img" />
                    	</div>
                        <ul class="w100 absolute shadow p-0" id="streamed_search">
                        </ul>
                    </div>
                    </form>
                    </div>
                    </div>
                    
                    
                    
                
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20 mt-30" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <h4 class="w-100 fs-18"><?php echo $name;?> Florida Predefined Property Search</h4>
                    
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=Yes&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> New Listings <span class="badge badge-primary">NEW</span></a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=3%2B&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> 3+ Bedroom Homes for Sale</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=Yes&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> <?php echo $name;?> Foreclosures</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=Condos&city=<?php echo $name;?>&zipcode=&beds=2%2B&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> 2+ Bedroom Condos for Sale</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=Yes&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> <?php echo $name;?> Short Sales</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=1500000&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> Luxury Homes and Condos</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&status=Sold&pagination=get&page=1"><i class="ti-search fs-13"></i> Sold Properties</a>
                    <a class="fleft col-md-6 dsply_inline_blck mb-5 pl-0" href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=Condos&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=Yes&gated=&pagination=get&page=1"><i class="ti-search fs-13"></i> Waterfront Homes and Condos</a>
                    
                    </div>
                    
                    
                    <div class="col-md-12 fleft mt-30">
                    <img src="admin/templates/cities/<?php echo $header_img;?>" onerror="$(this).attr('src','https://via.placeholder.com/300x200.png?text=No+community+image+added+yet')" style="float: left; height: 200px; width: auto; max-width: 100%; margin-right: 20px; margin-top: 10px; border-bottom: 12px solid white; margin-bottom: 0px!important;" />
                    <span class="fs-17"><?php echo $content;?></span>
                    </div>
                    
                    </div>
                    
                    
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20 mt-30" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <h4 class="w-100 fs-18"><?php echo $name;?> Communities</h4>
                    
                    <div class="city_comm_list w-100 fleft mt-15" id="city_list">
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
                    </div>
                    </div>
                    
                    
                    <div class="row justify-content-center bg-white shadow p-20 xs-pl-5 xs-pr-5 pt-20 pb-20 mt-30" style="border: 1px solid #EAEAEA;">
                    <div class="col-md-12 fleft">
                    <h4 class="w-100 fleft">Featured Cities.</h4>
                    <?php
                    $selCity = "SELECT * FROM cities WHERE city_id!='' ORDER BY name ASC";  
                    $cityRslts = mysqli_query($conn,$selCity);  
                    $noCity = mysqli_num_rows($cityRslts);
                    $data = $cityRslts->fetch_all(MYSQLI_ASSOC);
                    
                    $ftrdComm = '';
                    if($noCity>0){
                    foreach ($data as $row){
                    $city_name = $row['name'];
                    $city_slug = $row['slug'];
                    $ftrdComm .= $row['communities'];
                    ?>
					<a class="col-md-4 pl-0 fleft dsply_inline_blck mb-15" href="city/<?php echo $city_slug;?>"><?php echo $city_name;?></a>
                    <?php
                    }
                    }
                    ?>
                    </div>
                    </div>
                    
                </div>
                
                
                
                
                
                
                <div class="col-lg-4 col-md-12 col-sm-12 xs-pl-0 xs-pr-0 sm-pl-0 sm-pr-0 md-pl-0 md-pr-0 md-mt-30">
                <div class="page-sidebar p-20 shadow no_radius">
                <h4 class="w-100 centered-text fs-17"><?php echo $name;?> Real Estate</h4>
                
                <div class="totalsNav w-100"> 
                <a href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=&city=<?php echo $name;?>&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-desc&pagination=get&page=1" rel="nofollow"> 
                <span class="on">Homes For Sale</span><span class="to"><?php echo $homes_for_sale;?></span> 
                </a> 
                <!-- search.php?location=Any&mls_number=&min_price=Any&max_price=Any&property_type=&city=&zipcode=&beds=Any&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-asc&pagination=get&page=1 -->
                <a href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=Condos&city=<?php echo $name;?>&zipcode=&beds=&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&communities=&gulf_access=&ref=quick&sort=price-desc&pagination=get&page=1" rel="nofollow"> 
                <span class="on">Condos For Sale</span><span class="to"><?php echo $condos_for_sale;?></span> 
                </a> 
                
                <a href="search.php?location=Any&mls_number=&min_price=&max_price=&property_type=Condos&city=<?php echo $name;?>&zipcode=&beds=&baths=Any&min_sq_ft=&max_sq_ft=&min_year=Any&garage=Any&just_listed=&include_sold=&foreclosure=&short_sale=&pool=&spa=&guest_house=&waterfront=&gated=&status=Sold&date_sold_from=<?php echo date("Y-m-d", strtotime("first day of last month"));?>&date_sold_to=<?php echo date("Y-m-d", strtotime("last day of last month"));?>&pagination=get&page=1" rel="nofollow">
                <span class="on">Sold in <?php echo date("F", strtotime("first day of last month"));?></span><span class="to"><?php echo $sold_last_month;?></span> 
                </a> 
                </div>
                
                <div class="w-100 mt-15 centered-text">
                Last updated at <?php echo date("m-d-Y g:i a", strtotime($last_updated));?>
                </div>
                </div>
                 
                
                <?php 
                $silde_limit = "3";
                include_once 'side_listings.php';
                ?>
                
                <!-- Sidebar End -->
                </div>
            
            
             
                </div>
                
			</div>
		</section>
         
         
		<!-- Top header  -->
		<!-- ============================================================== -->
    <?php include_once 'footer.php';?>  
    <script type="text/javascript">
    var commArray = <?php echo json_encode($commArray);?>;
    
    $(document).ready(function(){
       for(var i=0; i<commArray.length; i++){
        var active_listings = commArray[i].active_listings;
        var community_id = commArray[i].community_id;
        var last_updated = commArray[i].last_updated;
        var max_price = commArray[i].max_price;
        var min_price = commArray[i].min_price;
        var name = commArray[i].name;
        
         appendCityComm(active_listings,community_id,last_updated,max_price,min_price,name);

       } 
    });
    
    
    function appendCityComm(active_listings,commID,last_updated,max_price,min_price,commName){
        if((commName.lastIndexOf('A', 0) === 0) || (commName.lastIndexOf('B', 0) === 0) || (commName.lastIndexOf('C', 0) === 0)){
            $("#abc_cont").show();
            var appendTo = "#streamed_abc";
        }else if((commName.lastIndexOf('D', 0) === 0) || (commName.lastIndexOf('E', 0) === 0) || (commName.lastIndexOf('F', 0) === 0)){
            $("#def_cont").show();
            var appendTo = "#streamed_def";
        }else if((commName.lastIndexOf('G', 0) === 0) || (commName.lastIndexOf('H', 0) === 0) || (commName.lastIndexOf('I', 0) === 0)){
            $("#ghi_cont").show();
            var appendTo = "#streamed_ghi";
        }else if((commName.lastIndexOf('J', 0) === 0) || (commName.lastIndexOf('K', 0) === 0) || (commName.lastIndexOf('L', 0) === 0)){
            $("#jkl_cont").show();
            var appendTo = "#streamed_jkl";
        }else if((commName.lastIndexOf('M', 0) === 0) || (commName.lastIndexOf('N', 0) === 0) || (commName.lastIndexOf('O', 0) === 0)){
            $("#mno_cont").show();
            var appendTo = "#streamed_mno";
        }else if((commName.lastIndexOf('P', 0) === 0) || (commName.lastIndexOf('Q', 0) === 0) || (commName.lastIndexOf('R', 0) === 0)){
            $("#pqr_cont").show();
            var appendTo = "#streamed_pqr";
        }else if((commName.lastIndexOf('S', 0) === 0) || (commName.lastIndexOf('T', 0) === 0) || (commName.lastIndexOf('U', 0) === 0)){
            $("#stu_cont").show();
            var appendTo = "#streamed_stu";
        }else if((commName.lastIndexOf('V', 0) === 0) || (commName.lastIndexOf('W', 0) === 0) || (commName.lastIndexOf('X', 0) === 0)){
            $("#vwx_cont").show();
            var appendTo = "#streamed_vwx";
        }else if((commName.lastIndexOf('Y', 0) === 0) || (commName.lastIndexOf('Z', 0) === 0)){
            $("#yz_cont").show();
            var appendTo = "#streamed_yz";
        }else{
            $("#numchar_cont").show();
            var appendTo = "#streamed_numchar";
        }
        
        min_price = formatToCurrency(min_price);
        min_price = min_price.replace('.00','');
        
        max_price = formatToCurrency(max_price)
        max_price = max_price.replace('.00','');
        
        var div = '<div class="letterCheckBox col-md-6 xs-pl-5 xs-pr-5 fleft dsply_inline_blck">\
        <div class="w-100 mt-10">\
			<div class="w-100"><a href="community/'+encodeURIComponent(commName)+'/homes/price-asc/1" class="bold" style="color: #585858;">'+commName+'</a> ('+active_listings+')</div>\
			<div class="w-100">'+min_price+' - '+max_price+'</div>\
        </div>\
        </div>';
        
        $('.city_comm_list '+appendTo).append(div);
    }
    
    function formatToCurrency(amount) {
      amount = parseFloat(amount);
      return "$" + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
    };
    </script>
    </div>
</body>
</html>
<?php
}else{
 echo '<script type="text/javascript">window.location.href="/";</script>';
}


}else{
   echo '<script type="text/javascript">window.location.href="/";</script>';
}
?>