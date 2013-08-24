<table  cellspacing="1" cellpadding="4" border="0" width="65%" align="center" style="background:none repeat scroll 0 0 #FFFFFF;">

	<tr >
		<td >
			<h2>By <?php echo Sanitize::html(ucfirst($paymentrec[0]['User']['firstname']." ".$paymentrec[0]['User']['lastname']))?></h2>
		</td>
	</tr>

	<tr class="displayhead">
		<td class="txt-center">Date</td>
		<td class="txt-center">Profile ID</td>
		<td class="txt-center">Amount Paid</td>
	</tr>

	<?php 
		$i=0;
		foreach($paymentrec as $payment)
		{ 
			if($i%2==0)
			{
				$class="display1";
			}
			else
			{
				$class="display2";
			}
			$i++;
	?>
			<tr class="<?php echo $class; ?>">
				<td><?php echo $payment['Payment']['created'] ; ?></td>
				<td><?php echo $payment['Payment']['transaction_id'] ; ?></td>
				<td>$<?php echo $payment['Payment']['amount'] ; ?></td>
			</tr>
	<?php	
		}
	?>
			<br>
			<tr>
				<td colspan="3"><input type="button" onclick='javascript:window.location="<?php echo SITE_HTTP_URL; ?>admin/viewReport"' name="reset" value="Back" /></td>		
			</tr>

			
</table>
<br>