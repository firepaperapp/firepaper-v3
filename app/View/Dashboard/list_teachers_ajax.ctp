<script type="text/javascript">
function confirmDelete(uid)
{
	var conf = confirm("Are you sure ,you want to delete record !")	;
	if(conf==true)
	{
		$.post(siteUrl+'dashboard/deleteAccount/'+uid, '',function(data){
		$("#msgbox").hide();
	
		loadPiece(siteUrl+"dashboard/listTeachersAjax/"+$('#departmentId').val()+"/","#content_teachers");

		});
		
	}
}
function suspendActivateAccount(uid,su_ac,suspendid)
{
	//suspendid = suspend p tag id no.
	
	if(su_ac=='S')
	{
		var confmsg= "suspend";
	}

	if(su_ac=='A')
	{
		var confmsg= "activate";
	}

	var conf = confirm("Are you sure ,you want to " + confmsg + " account!");
	if(conf==true)
	{
		$.post(siteUrl+'dashboard/suspendActivateAccount/'+uid+'/'+su_ac+'/'+suspendid,'',function(data){ 
		var dataarr = data.split("@"); 
		//var suspend
		$("#suspend"+dataarr[1]).html(dataarr[0]);
		$("#msgbox").show();
		$("#msgbox").html(dataarr[2]);
		
		});
	}
}
</script>
<?php
   $i = 0;  	
   $usertype= $this->Session->read('user_type');		
   if(is_array($data) && count($data)>0)
   {?>
   	<div id="msgbox"  class="success" style="display:none;"></div>
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
 	<div class="row">
	   	 <?php $k=1;
	 	 foreach($data as $teachers)
		 { 
		 		if($i%3==0 && $i!=0)
		 		{
		 		?>
					
      			  </div>
	       		 <div class="row">
	       		 <div class="user-box-wrapper">
					<div class="user-box-left">		 			
		   <?php }
		   		 else 
		   		 {
		   		 	if($i==0)
		   		 	{?>
		   		 	<div class="user-box-wrapper">
		   		 		<div class="user-box-left">
		   		 	<?php 
		   		 	}
		   		 	else {
		   		 	?>
		   		 	<div class="user-box-wrapper">
		   		 		<div class="user-box">	
		   		 	<?php 
		   		 	}
		   		 }
		   		?>
	 				<img src="<?php echo $teachers['User']['profilepic'];?>"  />

			       <?php $editpgurl = SITE_HTTP_URL."users/viewProfile/".$teachers['User']['id'];?>

					<div class="links">
						<p class="title"><a id="edituserprof" href="<?php echo $editpgurl; ?>"><strong><?php echo ucfirst(Sanitize::html($teachers['User']['firstname']." ".$teachers['User']['lastname']));?></strong></a>
						</p>
	 					<p>
	 					<?php
	 					$subjects = "";
	 					if(isset($teacherSubjects[$teachers['User']['id']]['subjects']))
	 					{
	 						foreach($teacherSubjects[$teachers['User']['id']]['subjects'] as $sub)
	 						{
	 						 	$subjects.=$sub['Subject']['title'].", ";
	 						}
	 						$subjects = substr($subjects, 0, -2);
	 					}
	 					?>
	 					 <?php echo $subjects;?></p>
						<a href="<?php echo $editpgurl; ?>" class="edit">View info</a>				
			        </div>
					
			    </div>  
			  </div> 
		<?php
		$k++;	
	     $i++;		 
	     
		 }?>
		 <div class="clr"></div>
     </div>
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