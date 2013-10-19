<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>login.js" type="text/javascript"></script>
<div class="header-signin">
  <div class="logo">
	  
  </div>
</div>
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<form action="<?php echo SITE_HTTP_URL;?>login" method="post" id="login">
<div class="main-signin">  
<h3>Sign into your account</h3>
<br />
<input type="text" <?php if(!$this->request->data){?> onfocus="if(this.value =='Username' ) this.value=''" onblur="if(this.value=='') this.value='Username'"  value="<?php echo $userCookieval;?>" <?php }else if ($this->request->data['username']=='') {?> value="<?php echo 'Username'; } else { echo $this->request->data['username']; } ?>" id="username" name="data[username]">
    
    
     <input type="password" <?php if(!$this->request->data){?>onfocus="if(this.value =='123456789' ) this.value=''" onblur="if(this.value=='') this.value='123456789'" value="<?php echo $passCookieval;?>" <?php }else {?> value="<?php echo $this->request->data['password'];?>" <?php }?> id="vPasswordLeft" name="data[password]">
      
     
    <div class="clr"></div>
     <input name="" type="submit" value="Sign in" class="submit"/>
     <div class="tick-box">
     <input name="remember_me" type="checkbox" value="1" <?php if((isset($_POST['remember_me']) && $_POST['remember_me']==1) || $remember_me==true){ echo 'checked = "checked"'; }?>/><label for="remember-me">Remember me on this computer</label>
    </div>
</div>
<div class="footer-signin"><a href="<?php echo SITE_HTTP_URL;?>forgotpassword" title="I forgot my password">I forgot my password</a></div>
</form>