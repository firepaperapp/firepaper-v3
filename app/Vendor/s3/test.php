<?php
ini_set("error_reporting", E_ALL);
ini_set("display_errors", "On");
ini_set("display_startup_errors", "On");
include_once("sdk.class.php");
$buket = "testcloudpollen";
$obj = new AmazonS3("AKIAJA5PZZ4H3N3N2CAA", "SnqMWKCEpnlw/P4RkAcRSYHZN/4ZnRZ75uWnx1oY");
//$response = $obj->create_bucket($buket, AmazonS3::REGION_US_W1);
/*$response = $obj->create_object($buket, "user_img_12930797123.jpg",
array("fileUpload"=> "/home/manpreet.k/html/cloudpollen/app/webroot/files/user_img_1293079712.jpg",
"contentType" => "images/jpeg",
"acl"=>AmazonS3::ACL_PUBLIC)
);*/

$response = $obj->get_bucket_filesize($buket, true);

print "<pre>";
print_r($response);
?>