<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Sub-domain should contain only characters and letters.");  

$(document).ready(function(){
	
	$("#closefancybox").click(function(){ 
	movepage();
//	window.location= siteUrl+"dashboard/listTeachers/"+$('#departmentId').val()+"/";
	});	
	
	
	$("#educat").validate({ 
	
	errorElement: "p",
	errorLabelContainer: "#validation-container_ad",
    invalidHandler: function(e, validator)  {
	var errors = validator.numberOfInvalids();
	if (errors) { 
		$("#success-container").hide();
		$("div#validation-container1").hide();
 		$("div#validation-container_ad").show();
	} else {
		$("div#validation-container_ad").hide();
	}
   },
   submitHandler: function(form)                                                 
   {
   	 	  var st_or_edu = $("#st_or_edu").val(); 

		  $("#loaderbox_adduser").empty().html(loader).show(); 
		  var first_name=$('#firstname').val();
		  var last_name=$('#lastname').val();
		  var email=$('#email').val();
			$('#bottomform').show();
			$('#invite_show').prepend("<input type='hidden' name='data[User_table][firstname][]' value='"+first_name+"'><input type='hidden' name='data[User_table][lastname][]' value='"+last_name+"'><input type='hidden' name='data[User_table][email][]' value='"+email+"'><div class='clear main-signup' style='margin-top:5px'><div class='left' style='width:50%'>"+first_name+" &nbsp;"+last_name+"</div>		<div class='left' style='width:50%'>"+email+"</div></div>			").slideDown("500");	
			
			$('#loaderbox_adduser').hide();
		
	  
		
	    
   },
   debug : false,
    rules: {
     "data[User][email]":  {required: true, email: true},		      
	 "data[User][firstname]":  {required: true},
	 "data[User][lastname]":  {required: true},
   },
   messages: 
   {
   	     "data[User][email]":{
				required: "Please enter email address.",
	   		email: "Please enter valid email address."
	      },

	     "data[User][firstname]":  {
	     required: "Please enter first name."
	     },

	     "data[User][lastname]":  {
	     required: "Please enter last name."
	     },

	   
   }
});

	$("#ad_invite").validate({ 
	
	submitHandler: function(form)                                                 
   {
   	 	

		 $('#loaderbox_adduser').show();
		 	$('#containerLoader').empty().html(loader);
			$.post(siteUrl+"yeargroups/addNewInvite/",$("#ad_invite").serialize(),function(data){
			
			$("#containerLoader").empty().hide();
				
				
				var msgarr = data.split('#'); 
				
				if($.trim(msgarr[0])=="error")
				{
					$("#validation-container_ad").hide();
					$("#validation-container1_ad").show();
					$("#success-container").hide();
					$("#validation-container1_ad").html(msgarr[1]);
					$('#bottomform').hide();
				}
				if($.trim(msgarr[0])=="success")
				{ 
					
					$("#validation-container_ad").hide();
					$("#validation-container1_ad").show();
					$("#maincontentdiv").hide();
					$("#addusermsgbox").show();
					
					$("#success-container_add").html(msgarr[1]).show();
				//	$("#closefancybox").show();
					$('#bottomform').hide();
					setTimeout(function(){ window.location.reload();},4000);	
					
				}
				
				$('#invite_show').html('');
		
			
			
	});
				
			$('#loaderbox_adduser').hide();
	
	    
   },
   debug : false,
  
});

});


</script>

<!--<div class="header-signup">-->
  <h1 style="margin:10px">Add New Student</h1>
<!--</div>-->

<div class="validation-signup" id="validation-container_ad" style="display:none;"></div>
<div class="validation-signup errMsg" id="validation-container1_ad" style="display:none"></div>
<div id="addusermsgbox"  class="main-signup" style="display:none;">
	<div id="success-container_add" style="display:none;"></div>	
	<div id="closefancybox" style="display:none; cursor:pointer;">Close</div>
</div>
<div  id="loaderbox_adduser" style="display:none"></div>




<?php echo $this->Form->create('User', array('type' => 'post','id'=>'educat')); ?>

<div class="main-signup" id="maincontentdiv" style="margin-bottom:10px;">

	<div class="coleducator-left"> 

		<p>First name<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'50', 'class'=>'input'));?> 
		<br />

		 <p>Last name<span class="mandatory">*</span></p>
		 <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50', 'class'=>'input'));?> 

		<p>Email<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150', 'class'=>'input'));?> 
		<br />

		
		<input name="" type="submit" value="Invite" class="submit"/>
		
		
	</div>
	
</div>

</form>


<?php echo $this->Form->create('User', array('type' => 'post','id'=>'ad_invite')); ?>
<div id="bottomform" style="display:none">
	<div id="label">
		<h2>Student You are inviting</h2>
	</div>
	
	<div id="invite_show" class="clear">
		
	</div>
	
	
	<input name="" type="submit" value="I have Done Invite Them" class="submit"/>
	
	
</div>
<?php echo $this->Form->end(); ?>


