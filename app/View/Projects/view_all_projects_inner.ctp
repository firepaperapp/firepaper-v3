<div class="marginT10">
	
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
<span class="duein-date"><span>Due Today </span><? print(Date("dS F Y")); ?></span>
				<? }	
				else if($date == $tom)
				{
					$b = "orange";
					?>
<span class="duein-date"><span>Due Tomorrow </span><? print(Date("dS F Y", strtotime($tom))); ?></span>
				<?php
				}
		 	}
			 
				/*if($date!=$currDate && $date!=$tom && $printed == false) 
				{	
					$printed = true;
					?>
					<span class="duein-date"><span>Others Due</span><? print(Date("dS F Y", strtotime($date))); ?></span>
				<?php
				}	*/	 
			?>
				
<div class="project-bar-wrapper" onClick="location.href='<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id'];?>';" style="cursor:pointer;">

	<div class="duein-date">
		<span>Due in:</span> <?php echo $this->Time->timeAgoInWords(strtotime($rec['Project']['created']));?>
	</div>
		<div class="project">
			<span class="<?php echo $b;?>"><?php echo $i;?></span>
			<div class="clr"></div>
			<em>Project</em>
		</div>
		<p class="project-title"><?php echo Sanitize::html($rec['Subject']['title']);?></p>

<!-- Progress bar -->
	<div class="progressbg">
		<div class="progressBar" style="width:<?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%;"></div>
	</div>
<!-- End Progress bar -->
<div class="completed-bubble">
		<span><?php echo $rec[0]['completed']>0?$rec[0]['completed']:0;?>%</span>
		<?php
			if($owner == 1)
				echo "Weight";
				else 
				echo "Completed";
		?>
	</div>
<!-- Details -->
	<div class="details">
		<h3>Details</h3>
		<p><?php echo Sanitize::html($rec['Project']['title']);?> </p>
		<div class="project-content">
		<span class="flat-files-icon"><span>&#xf15b;</span><?php echo $rec[0]['noOfFiles']>0?$rec[0]['noOfFiles']:0;?> Files</span> 
		<span class="flat-tasks-icon"><span>&#xf075;</span>
<?php echo $rec[0]['noOfComments']>0?$rec[0]['noOfComments']:0;?> Comments</span></div>
	</div>
<!-- End Details -->

	<div class="project-owner">
              <?php //echo "<pre>"; print_r($rec['User']);die;
if(is_file(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']))
{
	$userimage = USER_IMAGES_PATH.'100X100/'.$rec['User']['profilepic'];
}
else
{
	$userimage = IMAGES_PATH.'profile-pic.png';
}
?>
	<img id="imgid" alt="" height="55" width="55" src="<?php echo $userimage;?>" />
			<p class="title">Project leader:<br />
			<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $rec['Project']['leader_id'];?>" class="red"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>
				</p>
	</div><!-- end project-bar-wrapper -->	
</div>
		<!-- Project summary end here-->
	<?php		 
			$i++;
		}
		
	$this->Paginator->options(array('url' => $this->passedArgs));
	echo $this->element("pagination/ajax_pagination");
	}
	else 
	{
		echo "<p class='marginT10'><div class='empty-banner'>".NO_RECENT_PROJECTS_FOUND."</div></p>";
	}
	?> 
	<!-- end Project bars --->
	
</div>