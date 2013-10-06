<script>
 
</script>
<div class="version-documents projectTasks marginT10">	
	<form name="studSubmitTaskDoc_<?php echo $task_id;?>" id="studSubmitTaskDoc_<?php echo $task_id;?>" action="" method="post" onsubmit="return studentUploadDoc(<?php echo $task_id;?>);">
	    <div class="col-left-file">
		  <div class="date-cal">
		    <p class="number"><?php echo date("d", strtotime(date("Y-m-d")));?></p>
		    <p class="month"><?php echo date("M", strtotime(date("Y-m-d")));?></p>
		   </div>
		</div>
		<!-- end col-left -->
		<div class="col-middle">
			  <div class="doc-icon"><img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $fileDetail['fileType']['icon']?>" /></div>
			 <div class="file-name drag-file"><a href="javascript:void(0);" id="tool-tip" >
		        <?php 
		        $name = explode(".",$fileDetail['userFile']['file_name']);
		        echo $name[0]; 
		         ?></a>
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
	        <input type="submit" class="submit" value="Submit Task" />&nbsp;or&nbsp;<a href="javascript:void(0);"  onclick="$('#task_<?php echo $task_id;?>_box>div.projectTasks').hide('slow');$('#taskUnderDiv').hide('slow');" class="edit">Cancel</a>
	    </div>
		<div class="clr"></div>    	
	</form>		
</div>