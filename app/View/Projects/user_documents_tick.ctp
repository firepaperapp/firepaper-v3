<script>
 
</script>
<?php
//$url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
if($canChnage == 1)//  && (false !==  strpos($url , 'projects/viewDetails/')))
{?>
<div class="version-documents projectTasks projectTasksHolder marginT10" id="mytick_<?php echo $task_id;?>_box" style="width: 300px;">	
	<form name="studSubmitTaskDocDrop<?php echo $view;?>_<?php echo $task_id;?>" id="studSubmitTaskDocDrop<?php echo $view;?>_<?php echo $task_id;?>" action="" method="post" onsubmit="return studentUploadDocTick<?php echo $view;?>(<?php echo $task_id;?>);">
	  	<!-- end col-left -->
		<div class="col-middle">
			  <p><input type="checkbox" class="chkTask" name="data[projectStudentTaskDoc][taskDone]">&nbsp;I have done this task.</p>
	    </div> 
	  <!--  <div class="comment-link fl-left">
	    <h3>Comment</h3>
	    </div>-->
	    
		
	    <?php // echo $this->Form->textarea('projComments.comment',array('div'=>false,'label'=>false,"id"=>"comment",'class'=>'text-field-comment'));?> 
	    
	    <div class="clr"></div>
	    <div class="submit-wrapper">
	        <input type="hidden" name="data[projectStudentTaskDoc][title]" value="Task Completed" />
	        <input type="hidden" name="data[projectStudentTaskDoc][file_name]" value="" />
	        <input type="hidden" name="data[projectStudentTaskDoc][file_type_id]" value="" />
	        <input type="hidden" name="data[projectStudentTaskDoc][refer_file_id]" value="0" id="refer_file_id"/>	        
	        <input type="submit" class="submit" value="Submit Task" />&nbsp;or&nbsp;<a name="btnCancel1" href="javascript:void(0)" class="edit" onclick="$('#droptask_<?php echo $task_id;?>_box').hide('slow');$('#mytick_<?php echo $task_id;?>_box').hide('slow');">Cancel</a>
	    </div>
		<div class="clr"></div>    	
	</form>		
</div>
<?php
}
else 
{
	if($isSubmitted == 0)
		echo "Project is closed.";
	else  
		echo "This task is done.";
	if($view=="Large" && isset($docsArr[0]['prjTaskUserDoc']))
	{
		$docs = $docsArr[0]['prjTaskUserDoc'];
 		?>
		&nbsp;-&nbsp;
		<a href="javascript:void(0);" class="edit addcommentlink" id="addcomment_<?php echo $docs['id'];?>">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="edit viewTskCommentsInner viewTskCommentsLink" id="viewTskComments_<?php echo $docs['id'];?>"><?php echo $docsArr[0][0]['cnt_comment'];?> Comment(s)</a>
						
		<!-- HTML To add a Comment for user task Doc -->
		
		
		<div class="addcomment marginT10" id="addcomment_<?php echo $docs['id'];?>_box" style="display:none;width:300px;">
			<div class="comment-link fl-left"><span>Comment</span></div>
    		<div class="comment-point-add"></div>
			<textarea name="addcommenttext_<?php echo $docs['id'];?>" id="addcommenttext_<?php echo $docs['id'];?>" rows="5" cols="40"></textarea>
			 <div class="clr"></div>
    		 <div class="submit-wrapper">
		      	<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $docs['id'];?>, <?php echo $task_id;?>);" class="submit"/>&nbsp;or&nbsp;<a name="btnCancel1" href="javascript:void(0)" class="edit" onclick="$('#addcomment_<?php echo $docs['id'];?>_box').slideUp('slow');">Cancel</a>
		     
		      </div>
		</div>    
		<!-- HTML END To add a Comment for user task Doc -->
		
		<div class="clr"></div>
		<div class="col-middle ">
		<div class="width100Per" id="viewTskComments_<?php echo $docs['id'];?>_box" style="display:none;width:500px;">		 
		
		</div></div><div class="clr"></div>
	<?php
	}
	?>
<?php 
}?>


<div class="clr"></div>