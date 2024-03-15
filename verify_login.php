<?php
include 'connect.php'; 

if(isset($_POST['email'])){
    $email=filterThis($_POST['email'], $conn); 
    $password=filterThis($_POST['password'], $conn);
    $passwordEnc=hash("sha512", "dont_fuck_with_us!".$password); 
 
    $getUser="SELECT * FROM users WHERE email='$email' AND password='$passwordEnc'";
    $userRslt=mysqli_query($conn,$getUser) or die(mysqli_error($conn));
    $userExist=mysqli_num_rows($userRslt);
     
    if($userExist>0){ 
    $rowUser=mysqli_fetch_array($userRslt);
    extract($rowUser);
    
    if($status=='Active' || $status=='Inactive'){
    
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
    
    $_SESSION['user_id']=$user_id;
    $_SESSION['fullname']=$fullname;
    $_SESSION['phone_number']=$phone_number;
    $_SESSION['logged_email']=$email;
    $_SESSION['favorites']=$favorites;
    $_SESSION['fav_ids']=json_encode($favoritesArray);
    
    $last_login = date('Y-m-d H:i:s');
    $upUser="UPDATE users SET last_login='$last_login' WHERE user_id='$user_id'";
    $upUser=mysqli_query($conn,$upUser) or die(mysqli_error($conn));
    
    $restlArray=array(
    'data'=>"Done",
    'user_id'=>$user_id
    );
    //echo $response; 
    echo json_encode($restlArray);
    
    }else if($status=='Reset Password'){
    $restlArray=array('data'=>'You need to reset you password <br/>
    click <b>"Forgot password link"</b> below to receive reset link.');                   
    echo json_encode($restlArray); 
    
    }else if($status=='Disabled'){
    $restlArray=array('data'=>'Your account has been disabled. Please contact support.');                   
    echo json_encode($restlArray); 
    
    }else{
    $restlArray=array('data'=>'Fatal Error: '.$status);                   
    echo json_encode($restlArray); 
    }
     
    }else{
    $restlArray=array('data'=>'Wrong login details combination.');                   
    echo json_encode($restlArray); 
    }  
}else{
    $restlArray=array('data'=>'Fatal error');                   
    echo json_encode($restlArray); 
}
?>