<table id="tablelist" cellspacing="1" cellpadding="4" border="0" width="100%">
  		<tr class="displayhead">
			<td width="40%" class="txt-center">User</td>
			<td width="40%" class="txt-center">Amount Paid</td>
			<td width="20%" class="txt-center"></td>
		</tr>
 		<?php
		$row=1;
		$preMonth = "";
		$ttlRevenue = "";
		foreach($data as $rec){
 		$cssClass=($row%2)?'1':'2';
		$link = SITE_HTTP_URL."admin/ViewProfile/".$rec['User']['id'].'/VR';
		$ahref = "<a href='$link'>"; 
		print '
				<tr class="display'.$cssClass.'">
					<td width="20%">'.$ahref.' '.ucfirst(Sanitize::html(strtolower($rec['User']['firstname'].' '.$rec['User']['lastname']))).'</a></td>
					<td width="20%">$'.$rec[0]['totalSale'].'</td>';
		?>
					<td width="15%">
					<a href="<?php echo SITE_HTTP_URL;?>admin/viewPayments/<?php echo $rec['User']['id']; ?>">View Payments</a>
					</td>	
				</tr>
		<?php 
		$ttlRevenue = $ttlRevenue+$rec[0]['totalSale'];
		$row++;	
		if($row==count($data)+1)
				echo "<tr><td class='' colspan='3' align='right'>Total Revenue: $".number_format($ttlRevenue,2)."</td></tr>";
		}?>
 </table>