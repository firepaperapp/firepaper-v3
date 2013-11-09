<script>
	function showAfter(thisR)
	{
		$(thisR).parent("span").next("span").show();
		$(thisR).hide();
	}
</script>

<div class="panel widget">
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
					<p class="title-today">Today <span class="date"><?php print(Date("dS F Y")); ?></span></p>		
				<?}	
				else if($date == $yesterday)
				{?>
					<p class="title-tomorrow">Yesterday <span class="date"><?php print(Date("dS F Y", strtotime($yesterday))); ?></span></p>  
	
				<?php
				}
				else 
				{?>
					<p class=""><span class="date"><?php print(Date("dS F Y", strtotime($date))); ?></span></p>
				<?php
				}
			}
			else {
				
			}?>
			 <div class="msg-container">
		       	<div class="top"><img src="<?php echo IMAGES_PATH;?>icons/user.png" class="profile"/>
		       	<p class="contact"><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>"><b>
		       	<?php
		       	$st = ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));
				if(strlen($st)>15)
						echo substr($st, 0 ,15)."...";
				else
		        		echo nl2br($st);
		        ?>
		       	</b></a><span> - <? print(date("H:ia", strtotime($rec['ts']['created']))); ?></span></p> </div>
				<?php
				 
				if(isset($rec['ts']['refer_file_id']) && $rec['fileType']['icon']!='')
				{?>
		       	<!--<div class="doc-type"><img src="<?php echo IMAGES_PATH;?>icons/<?php echo $rec['fileType']['icon'];?>" /></div>-->
				<?php }	?>
				
		        <div class="msg-body" onClick='<?php 
		        if(isset($rec['ts']['project_id']) && $rec['ts']['project_id']!='') { 
		        	if($this->Session->read("user_type")==1 || $this->Session->read("user_type")==2 ||$this->Session->read("user_type")==3 || $this->Session->read("user_type")==7)
				{
					echo 'window.location = "'.SITE_HTTP_URL.'projects/markProject/'.$rec['ts']['project_id'].'/'.$rec['User']['id'].'"'; 
				} 
				else 
				{
					echo 'window.location = "'.SITE_HTTP_URL.'projects/viewDetails/'.$rec['ts']['project_id'].'"'; 
				}
		
		        	
				};?>' >
		        	<p>
		        	<span class="text-exposed">
		        	<?php
		        	if(strlen($rec['ts']['comment'])>120)
						echo substr(nl2br($rec['ts']['comment']), 0 ,120)."<a onclick='showAfter(this);' class='edit'>...See More</a>";
						    		else
		        		echo nl2br($rec['ts']['comment']);
		        	?>	
		        	</span>
		        	<span class="text-hidden" style="display:none;">
		        		<?php
		        		echo substr(nl2br($rec['ts']['comment']),121 ,strlen($rec['ts']['comment']));		        		?>
		        	</span> 
		        	</p>
		   		</div><!-- end msg-body -->
			</div><!-- end msg-container -->	 
	 		<?php
			$i++;
			 
		}
	}else 
	{
		echo "<p>".NO_LATEST_COMMENT."</p>";
	}
	?>
	<div class="clr-spacer"></div> 
 	<!--<a href="<?php echo SITE_HTTP_URL."dashboard/viewComments/";?>" class="readmore-btn">View all messages</a>
 	<div class="clr"></div>-->
 
 </div>