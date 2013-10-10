<?php
	if($this->Session->check('Message.flash'))
	{?>
		<div class="essage errorServer">
			<div class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?> 

<div class="col1">
	
	<?php
	if(count($data)>0)
	{
		$printed = false;
		$gotData = array();
		$preDate = "";
		$i = 0;
		$currDate = date("Y-m-d");
		$tom = date("Y-m-d", strtotime("+1 DAY"));
		foreach ($data as $rec)
		{	
			$date = date("Y-m-d", strtotime($rec['activityLog']['created']));
			if($preDate != $date)
			{
				if($i!=0)
				{
					echo "</ul>";
				}
				?>
				<p class="title-today">Due Today <span class="date"><? print(Date("dS F Y")); ?></span></p>
	
				<?php	
				$preDate = $date;
				if($currDate == $date)
				{?>
					<p class="title-today">Due Today <span class="date"><? print(Date("dS F Y")); ?></span></p>		
				<?}	
				else if($date == $tom)
				{?>
					 <p class="title-tomorrow">Due Tomorrow <span class="date"><? print(Date("dS F Y", strtotime($yesterday))); ?></span></p>
				<?php
				}
				
			}
			else {
				
			}
			if($date!=$currDate && $date!=$tom && $printed == false) 
			{
				$printed = true;
				?>
				<p class="title-other">Others Due<span class="date"><? print(Date("dS F Y", strtotime($date))); ?></span></p>
			<?php
			}
			?>
				 
			<?php		 
			$i++;
		}
	}
	else 
	{
		echo "<p>".NO_PROJECTS_FOUND."</p>";
	}
	?> 
	<div class="clr-spacer"></div> 
	<!-- end Project bars --->
	<a href="#" class="readmore-btn">View all projects</a>
	<div class="clr"></div>
 	
 </div>
 <div class="col1">
 <?php
    if(count($data)>0)
    {?>
    <p>These are all the marked the projects that you have completed.</p>
    <div class="clr-spacer"></div> <div class="clr-spacer"></div>
	<?php
    }?>
    
    <!--<div class="pagination"> <a href="#">Day</a><a href="#" class="active">Week</a><a href="#" >Month</a><a href="#">Year</a> </div>-->
   
    <div class="indicator-wrapper">
    	<div class="left">
         <?php
        if(count($data)>0)
        {
        	foreach ($data as $rec)	
        	{?> 
         	 <div class="indicator">       
		         <div class="leftcol">
		          	<h3><?php echo trim(Sanitize::html($rec['Subject']['title']));?></h3>
		            <p class="title">Overall Mark:</p>
		            <div class="indicator-holder">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $rec['overTtl'];?>%"><?php echo $rec['overTtl'];?>%</div>
		              </div><!-- end indicator-bg -->
		            </div><!-- end indicator-holder -->
		          </div><!-- end leftcol -->
		          <div class="index">

		          <p class="title">Individual Projects</p>
		            <?php
		            foreach($rec['Project'] as $projects)
		            {?>
		         	<p class="underline-link"><?php echo trim(Sanitize::html($projects['title']));?></p>
		            <div class="indicator-holder">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $projects['total'];?>%"><?php echo trim(Sanitize::html($projects['total']));?>%</div>
		              </div><!-- end indicator-bg -->
		            </div>
					<?php
		            }?>		             
         		 </div><!-- end rightcol -->   
         		  <div class="clr"></div>
     		</div><!-- indicator -->       
			<?php
        	}
        }
        else 
        {
        	echo NO_PROJECT_COMPLETED;	
        }
        ?>	 
      </div> 
        <?php
        if(count($data)>0)
        {?>
		     <div class="right-report">
		      <h3>Overall Week Report</h3>
		      <p class="title">Projects completed: <span><?php echo $noOfProjectCompleted;?></span></p>
		      <p class="title">Projects late: <span><?php echo $lateProjects; ?></span></p>
		      <div class="clr-spacer"></div>
		      <h3>Overall Average</h3>
		      <div class="indicator-holder">
		        <div class="indicator-bg">
		        <?php
		        	$ttl = round(($overAllPrjctsMarks/$overAllPrjctsWeight)*100,2);	        	 
		        ?>
		        <div class="indicator-bar" style="width:<?php echo $ttl;?>%"><?php echo $ttl;?>%</div></div>
		          </div>
		      </div><!-- right -->  
    	<?php } ?>
    	<div class="clr"></div>
        </div><!-- end indicator-wrapper -->
 </div>