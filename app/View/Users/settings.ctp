<script src="<?php echo JS_PATH ?>jquery.jeditable.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH ?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!-- File Upload Progress bar -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script> 
<!-- File Upload Progress bar End -->
<script type="text/javascript" src="<?php echo JS_PATH ?>settings.js"></script> 
<?php 
if(is_file(USER_IMAGES_URL.'logo/'.$userdata['User']['logopic']) && file_exists(USER_IMAGES_URL.'logo/'.$userdata['User']['logopic']))
{
	$userimage = USER_IMAGES_PATH.'logo/'.$userdata['User']['logopic'];
}
else
{
	$userimage = IMAGES_PATH.'default_logo.jpg';
}
?>
<input type="hidden" id="urluid" value="<?php echo $currentuserid; ?>">
<input type="hidden" id="uniquename" value="<?php echo $userdata['User']['username']?>">
<input type="hidden" id="sitetitle" value="<?php echo $userdata['User']['sitetitle']?>">
<input type="hidden" id="emailval" value="<?php echo $userdata['User']['email']?>">

    <div class="index page white">
	<?php
	if($this->Session->check('Message.flash'))
	{?>
		<div class="essage errorServer">
			<div class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
	?>
    <div class="account-settings-wrapper" id="dd" style="visibility:false;">
    	<h3>Account Settings</h3>
 			 <div id="successcontainer" class="success" style="display:none;"></div>
             <div class="validation-signup" id="validation-container" style="display:none;" ></div>
			 <div id="emailboxloader" style="display:none;"></div> 
                <h3>Name:</h3>
					<div id="name" style="width:200px;">
					<?php echo trim(ucfirst(Sanitize::html($userdata['User']['firstname'] . " " . $userdata['User']['lastname'])));?></div>
					<a href="javascript:void(0);" class="edit" id="editnamelink" >Edit</a>
				
				<br />

                <input type="hidden" id="hiddenemail" style="display:none;" value="<?php echo Sanitize::html($userdata['User']['email']); ?>">

				<p class="width100per">
					<h3>Email:</h3>
					<div id="emailcontent" style="width:300px;"><?php echo trim(Sanitize::html($userdata['User']['email']));?></div>
					<a href="javascript:void(0);" class="edit" id="editemaillink">Edit</a>
				</p>
				
				<?php echo $this->Form->create('User', array('type' => 'post','id'=>'emailform')); ?>
						
			   <div id="emailbox" style="display:none;">
				Email : <?php echo  $this->Form->input('email',array('label'=> false,'maxlength'=>'150','value'=>$userdata['User']['email'], 'id'=>'email' )); ?>			  
			   <?php echo  $this->Form->submit('Ok',array('label'=> false,'class'=>'submit',"div"=>false))?>
			   <?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'cancelemail',"div"=>false))?>
				   
				</div>
				</form>
				<br />
                <h3>Time Zone:</h3>
                <a id="savetimezone" class="edit">Save</a>
				
				<?php echo $this->Form->input('timezone',array('type'=>'select','div'=>false,'label'=>false,'options'=>$timezones,'id'=>"DropDownTimezone",'value'=>$userdata['User']['timezone']));?>	

               <br />
				
				<p class="width100per"><a href="javascript:void(0);" id="editpwdlink" class="edit">Change password</a></p>

				<?php echo $this->Form->create('User', array('type' => 'post','id'=>'pwdform')); ?>
				<div id="pwdbox" style="display:none;margin-bottom:10px;">

				   Old Password : <?php echo  $this->Form->input('oldpassword',array('label'=> false,'maxlength'=>'50','value'=>'','id'=>'oldpassword','type'=>'password')); ?>

				   New Password : <?php echo  $this->Form->input('password',array('label'=> false,'maxlength'=>'50','value'=>'','id'=>'password')); ?>

				   Confirm Password : <?php echo  $this->Form->input('cpassword',array('label'=> false,'maxlength'=>'50','value'=>'', 'type'=>'password','id'=>'cpassword'))?>

				   <p style="float:left;margin-top:10px;"><?php echo  $this->Form->submit('Ok',array('label'=> false,"div"=>false))?><?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'cancelpwd'))?></p>
					   
				</div>
                </form>
         		 <br />
                 
        <div class="rule"></div>
        
               
                <!--<h4>Your Logo</h4>
                <br />
				<img id="imgid" src="<?php echo $userimage;?>" /><br />
				
			     <table id="files1"></table>  
					<form id="editimglink" action="<?php echo SITE_HTTP_URL;?>users/updateLogoImage" method="POST" enctype="multipart/form-data" class="marginT10">
			    		 <input type="file" id="uploadfile" name="uploadfile" />   	 
			    		 <button>Upload</button>
			   			 <div>Upload files</div> 
					</form>  
				
				<br />
                <br />-->
				<span id="status" ></span>

               <!-- <h3>Username:</h3> 
					<div id="usernamediv" style="width:200px;"><?php echo trim(Sanitize::html($userdata['User']['username']));?></div>
					<a  class="edit" id="editusernamelink">Edit</a>
				</p>

				<?php echo $this->Form->create('User', array('type' => 'post','id'=>'usernameform')); ?>
		
			   <div id="usernamebox" style="display:none;">
			   <?php echo  $this->Form->input('username',array('label'=> false,'maxlength'=>'150','value'=>$userdata['User']['username'], 'id'=>'username' )); ?>			  
			   <span style="float:left"><?php echo  $this->Form->submit('Ok',array('label'=> false,"div"=>false))?></span><?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'cancelusername',"div"=>false))?>
				   
				</div>-->
				</form>
				<div style="display:none">
				<!--<br /> 
                <h3>Company URL on firepaperapp:</h3>

					<input id="companyurl" name="companyurl" type="text" value="<?php echo $userdata['User']['sitetitle']?>"/>
					<em>.firepaperapp.com</em>

					<a id="edit_companyurl_link" class="edit">Save</a>	
				</div>			
				</p>-->
			
                <h3>Country:</h3><a id="editcountrylink" class="edit">Save</a>
				</p> 
                <?php echo $this->Form->input('country',array('type'=>'select','div'=>false,'label'=>false,'options'=>$countries,'id'=>"DropDownCountry",'value'=>$userdata['User']['country']));?>
