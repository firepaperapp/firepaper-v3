<div class="activity-panel-wrapper marginT10">
	<div class="activity-panel">
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
				?> 
				<?php	
				$preDate = $date;
				if($currDate == $date)
				{	$b = "red";
					?>
					<p class="title-today">Due Today <span class="date"><? print(Date("dS F Y")); ?></span></p>
				<?}	
				else if($date == $tom)
				{
					$b = "orange";
					?>
					 <p class="title-tomorrow">Due Tomorrow <span class="date"><? print(Date("dS F Y", strtotime($tom))); ?></span></p>
				<?php
				}
		 	}
			 
				if($date!=$currDate && $date!=$tom && $printed == false) 
				{	
					$printed = true;
					?>
					<p class="title-other">Others Due<span class="date"><? print(Date("dS F Y", strtotime($date))); ?></span></p>
				<?php
				}		 
			?>
				<!-- Project_summary start here -->
					<!-- Project bars --->
					<div class="project-bar-wrapper" onClick="location.href='<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id'];?>';" style="cursor:pointer;">
						<div class="project-bar">
						  <div class="completed-bubble">
						  <span><?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%</span>
						  <?php
						  if($owner == 1)
						  	echo "Weight";
						  else 
						  	echo "Completed";
						  ?>
						   </div>
						  <div class="project"><span class="<?php echo $b;?>"><?php echo $i;?></span>
						  <div class="clr"></div>
						  <em>Project</em></div>
						  <p class="project-title"><?php echo Sanitize::html($rec['Subject']['title']);?></p>
						  <p><?php echo Sanitize::html($rec['Project']['title']);?>  <span class="started-details">- <?php 
								echo $this->Time->timeAgoInWords(strtotime($rec['Project']['created']));?></span></p>
						
						<p class="project-content">
							<?php echo $rec[0]['noOfFiles']>0?$rec[0]['noOfFiles']:0;?> Files and
							  <?php echo $rec[0]['noOfComments']>0?$rec[0]['noOfComments']:0;?> Comments
							  
						</p><!-- end project-content -->
						</div><!-- end project-bar -->	
						<div class="clr"></div>
					</div><!-- end project-bar-wrapperr -->
					<!-- end Project bars --->
				<!-- Project summary end here-->
			<?php		 
			$i++;
		}
		
	$this->Paginator->options(array('url' => $this->passedArgs));
	echo $this->element("pagination/ajax_pagination");
	}
	else 
	{
		echo "<p class='marginT10'>".NO_RECENT_PROJECTS_FOUND."</p>";
	}
	?> 
	<!-- end Project bars --->
	</div>
</div>