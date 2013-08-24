<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>

<script>
$(document).ready(function(){   
		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   		loadPiece(siteUrl+"whiteboards/listCommentAjax/"+$("#content_id").val()+"/?rand="+randomnumber, "#comments_listing");

		$('#commentform').validate({ 
		errorElement: "p",				
	 	submitHandler: function(form) { 
					$('#commentloader').empty().html(loader).show();			
					$.post(siteUrl +'Whiteboards/addComment/'+$("#content_id").val(),$("#commentform").serialize(),function(data)
                    {	
					   $("#whiteboardcomment").val('');
					   $('#commentloader').empty().hide();
					   $('#successdiv').empty().html(data).show();

					   var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
					    
   		loadPiece(siteUrl+"whiteboards/listCommentAjax/"+$("#content_id").val()+"/?rand="+randomnumber, "#comments_listing");
                    });
	        },
		rules: {
		"data[WhiteboardComment][comment]":  {required: true}		
		},
		messages:
		{
			"data[WhiteboardComment][comment]":{
			required: "Please enter comment."
			} 
		}
	}); 

}); 
</script>
<div class="activity">
	<div class="index">
		<h3><a href="#" ><?php echo Sanitize::html($contentdata['Whiteboard']['title']);?> </a></h3>
		<div class="project-brief-box-wrapper">
		<div class="project-brief-box">
			<h3>Whiteboard Details</h3> 
		 	<div class="clr"></div>
			<div class="details">
				<div class="left">
					<p class="title">Whiteboard Title:</p>
					<h3><span><?php echo Sanitize::html($contentdata['Whiteboard']['title']);?></span></h3>
					<p class="title">Whiteboard Brief:</p>
					<p><?php echo nl2br($contentdata['Whiteboard']['content']);?></p>
				</div>
				<div class="right">
					<p class="title">Cretaed:</p>
					<p class="due-in"><?php echo date("F j, Y", strtotime($contentdata['Whiteboard']['created']))?></p>
					<p class="title">By:</p>
					<p class="leader"><a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $contentdata['Whiteboard']['created_by'];?>" class="red"><?php echo ucfirst(Sanitize::html($contentdata['User']['firstname']." ".$contentdata['User']['lastname']));?></a></p>
					<?php
					if(count($projects)>0)
					{?>
					<p class="title">Project:</p>
					<p class="leader">
					<?php
					foreach($projects as $rec)
					{?>
					<a href="<?php echo SITE_HTTP_URL?>projects/viewDetails/<?php echo $rec['Project']['id'];?>" class="red"><?php echo ucfirst(Sanitize::html($rec['Project']['title']));?></a><br/>
<?php
					}?>
					</p>	
					<?php
					}?>
			 	</div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
		<div class="clr">&nbsp;</div>
		 
		<div class="clr"></div>
		<div>
			<h3>Comments</h3>	
		</div>
		 
	 	<div id="commentloader" style="display:none;"></div>
		<div id="successdiv" style="display:none;" class="success"></div>
		 
		<?php $action = SITE_HTTP_URL."/Whiteboards/addComment/"?>
		<?php
		if($canEdit == 1)
		{?>
		<?php echo $this->Form->create('WhiteboardComment',array( 'type' => 'post', 'id'=>'commentform')); ?>
			<!-- HTML To add a Comment for user task Doc -->
			<div class="addcomment marginT10" style="width:300px;">
					<p class="task-comment-title">Add a comment</p>
					 
		          	<textarea name="data[WhiteboardComment][comment]" id="whiteboardcomment"  class="text-field-comment"></textarea>
		          	<div class="submit-wrapper">
		          		<input type="submit" name="submit" value="Submit" class="submit"/>
    				 
    					</div>
     				<div class="clr">&nbsp;</div>			
	        </div>    
	        <!-- HTML END To add a Comment for user task Doc -->
				        
			 
			
		</form>
		<?php }?>
		<div id="comments_listing"></div><input type="hidden" value="<?php echo $content_id; ?>" name="content_id" id="content_id">
	</div>
</div>