<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>style.css" />
<table style="width: 570px; margin-bottom: 20px; margin-top:20px;" class="f12 lmb" id="plan_table">
  
  
<tbody>
<tr>
 	<th class="c" align="center"><strong>Institute</strong></th>
	<th class="c" align="center"><strong>Educator</strong></th>
	<th class="c" align="center"><strong>Strudent</strong></th>			
</tr>
<tr class="plan_item">
 <?php
	$previuos = "";
	$current = "";
	$newpack = array();
	$i = 0;
	foreach($packages as $rec)
	{
		$newpack[$rec['Package']['user_type_id']][] = $rec['Package']; 
		$i++;
	}
 	foreach($newpack as $key=>$rec)
	{	
		 
		$cc = "";
	 	if($key == $userdata['User']['user_type_id'])
		{
			$cc = "current_plan";
		}
		?>
 		<td valign="top" class="c <?php echo $cc;?>">
			<table cellpadding="0" cellpadding="0" width="100%">
			<?php							
				foreach($rec as $packagList)
				{?>
					<tr><td valign="top">
						<?php
						echo $packagList['name']."<br/>";
							if($packagList['space'] == 0)
								echo "Unlimited ";
							else 
								echo $packagList['space']."GB";?><br> <em>($<?php echo $packagList['amount'];?>)</em>
						<?php	
						if($packagList['id'] == $userdata['User']['package_id'])
						{?>
							<a href="javascript:void(0);" class="r delete">User's Plan</a>
						<?php
						}
						else {
							?>
							<br />
							<?php
							if( ($userdata['Package']['space'] <= $packagList['space']  || $packagList['unlimited']==1) && $packagList['amount']>0)
							{
								if($key == $userdata['User']['user_type_id'])
								{
									if($userdata['Package']['amount'] < $packagList['amount'])
									{?>
										<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>, <?php echo $userdata['User']['id'];?>);">Upgrade</a>
									<?php
									}
									else 
									{?>
										<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>, <?php echo $userdata['User']['id'];?>);">Downgrade</a>
									<?php
									}
								}
								else 
								{?>
									<a href="javascript:void(0);" class="r delete" onclick="updatePck(<?php echo $packagList['id'];?>, <?php echo $userdata['User']['id'];?>, <?php echo $key;?>);">Change Type</a>
								<?php
								}
							}
							else 
							{
								echo '<p style="margin-top:1px;">&nbsp;</p>';
							}
						}
						?>	
					</td></tr>
				<?php
				}
			?>
			</table>
		</td>	
	<?php
	}
?>
</tr>
</table>