<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>

<script>
jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value); 
}, "Sub-domain should contain only characters and letters.");  


$(document).ready(function(){
	
	$("#closefancybox").click(function(){ 
	listcoadmins();
	//window.location= siteUrl+"users/coadmins/";
	});
	
	$("#addcoadminform").validate({ 	
	errorElement: "p",
	errorLabelContainer: "#validation-container-coadmin",
    invalidHandler: function(e, validator)  {
	var errors = validator.numberOfInvalids();
	if (errors) { 
		$("#success-container").hide();
	//	$("div#validation-container1").hide();
 		$("div#validation-container-coadmin").show();
	} else {
		$("div#validation-container-coadmin").hide();
	}
   },
   submitHandler: function(form)                                                 
   {
   			var randomnumber=Math.floor(Math.random()*101);

			$("#loaderbox_addcoadmin").empty().html(loader).show(); 
		  
			$.post(siteUrl+"users/addNewCoadmin/&rand="+randomnumber, $("#addcoadminform").serialize(), function(data){
		
				$("#loaderbox_addcoadmin").empty().hide();				
				
				var msgarr = data.split('##');
				
				if($.trim(msgarr[0])=="error")
				{
					$("#validation-container-coadmin").show().html(msgarr[1]);					
				}
				if($.trim(msgarr[0])=="success")
				{ 
					$("#validation-container-coadmin").hide();
					$("#maincontentdiv").hide();
					$("#addusermsgbox").show();
					
					$("#success-container").empty().html(msgarr[1]).show();
					$("#closefancybox").show();

					
						setTimeout('listcoadmins()',5000);					
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


function listcoadmins()
{
	if($('#fancybox-wrap').css('display') == "block")
	{
		$.fancybox.close();
		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
		loadPiece(siteUrl+"users/listCoadminsAjax/?rand="+randomnumber,"#content_coadmin");
	}
}
</script>

<div class="validation-signup" id="validation-container-coadmin" style="display:none;"></div>
<div  id="loaderbox_addcoadmin" style="display:none"></div>
<div id="addusermsgbox"  class="main-signup" style="display:none;">
	<div id="success-container" style="display:none;"></div>	
	<div id="closefancybox" style="display:none; cursor:pointer;">Close</div>
</div>

<?php echo $this->Form->create('User', array('type' => 'post','id'=>'addcoadminform')); ?>

<div class="main-signup" id="maincontentdiv" style="margin-bottom:10px;">

<!--<div class="header-signup">-->
  <h1 style="margin:10px">Add New Co-Admin</h1>
<!--</div>-->

	<h3>Your site address</h3>

	<p>Site address details, for example http://stpeters.firepaperapp.com<br />
	<strong>Letters &amp; numbers only</strong></p>

	<div class="url">
	<?php echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50'));?> 
	<h3>.firepaperapp.com<span class="mandatory">*</span></h3>
	</div>

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

		<p>Time Zone<span class="mandatory">*</span></p>
        <?php echo $this->Form->input('timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$defaultTimeZone));?>
		<br />

		
		
		<input name="" type="submit" value="Add Co-admin" class="create-account"/>
		
	</div>
	
</div>

</form>