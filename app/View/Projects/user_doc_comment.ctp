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
			echo		$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?>
<?php
//$pointer = "task-pointer";
$box = "task-comment";

if(strpos($_SERVER['HTTP_REFERER'], "markProject") != 0)
{
	//$pointer = "comment-point";
//$box = "comment-box";
}
if(count($taskComments)>0 && isset($taskComments[0]['projComments']['id']))
{?>
	
	<h3>Comments</h3>
	<?php
	foreach($taskComments as $rec)
	{
		//echo USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic'];
		if(is_file(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$rec['User']['profilepic']))
		{
			$userimage = USER_IMAGES_PATH.'100X100/'.$rec['User']['profilepic'];
		}
		else
		{
			$userimage = IMAGES_PATH.'profile-pic.png';
		}
	?>
	<div  id="delcomment_<?php echo $rec['projComments']['id'];?>">
	
	  <div class="<?php echo $box;?>">
	  <div class="authorbox">
	  <img id="imgid" alt="" height="55" width="55" src="<?php echo $userimage;?>" />
	  <p>
	  <?php
		if($this->Session->read("userid") == $rec['projComments']['posted_by'] || ( $isOwner == 1 && $viewType == "common"))
		{ ?>
		<?php if($isOwner == 1) { ?>
				<!--<a class="edit" href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>">--><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?><!--</a>-->
				<br />
		<?php
			}
		} else { ?>
			<!--<a class="edit" href="<?php echo SITE_HTTP_URL."users/viewProfile/".$rec['User']['id'];?>">--><?php echo ucfirst(Sanitize::html($rec['User']['firstname']." ".$rec['User']['lastname']));?><!--</a>-->
		<?php } ?>
		
		
		<?php
		$comment_date = $rec['projComments']['updated_on'] == '0000-00-00 00:00:00'?$rec['projComments']['created']:$rec['projComments']['updated_on'];
		echo "".date("F j, Y", strtotime($comment_date));
		?>
	  </p>
	  </div>
		<p>
		<span class="editcommentbox" style="word-wrap: break-word;" id="editcomment_<?php echo $rec['projComments']['id'];?>_box"><?php echo nl2br(Sanitize::html($rec['projComments']['comment']));?></span>
		</p>
		<a href="javascript:void(0);" id="editcomment_<?php echo $rec['projComments']['id']?>" class="editcommentlink edit">Edit</a>
		<a href="javascript:void(0)" onclick="delCommentId(<?php echo $rec['projComments']['id'];?>, <?php echo $userTaskId; ?>, '<?php echo $from;?>');" class="edit">Delete</a>
		</div>
	</div>
	
	<?php	
	}
	?>
	<input type="hidden" name="countComment" id="countcomment" value="<?php echo count($taskComments)?>" />
<?php
}
else
{?>
	  <div class="comment-point"></div>
	  <div class="comment-box"><p class="error"><?php echo ERR_RECORD_NOT_FOUND; ?></p></div>
<?php
}
?>