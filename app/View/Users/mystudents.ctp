<div class="index page white">
	<h3>Students</h3>
 	<!-- Inner Content List start -->
	<div class="row">
   	 <?php $k=1; $j=0;
   	 $i = 0;
 	 foreach($data as $students)
	 { 
	 		if($i%3==0 && $i!=0)
	 		{
	 		?>
			<!--	<div class="clr"></div>-->
  			  </div>
       		 <div class="row">
       		 	<div class="user-box-wrapper">
				<div class="user-box-left">		 			
	   <?php }
	   		 else 
	   		 {
	   		 	if($i==0)
	   		 	{?>
	   		 		<div class="user-box-wrapper">
	   		 		<div class="user-box-left">
	   		 	<?php 
	   		 	}
	   		 	else {
	   		 	?>
	   		 		<div class="user-box-wrapper">
	   		 		<div class="user-box">	
	   		 	<?php 
	   		 	}
	   		 }
	   		?><div class="imgclass"><img src="<?php echo $students['User']['profilepic'];?>" class="profile" /></div>
		       <?php $editpgurl = SITE_HTTP_URL."users/viewProfile/".$students['User']['id'];?>
				<div class="links">
					<p class="title"><a id="edituserprof" href="<?php echo $editpgurl; ?>"><b><?php echo ucfirst(Sanitize::html($students['User']['firstname']." ".$students['User']['lastname']));?></b></a>
					</p>
 			      </div>
				<div class="clr"></div>
		    </div>  
		    </div>
	<?php
	$k++;	
     $i++;		 
     
	 }?>
	 <div class="clr"></div>
 </div>
</div>