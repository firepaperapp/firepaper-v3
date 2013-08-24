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

/*

function checkme()
{
	if($("#whiteboardcomment").val()=="")
	{
		alert("Please enter comment");
		return false;
	}
	else
	{
		$('#commentloader').empty().html(loader).show();			
					$.post(siteUrl +'Whiteboards/addComment/'+$("#content_id").val(),$("#commentform").serialize(),function(data)
                    {	
					   $("#whiteboardcomment").val('');
					   $('#commentloader').empty().hide();
					   $('#successdiv').empty().html(data).show();

					   var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   		loadPiece(siteUrl+"whiteboards/listCommentAjax/"+$("#content_id").val()+"/?rand="+randomnumber, "#comments_listing");
                    });
		
		
	}
}*/


</script>
<span style="float:right;"><a href="<?php echo SITE_HTTP_URL?>Whiteboards/">Back</a></span><br>
<div>
	<h1 style="font-size:26px;"><?php echo ucfirst(Sanitize::html($contentdata['Whiteboard']['title'])); ?></h1>	
</div>
<br>

<div>
	<?php echo $contentdata['Whiteboard']['content'];?>
</div>

<br><br>
<div id="commentloader" style="display:none;"></div>
<div id="successdiv" style="display:none;" class="success"></div>
<p><strong>Comments</strong></p><br>
<?php $action = SITE_HTTP_URL."/Whiteboards/addComment/"?>
<?php echo $this->Form->create('WhiteboardComment',array( 'type' => 'post', 'id'=>'commentform')); ?>
	<div>
		<textarea name="data[WhiteboardComment][comment]" id="whiteboardcomment" rows="10" cols="60" ></textarea><br>
		<?php //echo $this->Form->submit('submit',array('label'=>false,'name'=>'submit','value'=>'Submit'));?><br>
		<input type="submit" name="submit" value="Submit">
	</div>
	<input type="hidden" value="<?php echo $content_id; ?>" name="content_id" id="content_id">
</form>

<div id="comments_listing"></div>