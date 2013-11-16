<?php

define("SITE_BASE_PATH", "/var/www/firepaperapp.com/dev/");
//define("SITE_BASE_PATH", "E:/wamp/www/fireappwc/");
// define("SITE_HTTP_URL", "http://".$_SERVER['HTTP_HOST']."/php_oracle/branches/");

//We have this setup for live site or manpreet copy only
// define("HTTP_HOST", "ubundle.it");
// $subdomain = substr( env("HTTP_HOST"), 0, strpos(env("HTTP_HOST"), ".") );
// if( strlen($subdomain)>0 && $subdomain != "www" ) {
// 	define("SITE_HTTP_URL", "http://".$subdomain.".".HTTP_HOST."/");
// }
// else 
// {
// 	define("SITE_HTTP_URL", "http://www.".HTTP_HOST."/");
// }

// for localhost only
//define("SITE_HTTP_URL", "http://localhost/firepaperapp/");
define("SITE_HTTP_URL", "http://".$_SERVER['HTTP_HOST']."/dev/");
define("IMAGES_PATH", SITE_HTTP_URL."app/webroot/images/");
define("CSS_PATH", SITE_HTTP_URL."app/webroot/css/");
define("JS_PATH", SITE_HTTP_URL."app/webroot/js/");
define("FILES_PATH", SITE_BASE_PATH."app/webroot/files/");
define("FILES_PATH_URL", SITE_HTTP_URL."app/webroot/files/");
define("SITE_NAME", "Firepaperapp");

define('EMAIL_CONTENT_TYPE','text/html; charset=utf-8');
define('EMAIL_FROM_ADDRESS',"info@firepaperapp.com");
define('EMAIL_ADMIN',"info@firepaperapp.com");
define('EMAIL_SUPPORT',"info@firepaperapp.com");
define('EMAIL_TO_ADDRESS',"info@firepaperapp.com"); // for contact us form
define('EMAIL_FROM_NAME','Firepaperapp');
define('EMAIL_METHOD','smtp');
define('EMAIL_HOST','localhost');
define('EMAIL_SMTP_AUTH','false');
define('EMAIL_USERNAME','');
define('EMAIL_PASSWORD','');
define("ADMIN_NAME","Firepaperapp");
global $cardTypes, $defaultTimeZone, $videoArray, $filesArray;;
$serviceLevels = array(1=>"Individual Account",2=>"Company");
$phoneTypes = array(1=>"Mobile",2=>"Work Phone",3=>"Home Phone");
$billingMethods = array(1=>"Credit Card",2=>"ACH Debit",3=>"Paypal");
$cardTypes = array("American"=>"American Express Card",
					"Discover"=>"Discover Card",
					"Master"=>"Master Card",
					"Visa"=>"Visa Card");
$defaultTimeZone = "-8.0";
$videoArray = array("mpg", "mov", "wmv", "wma", "rm","avi","flv","mpg","swf");
$filesArray = array('3gp','7z','ace','ai','aif','aiff','amr','asf','asx','bat','bin','bmp','bup','cab','cbr','cda','cdl','cdr','chm','dat','divx','dll','dmg','doc','dss','dvf','docx','dwg','eml','eps','exe','fla','flv','gform','gdraw','gif','gdoc','gslides','gsheet','gz','hqx','htm','html','ifo','indd','iso','jar','jpeg','jpg','lnk','log','m4a','m4b','m4p','m4v','mcd','mdb','mid','mov','mp2','mp4','mpg','mpeg','msi','mswmm','ogg','pdf','png','pps','ppt','pptx','ps','psd','pst','ptb','pub','qbb','qbw','qxd','ram','rar','rm','rmvb','rtf','sea','ses','sit','sitx','ss','swf','tgz','thm','tif','tmp','tiff','torrent','ttf','txt','vcd','vob','wav','wma','wmv','wps','xls','xlsx','xpi','zip');


define("PAGE_LIMIT",4);
define("USER32X29","user60X60.png");
define("USER_IMAGES_URL",FILES_PATH."user_image/");
define("USER_IMAGES_PATH", FILES_PATH_URL."user_image/");
define('MENCODER','/usr/local/bin/mencoder ');
define('FFMPEG','/usr/local/bin/ffmpeg');
define("MAX_TEXT_LIMIT", 1500);

define("MAX_FILESIZE",  5242880);  // 5MB
define("MAX_FILESIZE_MSG",  "Please upload up to 5MB only.");  // 2MB

define("MAX_FILESIZE_PIC",  2097152);  // 2MB
define("MAX_FILESIZE_PIC_MSG",  "Please upload up to 2MB only.");  // 2MB


//Dont forget to chnage the payment constants when going live
//AMAZON WEB SERVICE CONSTANTS
define("AMAZON_S3_KEY", "AKIAJA5PZZ4H3N3N2CAA");
define("AMAZON_S3_SECURITY_KEY", "SnqMWKCEpnlw/P4RkAcRSYHZN/4ZnRZ75uWnx1oY");  // 2MB
define("MAIN_BUCKET", "testcloudpollen");
define("MULTIPLY_BY", "1073741824");

define("INVITE_SUCCESS","All The Selected Users Invited Successfully");
define("INVITE_UNSUCCESS","All The Selected Users Already Invited");
define("INVITE_DEL_SUCCESS","Student Deleted Successfully From List");
define("NO_RESULT","No Result Found");

?>