<div style="display:none">
<div class="rule"></div>
<h3>Manage your subscription</h3>

<h3>Your plan:<span class="red"> <?php echo $userdata['Package']['name']?></span></h3>
			<?php
			if($userdata['Package']['unlimited'] == 0)
			{?>
			<em>Amount of space used:</em>
            <div class="indicator-holder">
              <div class="indicator-bg">
				<?php
				$used = 0;
				if(!isNull($userdata['User']['totalspace']))
				{
					if($userdata['User']['usedspace']>0)
					{
						$used = round(($userdata['User']['usedspace']/$userdata['User']['totalspace'])*100,2);
					}
				}?>
                <div class="indicator-bar" style="width:<?php echo $used;?>%">&nbsp;<?php echo $used;?>%</div>
              </div><!-- end indicator-bg -->
            </div><!-- end indicator-holder -->
		<?php
			} 
			?>
            <table style="width: 470px; margin-bottom: 20px; margin-top:20px;" class="f12 lmb" id="plan_table">
	<tbody>
	<tr>
	 	<th class="c" align="center"><strong>Institute</strong></th>
		<th class="c" align="center"><strong>Educator</strong></th>
		<th class="c" align="center"><strong>Strudent</strong></th>			
	</tr>
	<tr class="plan_item">
	 <?php
		$previuos = "";
		$current = "";
		$newpack = array();
		$i = 0;
		foreach($packages as $rec)
		{
			$newpack[$rec['Package']['user_type_id']][] = $rec['Package']; 
			$i++;
		}
	 	foreach($newpack as $key=>$rec)
		{	
			 
			$cc = "";
		 	if($key == $userdata['User']['user_type_id'])
			{
				$cc = "current_plan";
			}
			?>
	 		<td valign="top" class="c <?php echo $cc;?>">
				<table cellpadding="0" cellpadding="0" width="100%">
				<?php							
					foreach($rec as $packagList)
					{?>
						<tr><td valign="top">
							<?php 
							echo $packagList['name']."<br/>";
							if($packagList['space'] == 0)
								echo "Unlimited ";
							else 
								echo $packagList['space']."GB";?><br> <em>($<?php echo $packagList['amount'];?>)</em>
							<?php	
						 	if($packagList['id'] == $userdata['User']['package_id'])
							{?>
								<a href="javascript:void(0);" class="r delete">Your Plan</a>
							<?php
							}
							else {
								?>
								<br />
								<?php
								if(($userdata['Package']['space'] <= $packagList['space'] || $packagList['unlimited']==1) && $packagList['amount']>0)
								{	 
									if($key == $userdata['User']['user_type_id'])
									{
										if($userdata['Package']['amount'] < $packagList['amount'])
										{?>
											<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>);">Upgrade</a>
										<?php
										}
										else 
										{?>
											<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>);">Downgrade</a>
										<?php
										}
									}
									else 
									{?>
										<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>, <?php echo $key;?>);">Change Type</a>
									<?php
									}
								}
								else 
								{
									echo '<p style="margin-top:1px;">&nbsp;</p>';
								}
							}
							?>	
						</td></tr>
					<?php
					}
				?>
				</table>
			</td>	
		<?php
		}
	?>
	</tr>
</table>
 
</div>
<div class="rule"></div>
<h3>Other</h3>
		<?php if($userdata['User']['status']==1) {?>
		<p id="suspend" ><a class="edit" style="cursor:pointer;" onclick="suspendActivateAccount(<?php echo $userdata['User']['id'];?>,'S');" >Suspend Account</a></p>

		<?php } if($userdata['User']['status']==2) {?>

		<p id="suspend"><a  class="edit" style="cursor:pointer;" onclick="suspendActivateAccount(<?php echo $userdata['User']['id'];?>,'A');" >Activate Account</a></p>
	<?php 	} ?>

<p><em>Your account will be held for 3 months before it auto deletes</em></p><br />

	<p style="cursor:pointer;">
		<a class="edit" id="deluser" href="<?php echo SITE_HTTP_URL?>users/deleteAccount/0/setting">Delete Account</a>
		<em>This cannot be undone</em>
	</p>
</div>
</div>
<div id="backgroundPopup"></div>

