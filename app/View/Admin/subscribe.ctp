<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.core.js"></script>
<script>
$(document).ready(function(){
	 
	document.testChange = 0;
	if($("#expiredate").length!=0)
	{
		//Both of thease funcations belongs to signup step2	
		$("#expiredate").datepicker({
				showOn: 'button',
				buttonImage: siteImagesUrl+'calendar.png',
				changeMonth: true,
				changeYear: true,
				minDate: new Date(),
				buttonImageOnly: true
		});
		
	 	$("#country").change(function() {
		  var valCountry = $(this).val();
		   if( valCountry != "United States"){
		  	document.getElementById("state_dropdown").style.display = "none";
		  	document.getElementById("state_text").style.display = "inline-block";
		  	$("#vStateT").rules("add", {required: true, messages:{required:""}});
		  	$("#vStateD").rules("remove");
	
		  }
		  else{
		  	document.getElementById("state_dropdown").style.display = "inline-block";
		  	document.getElementById("state_text").style.display = "none";
		  	$("#vStateD").rules("add", {required: true, messages:{required:""}});
		  	$("#vStateT").rules("remove");
		  	
		  }
		});
			
	}
	$("#subscribeFrm").validate({

		  errorClass: "error1",
		   errorElement: "p",
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
	            if(document.getElementById("state_dropdown").style.display != "none"){
	            	var getState = $("#vStateD").val();
	            	$("#vState").val(getState);
	            }
	            else{
	            	var getState = $("#vStateT").val();
	            	$("#vState").val(getState);
	            }
	            form.submit();
	        },
	 	   rules: {   		   
			 "data[nameoncard]":  {required: true},	
			 "data[cardnumber]":  {required: true, creditcard: true},	 
			 "data[expiredate]":  {required: true},
	  	     "data[addrsline1]":  {required: true},	 	   
	 		 "data[country]":  {required: true},
	 	     "data[city]":  {required: true},
	 	     "data[zipcode]":  {required: true,minlength:4, number:true},	 	 
	 	     "data[ccvcode]":  {required: true}
	 		   },
		   messages: 
		   {
		   	  "data[nameoncard]": {
	 	     	required: "Please enter name on card."	 	     	
	 	     },
		 	 	 	    
	 	      "data[cardnumber]": {
	 	     	required: "Please enter card number"	 	     	
	 	     },
	 	     "data[expiredate]":  {
	 	     	required: "Please enter card expiry date."	 	     	
	 	     },
			 "data[addrsline1]":  {
			 	required: "Please enter address."
			 },
			 "data[country]":  {
	 	     required: "Please select country."	 	     
	 	     },
			 "data[city]": {
	 	     	required: "Please enter city."	 	     	
	 	     },
	 	      "data[zipcode]":  {
	 	     	required: "Please enter zip code",
	 	     	number: "Please enter number only"	     	
	 	     },
	 	     "data[ccvcode]":  {
	 	     	required: "Please enter CCV code."	 	     	
	 	     }  
 		   }
		}); 

});
</script>
<div style="margin-left:24%;margin-bottom:10px;">
<h3>Package and Billing details</h3>
<?php 
if($pkg['Package']['package_type'] == "trial")
{
	echo "<h4>User will not be charged this month and from the next month package wil be following.</h4>";
}
if(isset($comingPackage)) 
    	{
    		$pkg = $comingPackage;
    	}
    	 ?>
    		<h3><?php echo $pkg['Package']['name']?> at $<?php echo $pkg['Package']['amount']?>/PM with <?php echo $pkg['Package']['space']?>GB</h3>
    	<?php
		 
		echo "<small>You can cancel your subscription at any time.</small>";
?>
</div>
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
<div id="validation-container" class ="validation-signup" style="border 1px solid red;<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?></div>
<form name="subscribeFrm" action="" method="post" id="subscribeFrm">

