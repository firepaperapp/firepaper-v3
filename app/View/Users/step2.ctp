<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>signup.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.datepicker.js"></script>

<div class="header-signup">
  <h1><span>Sign</span>Up</h1>
</div>
<!-- end header -->
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<?php echo $this->Form->create('User', array('action'=>'step2','type' => 'post','id'=>'step2')); ?>
<div class="main-signup">
  <h3>Package and Billing details</h3>
 <?php
   
  		if($this->Session->read("registerUserData.trial") == 1)
  		{
  			echo "<h4>You will not be charged this month and from the next month your monthly package wil be following.</h4>";
  		}
    	if(isset($pkg['Package']['name']))
    	{?>
    		<h3>&nbsp;&nbsp;Package: <?php echo $pkg['Package']['name']?>, $<?php echo $pkg['Package']['amount']?> with interval of <?php echo $pkg['Package']['duration'];?> days</h3>
    	<?php
		}
		echo "<small>You can cancel your subscription at any time.</small>";
    	?>
   <div class="clr"></div>
  <div class="col-left">
  	<p>Account Details</p><br/>
    <p>Card Type<span class="mandatory">*</span></p>
      <?php echo $this->Form->input('cardtype',array('type'=>'select','div'=>false,'label'=>false,'options'=>$cardTypes,'id'=>'cardtype'));?>
    <br />
    <p>Name On Card<span class="mandatory">*</span></p>
   	<?php echo $this->Form->input('nameoncard',array('id'=>'nameoncard','div'=>false,'label'=>false,'maxlength'=>'50'));?>
    <br />
    <p>Card Number<span class="mandatory">*</span></p>
   	<?php echo $this->Form->input('cardnumber',array('id'=>'cardnumber','div'=>false,'label'=>false,'maxlength'=>'20'));?>
    <br />
    <p>Expiration Date<span class="mandatory">*</span></p>
     <span>
     <?php echo $this->Form->input('expiredate',array('id'=>'expiredate','div'=>false,'label'=>false, 'readonly'=>'true','style'=>'width:190px'));?></span>
    <br />
    <p>CCV Code<span class="mandatory">*</span></p>
      	<?php echo $this->Form->input('ccvcode',array('id'=>'ccvcode','div'=>false,'label'=>false,'maxlength'=>'3'));?>
	 
	 
	<br />
	 
  </div>
  

<div class="col-right">
	<p>Billing Details</p><br/>
    <p>Address Line 1<span class="mandatory">*</span></p>
 <?php echo $this->Form->text('addrsline1',array('id'=>'addrsline1','div'=>false,'label'=>false,'maxlength'=>150));?>
   <p>Address Line 2<span class="mandatory"></span></p>
 <?php echo $this->Form->text('addrsline2',array('div'=>false,'label'=>false,'maxlength'=>'150'));?>
  <p>Country<span class="mandatory">*</span></p>
  <?php echo $this->Form->input('country',array('type'=>'select','div'=>false,'label'=>false,'options'=>$countries,'id'=>"country"));?> 
  
   <p>State<span class="mandatory">*</span></p>
 	<span id="state_dropdown" style="display:<?php echo $displayDropDown;?>;">
   <?php echo $this->Form->input('vStateD',array('id'=>'vStateD','type'=>'select','div'=>false,'label'=>false,'options'=>$states));?>
   </span>
   <span id="state_text" style="display:<?php echo $displayText;?>;">
   <?php echo $this->Form->input('vStateT',array('id'=>'vStateT','div'=>false,'label'=>false, 'maxlength'=>'50'));?>
   </span>
   <?php echo $this->Form->input('vState',array('id'=>'vState','div'=>false,'label'=>false,'type'=>'hidden'));?>
   
   <p>City<span class="mandatory">*</span></p>
 <?php echo $this->Form->input('city',array('id'=>'city','div'=>false,'label'=>false,'maxlength'=>'50'));?>
  
   
   <p>Zip Code<span class="mandatory">*</span></p>
 	<?php echo $this->Form->input('zipcode',array('id'=>'zipcode','div'=>false,'label'=>false,'maxlength'=>'5'));?> 
  
     </div>
      <div class="clr"></div>
      <input name="" type="submit" value="Subscribe" class="submit"/>
</div>
</form>