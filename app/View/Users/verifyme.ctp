<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>signup.js" type="text/javascript"></script>
<div class="header-signup">
  <h1><span>Verify</span>Account</h1>
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
<?php 
	
	$user_data=$user_data[0];

echo $this->Form->create('User', array('action'=>'verifyme/'.$user_data["User"]["unique_key"]."/".$user_data["User"]["email"],'type' => 'post','id'=>'user')); ?>
<div class="main-signup">
 
  <h3>Are Your Details correct?</h3>
  <div class="col-left">

    <p>First name<span class="mandatory">*</span></p>
       <?php echo $this->Form->input('firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'50', "tabindex"=>2,"value"=>$user_data["User"]["firstname"]));?> 
	   
    <br />
    <p>Email<span class="mandatory">*</span></p>
   <?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150', "tabindex"=>4,"value"=>$user_data["User"]["email"]));?> 
    <br />
	 
  <h3>Login Details</h3>
  <br/>
    <p>Username<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('username',array('div'=>false,'label'=>false,"id"=>"username",'maxlength'=>'150', "tabindex"=>5));?> 
    <br />
    <p>Password<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('password',array('div'=>false,'label'=>false,"id"=>"password",'maxlength'=>'50','value'=>'','type'=>'password',  "tabindex"=>6));?> 
    <br />
 <br />
	<p>I accept terms and conditions<span class="mandatory">*</span></p>
 	<p style="text-align:left;"><input type="checkbox" name="data[User][terms]" value="" tabindex="10" id="terms"/></p>
  </div>
  

<div class="col-right">
    <p>Last name<span class="mandatory">*</span></p>
  <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50', "tabindex"=>3,"value"=>$user_data["User"]["lastname"]));?> 
    <br />   <br />   <br />   <br />
	    <div class="spacer-form"></div>
	    <div class="clr"></div>
    	<div class="tip"><p>This is what you use to sign in</p></div>
   		 <p>Re-type password<span class="mandatory">*</span></p>
   		  <?php echo $this->Form->input('cpassword',array('div'=>false,'label'=>false,"id"=>"cpassword",'maxlength'=>'50','type'=>'password','value'=>'', "tabindex"=>7));?> 
  		 
   
    </div>
     
     <div class="clr"></div>
   
     <input name="" type="submit" value="VerifyMe" class="submit"/>
</div>
</form>