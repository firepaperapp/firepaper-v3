<script>
var prj_id = "<?php echo $project_id?>";
$(document).ready(function() {
	$('.userTaskDocsDrop').click(function()
	{ 	 
		var myId = $(this).attr('id');
		if($('#'+myId+"_box").css('display') == "none")
		{
			var gotId = $(this).attr('id').split("_");
	 		if("undefined"== typeof(this.taskDetailCalled))
			{
				$('#'+myId+"_box").empty().html(loader);
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
				var callUrl = "userDocumentsDrop";
				if($("#taskType_"+gotId[1]).val() == "tick")
				{
					var callUrl = "userDocumentsTick";	
				} 
				var ex = $("#status"+prj_id).val();
				$.get(siteUrl+"projects/"+callUrl+"/"+gotId[1]+"/?s="+ex+"&rand="+randomnumber,   function(data)
				{	
		 			$('#'+myId+"_box").empty().html(data);
		 			 
		  		});
			}
			else
			{
				//this.taskDetailCalled = 0;
			}
			$('#'+myId+"_box").show('slow');
		}
		else
		{
			$('#'+myId+"_box").hide('slow');
		}
	});
	
});
</script>
<p><strong>Tasks</strong></p>
<div class="clr"></div>
<?php
$i=1;
foreach($tasks as $rec)
{?>
 <div style="margin-top:5px;">
      <?php
		if($isOwner == 0)
		{?> 	 
		   <div class="open-close">
          	<a href="javascript:void(0)" class="userTaskDocsDrop" id="droptask_<?php echo $rec['prjTask']['id'];?>">Open</a>
          </div>
	 <?php }
		else 
		{
			 
		}
	 ?>
      <div class="doc-icon">
      <?php if($rec['fileType']['icon']!='')
      {?>
     	 <img src="<?php echo IMAGES_PATH;?>icons/<?php echo $rec['fileType']['icon'];?>" />
	  <?php 
      }
		else 
		{?>
			<img src="<?php echo IMAGES_PATH;?>arrow.gif" />
		<?php
		}
		?>
      </div>
      <div class="file-name" style="width:50%;">
      
       <?php 
      if($rec['fileType']['icon']!='')
	  {?>
		    <a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $rec['prjTask']['refer_file_id']?>" id="tool-tip" style="color:black;"><?php echo Sanitize::html($rec['prjTask']['title']);?></a><em></em>
		<?php
	  }
	  else 
	  {
	  	echo Sanitize::html($rec['prjTask']['title']);
	  }
      ?></div>
      <div class="col-weight"><?php echo $rec['prjTask']['weight'];?>%</div>
      <?php
      if($rec['prjTask']['refer_file_id'] == 0)
      {
      	$taskType = "tick";
      }
      else {
      	$taskType = "doc";
      }
      ?>
      <input type="hidden" name="taskType_<?php echo $rec['prjTask']['id'];?>" id="taskType_<?php echo $rec['prjTask']['id'];?>" value="<?php echo $taskType;?>" />
      <div class="clr"></div>
      
</div>
<div id="droptask_<?php echo $rec['prjTask']['id'];?>_box" class="file-details">      		 		
</div>
<div class="clr-dotted"></div>
<?php }?>
 <?php
if($isOwner == 1)
{?> 	
<p class="marginT10"><a href="<?php echo SITE_HTTP_URL;?>projects/addEditProject/<?php echo $project_id;?>?m=e" class="edit">Edit Project</a></p>
<?php
}?>