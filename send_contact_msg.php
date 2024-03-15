<?php
require 'vendor/autoload.php';
include 'connect.php';
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(0); 

function sendMail($usr_email,$phone,$name,$subject,$msgBody){
    
    if(!$subject){
    $subject = WEBNAME." Contact Message";
    }
    
    $emailBody ='<table cellspacing="0" cellpadding="0" border="0" bgcolor="white" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody>
     
    
    <tr>
    <td width="92%">  
    <table align="center" width="600" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody> 
    <tr>
    <td>  
    
    <p style="line-height: 1.5em;"> 
    <b>Contact Name: </b>'.$name.'<br/> 
    <b>Contact Email: </b>'.$usr_email.'<br/> 
    <b>Contact Phone: </b>'.$phone.'<br/>  
    <b>Subject: </b>'.$subject.'<br/> 
    <b>Message: </b>'.$msgBody.'
    </div>
    </p>
     
    <br>
    <br> 
    <br />
    <br /> 
    </td>
    </tr>
        
    </tbody>
    </table>
     
    </td>
    </tr>
    </tbody>
    </table>'; 
    
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom(WEBMAIL, "New Contact Message From $name");
    $email->setSubject($subject);
    $email->addTo(WEBMAILRCVR, WEBNAME); 
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
    
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/   
    $restlArray=array('data'=>"Done"); 
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
    
    
    /**
    require 'PHPMailer/PHPMailerAutoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    $mail->ContentType = 'text/html'; 
    $mail->IsHTML(true); 
    
    //Set who the message is to be sent from
    $mail->setFrom($usr_email, $name); 
    //Set who the message is to be sent to
    $mail->addAddress('info@coolehome.org', 'Coole Home'); /** adebayoishola01@gmail.com, info@coolehome.com ** /
    //Set the subject line
    $mail->Subject = $subject;
    //Replace the plain text body with one created manually
    $mail->Body = $emailBody; 
    
    //send the message, check for errors
    if(!$mail->send()){ 
        $message = $mail->ErrorInfo;    
        $restlArray=array('data'=>"Error sending email: ".$message); 
        
    }else{
        $restlArray=array('data'=>'Done');  
    }
    
    echo json_encode($restlArray); 
    **/ 
}
 
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['message'])){ 
     
     $name=$_POST['name']; 
     $email=strtolower($_POST['email']);
     $phone=strtolower($_POST['phone']);
     $subject=$_POST['subject'];
     $msgBody=nl2br($_POST['message']);
     
     $ins_name = filterThis($_POST['name'], $conn);
     $ins_email = filterThis($_POST['email'], $conn);
     $ins_phone = filterThis($_POST['phone'], $conn);
     $ins_subject = filterThis($_POST['subject'], $conn);
     $ins_msgBody = filterThis($_POST['message'], $conn);
     $date = date("Y-m-d H:i:s");
     
     $addMsg="INSERT INTO contact_message(fullname, email, phone, subject, message, date) VALUES('$ins_name', '$ins_email', '$ins_phone', '$ins_subject', '$ins_msgBody', '$date')";   
     $msgRslt=mysqli_query($conn,$addMsg) or die(mysqli_error($conn));
     
     if($msgRslt){
     sendMail($email,$phone,$name,$subject,$msgBody);   
     }else{
     $restlArray=array('data'=>'Error: unable to send message.');
     echo json_encode($restlArray);
     }
     
}else{
     $restlArray=array('data'=>'Error: missing required feild');
     echo json_encode($restlArray);
}
?>