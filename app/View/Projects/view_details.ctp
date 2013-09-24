<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script src="<?php echo JS_PATH?>jquery.jeditable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!--File Upload Progress bar-->
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script> 
<!--File Upload Progress bar End-->
<script>

</script>

	<div class="index white">
		<div class="project-brief-box-wrapper">
	    <div class="project-wrapper">
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
		<h1><a href="#" ><?php echo Sanitize::html($prjDetails['Subject']['title']);?> </a>- <?php echo Sanitize::html($prjDetails['Project']['title']);?></h1>
		<?php echo $this->element("/common/project_detail");?>
		<div class="rule"></div>
		
				<h3>TO DO's</h3>
		
		
	 	<div id="loaderJsTask"></div>
	    	<?php
	    	foreach($tasks as $rec)
	    	{?>
	    	
				<div class="project-drop-area-wrapper">
 		          <?php
					if($isOwner == 0 && $vistor==0)
					{?> 	 
					   <div class="open-close" style="display:block">
			          	<a href="javascript:void(0);" class="userTaskDocs" id="task_<?php echo $rec['prjTask']['id'];?>">Open</a>
			          
			          </div>
				<?php }?>
			          <div class="doc-icon">
			          <?php if($rec['fileType']['icon']!='')
			          {?>
			          <img src="<?php echo IMAGES_PATH;?>icons/<?php echo $rec['fileType']['icon'];?>" />
						<?php }?>
			          </div>
			          <div class="file-name">
				          <?php 
		 		          if($rec['fileType']['icon']!='')
				          {?>
				          	 <a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $rec['prjTask']['refer_file_id']?>" id="tool-tip">
				          	 <?php echo Sanitize::html($rec['prjTask']['title']);?></a>
				           <em></em>
				          <?php
				          }
				          else 
				          {
				   
							if(isset($rec['projectStudentTaskMark']) && $rec['projectStudentTaskMark']['marks']!='')
							{?>
				 				<!-- <input type="checkbox" name="ticked" checked="checked" disabled/>-->
							<img src="<?php echo IMAGES_PATH?>active.png" border="0">
				 			<?php
								echo '<span style="text-decoration:line-through;">'.Sanitize::html($rec['prjTask']['title'])."</span>";
							}
							else 
							{
				          		echo Sanitize::html($rec['prjTask']['title']);
							}
				          }
				          ?>
				         
				         
				     </div>
			          <?php
					if($isOwner == 0)
					{?> 		
			          <!-- <div class="comment-box"> <a class="btn"><?php echo $rec[0]['cnt_comment']>0?$rec[0]['cnt_comment']:0;?> Comments</a></div>-->
					<?php }
					else 
					{
						
					}
					?>
					<?php
				  	if(isset($rec['projectStudentTaskMark']['marks']) && $rec['projectStudentTaskMark']['marks']>0)
				  	{?>
					<div class="col-weight">
					  <div class="weight" style="background-color:red;"><?php echo $rec['projectStudentTaskMark']['marks'];?>%</div>
					</div>
				<?php } ?>
		         	 <div class="weight-col"><?php echo $rec['prjTask']['weight'];?>%</div>
		         	 
		 		      <?php
				      if($rec['prjTask']['refer_file_id'] == 0)
				      {
				      	$taskType = "tick";
				      }
				      else {
				      	$taskType = "doc";
				      }
				      ?>
			     	 <input type="hidden" name="VtaskType_<?php echo $rec['prjTask']['id'];?>" id="VtaskType_<?php echo $rec['prjTask']['id'];?>" value="<?php echo $taskType;?>" />
			       
					  <?php
					 
					//if($isOwner != 0)
					{?> 	
					<p class="file-links"><span> <? print(Date("dS F Y", strtotime($rec['prjTask']['created']))); ?> at <? print(date("H:ia", strtotime($rec['prjTask']['created']))); ?></span>&nbsp;-&nbsp;<a href="javascript:void(0);" class="addcommentlink" id="addcomment_<?php echo $rec['prjTask']['id'];?>">Add New Comment</a>&nbsp;-&nbsp;<a href="javascript:void(0)" class="viewTskComments viewTskCommentsLink" id="viewTskComments_<?php echo $rec['prjTask']['id'];?>"><?php echo  $rec[0]['cnt_comment'];?> Comment(s)</a><?php
					  $v = (int)$rec[0]['extraDocs'];	
					  if($v > 0)
					  {?>				  
					  &nbsp;-&nbsp;<a href="javascript:void(0);" class="edit" onclick="viewExtraTaskDocs(<?php echo $rec['prjTask']['id']?>)">View Other Docs</a>
<?php
					  }?></p> <div class="rule"></div>	
		 			<?php
					}
					//else 					
					{
					?>
					       
				<?php
					}?>
					<div class="width100Per" id="extraDocs_<?php echo $rec['prjTask']['id'];?>" style="display:none;">	
				 	    
					 </div>
					  <div id="task_<?php echo $rec['prjTask']['id'];?>_box" style="">     
			        	<?php
			        	if($isOwner == 0 && $vistor==0)
						{
				 
							echo $this->requestAction("/projects/userDocuments/".$rec['prjTask']['id']."?view=Large&s=u");
						}
					?> 		 	
					
					</div>
					 <!-- HTML To add a Comment for user task Doc -->
					<div class="addcomment marginT10" id="addcomment_<?php echo $rec['prjTask']['id'];?>_box" style="display:none;">
					<h3>Add a comment</h3>
					
					<textarea name="addcommenttext_<?php echo $rec['prjTask']['id'];?>" id="addcommenttext_<?php echo $rec['prjTask']['id'];?>" class="text-field-comment"></textarea>
					<div class="submit-wrapper">
					<input type="button" name="submit" value="Submit" onclick="addCommentTask(<?php echo $rec['prjTask']['id'];?>, <?php echo $rec['prjTask']['id'];?>);" class="submit"/>
					or <a class="edit" href="javascript:void(0);" onclick="$('#addcomment_<?php echo $rec['prjTask']['id'];?>_box').slideUp('slow');">Cancel</a>
					</div>
					<div class="clr"></div>	
							
					</div>    
					<!-- HTML END To add a Comment for user task Doc -->
					
					<div class="clr"></div>
					<div class="width100Per" id="viewTskComments_<?php echo $rec['prjTask']['id'];?>_box">	
				 
				</div>				
				
				<div class="clr-spacer"></div> 	
				<?php }?>
			
	      
	   	  <?php
	   	  if(isset($noOfTasks) && isset($taksDone))
	   	  {
	   	  	if($noOfTasks == $taksDone)
	   	  	{?>
		   	  <div style="float:left; margin-left:25px;">
		   	  	<a href="<?php echo SITE_HTTP_URL?>projects/completeProject/<?php echo $project_id;?>" class="submit" onclick="completeProject();">Complete Project</a>
		   	  </div><div class="clr"></div>
	   		<?php
	   	  	}
		}?> 
	    <?php
	    //$pointer = "task-pointer";
