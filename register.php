<?php
include 'connect.php';
require_once 'vendor/autoload.php';  
error_reporting(0);
ini_set('max_execution_time', 60); //60 seconds = 1 min 

function getRandomString($length){
$validCharacters = time()."234agHFS41GTFtyWioxVHVW1234635UUWYbsuy55wuTSffsf65265YS556567sfsftsfy676769snSKSSDfsffjstyscfJSTYDsyt".time();
$validCharNumber = strlen($validCharacters);
$result = ""; 

for ($i=0; $i<$length; $i++) {
    $index = mt_rand(0, $validCharNumber - 1);
    $result .= $validCharacters[$index];
}
return $result;
}

function sendMail($toEmail,$fullname,$token){
    $subject = "Welcome To ".WEBNAME.": Verify Your Email"; 
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
    <td align="center" style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:25px;font-weight:bold;padding:0px;padding-top: 40px;" >
    Welcome to '.WEBNAME.'
    </td>
    </tr>
    <tr>
    <td align="center" style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:normal;line-height:22px;padding:30px 5% 0px" >
    <p style="line-height:1.3em;">
    <h3 style="margin-bottom:.6em;text-align: center;font-weight: normal;">We\'re excited that you\'ve joined the team.</h3> 
    <br/>  
    <div style="text-align: center; width: 100%; max-width: 400px; text-align: center;"> 
    Verify your email to get fast response from our agents and enjoy full features of our website.
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
    <a href="'.WEBURL.'/verify-account.php?email='.$toEmail.'&token='.$token.'" 
    style="color:#ffffff;display:inline-block;font-family:\'Helvetica Neue\',arial;font-size:17px;font-weight:bold;line-height:46px;min-width:280px;max-width:280px;text-align:center;text-decoration:none">
    Verify &amp; Complete Registration</a></td>
    </tr>
    </tbody>
    </table>
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
    <a href="'.WEBURL.'/privacy">Privacy Policy</a> 
    | <a href="'.WEBURL.'/terms">Terms</a>&nbsp;<br>
    This email was sent to you by <a href="'.WEBURL.'">'.WEBNAME.'</a>.<br/>
    If you wish to unsubscribe from all future emails, <a href="'.WEBURL.'/unsubscribe-cro.php?email='.$toEmail.'" title="unsubscribe">please click here</a><br />
    <br>
    <span>MVP Realty</span>. | '.WEBADDRESS.'</span></span></td>
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
    </div>';  
    
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom(WEBMAIL, WEBNAME);
    $email->setSubject($subject);
    $email->addTo($toEmail, $fullname); 
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
 
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/       
    $restlArray=array('data'=>'Done'); 
    }else{
    /** insert into system reports notification **/ 
    /** keep emails in queue until problem is rectified **/ 
    $error=$response->body(); 
    $errors=json_decode($error);   
    $message=$errors->errors[0]->message;
    //$restlArray=array('data'=>"Error sending email: ".$message);     
    $restlArray=array('data'=>'Done'); /** success anyway no account verification **/  
    }    
    
    }catch (\Exception $e) { 
    /** insert into system reports notification **/ 
    /** keep emails in queue until problem is rectified **/  
    $message = $e->getMessage(); 
    //$restlArray=array('data'=>"Error sending email: ".$message);  
    $restlArray=array('data'=>'Done'); /** success anyway no account verification **/  
    } 
    
    echo json_encode($restlArray);     
}
 

if(isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password'])){ 

     $fullname=filterThis($_POST['fullname'], $conn); 
     $email=filterThis(strtolower($_POST['email']), $conn);
     $password=mysqli_real_escape_string($conn, $_POST['password']);  
     $passLen=strlen($password);
     $phone=filterThis($_POST['phone'], $conn);
     
     $checkEmail="SELECT email FROM users WHERE email='$email'"; 
     $EmailRslt=mysqli_query($conn,$checkEmail) or die(mysqli_error($conn));
     $EmailExist=mysqli_num_rows($EmailRslt); 
     
     $checkToken="SELECT token FROM reg_tokens WHERE email='$email'"; 
     $tokenRslt=mysqli_query($conn,$checkToken) or die(mysqli_error($conn));
     $tokenExist=mysqli_num_rows($tokenRslt);
    
     if($tokenExist>0){
      $rowTok=mysqli_fetch_array($tokenRslt); 
      $token=$rowTok['token']; /** use old **/
      $tokRslt=true; /** force to true **/
     }else{
      $token=getRandomString(50); /** generate new **/
      $addToken="INSERT INTO reg_tokens(email, token) VALUES('".$email."', '".$token."')";
      $tokRslt=mysqli_query($conn,$addToken) or die(mysqli_error($conn));
     }
     
     if($tokRslt){
       if($EmailExist<1){ 
        if($passLen>5){
        $date=date('Y-m-d H:i:s');
        $passwordEnc=hash("sha512", "dont_fuck_with_us!".$password);   
        
        $addUser="INSERT INTO users(fullname, email, password, phone_number, date_joined) VALUES('".$fullname."', '".$email."', '".$passwordEnc."', '".$phone."', '".$date."')";
        $addUserRslt=mysqli_query($conn,$addUser) or die(mysqli_error($conn));
        
        $cookie_name = 'mvprealy_uname';
        $cookie_pass = 'mvprealty_password';
        
        unset($_COOKIE[$cookie_name]);
        unset($_COOKIE[$cookie_pass]);
        session_destroy(); //cancel current login
        session_start();
    
        sendMail($email,$fullname,$token);  
         
        }else{
        $restlArray=array('data'=>'<b>Error:</b> password can\'t be less than 6 characters.'); 
        echo json_encode($restlArray);   
        }   
    }else{
    $restlArray=array('data'=>'<b>Error:</b> email is already in use.'); 
    echo json_encode($restlArray);      
    }
    
    }else{
    $restlArray=array('data'=>'Error: unable to create account...try again later.'); 
    echo json_encode($restlArray);  
    }
    
}else{
    $restlArray=array('data'=>'Missing Parameters'); 
    echo json_encode($restlArray);
}
?>