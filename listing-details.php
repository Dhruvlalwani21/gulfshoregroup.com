<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);

if($_SESSION['driver_id']){
include_once '../connect.php';
include_once '../session_vars.php';
}

function GetDrivingDistance($lat1, $long1, $lat2, $long2){
    $url ="https://maps.googleapis.com/maps/api/directions/json?origin=".$lat1.",".$long1."&destination=".$lat2.",".$long2."&mode=driving&key=AIzaSyAhslYaXxH3ycFvxtw6bIifl0D6K_Y4DYk";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $response_a = json_decode($response, true);
    $dist = $response_a['routes'][0]['legs'][0]['distance']['text'];
    $time = $response_a['routes'][0]['legs'][0]['duration']['text'];
    $paths = $response_a['routes'][0]['overview_polyline']['points'];
    
    return array('distance' => $dist, 'time' => $time, 'paths' => $paths);
}

if(isset($_GET['listing_id'])){
    
$sqlListings = "SELECT * FROM load_posts WHERE posts_id='$listing_id'";  
$listingRslt=mysqli_query($conn,$sqlListings) or die(mysqli_error($conn));
$listingExists=mysqli_num_rows($listingRslt);

if($listingExists>0){
$row=mysqli_fetch_array($listingRslt);
$posts_id=$row['posts_id'];
$listed_by=$row['company_id'];
$agent_id=$row['user_id'];
$pickup=$row['pickup'];
$order_id=$row['order_id'];
$order_uniq_id=$row['order_uniq_id'];
$pickup_location=$row['pickup_location'];
$delivery=$row['delivery'];
$delivery_location=$row['delivery_location'];
$pickup_date=$row['pickup_date'];
$pickup_date_type=$row['pickup_date_type'];
$delivery_date=$row['delivery_date'];
$delivery_date_type=$row['delivery_date_type'];
$vehicle=$row['vehicle'];
$vehicle_runs=$row['vehicle_runs'];
$ship_via=$row['ship_via'];
$no_vehicle=$row['no_vehicle'];
$expire_on=$row['expire_on'];
$carrier_pay=$row['carrier_pay'];
$lowest_bid=$row['lowest_bid'];
$no_bids=$row['no_bids'];
$watching=$row['watching'];
$date_listed=$row['date_listed'];
$last_updated=$row['last_updated'];
$post_status=$row['status'];

$pickLatLong = "SELECT latitude, longitude, county FROM cities_extended WHERE zip='$pickup'";  
$pickLatLongRslt=mysqli_query($conn,$pickLatLong) or die(mysqli_error($conn));
$pickLatLonExst=mysqli_num_rows($pickLatLongRslt);

if($pickLatLonExst>0){
$rowPickLatLong=mysqli_fetch_array($pickLatLongRslt);
$pickup_latitude = $rowPickLatLong['latitude'];
$pickup_longitude = $rowPickLatLong['longitude'];
$pickup_county = $rowPickLatLong['county'];
}


$delivLatLong = "SELECT latitude, longitude, county FROM cities_extended WHERE zip='$delivery'";  
$delivLatLongRslt=mysqli_query($conn,$delivLatLong) or die(mysqli_error($conn));
$delivLatLonExst=mysqli_num_rows($delivLatLongRslt);

if($delivLatLonExst>0){
$rowDelivLatLong=mysqli_fetch_array($delivLatLongRslt);
$delivery_latitude = $rowDelivLatLong['latitude'];
$delivery_longitude = $rowDelivLatLong['longitude'];
$delivery_county = $rowDelivLatLong['county'];
}

$dist = GetDrivingDistance($pickup_latitude, $pickup_longitude, $delivery_latitude, $delivery_longitude); 
$totalMiles = $dist['distance'];
$time = $dist['time'];
$totalTime = str_replace('hours','hr',$time);
$totalWeight = 0; 

$paths = $dist['paths'];

if($no_vehicle>1){
    $vehicleOut = $no_vehicle.' vehicles';
    $vExplode = explode('#',$vehicle);
    $v1 = $vExplode[0];
    $extra = $no_vehicle - 1;
    $vehicle = str_replace(';',' ',$v1).' <b class="fs-14 deep-blue-text">+'.$extra.' more</b>'; 
    
    $vehicleList = '';
    $count = 1;
    foreach($vExplode as $cars){
       if($cars!=''){
       $split = explode(';',$cars);
       $carYear = trim($split[0]);
       $carMake = trim($split[1]);
       $carModel = trim($split[2]);
       if($vehicle_runs == 'Yes'){
        $vehicleRuns = '<i class="icofont icofont-check fs-18" styele="color: green;"></i>Operable';
       }else{
        $vehicleRuns = '<i class="icofont icofont-close danger fs-18"></i>Inoperable';
       }
       
       $sqlTrims = "SELECT Length_Inch, Width_Inch, Height_Inch, CurbWeight_LBS FROM year_make_model_trim WHERE Make='$carMake' AND Model='$carModel' AND Year='$carYear'";  
       $trimRslt=mysqli_query($conn,$sqlTrims) or die(mysqli_error($conn));
       $trimExists=mysqli_num_rows($trimRslt); 
       if($trimExists>0){
       $rowC = mysqli_fetch_array($trimRslt);
       $Length_Inch = str_replace('.','',$rowC['Length_Inch']);
       $Width_Inch = str_replace('.','',$rowC['Width_Inch']);
       $Height_Inch = str_replace('.','',$rowC['Height_Inch']);
       
       $dimentions = $Length_Inch.' x '.$Width_Inch.' x '.$Height_Inch.' in';
       $weight = $rowC['CurbWeight_LBS'];
       $totalWeight += $weight;
       $weight = number_format($weight,0);
       
       }else{
       $weight = '<a href="https://www.edmunds.com/'.$carMake.'/'.$carModel.'/'.$carYear.'/features-specs/#Measurements-section-title-content" target="_blank">View Full Spec</a>';
       $dimentions = '<a href="https://www.edmunds.com/'.$carMake.'/'.$carModel.'/'.$carYear.'/features-specs/#Measurements-section-title-content" target="_blank">View Full Spec</a>';
       }
    
       $vehicleList .= '<div class="w-100 fleft pt-20 pb-20" style="border-top: 1px solid #EBEBEB;">
                          <div class="w-100 fleft mb-10"><h4 class="w-100 fw-bold fs-17">'.$count.'. '.$carYear.' '.$carMake.' '.$carModel.'</h4></div>
                          <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left xs-mb-20">
                              <h4 class="fs-13 text-bold-600" style="color: #858585;">Condition</h4>
                              <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$vehicleRuns.'</p>
                          </div>
                          <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left xs-mb-20">
                              <h4 class="fs-13 text-bold-600" style="color: #858585;">Weight</h4>
                              <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$weight.' lbs</p>
                          </div>
                          <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left">
                              <h4 class="fs-13 text-bold-600" style="color: #858585;">Dimentions</h4>
                              <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$dimentions.'</p>
                          </div>
                         </div>';
    $count++;
    }
    }
    
}else{
    $vehicleOut = $no_vehicle.' vehicle'; 
    $car = $vehicle; /** original **/
    $vehicle = str_replace(';',' ',$vehicle); 
    $vehicle = str_replace('#','',$vehicle); 
 
    $split = explode(';',$car);
    $carYear = trim($split[0]);
    $carMake = trim($split[1]);
    $carModel = trim($split[2]);
    
    if($vehicle_runs == 'Yes'){
    $vehicleRuns = '<i class="icofont icofont-check fs-18" styele="color: green;"></i>Operable';
    }else{
    $vehicleRuns = '<i class="icofont icofont-check fs-18 danger"></i>Inoperable';
    }
    
    $sqlTrims = "SELECT Length_Inch, Width_Inch, Height_Inch, CurbWeight_LBS FROM year_make_model_trim WHERE Make='$carMake' AND Model='$carModel' AND Year='$carYear'";
    $trimRslt=mysqli_query($conn,$sqlTrims) or die(mysqli_error($conn));
    $trimExists=mysqli_num_rows($trimRslt); 
    if($trimExists>0){
    $rowC = mysqli_fetch_array($trimRslt);
    $Length_Inch = str_replace('.','',$rowC['Length_Inch']);
    $Width_Inch = str_replace('.','',$rowC['Width_Inch']);
    $Height_Inch = str_replace('.','',$rowC['Height_Inch']);
    
    $dimentions = $Length_Inch.' x '.$Width_Inch.' x '.$Height_Inch.' in';
    $weight = $rowC['CurbWeight_LBS'];
    $totalWeight += $weight;
    $weight = number_format($weight,0);
    
    }else{
    $weight = '<a href="https://www.edmunds.com/'.$carMake.'/'.$carModel.'/'.$carYear.'/features-specs/#Measurements-section-title-content" target="_blank">View Full Spec</a>';
    $dimentions = '<a href="https://www.edmunds.com/'.$carMake.'/'.$carModel.'/'.$carYear.'/features-specs/#Measurements-section-title-content" target="_blank">View Full Spec</a>';
    }
    
    $vehicleList .= '<div class="w-100 fleft pt-20 pb-20" style="border-top: 1px solid #EBEBEB;">
                      <div class="w-100 fleft mb-10"><h4 class="w-100 fw-bold fs-17">1. '.$carYear.' '.$carMake.' '.$carModel.'</h4></div>
                      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left xs-mb-20">
                          <h4 class="fs-13 text-bold-600" style="color: #858585;">Condition</h4>
                          <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$vehicleRuns.'</p>
                      </div>
                      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left xs-mb-20">
                          <h4 class="fs-13 text-bold-600" style="color: #858585;">Weight</h4>
                          <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$weight.' lbs</p>
                      </div>
                      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 pl-0 text-left">
                          <h4 class="fs-13 text-bold-600" style="color: #858585;">Dimentions</h4>
                          <p class="mb-0 fw-bold fs-15" style="color: #737373;">'.$dimentions.'</p>
                      </div>
                     </div>';
}

if($no_bids == '0'){
   $noBidsOut = 'No Quotes'; 
}else if($no_bids == '1'){
   $noBidsOut = '1 quote';  
}else if($no_bids >1){
   $noBidsOut = $no_bids.' quotes';  
}

$expireOn = DateTime::createFromFormat("Y-m-d H:i:s",$expire_on);
$rightNow = new DateTime();
$daysLeft = $rightNow->diff($expireOn)->format("%a");
$hoursLeft = $rightNow->diff($expireOn)->format("%H");
$minLeft = $rightNow->diff($expireOn)->format("%i");
$secLeft = $rightNow->diff($expireOn)->format("%s");

$nowStamp = time();
$xprStam = strtotime($expire_on);

if($daysLeft>1){
    $dayTxt = 'days';
}else{
    $dayTxt = 'day';
}

if($hoursLeft>1){
    $hourTxt = 'hours';
}else{
    $hourTxt = 'hour';
}

if($minLeft>1){
    $minTxt = 'minutes';
}else{
    $minTxt = 'minute';
}

if($xprStam>$nowStamp){
$status = '<button class="btn btn-success pl-15 pr-15 fs-13 fw-bold mt--5" style="padding: 6px;">Active</button>';
$stillActive = 'Yes';

if($daysLeft>0){
    $timeLeft = $daysLeft.' '.$dayTxt.' '.$hoursLeft.' '.$hourTxt.' Left |';
}else{
    if($hoursLeft>0){
    $timeLeft = '<i class="icofont icofont-ui-clock fs-14" style="color: red;"></i> '.$hoursLeft.' '.$hourTxt.' '.$minLeft.' '.$minTxt.' Left |';
    }else{
    if($minLeft>0){
    $timeLeft = '<i class="icofont icofont-ui-clock fs-14" style="color: red;"></i> '.$minLeft.' '.$minTxt.' Left |';
    }else{
    $timeLeft = '<i class="icofont icofont-calendar fs-14" style="color: red;"></i> <span style="color: red;">Listing Expired</span>';  
    $status = '<button class="btn btn-danger pl-15 pr-15 fs-13 fw-bold mt--5" style="padding: 6px;">Expired</button>'; 
    $stillActive = 'No'; 
    }   
    }
}
}else{
    $timeLeft = '<i class="icofont icofont-calendar fs-14" style="color: red;"></i> <span style="color: red;">Listing Expired</span>';  
    $status = '<button class="btn btn-danger pl-15 pr-15 fs-13 fw-bold mt--5" style="padding: 6px;">Expired</button>'; 
    $stillActive = 'No'; 
}

$sqlWatching = "SELECT post_id FROM watch_list WHERE company_id='$listed_by' AND user_id='$agent_id' AND post_id='$listing_id' AND order_id='$order_id' AND driver_id='$driver_id'";  
$watchingRslt=mysqli_query($conn,$sqlWatching) or die(mysqli_error($conn));
$watchingExist=mysqli_num_rows($watchingRslt);

if($watchingExist>0){
   $iamWatching = 'Yes'; 
}else{
   $iamWatching = 'No'; 
}

if(isset($_SESSION['driver_id'])){
    $driverID = $_SESSION['driver_id']; /** for notificartion **/
    $delNoti="DELETE FROM driver_notifications WHERE driver_id='$driverID' AND order_id='$posts_id'";
    $delRslt=mysqli_query($conn,$delNoti) or die(mysqli_error($conn));
}
?>
<script type="text/javascript">
var company_id="<?php echo $listed_by;?>";
var agent_id="<?php echo $agent_id;?>";
var driver_id="<?php echo $driver_id;?>";
var listing_id='<?php echo $listing_id;?>'; 
var order_id = '<?php echo $order_id;?>';
var order_uniq_id = '<?php echo $order_uniq_id;?>';
var expiredStamp = '<?php echo $xprStam;?>';
var lowest_bid = '<?php echo $lowest_bid;?>';
var no_bids = '<?php echo $no_bids;?>';

</script>
<link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/pickers/pickadate/pickadate.css" />

<div class="row match-height float_none" id="settings_cont" style="max-width: 1100px!important;">  

<div class="col-md-12 fleft xs-pl-0 xs-pr-0 xs-mt-15 sm-mt-15">
<h4 class="card-title">
<div style="color: #0098E1; cursor: pointer;" onclick="window.history.go(-1); return false;">
<i class="la la-chevron-left" style="font-size: 15px; float: left;"></i> 
<span style="font-size: 15px; float: left; font-weight: 500; margin-top: -1.5px;">&nbsp;Go Back</span>
</div>
</h4>
</div>

<div class="col-lg-9 col-md-12 fleft xs-pl-0 xs-pr-0 sm-pl-0 sm-pr-0 xs-mt-5 sm-mt-5">
    
    <div class="w-100 fleft pt-15 pb-15 pr-0 pl-0">
    <h4 class="w-100 fw-bold"><span class="text_left"><?php echo $vehicle;?></span> <span class="fright text_right"><?php echo $status;?></span></h4>
    <h4 class="w-100 fs-14 fw-bold" style="color: #727272;"><?php echo $timeLeft;?> <span class="listed_cont">Listed <?php echo date("M d, Y", strtotime($date_listed));?></span></h4>
    </div>
    
    <div class="card fleft w-100 no_radius pb-25"> 
    <div class="card-content collapse show">
      <div class="card-body"> 
      <div class="fleft dsply_inline_blck col-md-6 col-sm-6 pl-0">
      <h3 class="w-100 fleft fw-bold fs-15">Pickup</h3>
      <div class="w-100 fleft fw-500 mb-5"><i class="la la-map-marker fs-13"></i> <?php echo $pickup_location?></div>
      <div class="w-100 fleft fw-500"><i class="la la-calendar fs-13"></i> <b><?php echo $pickup_date_type;?>:</b> <?php echo date('M d, Y', strtotime($pickup_date));?></div>
      </div>
      
      <div class="fleft dsply_inline_blck col-md-6 col-sm-6 xs-pl-0 xs-mt-15 pr-0">
      <h3 class="w-100 fleft fw-bold fs-15">Delivery</h3>
      <div class="w-100 fleft fw-500 mb-5"><i class="la la-map-marker fs-13"></i> <?php echo $delivery_location?></div>
      <div class="w-100 fleft fw-500"><b class=" fs-13"><i class="la la-calendar fs-13"></i> <?php echo $delivery_date_type?>:</b> <?php echo date('M d, Y', strtotime($delivery_date));?></div>
      </div>  
      
      <div class="w-100 fleft mt-10">
      <!--img src="https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=5&size=640x300&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&key=AIzaSyAhslYaXxH3ycFvxtw6bIifl0D6K_Y4DYk" style="width: 100%; height: auto;" /-->
      <img src="https://maps.googleapis.com/maps/api/staticmap?size=793x313&scale=0&path=weight:5|color:blue|enc:<?php echo $paths;?>&markers=anchor:center|icon:https://crm.cronetic.com/app-assets/images/pickup_marker_P.png|<?php echo $pickup_latitude;?>,<?php echo $pickup_longitude;?>&markers=anchor:center|icon:https://crm.cronetic.com/app-assets/images/delivery_marker_D.png|<?php echo $delivery_latitude;?>,<?php echo $delivery_longitude;?>&style=element:geometry|color:0xF9F9F9&style=feature:administrative|color:0xDDDDDD&style=feature:administrative.province|color:0xB8B8B8&style=element:labels.text.fill|color:0x616161&style=element:labels.text.stroke|color:0xF5F5F5&style=feature:administrative.land_parcel|element:labels.text.fill|color:0xBDBDBD&style=feature:poi|element:geometry|color:0xEEEEEE&style=feature:poi|element:labels.text.fill|color:0x757575&style=feature:poi.park|element:geometry|color:0xE5E5E5&style=feature:poi.park|element:labels.text.fill|color:0x9E9E9E&style=feature:road|element:geometry|color:0xDDDDDD&style=feature:road.arterial|element:labels.text.fill|color:0x757575&style=feature:road.highway|element:geometry|weight:0.4&style=feature:road.highway|element:labels.text.fill|color:0x616161&style=feature:road.local|element:labels.text.fill|color:0x9E9E9E&style=feature:water|element:geometry|color:0xEFEFEF&style=feature:water|element:labels.text.fill|color:0x9E9E9E&key=AIzaSyAhslYaXxH3ycFvxtw6bIifl0D6K_Y4DYk" style="width: 100%; height: auto;" />
      <!--img src="https://maps.googleapis.com/maps/api/staticmap?size=400x400&center=< ?php echo $pickup_latitude;?>,< ?php echo $pickup_longitude;?>&zoom=6&path=weight:5%7Ccolor:blue%7Cenc:< ?php echo $paths;?>&key=AIzaSyAhslYaXxH3ycFvxtw6bIifl0D6K_Y4DYk" /-->
      </div> 
      
      
      <div class="w-100 fleft mt-30">
      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 border-right-blue-grey border-right-lighten-5 text-center xs-mb-30">
          <h4 class="primary fs-17 fw-bold text-bold-400" id="ttl_leads"><?php echo $totalMiles;?></h4>
          <p class="mb-0" style="color: #727272;">Total Distance</p>
      </div>
      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 border-right-blue-grey border-right-lighten-5 text-center xs-mb-30">
          <h4 class="primary fs-17 fw-bold text-bold-400" id="ttl_quotes"><?php echo $totalTime;?></h4>
          <p class="mb-0" style="color: #727272;">Driving Time</p>
      </div>
      <div class="fleft dsply_inline_blck col-md-4 col-sm-4 col-12 text-center">
          <h4 class="primary fs-17 fw-bold text-bold-400" id="ttl_orders"><?php echo $totalWeight;?> (lbl)</h4>
          <p class="mb-0" style="color: #727272;">Total Weight</p>
      </div>
      </div>
      
      </div>
    </div>
    </div>
    
    
    <div class="col-md-12 fleft pl-0 pr-0">
    <div class="card no_radius"> 
    <div class="card-header">
    <h4 class="card-title">Shipment Details</h4>
    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
        <!--li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li-->
        <!--li><a data-action="expand"><i class="ft-maximize"></i></a></li-->
        <!--li><a data-action="close"><i class="ft-x"></i></a></li-->
      </ul>
    </div>
    </div>
    <div class="card-content pt-0 mt-0 collapse show">
      <div class="card-body pt-0 mt-0"> 
        <?php echo $vehicleList;?>
        
        <div class="w-100 fleft pt-20 pb-20" style="border-top: 1px solid #EBEBEB;">
            <div class="w-100 fleft"><h4 class="fw-bold fs-16 mb-0 pb-0">Requested Transport Type: <span class="fw-500" style="color: #858585;"><?php echo $ship_via;?> Transport</span></h4></div>
        </div>
        
        <div class="w-100 fleft pt-20 pb-20" style="border-top: 1px solid #EBEBEB;">
            <div class="w-100 fleft"><h4 class="fw-bold fs-16 mb-0 pb-0">Amount Offered: <span class="fw-500 danger fw-bold">$<?php echo number_format($carrier_pay,2);?></span></h4></div>
        </div>
        
        <div class="w-100 fleft pt-20 pb-20" style="border-top: 1px solid #EBEBEB;">
            <div class="w-100 fleft"><h4 class="fw-bold fs-16 mb-0 pb-0">Lowest Quote: <span class="fw-500 danger fw-bold">$<?php echo number_format($lowest_bid,2);?></span></h4></div>
        </div>
        
      </div>
    </div>
    </div>
    </div>
    
    
    
    <div class="col-md-12 fleft pl-0 pr-0">
    <div class="card no_radius"> 
    <div class="card-header">
    <h4 class="card-title">Quotes</h4>
    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    <div class="heading-elements">
      <ul class="list-inline mb-0" onclick="loadQuotes()">
        <li><a data-action="collapse"><i class="ft-plus"></i></a></li>
        <!--li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li-->
        <!--li><a data-action="expand"><i class="ft-maximize"></i></a></li-->
        <!--li><a data-action="close"><i class="ft-x"></i></a></li-->
      </ul>
    </div>
    </div>
    <div class="card-content collapse mb-30 hide">
      <div class="card-body pt-0 xs-pl-5 xs-pr-5"> 
        <input type="hidden" name="quotes_loaded" id="quotes_loaded" value="No" />
        <div class="w-100 fleft centered-text mb-30" id="quotes_loader"><img src="../app-assets/images/ajax-loader2.gif" width="25" height="25" /></div>
        <div class="fleft w-100 mb-30 centered-text" style="display: none;" id="reloadQuotes">
        <div class="w-100 fleft centered-text">Unable to load quotes please <a href="javascript:;" onclick="loadQuotes()">Try again</a></div>
        <div class="w-100 fleft mt-10 centered-text"><button class="float_none btn btn-secondary" onclick="loadQuotes()">Load Quotes</button></div>
        </div>
        
        <div class="fleft w-100" id="streamed_quotes"></div>
        
      </div>
    </div>
    </div>
    </div>
    
    <div class="col-md-12 fleft pl-0 pr-0">
    <div class="card no_radius"> 
    <div class="card-header">
    <h4 class="card-title">Questions</h4>
    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li><a data-action="collapse"><i class="ft-plus"></i></a></li>
        <!--li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li-->
        <!--li><a data-action="expand"><i class="ft-maximize"></i></a></li-->
        <!--li><a data-action="close"><i class="ft-x"></i></a></li-->
      </ul>
    </div>
    </div>
    <div class="card-content collapse hide">
      <div class="card-body pt-0"> 
        
        <div class="fleft w-100" id="streamed_questions"></div>
        
        <?php
        $sqlQuestion = "SELECT driver_id, question, question_date, answer, answer_date FROM quotes_questions WHERE post_id='$listing_id' AND order_id='$order_id' ORDER BY question_date DESC";  
        $qstnRslt=mysqli_query($conn,$sqlQuestion) or die(mysqli_error($conn));
        $qstsExists=mysqli_num_rows($qstnRslt);
        
        if($qstsExists>0){
        
        while($rowQ = mysqli_fetch_array($qstnRslt)){
        $driverID = $rowQ['driver_id'];
        $question = $rowQ['question'];
        $question_date = date("F d, Y, g:i A", strtotime($rowQ['question_date']));
        $answer = $rowQ['answer'];
        $answer_date = date("F d, Y, g:i A", strtotime($rowQ['answer_date']));
        
        if($driver_id == $driverID){
            $nameOut = 'Me';
        }else{
            $nameOut = 'Carrier';
        }
        ?>
        <div class="question_row fleft w-100 pt-20 pb-20 greyBorderTop">
        <div class="qstnLogoCont fleft dsply_inline_blck" style="">
        <img src="../app-assets/images/no-image-found.jpg" />
        </div>
        <div class="fleft qstnTxtCont">
        <h3 class="fleft w-100 fw-bold fs-16"><?php echo $nameOut;?></h3>
        <h3 class="fleft w-100 fs-14 fw-bold" style="color: #999;"><?php echo $question_date;?></h3>
        <p class="fleft w-100" style="color: #373737; fs-16"><?php echo $question;?></p>
        
        <?php
        if($answer!=''){
        ?>
        <div class="fleft w-100 pl-25 pr-25">
        <h3 class="fleft w-100 fw-bold fs-16">Answer</h3>
        <h3 class="fleft w-100 fs-14 fw-bold" style="color: #999;"><?php echo $answer_date;?></h3>
        <p class="fleft w-100" style="color: #373737; fs-16"><?php echo $answer;?></p>
        </div>
        <?php
        }
        ?>
        
        </div>
        </div>
        <?php
        }
        
        }else{
        ?>
        <div class="fleft w-100 centered-text mb-30 mt-15" id="noQuestions">No questions asked.</div>
        <?php
        }
        ?>
         
        <div class="fleft w-100 mt-20 mb-30">
        
        <div class="w-100">
        <div class="form-group">
        <label style="font-weight: 600; width: 100%; float: left;">Ask question</label>
        <textarea  class="form-control" name="question" id="question" maxlength="1500" placeholder="Question" style="resize: none; max-height: 120px!important; height: 120px!important; min-height: 120px!important;"></textarea>
        <small><b>Max:</b> 1500 characters</small>
        </div>
        </div>

        <span style="float: left; width: 100%; margin-top: 0px;">
        <button class="btn btn-secondary fright mt-10" id="action_bt" style="border-radius: 0px!important; margin-left: 0px;" onclick="askQuestion()">
        <span class="icon_text">Ask Question</span></button> 
        </span>
        </div>
      </div>
    </div>
    </div>
    </div>
</div>


<div class="col-lg-3 col-md-12 fleft pr-0 xs-pl-0 xs-pr-0 sm-pl-0 sm-pr-0 md-pr-15">
<div class="card w-100 pb-30 fleft no_radius">
<div class="card-content">
  <div class="card-body"> 
    <h4 class="w-100 fleft centered-text fs-16 fw-bold mb-30">Submit a quote</h4>
    
    <?php
    if($stillActive == 'Yes' && $post_status == 'Posted'){
    ?>
    <button class="btn no_radius fleft w-100" style="background-color: #00b437; color: white;" onclick="showModal('#SubmitQuoteModal')">Submit Quote</button>
    
    <?php
    if($iamWatching == 'No'){
    ?>
    <button class="btn btn-primary no_radius fleft w-100 mt-25" id="watchBtn" onclick="watchQuote()">Watch</button>
    <?php
    }else{
    ?>
    <button class="btn btn-primary no_radius fleft w-100 mt-25" id="watchBtn" onclick="unwatchQuote()">Unwatch</button>
    <?php
    }
    
    }else if($post_status == 'Accepted'){
    ?>
    <button class="btn btn-success no_radius fleft w-100">Quote Accepted</button>
    <?php
    }else{
    ?>
    <button class="btn btn-danger no_radius fleft w-100">Listings Expired</button>
    <?php
    }
    ?>
    
    <div class="fleft w-100 mt-35 pb-10" style="border-bottom: 1px solid #E9E9E9;">
    <div class="fleft col-md-6 pl-0 pr-0 text-left dsply_inline_blck fs-13"><b>Lowest Quote</b></div> 
    <div class="fleft col-md-6 pl-0 pr-0 text-right dsply_inline_blck"><h2 class="fleft fw-bold" id="lowest_bid_text">$<?php echo number_format($lowest_bid,0);?></h2></div>
    </div>
    
    <div class="w-100 fleft mt-20">
      <div class="fleft dsply_inline_blck col-md-6 col-sm-6 col-12 pl-0 pr-0 border-right-blue-grey border-right-lighten-5 text-center xs-mb-20">
          <h4 class="fs-15 fw-400" id="ttl_leads">Watching</h4>
          <p class="mb-0 fw-bold fs-18" style="color: #727272;"><i class="primary icofont icofont-eye-alt fs-20"></i> <span id="watching_out"><?php echo $watching;?></span></p>
      </div>
      <div class="fleft dsply_inline_blck col-md-6 col-sm-6 col-12 pl-0 pr-0 text-center xs-mb-20">
          <h4 class="fs-15 fw-400" id="ttl_quotes">Quotes</h4>
          <p class="mb-0 fw-bold fs-18" style="color: #727272;"><i class="primary icofont icofont-money-bag fs-20"></i><?php echo $no_bids;?></p>
      </div>
    </div>
    
  </div>
</div>
</div>
</div>


 
 
</div>


<!-- submit quote modal -->
<div class="modal fade text-left" id="SubmitQuoteModal" tabindex="-1" role="dialog" aria-labelledby="SubmitQuoteModal" aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title" id="SubmitQuoteModal"><i class="icofont icofont-money-bag mt-3 fs-20 fleft pr-5"></i> Submit Quote</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Quote Price</label>
<div class="input-group">
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;">$</span>
<input type="number" class="form-control capitalize" id="quote_price" name="quote_price" />
</div>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Quote Expires</label>
<div class="input-group">
<input type="text" class="form-control capitalize" id="expiration_day" name="expiration_day" value="" />
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;"><i class="la la-calendar"></i></span>
</div>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Estimated Pickup</label>
<div class="input-group">
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;">Within</span>
<input type="number" class="form-control capitalize" id="estimated_pickup" name="estimated_pickup" value="3" />
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;">days of booking</span>
</div>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Estimated Delivery</label>
<div class="input-group">
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;">Within</span>
<input type="number" class="form-control capitalize" id="estimated_delivery" name="estimated_delivery" value="7" />
<span class="input-group-addon" style="height: 42px; border-radius: 0px!important;">days of booking</span>
</div>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Vehicle Type</label>
<select class="form-control" id="trailer_type" name="trailer_type">
<option value="Air Ride Van">Air Ride Van</option>
<option value="Auto Carrier">Auto Carrier</option>
<option value="Dry Van">Dry Van</option>
<option value="Dump">Dump</option>
<option value="Flatbed">Flatbed</option>
<option value="Flatbed Double">Flatbed Double</option>
<option value="Multi-Car Enclosed Trailer">Multi-Car Enclosed Trailer</option>
<option value="Multi-Car Open Trailer">Multi-Car Open Trailer</option>
<option value="Lowboy">Lowboy</option>
<option value="Power Only">Power Only</option>
<option value="Reefer">Reefer</option>
<option value="Removable Gooseneck">Removable Gooseneck</option>
<option value="Step Deck">Step Deck</option>
<option value="Stretch Flatbed">Stretch Flatbed</option>
<option value="Tanker">Tanker</option>
<option value="Van Double">Van Double</option>
<option value="Other">Other</option>
</select>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Service Type</label>
<select class="form-control" id="ship_via" name="ship_via">
<option value="Open Transport">Open Transport</option>
<option value="Enclosed Transport">Enclosed Transport</option>
</select>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Preffered Payment Method</label>
<select class="form-control" id="payment_method" name="payment_method">
<option value="Cash/Certified Fund">Cash/Certified Fund</option>
<option value="Check">Check</option>
</select>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label id="form_lbl">Payment Accepted</label>
<select class="form-control" id="payment_accepted" name="payment_accepted">
<option value="At Delivery">At Delivery</option>
<option value="At Pickup">At Pickup</option>
</select>
</div>
</div>

<div class="w-100">
<div class="form-group">
<label style="font-weight: 600; width: 100%; float: left;">Note to broker</label>
<textarea  class="form-control" name="note_to_broker" id="note_to_broker" maxlength="1500" placeholder="Note to broker" style="resize: none; max-height: 120px!important; height: 120px!important; min-height: 120px!important;"></textarea>
<small><b>Max:</b> 1500 characters</small>
</div>
</div>

<span style="float: left; width: 100%; margin-top: 0px;">
<button class="btn btn-secondary fright mt-10" id="action_bt" style="border-radius: 0px!important; margin-left: 0px;" onclick="submitQuote()">
<span class="icon_text">Submit Quote</span></button> 
</span>
                 
</div>
 
</div>
</div>
</div>
<!-- submit quote modal -->

<script src="templates/temp-app.js" type="text/javascript"></script> 
<script src="../../app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js" type="text/javascript"></script>
<script src="templates/listing-details.js?v=<?php echo $file_version;?>"></script>
<?php
}else{
    echo '<script type="text/javascript">window.location.href="#/find/any/any/any/any/list/location/1";</script>';  
}

}else{
    echo '<script type="text/javascript">window.location.href="#/find/any/any/any/any/list/location/1";</script>';  
}
?> 