$box = "task-comment";
	if(count($projComments)>0)
	{?>
	</div><div class="rule"></div>
	  	<h3>Changes</h3>
	  	<?php
	    foreach($projComments as $rec)
	    {?>	    
	    <div class="<?php echo $pointer;?>"></div>
		<div class="<?php echo $box;?>">
		 		<p id="projComments_<?php echo $rec['projComments']['id'];?>">
					<span class="editcommentbox" id="editcomment_<?php echo $rec['projComments']['id'];?>_box"><?php echo nl2br(Sanitize::html($rec['projComments']['comment']));?></span>	<?php
				if($this->Session->read("userid") == $rec['projComments']['posted_by'])
				{?>
				&nbsp;-&nbsp;	by You
			<!--<a href="javascript:void(0)" onclick="delCommentId(<?php echo $rec['projComments']['id'];?>);" class="edit">Delete</a>-->
				<? }
				else 
				{?>
					&nbsp;-&nbsp;	by - <a class="edit" href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>
				<?php
				}
				$comment_date = $rec['projComments']['updated_on'] == '0000-00-00 00:00:00'?$rec['projComments']['created']:$rec['projComments']['updated_on'];
				echo "&nbsp;-&nbsp;	on - ".date("d-M-Y", strtotime($comment_date));
				?>
				</p>
		 </div>		
	 	<?php }?>	
	 	</div><!-- end project wrapper -->
	   	  <div class="clr"></div>    
	    <?php
	    }
	    $status = "u"; //Project Un Completed
	    if((isset($isUserAdded['projectStudent']['id']) && $isUserAdded['projectStudent']['completed'] == 1) || $prjDetails['Project']['published']!=1 )
	    {
	    	$status = "c"; //Project Completed
	    }
	    ?>
	    <div class="clr"></div>
	    <?php
	    if(count($dataWhiteboards)>0)
	    {?>
	    <div class="row">
			<div class="left">
				<h3>Whiteboards</h3>
			</div>
			<div class="right">
				<h3></h3>
			</div>
		</div> <div class="clr"></div>
		 <div class="project-wrapper">
		 		<div class="project-brief-box-wrapper">
					<div class="project-drop-area-wrapper">
					 <?php
					    foreach($dataWhiteboards as $rec)
					    {?>
					    	<p class="marginT10">
					    	<a href="<?php echo SITE_HTTP_URL;?>whiteboard/<?php echo $rec['Whiteboard']['id'];?>" class="edit">
					    	<?php echo Sanitize::html($rec['Whiteboard']['title']);?>
					    	</a>
					    	<div class="clr"></div>
					    	</p>
						<?php
					    }?>
					</div>
				</div>
		</div>
	    <?php
	    }
	    ?>
		<input type="hidden" name="isOwner" id="isOwner" value="<?php echo $isOwner;?>" />
		<input type="hidden" name="gotUserId" id="gotUserId" value="<?php echo $posted_to;?>" />
	    <input type="hidden" name="posted_to" id="posted_to" value="<?php echo $posted_to;?>" />
	    <input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
	    <input type="hidden" name="status<?php echo $project_id;?>" id="status<?php echo $project_id;?>" value="<?php echo $status;?>" />
	  </div>
	
</div>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.droppable.js"></script>
<script>
$('.userTaskDocs').each(function()
		{ 	  
			var myId = $(this).attr('id');
			if($('#'+myId+"_box").css('display') == "none")
			{	
				var gotId = $(this).attr('id').split("_");
		 		if("undefined"== typeof(this.taskDetailCalled))
				{
					$('#'+myId+"_box").empty().html(loader);
					//using random number to resolve cache issue
					var randomnumber=Math.floor(Math.random()*101);
					var callUrl = "userDocuments";
					if($("#VtaskType_"+gotId[1]).val() == "tick")
					{
						var callUrl = "userDocumentsTick";	
					} 
					var ex = $("#status"+$("#project_id").val()).val();
					
					
					$.get(siteUrl+"projects/"+callUrl+"/"+gotId[1]+"?view=Large&s="+ex+"&rand="+randomnumber,   function(data)
					{	
			 			$('#'+myId+"_box").empty().html(data);
			 			 
			  		});
				}
				else
				{
					//this.taskDetailCalled = 0;
				}
				$('#'+myId+"_box").show('slow');
			}
			
		});
</script>
<script type="text/javascript" src="<?php echo JS_PATH ?>view_project_details.js"></script> 