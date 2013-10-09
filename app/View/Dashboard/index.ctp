


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
	 </div><!-- end right -->
 	<div class="index">
 	
 		<?php 
  		if($this->Session->read('user_type') != 1)
		{
			
 			echo $this->requestAction("/projects/getLatestProjects");
		}
 		else
 		{?>
 			
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

