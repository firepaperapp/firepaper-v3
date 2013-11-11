<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $title_for_layout?></title>
<?php echo $this->Html->css('adminstyle') ?>
<?php echo $this->Html->css('alignment') ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body  style="margin:0 auto;background:#688A00" >

		<div class="h10 fl w300"></div>
        <?php echo $this->Session->flash();?>
			<?php
			echo $content_for_layout ?>
		<div class="h20 fl w300"></div>
		<!--<div class="fl bg8bc7f0 h20 w100p pt5 tar">
			<div class="fr pr5 cffffff">Copyright &copy; <?php echo date('Y').' '.SITE_NAME ?></div>
		</div>-->
	</div>
		</div>
	</div>
</body>
</html>
