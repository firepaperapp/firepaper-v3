<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!--<script type="text/javascript">
$(document).ready(function(){
		$("a.add-projects").fancybox({				 
			ajax : {
			type	: "GET"
			}
		});
		
});
</script>-->

	
		<?php
			App::import('Helper','Time');
			$time = new TimeHelper(new View());
			if(count($data)>0)
			{
				$gotData = array();
				$printed = false;
				$preDate = "";
				$i = 0;
				$b = "blue";
				$currDate = date("Y-m-d");
				$tom = date("Y-m-d", strtotime("+1 DAY"));$i=1;
				foreach ($data as $rec)
				{	
					$date = date("Y-m-d", strtotime($rec['Project']['duedate']));
					if($preDate != $date)
					{
						
						if($i!=0)
						{
						//	echo "</ul>";
						}
							
						$preDate = $date;
						if($currDate == $date)
						{	$b = "red";
							?>
							
						<? }	
						else if($date == $tom)
						{
							$b = "orange";
							?>
							 
						<?php
						}
				 	}
					 
						if($date!=$currDate && $date!=$tom && $printed == false) 
						{	
							$printed = true;
							?>
						
						<?php
						}		 
					?> 
					
						
							<!-- Project bars --->
	<div class="project-bar-wrapper" onClick="location.href='<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id'];?>';" style="cursor:pointer;">
		<span class="duein-date"><span>Due: </span><? print(Date("dS F Y", strtotime($date))); ?></span>
		
			<p class="project-title"><?php echo Sanitize::html($rec['Project']['title']);?> </p>
		
		<div class="project-bar">
		<!-- Bubble -->
	<div class="completed-bubble">
		<span><?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%</span>
		<?php
			if($owner == 1)
				echo "Weight";
				else 
				echo "Completed";
		?>
	</div>
<!-- End bubble -->
<!-- Progress bar -->
<?php //echo "<pre>"; print_r($rec);die;?>
	<div class="progressbg">
		<div class="progressBar" style="width:<?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%;"></div>
	</div>
<!-- End Progress bar -->

		<div class="project"><span class="<?php echo $b;?>"><?php echo $i;?></span>
		<div class="clr"></div>
		<em>Project</em></div>
		<div class="details">
		
		<h3>Details</h3>

			<p><?php echo Sanitize::html($rec['Project']['description']);?>
			<!--<span class="started-details">- <?php 
			echo $this->Time->timeAgoInWords(strtotime($rec['Project']['created']));?></span>-->
			</p>
		
		<div class="project-content">
		<span class="flat-files-icon"><span>&#xf15b;</span><?php echo $rec[0]['noOfFiles']>0?$rec[0]['noOfFiles']:0;?> Files</span> 
		<span class="flat-tasks-icon"><span>&#xf075;</span>
<?php echo $rec[0]['noOfComments']>0?$rec[0]['noOfComments']:0;?> Comments</span>
		</div>
		</div><!-- end project-content -->
		<div class="project-owner">
		<?php //echo "<pre>"; print_r($rec['User']);die;
	      if(is_file(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']))
	      {
		      $userimage = USER_IMAGES_PATH.'100X100/'.$rec['User']['profilepic'];
	      }
	      else
	      {
		      $userimage = IMAGES_PATH.'profile-pic.png';
	      }
	      ?>
		      <img id="imgid" alt="" height="55" width="55" src="<?php echo $userimage;?>" />
		        <p class="title">Project leader:<br />
			<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $rec['Project']['leader_id'];?>" class="red"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a></p>
		</div>
		
		</div>
		</div><!-- end project-bar -->	
		
	</div><!-- end project-bar-wrapperr -->
		<!-- end Project bars --->
		<?php		 
			$i++;
			} ?>
		<div class="clr-spacer"></div> 
		<?php
 			} else {
 			 
 			 if (in_array($this->Session->read('user_type'), array(1,2,3,7))) { 
			//echo "<div class='no-projects widget'><h2>".NO_RECENT_PROJECTS_FOUND;
 ?>
           	 	<div class='no-projects widget'>
           	 	<h2>Welcome to Firepaperapp!</h2>
           	 	<h3>First things first, create your class structures and student accounts</h3>
           	 	
           	 	<p>These will be your mailing list groups, this will help when distributing your projects.</p>
           	 	
           	 	<br />
           	 	<a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" class="submit" alt="Start creating groups">Start creating groups</a>
           	 	<div class="clr-spacer"></div>
           	 	<h3>Next thing is to create your project!</h3>
           	 	<p>All active project will be displayed here on your dashboard.</p>
           	 	<br />
           	 	<a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" class="submit" alt="Create your first project">Create your project</a>
           	 	<div class="clr-spacer"></div> 
           	 	
           	 	
           	 	<h3>Looks like you don't have any projects.</h3>
           	 	<p>You have your own file storage area, keep everything in one area.</p>
           	 	<br />
           	 	<a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" class="submit" alt="View File area">View File area</a>
           	 	
           	 	<a href="<?php echo SITE_HTTP_URL?>projects/viewAllProjects/<?php echo $dept_id?>" class="view-all-projects">View archived projects</a>
            	 	<?php 
				}
 				echo "</div>";
 			}
 			?> 
<!-- end Project bars --->
		
		
	