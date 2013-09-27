<ul class="list-activity">
    <?php
    if(is_array($data) && count($data)>0)
    {
    	foreach($data as $rec)	
    	{
    		if($rec['activityLog']['activity_text']!='')
    		{
		    if(is_file(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']))
		    {
			    $userimage = USER_IMAGES_PATH.'100X100/'.$rec['User']['profilepic'];
		    }
		    else
		    {
			    $userimage = IMAGES_PATH.'profile-pic.png';
		    }
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