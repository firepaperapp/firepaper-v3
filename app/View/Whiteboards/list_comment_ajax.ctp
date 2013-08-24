<script src="<?php echo JS_PATH ?>jquery.jeditable.js" type="text/javascript"></script>
<script>
   $(document).ready(function (){
	$(".editcommentbox").editable(siteUrl+"whiteboards/updateComment/",
        {
            indicator :loader,
            type   : 'textarea',
            submitdata: { _method: "put" },
            select : true,
            submit : 'OK',
            cancel : 'cancel',
            event : 'manclick.editable',
			onsubmit: checkcommentbox,
            cols:40,
            rows : 4,
            placeholder:'',
			id : 'commenttext'		 
        }
    );

	 $(function()
    {
        $(".editcommentlink").click(function(){ 
			var id = $(this).attr('id'); 
			
			$("#"+id+"_box").trigger('manclick.editable');
        }
    );
    }
);
	});
function checkcommentbox()
{ 

if(document.editinplaceform.value.value=="")
{
	alert("Please enter comment");
	return false;
}
	var id = $(this).attr('id');
}

function confirmDelete(commentid)
{ 
	var con = confirm("Are you sure to delete the content?");
	
	$("#successdiv").empty().hide();
	if(con==true)
	{
		$("#loaderdiv").empty().html(loader).show();
		$.post(siteUrl+'Whiteboards/deleteComment/'+commentid, '',function(data){
		//alert(data);
			$("#loaderdiv").empty().hide();
			$("#successdiv").html(data).show();
			
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
			loadPiece(siteUrl+"whiteboards/listCommentAjax/"+$("#content_id").val()+"/?rand="+randomnumber, "#comments_listing");

			
			});
	}
}
</script>
<br>
<input type="hidden" id="currentcommentid" value="">
<input type="hidden" name="contid" id="contid" value="<?php echo $contentid;?>">
<div id="msgdiv" class="success" style="display:none;"></div>
<div id="loaderdiv" style="display:none;"></div>
<div style="width:420px;float:left;">
<?php
	
	if(is_array($data) && count($data)>0)
	{
		foreach($data as $comment) 
		{  ?>
		<div class="whiteboard-comment" style="width:100%;float:left;margin-top:10px;"> 
				<div style="float:left;margin-right:16px;width:60px;">
					<img src="<?php echo $comment['User']['profilepic'];?>" >
				</div>
				<div style="float:left;width:340px;">
					
					<p><a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $comment['User']['id'];?>">
						<strong><?php echo ucfirst(Sanitize::html($comment['User']['firstname'] . " " .$comment['User']['lastname']))?></strong></a>&nbsp;(Commented on version <?php echo $comment['Whiteboard']['version']; ?>) 
					</p> 
					<br>
					<div class="editcommentbox" id="editcomment_<?php echo $comment['WhiteboardComment']['id'];?>_box">
						<?php echo  nl2br(Sanitize::html($comment['WhiteboardComment']['comment'])); ?>
						
					</div>
					<?php  if($show_editdelete=='Y' || $this->Session->read('userid')==$comment['WhiteboardComment']['created_by'] || $this->Session->read('userid')==$comment['WhiteboardComment']['received_by']) 
					{?>
				<!--	<a id="editcomment_<?php echo $comment['WhiteboardComment']['id']?>" class="editcommentlink" style="cursor:pointer;">Edit</a>&nbsp;|&nbsp; -->
					
					<a style="cursor:pointer;" class="edit" onclick="confirmDelete(<?php echo $comment['WhiteboardComment']['id']?>)">Delete Comment</a>
					<?php } ?> 
				</div>
		</div>	
		<br>
		<?php 
		} 
	}
	else 
	{
		echo '<p>'.ERR_NO_COMMENT_ADDED_YET.'</p>';
	}
echo "<br>";
$this->Paginator->options(array('url' => $this->passedArgs));
echo $this->element("pagination/ajax_pagination");
?>
</div>