<?php
include 'connect.php'; 
require_once 'vendor/autoload.php';  
error_reporting(0);
ini_set('max_execution_time', 60); //60 seconds = 1 min 

function getRandomString($length){
$validCharacters = "234agHFS41GTFtyWioxVHVW1234635UUWYbsuy55wuTSffsf65265YS556567sfsftsfy676769snSKSSDfsffjstyscfJSTYDsyt";
$validCharNumber = strlen($validCharacters);
$result = ""; 

for ($i=0; $i<$length; $i++) {
    $index = mt_rand(0, $validCharNumber - 1);
    $result .= $validCharacters[$index];
}
return $result;
}

if(isset($_POST['account_email'])){ 
$account_email=$_POST['account_email']; 

$checkEmail="SELECT status, fullname FROM users WHERE email='".$account_email."' ";
$checkEmailRslt=mysqli_query($conn,$checkEmail) or die(mysqli_error($conn));
$userExist=mysqli_num_rows($checkEmailRslt);
$row=mysqli_fetch_array($checkEmailRslt); 
$status=$row['status'];
$fullname=$row['fullname'];
//reset_tokens
if($userExist>0){
if(($status=="Active") || ($status=="Inactive") || ($status=="Reset Password")){
    
    $getToken="SELECT token FROM reset_tokens WHERE email='".$account_email."' AND token!=''";
    $tokRslt=mysqli_query($conn,$getToken) or die(mysqli_error());
    $tokenExist=mysqli_num_rows($tokRslt);
    $rowT=mysqli_fetch_array($tokRslt);
    $rst_token=$rowT['token'];
    
    if($tokenExist>0){
     $token=$rst_token;   
    }else{
     $token=getRandomString(55); 
     $addToken="INSERT INTO reset_tokens(email, token) VALUES('".$account_email."', '".$token."')";
     $tokRslt=mysqli_query($conn,$addToken) or die(mysqli_error($conn));   
    }           
       
    $subject = "".WEBNAME." Password Reset Request";
    $emailBody ='
    <div style="font-family:Helvetica Light,Helvetica,Arial,sans-serif;margin:0;padding:0; width:100%" bgcolor="#eeeeee">  

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
    <tbody><tr>
    <td bgcolor="#eeeeee" align="center" style="padding:25px" >
    
    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:600px" >
    <tbody><tr>
    <td>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tbody>
    <tr>
    <td>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tbody>
    
    <tr>
    <td align="center" style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:18px;font-weight:bold;padding:0px;padding-top: 40px;" >
    <img src="'.WEBLOGO.'" alt="First1 logo" width="200" height="45" />
    </td>
    </tr>
    
    <tr>
    <td align="center" style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:normal;line-height:22px;padding:30px 5% 0px" >
    <p style="line-height:1.3em;">
    <div style="text-align: center; width: 100%; max-width: 500px; text-align: center;"> 
    We received a request to reset your password on '.WEBNAME.'. Simply click the button below to set a new password.
    </div>
    </p>
    </td>
    </tr>
            
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20"></td>
    </tr>
     
    
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20"></td>
    </tr>
    
    
    
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="1" style="padding:0px 30px">
    <table cellpadding="0" cellspacing="0" width="30%" style="border-collapse:collapse">
    <tbody><tr>
    <td style="border-top-color:#eeeeee;border-top-style:solid;border-top-width:1px;padding:0px 30px"></td>
    <td>
    </td>
    </tr>
    </tbody></table>
    </td>
    </tr>
    
     
    </tbody></table>
    </td>
    </tr>
     
    
    
    <tr>
    <td>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    
    <tbody>  
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20"></td>
    </tr>
    
    
    
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="1" style="padding:0px 30px">
    <table cellpadding="0" cellspacing="0" width="300" height="46" style="border-collapse:collapse">
    
    <tbody><tr>
    <td bgcolor="#2ccae7" height="46" align="center" style="border-radius:2px;">
    <a href="'.WEBURL.'/reset-password.php?email='.$account_email.'&token='.$token.'" 
    style="color:#ffffff;display:inline-block;font-family:\'Helvetica Neue\',arial;font-size:17px;font-weight:bold;line-height:46px;min-width:280px;max-width:280px;text-align:center;text-decoration:none">
    Set New Password</a>
        
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
     
    
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20">
    <br>
    <br> 
    
    <center>
    <p style="line-height:1.3em;color:black;max-width: 450px;"><strong>If you didn\'t ask to change your password, <br/>Please contact us immediately.</strong></p>              
    </center>
    </td>
    </tr>
    
    
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20"></td>
    </tr>
    <tr>
    <td width="100%" align="center" valign="top" bgcolor="#ffffff" height="20"></td>
    </tr>
    </tbody></table>
    </td>
    </tr>
     
    
    <tr>
    <td align="center" valign="top" style="font-size:0" >
    
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr> 
    
    <tr>
    <td bgcolor="#eeeeee" align="center" style="padding:20px 0px">
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;max-width:600px" >
    <tbody><tr>
    <td align="center" style="color:#818181;font-family:\'Helvetica Light\',\'Helvetica\',Arial,sans-serif;font-size:12px;line-height:1.5;padding-top:5px">
    
    <table style="border-collapse:collapse;text-align:center;width:100%;">
    <tbody>
    <tr>
    <td style="color:#535353;font-size:10px;line-height:16px;padding-bottom:20px;padding-left: 15px;padding-right: 15px;" align="center"><span style="font-size:12px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">
    <a href="'.WEBURL.'/privacy.php">Privacy Policy</a> 
    | <a href="'.WEBURL.'/terms.php">Terms</a>&nbsp;<br>
    This email was sent to you by <a href="'.WEBURL.'">'.WEBNAME.'</a>.<br/>
    If you wish to unsubscribe from all future emails, <a href="'.WEBURL.'/unsubscribe-cro.php?email='.$account_email.'" title="unsubscribe">please click here</a><br />
    <br>
    <span>'.WEBNAME.'</span>. | '.WEBADDRESS.'</span></span></td>
    </tr>
    </tbody>
    </table>
    <br>
    <br>
    &nbsp;
    </td>
    </tr>
    </tbody></table>
    
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>';    
    
        
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom(WEBMAIL, WEBNAME);
    $email->setSubject($subject);
    $email->addTo($account_email, $fullname); 
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
 
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/       
    $upAccnt="UPDATE users SET status='Reset Password' WHERE email='".$account_email."' ";
    $upRslt=mysqli_query($conn,$upAccnt) or die(mysqli_error($conn)); 
    
    $cookie_name = 'mvprealy_uname';
    $cookie_pass = 'mvprealy_password';
    
    unset($_COOKIE[$cookie_name]);
    unset($_COOKIE[$cookie_pass]);
    session_destroy(); //cancel current login

    $restlArray=array('data'=>"Password reset link sent to your email.");

    }else{
    /** insert into system reports notification **/ 
    /** keep emails in queue until problem is rectified **/ 
    $error=$response->body(); 
    $errors=json_decode($error);   
    $message=$errors->errors[0]->message;
    $restlArray=array('data'=>"Error sending email: ".$message);      
    }    
    
    }catch (\Exception $e) { 
    /** insert into system reports notification **/ 
    /** keep emails in queue until problem is rectified **/  
    $message = $e->getMessage(); 
    $restlArray=array('data'=>"Error sending email: ".$message);   
    } 
    
    echo json_encode($restlArray);

        
}else{
$restlArray=array('data'=>"<b>Error:</b> account is not active. Please contact support."); 
echo json_encode($restlArray);
}

}else{
$restlArray=array('data'=>"<b>Error:</b> email is not associated with any account."); 
echo json_encode($restlArray);   
}

}else{
$restlArray=array('data'=>"Fatal Error"); 
echo json_encode($restlArray);
}
?>