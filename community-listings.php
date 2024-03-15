<?php
//$name from community.php 

if($noProperties>0){
                    
while($row = mysqli_fetch_array($pptyRslt)){
extract($row);
//'ListingId,ListingKeyNumeric,StandardStatus,PropertyAddress,StreetName,StreetNumber,StreetSuffix,StreetDirSuffix,StreetNumberNumeric,City,PostalCode,DefaultPic,ListPrice,BedroomsTotal,BathroomsFull,BathroomsTotalInteger,GarageSpaces,LivingArea';

$link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
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

if(in_array($MLSNumber, $favoritesArray)){
    $favDsply=' display: none;';
    $unfDsply=' display: inline-block;';
}else{ 
    $favDsply=' display: inline-block;';
    $unfDsply=' display: none;';  
}             

if($Status == 'Active'){
    $statusColor = '#009500';
    $badge = '';
}else if($Status == 'Sold'){
    $statusColor = 'red';
    $badge = '<div class="_exlio_125" style="background-color: #EA7500; color: white;">Sold</div>';
}else if($Status == 'Pending'){
    $statusColor = 'orange';
    $badge = '<div class="_exlio_125">Pending</div>';
}
?>


<div class="col-lg-6 col-md-6 col-sm-12 fleft pl-0 dsply_inline_blck">
<div class="match-height property-listing property-2">

<div class="listing-img-wrapper h-100">
	<?php echo $badge;?>
	<div class="list-img-slide">
		<div class="click">
            <?php
            if($AllPixList !=''){
            $ecPix = explode(',',$AllPixList);
            $pixCounter = 0;                                    
            foreach($ecPix as $pix){
                if($pix!='' && $pixCounter>0){
                ?>
				<div>
                <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
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
            <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>">
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
</div>

<div class="listing-detail-footer"> 
	<div class="w-100" id="listing_footer" style="left: 5px;">
		<div class="col-12 p-0 mt-5 mb-5 fleft dsply_inline_blck">
        
        <div class="col-3 fleft p-10 dsply_inline_blck" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
        <div class="btn fleft w-100" data-toggle="tooltip" title="Add To Favorites">
        <i class="ti-thumb-up"></i>
        </div>
        </div>
        
        <div class="col-3 fleft p-10 dsply_inline_blck" onclick="remFrmFav('<?php echo $MLSNumber;?>')" id="rem-frm-fav-<?php echo $MLSNumber;?>" style="<?php echo $unfDsply;?>">
        <div class="btn fleft w-100" style="background-color: #FF8484!important; color: white!important;" data-toggle="tooltip" title="Remove From Favorites">
        <i class="ti-thumb-down"></i>
        </div>
        </div>
        
        <div class="add_rem_loader_<?php echo $MLSNumber;?> col-3 centered-text fleft p-10" style="display: none;">
        <div class="btn fleft w-100"><img src="assets/img/loader.gif" class="float_none" style="width: 15px; height: 15px; cursor: pointer;" /></div>
        </div>
        
        <span class="col-3 fleft p-10 dsply_inline_blck" onclick="openGetInfo('<?php echo $MLSNumber;?>')">
        <div class="btn fleft w-100" data-toggle="tooltip" title="Get More Information">
        <i class="ti-email"></i>
        </div>
        </span>
        
        <span class="col-3 fleft p-10 dsply_inline_blck" onclick="openTourModal('<?php echo $MLSNumber;?>')">
        <div class="btn fleft w-100" data-toggle="tooltip" title="Schedule a Tour">
        <i class="ti-alarm-clock"></i>
        </div>
        </span>
        <span class="col-3 fleft p-10 dsply_inline_blck">
        <a href="homes-for-sale/<?php echo $MLSNumber;?>/<?php echo $link;?>" class="btn fleft w-100" data-toggle="tooltip" title="View Details">
        <i class="ti-eye"></i>
        </a>
        </span>
        </div>
	</div>
</div>

</div>
</div>
<?php
}

}else{
    
    if($property_type == 'homes'){
    echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/condos/price-asc/1";</script>';       
    }else if($property_type == 'condos'){
    echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/land/price-asc/1";</script>';     
    }else if($property_type == 'land'){
    echo '<script type="text/javascript">window.location.href="community/'.urldecode($name).'/sold/price-asc/1";</script>';     
    }else{
    echo '<div style="width: 100%; float: left; text-align: center; padding-top: 30px; padding-bottom: 30px;">
    Sorry, there are no results that match your search. Please try different search criteria..
    <div class="fleft w-100 mt-20 centered-text"><a href="mls-search" class="btn btn-primary">MLS Search</a></div>
    </div>';
    }

}
?>