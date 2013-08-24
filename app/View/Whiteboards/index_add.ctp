<script src="<?php echo JS_PATH?>ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){

	 $('#whiteboardform').validate({
		errorElement: "p",		
		
		 
		rules: {
		"data[Whiteboard][title]":  {required: true}//,
//		"data[Whiteboard][content]":  {required: true}
		
		},
		messages:
		{
		"data[Whiteboard][title]":{
			required: "Please enter Title."
		} //,

	//	"data[Whiteboard][content]":{
		//	required: "Please enter Content.",
	//	}
		}
	});


});
	function checktextarea()
	{
		var editorcontent = CKEDITOR.instances['content'].getData().replace(/<[^>]*>/gi, '');

		if($.trim(editorcontent)=='')
		{
			$("#errcontent").show().html('Please enter the content'); 
			return false;
		}
		return true;
	}

</script>



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
		<br>
	<?php }
?>


<?php echo $this->Form->create('Whiteboard', array('action'=>'/addEditContent','type' => 'post', 'id'=>'whiteboardform','onsubmit'=>'return checktextarea();')); ?>

Title :
<?php echo $this->Form->input('Whiteboard.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'256', "value"=>"",'type'=>"text"));
?>
<br><br>
Content :
<textarea id="content" name="data[Whiteboard][content]"></textarea>
<p id="errcontent" style="display:none;color:red;"></p>
<script type="text/javascript">		
			CKEDITOR.replace( 'content',
			{
				toolbar : 'MyToolbar',
			/*	uiColor : '#f2f2f2',
				width : '700px',
				height: '60px',
				resize_enabled: false,
				toolbarCanCollapse: false,
				toolbarLocation: 'bottom',
				removePlugins: 'elementspath'*/

			});
			</script>

			<br><br>
<input type="submit" name="submit" value="Submit" id="submit"><br><br>

</form>
