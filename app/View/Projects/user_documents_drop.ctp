<?php

if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "/files/getFiles")!=false)
{
	$dropFile = 1;
}
else {
	$dropFile = 0;
}
?>
<script>
$(document).ready(function() {	 
		
if($(".dropAllowed").length!=0)
{	 
	$( ".dropFileHereProj").droppable({ accept: '.dragFileForProject' , drop: function(event, ui) 
	{ 	 
		var gotIdDrop = $(this).attr('id').split("_"); 
		var gotId = $(ui.draggable).attr('id').split("_");
		//We will get the detail of the selected file and populate HTML
		//$("#loaderJsTask").empty().html(loader).show();
		//$(ui.draggable).hide('slow');
		$.get(siteUrl+"projects/studentUploadTaskDoc/"+gotId[1]+"/"+gotIdDrop[1]+"/1"+"?v="+Number(new Date()),function(data)
		{	 
			$("#droptask_"+gotIdDrop[1]+"_box").append(data).show('slow');		
			//alert($("#taskUnderDiv").html());
			//$("#loaderJsTask").hide();
			$("#dragdrop_"+gotIdDrop[1]).fadeOut('slow');
		}
		);
	}
	});	
}
$('.upload-link-drop').each(function(){
var myId = $(this).attr('id');
var btnUpload = $('#'+myId);
var taskId = myId.split("_");
var status = $('#loaderJsTask');

if($("#"+myId).hasClass("file_upload") == false)
{
 $("#"+myId).fileUploadUI({
 	dragDropSupport: false,
    uploadTable: $('#filesDragDrop'+taskId[1]),
    downloadTable: $('#filesDragDrop'+taskId[1]),
    buildUploadRow: function (files, index) {
    	       return $('<tr>' +
                '<td class="file_upload_progress"><div><\/div><\/td>' +
                '<td class="file_upload_cancel">' +
                '<button class="ui-state-default ui-corner-all" title="Cancel">' +
                '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
                '<\/button><\/td><\/tr>');
    },
    buildDownloadRow: function (response) {
    	if("undefined" == typeof(response.success))
		{
				alert(response.error);

		} else{	 
				alert(response.success);	
				var project_id = $("#droptask_"+taskId[1]+"_box").parents(".prjList").attr('id');							
				$.get(siteUrl+"projects/studentUploadTaskDoc/"+response.id+"/"+taskId[1]+"/1/?v="+Number(new Date()),function(data)
				{	 
					$("#droptask_"+taskId[1]+"_box").append(data).show('slow');		
					//alert($("#taskUnderDiv").html());
					$("#loaderJsTask_"+project_id[1]).hide();
					$("#drag_"+taskId[1]).fadeOut('slow');
				}
				);
		}     
    }
});
}
 
	
});	
});
</script>
<div class="version-documents projectTasks">			   
<?php
if(count($taskDocs)>0)
{?>
<p class=""><strong>Your added documents</strong></p>
<?php
 	foreach($taskDocs as $rec)
	{?>
 
	 	<!-- end col-left -->
	 <p class="title"><img src="<?php echo IMAGES_PATH;?>file-icons/<?php echo $rec['fileType']['icon'];?>" />&nbsp;&nbsp;
	  <?php  
	  	echo $rec['prjTaskUserDoc']['title']; 
	  ?> 
	<?php
	if($canChnage == 1) //This project is closed
	{?>
	<a href="javascript:void(0)" class="deleteDocFrmProject edit" id="a_<?php echo $rec['prjTaskUserDoc']['id'];?>" onclick="delTaskDoc(<?php echo $rec['prjTaskUserDoc']['id'];?>)" style="color:red;">Delete</a>
	<?php
	}?>
	</p>	
	<?php 
	}
} ?>
</div>
<?php
if($canChnage == 1) //This project is closed
{?>
<div class="dropFileHereProj project-drop-area" id="dragdrop_<?php echo $task_id;?>" style="text-align:center;">
	<p>
		<?php
		if($dropFile == 1)
		{
	 		echo '<span  class="dropAllowed">Drag a  new version here</span> <span>or</span>';
		}?>
		<table id="filesDragDrop<?php echo $task_id;?>"></table>  
	 	<form id="formdrop_<?php echo $task_id;?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile" method="POST" enctype="multipart/form-data" class="marginT10 upload-link-drop" style="text-align:center;margin-left:27px;margin-top:-1px;">
			 <input type="file" id="uploadfile" name="data[userFile][uploadfile]" />   	 
			 <button>Upload</button>
			 <div>Upload files</div> 
		</form> 
		<!--<a id="uploadfile_<?php echo $task_id;?>" name="data[userFile][uploadFile]" class="edit upload-link-drop">Upload it</a>-->
	</p>		
</div>
<?php
}?>