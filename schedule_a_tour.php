<?php
require 'vendor/autoload.php';
include 'connect.php';
error_reporting(0); 
    
function sendMail($conn,$logged_email,$mail_to,$MLSNumber,$name,$tour_phone,$move_in_date,$tour_date,$tour_time){
    
    
    $toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, TotalArea, PropertyType, PropertyInformation, DefaultPic';
    $sqlPpty = "SELECT $toSel FROM properties WHERE MLSNumber='$MLSNumber'";
    $pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
    $pptyExist=mysqli_num_rows($pptyRslt);
    
    if($pptyExist>0){ 
    $row = mysqli_fetch_array($pptyRslt);
    extract($row);
    $link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
    
    $moreInfo=' <b>SqFt Total: </b>'.$sq_ft_total.' SqFt<br/>  
                <b>Beds: </b>'.$beds_total.'<br/> 
                <b>Baths: </b>'.$baths_total.'<br/>
                <b>Garages: </b>'.$garages_number.'<br/>'; 
    
    $subject = "New Tour Scheduled For Listing #".$MLSNumber; 
    $emailBody ='<table cellspacing="0" cellpadding="0" border="0" bgcolor="white" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody>
    
    <table align="center" width="600" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:20px 0;text-align:left;padding-bottom:20px">
    <tbody><tr>
    <td align="center">
    <img src="'.WEBURL.'/'.$default_image.'" alt="MVP Realty"  style="border:0;outline:none; width: 100%; height: auto; text-decoration:none" class="CToWUd">
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
    <b>Property MLS Number: </b>#'.$MLSNumber.'<br/> 
    <b>Property Type: </b>'.$PropertyType.'<br/>  
    '.$moreInfo.' 
    <b>Price: </b>$'.number_format($CurrentPrice,0).'<br/>   
    <b>Location: </b>'.$PropertyAddress.' <br/>  
    <b>Link: </b><a href="'.WEBURL.'/homes-for-sale/'.$MLSNumber.'/'.$link.'">view property</a><br/> 
    <b>Description: </b>'.$PropertyInformation.'<br/> 
    <br /> 
    <hr style="background:#e4e6e9;color:#e4e6e9;font-size:1px;height:1px;border:0">
    <br />
    <b>Tour Details</b><br/>
    <b>Full Name: </b>'.$name.'<br/> 
    <b>Contact Phone: </b>'.$tour_phone.'<br/> 
    <b>Move In Date: </b>'.$move_in_date.'<br/> 
    <b>Tour Date: </b>'.$tour_date.'<br/> 
    <b>Tour Time: </b>'.$tour_time.'<br/> 
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
    $email->setFrom(WEBMAIL,"Tour Scheduler");  /** adebayoishola01@gmail.com, questions@coolehome.com**/
    $email->setSubject($subject);
    $email->addTo(WEBMAILRCVR, WEBNAME); //WEBMAIL
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
 
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/  
  
    $selTours="SELECT tour_id FROM tour WHERE email='$logged_email'";
    $tourRslt=mysqli_query($conn,$selTours) or die(mysqli_error($conn));
    $tours=mysqli_num_rows($tourRslt);  
    $_SESSION['tours']=$tours;
  
    $restlArray=array('data'=>'Done', 'no_tour'=>$tours); 
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
     $restlArray=array('data'=>"Not Found");
    }
    echo json_encode($restlArray); 
}


if(isset($_POST['uniq_id'])){ 
$logged_email=$_POST["logged_email"];
$MLSNumber=$_POST["uniq_id"];  
$name=$_POST["name"];  
$email=$_POST["email"];  
$tour_phone=$_POST["tour_phone"];  
$move_in_date=$_POST["move_in_date"];  
$tour_date=$_POST["tour_date"];  
$tour_time=$_POST["tour_time"]; 
$tourDate = str_replace('-','/',$tour_date); 
$tourDate = date("Y-m-d", strtotime($tourDate));

if(filter_var($logged_email, FILTER_VALIDATE_EMAIL)){ /** valid emails **/

$query ="SELECT user_id FROM users WHERE email='$logged_email' "; 
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$accExt=mysqli_num_rows($result);   
if($accExt>0){
$rowU = mysqli_fetch_array($result);
$user_id=$rowU["user_id"];  

$sqlDel="DELETE FROM tour WHERE email='$email' AND MLSNumber='$MLSNumber' ";   
$delRslt=mysqli_query($conn,$sqlDel);  

$date = date("Y-m-d H:i:s");
   
$addTour="INSERT INTO tour(user_id, email, MLSNumber, name, phone, move_in_date, tour_date, tour_time, date_added) VALUES('$user_id','$email','$MLSNumber', '$name', '$tour_phone', '$move_in_date', '$tourDate', '$tour_time', '$date')";
$addTourRslt=mysqli_query($conn,$addTour);  

sendMail($conn,$logged_email,$email,$MLSNumber,$name,$tour_phone,$move_in_date,$tour_date,$tour_time);

}else{
$restlArray=array('data'=>'Error: Account not valid'); 
echo json_encode($restlArray);      
}

}else{
$restlArray=array('data'=>'Error: login with a valid email'); 
echo json_encode($restlArray);      
}

}else{
$restlArray=array('data'=>'fatal error'); 
echo json_encode($restlArray);      
}
?>