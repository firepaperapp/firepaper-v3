<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.ui.core.js"></script>

<script>
$(document).ready(function(){ 

$("#startdate").datepicker({
				showOn: 'button',
				buttonImage: siteImagesUrl +'calendar.png',
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd',
			//	minDate: new Date(),
				buttonImageOnly: true
		});

$("#enddate").datepicker({
		showOn: 'button',
		buttonImage: siteImagesUrl+'calendar.png',
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		changeYear: true,
	//	minDate: new Date(),
		buttonImageOnly: true
});

});

function checkform()
{
	if($("#startdate").val()=="" && $("#enddate").val()=="" )
	{
		alert("Please select date");
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

function loadMyRec(recDate, fromRec, toRec)
	{	
		if($('#cont_'+recDate).attr('innerHTML')=='') 
		{
			$.ajax({
			   type: "POST",
			   url: siteUrl+"admin/reportsDetail",
			   data: {"date":recDate , "uname" : $("#uname").val(), "startdate":fromRec, "enddate":toRec},
			   success: function(msg){
			      $('#cont_'+recDate).empty().html(msg);
			      $('#cont_'+recDate).slideDown(1000);
			   }
			 });			
		}
		else 
		{	
			$('#cont_'+recDate).slideToggle(1033);
		}
	}
</script>


<form name="viewreportfrm" action="" method="post" id="viewreportfrm" onsubmit="return checkform();">
<input type="hidden" id="uname" name="uname" value="<?php echo $uname; ?>">
<table width="65%" cellspacing="0" cellpadding="5" border="0" align="center" height="100" 
style="border: 1px solid #ABD8D8; ">
	<tr>
		<td colspan="4"><strong>Search</strong></td>
	</tr>
	
	<tr>
		<td>Date From </td>

		<td><?php echo $this->Form->input('startdate',array('id'=>'startdate','div'=>false,'label'=>false, 'readonly'=>'true','style'=>'width:190px','value'=>$sDateFrom));?></td>

		<td>Date To  </td>

		<td><?php echo $this->Form->input('enddate',array('id'=>'enddate', 'value'=>$sDateTo, 'div'=>false,'label'=>false, 'readonly'=>'true','style'=>'width:190px'));?></td>
		
	</tr>

	<tr>
		<td>Name : </td>
		<td colspan="3"><?php echo $this->Form->input('username',array('id'=>'username','div'=>false,'label'=>false, 'style'=>'width:190px'));?></td>
	</tr>

	<tr>
		<td colspan="4"><input type="submit" name="submit" value="Submit"></td>
	</tr>

</table>
</form>

<br>
<!--<table id="tablelist" cellspacing="1" cellpadding="4" border="0" width="65%">-->
<table  cellspacing="1" cellpadding="4" border="0" width="65%" align="center" style="background:none repeat scroll 0 0 #FFFFFF;">
<?php
if($data){
if($fomrPosted==0)
{?>

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
		$link = SITE_HTTP_URL."admin/ViewProfile/".$rec['User']['id']."/VR";
		$ahref = "<a href='$link'>";

		$currMonth = $rec[0]['datePay'];
		if($currMonth!=$preMonth)
		{
			if($row!=1)
				echo "<tr><td class='' colspan='4' align='right'>Total Revenue: $".number_format($ttlRevenue,2)."</td></tr>";
			echo '<tr class="header"><td colspan="4" align="left"><b>'.date("M Y",strtotime($currMonth.'-01')).'</b></td></tr>';
			$preMonth = $currMonth;	
			$ttlRevenue = "";
		}
		$cssClass=($row%2)?'1':'2';
		print '
				<tr class="display'.$cssClass.'">
					<td width="20%">'.$ahref.' '.ucfirst(Sanitize::html(strtolower($rec['User']['firstname'].' '.$rec['User']['lastname']))).'</td>
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
				echo "<tr><td class='' colspan='4' align='right'>Total Revenue: $".number_format($ttlRevenue,2)."</td></tr>";
		}?>
 	
<?
}
else {
	
	//we will get months in between
	if(count($data)>0 && isset($data[0][0]['datePay']))	
	{
		$sDateFrom = $sDateFrom!=""?$sDateFrom:0;
		$sDateTo = $sDateTo!=""?$sDateTo:0;
		?>
		 
		<?php 
		foreach($data as $rec)	 
		{	
			$xl = explode("-",$rec[0]['datePay']);
			$stMonth = date("F",strtotime($rec[0]['datePay']."-01"));
			?>
			<tr><td>
			<div>
				<p style="float:left"><b><span style="cursor:pointer;font-size:13px;" onclick='loadMyRec("<?php echo $rec[0]['datePay'];?>", "<?php echo $sDateFrom;?>", "<?php echo $sDateTo;?>" );'>+&nbsp;<?php echo $stMonth;?> <?php echo $xl[0];?></span>
					
				</p>
				<p style="float:right;font-size:13px;">$<?php echo $rec[0]['totalSale']?>&nbsp;<!--(<?php echo $rec[0]['cnt']?> Orders)--></p>
			</div>
			<div id="cont_<?php echo  $rec[0]['datePay'];?>" style="display:none;width:100%;float:left;"></div></td>
			</tr>
		<?}?>
	 
	<?}
	else 
		echo "<tr><td>No Record Found</td></tr>";
}
}
else 
		echo "<tr><td>No Record Found</td></tr>";
?>
</table>
<br>