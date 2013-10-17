<script>
 
</script>
<div class="version-documents projectTasks projectTaskHolder">	
	<form name="studSubmitTaskDocDrop_<?php echo $task_id;?>" id="studSubmitTaskDocDrop_<?php echo $task_id;?>" action="" method="post" onsubmit="return studentUploadDocDrop(<?php echo $task_id;?>);">
	 	<div class="col-middle">
			  <div class="doc-icon"><img src="<?php echo IMAGES_PATH;?>icons/<?php echo $fileDetail['fileType']['icon']?>" /></div>
			 <div class="file-name">
		        <?php 
		        $name = explode(".",$fileDetail['userFile']['file_name']);
		        echo $name[0]; 
		         ?>
	         </div>
	    </div> 
	    <div class="comment-link fl-left"><span>Comment</span></div>
	    
		<?php echo $this->Form->textarea('projComments.comment',array('div'=>false,'label'=>false,"id"=>"comment",'class'=>'text-field-comment'));?> 
	    <div class="clr"></div>
	    <div class="submit-wrapper">
	         <input type="hidden" name="data[projectStudentTaskDoc][title]" value="<?php echo  $name[0];?>" />
	        <input type="hidden" name="data[projectStudentTaskDoc][file_name]" value="<?php echo $fileDetail['userFile']['file_name'];?>" />
	        <input type="hidden" name="data[projectStudentTaskDoc][file_type_id]" value="<?php echo $fileDetail['userFile']['file_type_id'];?>" />
	           <input type="hidden" name="data[projectStudentTaskDoc][refer_file_id]" value="<?php echo $fileDetail['userFile']['id'];?>" id="refer_file_id"/>
	        
	        <input type="submit" class="submit" value="Submit Task" />&nbsp;or&nbsp;<a href="javascript:void(0);"  onclick="$('#droptask_<?php echo $task_id;?>_box>div.projectTaskHolder').hide('slow');" class="edit">Cancel</a>
	    </div>
		<div class="clr"></div>    	
	</form>		
</div>