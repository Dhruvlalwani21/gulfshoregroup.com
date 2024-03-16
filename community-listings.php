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



<div class="col-lg-6 col-md-6 col-sm-10 xs-mb-15 sm-mb-15 fleft dsply_inline_blck sm-float_none">
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
                                            $sgt = 0;
                                        }else{
                                            $sgt = -1;
                                        }
                                        
                                        $pixCounter = 0;                                    
                                        foreach($ecPix as $pix){
                                            if($pix!='' && $pixCounter>$sgt){
                                            ?>
                							<div>
                                            <a href="javascript:;" data-href="<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                            <img src="<?php echo $pix;?>" id="<?php echo $MLSNumber;?>" loading="lazy" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="" />
                                            </a>
                                                       <div class="card-img-overlay">
                                    <div class="btn fright like" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
                       <i class="fa-regular fa-thumbs-up"></i>
                                    </div>
                                    </div>
                                            </div>                                            
                                            <?php                                                                                   
                                            }    
                                            $pixCounter++; 
                                        }
                                        }else{
                                        ?>
            							<div>
                                        <a href="javascript:;" data-href="listings/<?php echo $MLSNumber;?>/<?php echo $link;?>">
                                        <img src="<?php echo $DefaultPic;?>" loading="lazy" id="<?php echo $MLSNumber;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid mx-auto card-img" alt="" />
                                        </a>
                                            <div class="card-img-overlay" >
                                    <div class="btn fright like" onclick="addToFav('<?php echo $MLSNumber;?>')" id="add-to-fav-<?php echo $MLSNumber;?>" style="<?php echo $favDsply;?>">
                       <i class="fa-regular fa-thumbs-up"></i>
                                    </div>
                                    </div>
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
                                            <a href="listings/<?php echo $MLSNumber;?>/<?php echo $link;?>" class="w-100 prt-link-detail">
                                            <div class="w-100"><?php echo $SubCondoName;?></div>
                                            <div class="w-100 fs-14 medium" style="color: #535353;"><i class="ti-location-pin"></i> <?php echo $PropertyAddress;?></div>
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
                                <div class=" w-100 fs-11 text-left">
      								<?php echo $ListOfficeName;?>
       							</div>
        					</div>
        					
        					<div class="listing-detail-footer"> 
        						<div class="w-100" id="listing_footer" style="left: 5px;">
            						<div class="p-0 mt-5 mb-2">
                                 
                                    <div class="add_rem_loader_<?php echo $MLSNumber;?> col-3 centered-text fleft p-10" style="display: none;">
                                    <div class="btn fleft w-100"><img src="assets/img/loader.gif" class="float_none" style="width: 15px; height: 15px; cursor: pointer;" /></div>
                                    </div>
                                    
                                    <span class="p-2" onclick="openGetInfo('<?php echo $MLSNumber;?>')">
                                    <a href="#" class="btn btn-primary btn-lg btn-block">Get Information</a>
                                    </span>
                                    
                                    <span class="p-2" onclick="openTourModal('<?php echo $MLSNumber;?>')">
          <a href="#" class="btn btn-primary btn-lg btn-block">Sechedule a Tour</a>
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