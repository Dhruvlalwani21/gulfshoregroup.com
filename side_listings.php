<div class="page-sidebar row p-0 no_radius" style="background-color: transparent!important; border: transparent!important;">
<?php
$selFeatured = "SELECT matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, MatrixModifiedDT, other_fields_json FROM properties WHERE Status='Active' AND ListPrice>0 AND (PropertyClass='RES' OR PropertyClass='RIN') ORDER BY RAND() LIMIT $silde_limit";  
$ftrdRslts = mysqli_query($conn,$selFeatured);
$ftrdExst = mysqli_num_rows($ftrdRslts);

if($ftrdExst>0){
$today = strtotime(date("Y-m-d"));
while($rowFtrd = mysqli_fetch_array($ftrdRslts)){
extract($rowFtrd);
$link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);

$otherFieldsJson = json_decode($other_fields_json); 
$ListOfficeName = $otherFieldsJson->ListOfficeName;
$ListOfficePhone = $otherFieldsJson->ListOfficePhone;
                    
if(!$BedsTotal){
$BedsTotal = '0';
}

if(!$BathsTotal){
$BathsTotal = '0';
}

if(!$Parking){
$Parking = '0';
}

$BathsTotal = str_replace('.00','',$BathsTotal);
$GarageSpaces = str_replace('.00','',$GarageSpaces);

$MxModifiedDT = strtotime($MatrixModifiedDT);
$hotDiff = $today - $MxModifiedDT;
$justListed = floor($hotDiff / ( 60 * 60 ));

if($justListed<=24){
    if($justListed<1){
        $domOut = 'New Hot';
    }else{
        $domOut = "New $justListed hours ago";
    }
    $domBadge = '<span class="_exlio_125 _list_blickes types shadow no_radius" style="background-color: #FFE2C6; color: #EA7500;"><i class="fas fa-fire"></i> &nbsp;'.$domOut.'</span>';
}else{
    $domBadge = '';
}   

if($Status == 'Active'){
$statusColor = '#009500';
$badge = $domBadge;
}else if($Status == 'Sold'){
$statusColor = 'red';
$badge = '<div class="_exlio_125" style="background-color: #EA7500; color: white;">Sold</div>';
}else if($Status == 'Pending'){
$statusColor = 'orange';
$badge = '<div class="_exlio_125">Pending</div>';
}
?>
<div class="w-100 col-lg-12 col-md-6 col-sm-12 xs-mb-15 sm-mb-15 dsply_inline_blck ">
<div class="match-height property-listing property-2">

<div class="listing-img-wrapper h-100">
	<?php echo $badge;?>
	<div class="list-img-slide">
		<div class="click">
            <?php
            if($AllPixList !=''){
            $ecPix = explode(',',$AllPixList);
            $counPix = count($ecPix);
            if($counPix>2){
                $gt = 0;
            }else{
                $gt = -1;
            }
            
            $pixCounter = 0;                                    
            foreach($ecPix as $pix){
                if($pix!='' && $pixCounter>$gt){
                ?>
				<div>
                <a href="javascript:;" data-href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                <img src="<?php echo $pix;?>" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto" alt="" />
                </a>
                </div>                                            
                <?php                                                                                   
                }
                $pixCounter++; 
            }
            }else{
            ?>
			<div>
            <a href="javascript:;" data-href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
            <img src="<?php echo $DefaultPic;?>" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto" alt="" />
            </a>
            </div>
            <?php
            }
            ?>
		</div>
	</div>
</div>

<div class="listing-detail-wrapper mt-1">
	<div class="listing-short-detail-wrap">
		<div class="_card_list_flex">
			<div class="_card_flex_01">
				<h4 class="listing-name verified">
                <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>" class="w-100 prt-link-detail">
                <div class="w-100"><?php echo $SubCondoName;?></div>
                <div class="w-100 fs-14 medium" style="color: #535353;"><?php echo $PropertyAddress;?></div>
                </a>
                </h4>
			</div>
		</div>
		<div class="_card_list_flex  mb-1">
			<div class="_card_flex_01">
				<h6 class="listing-card-info-price mb-0 p-0" style="color: #0076AE;">$<?php echo number_format($CurrentPrice,0);?></h6> 
			</div>
		</div>
	</div>
</div>

<div class="price-features-wrapper">
	<div class="list-fx-features">
		<div class="listing-card-info-icon">
			<div class="inc-fleat-icon"><img src="assets/img/bed.svg" width="13" alt="" /></div><?php echo $BedsTotal;?> Beds
		</div>
		<div class="listing-card-info-icon">
			<div class="inc-fleat-icon"><img src="assets/img/bathtub.svg" width="13" alt="" /></div><?php echo $BathsTotal;?> Baths
		</div>
		<div class="listing-card-info-icon">
			<div class="inc-fleat-icon"><img src="assets/img/car.svg" width="13" alt="" /></div><?php echo $GarageSpaces;?> Car Garage
		</div>
		<div class="listing-card-info-icon">
			<div class="inc-fleat-icon"><img src="assets/img/move.svg" width="13" alt="" /></div><?php echo number_format($TotalArea,0);?> sqft
		</div>
	</div>
    
    <div class="w-100 fs-11 text-left">
    	<?php echo $ListOfficeName;?>
    </div>
</div>
</div>
</div>
<?php
}
}
?>
</div>