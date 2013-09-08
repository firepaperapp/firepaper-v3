
<div class="col1">
	
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
		<p class="title-other">Due: <span class="date"><? print(Date("dS F Y", strtotime($date))); ?></span></p>
		
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
	<div class="progressbg">
		<div class="progressBar" style="width:<?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%;"></div>
	</div>
<!-- End Progress bar -->

		<div class="project"><span class="<?php echo $b;?>"><?php echo $i;?></span>
		<div class="clr"></div>
		<em>Project</em></div>
		<div class="project-content">
		<div class="inner">
		<h4>Course details</h4>
		<div class="note">
			<p><?php echo Sanitize::html($rec['Project']['description']);?>
			<span class="started-details">- <?php 
			echo $this->Time->timeAgoInWords(strtotime($rec['Project']['created']));?></span>
			</p>
		</div>
		<div class="project-items">
		<span class="file-icon"><?php echo $rec[0]['noOfFiles']>0?$rec[0]['noOfFiles']:0;?> Files</span>
		<?php //echo $rec[0]['noOfComments']>0?$rec[0]['noOfComments']:0;?> <!--Comments-->
		</div>
		</div><!-- end project-content -->
		<p class="leader"><a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Project']['leader_id'];?>" class="red"><?php echo ucfirst(Sanitize::html($prjDetails['User']['firstname']." ".$prjDetails['User']['lastname']));?></a></p>
		</div>
		</div><!-- end project-bar -->	
		<div class="clr"></div>
	</div><!-- end project-bar-wrapperr -->
		<!-- end Project bars --->
		<?php		 
			$i++;
			} ?>
		<div class="clr-spacer"></div> 
		<?php
			} else {
			echo "<div class='no-projects widget'><h2>".NO_RECENT_PROJECTS_FOUND;
			if(in_array($this->Session->read('user_type'), array(1,3,7)))
           	 	{
           	 		echo '</h2><a class="add-projects button" href="'.SITE_HTTP_URL.'projects/addEditProject">Add a new project</a>';
           	 	} ?>
           	 	<br />
           	 	<a href="<?php echo SITE_HTTP_URL?>projects/viewAllProjects/<?php echo $dept_id?>" class="view-all-projects">View archived projects</a>
           	 	<?php 
				echo "</div>";
			}
			?> 
<!-- end Project bars --->
		
		
	<div class="clr"></div>
 
 </div>