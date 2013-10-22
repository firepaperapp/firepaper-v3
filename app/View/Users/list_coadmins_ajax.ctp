<script>
function confirmCoadminDelete(uid)
{
	var conf = confirm("Are you sure ,you want to delete record !")	;
	if(conf==true)
	{
		$('#coadminloader').empty().html(loader).show();
		$.post(siteUrl+'users/deleteAccount/'+uid, '',function(data){ 
		$('#coadminloader').hide();
		var dataArr = data.split("@");
		alert($.trim(dataArr[1]));

		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
		loadPiece(siteUrl+"users/listCoadminsAjax/?rand="+randomnumber,"#content_coadmin");

		});
		
	}
}
</script>

<div id="coadminloader" style="display:none;"></div>
<?php 

if(is_array($data) && count($data)>0)
{
	foreach($data as $coadmins)
	{
?>
<!--	<div class="file-doc-container"  class="ui-state-default" id="main_<?php echo $coadmins['User']['id'];?>">
				  <div class="doc-icon"><img src="<?php echo $coadmins['User']['profilepic'];?>" /></div>
					<div class="file-name">
						<a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $coadmins['User']['id']?>" id="tool-tip"><?php echo Sanitize::html($coadmins['User']['firstname']." ".$coadmins['User']['lastname']);?></a> <em></em> 
						
					</div>
					<a href="#<?php //echo SITE_HTTP_URL?>files/confirmDeletion/<?php //echo $rec['userFile']['id'];?>/" class="btn deleteFile">Delete</a>
				  <div class="clr"></div>
	</div>-->

<?php } ?>



<div class="row">
	 <?php 
		$i = 0;
	 	foreach($data as $coadmins)
		{ 
		 	if($i%3==0 && $i!=0)
			{
			?>
			<div class="clr"></div>
</div>
			<div class="row">
			<div class="user-box-left">		 			
			 <?php 
			 }
			 else 
			 {
				if($i==0)
				{	?>
					<div class="user-box-left">
				<?php
				}
				else 
				{	?>
					<div class="user-box">	
				<?php 
				}
			 }
			?>
		 	     	
					<div class="imgclass"><img src="<?php echo $coadmins['User']['profilepic'];?>" class="profile" /></div>

			  					<div class="links">
						<p class="title"><a id="edituserprof" href="<?php echo SITE_HTTP_URL."users/viewProfile/".$coadmins['User']['id']; ?>"><b><?php echo ucfirst(Sanitize::html($coadmins['User']['firstname']." ".$coadmins['User']['lastname']));?></b></a>
						</p>
						
						<p><a onclick="confirmCoadminDelete(<?php echo $coadmins['User']['id'];?>);" class="edit">Delete </a></p>

                        <?php //if($showlinks=='Y'){ ?>
				<!--			<p><a onclick="confirmDelete(<?php //echo $teachers['User']['id'];?>);" href="#">Delete Account</a></p>

							<?php //if($teachers['User']['status']==1) {?>
							<p id="suspend<?php echo $k;?>" ><a onclick="suspendActivateAccount(<?php //echo $teachers['User']['id'];?>,'S',<?php //echo $k;?>);" href="#">Suspend Account</a></p>

							<?php //} if($teachers['User']['status']==2) {?>

							<p id="suspend<?php echo $k;?>"><a onclick="suspendActivateAccount(<?php //echo $teachers['User']['id'];?>,'A',<?php // echo $k;?>);" href="#">Activate Account</a></p>
						<?	//} 
						//}
						?>-->
		
						

						
			        </div>
					<div class="clr"></div>
			    </div>  
		<?php
		
	     $i++;		 
	     
		 }?>
		 <div class="clr"></div>
     </div>
<?php }
	else 
	{
		echo '<p>'.ERR_RECORD_NOT_FOUND.'</p>';
	}
?>
<?php 
$this->Paginator->options(array('url' => $this->passedArgs));
echo $this->element("pagination/ajax_pagination");?>
 <div class="clr"></div>