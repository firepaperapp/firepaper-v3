<div class="bread">
    	<div class="crumb" style="cursor:pointer;" onclick="window.location = '<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups'">
    		<h2><a href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups">Home</a></h2>
    		<em><a style="color:#51ADAD;" href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups"><?php echo $yeargp_count; ?> Year Groups</a></em>
    	</div>

    	<?php if($showyear=='Y'){?>
		<div class="crumb" style="cursor:pointer;" onclick="window.location = '<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>'">
			<h2><a  href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>"><?php echo $yrgpname?></a></h2>
			<em><a style="color:#51ADAD;" href="<?php echo SITE_HTTP_URL;?>yeargroups/viewgroups/<?php echo $yrgpid;?>"><?php echo $classgrpcount?> Class Groups</a></em>
		</div>
	<?php } ?>

	<?php if($showclass=='Y'){?>
		<div class="crumb" style="cursor:pointer;">
			<h2><?php echo $studentclassgpname;?></h2>
			<em><?php echo $studentclassgrpcount;?> Students </em>
		</div>
	<?php } ?>
</div>
<div class="clr-spacer"></div>
