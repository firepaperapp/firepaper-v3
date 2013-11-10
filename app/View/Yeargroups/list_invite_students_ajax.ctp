<script>

function confirmdel(uid, userType, studntID)
{
	//studntID = used for hiding g. name p tag  after deleting gaurdian
	//uid= userid to be deleted;

	if(userType=='S')
	{
			var msgg = 'Are you sure, you want to delete this student from your invite list';
 	}

	var conf = confirm(msgg);
	if(conf==true)
	{
		$("#loaderbox").empty().html(loader).show();

		if(userType=='S')
		{			
			$.post(siteUrl+'yeargroups/deleteStudentInvite/'+uid,function(data){
					
					$("#loaderbox").empty().hide();
	 				window.location= siteUrl+"yeargroups/viewgroups";
			});
		}

				
	}
}
</script>

<!--<div class="clr-spacer"></div>-->
<?php
$i = 0;
$f = "$('#addStudentToGroup').trigger('click')";	
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
<?php } ?>
<div id="loaderbox" style="display:none;"></div>
<div class="row">
   	 <?php $k=1; $j=0;
 	 foreach($data as $students)
	 {// pr($students); exit;
	 		if($i%3==0 && $i!=0)
	 		{
	 		?>
			<!--	<div class="clr"></div>-->
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
	   		?><div class="imgclass"><img src="<?php echo $students['User']['profilepic'];?>" class="profile" /></div>
		       <?php $editpgurl = SITE_HTTP_URL."users/viewProfile/".$students['User']['id'];?>
				<div class="links">
					<p class="title"><a id="edituserprof" href="<?php echo $editpgurl; ?>"><b><?php echo ucfirst(Sanitize::html($students['User']['firstname']." ".$students['User']['lastname']));?></b></a>
					</p>
 					<?php
					
					if($students['User']["status"]==0)
					{
						echo "<p style='font-size:12px'>Status:Pending</p>";
					}
					else
					{
						echo "<p>Status: Connected</p>";
					}
					
				?>
<p><a id="studdel" class="edit deleteGroup" onclick="return  confirmdel(<?php echo $students['User']['id'];?>,'S','');"> Delete Student</a></p>
			
					
		        </div><div class="clr"></div>
		        <?php
		        	if(isset($students['groups']))
					{
						echo 'Groups<br/>';
						foreach($students['groups'] as $recGroup)
						{
							echo '<a href="'.SITE_HTTP_URL."yeargroups/viewgroups/".$recGroup['classGroupParent']['id'].'" class="edit">'.$recGroup['classGroupParent']['title'].'</a> > ';
							echo '<a href="'.SITE_HTTP_URL."yeargroups/classGroups/".$recGroup['classGroup']['id'].'" class="edit">'.$recGroup['classGroup']['title'].'</a><br/>';
							 
	 					}
					}
		        ?>
				<div class="clr"></div>
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
	echo '<p style="margin-top:10px;">';
	if(!isset($searched))
	{
		echo '<p style="margin-top:10px;" class="width100per">'.NO_RESULT.'';
	
	}
 
	else 
	{
		echo "No search results found.";
	}
}
?>
<?php 
$this->Paginator->options(array('url' => $this->passedArgs));
echo $this->element("pagination/ajax_pagination");?>
<div class="clear">&nbsp;</div>
