<script language="Javascript">
	$(document).ready(function() {
		$('#adminFrm').validate();
		
	});
	function resetForm(id) {
	$("#cpassword").val("");
	$("#newpassword").val("");
	$("#newconfirmpassword").val("");
}
</script>
<form name="adminFrm" action="" method="post" id="adminFrm">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" height="300">
	<tbody>
		<tr>
			<td valign="top" align="left" style="padding: 0pt 0pt 0pt 15px;">
				<table cellpadding="0" cellspacing="5" border="0" width="600" class="registerTable">
					<tr>
						<td valign="top" colspan="2"><strong><?php $this->Session->flash();?></strong></td>
					</tr>
					<tr>
						<td valign="top" colspan="2"><?php echo $this->Utility->display_message($errMsg,'errmsg',1); ?></td>
					</tr>
					<tr>
						<td valign="top" width="30%">Current Password:</td>
						<td valign="top" width="70%"><?php echo $this->Form->password( 'Admin.cpassword', array('id'=>'cpassword', 'class'=>'inputBox required', 'maxlength'=>20, 'label' => false)); ?></td>
					</tr>
					<tr>
						<td valign="top">New Password:</td>
						<td valign="top" align="left"><?php echo $this->Form->password( 'Admin.newpassword', array('id'=>'newpassword', 'class'=>'inputBox required', 'maxlength'=>20, 'label' => false)); ?></td>
					</tr>
					<tr>					
						<td valign="top">Confirm New Password:</td>
						<td valign="top" align="left"><?php echo $this->Form->password( 'Admin.newconfirmpassword', array('id'=>'newconfirmpassword', 'class'=>'inputBox required', 'maxlength'=>20, 'label' => false)); ?></td>
					</tr>
					<tr>
						<td valign="top"></td>
						<td valign="top">
							<input type="submit" class="button-admin" value="Submit" name="submit">
							<input type="button" class="button-admin" value="Reset" name="reset" onclick="resetForm('adminFrm');">
						</td>
					</tr>
					
				</table>
			</td>		
		</tr>
	</tbody>
</table>
</form>