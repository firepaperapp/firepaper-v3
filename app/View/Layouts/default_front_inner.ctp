<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>style.css" />
<title><?php echo ucfirst($this->Session->read("username"))." - ".$metaTitle; ?></title>
<meta name="keywords" content="<?php if (isset($metaKeyword)){ echo $metaKeyword; } ?>" />
<meta name="description" content="<?php if (isset($metaDescription)) { echo $metaDescription; } ?>" />
<!--<link rel="stylesheet" href="<?php echo CSS_PATH;?>popupjquery/general.css" type="text/css" media="screen" />-->
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>ie8.css" type="text/css" media="screen" />

<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>ie7.css" type="text/css" media="screen" />

<![endif]-->

<script>
	var siteUrl = "<?php echo SITE_HTTP_URL;?>";	
	var siteImagesUrl = "<?php echo SITE_HTTP_URL;?>app/webroot/images/";
</script>
<!--<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.4.2.js"></script>-->
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
<script type="text/javascript" src="<?php echo JS_PATH;?>bubble.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>common.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-idleTimeout.js"></script>

<script type="text/javascript">
        
$(document).ready(function(){
    var s = <?php echo Configure::read('Session.timeout');?>;
    $(document).idleTimeout({
      alive_url:'<?php echo SITE_HTTP_URL;?>users/check_user_login',
      logout_url:'<?php echo SITE_HTTP_URL;?>users/check_user_login',
      //redirect_url:'<?php echo SITE_HTTP_URL;?>dashboard'
    });
  });
</script>
</head>
<body>


<section class="wrapper">
	<section class="container">
	<?php echo $this->element("common/header");?>
	<?php echo $content_for_layout; ?>
	
	</section>
<?php echo $this->element("common/leftsidebar");?>
<section class="footer">
	<?php echo $this->element("common/footer");?>	 
	</section>
</section>
<div id="fancybox-overlay1" style="background-color: rgb(119, 119, 119);  position: absolute;top: 0;width: 100%;z-index: 1100;cursor: pointer; height: 1114px; opacity:0.7;display: none;"></div>
</body>
</html>
