<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>signup.js" type="text/javascript"></script>
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
<?php echo $this->Form->create('User', array('action'=>'step1/'.$user_type.'/'.$trialpack,'type' => 'post','id'=>'user')); ?>
<div class="main-signup">
  <?php if($user_type == 1):?>
  <h3>Your site address</h3>
  <p>Site address details, for example http://stpeters.firepaperapp.com<br />
    <strong>Letters &amp; numbers only</strong></p>
  <div class="url">
   <?php echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50', "tabindex"=>1));?> 
    <h3>.firepaperapp.com<span class="mandatory">*</span></h3>
  </div>
  <?php endif;?>
  <h3>Your details</h3>
  <div class="col-left">
    <p>First name<span class="mandatory">*</span></p>
       <?php echo $this->Form->input('firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'50', "tabindex"=>2));?> 
    <br />
    <p>Email<span class="mandatory">*</span></p>
   <?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150', "tabindex"=>4));?> 
    <br />
    <p>Username<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('username',array('div'=>false,'label'=>false,"id"=>"username",'maxlength'=>'150', "tabindex"=>5));?> 
    <br />
    <p>Password<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('password',array('div'=>false,'label'=>false,"id"=>"password",'maxlength'=>'50','value'=>'','type'=>'password',  "tabindex"=>6));?> 
    <br />
    <p>Time Zone<span class="mandatory">*</span></p>
       <?php echo $this->Form->input('timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$defaultTimeZone, "tabindex"=>8));?>
	<br />
	<p> Verification</p>
	<br />
	<p>
		<img src="<?php echo FILES_PATH_URL."captcha/".$captcha_src;?>" alt="captcha" />
	</p>
	  <br /><br />
	<p>I accept terms and conditions<span class="mandatory">*</span></p><br />
 	<p style="text-align:left;"><input type="checkbox" name="data[User][terms]" value="" tabindex="10" id="terms"/></p>
  </div>
  

<div class="col-right">
    <p>Last name<span class="mandatory">*</span></p>
  <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50', "tabindex"=>3));?> 
    <br />
	    <div class="spacer-form"></div>
	    <div class="clr"></div>
    	<div class="tip"><p>This is what you use to sign in</p></div>
   		 <p>Re-type password<span class="mandatory">*</span></p>
   		  <?php echo $this->Form->input('cpassword',array('div'=>false,'label'=>false,"id"=>"cpassword",'maxlength'=>'50','type'=>'password','value'=>'', "tabindex"=>7));?> 
  		  <div class="clr-spacer-form"></div>
   		  <div class="tip"><p>Important for your project dates etc</p></div>
   		  <p>Enter text shown on left<span class="mandatory">*</span></p>
   
   	<?php echo $this->Form->input('sSecurityCode',array('div'=>false,'label'=>false,"id"=>"sSecurityCode",'maxlength'=>'20', "tabindex"=>9));?> 
    </div>
     
     <div class="clr"></div>
     <input type="hidden" name="data[User][user_type_id]" value="<?php echo $user_type?>">
      <input type="hidden" name="data[User][trial]" value="<?php echo $trialpack?>">
     <input name="" type="submit" value="Create Account!" class="submit"/>
</div>
</form>