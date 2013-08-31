<script type="text/javascript" src="<?php echo JS_PATH;?>project_detail.js"></script>
<div class="version-documents projectTasks">			   
<?php
if(count($taskDocs)>0)
{?>
<div class="clr marginT10"></div>
<h4>Added documents</h4>	
<?php
	
 	foreach($taskDocs as $rec)
	{?>
	 <div class="encloseJs">
		<div class="file-name"> 
			<?php
			if($rec['fileType']['icon']!="")
			{?>
				<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $rec['fileType']['icon'];?>" />	
		<?php
			}?>
			<a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $rec['prjTaskUserDoc']['refer_file_id']?>" id="tool-tip"><?php echo $rec['prjTaskUserDoc']['title'];?></a> 
			
			<p class="file-links"><span> <? print(Date("dS F Y", strtotime($rec['prjTaskUserDoc']['submitted_date']))); ?> at <? print(date("H:ia", strtotime($rec['prjTaskUserDoc']['submitted_date']))); ?></span> -<?php
		  	if($rec[0]['cnt_comment']>0)
		  	{?>
		  	<a href="javascript:void(0)" class="viewTskCommentsInner  edit viewTskCommentsLink" id="viewTskComments_<?php echo $rec['prjTaskUserDoc']['id'];?>"><?php echo $rec[0]['cnt_comment'];?> Comment(s)</a>	<?php
		  	}
		  	else 
		  	{?>
			  <a class="viewTskComments" href="javascript:void(0)">0 Comment</a>
			<?php 
		  	}?>&nbsp;-&nbsp;
			<a href="javascript:void(0);" class="addcommentlink edit" id="addcomment_<?php echo $rec['prjTaskUserDoc']['id'];?>">Add New Comment</a>
			
			<?php
			if($canChnage == 1)
			{?>
			&nbsp;-&nbsp;<a href="javascript:void(0)" class="deleteDocFrmProject edit" id="a_v<?php echo $rec['prjTaskUserDoc']['id'];?>" onclick="delTaskDoc(<?php echo $rec['prjTaskUserDoc']['id'];?>, 'viewDetail')">Delete</a>
			<?php
			}?>
			</p> 
		</div>		
		<div class="clr"></div>			
		<!-- end col-left -->	 	 
			<!-- HTML To add a Comment for user task Doc -->
			<div class="addcomment marginT10" id="addcomment_<?php echo $rec['prjTaskUserDoc']['id'];?>_box" style="display:none;">
				 <h3>Add a comment</h3>
				 
				<div class="clr"></div>
				<textarea name="addcommenttext_<?php echo $rec['prjTaskUserDoc']['id'];?>" id="addcommenttext_<?php echo $rec['prjTaskUserDoc']['id'];?>" class="text-field-comment"></textarea>
			          	
	          	<div class="submit-wrapper">
		          	<input type="button" name="submit" value="Submit" onclick="addComment(<?php echo $rec['prjTaskUserDoc']['id'];?>, <?php echo $task_id;?>);" class="submit"/>&nbsp;or&nbsp;
		          	<a href="javascript:void(0);" class="edit" title="cancel" onclick="$('#addcomment_<?php echo $rec['prjTaskUserDoc']['id'];?>_box').slideUp('slow');">cancel</a>
		         </div>
	        </div>    
	        <!-- HTML END To add a Comment for user task Doc -->
	 	   <div class="width100Per" id="viewTskComments_<?php echo $rec['prjTaskUserDoc']['id'];?>_box" style="display:none;width:500px;">		 
		 
	 	    </div>
	 	<!-- end col-middle -->    
		<?php
	  	if($rec['prjTaskUserDoc']['marks']>0)
	  	{?>
			<div class="col-weight">
			  <div class="weight"><?php echo $rec['prjTaskUserDoc']['marks'];?>%</div>
			</div>
		<?php } ?>
		<div class="clr"></div>
	 </div>
	<?php 
	}
} ?>
</div>
<?php
$url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
if($canChnage == 1 )//&& (false !==  strpos($url , 'projects/viewDetails/')))
{?>
<div class="dropFileHere marginT10 project-drop-area" id="drag_<?php echo $task_id;?>">
 	<p>Drag a  new version here <span>--- or ---</span> 
 	<!-- <a id="uploadfile_<?php echo $task_id;?>" name="data[userFile][uploadFile]" class="edit upload-link">Upload it</a> -->
 	<table id="filesDrag<?php echo $task_id;?>"></table>  
 	<form id="form_<?php echo $task_id;?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile" method="POST" enctype="multipart/form-data" class="marginT10 upload-link">
		 <input type="file" id="uploadfile" name="data[userFile][uploadfile]" />   	 
		 <button>Upload</button>
		 <div>Upload files</div>
	</form>  
 	</p>
 	
</div>
<div id="<?php echo $task_id;?>_withoutdocbox" style="display:none;"></div>
<p class="marginT10">Or&nbsp;<a class="edit submitWithoutDoc" id="withoutdoctask_<?php echo $task_id;?>">Submit without document</a></p>		
<?php
}?>
<div class="clr">&nbsp;</div>
<?php
$pointer = "task-pointer";
$box = "task-comment";
/*if(count($taskOtherComments)>0)
{?>
  	<p class="task-comment-title">Comment</p>
	<?php
	foreach($taskOtherComments as $rec)
	{?>
		<div class="<?php echo $pointer;?>"></div>
		<div class="<?php echo $box;?>">
		 		<p id="projComments_<?php echo $rec['projComments']['id'];?>">
					<span class="editcommentbox" id="editcomment_<?php echo $rec['projComments']['id'];?>_box"><?php echo nl2br(Sanitize::html($rec['projComments']['comment']));?></span>&nbsp;-&nbsp;		<?php
				if($this->Session->read("userid") == $rec['projComments']['posted_by'])
				{?>
				<a href="javascript:void(0)" onclick="delCommentId(<?php echo $rec['projComments']['id'];?>);" class="edit">Delete</a>
				<? }
				else 
				{?>
					By - <a class="edit" href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $rec['User']['id'];?>"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>
				<?php
				}
				$comment_date = $rec['projComments']['updated_on'] == '0000-00-00 00:00:00'?$rec['projComments']['created']:$rec['projComments']['updated_on'];
				echo "&nbsp;-&nbsp;	on - ".date("d-M-Y", strtotime($comment_date));
				?>
				</p>
		 </div>		  
	<?php
	}
	?>
<?php
}*/
?>
<div class="clr"></div>