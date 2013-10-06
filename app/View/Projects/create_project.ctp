<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.datepicker.js"></script>
<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.droppable.js"></script>

<!-- File Upload Progress bar -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script> 
<!-- File Upload Progress bar End -->
<div class="index white page">
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<?php echo $this->Form->create('Project', array('action'=>'createProject','type' => 'post','id'=>'Project')); ?>
<script> 
	var groupAdded = <?php echo json_encode($dataGroups);?>;	
	var userAdded = <?php echo json_encode($dataUsers);?>;	
	var whiteboardsAdded = <?php echo json_encode($dataWhiteboards);?>;	
</script>
<script type="text/javascript">
$(document).ready(function(){
		
                $("#duedate").datepicker({
				dateFormat: 'D MM yy',
				showOn: 'button',
				buttonImage: siteImagesUrl+'calendar.png',
				changeMonth: true,
				changeYear: true,
				minDate: new Date(),
				buttonImageOnly: true
		});
		
});
</script>
<style>
    #duedate{
        width: 100%
    }
</style>				
	<h1>
	<?php
 	if($project_id!=0)
	{
		$mode = "edit"; 
		echo "Update";
	}
	else
	{
		$mode = "add";
		echo "Create a";
	}
	?> Project</h1>
	
	<div class="clr"></div>
	<div id="projectCreated"></div>
    <div id="createProject">
	    
	    <h3>Course title</h3>
	     <?php echo $this->Form->input('title',array('id'=>'projectTitle', 'tabindex'=>1,'div'=>false,'label'=>false,'maxlength'=>'150','class'=>'title-field'));?>
	      <h3>Details</h3>  
	      <?php echo $this->Form->input('description',array('id'=>'projectDesc','tabindex'=>2, 'div'=>false, 'label'=>false,'type'=>'textarea','class'=>'text-field'));?>
	      <div class="line"></div>
	      <h3>Course deadline</h3>
	          <span class="pickdate"> <?php echo $this->Form->text('duedate',array('id'=>'duedate','tabindex'=>3, 'div'=>false,'label'=>false, 'class'=>'date-field','readonly'=>'true'));?></span>
	          
	          
	      <div class="line"></div>
	      <h3>Select a subject</h3>
	            <select name="data[Project][subject_id]" id="subject_id" tabindex="4" class="dropdown">
	            <option value="">Please Select</option>
	             <?php
	             	$st = "";
					if(count($subjects)>0)
					{		
						$dept = array();				
						foreach($subjects as $rec)
						{
							$dept[$rec['Department']['id']][] = $rec;
						}
						foreach ($dept as $rec)
						{
							$st.='<optgroup label="'.$rec[0]['Department']['title'].'">';
							foreach ($rec as $gotRec)
							{
								$selected = "";
								if(isset($this->request->data['Project']['subject_id']) && $this->request->data['Project']['subject_id'] == $gotRec['Subject']['id'])
									$selected= "selected = 'selected'";
								$st.='<option value="'.$gotRec['Subject']['id'].'" '.$selected.'>'.$gotRec['Subject']['title'].'</option>';
							}
							$st.='</optgroup>';
						}
					}
					echo  $st;

				?>
				</select>	
	             <?php
	 			if(count($subjects) == 0 && ($this->Session->read("user_type") == 1 || $this->Session->read("user_type") == 7 ))
	 			{
	 				echo "<p><a class='edit' href='".SITE_HTTP_URL."/departments'>Create a Subject</a></p>";
	 			}?>
	 			
	            <div class="line"></div>
	            
	            <h3>Owner</h3>
	            <?php
	            if ($this->Session->read("user_type") == 1 || $this->Session->read("user_type") == 7 ) 
	            {
	            	 //print_r($teachers);die;
	           		echo '<p id="leader">'.$this->Form->input('leader_id',array('type'=>'select','div'=>false,'tabindex'=>5, 'label'=>false,'value'=>$lid,'options'=>$teachers,'id'=>'cardtype','class'=>'dropdown','empty'=>"Select an owner"))."</p>";
	           		?>
	           		<!--<a id="addedu" class="red" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/educator/0">Add a new owner</a>-->
	           		
	           		<?php
	            }
	            else 
	            {
		         	echo "<input type='hidden' name='data[Project][leader_id]' tabindex='6' id='leader_id' value='".$this->Session->read("userid")."' /><p>You</p>";   	
				}
	           ?>
	          <!-- <a href="javascript:void(0)" class="submit" id="createProjectBtn" onclick="submitProject(2)">Continue</a>&nbsp;&nbsp;-->
	           
	          
	          <div class="clr"></div>
	      	     
	      <!-- end project wrapper -->      
	     
	     <input type="hidden" id="project_id" name="data[Project][project_id]" value="<?php echo $project_id;?>" />
  		 </form>
    </div>   

     <div class="clr"></div>
     <?php
     	$d = "display:none;";
     	if(isset($this->request->params['url']['m']) && $this->request->params['url']['m'] == "e")
     	{
     		$d = "display:block;";
     	}
     ?>
     <div class="line"></div>
 	<div id="docAndTask" style="<?php //echo $d;?>">
 	 	<div class="left">
	    	<h3>Documents <span>&amp;</span> Tasks</h3>
	 	</div>
	    <div class="right">
	    	<h3>Weight</h3>
	    </div>
	    <div class="clr"></div>
	    	<h3>Create a Task</h3>
	    <div class="clr"></div>
	   	<div id="loaderJsTask"></div>
		        
			<div class="project-drop-area-wrapper">
				<div class="task-wrapper">
				<a href="javascript:void(0)" onclick="createTaskEmpty()" class="button">+ Create a Task</a> Or you can add a document below
				</div>			
			 
				<div class="dropFileHere project-drop-area">
					<p>Drag and drop a document here</p>
					
					<form id="file_upload" action="<?php echo SITE_HTTP_URL;?>files/uploadFile" method="POST" enctype="multipart/form-data">
		    		<input type="file" class="uploadfile" id="uploadfile" name="data[userFile][uploadfile]" />    	 
		    		 <button>Upload</button>
		   			 <div>Upload files</div> 
					</form>  
					
					<!--<a id="uploadfile" name="data[userFile][uploadFile]" class="edit">Upload it</a>-->
					<table id="files"></table>
				</div>
			

		</div>
		<div class="clr"></div>
		<div style="margin-bottom:20px;">
		  	<div id="validation-container-task" class="validation-signup" style="display:none;"></div>
		  	<div id="validation-container-success-task" class="success" style="display:none;"></div>
		</div>
	     <div class="project-brief-box-wrapper" id="createTaskDiv" style="display:none;">
	    	<form action="" name="createTaskForm" id="createTaskForm" method="POST">	
				<div class="project-drop-area-wrapper">
					
		   			<h3>Your task title<span class="mandatory">*</span></h3>
		   			<?php echo $this->Form->input('projectTask.title',array('div'=>false,'label'=>false,"id"=>"taskTitle",'maxlength'=>'150','class'=>'task-input'));?> 
		   			
		     		<div class="weight-col">
		     		<p>Add your weight &rarr;</p>
		    			 
		    			<?php echo $this->Form->input('projectTask.weight',array('div'=>false,'label'=>false,"id"=>"taskWeight",'maxlength'=>'3','class'=>'weight-input'));?> 
		    			
		     		</div>
		    		<div class="clr"></div>
		    		<h3>Comment</h3>
		    		
		        	
		        	
		        	<?php echo $this->Form->textarea('projComments.comment',array("id"=>"comment",'class'=>'text-field-comment'));?> 
	
		        	<div class="clr"></div>
		        	<div class="submit-wrapper">
		    			<input type="submit" name="btnSubmitTask" class="submit" value="Submit" /> <span>&nbsp;or <a href="javascript:void(0);" class="edit" onclick="$('#createTaskDiv').hide('slow');"/>cancel</a></span>
					</div>
	 				<div class="clr"></div>
				</div>
			</form>	
		</div>
		<div class="clr"></div>
