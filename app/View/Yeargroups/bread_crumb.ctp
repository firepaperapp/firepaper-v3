<div class="bread">
    	<div class="crumb" style="cursor:pointer;" onclick="window.location = '<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups'">
    		<h3><a href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups">Home</a></h3>
    		<p><a href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups"><?php echo $yeargp_count; ?> Year Groups</a></p>
    	</div>

    	<?php if($showyear=='Y'){?>
		<div class="crumb" style="cursor:pointer;" onclick="window.location = '<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>'">
			<h3<a  href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>"><?php echo $yrgpname?></a></h3>
			<p><a href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>"><?php echo $classgrpcount?> Class Groups</a></p>
		</div>
	<?php } ?>

	<?php if($showclass=='Y'){?>
		<div class="crumb" style="cursor:pointer;">
			<h3><?php echo $studentclassgpname;?></h3>
			<p><?php echo $studentclassgrpcount;?> Students </p>
		</div>
	<?php } ?>
</div>
<div class="clr-spacer"></div>
