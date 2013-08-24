<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" height="300">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table cellpadding="0" cellspacing="5" border="0" width="600" >
					<tr>
						<td valign="top" width="25%">Name:</td>
						<td valign="top" width="75%"><?php echo Sanitize::html($packageRec['Package']['name']);?></td>
					</tr>
					
					<tr>
						<td valign="top">Amount:</td>
						<td valign="top">$<?php echo Sanitize::html($packageRec['Package']['amount']);?></td>
					</tr>
					<tr>
						<td valign="top">Duration:</td>
						<td valign="top"><?php echo Sanitize::html($packageRec['Package']['duration']);?>&nbsp;Month(s)</td>
					</tr>
					<tr>
						<td valign="top">Space:</td>
						<td valign="top"><?php 
						if($packageRec['Package']['space'] == 0 )
						echo "Unlimited";
						else
						echo Sanitize::html($packageRec['Package']['space'])."&nbsp;GB";?></td>
					</tr>
					<tr>
						<td valign="top">UserType:</td>
						<td valign="top"><?php echo Sanitize::html($packageRec['Usertype']['title']);?></td>
					</tr>
					
					<tr>
						<td valign="top" align="right"></td>
						<td valign="top">
				<input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL?>admin/manageplans"' name="reset" value="Back" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>