<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table cellpadding="0" cellspacing="5" border="0" width="600" class="registerTable">
					<tr >
						<td class="errordiv" id="errordiv" align="center" style="display:none;border:1px solid red;" colspan="2"></td>
					</tr>

					<tr>
						<td colspan="2"><h4>Account Details</h4></td>
					</tr>

					<tr>
						<td valign="top" width="25%">Card Type<span class="mandatory">*</span></td>
						<td valign="top" width="75%"><?php echo $this->Form->input('cardtype',array('type'=>'select','div'=>false,'label'=>false,'options'=>$cardTypes,'id'=>'cardtype'));?></td>
					</tr>

					<tr>
						<td valign="top" width="25%">Name On Card<span class="mandatory">*</span></td>
						<td valign="top" width="75%">	<?php echo $this->Form->input('nameoncard',array('id'=>'nameoncard','div'=>false, 'class'=>'inputBox required', 'label'=>false,'maxlength'=>'50'));?></td>
					</tr>

					<tr>
						<td valign="top">Card Number<span class="mandatory">*</span></td>
						<td valign="top">	<?php echo $this->Form->input('cardnumber',array('id'=>'cardnumber','div'=>false, 'class'=>'inputBox required', 'label'=>false,'maxlength'=>'20'));?></td>
					</tr>

					<tr>
						<td valign="top">Expiration Date<span class="mandatory">*</span></td>
						<td valign="top" style="text-align:left"> <?php echo $this->Form->input('expiredate',array('id'=>'expiredate','class'=>'inputBox', 'div'=>false,'label'=>false, 'readonly'=>'true','style'=>'width:190px'));?></td>
					</tr>

					<tr>
						<td valign="top">CCV Code<span class="mandatory">*</span></td>
						<td valign="top"><?php echo $this->Form->input('ccvcode',array('id'=>'ccvcode', 'class'=>'inputBox required', 'div'=>false,'label'=>false,'maxlength'=>'3'));?></td>
					</tr>


					<tr>
						<td colspan="2"><h4>Billing Details</h4></td>
					</tr>

					<tr>
						<td valign="top">Address Line 1<span class="mandatory">*</span></td>
						<td valign="top"> <?php echo $this->Form->text('addrsline1',array('id'=>'addrsline1','class'=>'inputBox', 'div'=>false,'label'=>false,'maxlength'=>150));?></td>
					</tr>
					<tr>
						<td valign="top">Address Line 2</td>
						<td valign="top"> <?php echo $this->Form->text('addrsline2',array('div'=>false,'class'=>'inputBox', 'label'=>false,'maxlength'=>'150'));?></td>
					</tr>
					<tr>
						<td valign="top">Country<span class="mandatory">*</span></td>
						<td valign="top">		
								<?php echo $this->Form->input('country',array('type'=>'select','div'=>false,'label'=>false, 'options'=>$countries, 'id'=>"country"));?> 
						</td>
					</tr>


					<tr>
						<td valign="top">State<span class="mandatory">*</span></td>
						<td valign="top" id="state_dropdown" style="display:<?php echo $displayDropDown;?>;">
						<?php echo $this->Form->input('vStateD',array('id'=>'vStateD','type'=>'select','div'=>false,'label'=>false,'options'=>$states));?></td>


						 <td valign="top" id="state_text" style="display:<?php echo $displayText;?>;">
						<?php echo $this->Form->input('vStateT',array('id'=>'vStateT','div'=>false,'class'=>'inputBox', 'label'=>false, 'maxlength'=>'50'));?></td>						
					</tr>

		<?php echo $this->Form->input('vState',array('id'=>'vState','div'=>false,'label'=>false,'type'=>'hidden')) ; ?>

				

					<tr>
						<td valign="top">City<span class="mandatory">*</span></td>
						<td valign="top"> <?php echo $this->Form->input('city',array('id'=>'city','class'=>'inputBox required', 'div'=>false,'label'=>false,'maxlength'=>'50'));?>
						</td>
					</tr>

					<tr>
						<td valign="top">Zip Code<span class="mandatory">*</span></td>
						<td valign="top"> <?php echo $this->Form->input('zipcode',array('id'=>'zipcode','div'=>false,'class'=>'inputBox required', 'label'=>false,'maxlength'=>'5'));?>
						</td>
					</tr>
				
					<tr>
						<td valign="top" align="right"><?php echo $this->Form->submit('Submit'); ?></td>
						<td valign="top" align="left">
				<input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL; ?>admin/manageusers"' name="reset" value="Cancel" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>

</form>