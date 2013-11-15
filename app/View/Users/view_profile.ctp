<script src="<?php echo JS_PATH ?>jquery.jeditable.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH ?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH ?>profile.js" type="text/javascript"></script>
<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo JS_PATH; ?>plupload/plupload.full.js"></script>

<?php

$userdata=$userdata2;


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
         
        <h3>Profile Details</h3>
            <div class="profile-details-wrapper">
                <div class="profile-large">                   
                    <img id="imgid" height="100" width="100" src="<?php echo $userimage;?>" alt="" />
                </div>
                <div class="profile-upload">
                    <?php if ($showedit == 'Y') {?>
                    <div id="editphoto">Edit Photo</div><br>
                    <img id="editphotoprogress" src="<?php echo IMAGES_PATH . '/pbar-ani.gif'; ?>">
					
					<script type="text/javascript">
					$(function() {
						// PL Upload using HTML 5, with HTML 4 fallback (for IE < 10)
						// MultiPart must be set to true for $_FILES to be sent to PHP
						// We let PHP handle the maximum file size you can upload
					    var uploader = new plupload.Uploader({
					        runtimes : 'html5,html4',
					        browse_button : 'editphoto',
					        url : '<?php echo SITE_HTTP_URL;?>users/updateImage/<?php echo $userdata['User']['id'];?>',
					        filters : [{ title : 'Image Files', extensions : 'jpeg,jpg,gif,png' }],
					        multipart: true,
					        max_file_count : 1,
					        file_data_name: 'uploadfile'
					    });
					 	
					 	// the uploader must be initialized 
					 	// before we bind the events
					 	uploader.init();
					 	
					    uploader.bind('FilesAdded', function(up, files) {
						    up.start(); // start uploading as soon as the file is chosen
					    });
					 
					    uploader.bind('UploadProgress', function(up, file) {
					    	// increase the progress bar width as the file uploads,
					    	// this only works because the photo is 100px wide
					        $('#editphotoprogress').width(file.percent);
					    });
					 
					    uploader.bind('Error', function(up, err, result) {
				 			try {
					 			var data = $.parseJSON(result.response);
					 			
					 			if (data.error) {
						        	alert(data.error);
						        } else {
						        	alert(result.response);
						        }
					        } catch(e) {
					        	alert(result.response);
					        }
					    });
					 
					    uploader.bind('FileUploaded', function(up, file, result) {
					    	try {
						    	var data = $.parseJSON(result.response);
						    	
						    	if (data.success) {
						    		// replace the current photo with the uploaded one
						        	$('#imgid').attr('src', '<?php echo USER_IMAGES_PATH . '100X100/'; ?>' + data.success);
						        } else if (data.error) {
						        	// display the error message
						        	alert(data.error)
						        } else {
						        	alert(result.response);
						        }
						    } catch(e) {
					        	alert(result.response);
					        }
					    });
					    
					    uploader.bind('UploadComplete', function(up, file, response) {
					    	$('#editphotoprogress').width(0); // hide the progress bar
					    });
					});
					</script>
                    <?php }
					
					
					
					 ?> 
                </div>
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
    <div id="backgroundPopup"></div>
</div><!-- end activity -->
