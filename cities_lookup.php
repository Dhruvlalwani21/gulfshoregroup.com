<?php
require 'vendor/autoload.php';
include 'connect.php';
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(0);
 
if(isset($_POST['city'])){ 
     
     $city=$_POST['city'];
     
     $sqlCity="SELECT city_id, communities FROM cities WHERE name='$city'";   
     $cityRslt=mysqli_query($conn,$sqlCity) or die(mysqli_error($conn));
     $cityFound = mysqli_num_rows($cityRslt);
     
     if($cityFound>0){
       $row = mysqli_fetch_assoc($cityRslt);
       $city_id = $row['city_id'];
       $communities = $row['communities'];
       
       if($communities!=''){
        //72:Aquarius Naples,698:Country Club Of Naples,
        /**
        $explC = explode(',',$communities);
        
        foreach($explC as $comWtId){
            if($comWtId!=''){
                $expl_mr = explode(':',$comWtId);
                $commId = $expl_mr[0];
                $community = $expl_mr[1];
            }
        }
        **/
        
        $restlArray = array('data'=>'Done', 'communities'=>$communities);
        
       }else{
        $restlArray=array('data'=>'Error: no community found in this city.');
       }
       
       echo json_encode($restlArray);
       
     }else{
     $restlArray=array('data'=>'Error: unable to send message.');
     echo json_encode($restlArray);
     }
     
}else{
     $restlArray=array('data'=>'Error: missing required feild');
     echo json_encode($restlArray);
}
?>