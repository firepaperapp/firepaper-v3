<!--File Upload Progress bar-->
<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script> 
<!--File Upload Progress bar End-->
<script>
function studentUploadDocTick(taskId)
{
	if($("#studSubmitTaskDocDrop_"+taskId+" :input").eq(0).is(":checked") == false)
	{
		alert("Please check that task is done.");
		return false;
	}
	else
	{
		var project_id = $("#droptask_"+taskId+"_box").parents(".prjList").attr('id').split("_");
		$("#loaderJsTask_"+project_id[1]).empty().html(loader).show();
		var postedVal = $("#studSubmitTaskDocDrop_"+taskId).serialize();
		$.post(siteUrl+"projects/studentSubmitDocToProject/"+taskId+"/?p="+project_id[1],postedVal,function(data){		
			
			$("#loaderJsTask_"+project_id[1]).empty().hide();			            	
			//TO alert the success message
			if("undefined" == typeof(data.success))
			{
			 	var err = data.error.toString();
				alert(err);
			}
			else
			{							
		    	 
				var msg = data.success; 
				//$('#validation-container-task').empty().html(msg).show();
				//we will get the task list
				$('#droptask_'+taskId+"_box").empty().html(loader);
				//using random number to resolve cache issue
			 	var randomnumber=Math.floor(Math.random()*101);
				$.get(siteUrl+"projects/userDocumentsTick/"+taskId+"/?rand="+randomnumber,   function(data)
				{	
		 			$('#droptask_'+taskId+"_box").empty().html(data);
		 			 
		  		});
				 
			
		}},"json");
		return false; 	
	}
}
function studentUploadDocDrop(taskId)	
{
var project_id = $("#droptask_"+taskId+"_box").parents(".prjList").attr('id').split("_");
$("#loaderJsTask_"+project_id[1]).empty().html(loader).show();
var postedVal = $("#studSubmitTaskDocDrop_"+taskId).serialize();
$.post(siteUrl+"projects/studentSubmitDocToProject/"+taskId+"/?p="+project_id[1],postedVal,function(data){		
	
	$("#loaderJsTask_"+project_id[1]).empty().hide();			            	
	//TO alert the success message
	if("undefined" == typeof(data.success))
	{
	 	var err = data.error.toString();
		alert(err);
	}
	else
	{							
    	 
		var msg = data.success; 
		//$('#validation-container-task').empty().html(msg).show();
		//we will get the task list
		$('#task_'+taskId+"_box").empty().html(loader);
		//using random number to resolve cache issue
	 	var randomnumber=Math.floor(Math.random()*101);
		$.get(siteUrl+"projects/userDocumentsDrop/"+taskId+"/?rand="+randomnumber,   function(data)
		{	
 			$('#droptask_'+taskId+"_box").empty().html(data);
 			 
  		});
		 
	
}},"json");
return false;   
}
$(document).ready(function() {
	$('.projectsDp').click(function()
	{ 	
		var myId = $(this).attr('id');
		var gotId = $(this).attr('id').split("_");
		if(location.href.indexOf("viewDetails/"+gotId[1])!=-1)
		{
			window.location = siteUrl+"projects/viewDetails/"+gotId[1];
		}
		if($('#'+myId+"_box").css('display') == "none")
		{
			
	 		if("undefined"== typeof(this.taskDetailCalled))
			{
				$('#'+myId+"_box").empty().html(loader);
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
				$.get(siteUrl+"projects/listProjectTasks/"+gotId[1]+"/?rand="+randomnumber,   function(data)
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
<?php
if(count($myProjects)>0)
{
	$i = 1;
	foreach($myProjects as $rec)
	{
	$status = "u"; //Project Un Completed
    if( (isset($rec['projectStudent']['id']) && $rec['projectStudent']['completed'] == 1) ||$rec['Project']['published']!=1 )
    {
    	$status = "c"; //Project Completed
    }	
	?>
	<div class="project">
	    <p class="title"><span><?php echo $i;?></span><label onclick="window.location = '<?php echo SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id'];?>'" style="cursor:pointer;"
	title="View Project"><?php echo Sanitize::html($rec['Project']['title']);?></label> <a href="javascript:void(0);" class="btn projectsDp" id="project_<?php echo $rec['Project']['id'];?>">Open</a></p>
	    <div class="clr"></div>
	    <div id="loaderJsTask_<?php echo $rec['Project']['id'];?>"></div>
	    <div class="project-details prjList" id="project_<?php echo $rec['Project']['id'];?>_box"> <em>Files added:</em>
	      
	    </div> <!-- end project-details -->
	  </div> <!-- end project -->
	  <input type="hidden" name="status<?php echo $rec['Project']['id'];?>" id="status<?php echo $rec['Project']['id'];?>" value="<?php echo $status;?>" />
	<?php  
	$i++;
	}
}
else {?>
	<p class="marginT10"><?php echo NO_PROJECTS_FOUND;?></p>
<?php }?>