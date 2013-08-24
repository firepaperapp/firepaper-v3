<script src="<?php echo JS_PATH ?>jquery.validate.js" type="text/javascript"></script>
<script language="Javascript">
jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Sub-domain should contain only characters and letters.");  

jQuery.validator.addMethod("siteTitleRequired", function(value, element, param) 
{	 
	if($("#sitetitle").css("display") == "none")
	{
		return true;
	}
	else
	{
		 
		if($.trim($("#sitetitle").val()) == "")
		{
			return false;
		}
		else
		{
			return true;
		}
	}

}, "Please enter site title.");  


	$(document).ready(function() {
	$('#adminFrm').validate(
	{
		errorElement: "p",
		errorClass: "error1",

		   errorLabelContainer: "#validation-container",
		   unhighlight: function(element, errorClass) {
	 
		   },	
		   debug:false,
		   invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			 	if (errors) {
			 		$("div#validation-container").show();
				} else {
					$("div#validation-container").hide();
				}
			},
		
		submitHandler: function(form)                                                 
		{
			//$("#loaderid").empty().html(loader).show();
			$.post(siteUrl+"admin/addedituser/",$("#adminFrm").serialize(),function(data){
			//$("#loaderid").empty().hide();
			var msgarr = data.split("@@"); 
			if($.trim(msgarr[0])=="error")
			{
				$("#validation-container").empty().html(msgarr[1]).show();
			}
			else
			{
			 
				if($("#uid").val()!=="" && $("#uid").val() > 0)
				{
					window.location= siteUrl+"admin/manageusers";
				}
				else
				{
					window.location= siteUrl+"admin/subscribe";
				}
			}
			
			});

		},
	 	rules: {
			  "data[User][sitetitle]":  {siteTitleRequired: true, numberandletter:true},
		      "data[User][username]":  {required: true},	
			  "data[User][password]":  {required: true, minlength: 5},
			  "data[User][confirmpassword]":  {required: true, equalTo: "#password"},
			  "data[User][email]":  {required: true, email: true},	
			  "data[User][firstname]":  {required: true},	
			   "data[User][lastname]":  {required: true}

			   },
		messages:{	
			"data[User][sitetitle]":{
				required: "Please enter sub-domain name.",
	       },
		
			"data[User][username]": {
	     	required: "Please enter username."
			},

		  "data[User][firstname]": 
		  {
	     	required: "Please enter first name."
		  },

		 "data[User][lastname]": {
	     	required: "Please enter last name."
	     } ,

		 "data[User][email]": {
	     	required: "Please enter email."
	     },

		 	"data[User][password]": {
	     	required: "Please enter password.",
	     	minLength: "Password should be greater than 5 characters"

	     },
	     "data[User][confirmpassword]":  {
	     	required: "Please re-type password.",
	     	equalTo: "Password and Confirm Password do not match."
	     }	 
		
   }

		
	}	);
	});
</script>
<?php
	if($this->Session->check('Message.flash'))
	{?>
		<div class="essage errorServer">
			<div class="validation-container">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?>
<div id="validation-container" class ="validation-signup" style="display:none;border 1px solid red;"></div>
<div style="display:none;" id="loaderid"></div>
<!--<div style="display:none;" class="errordiv" id="errordiv"></div>-->
<form name="adminFrm" action="" method="post" id="adminFrm">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table cellpadding="0" cellspacing="5" border="0" width="600" class="registerTable">
					<tr >
						<td  id="errordiv" align="center" style="display:none;border:1px solid red;" colspan="2"></td>
					</tr>
					<tr >
						<td  colspan="2"><h2>STEP 1</h2></td>
					</tr>
					<?php
					$style = "";
					 
					if(isset($userdata['User']['user_type_id']))
					{
						if($userdata['User']['user_type_id'] == 6)
						{
							$style="display:none;";							 
						}
						$defaultTimeZone = $userdata['User']['timezone'];
					}
					?>
					<tr style="<?php echo $style;?>">
						<td valign="top" width="25%">Sitetitle<span class="mandatory">*</span></td>
						<td valign="top" width="75%"><?php echo $this->Form->input( 'User.sitetitle', array('id'=>'sitetitle', 'value'=> $userdata['User']['sitetitle'],'class'=>'inputBox', 'maxlength'=>50, 'label' => false, "style"=>$style) ); ?></td>
					</tr>

					<tr>
						<td valign="top" width="25%">Username<span class="mandatory">*</span></td>
						<td valign="top" width="75%"><?php echo $this->Form->input( 'User.username', array('id'=>'username', 'value'=> $userdata['User']['username'],'class'=>'inputBox required', 'maxlength'=>50, 'label' => false) ); ?></td>
					</tr>

					<tr>
						<td valign="top">First Name<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->input( 'User.firstname', array('id'=>'first_name', 'class'=>'inputBox required','value'=>$userdata['User']['firstname'], 'maxlength'=>50, 'label' => false)); ?></td>
					</tr>

					<tr>
						<td valign="top">Last Name<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->input( 'User.lastname', array('id'=>'last_name', 'class'=>'inputBox required', 'value'=>$userdata['User']['lastname'],'maxlength'=>50, 'label' => false)); ?></td>
					</tr>

					<tr>
						<td valign="top">Email Address<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->input( 'User.email', array('id'=>'email', 'class'=>'inputBox required email', 'value'=>$userdata['User']['email'], 'maxlength'=>50, 'label' => false)); ?></td>
					</tr>
				 
					<tr>
						<td valign="top">Password<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->password( 'User.password', array('id'=>'password', 'class'=>'inputBox required', 'maxlength'=>50, 'label' => false)); ?></td>
					</tr>
					<tr>
						<td valign="top">Confirm Password<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->password( 'User.confirmpassword', array('id'=>'confirmpassword', 'class'=>'inputBox required', 'maxlength'=>50, 'label' => false)); ?></td>
					</tr>
					<tr>
						<td valign="top">User Type:</td>
						<td valign="top">
							<?php
							if($userID!=0)
							{?>
								  <input type="hidden" name="data[User][usertype]" value="<?php echo $userdata['User']['user_type_id'];?>">
								  <?php
								  foreach($arTypesAll as $usertype) 
								  { 
									  if($usertype['UserType']['id']==$userdata['User']['user_type_id'])
									  { 
									  	echo '<div style="text-align:left;">'.$usertype['UserType']['title'].'</div>'; 									  
									  }
									  else
									  {  }
								  }?>
								 
							<?php
							}
							else 
							{?>
								<select name="data[User][usertype]">
									<?php 
									  foreach($arrTypes as $usertype) 
									  { 
										  if($usertype['UserType']['id']==$userdata['User']['user_type_id'])
										  { $selected="SELECTED" ; }
										  else
										  { $selected="";} 
										?>
									 <option value="<?php echo $usertype['UserType']['id'];?>" <?php echo $selected;?>> <?php echo $usertype['UserType']['title'];?></option>
							<?php }
								?>
								</select>
								<!--<select name="data[User][trialpackage]">
									<option value="0">Regular Package</option>
									<option value="1">Free Trial</option>
								</select>-->
								<?php
							} ?>
							
						</td>
					</tr>
  					<tr>
						<td valign="top">Timezone</td>
						<td valign="top"><?php echo $this->Form->input('User.timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$defaultTimeZone));?></td>
					</tr>
 					<tr>
						<td valign="top" align="right"><?php echo $this->Form->submit('Submit'); ?></td>
						<td valign="top"  align="left">
				<input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL; ?>admin/manageusers"' name="reset" value="Cancel" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="uid" value="<?php echo $userID; ?>" id="uid">
</form>