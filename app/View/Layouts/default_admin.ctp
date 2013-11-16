<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $title_for_layout; ?></title>

<script>
	var siteUrl = "<?php echo SITE_HTTP_URL;?>";
</script>
<?php echo $this->Html->css(CSS_PATH.'admin/adminstyle.css'); ?>
<?php echo $this->Html->css(CSS_PATH.'admin/alignment.css'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.9.0.js"></script>
<!--<script src="http://code.jquery.com/jquery-1.9.0.js"></script>-->
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<!--<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.4.2.js"></script>-->
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validate.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
<div  style="background: none repeat scroll 0 0 #EEF7F7;">
    <table  border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#26647d;">
	<tbody>
	   <tr style="background:#44A2A2;">
	  <td colspan="4" height="85" valign="bottom" >
			  <div id="Header"> <!-- Header start here -->
				   <div class="Logo"><img src="<?php echo IMAGES_PATH?>logo.png" /></div>
			  </div>
	 </td>
	 <td width="30%" style="text-align:right;padding-right:10px;">
	 	<span class="headerText">Site Administration</span>  	 
	 </td>
	</tr>
	</tbody>
    </table>
    <table  border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
		<tr>
			<td><?php echo $content_for_layout ?></td>
		</tr>
		<tr><td height="100">&nbsp;</td></tr>
    </table>
</div>
</body>
</html>