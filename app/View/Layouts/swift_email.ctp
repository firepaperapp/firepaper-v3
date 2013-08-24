<?php echo'<?xml version="1.0" encoding="iso-8859-1"?>';
$this->_params['sSiteUrl'] = 'http://'.$_SERVER['SERVER_NAME'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SITE_NAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?php echo SITE_URL ?>/css/email.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
<?php echo $content_for_layout;?>
</div>
</body>
</html>
