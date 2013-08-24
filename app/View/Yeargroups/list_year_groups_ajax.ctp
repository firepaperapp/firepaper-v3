<script type="text/javascript">
$(document).ready(function(){
                $("a.deleteGroup").fancybox({
			ajax : {
			type	: "GET",
			}
		});
});
</script>
<?php echo $this->requestAction("/yeargroups/breadCrumb/$group_id");?>
<?php
$m = 0;
$f = "$('#add-groups').slideToggle('slow')";	 
?>
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
if(is_array($data) && count($data)>0)
{

echo '<p class="marginT10"><a href="javascript:void(0);" onclick="'.$f.'" class="edit">Click Here</a> to create group.</p>';
?>
<div class="row">
   	 <?php $k=1;
 	 foreach($data as $rec)
	 { 
	 		if($m%3==0 && $m!=0)
	 		{ 
	 		?>
			
				<div class="clr"></div>
  			  </div>
       		 <div class="row">
				<div class="user-box-left">		 			
	   <?php }
	   		 else 
	   		 { 
	   		 	if($m==0)
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
	   		?>
	  	       <?php 
		       if($viewType == "year")
		       {
		       	$editpgurl = SITE_HTTP_URL."yeargroups/viewgroups/".$rec['classGroup']['id'];
		       }
		       else {
		       	$editpgurl = SITE_HTTP_URL."yeargroups/classGroups/".$rec['classGroup']['id'];
		       }
		       ?>

				<div class="links" style="width:160px;">
					<p class="title">
						<a id="edituserprof" href="<?php echo $editpgurl; ?>"><b><?php echo ucfirst(Sanitize::html($rec['classGroup']['title']));?></b></a>
					</p>
					<?php
					
				    $rec[0]['cnt'] = $rec[0]['cnt']==""?0:$rec[0]['cnt'];
					//if($rec[0]['cnt']>0)
					{
						if($viewType == "year")
							$st = "Class Group(s)";
						else 
							$st = "Student(s)";
						?>
					<p style="font-weight:normal;"><?php echo $rec[0]['cnt']." ".$st."";?></p>
					<p style="font-weight:normal;">Created By:
						<?php
						if($this->Session->read("userid") == $rec['classGroup']['created_by'])
						{
							echo "You";
						}
						else 
						{
							echo  ucfirst(Sanitize::html($rec['UserC']['firstname']." ".$rec['UserC']['lastname']));;
						}?>
					</p>
					<?php
					$showdel =0;
					if($this->Session->read("userid") == $rec['classGroup']['created_by'] || $this->Session->read("userid") == $rec['classGroup']['admin_id'] || $this->Session->read("user_type")==7)
					{	$showdel = 1; }
					
					$adminIdsStr = $this->Session->read("adminsIDStr");
					$adminIdsArr = explode(',', $adminIdsStr);
					for($i=0;$i<count($adminIdsArr);$i++)
					{
						if($rec['classGroup']['created_by']==$adminIdsArr[$i])
						{	 $showdel = 1;		}
					}

					if($showdel==1)
					{
					?>
					<p><a class="edit deleteGroup" href="<?php echo SITE_HTTP_URL."yeargroups/deletegroup/".$rec['classGroup']['id'];?>">Delete</a></p>
					<?php }?>
					<?php 
					}?>
     				
		        </div>
				<div class="clr"></div>
		    </div>  
	<?php
	$k++;	
     $m++;		 
    
	 }?>
	 <div class="clr"></div>
</div>
<?php 
$this->Paginator->options(array('url' => $this->passedArgs));
echo $this->element("pagination/ajax_pagination");
}
else 
{	
	echo '<p style="margin-top:10px;">';
	if(!isset($searched))
	{
		
		if(!isNull($group_id))
		{
			echo 'No class group has been created yet in this year group. <a href="javascript:void(0);" onclick="'.$f.'" class="edit">Click Here</a> to create new.';
		}
		else 
		{
			echo 'No year group has been created yet. <a href="javascript:void(0);" onclick="'.$f.'" class="edit">Click Here</a> to create new.';
		}
		
	}
	else 
	{
		echo "No search results found.";
	}
	echo '</p>';
}
?>