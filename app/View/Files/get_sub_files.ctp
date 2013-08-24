<script>
$(function() 
{
	$(".file-name a").hover(function() {
	$(this).next("em").stop(true, true).animate({opacity: "show", top: "-24"}, "slow");
	}, function() {
	$(this).next("em").animate({opacity: "hide", top: "-14"}, "fast");
	});
	fadeErrorMessage('Formmessage');
	$("a.deleteFileVersion").fancybox({				 
			ajax : {
			type	: "GET"
			}
	});
	$(".dragFileForProject").draggable({helper:"clone" });
});
</script>
<?php
	if($this->Session->check('Message.flash'))
	{?>
		<div class="Formmessage errorServer">
			<div class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?>
<p class="version-title">Versions</p>
<?php
if(isset($rec['Revison']))
{
	foreach($rec['Revison'] as $recSub)
	{?>
		<div class="file-name file-name-border">
			<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $recSub['fileType']['icon'];?>" />
			
			<a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $recSub['userFile']['id']?>" id="tool-tip"><span id="fileProject_<?php echo $recSub['userFile']['id'];?>" class="dragFileForProject" style="color:black;"><?php echo $recSub['userFile']['file_name']?></span></a> <em></em> 
			<p class="file-links">
				<span> <?php 
				echo date("m/d/y", strtotime($recSub['userFile']['uploaded']))." at ".date("h:i:a", strtotime($recSub['userFile']['uploaded']));?> -</span> <a href="<?php echo SITE_HTTP_URL?>files/confirmDeletion/<?php echo $recSub['userFile']['id'];?>" class="edit deleteFileVersion" >Delete</a>
			</p>
		 
		</div>
	<?php
	}
}?>