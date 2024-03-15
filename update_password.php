<?php 
include 'connect.php';  

if(isset($_POST['account_email']) && isset($_POST['token']) && isset($_POST['password'])){ 

    $account_email=filterThis($_POST['account_email'], $conn);
    $token=filterThis($_POST['token'], $conn);
    $password=htmlspecialchars($_POST['password']); 
    $password=mysqli_real_escape_string($conn, $password); 
    $passLen=strlen($password);
    $password=hash("sha512", "dont_fuck_with_us!".$password);
    
    $checkEmail="SELECT password FROM users WHERE email='".$account_email."' ";
    $checkEmailRslt=mysqli_query($conn,$checkEmail) or die(mysqli_error($conn));
    $userExist=mysqli_num_rows($checkEmailRslt); 
    $row=mysqli_fetch_array($checkEmailRslt); 
    $pw=$row['password'];
        
    $getToken="SELECT token FROM reset_tokens WHERE email='".$account_email."' AND token='$token'";
    $tokRslt=mysqli_query($conn,$getToken) or die(mysqli_error());
    $tokenExist=mysqli_num_rows($tokRslt); 
    
    if($tokenExist>0){
    if($userExist>0){
    if($passLen>5){    
    if($pw!=$password){   
    
    $up="UPDATE users SET password='$password', status='Active' WHERE email='$account_email'";
    $upRslt=mysqli_query($conn,$up) or die(mysqli_error($conn));
 
    if($upRslt){  
    $delToken="DELETE FROM reset_tokens WHERE email='".$account_email."'"; //del previous tokens
    $delRslt=mysqli_query($conn,$delToken) or die(mysqli_error());
    
    $restlArray=array('data'=>"Password updated succesfully.");   
    }else{
    $restlArray=array('data'=>'<b>Error:</b> unable to reset your password...try again');
    }   
    }else{
    $restlArray=array('data'=>'<b>Notice:</b> new password must be different from old one.');  
    }
    
    echo json_encode($restlArray); 
    
    }else{
    $restlArray=array('data'=>'<b>Error:</b> password can\'t be less than 6 characters.'); 
    echo json_encode($restlArray);  
    } 
    }else{
    $restlArray=array('data'=>'<b>Error:</b> account not found.'); 
    echo json_encode($restlArray);  
    }
    
    }else{
    $restlArray=array('data'=>'<b>Error:</b> invalid token.'); 
    echo json_encode($restlArray);  
    } 
}else{
$restlArray=array('data'=>'Fatal error'); 
echo json_encode($restlArray);  
}
?>