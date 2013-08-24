<script type="text/javascript">
$(document).ready(function() {
	$("#loginUserForm").validate();
});
</script>
<form action="<?php echo COMMON_URL; ?>/users/login" name="loginUserForm" id="loginUserForm" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="43" class="layout">
	<tr>
		<td colspan="4">
		<div class="fl" style="padding:5px;">
		<?php if(isset($errMsg)) { ?>
		<div class="txt_red" align="center" ><?php echo $this->Utility->display_message($errMsg,'errmsg',1); ?></div>
		<?php } ?>
		<div class="successmsg" align="center" ><strong><?php $this->Session->flash();?></strong></div>
	</tr>
	<tr>
		<td> USER NAME</td>
		<td><?php echo $this->Form->input('User.username',array('id' => 'username','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> password
		</td>
		<td><?php echo $this->Form->password('User.password',array('id' => 'password','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td valign="top"></td>
		<td valign="top"><input type="submit"  name="data[User][cmdSubmit]" class="button" value="Login"/></td>
	</tr>
</table>
</form>