<div class="activity-panel-wrapper marginT10">
	<div class="activity-panel">
	<?php
	if(count($data)>0)
	{
		$gotData = array();
		$preSection = "";
		$i = 0;
		$currDate = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime("-1 DAY"));
		foreach ($data as $rec)
		{	  		
			if($preSection != $rec['ts']['section'])
			{?>					
				 
			<p class="title-today"><?php echo ucfirst($rec['ts']['section']); ?></p>
				<?php
				$preSection = $rec['ts']['section'];
			}
			else {
				
			}?>
			 <div class="msg-container">
			 	<?php
			 	$viewUrl = "";
			 	$id = $rec['ts']['gotId'];
			 	switch($rec['ts']['section'])
			 	{
			 		case "projects":
			 			$viewUrl = SITE_HTTP_URL."projects/viewDetails/";
			 			break;
			 		case "project comments":
			 			$viewUrl = SITE_HTTP_URL."dashboard/viewComments/";
			 			break;	
			 		case "whiteboard comments":
			 		case "whiteboards":
			 			$viewUrl = SITE_HTTP_URL."whiteboards/viewWhiteboard/";
			 			break;		 		
			 		case "files":
			 			$viewUrl = SITE_HTTP_URL."files/getFiles/";
			 			break;
			 	}
			 	if($rec['ts']['section'] == "project comments" || $rec['ts']['section'] == "whiteboard comments")
			 	{?>
		    	<div class="top"><img src="<?php echo IMAGES_PATH;?>icons/user.png" class="profile"/><p >Commented By: <a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['ts']['userid'];?>"><b><?php echo ucfirst(Sanitize::html($rec['ts']['name']));?></b></a></div>
	<?php } ?>
		      		
		        <div class="msg-body" onClick="" style="cursor:pointer;word-wrap: break-word;">
		        	
		        	<p><a href="<?php echo $viewUrl.$id;?>"><?php echo nl2br($rec['ts']['title']);?></a>
		        	</p>
		   		</div><!-- end msg-body -->
	 		</div><!-- end msg-container -->	 
	 		<?php
			$i++;		 
		}?>
		<div class="float:left;width:100%;margin-top:10px;">&nbsp;</div> 
		<?php 
		echo $this->element("pagination/ajax_pagination");?>
		<div class="clr"></div>
	<?php
	}else 
	{
		if($filters == "")
			echo "<p>Please enter search keyword.</p>";
		else 
			echo "<p>".ERR_RECORD_NOT_FOUND."</p>";
	}
	?> 
	
	</div><!-- end msg-body -->
</div>