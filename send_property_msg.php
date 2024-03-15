<?php 
include 'connect.php';
require 'vendor/autoload.php';
ini_set('max_execution_time', 90); //90 seconds = 1 minute 30 seconds
error_reporting(0); 

function sendMail($conn,$uniq_id,$mail_from,$info_phone,$info_name,$info_message,$logged_email){
    
    
    $toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, TotalArea, PropertyType, PropertyInformation, DefaultPic';
    $sqlPpty = "SELECT $toSel FROM properties WHERE MLSNumber='$uniq_id'";
    $pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
    $pptyExist=mysqli_num_rows($pptyRslt);
    
    if($pptyExist>0){ 
    $row = mysqli_fetch_array($pptyRslt);
    extract($row);
    $link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
    
    $moreInfo=' <b>SqFt Total: </b>'.$TotalArea.' SqFt<br/>  
                <b>Beds: </b>'.$BedsTotal.'<br/> 
                <b>Baths: </b>'.$BathsTotal.'<br/>
                <b>Garages: </b>'.$GarageSpaces.'<br/>'; 
    
    $subject = "New Message About Property With Listing Id#".$uniq_id; 
    $emailBody ='<table cellspacing="0" cellpadding="0" border="0" bgcolor="white" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody>
    
    <table align="center" width="600" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:20px 0;text-align:left;padding-bottom:20px">
    <tbody><tr>
    <td align="center">
    <img src="'.WEBURL.'/'.$DefaultPic.'" alt="MVP Realty"  style="border:0;outline:none; width: 100%; height: auto; text-decoration:none" class="CToWUd">
    </td>
    </tr>
    </tbody>
    </table>
    
    <tr>
    <td width="92%">  
    <table align="center" width="600" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody> 
    <tr>
    <td>  
    
    <p style="line-height: 1.5em;">
      
    <div style="text-align: center; width: 100%; text-align: left; line-height: 1.5em;">  
    <b>Property MLS Number: </b>#'.$uniq_id.'<br/> 
    <b>Property Type: </b>'.$PropertyType.'<br/>  
    '.$moreInfo.' 
    <b>Price: </b>$'.number_format($CurrentPrice,0).'<br/>   
    <b>Location: </b>'.$PropertyAddress.' <br/>  
    <b>Link: </b><a href="'.WEBURL.'/homes-for-sale/'.$uniq_id.'/'.$link.'">view property</a><br/> 
    <b>Description: </b>'.$PropertyInformation.'<br/> 
    <br /> 
    <hr style="background:#e4e6e9;color:#e4e6e9;font-size:1px;height:1px;border:0">
    <br />
    <b>Contact Name: </b>'.$info_name.'<br/> 
    <b>Contact Email: </b>'.$mail_from.'<br/> 
    <b>Contact Phone: </b>'.$info_phone.'<br/> 
    <b>Message: </b>'.$info_message.'<br/> 
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
    $email->setFrom(WEBMAIL, 'New Property Message');
    $email->setSubject($subject);
    $email->addTo(WEBMAILRCVR, WEBNAME);
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
 
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/ 
    $restlArray=array('data'=>'Done'); 
    }else{ 
    $error=$response->body(); 
    $errors=json_decode($error);   
    $message=$errors->errors[0]->message;
    $restlArray=array('data'=>"Error sending email: ".$message);      
    }    
    
    }catch (\Exception $e) {  
    $message = $e->getMessage(); 
    $restlArray=array('data'=>"Error sending email: ".$message);   
    } 
    
    }else{
     $restlArray=array('data'=>"Not Found $uniq_id");
    }
    echo json_encode($restlArray); 
}


if(isset($_POST['email']) && isset($_POST['uniq_id']) && isset($_POST['info_message'])){ 

     $uniq_id=filterThis($_POST['uniq_id'], $conn); 
     $email=filterThis(strtolower($_POST['email']), $conn);  
     $info_name=filterThis($_POST['name'], $conn);  
     $info_phone=filterThis($_POST['info_phone'], $conn); 
     $info_message=filterThis($_POST['info_message'], $conn); 
     $logged_email=$_POST['logged_email'];  
 
     $sql="SELECT user_id FROM users WHERE email='$logged_email' ";  
     $rslt=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
     $userExist=mysqli_num_rows($rslt);
    
     if($userExist>0){
     $row = mysqli_fetch_array($rslt);
     $user_id = $row['user_id'];
     $date = date("Y-m-d H:i:s");
     
     $save="INSERT INTO get_info(user_id, email, phone, name, ListingId, message, date) VALUES('$user_id','$email','$info_phone','$info_name','$uniq_id','$info_message','$date')";
     $saveRslt=mysqli_query($conn,$save);
     if($saveRslt){
     sendMail($conn,$uniq_id,$email,$info_phone,$info_name,$info_message,$logged_email);    
     }else{
     $restlArray=array('data'=>"Error: unable to add request."); 
     echo json_encode($restlArray);  
     }
     
     }else{
     sendMail($conn,$uniq_id,$email,$info_phone,$info_name,$info_message,$logged_email);  
     }
}
?>