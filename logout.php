<?php
session_start();
/**
$cookie_name = 'realtorrefund_email';
unset($_COOKIE[$cookie_name]);

$res1=setcookie($cookie_name, "", time() - 3600, '/');
**/

session_destroy();   // function that Destroys Session 
header("Location: index.php");
?>