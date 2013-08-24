<script>
	$("a.addgaurdian").fancybox({				 
	ajax : {
	type	: "GET"
	
	}
	});

function confirmdel(uid, userType, studntID)
{
	//studntID = used for hiding g. name p tag  after deleting gaurdian
	//uid= userid to be deleted;

	if(userType=='S')
	{
			var msgg = 'Are you sure, you want to delete user from  this group?';
 	}
	if(userType=='G')
	{
			var msgg = 'Are you sure, you want to delete gaurdian?';
 	}

	var conf = confirm(msgg);
	if(conf==true)
	{
		$("#loaderbox").empty().html(loader).show();

		if(userType=='S')
		{			
			$.post(siteUrl+'yeargroups/deleteStudentAccount/'+uid+'/'+$("#classgroupid").val(), '',function(data){
					
					$("#loaderbox").empty().hide();
	 				window.location= siteUrl+"yeargroups/classGroups/"+$("#classgroupid").val();
			});
		}

		if(userType=='G')
		{
				$.post(siteUrl+'yeargroups/deleteUser/guardian', {'uid':studntID},function(data){
				
					$("#loaderbox").empty().hide();
					var dataArr = data.split("##");
					if($.trim(dataArr[0])=="success")
					{
						alert(dataArr[1]);
						var gaurdContainerId = "#gname_"+studntID;
						var addgaurdID = "#addgaurdian_"+studntID;
						$(addgaurdID).show();
						$(gaurdContainerId).hide();
					}
				});
		}			
	}
}
</script>
<?php 
if($classgroupid != 0)
{
echo $this->requestAction("/yeargroups/breadCrumb/$classgroupid");
}
?>
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
				<div class="user-box-left">		 			
	   <?php }
	   		 else 
	   		 {
	   		 	if($i==0)
	   		 	{?>
	   		 		<div class="user-box-left">
	   		 	<?php 
	   		 	}
	   		 	else {
	   		 	?>
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
					if(!empty($students['userGaurdian']['GID']))
					{
						$grd_id= "gname_".$students['User']['id'];
						$vwprflink = SITE_HTTP_URL."users/viewProfile/".$students['userGaurdian']['GID'];
						echo "<p id='$grd_id'><a href=$vwprflink>".ucfirst(Sanitize::html($students['userGaurdian']['Gfirstname']." ".$students['userGaurdian']['Glastname']))."</a><br/>" ;
				 
						$href= SITE_HTTP_URL."yeargroups/deleteGaurdian/".$students['userGaurdian']['GID'] ;
						?>
			 			<a class="edit deleteGroup" style="cursor:pointer" onclick="return confirmdel(<?php echo $students['userGaurdian']['GID']; ?>,'G',<?php echo $students['User']['id'];?>)" >Delete Guardian </a>							
						</p>
						<p>
						<a style="display:none;" class="addgaurdian" href="<?php echo SITE_HTTP_URL?>yeargroups/assignGuardian/<?php echo $students['User']['id'];?>" id="addgaurdian_<?php echo $students['User']['id'];?>" >Add Guardian</a>
						
						<!-- <a style="display:none;" class="addgaurdian" href="<?php echo SITE_HTTP_URL?>yeargroups/newUser/<?php echo $students['User']['id'];?>" id="addgaurdian_<?php echo $students['User']['id'];?>" >Add Gaurdian</a>--></p>
					<?php 
					} else{	

					$grd_id= "gname_".$students['User']['id'];
					?>
					
					<p id="<?php echo $grd_id;?>" style="display:none;"></p>

					<p><a class="addgaurdian"  href="<?php echo SITE_HTTP_URL?>yeargroups/assignGuardian/<?php echo $students['User']['id'];?>" id="addgaurdian_<?php echo $students['User']['id'];?>" >Add Guardian</a></p>

					<?php }					
					$dispalylink = "N";
				 	if( (isset($classgp['classGroup']['admin_id']) && $this->Session->read("userid") == $classgp['classGroup']['admin_id']) || $this->Session->read("userid") == $students['classgroupStudent']['added_by'] || $this->Session->read("user_type") == 1)
					{
						$dispalylink = "Y";
					}
					
					$idstr =  $this->Session->read("adminsIDStr");
					$idarr = explode(',', $idstr);
					for($m=0;$m < count($idarr);$m++)
					{
						if($students['classgroupStudent']['added_by']==$idarr[$m])
						{
							$dispalylink = "Y";
						}
					}

					// students who  are under the same admin but created by educator or coadmin
					if(!empty($educatorsId))
					{
						foreach($educatorsId as $eduId)
						{
							if($eduId['User']['id']==$students['classgroupStudent']['added_by'])
							{
								$dispalylink = "Y";
							}
						}
					} 
					
					if($dispalylink=='Y' && $this->request->params['action']!= 'filteredSearch')
					{?>
<p><a id="studdel" class="edit deleteGroup" onclick="return  confirmdel(<?php echo $students['User']['id'];?>,'S','');"> Delete Student</a></p>
				<?php }
				else if($this->request->params['action'] == 'filteredSearch')
				{
					//we will show the groups
					
				}
				?>

					
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
	<?php
	$k++;	
     $i++;		 
     
	 }?>
	 <div class="clr"></div>
 </div>
<?php }
else 
{
	echo '<p style="margin-top:10px;">';
	if(!isset($searched))
	{
		echo '<p style="margin-top:10px;" class="width100per">'.MSG_NO_STUDENT_HAS_BEEN_ADDED_YET.'';
		echo '<a href="javascript:void(0);" onclick="'.$f.'" class="edit">Click Here</a> to add student in this class group.</p>';
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
<input type="hidden" id="classgroupid" value="<?php echo $classgroupid?>">