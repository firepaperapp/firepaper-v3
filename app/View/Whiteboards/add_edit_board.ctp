<script src="<?php echo JS_PATH?>ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
jQuery.validator.addMethod("checktextarea", function(value, element, param) 
{
		var editorcontent = CKEDITOR.instances['content'].getData().replace(/<[^>]*>/gi, '');
	 	var mydiv = document.createElement("div");
        mydiv.innerHTML = editorcontent;
		var check;
        if (document.all) // IE Stuff
        {
            check = mydiv.innerText;
           
        }   
        else // Mozilla does not work with innerText
        {            
            check = mydiv.textContent;
        }    
		if($.trim(check)=='')
		{
			//$("#errcontent").show().html('Please enter the content'); 
			return false;
		}
		else
		{
			return true;
		}
		
	 

}, "Please enter the content.");

$(document).ready(function(){

	 $('#whiteboardform').validate({
		errorElement: "p",		
		
		 
		rules: {
		"data[Whiteboard][title]":  {required: true}	,	
		"data[Whiteboard][content]":  {checktextarea: true}
		},
		messages:
		{
		"data[Whiteboard][title]":{
			required: "Please enter Title."
		} 
		}
	});
});
	function  checktextarea()
	{
		 
		
		
	}
	
	function cancelboard()
	{
		window.location= siteUrl+"Whiteboards/";
	}

	function changeButtonText()
	{  
		if($('#updtchk').val()==0)
		{
			$('#updtchk').val('1');
			$("#submit1").val('Save As New Version');
		}
		if($('#updtchk').val()==1)
		{
			$('#updtchk').val('0');
			$("#submit1").val('Update Current Version');
		}
		
	}

</script>
<div class="activity">
	<div class="index">
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
	<?php } ?>
	<div class="marginT10"><h3><?php echo $heading; ?></h3></div>
	<br/>
	<?php echo $this->Form->create('Whiteboard', array('action'=>'/addEditBoard/'.$whiteboardID,'type' => 'post', 'id'=>'whiteboardform')); ?>
	
	Title :
	<?php echo $this->Form->input('Whiteboard.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'256', "value"=>$contenttitle,'type'=>"text","width"=>"150"));
	?>
	<br><br>
	Content :
	<textarea id="content" name="data[Whiteboard][content]"><?php echo $content; ?></textarea>
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
	 	<div class="clr"></div>
	 	<div class="submit-wrapper">
			<?php 
				if($showbutton=='Y')
				{?>	
					<input type="submit" class="submit" name="submit" value="Save As New Version" onclick="javascript:$('#newversion').val(1);" id="submit">&nbsp;&nbsp;
					<input type="submit" class="submit" name="updatesubmit" value="Update Current Version" id="updatesubmit">&nbsp;&nbsp;
					
			<?php
				}
				else
				{?>
					<input type="submit" class="submit" name="submit" value="Save" id="submit">&nbsp;&nbsp;
				<?php 
				}?>
				
				<input onclick="cancelboard();" class="submit" type="Button" name="cancel" value="Cancel" id="cancel">
				<input type="hidden" name="data[newversion]" value="0" id="newversion">
				<br><br>
		</div>
		</form>
	</div>
</div>