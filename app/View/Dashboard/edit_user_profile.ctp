<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>

<script>
jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Sub-domain should contain only characters and letters.");

$(document).ready(function(){
	$("#educat").validate({
	errorElement: "p",
	errorLabelContainer: "#validation-container",
    invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) { 
		$("#success-container").hide();
		$("div#validation-container1").hide();
 		$("div#validation-container").show();
	} else {
		$("div#validation-container").hide();
	}
   },
   submitHandler: function(form) 
   {
   	  // var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	   //$.post(siteUrl+"dashboard/addEditDepartment/"+$('#dept_id').val()+"/&rand="+randomnumber, //$("#educat").serialize());

	  //  form.submit();
		  var st_or_edu = $("#st_or_edu").val(); 
	      $.post(siteUrl+"dashboard/addNewUser/"+st_or_edu+"/1",$("#educat").serialize(),function(data){
		
				var msgarr = data.split('#');
				
				if($.trim(msgarr[0])=="error")
				{
					$("#validation-container").hide();
					$("#validation-container1").show();
					$("#success-container").hide();
					$("#validation-container1").html(msgarr[1]);
				}
				if($.trim(msgarr[0])=="mailsuccess")
				{ 
					$("#validation-container").hide();
					$("#validation-container1").hide();
					$("#success-container").show();
					$("#success-container").html(msgarr[1]);
				}
		
				
		 } )
	  
		
	    
   },
   debug : false,
    rules: {
     "data[User][sitetitle]":  {required: true, numberandletter:true},	
	 "data[User][username]":  {required: true},	
	 "data[User][email]":  {required: true, email: true},		      
	 "data[User][password]":  {required: true, minlength: 5},
	 "data[User][cpassword]":  {required: true, equalTo: "#password"},
	 "data[User][firstname]":  {required: true},
	 "data[User][lastname]":  {required: true},
	 "data[User][timezone]":  {required: true},
   },
   messages: 
   {
   		"data[User][sitetitle]":{
				required: "Please enter sub-domain name.",
	       },

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
	     },

	     "data[User][timezone]":  {
	     required: "Please enter timezone."
	     }
   }
});
});
</script>

<div class="header-signup">
  <h1><span>Edit Profile</span></h1>
</div>

<div class="validation-signup" id="validation-container" style="display:none;"></div>
<div class="validation-signup" id="validation-container1" style="display:none"></div>
<div class="success" id="success-container" style="display:none"></div>

<?php echo $this->Form->create('User', array('type' => 'post','id'=>'educat')); ?>
<input type="hidden" name="st_or_edu" id="st_or_edu" value="<?php echo $st_or_edu; ?>">
<div class="main-signup">
	<h3>Your site address</h3>

	<p>Site address details, for example http://stpeters.firepaperapp.com<br />
	<strong>Letters &amp; numbers only</strong></p>

	<div class="url">
	<?php echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50', 
	'value'=>$userdata['User']['sitetitle']
	 ));?> 
	<h3>.firepaperapp.com<span class="mandatory">*</span></h3>
	</div>

	<h3>Your details</h3>
<!--	<div class="col-left">-->

		<p>First name<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'50',
		'value'=>$userdata['User']['firstname'] ));?> 
		<br />

		 <p>Last name<span class="mandatory">*</span></p>
		 <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50',
		 'value'=>$userdata['User']['lastname']));?> 

		<p>Email<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150',
		'value'=>$userdata['User']['email']));?> 
		<br />

		<p>Username<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('username',array('div'=>false,'label'=>false,"id"=>"username",'maxlength'=>'150',
		'value'=>$userdata['User']['username']));?> 
		<br />

		<p>Password<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('password',array('div'=>false,'label'=>false,"id"=>"password",'maxlength'=>'50','type'=>'password', 'value'=>''));?> 
		<br />

		<p>Re-type password<span class="mandatory">*</span></p>
		<?php echo $this->Form->input('cpassword',array('div'=>false,'label'=>false,"id"=>"cpassword",'maxlength'=>'50','type'=>'password','value'=>''));?> 
		<br />

		<p>Time Zone<span class="mandatory">*</span></p>
        <?php echo $this->Form->input('timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$defaultTimeZone));?>
		<br />

		<br />
		<?php if($st_or_edu=="educator") { ?>
		<p>Department Leader></p>
		<?php
			if($userdata['departmenTteacher']['leader']==1)
				$checked = 'true';
			else 
			$checked="";
			
		echo $this->Form->input('leader',array('div'=>false,'label'=>false,"id"=>"leader",'maxlength'=>'50','type'=>'checkbox','value'=>'1', 'checked'=>$checked )); ?> 
		<br />
		<?php } ?>
		<input name="" type="submit" value="Add Educator" class="create-account"/>

	<!--</div>-->
	
</div>

</form>
