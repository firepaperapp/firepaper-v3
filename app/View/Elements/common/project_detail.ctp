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
	
		<div class="details left">
			
			<h3>Course details</h3> 
			<?php
			if($isOwner == 0 && isset($howMuchCompleted))
			{?>
				<div class="completed-bubble"><span><?php echo $howMuchCompleted;?>%</span> Completed</div>
			<?php }?>
				<!--<p class="title">Project title:</p>
				<p><?php echo Sanitize::html($prjDetails['Project']['title']);?></p>
				<div class="clr-spacer"></div>-->
				
				<p><?php echo nl2br(Sanitize::html($prjDetails['Project']['description']));?></p>
			</div>
			<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Project']['leader_id'];?>" class="red"><?php echo ucfirst(Sanitize::html($prjDetails['User']['firstname']." ".$prjDetails['User']['lastname']));?></a>
			<div class="left deadline-details">
			<p class="title">Project leader:</p>
				<img id="imgid" alt="" height="100" width="100" src="<?php echo $userimage;?>" /><p class="leader"></p>
				
				<p class="title">Due:</p>
				<div class="day"><?php echo date("d", strtotime($prjDetails['Project']['duedate']))?></div>
				<p class="due-in"><?php echo date("F j, Y", strtotime($prjDetails['Project']['duedate']))?></p>
				
				<?php
	 			if($isOwner == 1)
				{?>
					<p><a href="<?php echo SITE_HTTP_URL?>projects/addEditProject/<?php echo $prjDetails['Project']['id'];?>/?m=e" class="button">Edit Project</a></p>
					<p>
					<?php
					if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], "projects/markProject") == false)
					{
						if($prjDetails['Project']['published'] == 1)
						{?>
							<a href="<?php echo SITE_HTTP_URL?>projects/closeProject/<?php echo $prjDetails['Project']['id'];?>" onclick="closeProject(<?php echo $prjDetails['Project']['id'];?>)" class="red">Close Project</a>
						<?php
						}
						else
						{?>
							<a href="<?php echo SITE_HTTP_URL?>projects/openProject/<?php echo $prjDetails['Project']['id'];?>" onclick="openProject(<?php echo $prjDetails['Project']['id'];?>)" class="red">Open Project</a>
						<?php
						}
					}?>
					</p> 
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
</div>