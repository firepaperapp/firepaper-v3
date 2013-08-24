<script>
function confirmdelete()
{
	var conf = confirm("Are you sure to delete the plan");
	if(conf==true)
	{
		return true;
	}
	if(conf==false)
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


<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
	<tbody>
	<tr>
  	  <td>
  	  <strong><?php // $this->Session->flash();?></strong>
	   <table width="100%" cellspacing="0" cellpadding="5" border="0" align="center">
		 <tbody>	  	   
			<tr style="background:#44A2A2;color:#FFFFFF;">
				<td valign="top"><b>Package Name</b></td>
				<td valign="top"><b>Amount</b></td>
				<td valign="top"><b>Duration</b></td>
				<td valign="top"><b>UserType</b></td>
				<td valign="top"><b>Action</b></td>
			</tr>
			<?php 
				if(count($arPackages) > 0) 
				{
					$i=1;
					foreach($arPackages AS $pack)
					{
			?>
			<tr>
				<td valign="top"><a href="<?php echo SITE_HTTP_URL; ?>admin/viewPlan/<?php echo $pack['Package']['id']; ?>" > <?php echo Sanitize::html($pack['Package']['name']); ?></a></td>

				<td valign="top"><?php 
				if($pack['Package']['amount'] == 0)
					echo "Free";
				else
					echo "$".Sanitize::html($pack['Package']['amount']); 
				?></td>
				<td valign="top"><?php echo Sanitize::html(ucFirst($pack['Package']['package_type']))." Package"; ?>&nbsp;  </td>

				<td valign="top"><?php echo Sanitize::html($pack['Usertype']['title']); ?></td>

				<?php //if($pack['Package']['countpackages'] == 0 ) 
				{ ?>
				<td valign="top"><a href="<?php echo SITE_HTTP_URL; ?>admin/addeditPackage/<?php echo $pack['Package']['id']; ?>"><img src="<?php echo IMAGES_PATH ?>edit-admin.png" border="0" title="Edit" /></a>&nbsp; 

				<a onclick="return confirmdelete();" href="<?php echo SITE_HTTP_URL; ?>admin/deletePackage/<?php echo $pack['Package']['id']; ?>"><img src="<?php echo IMAGES_PATH ?>delete-admin.gif" border="0" title="Delete" /></a></td>

				<?php } ?>
				
			</tr>
			<?php
				
					}
				}
				else
				{
				?>
					<tr><td><?php echo  ERR_RECORD_NOT_FOUND; ?></td></tr>
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