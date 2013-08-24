<style>
.deleteuser{
padding : 10px;
width :200px;
margin:10px;
float : left;
}

</style>


<script>
$(document).ready(function (){

	var uid = $("#urluid").val();  
	$("#no").click(function(){ 
		 $.fancybox.close();
	});

	$("#closefancybox").click(function(){
		$.fancybox.close();  
		window.location= siteUrl+"dashboard/listTeachers/";

	});

	
	$("#yes").click(function(){
		$("#msgdiv").empty().html(loader).show();
		$("#deleteuser").hide();
		
		$.post(siteUrl+'users/deleteAccount/'+uid, '',function(data){   
			var arrdata= data.split("@");  
			$("#msgdivdel").empty().html(arrdata[1]).show();
			$("#closefancybox").show();

			if(arrdata[0]==1)
			{
				$("#closefancybox").click(function(){
				$.fancybox.close();  
				window.location= siteUrl;

			});
			}
			if(arrdata[0]==2)
			{
				$("#closefancybox").click(function(){
				$.fancybox.close();  
				window.location= siteUrl+"dashboard/listTeachers/";

			});
			}
			if(arrdata[0]==3)
			{
				$("#closefancybox").click(function(){
				$.fancybox.close();  
				window.location= siteUrl+"yeargroups/viewgroups/";

			});
			}
			setTimeout("movepage("+arrdata[0]+")",5000);

				
			//window.location= siteUrl+"dashboard/listTeachers/";

			});
	
	});

	$("#passwordform").validate({ 
    errorElement: "p",
    errorLabelContainer: "#validation-containercheck",

    //debug:true,
    highlight: function(element, errorClass) {
   },
   unhighlight: function(element, errorClass) {
   },
   invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 		$("div#validation-containercheck").show();
		//slideupdiv(2);
	} else {
		$("div#validation-containercheck").hide();
	}
	},
   submitHandler: function(form) {  					
					$('#loaderbox1').empty().html(loader).show();
					
                    $.post(siteUrl +'users/checkPassword/',$("#passwordform").serialize(),function(data)
                    { 
						$('#loaderbox1').hide(); 
						if($.trim(data)=="success")
						{	
							$("#pwdbox1").hide()
							$("#validation-containercheck").hide(); 
							$("#deleteuser").show();
						}
						else
						{	$("#validation-containercheck").html(data).show(); }			
                    });
	        },

   //onkeyup: false,
   rules: {  "data[User][password]":  {required: true}  },
   messages:
   {
			"data[User][password]": {
	     	required: "Please enter password.",
	     	minLength: 5
	     }
	   }
});


$("#canceldelete").click(function(){ 
		 $.fancybox.close();
	});





});//ready ends

function movepage(id)
{
	
	if(id==1)
	{
		window.location= siteUrl;
	}
	if(id==2)
	{
		window.location= siteUrl+"dashboard/listTeachers/";
	}
	if(id==3)
	{
		window.location= siteUrl+"yeargroups/viewgroups/";
	}
}

</script>
<div id="loaderbox1" style="display:none;"></div>
<div id="validation-containercheck" style="display:none;color:red;"></div>
<div id="msgdivdel" style="display:none;"></div>
<div id="closefancybox" style="display:none; cursor:pointer;" >Close</div>
<?php
if($checkdelete=="Y")
{ 
?>
<div id="pwdbox1" class="deleteuser">
		<?php echo $this->Form->create('User', array('type' => 'post','id'=>'passwordform')); ?>				
			Enter Your Password : 
			<?php echo  $this->Form->input('password',array('label'=> false,'maxlength'=>'150','value'=>"", 'id'=>'password' )); ?>			  
		   <span style="float:left">
				<?php echo  $this->Form->submit('Ok',array('label'=> false,'div'=>false));?>
		   </span>				
		   <?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'canceldelete','div'=>false));?>
		</form>
</div>
<div class="deleteuser" id="deleteuser" style="display:none">
	<p> Are you sure to delete your account</p>
	<input type="button" name="yes" id="yes" value="Yes">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="no" id="no" value="No">
</div>
<?php } 
else{ 
?>
<div class="deleteuser" id="deleteuser">
	<p> Are you sure to delete this user</p>
	<input type="button" name="yes" id="yes" value="Yes">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="no" id="no" value="No">
</div>
<?php  } ?>