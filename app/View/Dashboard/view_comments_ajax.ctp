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
	 
		$date = date("Y-m-d", strtotime($rec['ts']['created']));
		if($preDate != $date)
		{
			if($i!=0)
			{
				//echo "</ul><hr><ul class='list-activity'>";
			}
			?>					
			<?php	
			$preDate = $date;
			if($currDate == $date)
			{?>
				<span class="date"><span class="title-today">Today</span> <?php print(Date("dS F Y")); ?></span>	
			<?}	
			else if($date == $yesterday)
			{?>
				<span class="date"><span class="title-today">Yesterday</span> <?php print(Date("dS F Y", strtotime($yesterday))); ?></span> 

			<?php
			}
			else 
			{?>
				<span class="date"><?php print(Date("dS F Y", strtotime($date))); ?></span>
			<?php
			}
		}
		else {
			
		}?>
		 <div class="msg-container">
	       	<div class="top"><img src="<?php echo IMAGES_PATH;?>icons/user.gif" class="profile"/><p class="contact"><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a><span> - <? print(date("H:ia", strtotime($rec['ts']['created']))); ?></span></p> </div>
			<?php
			if(isset($rec['ts']['refer_file_id']) && $rec['fileType']['icon']!='')
			{?>
	       	<div class="doc-type"><img src="<?php echo IMAGES_PATH;?>icons/<?php echo $rec['fileType']['icon'];?>" /></div>
			<?php }?>	
	        <div class="msg-body" style="cursor:pointer;word-wrap: break-word;">
	        	
	        	<p><?php
				 	echo nl2br($rec['ts']['comment']);
	        	?>
	        	</p>
	   		</div><!-- end msg-body -->
	   		<?php
	   		if(isset($rec['ts']['project_id']) && $rec['ts']['project_id']!='')
	   		{?>
	   			<p>Commented under the <a class="edit" href="<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['ts']['project_id'];?>"><?php echo $rec['ts']['project_title']?></a> project</p>	
	   		<?php
	   		}
	   		?>
	   		
		</div><!-- end msg-container -->	 
 		<?php
		$i++;		 
	}
}else 
{
	echo "<p>".NO_LATEST_COMMENT."</p>";
}
?> 
<div class="float:left;width:100%;margin-top:10px;">&nbsp;</div> 
<?php 
echo $this->element("pagination/ajax_pagination");?>    
<div class="clr"></div>