<?php
session_start();
define('APPVERSION', '1.22');
define('SENDGRID', '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');
define('WEBNAME', 'Gulf Shore Groups');
define('WEBLOGO', 'http://gulfshoregroup.com/assets/img/first1-main-logo.png');
define('WEBLOGOALT', 'http://gulfshoregroup.com/assets/img/first1-alt-logo.png');
define('WEBMAIL', 'messages@first1.us');
define('WEBMAILRCVR', 'office@first1.us');
define('WEBURL', 'http://gulfshoregroup.com');
define('WEBADDRESS','1495 Pine Ridge Road #1 Naples, FL 34109');
define('WEBMAPAPI','AIzaSyBQwpzlVeV9AI6FETYYUmLt730XEKRdfAY');
define('WEBWALKSCOREAPI','84300aba4f3c1ce3ddab5e297cbcc280');
define('FBAPPID','347251250481799'); //347251250481799
define('FBAPPSECRET','8088455fa7bd64322caec2d13d78d222'); //8088455fa7bd64322caec2d13d78d222


//define('FBAPPID','574803049948658');
//define('FBAPPSECRET','96c78630a36d5f964da10e44bc397f2b');





error_reporting(1);
//$conn = mysqli_connect("db5013859389.hosting-data.io","dbu1470512","Immokalee_34142","dbs11591428");
//$conn = mysqli_connect("localhost","u110616855_hybrid_pro","J#i1qwPNBQ","u110616855_real_estate");
//$conn = mysqli_connect("db5013225696.hosting-data.io","dbu2802442","J#i1qwPNBQ","dbs11095202");
$conn = mysqli_connect('localhost','Dimitri','$Florida_239','dbs11591428');
// Check connection
if(mysqli_connect_errno()){
   //echo "Failed to connect to MySQL: ".mysqli_connect_error();
}else{
   //echo 'connected';
}


function filterThis($string, $conn){
    $string = strip_tags($string, '<br /><br/><br>');
    $string = mysqli_real_escape_string($conn, $string);
    $string = trim($string);
    //$string = htmlentities($string);
    return $string;
}


function filterCK($string, $conn){
    $string = trim($string);
    $string = mysqli_real_escape_string($conn, $string);
    //$string = strip_tags($string, '<br /><br/><br>');
    //$string = htmlentities($string);
    return $string;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];;
$phone_number = $_SESSION['phone_number'];
$logged_email = $_SESSION['logged_email'];
$favorites = $_SESSION['favorites'];
$tours = $_SESSION['tours'];
?>