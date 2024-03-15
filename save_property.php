<?php
require 'vendor/autoload.php';
include 'connect.php';
error_reporting(0); 
    
function sendMail($conn,$email,$fullname,$property_id,$no_saved){
    
    $to_sel="listing_id, ListingId, total_bedrooms, baths_full, total_bedrooms, city, default_image, list_price, mls_number, flexmls_listing_id, garage_spaces, property_type, public_remarks, sq_ft_total, area, street_number, street_name, street_suffix";  
    $sql = "SELECT $to_sel FROM listings WHERE ListingId='$property_id' ";  
    $rs=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
    $pptyExist=mysqli_num_rows($rs);
    
    if($pptyExist>0){ 
    $row = mysqli_fetch_array($rs);
    $listing_id=$row["listing_id"];
    $ListingId=$row["ListingId"];   
    $beds_total=$row["total_bedrooms"]; 
    $baths_total=$row["total_bedrooms"];
    $default_image=$row["default_image"]; 
    $list_price=$row["list_price"];
    $mls_number=$row["mls_number"];
    $flexmls_listing_id=$row["flexmls_listing_id"];
    $garages_number=$row["garage_spaces"];  
    $property_type=$row["property_type"];  
    $remarks=$row["public_remarks"]; 
    $sq_ft_total=$row["sq_ft_total"];   
    $area=$row["area"];  
    $street_number=$row["street_number"];  
    $street_name=$row["street_name"];   
    $street_suffix=$row["street_suffix"];
    $city=$row["city"];  
    
    $moreInfo=' <b>SqFt Total: </b>'.$sq_ft_total.' SqFt<br/>  
                <b>Beds: </b>'.$beds_total.'<br/> 
                <b>Baths: </b>'.$baths_total.'<br/>
                <b>Garages: </b>'.$garages_number.'<br/>'; 
    
    $subject = "New Property Saved"; 
    $emailBody ='<table cellspacing="0" cellpadding="0" border="0" bgcolor="white" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:0;text-align:left;padding-bottom:20px">
    <tbody>
    
    <table align="center" width="600" style="color:#5e6670;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:1.25em;background-color:white;padding:20px 0;text-align:left;padding-bottom:20px">
    <tbody><tr>
    <td align="center">
    <img src="'.$default_image.'" alt="cronetic"  style="border:0;outline:none; width: 100%; height: auto; text-decoration:none" class="CToWUd">
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
    <b>Property MLS ID: </b>#'.$flexmls_listing_id.'<br/> 
    <b>Property Type: </b>'.$pptyType.'<br/>  
    '.$moreInfo.' 
    <b>Price: </b>$'.number_format($list_price,2).'<br/>   
    <b>Location: </b>'.$street_name.', '.$city.', '.$area.' '.$street_suffix.'<br/>  
    <b>Linkasasas: </b><a href="https://realtorrefund.com/property-details.php?id='.$uniq_id.'">view property</a><br/> 
    <b>Description: </b>'.$remarks.'<br/> 
    <br /> 
    <hr style="background:#e4e6e9;color:#e4e6e9;font-size:1px;height:1px;border:0">
    <br />
    <b>Contact Name: </b>'.$info_name.'<br/> 
    <b>Contact Email: </b>'.$mail_to.'<br/> 
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
    $email->setFrom($mail_to, $info_name);
    $email->setSubject($subject);
    $email->addTo('adebayoishola01@gmail.com', 'Coole Home');
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid('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');
 
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
     $restlArray=array('data'=>"Not Found");
    }
    echo json_encode($restlArray); 
}


if(isset($_POST['type'])){ 
$email=$_POST["email"];
$type=$_POST["type"];
$MLSNumber=$_POST["unique_id"];  

if(filter_var($email, FILTER_VALIDATE_EMAIL)){ /** valid emails **/

$query ="SELECT user_id, fullname, email FROM users WHERE email='$email' "; 
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$accExt=mysqli_num_rows($result);   
if($accExt>0){
$rowU = mysqli_fetch_array($result);
$fullname=$rowU["fullname"];
$user_id=$rowU["user_id"];  
      
$sql="SELECT save_id FROM saves WHERE email='$email' AND MLSNumber='$MLSNumber' ";   
$savesRslt=mysqli_query($conn,$sql);  
$alreadySvd = mysqli_num_rows($savesRslt);  

if($type=="add"){ 
  if($alreadySvd<1){
  $savePpty="INSERT INTO saves(user_id,email,MLSNumber) VALUES('$user_id','$email','$MLSNumber')";
  $savePptyRslt=mysqli_query($conn,$savePpty);  
  
  //sendMail($conn,$email,$fullname,$MLSNumber,$no_saved);  
  } 
  
  $checkFavs = "SELECT MLSNumber FROM saves WHERE email='$email' AND MLSNumber!='' ";
  $favRslt = mysqli_query($conn,$checkFavs) or die(mysqli_error($conn));
  $favorites = mysqli_num_rows($favRslt);  
  $favoritesArray=array();

  if($favorites>0){
  while($row=mysqli_fetch_array($favRslt)){
  extract($row);

  array_push($favoritesArray,$MLSNumber);
  }
  }else{
  array_push($favoritesArray,"No Favs");   
  }

  $_SESSION['favorites']=$favorites;
  $_SESSION['fav_ids']=json_encode($favoritesArray);

  $restlArray=array('data'=>'Done',
                    'no_saved'=>$favorites); 
  echo json_encode($restlArray); 
  
}else{
  $delPpty="DELETE FROM saves WHERE email='$email' AND MLSNumber='$MLSNumber'";
  $delPptyRslt=mysqli_query($conn,$delPpty);  
  
  $checkFavs = "SELECT MLSNumber FROM saves WHERE email='$email' AND MLSNumber!='' ";
  $favRslt = mysqli_query($conn,$checkFavs) or die(mysqli_error($conn));
  $favorites = mysqli_num_rows($favRslt);  
  $favoritesArray=array();

  if($favorites>0){
  while($row=mysqli_fetch_array($favRslt)){
  extract($row);

  array_push($favoritesArray,$MLSNumber);
  }
  }else{
  array_push($favoritesArray,"No Favs");   
  }

  $_SESSION['favorites']=$favorites;
  $_SESSION['fav_ids']=json_encode($favoritesArray); 

  $restlArray=array('data'=>'Done',
                    'no_saved'=>$favorites); 
  echo json_encode($restlArray);
}



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