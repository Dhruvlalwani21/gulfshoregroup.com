<?php
include 'connect.php';
error_reporting(0);

if(isset($_POST['user_id']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['phone'])){ 
     
$user_id=filterThis($_POST['user_id'], $conn);
$fullname=filterThis($_POST['fullname'], $conn);
$last_name=filterThis($_POST['last_name'], $conn);
$email=trim(strtolower($_POST['email']));
$phone=filterThis($_POST['phone'], $conn);

$userSQL="SELECT email FROM users WHERE email='$email' AND user_id!='$user_id' ";
$userRst=mysqli_query($conn,$userSQL); 
$userExist=mysqli_num_rows($userRst);
if($userExist>0){
$restlArray=array('data'=>'Email is associated with another account...Try different email.');  
echo json_encode($restlArray);
exit();   
} 

$up="UPDATE users SET fullname='$fullname', email='$email', phone_number='$phone' WHERE user_id='$user_id'";
$upRslt=mysqli_query($conn,$up) or die(mysqli_error($conn)); 
 
if($upRslt){
    
    $_SESSION['fullname'] = $fullname;
    $_SESSION['phone_number'] = $phone;
    $_SESSION['logged_email'] = $email;
    $restlArray=array('data'=>'Done'); 
}else{
 $restlArray=array('data'=>mysqli_error($conn));   
}
echo json_encode($restlArray);  
}else{
$restlArray=array('data'=>'fatal error'); 
echo json_encode($restlArray);    
}
?>