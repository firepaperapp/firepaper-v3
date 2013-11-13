$(document).ready(function() {
		$('.viewTskComments').live("click", function()
		{	 
		
		alert("dddd");
			var myId = $(this).attr('id');
			if($('#'+myId+"_box").css('display') == "none")
			{
				var gotId = $(this).attr('id').split("_");
		 		if("undefined"== typeof(this.taskDetailCommentCalled))
				{ 
					$('#'+myId+"_box").empty().html(loader);
					//using random number to resolve cache issue
					var randomnumber=Math.floor(Math.random()*101);
					var ex = "";
					if($("#isOwner").val() != 1)
						ex = $("#gotUserId").val();
					$.get(siteUrl+"projects/getAllCommentsOnTask/"+gotId[1]+"/"+ex+"?rand="+randomnumber,   function(data)
					{	
			 			$('#'+myId+"_box").empty().html(data);
			 			 
			  		});
				}
				else
				{
					//this.taskDetailCommentCalled = 1;
				}
				$('#'+myId+"_box").show('slow');
			}
			else
			{
				$('#'+myId+"_box").hide('slow');
			}
		}
	);
	$('.viewTskCommentsInner').live("click", function()
		{	 
			var myId = $(this).attr('id');
			if($('#'+myId+"_box").css('display') == "none")
			{
				var gotId = $(this).attr('id').split("_");
		 		if("undefined"== typeof(this.taskDetailCommentCalled))
				{ 
					$('#'+myId+"_box").empty().html(loader);
					//using random number to resolve cache issue
					var randomnumber=Math.floor(Math.random()*101);
					var ex = "";
				 
					$.get(siteUrl+"projects/userDocumentComments/"+gotId[1]+"/?rand="+randomnumber,   function(data)
					{	
			 			$('#'+myId+"_box").empty().html(data);
			 			 
			  		});
				}
				else
				{
					//this.taskDetailCommentCalled = 1;
				}
				$('#'+myId+"_box").show('slow');
			}
			else
			{
				$('#'+myId+"_box").hide('slow');
			}
		}
	);
	$(".addcommentlink").live("click", function(){
   	
   		var id = $(this).attr('id');
   		//$(".addcomment").hide();    		  		
   	 	$("#"+id+"_box").find("textarea").val("");
   		$("#"+id+"_box").slideToggle();
   		
   });
	 
		$("#sendmesg").fancybox({
			ajax : {
			type	: "GET",
			}
		});

		$('.userTaskDocs').click(function()
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
					var callUrl = "userDocuments";
					if($("#VtaskType_"+gotId[1]).val() == "tick")
					{
						//var callUrl = "userDocumentsTick";	
					} 
					var ex = $("#status"+$("#project_id").val()).val();
					
					
					$.get(siteUrl+"projects/"+callUrl+"/"+gotId[1]+"?view=Large&s="+ex+"&rand="+randomnumber,   function(data)
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
		}
	);
	$(".submitWithoutDoc").live("click",function()
		{ 	  
			
			var myId = $(this).attr('id');
			var gotId = $(this).attr('id').split("_");
			
			if($('#'+gotId[1]+"_withoutdocbox").css('display') == "none")
			{	
				$(this).parent("p").hide();
				$('#'+gotId[1]+"_withoutdocbox").empty().html(loader);
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
			  	var callUrl = "userDocumentsTick";	
		 		var ex = $("#status"+$("#project_id").val()).val();
		 	 
		 		$.get(siteUrl+"projects/"+callUrl+"/"+gotId[1]+"?view=Large&s="+ex+"&rand="+randomnumber,   function(data)
				{	
		 			$('#'+gotId[1]+"_withoutdocbox").empty().html(data).show("slow");
		 			 
		  		});
			}
			else
			{
				$('#'+gotId[1]+"_withoutdocbox").show('slow');
			}
			
		});
	//$('.userTaskDocs').trigger("click");
});
function delCommentId(commentId, taskId, from)
{		 
	if(confirm("Do you really want to delete this comment?"))
		{
			if($(taskId).length == 0)
				taskId = 0;
				
			//$('#viewTskComments_'+taskId+"_box").empty().html(loader);
			if(from!='')
			{
				var url = "getAllCommentsOnTask";
			}
			else
			{
				var url = "userDocumentComments";
			}
			$.post(siteUrl+"projects/"+url+"/"+taskId, {d:commentId},function(data)			{
				if(taskId==0)		
				{
					$('#projComments_'+commentId).fadeOut();
				}
				else
				{
					$('#delcomment_'+commentId).fadeOut();
				}
			} );	   		
		}		 
}
function addComment(f,t)
{		
	if($.trim($("#addcommenttext_"+f).val())=="")
	{
		alert("Please enter comment.");
	}
	else
	{
	    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
	    $('#viewTskComments_'+f+"_box").empty().html(loader);
	    $.post(siteUrl+"projects/userDocumentComments/"+f+"/?rand="+randomnumber, {
	    	comment:$("#addcommenttext_"+f).val(), 
	    	posted_to: $('#posted_to').val(),
	    	project_id:$("#project_id").val(), 
	    	task_id:t,
	    	student_doc_id:f,
	    	comment:$("#addcommenttext_"+f).val(), 
	    }, function(data)
		{
		   $("#addcomment_"+f+"_box").slideUp();
		   $("#addcommenttext_"+f).val("");
           $('#viewTskComments_'+f+"_box").empty().html(data).show();           
           
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false; 
	}
}
function studentUploadDoc(taskId)	
 {
    $("#loaderJsTask").empty().html(loader).show();
    $('#uploadDoc').slideUp('slow');
    var postedVal = $("#studSubmitTaskDoc_"+taskId).serialize()+"&posted_to="+$('#posted_to').val();
    $.post(siteUrl+"projects/studentSubmitDocToProject/"+taskId+"/?p="+$('#project_id').val(),postedVal,function(data){		
    	
    	$("#loaderJsTask").empty().hide();			            	
    	//TO alert the success message
		if("undefined" == typeof(data.success))
		{
			$('#uploadDoc').slideDown('slow');
			var err = data.error.toString();
			$('#validation-container-task').empty().html(err).show();
		}
		else
		{							
        	 
			var msg = data.success; 
			$('#validation-container-task').empty().html(msg).show();
			//we will get the task list
			$('#task_'+taskId+"_box").empty().html(loader);
			//using random number to resolve cache issue
		 	var randomnumber=Math.floor(Math.random()*101);
		 	window.location = siteUrl+"projects/viewDetails/"+$('#project_id').val();
			/*$.get(siteUrl+"projects/userDocuments/"+taskId+"/?rand="+randomnumber,   function(data)
			{	
	 			$('#task_'+taskId+"_box").empty().html(data);
	 			 
	  		});*/
			 
		
    }},"json");
    return false;   
 }
function studentUploadDocTickLarge(taskId)
{
	if($("#studSubmitTaskDocDropLarge_"+taskId+" :input").eq(0).is(":checked") == false)
	{
		alert("Please check that task is done.");
		return false;
	}
	else
	{
		var project_id = $("#project_id").val();
		$("#loaderJsTask").empty().html(loader).show();
		var postedVal = $("#studSubmitTaskDocDropLarge_"+taskId).serialize();
		$.post(siteUrl+"projects/studentSubmitDocToProject/"+taskId+"/?p="+project_id,postedVal,function(data){		
			
			$("#loaderJsTask").empty().hide();			   
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
			 	window.location = siteUrl+"projects/viewDetails/"+project_id;
				/*$.get(siteUrl+"projects/userDocuments/"+taskId+"/?view=large&rand="+randomnumber,   function(data)
				{	
		 			$('#task_'+taskId+"_box").empty().html(data);
		 			 
		  		});*/
				 
			
		}},"json");
		return false; 	
	}
}
function addCommentTask(f)
{		
	if($.trim($("#addcommenttext_"+f).val())=="")
	{
		alert("Please enter comment.");
	}
	else
	{
	    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
	    ex = 0;
    	if($("#isOwner").val() != 1)
			ex = $("#gotUserId").val();
	    $('#viewTskComments_'+f+"_box").empty().html(loader);
	    $.post(siteUrl+"projects/getAllCommentsOnTask/"+f+"/"+ex+"?rand="+randomnumber, {
	    	comment:$("#addcommenttext_"+f).val(), 
	    	posted_to: $('#posted_to').val(),
	    	project_id:$("#project_id").val(), 
	    	task_id:f,
	      	comment:$("#addcommenttext_"+f).val(), 
	    }, function(data)
		{
		   $("#addcomment_"+f+"_box").slideUp();	
           $('#viewTskComments_'+f+"_box").empty().html(data).show();           
           
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false; 
	}
	
} 
function viewExtraTaskDocs(task_id)
{
	var randomnumber=Math.floor(Math.random()*101);
	if($('#extraDocs_'+task_id).css('display') == "none")
	{
		$.get(siteUrl+"projects/extraTaskDocs/?task_id="+task_id+"&rand="+randomnumber,   function(data)
		{	
	
			$('#extraDocs_'+task_id).empty().html(data).show('slow');
		});
	}
	else
	{
		$('#extraDocs_'+task_id).hide('slow');
	}
}function completeProject()
{
	if(confirm("Are you sure you want to complete this project?"))
	{
		return true;
	}
	else
		return false;
}