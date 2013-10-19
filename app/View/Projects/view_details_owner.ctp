<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script src="<?php echo JS_PATH?>jquery.jeditable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script>
$(document).ready(function() {
		$('.userTaskDocs').click(function()
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
					$.get(siteUrl+"projects/userDocuments/"+gotId[1]+"/?rand="+randomnumber,   function(data)
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
			else
			{
				$('#'+myId+"_box").hide('slow');
			}
		}
	)
});
function delCommentId(commentId, taskId)
{		 
	if(confirm("Do you really want to delete this comment?"))
		{
			$('#viewTskComments_'+taskId+"_box").empty().html(loader);
			$.post(siteUrl+"projects/userDocumentComments/"+taskId, {d:commentId},function(data){
					
					$('#viewTskComments_'+taskId+"_box").empty().html(data);
			} );	   		
		}		 
}
function addComment(f)
{		
	if($.trim($("#addcommenttext_"+f).val())=="")
	{
		alert("Please enter comment.");
	}
	else
	{
	    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
	    $('#viewTskComments_'+f+"_box").empty().html(loader);
	    $.post(siteUrl+"projects/userDocumentComments/"+f+"/?rand="+randomnumber, {
	    	comment:$("#addcommenttext_"+f).val(), 
	    	posted_to: $('#posted_to').val(),
	    	project_id:$("#project_id").val(), 
	    	task_id:f,
	    	comment:$("#addcommenttext_"+f).val(), 
	    }, function(data)
		{
		   $("#addcomment_"+f+"_box").slideUp();	
           $('#viewTskComments_'+f+"_box").empty().html(data);           
           
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false; 
	}
}
</script>
<div class="activity">
	<h1><a href="#" ><?php echo Sanitize::html($prjDetails['Subject']['title']);?> </a><span class="project-page-name">- <?php echo Sanitize::html($prjDetails['Project']['title']);?></span></h1>
	<div class="project-brief-box">
		<h3>Project Details</h3> <div class="completed-bubble">Completed <span>85%</span></div>
		<div class="clr"></div>
		<div class="details">
			<div class="left">
				<p class="title">Project title:</p>
				<p><?php echo Sanitize::html($prjDetails['Project']['title']);?></p>
				<p class="title">Project brief:</p>
				<p><?php echo nl2br(Sanitize::html($prjDetails['Project']['description']));?></p>
			</div>
			<div class="right deadline-details">
				<p class="title">Due:</p>
				<p class="due-in"><?php echo date("F j, Y", strtotime($prjDetails['Project']['duedate']))?></p>
				<p class="title">Project leader:<br>
				<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Subject']['title'];?>" class="red"><?php echo ucfirst(Sanitize::html($prjDetails['User']['firstname']." ".$prjDetails['User']['lastname']));?></a></p>
				<p class="title">Any questions?</p>
				<p><a href="" class="red">Send a message</a></p>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="row">
		<div class="left"><p>Content</p></div>
	    <div class="right"><p>Weight</p></div>
	</div>
    <div class="project-wrapper">
    	<?php
    	foreach($tasks as $rec)
    	{?>
         <div class="file-doc-container">
	          <div class="open-close">
	           	 <a href="javascript:void(0)" class="userTaskDocs" id="task_<?php echo $rec['prjTask']['id'];?>">Open</a>
	          </div>
	          <div class="doc-icon"><img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $rec['fileType']['icon'];?>" /></div>
	          <div class="file-name"><?php echo Sanitize::html($rec['prjTask']['title']);?></div>
	          <div class="comment-box"> <a class="btn"><?php echo $rec[0]['cnt_comment']>0?$rec[0]['cnt_comment']:0;?> Comments</a></div>
	          <div class="weight-col"><?php echo $rec['prjTask']['weight'];?>%</div>
	          
        </div>
        <div id="task_<?php echo $rec['prjTask']['id'];?>_box" class="file-details">      		 		
		</div>
		<?php }?>
      </div><!-- end project wrapper -->
    </div>
    <input type="hidden" name="posted_to" id="posted_to" value="<?php echo $posted_to;?>" />
    <input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
</div>
 