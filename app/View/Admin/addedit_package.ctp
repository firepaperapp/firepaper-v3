<script src="<?php echo JS_PATH ?>jquery.validate.js" type="text/javascript"></script>
<script language="Javascript">
$(document).ready(function() { 
	
		var changePaymentDivs = function()
	 	{
	 	
	 		/*if ($("input[name='pkg_unlimited']:checked").val() == '1') {
  	 	 
 
		 		//$("#vPayPalEmail").rules("add", {required: true, messages: {required: ""}});
		  		$("#pack_space").rules("remove", "required"); 
		  		$("#pack_space").rules("remove", "min"); 
		  		$("#pack_space").parents("tr:first").hide();
		  		$("#pack_space").val(0);
 		 	}
		 	else
		 	{
		 		 $("#pack_space").rules("add", {required: true, min:1, messages: {required: "Please enter space."}});
		 		 $("#pack_space").parents("tr:first").show();
		 		 $("#pack_space").show().val();
		 	}*/
	 		
	 		$("#pack_amt").removeAttr("readonly");
	 		if($("#package_type").val() == "trial" || $("#package_type").val() == "free")
	 		{
	 			 $("#pack_amt").val("0").attr("readonly",  "readonly");
	 		}
	 		if($("#package_type").val() == "unlimited")
	 		{
 				$("#pack_space").rules("remove", "required"); 
		  		$("#pack_space").rules("remove", "min"); 
		  		$("#pack_space").parents("tr:first").hide();
		  		$("#pack_space").val("0");
		  		
	 		}
	 		else
	 		{
	 			 $("#pack_space").rules("add", {required: true, min:1, messages: {required: "Please enter space."}});
		 		 $("#pack_space").parents("tr:first").show();
		 		 $("#pack_space").show().val();
		 		 
	 		}
	 		if($("#package_type").val() == "regular")
	 		{
 				 
		  		$("#tdDefault").show();
		  		
	 		}
	 };
	jQuery.validator.addMethod("numberanddot", function(value, element, param) 

		{
		
		return this.optional(element) || /^[a-z0-9.]+$/i.test(value);
		
		}, "Please enter only numeric values.");

		$('#packagefrm').validate(
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
			submitHandler: function(form) {
		    // do other stuff for a valid form
		    if($("input[name=isdefault]:checked").val() == 1)
		    {
		    	if(!confirm("Are you sure you want to make this package as the default package?"))
		    	{
		    		return false;
		    	}
		    }
		   	form.submit();
		   },
			rules: {
             "data[Package][name]":  {required: true},
			 "data[Package][amount]":  {required: true, numberanddot: true, min:0} 
			   },
		   messages:
		   {		
				 "data[Package][name]": {
			     	required: "Please enter package name."
			     	
			     }, 
				 "data[Package][amount]": {
			     	required: "Please enter amount."
			     	
			     },
				  "data[Package][space]": {
			     	required: "Please enter space."
			     	
			     }
			    
		   } 
	}	);
	$('#package_type').bind('change', function()
			{
				changePaymentDivs();				
			}
		 );		
changePaymentDivs();
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
<form name="plansfrm" action="" method="post" id="packagefrm">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table cellpadding="0" cellspacing="5" border="0" width="600" class="registerTable">
					<tr>
						<td valign="top" width="25%">Package Type<span style="color:red;"class="mandatory">*</span> </td>
						<td valign="top"><?php echo $this->Form->input('Package.package_type', array('type'=>'select','div'=>false, 'label'=>false, 'options'=>$package_type, 'id'=>"package_type", "value"=>$selectedPackageType)); ?>	</td>
					</tr>
					 
					<tr>
						<td valign="top" width="25%">User Type:</td>
						<td valign="top"><?php echo $this->Form->input('Package.user_type_id', array('type'=>'select','div'=>false, 'label'=>false, 'options'=>$packusertypes, 'id'=>"usrtpe")); ?>				
						</td>
					</tr>

					<tr>
						<td valign="top" width="25%">Name<span style="color:red;" class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->input( 'Package.name',  array('id'=>'pack_name', 'class'=>'inputBox required','maxlength'=>50, 'label' => false)); ?></td>
					</tr>
 				
					<tr>
						<td valign="top" width="25%">Amount<span style="color:red;"class="mandatory">*</span><div style="float:right">$</div></td>
						<td valign="top"><?php echo $this->Form->input( 'Package.amount',  array('id'=>'pack_amt', 'class'=>'inputBox required', 'maxlength'=>9, 'label' => false)); ?></td>
					</tr>
		 			<tr>
						<td valign="top" width="25%">Space<span style="color:red;" class="mandatory">*</span> <div style="float:right"></div></td>
						<td valign="top"  style="text-align:left"><?php echo $this->Form->input( 'Package.space',  array('id'=>'pack_space', 'class'=>'inputBox','style'=>"width:40px;", 'size'=>10, 'maxlength'=>2, 'label' => false)); ?>&nbsp;GB</td>
					</tr>

		 			<tr id="tdDefault">
						<td valign="top" width="25%">Default</td>
						<td valign="top">
						<?php
							$noSelected = "checked = 'checked' ";
							$yesSelected = "";
							 
							if(isset($this->request->data['Package']['isdefault']) && $this->request->data['Package']['isdefault'] == 1)
							{
								$yesSelected = "checked = 'checked' ";
								$noSelected = "";
							}
						?>
							<input type="radio" name="isdefault" value="1" <?php echo $yesSelected;?>>Yes
							<input type="radio" name="isdefault" value="0" <?php echo $noSelected;?>>No
						
						</td>
					</tr>


					<tr>
						<td valign="top" align="right"><?php echo $this->Form->submit('Submit'); ?></td>
						<td valign="top" align="left">
				<input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL; ?>admin/manageplans"' name="reset" value="Cancel" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>