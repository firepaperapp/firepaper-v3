<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table cellpadding="0" cellspacing="5" border="0" width="600" >
					<tr>
						<td valign="top" width="25%">Username:</td>
						<td valign="top" width="75%"><?php echo Sanitize::html($userdata['User']['username']);?></td>
					</tr>
					
					<tr>
						<td valign="top">User Type:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['userTypes']['title']);?></td>
					</tr>
					<tr>
						<td valign="top">First Name:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['firstname']);?></td>
					</tr>
					<tr>
						<td valign="top">Last Name:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['lastname']);?></td>
					</tr>
					<tr>
						<td valign="top">Email Address:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['email']);?></td>
					</tr>
			<!--		<tr>
						<td valign="top">Address:</td>
						<td valign="top"><?php echo $this->Form->textarea( 'User.address', array('id'=>'address', 'class'=>'addressBox required', 'label' => false)); ?></td>
					</tr>-->

					<tr>
						<td valign="top">Address:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['addrsline1']);?><br>
										 <?php echo Sanitize::html($userdata['User']['addrsline2']);?>
						</td>
					</tr>

	<!--				<tr>
						<td valign="top">Address Line2:</td>
						<td valign="top"><?php echo $this->Form->input( 'User.addrsline2', array('id'=>'addrsline2', 'class'=>'inputBox required', 'maxlength'=>50, 'label' => false, 'value'=>$userdata['User']['addrsline1'])) ?></td>
					</tr>

					<tr>
						<td valign="top">Date of Birth:</td>
						<td valign="top"><?php //echo $this->Form->text( 'User.dob', array('id'=>'dob', 'class'=>'inputBox2', 'maxlength'=>50, 'label' => false)); ?><span style="width:25px;margin-top:5px;"><a href="javascript:void(0);" onclick="displayDatePicker('data[User][dob]','cal');"><img src="<?php //echo SITE_URL; ?>images/calbtn.gif" id="cal" style="border:0;"/></a></span><br /><b>mm/dd/yyyy</b></td>
					</tr>-->

			<!--		<tr>
						<td valign="top">Phone:</td>
						<td valign="top"><?php //echo $this->Form->input( 'User.phone', array('id'=>'phone', 'class'=>'inputBox required', 'maxlength'=>50, 'label' => false)); ?></td>
					</tr>-->

					<tr>
						<td valign="top">City:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['city']);?></td>
					</tr>
					<tr>
						<td valign="top">States:</td>
						<td valign="top"><?php echo Sanitize::html($userstate);?></td>
					</tr>
					<tr>
						<td valign="top">Country:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['country']);?></td>
					</tr>
					<tr>
						<td valign="top">Zip Code:</td>
						<td valign="top"><?php echo Sanitize::html($userdata['User']['zipcode']); ?></td>
					</tr>
					<?php
					$used = 0;
					if(!isNull($userdata['User']['totalspace']))
					{
						if($userdata['User']['usedspace']>0)
						{
							$used = round(($userdata['User']['usedspace']/$userdata['User']['totalspace'])*100,2);?>
							<tr>
						<td valign="top">Used Space:</td>
						<td valign="top"><?php echo $used."%"; ?></td>
					</tr>
					<?php
						}
					}
					?>
					<tr>
						<td valign="top" align="right"></td>
						<td valign="top">
						<input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL; ?>admin/<?php echo $referer; ?>"' name="reset" value="Back" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>