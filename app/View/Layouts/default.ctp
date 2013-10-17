<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>style.css" />
<!--<link rel="stylesheet" href="<?php echo CSS_PATH; ?>popupjquery/general.css" type="text/css" media="screen" />-->
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>ie8.css" type="text/css" media="screen" />

<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>ie7.css" type="text/css" media="screen" />

<![endif]-->
<title>Firepaperapp</title>
<script>
	var siteUrl = "<?php echo SITE_HTTP_URL;?>";	
	var siteImagesUrl = "<?php echo SITE_HTTP_URL;?>app/webroot/images/";
</script>
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.4.2.js"></script>-->
<script type="text/javascript" src="<?php echo JS_PATH;?>bubble.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>animatedcollapse.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.sortable.js"></script>	
<script type="text/javascript">
animatedcollapse.addDiv('versions', 'fade=1')
animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
	alert(1);
}
animatedcollapse.init()
animatedcollapse.addDiv('project-details', 'fade=1')
animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}
animatedcollapse.init()
</script>
</head>
<body>
 	<?php echo $content_for_layout; ?>
</body>
</html>