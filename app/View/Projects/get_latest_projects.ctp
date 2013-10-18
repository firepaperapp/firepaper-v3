
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
				<span class="duein"><span>Due Today</span> <? print(Date("dS F Y")); ?></span>
	
				<?php	
				$preDate = $date;
				if($currDate == $date)
				{?>
					<span class="duein-date"><span>Due Today</span><? print(Date("dS F Y")); ?></span>
				<?php }	
				else if($date == $tom)
				{ ?>
					 <span class="duein-date"><span>Due Tomorrow </span><? print(Date("dS F Y", strtotime($yesterday))); ?></span>
				<?php
				}
				
			}
			else {
				
			}
			if($date!=$currDate && $date!=$tom && $printed == false) 
			{
				$printed = true;
				?>
				<span class="duein-date"><span>Others Due </span><? print(Date("dS F Y", strtotime($date))); ?></span>
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