<?php
include 'connect.php';
error_reporting(0); 

if(isset($_POST['email'])){ 
$email=filterThis($_POST["email"], $conn);

if(filter_var($email, FILTER_VALIDATE_EMAIL)){ /** valid emails **/
      
$sql="SELECT sub_id FROM subscriptions WHERE email='$email' AND news_letter='Yes' ";   
$savesRslt=mysqli_query($conn,$sql);  
$alreadySvd = mysqli_num_rows($savesRslt);  

if($alreadySvd<1){
  $addSub="INSERT INTO subscriptions(email,news_letter) VALUES('$email','Yes')";
  $addSubRslt=mysqli_query($conn,$addSub); 
} 

  $restlArray=array('data'=>'Done'); 
  echo json_encode($restlArray); 
 
}else{
$restlArray=array('data'=>'Error: provide a valid email'); 
echo json_encode($restlArray);      
}

}else{
$restlArray=array('data'=>'fatal error'); 
echo json_encode($restlArray);      
}
?>