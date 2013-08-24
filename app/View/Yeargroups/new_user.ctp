<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>

<script>
jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Sub-domain should contain only characters and letters.");  


$(document).ready(function(){
	
	$("#closefancybox").click(function(){ 
//	movepage();

  $.fancybox.close();
	});
	
	
	$("#gaurdianform").validate({  
	
	errorElement: "p",
	errorLabelContainer: "#gard_validation-container",
    invalidHandler: function(e, validator)  {
	var errors = validator.numberOfInvalids();
	if (errors) { 
		$("#success-container").hide();
		$("div#gard_validation-container1").hide();
 		$("div#gard_validation-container").show();
	} else {
		$("div#gard_validation-container").hide();
	}
   },
   submitHandler: function(form)                                                 
   {
		  $("#loaderbox_adduser").empty().html(loader).show(); 
		  $("div#gard_validation-container1").hide();
		  $("div#gard_validation-container").hide();
			$.post(siteUrl+"yeargroups/newUser/",$("#gaurdianform").serialize(),function(data){
		
				$("#loaderbox_adduser").empty().hide();
				
				
				var msgarr = data.split('##'); 
				
				if($.trim(msgarr[0])=="error")
				{
					$("#gard_validation-container").hide();
					$("#gard_validation-container1").show();
					$("#success-container").hide();
					$("#gard_validation-container1").html(msgarr[1]);
				}
				if($.trim(msgarr[0])=="success")
				{ 
					
					$("#gard_validation-container").hide();
					$("#gard_validation-container1").hide();
					$("#maincontentdiv").hide();
					$("#addusermsgbox").show();
					
					$("#success-container").empty().html(msgarr[1]).show();
					$("#closefancybox").show();

					var gardid = "#gname_"+$("#studentid").val(); //alert(gardid); alert(msgarr[2]);
					$(gardid).empty().html(msgarr[2]).show();
					
					var addgaurdId = "#addgaurdian_"+$("#studentid").val();
					$(addgaurdId).hide(); //hiding the add gaurdian link
				
					
		
				//	setTimeout("movepage()",5000);	
				setTimeout("$.fancybox.close();",5000);	
					
				}
		
				
		 } )
	    
   },
   debug : false,
    rules: {
   //  "data[User][sitetitle]":  {required: true, numberandletter:true},	
	 "data[User][username]":  {required: true},	
	 "data[User][email]":  {required: true, email: true},		      
	 "data[User][password]":  {required: true, minlength: 5},
	 "data[User][cpassword]":  {required: true, equalTo: "#password"},
	 "data[User][firstname]":  {required: true},
	 "data[User][lastname]":  {required: true}
	
   },
   messages: 
   {
   		//"data[User][sitetitle]":{
			//	required: "Please enter sub-domain name.",
	     //  },

	      "data[User][username]":{
				required: "Please enter username.",
	       },

	     "data[User][email]":{
				required: "Please enter email address.",
	   		email: "Please enter valid email address."
	      },

	     "data[User][password]": {
	     	required: "Please enter password.",
	     	minLength: "Password should be greater than 5 characters"
	     },

	     "data[User][cpassword]":  {
	     	required: "Please re-type password.",  	 	     	
	     	equalTo: "Password and Confirm Password do not match."
	     }
	     ,
	     "data[User][firstname]":  {
	     required: "Please enter firstname."
	     },

	     "data[User][lastname]":  {
	     required: "Please enter lastname."
	     }
   }
});
});

//function movepage()
{ 
	//	window.location= siteUrl+"yeargroups/classGroups/"+$("#group_id").val();
}
</script>

<!--<div class="header-signup">-->
  <h1 style="margin:10px">Add New Gaurdian<?php //echo $heading;?></h1>
<!--</div>-->

<div class="validation-signup" id="gard_validation-container" style="display:none;"></div>
<div class="validation-signup" id="gard_validation-container1" style="display:none"></div>
<div id="addusermsgbox"  class="main-signup" style="display:none;">
	<div id="success-container" style="display:none;"></div>	
	<div id="closefancybox" style="display:none; cursor:pointer;">Close</div>
</div>
<div  id="loaderbox_adduser" style="display:none"></div>




<?php echo $this->Form->create('User', array('type' => 'post','id'=>'gaurdianform')); ?>

<div class="main-signup" id="maincontentdiv" style="margin-bottom:10px;">
<!--	<h3>Your site address</h3>

	<p>Site address details, for example http://stpeters.firepaperapp.com<br />
	<strong>Letters &amp; numbers only</strong></p>

	<div class="url">
	<?php echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50'));?> 
	<h3>.firepaperapp.com<span class="mandatory">*</span></h3>
	</div>-->

	<h3>Your details</h3>
 	<div class="coleducator-left"> 

		<p>First name<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'50', 'class'=>'input'));?> 
		<br />

		 <p>Last name<span class="mandatory">*</span></p>
		 <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50', 'class'=>'input'));?> 

		<p>Email<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150', 'class'=>'input'));?> 
		<br />

		<p>Username<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('username',array('div'=>false,'label'=>false,"id"=>"username",'maxlength'=>'150', 'class'=>'input'));?> 
		<br />

		<p>Password<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('password',array('div'=>false,'label'=>false,"id"=>"password",'maxlength'=>'50','value'=>'','type'=>'password', 'class'=>'input'));?> 
		<br />

		<p>Re-type password<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('cpassword',array('div'=>false,'label'=>false,"id"=>"cpassword",'maxlength'=>'50','type'=>'password','value'=>'', 'class'=>'input'));?> 
		<br />

		<input type="hidden" name="data[User][studentid]" value="<?php echo $studentID;?>" id="studentid">

		
		<input name="" type="submit" value="Add Gaurdian" class="create-account"/>
		
		
 		
		
		
	</div>
	
</div>

</form>
