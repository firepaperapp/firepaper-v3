<h3>Archived projects</h3>
<div class="right-snippet-wrapper">
      <div class="right-snippet">
		<?php 
			if(count($projectData) > 0 )
			{
		?>		
				<ul id="archived-list">
		<?php
				$a =0;
				$currentyr="";
				$prevyr="";
				$currentmonth="";
				$prevmonth="";
				$printyr = 1;
				$printmonth = 1; 
				
				for($a=0;$a < count($projectData);$a++)
				{
					if($a== count($projectData)-1 )
					{
					$offset = $a ;
					}
					else
					{
						$offset = $a +1;
					}
					$currentyr = date('Y', strtotime($projectData[$a]['Project']['created']));
					$prevyr = date('Y', strtotime($projectData[$offset]['Project']['created']));
		
					$currentmonth = date('m', strtotime($projectData[$a]['Project']['created']));
					$prevmonth = date('m', strtotime($projectData[$offset]['Project']['created']));
				
					// print the year
					if($printyr==1)
					{
						echo "<strong>$currentyr</strong>";				
					}
									
					if($printmonth==1)
					{
						echo "<li class='month'>".date('M', strtotime($projectData[$a]['Project']['created']))."</li>";					
					}
					//set conditions to print months	
					if($currentmonth==$prevmonth)
					{
						$printmonth =0;
					}
					
					//set conditions to print year
					if($currentyr!=$prevyr)
					{
						$printyr = 1;
						$printmonth = 1;
					}
					else
					{
						$printyr = 0;
					}
					
		?>		 	
					<li><a href="<?php echo SITE_HTTP_URL?>projects/viewDetails/<?php echo $projectData[$a]['Project']['id']; ?>"> <?php echo $projectData[$a]['Project']['title']?></a><li>
					
					
					
		<?php	}
				echo "</ul>";
		 	}
			else
			{
				
				echo "<p class='marginT10'>".ERR_NO_ARCHIVE_PROJECTS_FOUND."</p>"; 
			}
		?>
		 
			<a href="<?php echo SITE_HTTP_URL;?>projects/archivedProjects" class="readmore-btn marginT10">View later projects</a>
		<div class="clr"></div>
 	</div>
 </div>