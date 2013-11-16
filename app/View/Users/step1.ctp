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
   <?php /*echo $this->Form->input('sitetitle',array('div'=>false,'label'=>false,"id"=>"sitetitle",'maxlength'=>'50', "tabindex"=>1));*/?> 
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
     <p>School name</p>
   <?php echo $this->Form->input('school_name',array('div'=>false,'label'=>false,"id"=>"school_name",'maxlength'=>'150', "tabindex"=>4));?> 
   <br />
    <p>Username<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('username',array('div'=>false,'label'=>false,"id"=>"username",'maxlength'=>'150', "tabindex"=>5));?> 
    <br />
    <p>Password<span class="mandatory">*</span></p>
    <?php echo $this->Form->input('password',array('div'=>false,'label'=>false,"id"=>"password",'maxlength'=>'50','value'=>'','type'=>'password',  "tabindex"=>6));?> 
    <br />
    
	
  </div>
  

<div class="col-right">
    <p>Last name<span class="mandatory">*</span></p>
  <?php echo $this->Form->input('lastname',array('div'=>false,'label'=>false,"id"=>"lastname",'maxlength'=>'50', "tabindex"=>3));?> 
    <br />
	    <div class="spacer-form" style="height:187px;"></div>
	    <div class="clr"></div>
    	<div class="tip">This is what you use to sign in</div>
   		 <p>Re-type password<span class="mandatory">*</span></p>
   		  <?php echo $this->Form->input('cpassword',array('div'=>false,'label'=>false,"id"=>"cpassword",'maxlength'=>'50','type'=>'password','value'=>'', "tabindex"=>7));?> 
  		  <div class="clr-spacer-form"></div>
   		  
   		  
   
    </div>
     
     <div class="clr"></div>
     <input type="hidden" name="data[User][user_type_id]" value="<?php echo $user_type?>">
      <input type="hidden" name="data[User][trial]" value="<?php echo $trialpack?>">
     <input name="" type="submit" value="Create Account!" class="submit"/>
</div>
</form>