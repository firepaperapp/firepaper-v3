<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	
	$("#closefancybox").click(function(){ 
	movepage();
	});	

	
	
	$("#projcomment").validate({ 
		errorElement: "p",
		
		submitHandler: function(form)                                                 
		{
			$("#posted_to_comnt").val($("#posted_to").val());
			$("#project_id_comnt").val($("#project_id").val());
			$("#loaderbox_sendmsg").empty().html(loader).show(); 		  
			$.post(siteUrl+"projects/sendMessage/",$("#projcomment").serialize(),function(data){

				$("#loaderbox_sendmsg").empty().hide();
				$("#addcommentmsgbox").show();
				$("#success-container").empty().html(data).show();
				setTimeout("movepage()",5000);	
			});
	   },
	   debug : false,
	    rules: {
		 "data[User][sitetitle]":  {required: true, numberandletter:true}
	   },
	   messages:{
			"data[User][sitetitle]":{ required: "Please enter sub-domain name." }      
	   }
	});
	
});  // ready ends

function movepage()
{
	window.location= siteUrl+"/projects/viewDetails/"+$("#project_id").val();
}
</script>

<!--<div class="header-signup">-->
  <h1 style="margin:10px">Send Message</h1>
<!--</div>-->

<div  id="loaderbox_sendmsg" style="display:none"></div>
<div id="addcommentmsgbox"  class="main-signup" style="display:none;margin-bottom:10px;width:450px;">
	<div id="success-container"></div>	
	<div id="closefancybox" style="cursor:pointer;">Close</div>
</div>


	<div style="width:500px;height:300px"> 
	<?php echo $this->Form->create('projComments', array('type' => 'post','id'=>'projcomment')); ?>

		<?php echo $this->Form->textarea( 'projComments.comment', array('id'=>'comment', 'rows'=>10, 'cols'=>50, 'class'=>'addressBox required', 'label' => false)); ?>
		
		<br>
		<br>
		<input type="checkbox" name="chktype" id="chktype"> &nbsp; &nbsp;
		Make comment as private
		
		<br>

		<?php echo $this->Form->submit( 'submit', array('id'=>'submit','label' => false,'class'=>'')); ?>
		<input type="hidden" name="posted_to_comnt" id="posted_to_comnt" value="" />
		 <input type="hidden" name="project_id_comnt" id="project_id_comnt" value="" />

		
		</form>
	</div>
