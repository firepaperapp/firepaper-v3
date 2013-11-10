<div class="index">
    <h3>
    <?php
    if($user_id !=  $this->Session->read("userid"))
	{
		echo trim(ucfirst(Sanitize::html($userDetail['User']['firstname']." ".$userDetail['User']['lastname'])))." ";
	}
	else 
	{
		echo "My";
	}
	?>
     Progress</h3>
     <?php
    if(count($data)>0)
    {?>
    
	<?php } ?>
    
    <!--<div class="pagination"> <a href="#">Day</a><a href="#" class="active">Week</a><a href="#" >Month</a><a href="#">Year</a> </div>-->
   
    <div class="indicator-wrapper">
    	
    	 <?php
        if(count($data)>0)
        {?>
		     <div class="right-report">
		      <h3>Overall Week Report</h3>
		      <p class="title">Projects completed: <span><?php echo $noOfProjectCompleted;?></span></p>
		      <p class="title">Projects late: <span><?php echo $lateProjects; ?></span></p>
		      <div class="clr-spacer"></div>
		      <!--<h3>Overall Average</h3>
		      <div class="indicator-holder">
		        <div class="indicator-bg">
		        <?php
		        	$ttl = round(($overAllPrjctsMarks/$overAllPrjctsWeight)*100,2);	        	 
		        ?>
		        <div class="indicator-bar" style="width:<?php echo $ttl;?>%"><?php echo $ttl;?>%</div></div>
		          </div>
		      </div> -->  
    	<?php } ?>
    	<div class="clr"></div>
    	
         <?php
        if(count($data)>0)
        {
        	foreach ($data as $rec)	
        	{?> 
         	 <div class="indicator">       
		       
		          	<h3><?php echo trim(Sanitize::html($rec['Subject']['title']));?></h3>
		            <!--<p class="title">Overall Mark:</p>
		            <div class="indicator-container">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $rec['overTtl'];?>%"><?php echo $rec['overTtl'];?>%</div>
		              </div>
		            </div> -->
		         
		          <div class="index">

		          <p class="title">Individual Projects</p>
		            <?php
		            foreach($rec['Project'] as $projects)
		            {?>
		            <div class="clr"></div>  
		         	<p class="underline-link"><?php echo trim(Sanitize::html($projects['title']));?></p>
		            <div class="indicator-container">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $projects['total'];?>%"><?php echo trim(Sanitize::html($projects['total']));?>%</div>
		              </div><!-- end indicator-bg -->
		            </div>
		            
		            <!-- Graph -->
		            <canvas id="canvas" height="450" width="450"></canvas>
		            
		            <script>

		var doughnutData = [
				{
					value: 30,
					color:"#F7464A"
				},
				{
					value : 50,
					color : "#46BFBD"
				},
				{
					value : 100,
					color : "#FDB45C"
				},
				{
					value : 40,
					color : "#949FB1"
				},
				{
					value : 120,
					color : "#4D5360"
				}
			
			];

	var myDoughnut = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(doughnutData);
	
	</script>
					<?php
		            }?>		             
         		 </div><!-- end rightcol -->   
         		  <div class="clr"></div>
     		</div><!-- indicator -->       
			<?php
        	}
        }
        else 
        {
        	echo NO_PROJECT_COMPLETED;	
        }
        ?>	 
       
       
        </div><!-- end indicator-wrapper -->
 	</div><!-- end activity -->
 </div>