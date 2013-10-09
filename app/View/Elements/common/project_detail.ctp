<script>
	function closeProject(d)
	{
		if(confirm("Are you sure you want to close this project?"))
		{
			window.location = siteUrl+"projects/closeProject/"+d;
		}
	}
	function openProject(d)
	{
		if(confirm("Are you sure you want to open this project?"))
		{
			window.location = siteUrl+"projects/closeProject/"+d;
		}
	}
</script>
<div class="project-brief-box-wrapper">
	<div class="project-brief-box">
	
		
			
			
			<?php
			if($isOwner == 0 && isset($howMuchCompleted))
			{?>
				<div class="completed-bubble"><span><?php echo $howMuchCompleted;?>%</span> Completed</div>
			<?php }?>
			<?php //echo "<pre>"; print_r($userdata);
if(is_file(USER_IMAGES_URL.'100X100/'.$prjDetails['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$prjDetails['User']['profilepic']))
{
	$userimage = USER_IMAGES_PATH.'100X100/'.$prjDetails['User']['profilepic'];
}
else
{
	$userimage = IMAGES_PATH.'profile-pic.png';
}
?>

			<img id="imgid" alt="" height="55" width="55" src="<?php echo $userimage;?>" />
			<span class="project-leader-title">Details:<br />
			<strong><a href="<?php echo SITE_HTTP_URL?>/<?php echo $prjDetails['Project']['leader_id'];?>" >
			<?php echo ucfirst(Sanitize::html($prjDetails['User']['firstname']." ".$prjDetails['User']['lastname']));?></a></strong>
				</span>
				<div class="clr"></div>
				<!--<p class="title">Project title:</p>
				<p><?php echo Sanitize::html($prjDetails['Project']['title']);?></p>
				<div class="clr-spacer"></div>-->
				<h3>Details</h3> 
				<p><?php echo nl2br(Sanitize::html($prjDetails['Project']['description']));?></p>
			
			
			<div class="project-controls">
			<?php
	 			if($isOwner == 1)
				{?>
					<p><a href="<?php echo SITE_HTTP_URL?>projects/addEditProject/<?php echo $prjDetails['Project']['id'];?>/?m=e" class="submit">Edit Project</a>
					
					<?php
					if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], "projects/markProject") == false)
					{
						if($prjDetails['Project']['published'] == 1)
						{?>
							or <a href="<?php echo SITE_HTTP_URL?>projects/closeProject/<?php echo $prjDetails['Project']['id'];?>" onclick="closeProject(<?php echo $prjDetails['Project']['id'];?>)" class="close red">Close Project</a>
						<?php
						}
						else
						{?>
							<a href="<?php echo SITE_HTTP_URL?>projects/openProject/<?php echo $prjDetails['Project']['id'];?>" onclick="openProject(<?php echo $prjDetails['Project']['id'];?>)" class="red">Open Project</a>
						<?php
						}
					}?>
					</p> 
			</div><!-- End project controls -->
			</div>		
			
			<div class="left deadline-details">
			<div class="project-content">
		<span class="flat-due-icon"><?php echo date("d", strtotime($prjDetails['Project']['duedate']))?>
				
				<?php echo date("F j, Y", strtotime($prjDetails['Project']['duedate']))?>
				</span>
				<span class="flat-files-icon"><?php echo $rec[0]['noOfFiles']>0?$rec[0]['noOfFiles']:0;?> Files</span> 
		<span class="flat-tasks-icon"><?php echo $rec[0]['noOfComments']>0?$rec[0]['noOfComments']:0;?> Comments</span>
				</div>
		   		<?php 
				} 
				if( ($this->Session->read("user_type")==3 || $this->Session->read("user_type")==4) && $isOwner==0) 
				{
					if($prjDetails['User']['status'] == 1 && $prjDetails['UserAdmin']['status'] == 1)
					{
						$mail = "mailto:".$prjDetails['User']['email']."?cc=".$prjDetails['UserAdmin']['email'];
					}
					else if($prjDetails['User']['status'] != 1 && $prjDetails['UserAdmin']['status'] == 1)
					{
						$mail = "mailto:".$prjDetails['UserAdmin']['email'];
					}
					else if($prjDetails['User']['status'] == 1 && $prjDetails['UserAdmin']['status'] != 1)
					{
						$mail = "mailto:".$prjDetails['User']['email'];
					}
					else 
					{
						$mail= "";
					}
			 		if($mail!="")
					{
		 			?>
					<p class="title">Any questions?</p>
					<p><a href="<?php echo $mail;?>" class="red">Send a message</a></p>
				<?php
					}
				}					
				?>
			</div>
		
		<div class="clr"></div>
	
</div>