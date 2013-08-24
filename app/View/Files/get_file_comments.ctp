<script>
$(function() 
{
	fadeErrorMessage('Formmessage');
     $(".editcommentbox").editable(siteUrl+"files/saveParameters/comments",
     {
            type   : 'textarea',
            submitdata: { _method: "put" },
            select : true,
            submit : 'Submit',
            cancel : 'Cancel',
            event : 'manclick.editable',
            callback: getCommentUpdated,
            onsubmit: checkNotEmptyComment,
            rows:5,
            cols:25
           
    });
	$(".editcommentlink").click(function(){
			/*Hiding the add comment box and tags box*/
			$(".addcomment").hide();  
			$(".tagbox").hide();
			
			var id = $(this).attr('id');
			 
	        $("#"+id+"_box_container").hide();
            $("#"+id+"_box").show();
            $("#"+id+"_box").trigger('manclick.editable');
	});
	$(".delComment").click(function()
   {
   		if(confirm("Do you really want to delete this comment?"))
   		{
   			var myId = $(this).attr('id').split("_");	  
   			$("#editcomment_"+myId[2]).empty().html(loader); 
	   		$.get(siteUrl+"files/getFileComments/<?php echo $fileId;?>/?d="+myId[2]+"&",function()
	   		{
	   			$("#editcomment_"+myId[2]).fadeOut('slow');
	   		});   		
	   	}  		
   		
   });   
});  
function getCommentUpdated(data) 
{	 
	$('#'+($(this).attr('id')+"_container")).empty().html(data).show();	
	$(this).hide();
}
function checkNotEmptyComment()
{	 
	 if($.trim(document.editinplaceform.value.value) == "")    
	{
		alert("Please enter comment.");
		return false;
	}
}	
   </script>
<?php
if($this->Session->check('Message.flash'))
{?>
	<div class="Formmessage errorServer">
		<div class="success">
			<?php
				$this->Session->flash(); // this line displays our flash messages
			?>
		</div>
	</div>
<?php }
?>
<?php
$i = 1;	
if(is_array($data) && count($data)>0)
{
	foreach($data as $rec)
	{ 
		$css = "";
		if($i%2==0)	
		$css = "alternet";
		?>
		<div class="comment-file commentholder" id="editcomment_<?php echo $rec['Comment']['id'];?>"style="width:90%;">
			<div class="width100per editcommentbox" style="display:none;" id="editcomment_<?php echo $rec['Comment']['id'];?>_box"><?php echo Sanitize::html($rec['Comment']['message']);?></div>
			
			<div class="width100per" id="editcomment_<?php echo $rec['Comment']['id'];?>_box_container"><?php echo nl2br(Sanitize::html($rec['Comment']['message']));?></div>
			
			<div class="width100per">
				<span class="upload-details">Commented, <?php echo $this->Time->timeAgoInWords(strtotime($rec['Comment']['created']));?> </span>&nbsp;-&nbsp;
				
				<a class="edit delComment" href="javascript:void(0);" id="comment_id_<?php echo $rec['Comment']['id'];?>">Delete</a>&nbsp;-
				<a href="javascript:void(0);" class="edit editcommentlink" id="editcomment_<?php echo $rec['Comment']['id'];?>">Edit</a>
			&nbsp;
			</div>			
		</div>
	<?php
	}
?><div class="clr"></div><?php	
$this->Paginator->options(array('url' => $this->passedArgs));
echo $this->element("pagination/ajax_pagination");?><div class="clr"></div><?php
}
else {
	echo ERR_RECORD_NOT_FOUND;
}
?> 