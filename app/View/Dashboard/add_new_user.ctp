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
	errorLabelContainer: "#validation-container",
    invalidHandler: function(e, validator)  {
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

		  $("#loaderbox_adduser").empty().html(loader).show(); 
		  
			$.post(siteUrl+"dashboard/addNewUser/"+st_or_edu+"/"+$('#departmentId').val()+"/"+$("#group_id").val(),$("#educat").serialize(),function(data){
		
				$("#loaderbox_adduser").empty().hide();
				
				
				var msgarr = data.split('#'); 
				
				if($.trim(msgarr[0])=="error")
				{
					$("#validation-container").hide();
					$("#validation-container1").show();
					$("#success-container").hide();
					$("#validation-container1").html(msgarr[1]);
				}
				if($.trim(msgarr[0])=="success")
				{ 
					
					$("#validation-container").hide();
					$("#validation-container1").hide();
					$("#maincontentdiv").hide();
					$("#addusermsgbox").show();
					
					$("#success-container").empty().html(msgarr[1]).show();
					$("#closefancybox").show();


				//	$("#success-container").html(msgarr[1]);
					//alert(msgarr[1]);
					//alert($('#referer').val());
					if($('#referer').val() == "/departments")
					{
						 var did ='#'+$('#userType').val()+'View_'+$('#departmentId').val();
						  $.fancybox.close();
						   
						  $(did+"_box").empty().html(loader);
						  $.get(siteUrl+"dashboard/getDepartmentUser/"+$('#departmentId').val()+"/"+$('#userType').val()+"/",   function(data)
							{	
					 			$(did+"_box").empty().html(data);
					 			 
					  		});
					}
					if($('#referer').val() == "/teachers")
					{
						
					}
									
				/*	if($('#referer').val() == "/listTeachers")
					{
					
				$.fancybox.close();
				loadPiece(siteUrl+"dashboard/listTeachers/"+$('#departmentId').val()+"/","#content_teachers");
					}*/

				setTimeout("movepage()",5000);	
					
				}
		
				
		 } )
	  
		
	    
   },
   debug : false,
    rules: {
     //"data[User][sitetitle]":  {required: true, numberandletter:true},	
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
   			/*"data[User][sitetitle]":{
				required: "Please enter sub-domain name.",
	       },*/

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
	     required: "Please enter first name."
	     },

	     "data[User][lastname]":  {
	     required: "Please enter last name."
	     },

	     "data[User][timezone]":  {
	     required: "Please enter time zone."
	     }
   }
});
});

function movepage()
{ 
	
	if($('#st_or_edu').val() == "educator")
	{
		window.location= siteUrl+"dashboard/listTeachers/"+$('#departmentId').val()+"/";
	}
	if($('#st_or_edu').val() == "student")
	{
		window.location= siteUrl+"yeargroups/classGroups/"+$("#group_id").val();
	}

}
</script>

<!--<div class="header-signup">-->
  <h1 style="margin:10px">Add New <?php echo $heading;?></h1>
<!--</div>-->

<div class="validation-signup" id="validation-container" style="display:none;"></div>
<div class="validation-signup" id="validation-container1" style="display:none"></div>
<div id="addusermsgbox"  class="main-signup" style="display:none;">
	<div id="success-container" style="display:none;"></div>	
	<div id="closefancybox" style="display:none; cursor:pointer;">Close</div>
</div>
<div  id="loaderbox_adduser" style="display:none"></div>




<?php echo $this->Form->create('User', array('type' => 'post','id'=>'educat')); ?>
<input type="hidden" name="st_or_edu" id="st_or_edu" value="<?php echo $st_or_edu; ?>">
<div class="main-signup" id="maincontentdiv" style="margin-bottom:10px;">
	<!-- <h3>Your site address</h3>

	<p>Site address details, for example http://stpeters.cloudpollen.com<br />
	<strong>Letters &amp; numbers only</strong></p>

	<div class="url">
	<?php echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50'));?> 
	<h3>.cloudpollen.com<span class="mandatory">*</span></h3>
	</div>
	-->
	<h3>Site details</h3>
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

		<p>Time Zone<span class="mandatory">*</span></p>
        <?php echo $this->Form->input('timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$defaultTimeZone));?>
		<br />

		<br />
		<?php if($st_or_edu=="educator" && $departmentId > 0) { ?>
		<p>Department Leader</p>
		<?php echo $this->Form->input('leader',array('div'=>false,'label'=>false,"id"=>"leader",'maxlength'=>'50','type'=>'checkbox','value'=>'1')); ?> 
		<br />
		<?php } ?>
		<input name="" type="submit" value="Add <?php if($st_or_edu=="educator") { ?>Educator<?}else{?>Student<?}?>" class="submit"/>
		<input type="hidden" name="referer" id="referer" value="<?php echo $referer?>" />
		<input type="hidden" name="userType" id="userType" value="<?php echo $st_or_edu?>" />
 		<input type="hidden" name="departmentId" id="departmentId" value="<?php echo $departmentId; ?>" />
		<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id?>" />
		
	</div>
	
</div>

</form>
