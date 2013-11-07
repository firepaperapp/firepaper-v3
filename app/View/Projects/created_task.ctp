<script>
 
$(document).ready(function(){
 

});
</script>
<div id="createdTasksCl_<?php echo $rec['projectTask']['id']?>">
<div class="project-brief-box-wrapper createdTasksCl">
       <div class="project-drop-area-wrapper">
       		<div class="weight-col" style="width:50px;">
       		<span class="editTaskWeight" id="taskWeight_<?php echo $rec['projectTask']['id']?>"><?php echo $rec['projectTask']['weight']?>%</span>
       		
       		</div>
          	<?php //pa($rec['projectTask']);
  			if(!isNull($rec['projectTask']['refer_file_id']))
  			{?>
  				<a href="<?php echo SITE_HTTP_URL;?>files/downloadFile/<?php echo $rec['projectTask']['refer_file_id'];?>"><img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $rec['fileType']['icon']?>" /><span class="task-title"><?php echo $rec['projectTask']['file_name'];?></span></a>
  			<?php
  			}	
			else
			{?>
				<div class="clr"></div>
				<span class="task-icon">✓</span><span class="task-title"><?php echo $rec['projectTask']['title'];?></span>
			<?php
			}
			?>&nbsp;-&nbsp;<a href="javascript:void(0);" class="edit" onclick="delTaskFromProject(<?php echo $rec['projectTask']['id']?>)">Delete Task</a>
			
			<span id="extraDoc_<?php echo $rec['projectTask']['id']?>" style="display:none;">&nbsp;-&nbsp;
			<a href="javascript:void(0);" class="edit" onclick="viewExtraTaskDocs(<?php echo $rec['projectTask']['id']?>)">View Other Docs</a>
			</span>
			
			
			<p class="file-links"><span> <? print(Date("dS F Y", strtotime($rec['projectTask']['created']))); ?> at <? print(date("H:ia", strtotime($rec['projectTask']['created']))); ?></span>&nbsp;-&nbsp;<a href="javascript:void(0);" class="addcommentlink" id="addcomment_<?php echo $rec['projectTask']['id'];?>">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="viewTskComments viewTskCommentsLink" id="viewTskComments_<?php echo $rec['projectTask']['id'];?>"><?php echo $commentsFortask;?> Comment(s)</a></p> 


	<!-- HTML To add a Comment for user task Doc -->
	<div class="addcomment marginT10" id="addcomment_<?php echo $rec['projectTask']['id'];?>_box" style="display:none;">
			<h3>Add a comment</h3>
			
          	<textarea name="addcommenttext_<?php echo $rec['projectTask']['id'];?>" id="addcommenttext_<?php echo $rec['projectTask']['id'];?>" class="text-field-comment"></textarea>
          	<div class="submit-wrapper">
          		<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $rec['projectTask']['id'];?>, <?php echo $rec['projectTask']['id'];?>);" class="submit"/>
				or <a class="edit" href="javascript:void(0);" onclick="$('#addcomment_<?php echo $rec['projectTask']['id'];?>_box').slideUp('slow');">Cancel</a>
				</div>
				<div class="clr">&nbsp;</div>			
    </div>    
    <!-- HTML END To add a Comment for user task Doc -->

	<div class="clr"></div>
	<div class="width100Per" id="viewTskComments_<?php echo $rec['projectTask']['id'];?>_box" style="display:none;width:500px;">	
 	    
	 </div>
	 <div class="clr"></div>
	 <div id="loaderJsTask_<?php echo $rec['projectTask']['id']?>"></div>
			<div class="dropTaskFileHere project-drop-area" id="task_<?php echo $rec['projectTask']['id']?>">
		<p>Drag a document here or</p> 
		<table id="uploadRevison_<?php echo $rec['projectTask']['id']?>"></table>
		<form id="fileupload_<?php echo $rec['projectTask']['id']?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile/" method="POST" enctype="multipart/form-data" class="extraTaskDocs">
		 <input type="file" id="uploadfile" name="data[userFile][uploadfile]" />    	 
		 <button>Upload</button>
		<div>Upload files</div> 
	
		
		<script>
		     $(document).ready(function(){
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
		     
		     });
		     </script>
		
	  
	 	 
	</div>
		</form>
	<div class="clr"></div>
	<div class="width100Per" id="extraDocs_<?php echo $rec['projectTask']['id'];?>" style="display:none;width:100%;">	
 	    
	 </div>
   </div>  
</div><div class="clr"></div>
</div><div class="clr"></div>
