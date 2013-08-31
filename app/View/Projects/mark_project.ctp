<script src="<?php echo JS_PATH?>jquery.jeditable.js" type="text/javascript"></script>
<script> 
$(document).ready(function (){		
	$("#markTask").submit(function(){
		$("#shdSubmit").val(1);
		if($(".taskProjectChk:checked").length == 0)
		{
			alert("Please select any task first");
			return false;
		}
		$(".taskProjectChk:checked").each(function(){
			
			var myId = $(this).attr("id");
			
			var testName =/^([0-9])*$/;				 
		 
			if($.trim($("#"+myId+"_weight").val()) == "")
			{
				alert("Please enter marks.");
				$("#shdSubmit").val(0);
				$("#"+myId+"_weight").focus();
				return false;
			}
		    else if(testName.test(document.getElementById(""+myId+"_weight").value) == false)
		     {
		         alert("Please enter only numeric values.");
		         $("#shdSubmit").val(0);
		         return false;  
		     }			
		     else if( parseInt($("#"+myId+"_weight").val()) > parseInt($("#"+myId+"_ttlweight").val()))
		     {
		         alert("Maximum marks can be upto "+$("#"+myId+"_ttlweight").val()+" only.");
		         $("#shdSubmit").val(0);
		         return false;  
		     }			
				 	
		});	  
	 	if($("#shdSubmit").val() == 1){
			return true;
		}				
		else
		{
			return false;
		}
	});
	$('.viewTskComments').click(function()
		{	 
			var myId = $(this).attr('id');
			if($('#'+myId+"_box").css('display') == "none")
			{
				var gotId = $(this).attr('id').split("_");
		 		if("undefined"== typeof(this.taskDetailCommentCalled))
				{ 
					$('#'+myId+"_box").empty().html(loader);
					//using random number to resolve cache issue
					var randomnumber=Math.floor(Math.random()*101);
					$.get(siteUrl+"projects/userDocumentComments/"+gotId[1]+"/"+$("#gotUserId").val()+"?rand="+randomnumber,   function(data)
					{	
			 			$('#'+myId+"_box").empty().html(data);
			 			 
			  		});
				}
				else
				{
					//this.taskDetailCommentCalled = 1;
				}
				$('#'+myId+"_box").show('slow');
			}
			else
			{
				$('#'+myId+"_box").hide('slow');
			}
		}
	);
	$(".addcommentlink").click(function(){
   	
   		var id = $(this).attr('id');
   		//$(".addcomment").hide();    		  		
   		$("#"+id+"_box").find("textarea").empty().html("");
   		$("#"+id+"_box").slideToggle();
   		
   });	
});
function delCommentId(commentId, taskId)
{		 
	if(confirm("Do you really want to delete this comment?"))
	{
		if($(taskId).length == 0)
			taskId = 0;
			
		$('#viewTskComments_'+taskId+"_box").empty().html(loader);
		$.post(siteUrl+"projects/userDocumentComments/"+taskId+"/"+$("#gotUserId").val(), {d:commentId},function(data)			{
			if(taskId==0)		
			{
				$('#projComments_'+commentId).fadeOut();
			}
			else
			{
				$('#viewTskComments_'+taskId+"_box").empty().html(data);
			}
		} );	   		
	}		 
}
function addComment(f,t)
{		
	if($.trim($("#addcommenttext_"+f).val())=="")
	{
		alert("Please enter comment.");
	}
	else
	{
	    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
	    $('#viewTskComments_'+f+"_box").empty().html(loader);
	    $.post(siteUrl+"projects/userDocumentComments/"+f+"/"+$("#gotUserId").val()+"?rand="+randomnumber, {
	    	comment:$("#addcommenttext_"+f).val(), 
	    	posted_to: $('#posted_to').val(),
	    	project_id:$("#project_id").val(), 
	    	task_id:t,
	    	student_doc_id:f,
	    	comment:$("#addcommenttext_"+f).val(), 
	    }, function(data)
		{
		   $("#addcomment_"+f+"_box").slideUp();	
           $('#viewTskComments_'+f+"_box").empty().html(data).show();           
           
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false; 
	}
}
</script>
<div class="activity">
	 <div class="index">
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
		<input type="hidden" name="gotUserId" id="gotUserId" value="<?php echo $gotUserId;?>" />
		<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
		<input type="hidden" name="posted_to" id="posted_to" value="<?php echo $gotUserId;?>" />
		<h3><?php echo Sanitize::html($prjDetails['Subject']['title']);?> <a href="<?php echo SITE_HTTP_URL?>projects/viewDetails/<?php echo $prjDetails['Project']['id'];?>"><span class="project-page-name">- <?php echo Sanitize::html($prjDetails['Project']['title']);?></a> ~ Project Marking</span></h3>
		<h3>Student: <a href="">
		<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $userDetail['User']['id'];?>"><?php echo ucfirst(Sanitize::html($userDetail['User']['firstname']." ".$userDetail['User']['lastname']));?></a>, 
		<?php
		if($classSt!='')
		{
			echo '<a href="">Class '.$classSt.'</a>';
		}
			
		?>
		</h3>	
		<?php echo $this->element("/common/project_detail");?>
		<div class="row">
			<div class="left">
				<h3>Documents &amp; Tasks</h3>
			</div>
			<div class="right">
				<h3>Weight</h3>
			</div>
		</div>
		<div class="clr"></div>
		<form name="markTask" id="markTask" action="" method="POST">	
		<?php
		$totalSubmission = 0;
		foreach($tasks as $rec)
		{?>
			<div class="project-brief-box-wrapper">
			<div class="project-drop-area-wrapper">
				<div class="col-weight">	
				Weight: <?php echo $rec['projectTask']['weight'];?>%
				<input type="hidden" id="task_<?php echo $rec['projectTask']['id'];?>_ttlweight" name="task_<?php echo $rec['projectTask']['id'];?>_ttlweight" value="<?php echo $rec['projectTask']['weight'];?>" />
				<?php
				if(isset($rec['projectStudentTaskDoc']) && count($rec['projectStudentTaskDoc'])>0)
				{?>
					&rarr;Add weight &rarr;<input class="weight-input taskProjectWeight" name="taskWeight[<?php echo $rec['projectTask']['id'];?>]" id="task_<?php echo $rec['projectTask']['id'];?>_weight" value="<?php echo isset($rec['projectStudentTaskMark']['marks'])?$rec['projectStudentTaskMark']['marks']:"";?>"/>			
				<?php }?>
				</div>
				<p>
				<?php
				if(isset($rec['projectStudentTaskDoc']) && count($rec['projectStudentTaskDoc'])>0)
				{?>
					<input id="task_<?php echo $rec['projectTask']['id'];?>" name="taskProjectChk[<?php echo $rec['projectTask']['id'];?>]" type="checkbox" value="1" class="task-tick-box taskProjectChk" checked /> 
				<?php 
				}
				?>
				<span class="task-title">
				<?php
				if(isset($rec['projectStudentTaskDoc']) && count($rec['projectStudentTaskDoc'])>0)
				{?>
				<span class="task-title" style="text-decoration:line-through;"> 
				 
				<?php
				}
				else 
				{?>
					<span class="task-title" > 
				<?php
				}
		
				echo Sanitize::html($rec['projectTask']['title']);?></span>
				</p>		
				<div class="clr"></div>				
				<?php
				if(isset($rec['projectStudentTaskDoc']) && count($rec['projectStudentTaskDoc'])>0)
				{?>
				<p class="field-title">Added documents</p>	
				<?php
				/*if($rec['projectTask']['refer_file_id']==0 && count($rec['projectStudentTaskDoc'])>0)
				{	$totalSubmission = 1;
				 	$docs = $rec['projectStudentTaskDoc'][0];
		 			?>
					<p>Task Completed&nbsp;&nbsp;</p>
					<p class="file-links"><span> <? print(Date("dS F Y", strtotime($docs['submitted_date']))); ?> at <? print(date("H:ia", strtotime($docs['submitted_date']))); ?></span>&nbsp;-&nbsp;<a href="javascript:void(0);" class="addcommentlink" id="addcomment_<?php echo $docs['id'];?>">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="viewTskComments viewTskCommentsLink" id="viewTskComments_<?php echo $docs['id'];?>"><?php echo $docs['projectStudentTaskDoc'][0]['cnt_comment'];?> Comment(s)</a></p> 
						<!-- HTML To add a Comment for user task Doc -->
						<div class="addcomment marginT10" id="addcomment_<?php echo $docs['id'];?>_box" style="display:none;width:300px;">
					          	<textarea name="addcommenttext_<?php echo $docs['id'];?>" id="addcommenttext_<?php echo $docs['id'];?>" rows="5" cols="40"></textarea>
					          	<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $docs['id'];?>, <?php echo $rec['projectTask']['id'];?>);"/>
					          	<input type="button" name="cancel" value="Cancel" onclick="$('#addcomment_<?php echo $docs['id'];?>_box').slideUp('slow');"/>
				        </div>    
				        <!-- HTML END To add a Comment for user task Doc -->
				       
				       <div class="clr"></div>
				 	   <div class="width100Per" id="viewTskComments_<?php echo $docs['id'];?>_box" style="display:none;width:500px;">		 
					 
				 	    </div><div class="clr"></div>
		 		 	    
				<?php
				}
				else {*/
					 
			 		foreach($rec['projectStudentTaskDoc'] as $docs)
					{
					$totalSubmission = 1;
					?>	 
						<div class="file-name"> 
							<?php
							if(!isNull($docs['refer_file_id']))
							{
			 				?>
							<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $fileTypes[$docs['file_type_id']];?>" /><a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $docs['refer_file_id']?>" id="tool-tip"><?php echo Sanitize::html($docs['title']);?></a> <em></em>
							<?php
							}
							else
							{
								echo $docs['title'];					
							}?>
							<div class="clr"></div>
							<p class="file-links"><span> <? print(Date("dS F Y", strtotime($docs['submitted_date']))); ?> at <? print(date("H:ia", strtotime($docs['submitted_date']))); ?></span> - <a href="javascript:void(0);" class="addcommentlink edit" id="addcomment_<?php echo $docs['id'];?>" style="margin-top:0px;">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="viewTskComments viewTskCommentsLink  edit" id="viewTskComments_<?php echo $docs['id'];?>"  style="margin-top:0px;"><?php echo $docs['projectStudentTaskDoc'][0]['cnt_comment'];?> Comment(s)</a></p>
						</div>		
						 	<div class="clr"></div>			
						<!-- HTML To add a Comment for user task Doc -->
						<div class="addcomment marginT10" id="addcomment_<?php echo $docs['id'];?>_box" style="display:none;">
								<h3>Add a comment</h3>
								
					          	<textarea name="addcommenttext_<?php echo $docs['id'];?>" id="addcommenttext_<?php echo $docs['id'];?>" class="text-field-comment"></textarea>
					          	<div class="submit-wrapper">
					          		<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $docs['id'];?>, <?php echo $rec['projectTask']['id'];?>);" class="submit"/>
                					or <a class="edit" href="javascript:void(0);" onclick="$('#addcomment_<?php echo $docs['id'];?>_box').slideUp('slow');">Cancel</a>
                					</div>
                 				<div class="clr">&nbsp;</div>			
				        </div>    
				        <!-- HTML END To add a Comment for user task Doc -->
				       
				       <div class="clr"></div>
				 	   <div class="width100Per file-details" id="viewTskComments_<?php echo $docs['id'];?>_box" style="display:none;width:550px;background-color:white;">		 
					 
				 	    </div><div class="clr"></div>
		 	    <?php
					//}
				}?>
			<?php
			}
			else 
			{
				echo "<p>".NO_DOC_ADDED."</p>";
			}
			?>
			
		</div> 
		
		</div> 
		<div class="clr"></div>
		<div class="clr-spacer"></div> 
		<?php
		}?> 
		<input type="hidden" name="shdSubmit" id="shdSubmit" value="1" />
		<?php
		//we will not show submit button if user has not submitted any doc in the project
		if($totalSubmission>0)
		{?>
		<input type="checkbox" name="isComplete" id="isComplete" value="1" />&nbsp;<span title="User will not be able to add any file in this project.">Student has completed the project.</span>
		<br/>
		<input type="submit" name="btnSubmit" id="btnSubmit" class="submit" value="Submit marks" />
		<?php }?>
		</form>
		<div class="clr"></div>
	</div>
</div><!-- end activity -->