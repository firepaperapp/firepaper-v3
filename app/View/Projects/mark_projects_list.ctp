<script type="text/javascript">
$(document).ready(function()
{
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	loadPiece(siteUrl+"projects/projectsMarking/1"+"/?rand="+randomnumber,"#prjt_marked");
	//loadPiece(siteUrl+"projects/projectsMarking/0"+"/?rand="+randomnumber,"#prjt_unmarked");

});
</script>

	<div class="index page white">
	<?php
		if($this->Session->check('Message.flash'))
		{?>
			<div class="essage errorServer">
				<div class="success">
					<?php
					echo	$this->Session->flash(); // this line displays our flash messages
					?>
				</div>
			</div>
		<?php }
		?>
  <h3>Marking</h3>
  
	  <?php
		$currDate = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime("-1 DAY"));
		$dayBeforeYesterday = date("Y-m-d", strtotime("-2 DAY"));
	  ?>
	  <div class="files-container">
	    <div class="file-col1-wrapper">
	      <div class="files-box-wrapper">
	        <div class="files-box">
	          <p class="title-files">Today <span><? print(Date("dS F Y")); ?></span></p>
	          <?php
	          if(isset($projects[0]))
	          {
	          	foreach($projects[0] as $rec)
	          	{?>
		          	<?php
			 		if($rec['projectStudent']['marked'] == 0)
			 		{
			 			$icon = "project-new.png";
			 			$text = "Mark";
			 		}
			 		else 
			 		{
			 			$icon = "project-marked.png";
			 			$text = "Re-mark";
			 		}
			 		?>
	         	 <div class="project-name marginT10">
	         	 	<img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $icon;?>" /><span class="cat"><?php echo ucfirst(Sanitize::html($rec['Subject']['title']));?></span> ~ <a href="<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id']."/".$rec['User']['id'];?>><?php echo ucfirst(Sanitize::html($rec['Project']['title']));?></a>          	 
	            	<p class="file-links" style="padding-top:4px;"><span> <? print(date("H:ia", strtotime($rec['projectStudent']['submitted_date']))); ?> by </span><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>" class="edit"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>| <a href="<?php echo SITE_HTTP_URL."projects/markProject/".$rec['Project']['id']."/".$rec['User']['id'];?>" class="edit"><?php echo $text;?></a></p>
	            <div class="clr"></div></div>
				<?php
	          	}
	          }
	          else 
	          {
	          	echo "No projects submitted today.";
			  }?>
	          <div class="clr"></div>
	        </div><!-- end files-box -->
	      </div><!-- end files-box-wrapper -->
	      <div class="files-box-wrapper">
	        <div class="files-box">
	          <p class="title-files">Yesterday <span><? print(Date("dS F Y", strtotime($yesterday))); ?></span></p>
	            <?php
	          if(isset($projects[1]))
	          {
	          	foreach($projects[1] as $rec)
	          	{?>
	         	 <div class="project-name marginT10">
	         		<?php
			 		if($rec['projectStudent']['marked'] == 0)
			 		{
			 			$icon = "project-new.png";
			 			$text = "Mark";
			 		}
			 		else 
			 		{
			 			$icon = "project-marked.png";
			 			$text = "Re-mark";
			 		}
			 		?>
		 		
		 		<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $icon;?>" />
	 		<span class="cat"><?php echo ucfirst(Sanitize::html($rec['Subject']['title']));?></span> ~ <a href="<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id']."/".$rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['Project']['title']));?></a>          	 
	            	<p class="file-links" style="padding-top:4px;"><span> <? print(date("H:ia", strtotime($rec['projectStudent']['submitted_date']))); ?> by </span><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>" class="edit"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>| <a href="<?php echo SITE_HTTP_URL."projects/markProject/".$rec['Project']['id']."/".$rec['User']['id'];?>" class="edit"><?php echo $text;?></a></p>
	            <div class="clr"></div></div>
				<?php
	          	}
	          }
	          else 
	          {
	          	echo "No projects submitted yesterday.";
			  }?>
	            <div class="clr"></div>
	        </div><!-- end files-box -->
	      </div>
	      <div class="files-box-wrapper">
	        <div class="files-box">
	          <p class="title-files"><? print(Date("dS F Y", strtotime($dayBeforeYesterday))); ?></p>
	        	 <?php
	          if(isset($projects[2]))
	          {
	          	foreach($projects[2] as $rec)
	          	{?>
	         	 <div class="project-name marginT10">
	         		<?php
			 		if($rec['projectStudent']['marked'] == 0)
			 		{
			 			$icon = "project-new.png";
			 			$text = "Mark";
			 		}
			 		else 
			 		{
			 			$icon = "project-marked.png";
			 			$text = "Re-mark";
			 		}
			 		?>
		 		
	         	 <span class="cat"><?php echo ucfirst(Sanitize::html($rec['Subject']['title']));?></span> ~ <a href="<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id']."/".$rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['Project']['title']));?></a>          	 
	            	<p class="file-links" style="padding-top:4px;"><span> <? print(date("H:ia", strtotime($rec['projectStudent']['submitted_date']))); ?> by </span><a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>" class="edit"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>| <a href="<?php echo SITE_HTTP_URL."projects/markProject/".$rec['Project']['id']."/".$rec['User']['id'];?>" class="edit"><?php echo $text;?></a></p>
	            <div class="clr"></div></div>
				<?php
	          	}
	          }
	          else 
	          {
	          	echo NO_PROJECTS_FOUND;
			  }?>
			   <div class="clr"></div>
	        </div><!-- end files-box -->
	      </div>
	      <div class="clr"></div>
	    </div><!-- end file-col1-wrapper -->
	    <div class="file-col2-wrapper">
	      <div class="files-box-wrapper">
	        <div class="files-box"> 
	          <p class="title-files">To be marked <span></span></p>          
	          <div id="prjt_unmarked"></div>
	          <div class="clr"></div>
	        </div><!-- end files-box -->
	      </div>
	          
	         <div class="files-box-wrapper">
	        <div class="files-box">
	          <p class="title-files">Marked <span></span></p>        
	          <div id="prjt_marked"></div>
	          <div class="clr"></div>
	        </div><!-- end files-box -->
	      </div>
	        
	        <div class="clr"></div>
	      </div><!-- end file-col2-wrapper -->
	      <div class="clr"></div>
	    </div>
	 </div>	    
