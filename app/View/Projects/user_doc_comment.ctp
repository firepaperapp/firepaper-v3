<script>
	$(document).ready(function() {

		$(".editcommentbox").editable(siteUrl+"projects/updateComment/",
        {
            indicator :loader,
            type   : 'textarea',
            submitdata: { _method: "put" },
            select : true,
            submit : 'Submit',
            cancel : 'Cancel',
            event : 'manclick.editable',
   			onsubmit: checkNotEmpty,
            cols:40,
            rows : 4,
            placeholder:'',
   			id : 'commenttext'   
        }
 	   );
	    $(".editcommentlink").click(function(){ 
	   var id = $(this).attr('id');
	   $("#"+id+"_box").trigger('manclick.editable');
	         //   $("#editcommentbox").trigger('manclick.editable');
	   //$("#textlimit").show();
	        }
	    );    

		fadeErrorMessage('Formmessage');
	});
	function checkNotEmpty()
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
		<div class="Formmessage marginT10 errorServer">
			<div class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?>
<?php
$pointer = "task-pointer";
$box = "task-comment";

if(strpos($_SERVER['HTTP_REFERER'], "markProject") != 0)
{
	//$pointer = "comment-point";
//$box = "comment-box";
}
if(count($taskComments)>0 && isset($taskComments[0]['projComments']['id']))
{?>
	<div class="clr-spacer"></div>
	<h3>Comments</h3>
	<?php
	foreach($taskComments as $rec)
	{?>
	<div  id="delcomment_<?php echo $rec['projComments']['id'];?>">
	<div class="<?php echo $pointer;?>"></div>
	  <div class="<?php echo $box;?>">
	  <div class="authorbox">
	  <?php
		if($this->Session->read("userid") == $rec['projComments']['posted_by'] || ( $isOwner == 1 && $viewType == "common"))
		{?>
		<a href="javascript:void(0);" id="editcomment_<?php echo $rec['projComments']['id']?>" class="editcommentlink edit">Edit</a>&nbsp;-&nbsp;<a href="javascript:void(0)" onclick="delCommentId(<?php echo $rec['projComments']['id'];?>, <?php echo $userTaskId;?>, '<?php echo $from;?>');" class="edit">Delete</a>
			<?php
			if($isOwner == 1)
			{?>
				By - <a class="edit" href="#"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>
			<?php
			}
		}
		else 
		{?>
			By - <a class="edit" href="#"><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?></a>
		<?php
		}
		$comment_date = $rec['projComments']['updated_on'] == '0000-00-00 00:00:00'?$rec['projComments']['created']:$rec['projComments']['updated_on'];
				echo "&nbsp;-&nbsp;	on - ".date("d-M-Y", strtotime($comment_date));
		?>
	  </div>
		<p>
		<span class="editcommentbox" style="word-wrap: break-word;" id="editcomment_<?php echo $rec['projComments']['id'];?>_box"><?php echo nl2br(Sanitize::html($rec['projComments']['comment']));?></span>
		</p>
		
		</div>
	</div>
	<?php	
	}
}
else
{?>
	  <div class="comment-point"></div>
	  <div class="comment-box"><p class="error"><?php echo ERR_RECORD_NOT_FOUND; ?></p></div>
<?php
}
?>