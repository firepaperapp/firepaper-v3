


<div class="index">
<h3>Latest projects</h3>
	<?php
		if($this->Session->check('Message.flash'))
		{?>
			<div class="essage errorServer">
				<div class="success">
					<?php
						$this->Session->flash(); // this line displays our flash messages
					?>
				</div>
			</div>
		<?php }
	?> 
	<?php 
	if($announce_view=='admin'){
		echo $this->requestAction("/announcements/today");
	}
	if($announce_view=='student'){
	echo $this->requestAction("/announcements/students");
	}
	
	?>

 	
 		<?php 
  		if($this->Session->read('user_type') != 1)
		{
			
 			echo $this->requestAction("/projects/getLatestProjects");
		}
 		else
 		{?>
 			<?php
    if(count($data)>0)
    {?>
    <p>These are all the marked the projects that you have completed.</p>
    <div class="clr-spacer"></div> <div class="clr-spacer"></div>
	<?php
    }?>
    
    <!--<div class="pagination"> <a href="#">Day</a><a href="#" class="active">Week</a><a href="#" >Month</a><a href="#">Year</a> </div>-->
   
    <div class="indicator-wrapper">
    	<div class="left">
         <?php
        if(count($data)>0)
        {
        	foreach ($data as $rec)	
        	{?> 
         	 <div class="indicator">       
		         <div class="leftcol">
		          	<h3><?php echo trim(Sanitize::html($rec['Subject']['title']));?></h3>
		            <p class="title">Overall Mark:</p>
		            <div class="indicator-holder">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $rec['overTtl'];?>%"><?php echo $rec['overTtl'];?>%</div>
		              </div><!-- end indicator-bg -->
		            </div><!-- end indicator-holder -->
		          </div><!-- end leftcol -->
		          <div class="index">

		          <p class="title">Individual Projects</p>
		            <?php
		            foreach($rec['Project'] as $projects)
		            {?>
		         	<p class="underline-link"><?php echo trim(Sanitize::html($projects['title']));?></p>
		            <div class="indicator-holder">
		              <div class="indicator-bg">
		                <div class="indicator-bar" style="width:<?php echo $projects['total'];?>%"><?php echo trim(Sanitize::html($projects['total']));?>%</div>
		              </div><!-- end indicator-bg -->
		            </div>
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
      </div> 
        <?php
        if(count($data)>0)
        {?>
		     <div class="right-report">
		      <h3>Overall Week Report</h3>
		      <p class="title">Projects completed: <span><?php echo $noOfProjectCompleted;?></span></p>
		      <p class="title">Projects late: <span><?php echo $lateProjects; ?></span></p>
		      <div class="clr-spacer"></div>
		      <h3>Overall Average</h3>
		      <div class="indicator-holder">
		        <div class="indicator-bg">
		        <?php
		        	$ttl = round(($overAllPrjctsMarks/$overAllPrjctsWeight)*100,2);	        	 
		        ?>
		        <div class="indicator-bar" style="width:<?php echo $ttl;?>%"><?php echo $ttl;?>%</div></div>
		          </div>
		      </div><!-- right -->  
    	<?php } ?>
    	<div class="clr"></div>
        </div><!-- end indicator-wrapper -->
 		<script>
			function getStuAndTeachers()
			{
				if($("#department_act").val() == "")
				{
					alert("Please select department first.");
				}
				else
				{
					$("#stuTeacher").empty().html(loader);
					$.get(siteUrl+"dashboard/getStuAndTeachersForDept/"+$("#department_act").val()+"/?v="+Number(new Date()),function(data)
					{
			 			$("#stuTeacher").empty().html(data);
					}
					);
				}
			}
			function getActivityFor()
			{
				var id = 0;
				if($(this).attr("id") == "students_act")
				{
					//students
					$("#teacher_act").val("");
					id = $("#students_act").val();
				}
				else
				{
					$("#students_act").val("");
					id = $("#teacher_act").val();
					//teachers
				}
		 		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
				$("#gotActivity").empty().html(loader);
				$.get(siteUrl+"dashboard/adminLatestActivity/"+id+"/?v="+randomnumber,function(data)
				{
	 	 			$("#gotActivity").empty().html(data);
				}
				);
			}
			$(document).ready(function(){
		        
		   	 });
		</script>
	
		  <div class="latest-activity">
			
				<div class="upload-container">
					<p>Filter by: </p>
					<?php echo $this->Form->input('department',array('type'=>'select','div'=>false,'label'=>false,'options'=>$deptList,'id'=>"department_act","onchange"=>"getStuAndTeachers();","empty"=>"Please Select"));?>
					<span id="stuTeacher"></span>
				</div>
		 		<div id="gotActivity">
		 		<?php
		 		echo $this->requestAction("/dashboard/adminLatestActivity");
		 		?>
		 		</div>
		 </div>
 		<?php
 		}
 		?>	
 
<?php 
if(!isset($usertype) || $usertype!=6)
echo $this->requestAction("/files/activityFilesProjectsDropbox");?>
   </div><!-- end left --> 
 	</div><!-- end right -->

