<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>login.js" type="text/javascript"></script>
<div class="header-signin">
  <div class="logo">
	  
  </div>
</div>
<?php
if($this->Session->check('Message.flash'))
{?>
	<div class="essage errorServer" style="width:400px;margin:0 auto;margin-bottom:10px;">
		<div class="success" style="margin-left:20px;">
			<?php
			echo	$this->Session->flash(); // this line displays our flash messages
			?>
		</div>
	</div>
<?php } ?>
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<form action="<?php echo SITE_HTTP_URL;?>forgotpassword" method="post" id="forgotpassword">
<div class="main-signin">  
<h3>Forgot Password</h3>
<br />
 	<p>Email address</p>
    <?php echo $this->Form->input('email',array('div'=>false,'label'=>false,"id"=>"email",'maxlength'=>'150'));?> 
    <div class="clr"></div>
    <input name="" type="submit" value="Submit" class="sign-in"/> or <a href="<?php echo SITE_HTTP_URL;?>login">Login</a>
    
  </div>
</form>