<?php
if(count($projects)>0)
{
	foreach($projects as $rec)
	{?>
	 <div class="project-name marginT10">
 		<?php
 		if($rec['projectStudent']['marked'] == 0)
 		{
 			$icon = "project-new.png";
 			$text = "Mark";
 		}
 		else 
 		{
 			$icon = "project-marked.png";
 			$text = "Re-mark";
 		}
 		?>
	 	<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $icon;?>" />
	 	<span class="cat"><?php echo ucfirst(Sanitize::html($rec['Subject']['title']));?></span> ~ <a href="<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id']."/".$rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['Project']['title']));?></a>          	 
	<p class="file-links" style="padding-top:4px;"><span> <? print(date("H:ia", strtotime($rec['projectStudent']['submitted_date']))); ?> by </span><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>" class="edit"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>| <a href="<?php echo SITE_HTTP_URL."projects/markProject/".$rec['Project']['id']."/".$rec['User']['id'];?>" class="edit"><?php echo $text;?></a></p>
<div class="clr"></div></div>
<?php
	}?>
	<div class="clr">&nbsp;</div>
	<?php 
	$this->Paginator->options(array('url' => $this->passedArgs));
	echo $this->element("pagination/ajax_pagination");
	?>
<?php
}
else 
{
	echo NO_PROJECTS_FOUND;
}?>