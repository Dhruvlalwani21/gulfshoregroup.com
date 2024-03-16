<?php
include 'connect.php';

if(isset($_GET['slug'])){
$slug = $_GET['slug'];


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
}
}
?>