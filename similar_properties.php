<?php
if(!$Development){
    $devToUse=$DevelopmentName;
}else{
    $devToUse=$Development;
}

$selFeatured = "SELECT matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, Status, SubCondoName, TotalArea, DefaultPic, AllPixList, other_fields_json FROM properties 
WHERE Status='Active' AND MLSNumber!='$MLSNumber' AND PropertyClass='$PropertyClass' AND (City='$City' OR Development='$devToUse' OR DevelopmentName='$devToUse') 
ORDER BY CASE WHEN Development LIKE '%$devToUse%' THEN 0  
                     WHEN DevelopmentName LIKE '%$devToUse%' THEN 1  
                     WHEN City LIKE '%$City%' THEN 2 
                     ELSE 3
                END, RAND() LIMIT 5";  
$ftrdRslts = mysqli_query($conn,$selFeatured);
$ftrdExst = mysqli_num_rows($ftrdRslts);

if($ftrdExst>0){
while($rowFtrd = mysqli_fetch_array($ftrdRslts)){
$sim_matrix_unique_id = $rowFtrd['matrix_unique_id'];
$sim_MLSNumber = $rowFtrd['MLSNumber'];
$sim_BathsTotal = $rowFtrd['BathsTotal'];
$sim_BedsTotal = $rowFtrd['BedsTotal'];
$sim_City = $rowFtrd['City'];
$sim_CurrentPrice= $rowFtrd['CurrentPrice'];
$sim_GarageSpaces = $rowFtrd['GarageSpaces'];
$sim_PropertyAddress = $rowFtrd['PropertyAddress'];
$sim_SubCondoName = $rowFtrd['SubCondoName'];
$sim_TotalArea = $rowFtrd['TotalArea'];
$sim_DefaultPic = $rowFtrd['DefaultPic'];
$sim_other_fields_json = $rowFtrd['other_fields_json'];

$otherFieldsJson = json_decode($sim_other_fields_json); 
$ListOfficeName = $otherFieldsJson->ListOfficeName;
$ListOfficePhone = $otherFieldsJson->ListOfficePhone;

$sm_link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $sim_PropertyAddress);
?>
<div class="sides_list_property no_radius shadow">
	<div class="sides_list_property_thumb">
        <a href="homes-for-sale/<?php echo $sim_MLSNumber;?>/<?php echo $sm_link;?>">
		<img src="<?php echo $sim_DefaultPic;?>" id="<?php echo $sim_MLSNumber;?>" alt="<?php echo $sim_PropertyAddress;?>" onerror="$(this).attr('src','https://via.placeholder.com/450x250.png?text=No+image+added+from+MLS')" class="img-fluid" alt="" />
        </a>
	</div>
	<div class="sides_list_property_detail">
		<h4 class="xs-fs-14"><a href="homes-for-sale/<?php echo $sim_MLSNumber;?>/<?php echo $sm_link;?>"><?php echo $sim_SubCondoName;?></a></h4>
		<span><i class="ti-location-pin"></i><?php echo $sim_PropertyAddress;?></span>
		<div class="lists_property_price">
			<div class="lists_property_types">
		    <?php echo number_format($sim_BedsTotal,0);?> Beds - <?php echo number_format($sim_BathsTotal,0);?> Baths
			</div>
			<div class="lists_property_price_value">
				<h4>$<?php echo number_format($sim_CurrentPrice,0);?></h4>
			</div>
		</div>
        <div class="w-100 fs-11 text-left">
        	<?php echo $ListOfficeName;?>
        </div>
	</div>
</div>
<?php
}
}
?>