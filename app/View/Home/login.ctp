<script src="<?php echo JS_PATH?>forgotpassword.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>login_in.js" type="text/javascript"></script>
<form action="<?php echo SITE_HTTP_URL;?>login" method="post" id="login_in">
 	<div class="Rightcontainer"> <!-- Rightcontainer start here -->
 	<div class="Formmessage errorJs" style="display:none;">
		<div class="errordiv"></div>
	</div>
 	<?php
	if(isset($errMsg))
	{?>
	<div class="Formmessage errorServer">
		<div class="errordiv"><?php echo $this->Utility->display_message_li($errMsg); ?></div>
	</div>
	<?php } ?>
	<div class="Box_Schedule"> <!-- Box_Schedule start here -->
    	<h1>Login</h1>
        <div class="Bor_container"><!--Bor_container start here -->
        <div class="Box_Form"> <!-- Box_Form start here -->
        	<div class="FormLeft"> <!-- FormLeft start here -->
            	<fieldset>                    
                        <label>Email Address(Username)<span>*</span></label>
                        <span class="inputtext">
                        <?php echo $this->Form->input('vUsername',array('div'=>false,'label'=>false,'id'=>'vUsernameIn'));?>
                        </span>
						<div class="clr"></div> 
                        <label>Password<span>*</span></label>
                        <span class="inputtext">
                        	<?php echo $this->Form->input('vPasswordIn',array('div'=>false,'type'=>'password','label'=>false,'id'=>'vPasswordIn'));?>
                        </span>
                </fieldset>
                <div class="clr">&nbsp;</div>
            </div> <!-- FormLeft end here -->
            	
        	
			
									
								
        </div> <!-- Box_Form end here -->
      
    <div class="clr"></div>
    </div><!-- Bor_container end here -->
    <div class="bor_Bot"></div>
    </div> <!-- Box_Schedule end here -->
 <span class="formButtonWrapperBluebg right_button" style="margin-top:5px;">
 			<?php echo $this->Form->input('login_in',array('div'=>false,'type'=>'hidden','label'=>false,'id'=>'login_in','value'=>'yes'));?>
 			<input type="submit" title="Submit" alt="Submit" value="Submit" class="formButtonBluebg" name="frmAdd"/>
									</span>   
</div> <!-- Rightcontainer end here -->
 </form>	