<div id="taskUnderDiv"></div>

	  	
	  	<div id="createdTasks" >
	   		<?php
	  		$noOftasks = 0;

	  		if(isset($projTasks[0]['projectTask']['id']) && count($projTasks)>0)
	  		{
  				foreach($projTasks as $rec)
	  			{
	  				$noOftasks++;
	  			?>
	  			
	  			<div  id="createdTasksCl_<?php echo $rec['projectTask']['id']?>">
			        <div class="project-brief-box-wrapper createdTasksCl">
			        <div class="project-rule"></div>
				           <div class="project-drop-area-wrapper">
				           		<div class="weight-col" ><span class="editTaskWeight" id="taskWeight_<?php echo $rec['projectTask']['id']?>"><?php echo $rec['projectTask']['weight']?></span>%<a class="editLink edit" id="<?php echo $rec['projectTask']['id']?>"> Edit</a></div>
					          	<?php //pa($rec['projectTask']);
					  			if(!isNull($rec['projectTask']['refer_file_id']))
					  			{?>
					  			<div class="doc-icon">
					  				
									<img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $rec['fileType']['icon']?>" /></div>
									
									<div class="file-name"><a href="<?php echo SITE_HTTP_URL;?>files/downloadFile/<?php echo $rec['projectTask']['refer_file_id'];?>"><?php echo $rec['projectTask']['title'];?></span></a>
					  			<?php
					  			}	
								else
								{?>
									<div class="file-name"><?php echo $rec['projectTask']['title'];?>
								<?php
								}
								?> <a href="javascript:void(0);" class="edit" onclick="delTaskFromProject(<?php echo $rec['projectTask']['id']?>)">Delete Task</a>
								<span id="extraDoc_<?php echo $rec['projectTask']['id']?>" style="
								<?php
								if($rec[0]['extraDocs'] == 0)
								{?>display:none;<?php }?>">&nbsp;-&nbsp;
								<a href="javascript:void(0);" class="edit" onclick="viewExtraTaskDocs(<?php echo $rec['projectTask']['id']?>)">View Other Docs</a>
								</div>
								
								
	<p class="file-links"><span> <? print(Date("dS F Y", strtotime($rec['projectTask']['created']))); ?> at <? print(date("H:ia", strtotime($rec['projectTask']['created']))); ?></span>&nbsp;-&nbsp;<a href="javascript:void(0);" class="addcommentlink" id="addcomment_<?php echo $rec['projectTask']['id'];?>">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="viewTskComments viewTskCommentsLink" id="viewTskComments_<?php echo $rec['projectTask']['id'];?>"><?php echo count($rec['projComments']);?> Comment(s)</a></p> 
					
					
						<!-- HTML To add a Comment for user task Doc -->
						<div class="addcomment marginT10" id="addcomment_<?php echo $rec['projectTask']['id'];?>_box" style="display:none;width:300px;">
								<p class="task-comment-title">Add a comment</p>
								
					          	<textarea name="addcommenttext_<?php echo $rec['projectTask']['id'];?>" id="addcommenttext_<?php echo $rec['projectTask']['id'];?>" class="text-field-comment"></textarea>
					          	<div class="submit-wrapper">
					          		<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $rec['projectTask']['id'];?>, <?php echo $rec['projectTask']['id'];?>);" class="submit"/>
                					or <a class="edit" href="javascript:void(0);" onclick="$('#addcomment_<?php echo $rec['projectTask']['id'];?>_box').slideUp('slow');">Cancel</a>
                					</div>
                 				<div class="clr"></div>			
				        </div>    
				        <!-- HTML END To add a Comment for user task Doc -->
					
					<div class="clr"></div>
					<div class="width100Per" id="viewTskComments_<?php echo $rec['projectTask']['id'];?>_box" style="display:none;width:500px;">	
				 	    
					 </div>
					 <div id="loaderJsTask_<?php echo $rec['projectTask']['id']?>"></div>
					 <table id="uploadRevison_<?php echo $rec['projectTask']['id']?>"></table>
 	  				<div class="dropTaskFileHere project-drop-area" id="task_<?php echo $rec['projectTask']['id']?>">
						<p>Drag a document here <span>or</span> 
						<form id="fileupload_<?php echo $rec['projectTask']['id']?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile/" method="POST" enctype="multipart/form-data" class="extraTaskDocs file_upload">
			    		 <input type="file" class="uploadfile" id="uploadfile_<?php echo $rec['projectTask']['id']?>" name="data[userFile][uploadfile]" />    	 
			    		 <button>Upload</button>
			   			 <div>Upload files</div> 
						</form>  
						<!--<a id="uploadfile" name="data[userFile][uploadFile]" class="edit">Upload it</a>-->
					</div>
					<div class="width100Per" id="extraDocs_<?php echo $rec['projectTask']['id'];?>" style="display:none;width:480px;">	
				 	    
					 </div><div class="clr"></div>
				      </div> 
				      
				   </div>
				  	
	  			   <div class="clr"></div><!--<div class="clr-spacer"></div>-->
				</div>
			<script>	
				var btnUpload = $('#uploadfile_<?php echo $rec['projectTask']['id']?>');
		var status = $('#loaderJsTask_<?php echo $rec['projectTask']['id']?>');
		
		 $('#fileupload_<?php echo $rec['projectTask']['id']?>').fileUploadUI({
		 	dragDropSupport: true,
			namespace: 'file_upload_<?php echo $rec['projectTask']['id']?>',
			cssClass : 'file_upload_<?php echo $rec['projectTask']['id']?>',
	        uploadTable: $('#uploadRevison_<?php echo $rec['projectTask']['id']?>'),
	        downloadTable: $('#uploadRevison_<?php echo $rec['projectTask']['id']?>'),
	        buildUploadRow: function (files, index) {
	             return $('<tr><td>' + files[index].name + '<\/td>' +
	                    '<td class="file_upload_progress"><div><\/div><\/td>' +
	                    '<td class="file_upload_cancel">' +
	                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
	                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
	                    '<\/button><\/td><\/tr>');
	        },
	        buildDownloadRow: function (response) {
	        	//Add uploaded file to list
						if("undefined" == typeof(response.success))
						{
							$("#validation-container-task").empty().html("<p class='error'>"+response.error+"</p>").show();
							$("#validation-container-success-task").empty().hide();
	
						} else{	 
								$("#validation-container-task").empty().hide();
								$("#validation-container-success-task").empty().html(response.success).show();
								$('.file_upload').removeClass('file_upload_large');
								$('.file_upload').removeClass('file_upload_highlight');
								$.get(siteUrl+"projects/createTaskDoc/"+response.id+"/?v="+Number(new Date()),function(data)
								{	 
									$("div#taskUnderDiv").empty().html(data).show('slow');	
									$("#loaderJsTask_<?php echo $rec['projectTask']['id']?>").hide();
									$(".dropFileHere").fadeOut('slow');
								}
								);
						}        
	        }
	    });
			</script>		
	  			<?php
	  			}

	  		}
	  		else {
	  			//echo '<p id="taskMsgDiv" style="padding:5px;">'.CREATE_TASK.'</p>';
	  		}
	  		?>
	   	</div>
	  	<div class="clr"></div>
	<form action="" name="saveProjForm" id="saveProjForm" method="POST" onsubmit="return false;">
        <div class="line"></div>
	      <h3>Invite</h3>
	           <div class="width100per">
		           <div class="add-people"> 
					<p><strong>Note:</strong> Enter the keyword to search groups</p>
						<select id="usersGroups" name="usersGroups"></select>
					</div>
					<div class="clr-spacer"></div>
							<div class="add-people">
								 <p><strong>Note:</strong> Enter the keyword to search premium students</p>
							<select id="otherUsers" name="otherUsers"></select>
							</div>
							<div id="containerLoader"></div>
							<p id="showAddMore" class="width100per" style="display:none;">No records found.</p>
							<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
				
        <?php
        if($mode == "edit" && (isset($this->request->data['Project']['published']) && $this->request->data['Project']['published'] == 1))
        {?>
       <div class="clr"></div>
	        <h3>Changes In Project</h3>
	 	    <p><strong>Note:</strong> Please enter the changes that you made.</p>
	          		<?php echo $this->Form->textarea('projComments.comment_project',array("id"=>"comment_project",'class'=>'text-field-comment'));?>
	        
		<?php }?>
        </form>
        <div class="clr-spacer-height"></div>
            <?php
		    if(isset($data['Project']['published']) && $data['Project']['published']==1)
		    {?>
		    	<a href="javascript:void(0);" class="submit" onclick="saveProjFormH(1);">Send project</a>
		   	<?php
		    }
			else 
			{?>
			<p>	<a href="javascript:void(0);" class="submit" onclick="saveProjFormH(0);">Save in drafts</a> 
				<a href="javascript:void(0);" class="submit" onclick="saveProjFormH(1);">Send project</a>	
			</p>
			<?php
			}    
		 	?>
		 
  
  	</div>
  	<div id="loaderJs"></div>  
  	<input type="hidden" name="tasksCount" id="tasksCount" value="<?php echo $noOftasks;?>" />
</div>

<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   


<script type="text/javascript" src="<?php echo JS_PATH?>projects.js"></script>
<script src="<?php echo JS_PATH ?>jquery.jeditable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.livequery.js"></script> 
<!-- end activity -->