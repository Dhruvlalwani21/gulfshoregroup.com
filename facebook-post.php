<?php
//app id: 1494810524217545
//secrete: 456fdb9561b5f562468c28a498c67c46

$fb = new Facebook\Facebook([
  'app_id' => '1494810524217545',
  'app_secret' => '456fdb9561b5f562468c28a498c67c46',
  'default_graph_version' => 'v2.8',
  ]);
             // facebook auto post

$params = array(
  "message" => "$title in $merchant   $short",
  "link" => "http://pickmyoffers.com/",
  "picture" => "http://Pickmyoffers.com/images/searched/Flipkart.png",
  "name" => "www.Pickmyoffers.com",
  "caption" => "www.pickmyoffers.com",
  "description" => "Submit Coupon and earn money through Pickmyoffers.com | Deals,Coupons and offers."
);

$post = $fb->post('/Page_id/feed',$params, $access_token);
$post = $post->getGraphNode()->asArray();
?>