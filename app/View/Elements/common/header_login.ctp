<script type="text/javascript">
$(document).ready(function() {
	$("#loginUserForm").validate();
});
</script>
<div id="Header_Container">

        <div class="Nav_Container"><!--Top Navigation Container Start Here-->
        	<div class="Logo"><a href="#"><img height="97" width="149" alt="" src="<?php echo IMAGE_PATH;?>logo.png"></a></div>
            <div class="Navigation">
            	<ul>
                	<li><a class="active" href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">What we do</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div><!--Top Navigation Container Start Here-->

        <div id="Login_Container">
        	<div class="Slogan"><!--Slogan Container Start Here-->
   	    	  <img height="106" width="484" alt="" src="<?php echo IMAGE_PATH;?>Slogan.png">
           	  <p>In today's digital-focused world, traditional products and delivery channels are not good enough to satisfy end user's requirement. IDS provides customized and technology driven services for publishing, digitization and content data conversion to help the clients redefine value of their content.</p>
              <p>Every day, IDS works closely with clients to deliver more intelligent and interactive digital content through state-of-the-art strategic publishing and content conversion processes that help deliver products to markets faster, cheaper and easier.</p>
              <span style="text-align: right; padding: 10px 20px 0pt 0pt; display: block;"><a href="#"><img style="padding: 0px;" alt="" src="<?php echo IMAGE_PATH;?>read_more_btn.gif"></a></span>
            </div><!--Slogan Container End Here-->


					<?php if(isset($errMsg)) {
					echo $this->Utility->display_message($errMsg,'error',1); }
					?>
					<div class="successmsg" align="center" ><strong><?php $this->Session->flash();?></strong></div>


<form action="<?php echo COMMON_URL; ?>home/login" name="loginUserForm" id="loginUserForm" method="post" >
            <div class="Login">
              <table width="300" cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                <tr>
                  <td height="37" class="font21" colspan="2">User Login</td>
                </tr>
                <tr>
                  <td height="47" valign="bottom" colspan="2">Username</td>
                </tr>
                <tr>
                  <td height="49" valign="top" colspan="2">
                  <?php echo $this->Form->input('User.username',array('id' => 'username','label' => false,'style'=>"width: 295px;",'class' => 'textBox required','div' => '','MAXLENGTH'=>'30'));?>
                 <!-- <input type="text" style="width: 295px;" id="textfield" class="textBox" name="textfield">-->
                 </td>
                </tr>
                <tr>
                  <td colspan="2">Password</td>
                </tr>
                <tr>
                  <td height="49" valign="top" colspan="2">
                  <?php echo $this->Form->password('User.password',array('id' => 'password','label' => false,'style'=>"width: 295px;",'class' => 'textBox required','div' => '','MAXLENGTH'=>'30'));?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><a href="#">Forgot Password / Login ID?</a></td>
                </tr>
                <tr>
                  <td height="36" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="37" width="65"><input type="image" height="20" width="56" alt="" src="<?php echo IMAGE_PATH;?>login_btn.gif" name ="data[cmdSubmit]" ></td>
                  <td width="235">&nbsp;</td>
                </tr>
              </tbody></table>
</form>
            </div>
        </div>

    </div>
    <div class="clr"></div>