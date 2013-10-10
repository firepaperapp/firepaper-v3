<ul class="list-activity">
<?php
	if(count($data)>0)
	{
		$gotData = array();
		$preDate = "";
		$i = 0;
		$currDate = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime("-1 DAY"));
		foreach ($data as $rec)
		{	
			$date = date("Y-m-d", strtotime($rec['activityLog']['created']));
			if($preDate != $date)
			{
				if($i!=0)
				{
					echo "</ul><hr>
					<ul class='list-activity'>";
				}
				?>
				
				<?php	
				$preDate = $date;
				if($currDate == $date)
				{?>
					<span class="date"><span class="title-today">Today</span> <? print(Date("dS F Y")); ?></span>	
				<?}	
				else if($date == $yesterday)
				{?>
					 <span class="date"><span class="title-today">Today</span> <span class="date"><? print(Date("dS F Y", strtotime($yesterday))); ?></span>
				<?php
				}
				else 
				{?>
					<span class="date"><? print(Date("dS F Y", strtotime($date))); ?></span>
				<?php
				}
			}
			else {
				
			}
			echo "<li>".$rec['activityLog']['activity_text']." <span>- ".$this->Time->timeAgoInWords(strtotime($rec['activityLog']['created']))."</span></li>";
	 
			$i++;
			 
		}
	}else 
	{
		echo "<li>".NO_RECENT_ACTIVITY."</li>";
	}
	?>

	</ul>
<hr>
<div class="clr-spacer"></div>
<a href="<?php echo SITE_HTTP_URL?>dashboard/viewAllActivity/<?php echo $userId;?>" class="readmore-btn">View all activity</a>
<div class="clr"></div>
