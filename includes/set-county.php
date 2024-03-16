<?php

//http://local.officere.com/set-county.php

$county = 'Alachua,
Baker,
Bay,
Bradford,
Brevard,
Broward,
Calhoun,
Charlotte,
Citrus,
Clay,
Collier,
Columbia,
Desoto,
Dixie,
Duval,
Escambia,
Flagler,
Franklin,
Gadsden,
Gilchrist,
Glades,
Gulf,
Hamilton,
Hardee,
Hendry,
Hernando,
Highlands,
Hillsborough,
Holmes,
Indian River,
Jackson,
Jefferson,
Lafayette,
Lake,
Lee,
Leon,
Levy,
Liberty,
Madison,
Manatee,
Marion,
Martin,
Miami-Dade,
Monroe,
Nassau,
Okaloosa,
Okeechobee,
Orange,
Osceola,
Other,
Palm Beach,
Pasco,
Pinellas,
Polk,
Putnam,
Santa Rosa,
Sarasota,
Seminole,
St. Johns,
St. Lucie,
Sumter,
Suwannee,
Taylor,
Union,
Volusia,
Wakulla,
Walton,
Washington';


$expld = explode(",",$county);

$options = "";
foreach($expld as $val){
    $val = trim($val);
    $val = ucwords(strtolower($val));
    if($val !=""){
        $options .= '<option value="'.$val.'">'.$val.'</option>';
    }
}
?>

<select>
<?php echo $options;?>
</select>