<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $title_for_layout; ?></title>
<script>
	var siteUrl = "<?php echo SITE_HTTP_URL;?>";
	var siteImagesUrl = "<?php echo SITE_HTTP_URL;?>app/webroot/images/";
</script>
<?php echo $this->Html->css(CSS_PATH.'admin/adminstyle.css'); ?>
<?php echo $this->Html->css(CSS_PATH.'admin/alignment.css'); ?>
<?php echo $this->Html->css(CSS_PATH.'admin/menu.css'); ?>

<!--<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.4.2.js"></script>-->
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validate.js"></script>
<!-- DD MENU SCRIPT -->
<script type="text/javascript">
$(document).ready(function () {	
	
	$('#nav li').hover(
		function () {
			//show its submenu
			//$('ul', this).css('display','block');
			$('ul', this).slideDown(100);

		}, 
		function () {
			//hide its submenu
			//$('ul', this).css('display','none');
			$('ul', this).slideUp(100);			
		}
	);
	$('#nav li ul li a').mouseover(function () {
		$(this).animate({ fontSize: "13px", paddingLeft: "15px" }, 50 );
    });
	$('#nav li ul li a').mouseout(function () {
		$(this).animate({ fontSize: "11px", paddingLeft: "0px" }, 50 );
    });	
});
</script>
<!-- DD MENU SCRIPT -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
<div>
	<table  border="0" cellpadding="0" cellspacing="0" width="100%" >
		<tr>
			<td height="85" valign="bottom"  style="background:#44A2A2;">
				<table  border="0" cellpadding="0" cellspacing="0" width="99%" >
					<tr>
						<td align="left"><img src="<?php echo IMAGES_PATH?>logo.png" /></td>
						<td align="right">
						<table  border="0" cellpadding="0" cellspacing="0" width="99%" >
						<tr>
							<td align="right"><font color="#ffffff" face="Trebuchet" size="5">Site Administration</font></td>
						</tr>
						<tr>
							<td align="right"><b>Welcome <?php echo $_SESSION['username'];?></b></td>
						</tr>
						<tr>
							<td  align="right"><a href="<?php echo SITE_HTTP_URL ?>admin/changepassword" class="edit">Change Password</a>&nbsp;|&nbsp;<a href="<?php echo SITE_HTTP_URL ?>admin/logout"  class="edit">Logout</a></td>
						</tr>
						
						</table>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->element("common/admin_menu"); ?>
			</td>
		</tr>
		<tr>
			<td>
			<div style="border:1px solid #44A2A2; margin:10px 0 0 0;" class="bgE2F3FA">
						<div id="breadcrumb">
						<?php echo $this->element("common/admin_breadcrumb",$breadcrumbs); ?></div>
						<div id='content'><?php echo $content_for_layout ?></div>
					</div>
			</td>
		</tr>
		<tr>
			<td>
			 <div style="margin: 10px 0pt 0pt; background: #44A2A2; color: #FFF; width: 99%;" id="footer">Copyright &copy; <?php echo date('Y').' '.SITE_NAME ?></div>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
</div>
</body>
</html>