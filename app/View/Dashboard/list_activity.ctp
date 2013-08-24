<ul class="list-activity">
    <?php
    if(is_array($data) && count($data)>0)
    {
    	foreach($data as $rec)	
    	{
    		if($rec['activityLog']['activity_text']!='')
    		{
  			echo "<li>".$rec['activityLog']['activity_text']." <span>- ".$this->Time->timeAgoInWords(strtotime($rec['activityLog']['created']))."</span></li>";;  		
    		}
    	}        	
	}
	else {
		echo "<li>".NO_RECENT_ACTIVITY."</li>";
	}
   ?> 
  </ul>
  <a href="<?php echo SITE_HTTP_URL?>dashboard/viewAllActivity" class="readmore-btn">View all activity</a>