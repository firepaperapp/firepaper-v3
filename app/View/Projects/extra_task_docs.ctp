<script>

</script>
<?php
if(count($docs)>0)
{
	foreach($docs as $rec)
	{?>
	<p class="marginT10">
	<a href="<?php echo SITE_HTTP_URL;?>files/downloadFile/<?php echo $rec['userFile']['id'];?>"><img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $rec['fileType']['icon']?>" /><span class="task-title"><?php echo $rec['userFile']['file_name'];?></span></a>
	<?php  
  	$url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
	if(false !==  strpos($url , 'projects/addEditProject')) {
	?>	
	&nbsp;-&nbsp;<a href="javascript:void(0)" onclick="deleteDoc(<?php echo $task_id;?>, <?php echo $rec['projectTaskExtraDoc']['id'];?>);" class="edit">Delete File</a>&nbsp;</a>
	<?php
	}?>
	</p>
	<?php
	
	}
}else 
{?>
	<p class="marginT10">
	No Records Found
	</p>
<?php
}?>