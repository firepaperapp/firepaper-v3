<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function()
	  {
	  	$(".changeMembership").fancybox({				 
			ajax : {
			type	: "GET"
			}
		});
   	  
    	}
    );
   
</script>
<script>
function checkme()
{ 
	if($('#status').val()=="" && $('#username').val()=="")
	{
		alert("Please select user type or enter user name");
		return false;
	}
	if($.trim($('#username').val()) !='')
	{
		var rex =/^[A-Z a-z0-9_.\' @&*!~,-]+$/;
		if(!rex.test($.trim($('#username').val())))
		{
			alert("Only  & * @  ! ~ ' ,  special characters are allowed.");
			return false;
		}
	}
}
function confirmdelete()
{
	var conf = confirm("Are you sure to delete the user?");
	if(conf==true)
	{
		return true;
	}
	if(conf==false)
	{
		return false;
	}
}
function updatePck(pkg, uid, usrType)
{
	var msg = "Are you sure you want to update the package?";
	if("undefined" != typeof(usrType))
	{
		msg = "Do you really want to change user's account type and membership plan?";	
	}
	if(confirm(msg))

	{
		window.location = siteUrl+"admin/changeMembership/"+uid+"/"+pkg;

	}
	else
	{
		return false;
	}
}
</script>
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

<form name="searchFrm" id="searchFrm" onsubmit="return checkme();" action="<?php echo SITE_HTTP_URL ?>admin/manageusers/search" method="POST">
<table border="0" align="left" width="30%" >
	<tr>
		<td colspan="2" style="border:0px;"><b>Search</b></td>
	</tr>
	<tr>
		<td style="border:0px;">User Type</td>
		<td style="border:0px;">			
			<?php 
				foreach($userTypes as $key=>$val){
					$options[$val['UserType']['id']] = $val['UserType']['title'];
				}
			    echo $this->Form->input('User.status',array('type'=>'select','div'=>false,'label'=>false,'options'=>$options,'id'=>"status",'value'=>$statustype, 'empty'=>'--Select Type--'));?>
		</td>
	</tr>
	<tr>
		<td style="border:0px;">User Name</td>
		<td style="border:0px;"><?php echo $this->Form->text( 'User.username', array('id'=>'username', 'value'=>$username, 'class'=>'inputBox required', 'label' => false)); ?></td>
	</tr>
	<tr>
		<td valign="top" style="border:0px;"></td>
		<td valign="top" style="border:0px;">
			<input type="submit" class="button-admin" value="Submit" name="submit">
			<input type="button" onclick="javascript:window.location='<?php echo SITE_HTTP_URL?>admin/resetSearch'" class="button-admin" value="Reset" name="reset">
		</td>
	</tr>
</table>
</form>
<br/>
<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
	<tbody>
	<tr>
  	  <td>
  	  <strong><?php $this->Session->flash();?></strong>
	   <table width="100%" cellspacing="0" cellpadding="5" border="0" align="center">
		 <tbody>	  	   
			<tr style="background:#44A2A2;color:#FFFFFF;">
				<td valign="top"><b>Username</b></td>
				<td valign="top"><b>Full Name</b></td>
				<td valign="top"><b>Type</b></td>
				<td valign="top"><b>Email Address</b></td>
				<td valign="top"><b>Action</b></td>
			</tr>
			<?php 
				if(count($arUsers) > 0) {
					$i=1;
					foreach($arUsers AS $user) {
			?>
			<tr>
				<td valign="top"><a href="<?php echo SITE_HTTP_URL;?>admin/ViewProfile/<?php echo $user['User']['id']; ?>/MU"><?php echo Sanitize::html($user['User']['username']); ?></a></td>
				<td valign="top"><?php echo Sanitize::html($user['User']['firstname']." ".$user['User']['lastname']); ?></td>
				<td valign="top"><?php echo Sanitize::html($user['Usertype']['title']); ?></td>
				<td valign="top"><a href="mailto:<?php echo $user['User']['email']; ?>" title="Email to <?php echo $user['User']['email']; ?>"><?php echo $user['User']['email']; ?></td>
				<td valign="top"> 
					<?php if($user['User']['status']==1){?>
					<a href="<?php echo SITE_HTTP_URL; ?>admin/userstatus/<?php echo $user['User']['id']; ?>/2"><img src="<?php echo IMAGES_PATH ?>active.png" border="0" title="Suspend User" /></a>&nbsp;
					<?php if(in_array($user['User']['user_type_id'], array(1, 3, 5))){?>
					 <a style="color:red;" href="<?php echo SITE_HTTP_URL?>admin/changeMembership/<?php echo $user['User']['id'];?>" class="changeMembership"><img src="<?php echo IMAGES_PATH ?>coins.png" border="0" title="Update Plan" /></a>		  
					<?php }?>
					
					<?php }elseif($user['User']['status']==2){ ?>
					<a href="<?php echo SITE_HTTP_URL; ?>admin/userstatus/<?php echo $user['User']['id']; ?>/1"><img src="<?php echo IMAGES_PATH ?>deactive.png" alt="deactive" border="0" title="Activate User" /></a>&nbsp;
					<?php }?>
					<a href="<?php echo SITE_HTTP_URL; ?>admin/addedituser/<?php echo $user['User']['id']; ?>"><img src="<?php echo IMAGES_PATH ?>edit-admin.png" border="0" title="Edit" /></a>&nbsp;
					<a onclick="return confirmdelete();" href="<?php echo SITE_HTTP_URL; ?>admin/userstatus/<?php echo $user['User']['id']?>/3"><img src="<?php echo IMAGES_PATH ?>delete-admin.gif" border="0" title="Delete" /></a>
				</td>
			</tr>
			<?php
					$i++;
					}
				}
				else {?>
			<tr><td><?php echo ERR_RECORD_NOT_FOUND; ?></td></tr>
		<?php }	?>
			<tr>
				<td valign="top" colspan="6"><?php echo $this->element('pagination/pagination');?></td>
			</tr>
		  </tbody>
		</table>
   	 </td>		
   </tr>
 </tbody>
</table>
</form>