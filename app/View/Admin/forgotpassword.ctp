<script language="Javascript">
	$(document).ready(function() {
		$('#adminFrm').validate();
	});
</script>
<table  border="0" cellpadding="0" cellspacing="0" width="100%" >
<tr>
	<td>
		<div id="main" class="bgE2F3FA">
		<form name="adminFrm" action="" method="post" id="adminFrm">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
		  <tbody>
			<tr>
				<td><?php echo $this->element("common/admin_breadcrumb",$breadcrumbs); ?></td>
			</tr>
			<tr>
			  <td height="20">&nbsp;</td>		
			</tr>
			<tr>
			  <td align="center">
					<table cellpadding="0" cellspacing="5" border="0" width="600" class="registerTable">
						<tr>
							<td colspan="2"> <?php if(isset($errMsg)) { ?>
									 <div class="cffffff err" style="text-align:center;"><strong><?php echo $this->Utility->display_message($errMsg,'error',1);	?></strong></div>
								 <?php } ?>
 							</td>
						</tr>				
						<tr>
							<td valign="top">Enter your username:</td>
							<td valign="top"><?php echo $this->Form->input( 'Admin.username', array('id'=>'username', 'class'=>'inputBox required', 'maxlength'=>20, 'label' => false) ); ?></td>
						</tr>
						<tr>
							<td valign="top"></td>
							<td valign="top"><?php echo $this->Form->submit('Submit'); ?></td>
						</tr>
					</table>
			  </td>		
			</tr>
			<tr>
			  <td height="20">&nbsp;</td>		
			</tr>
		 </tbody>
		</table>
		</form>
		</div>
	</td>
</tr>
</table>