<script>
$(document).ready(function()
{
	$("a#addEducator").fancybox({				 
				ajax : {
				type	: "GET"
				}
			});
			
	$("a#addStudent").fancybox({				 
				ajax : {
				type	: "GET"
				}
			});
	
	$("a.assignUser").fancybox({
			 
				showCloseButton : false,
			 
				ajax : {type	: "GET"}				
	});
	
 	$("a.leaderUser").fancybox({				 
				showCloseButton : false,
				ajax : {type	: "GET"}				
	});
	
});

</script>
<ul>
	<?php
	if(count($data)>0)
	{
		$anyLeaderAdded = 0;
		?> 
		<?php
		foreach($data as $rec)
		{?>
			<li>
			<?php  
			if(isset($rec['DepartmentTeacher']['leader']) && $rec['DepartmentTeacher']['leader'] == 1)
			{	$anyLeaderAdded = 1;
				?>
				<span class="title">Department Leader:</span>
			<?}
			else 
			{?>
				
			<?php
			}
			?>

			<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $rec['User']['id'];?>" class="underline-link">
			<?php
			echo Sanitize::html(ucfirst($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>&nbsp;-&nbsp;
			<a class="edit" onclick="delUser(<?php echo $departmentId;?>, <?php echo $subjectID;?>, <?php echo $rec['User']['id'];?>, '<?php echo $viewType;?>')">Delete <?php
			if($viewType == "educator")
				echo "Educator";
			else 
				echo "Student";
			?></a>
			
			<?php  
			if(isset($rec['DepartmentTeacher']['leader']) && $rec['DepartmentTeacher']['leader'] == 1)
			{?>
				&nbsp;-&nbsp;<a class="edit leaderUser" href="<?php echo SITE_HTTP_URL?>dashboard/viewEducatorsForDepartmetnLeaders/<?php echo $departmentId;?>/">Replace Leader</a>
			<?php
			}
			?>
			</li>
		<?php
		}
		if($anyLeaderAdded == 0 && $viewType == "educator" && $subjectID == 0 )
		{?>
			<li><a class="edit leaderUser" href="<?php echo SITE_HTTP_URL?>dashboard/viewEducatorsForDepartmetnLeaders/<?php echo $departmentId;?>/">Assign Department Leader</a></li>
		<?php
		}
		?>	
	<?php
	}
	else {
		echo ERR_RECORD_NOT_FOUND;
	}
	?>
<li>
	<?php
	
	 
	if($viewType == "student")
	{?>
		<a class="edit assignUser" href="<?php echo SITE_HTTP_URL?>dashboard/assignUserToDepartment/student/<?php echo $departmentId;?>">Assign another student</a>&nbsp;-&nbsp;
		
		<a class="edit" id="addStudent" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/student/<?php echo $departmentId;?>">Add new student</a>	
	<?php
	}	
	elseif($subjectID > 0 ) // get the educator to be assigned to a subject
	{
	?>
		<a class="edit assignUser" href="<?php echo SITE_HTTP_URL?>dashboard/assignUserToDepartment/educator/<?php echo $departmentId;?>/<?php echo $subjectID; ?>">Assign another educator</a>

	<?php }
	else   // get the educator to be assigned to a department
	{
	?>
		<a class="edit assignUser" href="<?php echo SITE_HTTP_URL?>dashboard/assignUserToDepartment/educator/<?php echo $departmentId;?>">Assign another educator</a>&nbsp;-&nbsp;
		<a class="edit" class="button right" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/educator/<?php echo $departmentId;?>">Add new educator</a>	
	<?}?>
</li>
</ul>


<input type="hidden" id ="subjectID" name="subjectID" value="<?php echo $subjectID; ?>">
		