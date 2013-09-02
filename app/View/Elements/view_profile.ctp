<script src="<?php echo JS_PATH ?>jquery.jeditable.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH ?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH ?>profile.js" type="text/javascript"></script>
<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!-- File Upload Progress bar -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script> 
<!-- File Upload Progress bar End -->
<script type="text/javascript">
	$(document).ready(function(){
                $("#deluser").fancybox({
			ajax : {
			type	: "GET",
			}
		});
   	 });
</script>


<?php
if(is_file(USER_IMAGES_URL.'100X100/'.$userdata['User']['profilepic']) && file_exists(USER_IMAGES_URL.'100X100/'.$userdata['User']['profilepic']))
{
	$userimage = USER_IMAGES_PATH.'100X100/'.$userdata['User']['profilepic'];
}
else
{
	$userimage = IMAGES_PATH.'profile-pic.png';
}
?>

<input type="hidden" id="emailupdt" value="<?php echo MSG_EMAIL_UPDATED?>">
<input type="hidden" id="errmail" value="<?php echo ERR_SAME_EMAIL_EXIST?>">
<input type="hidden" id="emailval" value="<?php echo $userdata['User']['email']?>">
<input type="hidden" id="userid" value="<?php if(!empty($userid)) {echo $userid;}?>" >
<input type="hidden" id="maxlimit" value="<?php echo MAX_TEXT_LIMIT;?>">
<input type="hidden" id="urluid" value="<?php echo $url_uid;?>">

<!--<div style="float:right;cursor:pointer;"><a onclick="javascript:history.go(-1)">Back</a></div>-->
    <div class="index white page">
        <h1>Profile Details</h1> 
    	
        <div class="profile-container">
            <div class="profile-details-wrapper"> <table id="files1"></table>   
                <div class="profile-large">                   
                    <img id="imgid" alt="" height="100" width="100" src="<?php echo $userimage;?>" /><br />			
                     <?php if ($showedit == 'Y') {?>
                        <span id="status" ></span>
                        <form action="<?php echo SITE_HTTP_URL;?>users/updateImage/<?php echo $userdata['User']['id'];?>" method="POST" enctype="multipart/form-data" >
		    				 <input type="file"  name="uploadfile" />   	 
		    				 <button>Upload</button>
		   					 <div>Edit</div> 
						</form>                    	 
                    <?php } ?><br><br>  
                </div>
                <ul id="files" ></ul>
                <div class="info">
                         <div id="successcontainer" class="success" style="display:none;"></div>
    			         <div class="validation-signup" id="validation-container" style="display:none;" ></div>
	
                    <p>
                        <span class="title">Name:</span>
                        <div id="name" style="width:200px;"><?php echo trim(ucfirst(Sanitize::html($userdata['User']['firstname'] . " " .$userdata['User']['lastname'])));?></div>
                         <?php if ($showedit == 'Y' && $userdata['User']['status'] == 1) { ?>
                                <a href="javascript:void(0);" class="edit" id="editnamelink" >Edit</a>
                        <?php } ?>
                    </p>
					<?php if(isset($rec['classgroupStudent']['group_id']))
					{?>
                    <p><span class="title">Class:</span> 
                    	<?php
                    	foreach($groups as $rec)
                    	{?>
                    		<a href="<?php echo SITE_HTTP_URL?>yeargroups/classGroups/<?php echo $rec['classgroupStudent']['group_id'];?>" class="underline-link"><?php echo $rec['classGroup']['title'];?></a>&nbsp
						<?php
                    	}?>
                    </p>
					<?php
					}?>
 					<p>
                     <span class="title">About me:</span><br />
                    <div id="aboutme" style="word-wrap: break-word;"><?php echo trim(ucfirst(Sanitize::html($userdata['User']['aboutme'])));?></div>
                        <?php if ($showedit == 'Y'  && $userdata['User']['status'] == 1) {?>
                        <a href="javascript:void(0);" class="edit" id="editabtmelink">Edit</a>
                        <?php } ?>
                   </ p>
					<p id="textlimit" style="display:none;"><b>Maximum characters can be <?php echo MAX_TEXT_LIMIT;?></b></p>

                    <p id="hiddenemail" style="display:none;"> <?php echo Sanitize::html($userdata['User']['email']); ?></p>

			 <div id="emailboxloader" style="display:none;"></div>
                    <?php if ($showedit == 'Y'  && $userdata['User']['status'] == 1) {?>
                    <p class="width100per">
                        <a  class="edit" id="editemaillink">Change email address</a></p>
						 <?php echo $this->Form->create('User', array('type' => 'post','id'=>'emailform')); ?>
						
					   <div id="emailbox" style="display:none;">
						Email : <?php echo  $this->Form->input('email',array('label'=> false,'maxlength'=>'150','value'=>'','id'=>'email')); ?>
                      
                       <p style="float:left"><?php echo  $this->Form->submit('Ok',array('label'=> false, 'div'=>false))?><?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'cancelemail','div'=>false))?></p>
                           
						</div>
						</form>
                        
                    </p><p class="width100per"><a  class="edit" id="editpwdlink">Change password</a>
						<?php echo $this->Form->create('User', array('type' => 'post','id'=>'pwdform')); ?>
                    <div id="pwdbox" style="display:none;">

                       Old Password : <?php echo  $this->Form->input('oldpassword',array('label'=> false,'maxlength'=>'50','value'=>'','id'=>'oldpassword','type'=>'password')); ?>

					   New Password : <?php echo  $this->Form->input('password',array('label'=> false,'maxlength'=>'50','value'=>'','id'=>'password')); ?>

                       Confirm Password : <?php echo  $this->Form->input('cpassword',array('label'=> false,'maxlength'=>'50','value'=>'', 'type'=>'password','id'=>'cpassword'))?>

                       <p><?php echo  $this->Form->submit('Ok',array('label'=> false, 'div'=>false))?><?php echo  $this->Form->button('Cancel',array('label'=> false,'id'=>'cancelpwd', 'div'=>false))?></p>
                           
                    </div>
                    </form>
					<?php }?>
     

					<?php if($showlinks=='Y' ){ ?>
					 
 							<p style="cursor:pointer;">
							<a class='edit' id="deluser" href="<?php echo SITE_HTTP_URL?>users/deleteAccount/">
							Delete Account</a></p>

							<?php if($createdbyarr['User']['status']==1) {?>
							<p id="suspend" ><a class='edit' style="cursor:pointer;" onclick="suspendActivateAccount(<?php echo $createdbyarr['User']['id'];?>,'S');" >Suspend Account</a></p>

							<?php } if($createdbyarr['User']['status']==2) {?>

							<p id="suspend"><a class='edit' style="cursor:pointer;" onclick="suspendActivateAccount(<?php echo $createdbyarr['User']['id'];?>,'A');" >Activate Account</a></p>
						<?	} 
						}
					?>
					<?php
					if($userdata['User']['user_type_id'] == 4 || $userdata['User']['user_type_id'] == 5)
					{?>
						<p class="width100per"><a class='edit' href="<?php echo SITE_HTTP_URL?>users/viewProgress/<?php echo $userdata['User']['id'];?>">View Progress Report</a></p>
					<?php
					}
					?>
                </div>
            </div>
            <div class="clr"></div>
        </div> 
    </div>
    <div id="backgroundPopup"></div>
<div class="clr"></div>