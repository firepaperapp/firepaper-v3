<script>
	var randomnumber=Math.floor(Math.random()*101);
	$("#createTaskDoc").validate({
	//errorClass:"invalid",
   	 errorElement: "p",
 	 debug:false,
 	 errorLabelContainer: "#validation-container-task",
 	 invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			 	if (errors) {
			 		$("div#validation-container-task").show();
				} else {
					$("div#validation-container-task").hide();
				}
			},
		submitHandler: function(form) {
                $("#loaderJsTask").empty().html(loader).show();
                $('#uploadDoc').slideUp('slow');
	            $.post(siteUrl+"projects/createTask/0"+"/?p="+$('#project_id').val(),$("#createTaskDoc").serialize(),function(data){		
	            	
	            	$("#loaderJsTask").empty().hide();			            	
	            	//TO alert the success message
					/*if("undefined" == typeof(data.success))
					{
						$('#uploadDoc').slideDown('slow');
						var err = data.error.toString();
						$('#validation-container-task').empty().html(err).show();
						$("#validation-container-success-task").empty().hide();
					}
					else
					{							
		            	var taskId = data.id;							
						var msg = data.success;*/
					
					 
			           
						$("#tasksCount").val(Number($("#tasksCount").val())+1);
						$('div#createdTasks').show('slow');
						$('div#createdTasks').prepend(data);	 
						
						$("#taskMsgDiv").empty().html("");
						$("#validation-container-task").empty().hide();
						$("#validation-container-success-task").empty().html("Task created successfully.").show();								
						$(".dropFileHere").fadeIn('slow');
						//we have to refresh the left area panel to display the uploaded file
						//as client requested
						$("ul.tabs li").removeClass("active");
						$(".tab_content").hide();
						$("#fileTab").addClass("active");
						$("#tab1").fadeIn();
						loadPiece(siteUrl+"files/listFiles/page:1/sort:uploaded/direction:desc?rand="+randomnumber,"#dropbox_files");
						return false;
	            //}
		
			});
        },
	     rules: {      
   	     "data[projectTask][weight]":  {required: true, number: true}
	  },
	   messages: 
	   {			   	 
			 "data[projectTask][weight]":  {
		 	required: "Please enter weight.",
		 	number:"Please enter a valid number."
		 }
		   }
	}		
);
</script>
<div id="uploadDoc">
	<div class="project-brief-box-wrapper"> 
		<div class="project-drop-area-wrapper">
		    <div class="file-added-docs add file-details-project">
				<form name="createTaskDoc" id="createTaskDoc" action="" method="post">
				    <div class="version-documents">
					    <div class="weight-col">
						      <span>Add your weighting &rarr;</span>      
						      <?php echo $this->Form->input('projectTask.weight',array('div'=>false,'label'=>false,"id"=>"taskWeight",'maxlength'=>'3','class'=>'weight-input'));?> 					     
					    </div>
				        <div class="doc-icon"><img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $fileDetail['fileType']['icon']?>" /></div>
				        <div class="file-name"><a href="javascript:void(0);" id="tool-tip" >
					        <?php 
							echo $fileDetail['userFile']['file_name'];
				        $name = explode(".",$fileDetail['userFile']['file_name']);
					/*	        echo $name[0]; */
							
					         ?></a>
				         </div>
				        <div class="comment-link fl-left">
				        <h3>Comment</h3>
				        </div>
				        
				      <?php echo $this->Form->textarea('projComments.comment',array('div'=>false,'label'=>false,"id"=>"comment",'class'=>'text-field-comment'));?> 
				       <div class="clr"></div>
				       <?php
				        global $videoArray;
				        if(in_array(strtolower($name[1]), $videoArray))
						{?>
				       <p><input type="checkbox" name="data[projectTask][monitor]">This file has been detected as video. Would you like it to be monitored?</p>
						<?php
						}?>
		 		        <div class="clr"></div>
				        <div class="submit-wrapper">
					         <input type="hidden" name="data[projectTask][title]" value="<?php echo  $name[0];?>" />
					        <input type="hidden" name="data[projectTask][file_name]" value="<?php echo $fileDetail['userFile']['file_name'];?>" />
					        <input type="hidden" name="data[projectTask][file_type_id]" value="<?php echo $fileDetail['userFile']['file_type_id'];?>" />
					        <input type="hidden" name="data[projectTask][refer_file_id]" value="<?php echo $fileDetail['userFile']['id'];?>" id="refer_file_id"/>
					        <input type="hidden" name="data[projectTask][imgeShow]" value="<?php echo $fileDetail['fileType']['icon']?>" id="imgeShow"/>
					        <input type="submit" class="submit" value="Submit" />&nbsp;or&nbsp;<a href="javascript:void(0)" class="edit" onclick="$('#taskUnderDiv').hide('slow');$('.dropFileHere').fadeIn('slow');">Cancel</a>
				        </div>
				      
				    <div class="clr"></div>    
				  </div>
			  </form>
			</div>
		</div>
	 </div><div class="clr"></div>    
</div>