$(document).ready(function(){
		
        //$(".project-drop-area").live("mouseover", function(){
        //    if()
        //    {
        //        $(this).style('position':'relative');
        //        $(this).children('form').addClass('drop-file');
        //    }
        //});
        //$(".project-drop-area").live("mouseout", function(){
        //    $(this).style('position':'');
        //     $(this).children('form').removeClass('drop-file'); 
        //});
        
   		commentEvents();
		var getTeacherForSubject = function()
		{
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue	
			$.get(siteUrl+"projects/getTeachersOfSubject/"+$("#subject_id").val()+"?rand="+randomnumber,function(data)
			{
				$("#leader").empty().html(data);
			}
			);
		}
		if($("#subject_id").val()=="")
		{
			// if we have not opened project detail page
			getTeacherForSubject();
		}
		if($("#leader").length!=0)
		{
			$('#subject_id').change(function(){
				getTeacherForSubject();
			});
		}
		$("#duedate").datepicker({
				dateFormat: 'D MM yy',
				showOn: 'button',
				buttonImage: siteImagesUrl+'calendar.png',
				changeMonth: true,
				changeYear: true,
				minDate: new Date(),
				buttonImageOnly: true
		});
		/*
		* Validation for project creation form
		*/
		$("#Project").validate({
					//errorClass:"invalid",
				   errorElement: "p",
				   errorLabelContainer: "#validation-container",
				   unhighlight: function(element, errorClass) {
			 
				   },	
				   debug:false,
				   invalidHandler: function(e, validator) {
					var errors = validator.numberOfInvalids();
					 	if (errors) {
					 		$("div#validation-container").hide();
						} else {
							$("div#validation-container").hide();
						}
					},
					submitHandler: function(form) {
			            $("#loaderJs").empty().html(loader).show();
			            $.post(siteUrl+"projects/addEditProject/"+$("#project_id").val(),$("#Project").serialize(),function(data){		
			            	$("#loaderJs").empty().hide();
			            	
			            	//TO alert the success message
							if("undefined" == typeof(data.success))
							{
								var err = data.error.toString();
								$('#validation-container').empty().html(err).show();
							}
							else
							{							
				            	var projectId = data.id;							
								$("#project_id").val(projectId);
								//$("#createProject").slideUp('slow');
								//$("#projectCreated").empty().html("<h3>Project: </h3>"+$("#projectTitle").val());				
								$("#createProjectBtn").fadeOut("slow")
								$('#docAndTask').show('slow');
							
								$('#taskUnderDiv').show('slow'); 
								$('#groupDiv').show('slow');
								
							}
							
			            },"json");				
			        },
				   onkeyup: false,
				   rules: {      
			  	     "data[Project][title]":  {required: true},	 	   
			 	     "data[Project][description]":  {required: true},
			 	     "data[Project][subject_id]":  {required: true},
			 	     "data[Project][duedate]":  {required: true}, 	     
		   	  	     "data[Project][leader_id]":  {required: true}
			 	   },
				   messages: 
				   {			   	 
				 	 "data[Project][title]":  {
					 	required: "Please enter project title."
					 },
			 	     "data[Project][description]": {
			 	     	required: "Please enter description."	 	     	
			 	     },
			 	      "data[Project][subject_id]": {
			 	     	required: "Please choose subject."	 	     	
			 	     },
			 	     "data[Project][duedate]":  {
			 	     	required: "Please enter due date."	 	     	
			 	     }
			 	     ,
			 	     "data[Project][leader_id]":  {
			 	     	required: "Please select leader."	 	     	
			 	     } 
			 	      
		 		   }
				}		
			);
			/*
			* Validation for task creation form, when user click on "Create Task"
			*/
			$("#createTaskForm").validate({
			//errorClass:"invalid",
		   		errorElement: "p",
		 	   debug:false,
		 	   errorLabelContainer: "#validation-container-task",
			  invalidHandler: function(e, validator) {
					var errors = validator.numberOfInvalids();
					 	if (errors) {
					 		$("div#validation-container-task").show();
						} else {
							$("div#validation-container-task").hide();
						}
					},
				submitHandler: function(form) {
		               $("#loaderJsTask").empty().html(loader).show();
		               $('#createTaskDiv').slideUp('slow');
			            $.post(siteUrl+"projects/createTask/0"+"/?p="+$('#project_id').val(),$("#createTaskForm").serialize(),function(data){		
			            		$("#loaderJsTask").empty().hide();
			          			$("#tasksCount").val(Number($("#tasksCount").val())+1);
								$("#taskMsgDiv").empty().html("");
								$('div#createdTasks').prepend(data);	
								$("#validation-container-task").empty().hide();	
								$("#validation-container-success-task").empty().html("Task created successfully.").show();
	 						
			             });
		        },
			   onkeyup: false,
			   rules: {      
		  	     "data[projectTask][title]":  {required: true},
		  	     "data[projectTask][weight]":  {required: true, digits: true, min:1}
			  },
			   messages: 
			   {			   	 
			 	 "data[projectTask][title]":  {
				 	required: "Please enter task title."				 	
				 },
				 "data[projectTask][weight]":  {
				 	required: "Please enter weight.",
				 	digits:"Please enter a valid number."
				 }
	 		   }
			}		
		);
		/*
		* When a File is dropped in the droppable area, we will fire get request and create a div to Add that Doc as task
		*/
		 
		$( ".dropFileHere").droppable({ accept: '.dragFiles' , drop: function(event, ui) 
		{ 	 
			var gotId = $(ui.draggable).attr('id').split("_");
			//We will get the detail of the selected file and populate HTML
			$("#loaderJsTask").empty().html(loader).show();
			//$(ui.draggable).hide('slow');
			$.get(siteUrl+"projects/createTaskDoc/"+gotId[1]+"/?v="+Number(new Date()),function(data)
			{	 
				$("#taskUnderDiv").empty().html(data).show('slow');		
				//alert($("#taskUnderDiv").html());
				$("#loaderJsTask").hide();
				$(".dropFileHere").fadeOut('slow');
			}
			);
				
		}
		});		
		/*
		* TO upload a file when user click on uploadFile
		*/
		var btnUpload = $('#uploadfile'); 
		var status = $('#loaderJsTask');
		
		 $('#file_upload').fileUploadUI({
		 	dragDropSupport: true,
	        uploadTable: $('#files'),
	        downloadTable: $('#files'),
	        buildUploadRow: function (files, index) {
	             return $('<tr><td>' + files[index].name + '<\/td>' +
	                    '<td class="file_upload_progress"><div><\/div><\/td>' +
	                    '<td class="file_upload_cancel">' +
	                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
	                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
	                    '<\/button><\/td><\/tr>');
	        },
	        buildDownloadRow: function (response) {
	        	//Add uploaded file to list
						if("undefined" == typeof(response.success))
						{
							$("#validation-container-task").empty().html("<p class='error'>"+response.error+"</p>").show();
							$("#validation-container-success-task").empty().hide();
	
						} else{	 
								$("#validation-container-task").empty().hide();
								$("#validation-container-success-task").empty().html(response.success).show();								
								$.get(siteUrl+"projects/createTaskDoc/"+response.id+"/?v="+Number(new Date()),function(data)
								{	 
									$("div#taskUnderDiv").empty().html(data).show('slow');	
									$("#loaderJsTask").hide();
									$(".dropFileHere").fadeOut('slow');
								}
								);
						}        
	        }
	    });
	    	
	 		 	
	//using random number to resolve cache issue
	$("#usersGroups").fcbkcomplete({
            json_url: siteUrl+"projects/getOtherGroups/",
            filter_selected: true,
            cache: false, 
            addontab: true,                     
            height: 4,
            width:"550"          
          });		 	
   //using random number to resolve cache issue
	$("#otherUsers").fcbkcomplete({
            json_url: siteUrl+"projects/getOtherUsers/",
            filter_selected: true,
            cache: false, 
            addontab: true,                     
            height: 4,
            width:"550"          
          });	
      //using random number to resolve cache issue
	$("#whiteboards").fcbkcomplete({
            json_url: siteUrl+"whiteboards/getWhiteboards/",
            filter_selected: true,
            cache: false, 
            addontab: true,                     
            height: 4,
            width:"550",
            loaderDiv:'containerLoader1',
            errorDiv: 'showAddMore1'       
          });	   
   	 /*  ############### Project in Edit Mode #####################################*/
	  if(userAdded.length!=0)
	  {
	  		for( var i=0;i<userAdded.length;i++)
			{			 	 
				 $("#otherUsers").trigger("addItem",[{"title": userAdded[i].key, "value": userAdded[i].value}]);
			}
	  }
	  if(groupAdded.length!=0)
	  {
	  		for( var i=0;i<groupAdded.length;i++)
			{			 	 
				 $("#usersGroups").trigger("addItem",[{"title": groupAdded[i].key, "value": groupAdded[i].value}]);
			}
	  }
	  if(whiteboardsAdded.length!=0)
	  {
	  		for( var i=0;i<whiteboardsAdded.length;i++)
			{			 	 
				 $("#whiteboards").trigger("addItem",[{"title": whiteboardsAdded[i].key, "value": whiteboardsAdded[i].value}]);
			}
	  }
	  
 	  if($('#project_id').val()!=0 && $('#projectTitle').val()!='')	
 	  {
 	  		$('#projectTitle').attr("readonly","readonly");
 	  }
 	
	 /* ############### Project in Edit Mode Ends #####################################	*/
 	
	});		
	
//To submit the project form	

function submitProject(status)
{
	$("#Project").submit();
}
//When a task is added then show it in the "Added Documents and Tasks" Div
function createTaskHtml(gotFormObj, taskId) 
{
	var title = $("#"+gotFormObj+" input[name='data[projectTask][title]']").val();
	var weight = $("#"+gotFormObj+" input[name='data[projectTask][weight]']").val();
	var text = $("#"+gotFormObj+" :input[name='data[projComments][comment]']").val();
	 
	
	var st = '<div  id="createdTasksCl_'+taskId+'"><div class="project-brief-box-wrapper createdTasksCl"><div class="project-drop-area-wrapper"><div class="weight-col">'+weight+'%</div><p>';
	
	if($("#"+gotFormObj+" input[name='data[projectTask][refer_file_id]']").length!=0)
	{
		st+='<a href="'+siteUrl+'files/downloadFile/'+$("#refer_file_id").val()+'" class="edit"><span class="task-title">'+title+'</span></a>';
	}
	else
	{
		st+='<span class="task-title">'+title+'</span>';
	}
	st+='&nbsp;-&nbsp;<a href="javascript:void(0);" class="edit" onclick="delTaskFromProject('+taskId+')">Delete Task</a> <p class="task-comment-title">Comment</p><div class="task-comment-wrapper"><div class="task-comment"><p>'+text+'</p></div></div></div></div><div class="clr"></div><div class="clr-spacer"></div></div>';
	 					            
	$('div#createdTasks').prepend(st);
}
function delTaskFromProject(taskId)
{
	if(confirm("Are you sure you want to delete this task?"))
	{
		$("#loaderJsTask").empty().html(loader).show();
		$.post(siteUrl+"projects/deleteTask/",{taskId:taskId}, function(response)
		{
			if("undefined" == typeof(response.success))
			{
		 		$("#validation-container-task").empty().html(response.error).show();
				$("#validation-container-success-task").empty().hide();
	
			} else{	
				$("#tasksCount").val(Number($("#tasksCount").val())-1);
				$("#loaderJsTask").hide();
				$("#validation-container-task").empty().hide();
				$("#validation-container-success-task").empty().html(response.success).show();							
				$("#createdTasksCl_"+taskId).fadeOut('slow');
			}								
		},"json");
	}
}
function createTaskEmpty()
{
	$('#createTaskForm input[name="data[projectTask][weight]"]').val("");
	$('#createTaskForm input[name="data[projectTask][title]"]').val("");
	$('#comment').val(""); 
	$('div#validation-container-task').empty().hide();
	$('#createTaskDiv').slideToggle();
}
function saveProjFormH(status)
{
	if($('#tasksCount').val() == 0)
	{
		alert("Please create any task.");	
	}
	else if(null == $('#usersGroups').val() && null == $('#otherUsers').val() && status!=0 )
	{
		alert("Please select any group first");
	}
	else if( $('#comment_project').length!=0 &&  $.trim($('#comment_project').val()) == "")
	{
		alert("Please enter the changes that you have made.");
	}
	else
	{
        $("#customstatus").val(status);
		$.ajax({
            type: "POST",
            url: $("#Project").attr('action'),
            data: $("#Project").serialize(),
            success: function(){
                document.saveProjForm.action = siteUrl+"projects/saveOrSendProject/"+$("#project_id").val()+"/"+$("#customstatus").val();
                document.saveProjForm.submit();
            },
            dataType: "json"
        });
		
	}
}
function checkTask()
{	//alert("MAN");
 	var regexp = /^[0-9]{1,2}$/gi;
 	$("div#validation-container-task").show();
  	//if($.trim(document.editinplaceform.value.value)=="")
	{
	    $("div#validation-container-task").empty().html('Please enter weight');
	    return false;
	}
	//else if(!regexp.test($.trim(document.editinplaceform.value.value)) || $.trim(document.editinplaceform.value.value)<1)
	{
		$("div#validation-container-task").empty().html('Please enter numeric digits');
	    return false;
	}
	else
	{
		$("div#validation-container-task").empty().hide();
		return true;
	}
}
function addComment(f)
{		
	if($.trim($("#addcommenttext_"+f).val())=="")
	{
		alert("Please enter comment.");
	}
	else
	{
	    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
	    $('#viewTskComments_'+f+"_box").empty().html(loader);
	    $.post(siteUrl+"projects/getAllCommentsOnTask/"+f+"/"+$("#gotUserId").val()+"?rand="+randomnumber, {
	    	comment:$("#addcommenttext_"+f).val(), 
	    	posted_to: $('#posted_to').val(),
	    	project_id:$("#project_id").val(), 
	    	task_id:f,
	      	comment:$("#addcommenttext_"+f).val(), 
	    }, function(data)
		{
		   $("#addcomment_"+f+"_box").slideUp();	
           $('#viewTskComments_'+f+"_box").empty().html(data).show();
           var totalcomment = $('#viewTskComments_'+f+"_box").find("input[name='countComment']").val();
            $("a#viewTskComments_"+f).html(totalcomment+ ' Comment(s)');
           
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false; 
	}
}
function delCommentId(commentId, taskId, from)
{		 
	if(confirm("Do you really want to delete this comment?"))
		{
			if($(taskId).length == 0)
				taskId = 0;
				
			$('#viewTskComments_'+taskId+"_box").empty().html(loader);
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
					$('#viewTskComments_'+taskId+"_box").empty().html(data);
                    var totalcomment = $('#viewTskComments_'+taskId+"_box").find("input[name='countComment']").val();
                   
                    $("a#viewTskComments_"+taskId).html(totalcomment+ ' Comment(s)');
				}
			} );	   		
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
}
function deleteDoc(task_id, fileId)
{
	var randomnumber=Math.floor(Math.random()*101);
	$.get(siteUrl+"projects/extraTaskDocs/?task_id="+task_id+"&delId="+fileId+"&rand="+randomnumber,   function(data)
	{	
		$('#extraDocs_'+task_id).empty().html(data).show('slow');
			 
	});
}
function commentEvents()
{
	$('.viewTskComments').on("click", function()
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
					$.get(siteUrl+"projects/getAllCommentsOnTask/"+gotId[1]+"/"+$("#gotUserId").val()+"?rand="+randomnumber,   function(data)
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
	$(".addcommentlink").on("click", function(){
   	
   		var id = $(this).attr('id');
   		//$(".addcomment").hide();    		  		
   		$("#"+id+"_box").find("textarea").empty().html("");
   		$("#"+id+"_box").slideToggle();
   		
   });	
    $('.extraTaskDocs').
    livequery(function()
	{
    	$(this).each(function(){
		 
				var myId = $(this).attr('id');
				var btnUpload = $('#'+myId);
				var status=$('#status');
				var manFileId = myId.split("_");
				var randomnumber=Math.floor(Math.random()*101); 
				  $(btnUpload).fileUploadUI({
				 	dragDropSupport: false,
			       uploadTable: $('#uploadRevison_'+manFileId[1]),
			        downloadTable: $('#uploadRevison_'+manFileId[1]),
			        buildUploadRow: function (files, index) {
			             return $('<tr><td>' + files[index].name + '<\/td>' +
			                    '<td class="file_upload_progress"><div><\/div><\/td>' +
			                    '<td class="file_upload_cancel">' +
			                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
			                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
			                    '<\/button><\/td><\/tr>');
			        },
			        buildDownloadRow: function (response) {
			        	//Add uploaded file to list
			        	 
						if("undefined" == typeof(response.success))
						{
							$("#validation-container-task").empty().html("<p class='error'>"+response.error+"</p>").show();
							$("#validation-container-success-task").empty().hide();
		
						} else{	 
								$("#validation-container-task").empty().hide();
								$("#validation-container-success-task").empty().html(response.success).show();												$("#extraDoc_"+manFileId[1]).show();
								
								$.get(siteUrl+"projects/extraTaskDocs/?addFile="+response.id+"&task_id="+manFileId[1]+"&project_id="+$("#project_id").val()+"&v="+Number(new Date()),function(data)
								{	
 
									$("#extraDoc_"+manFileId[1]).show();
									$("div#extraDocs_"+manFileId[1]).empty().html(data).show('slow');	
									$("#loaderJsTask"+manFileId[1]).hide();
									//$(".dropFileHere").fadeOut('slow');
									loadPiece(siteUrl+"files/listFiles/page:1/sort:uploaded/direction:desc?rand="+randomnumber,"#dropbox_files");
								}
								);
						}        
			        }
			    });
	 		 });
	 	 });
	   //Yp upload the extra docs related 
		$( ".dropTaskFileHere").
		livequery(function()
		{
			$(this).droppable({ accept: '.dragFiles' , drop: function(event, ui) 
			{ 	 
				 
				var fileId = $(ui.draggable).attr("id").split("_"); 
				var taskId = $(this).attr('id').split("_");
				//We will get the detail of the selected file and populate HTML
				$("#loaderJsTask"+taskId[1]).empty().html(loader).show();
				//$(ui.draggable).hide('slow');
				$.get(siteUrl+"projects/extraTaskDocs/?addFile="+fileId[1]+"&task_id="+taskId[1]+"&project_id="+$("#project_id").val()+"&v="+Number(new Date()),function(data)
		 
				{	 
					$("#extraDoc_"+taskId[1]).show();
			 		$("#loaderJsTask"+taskId[1]).hide();
			 		$("div#extraDocs_"+taskId[1]).empty().html(data).show('slow');	
		 		}
				);
					
			}
			});		
		});
		$(".editTaskWeight").
			editable(siteUrl+"projects/updateTaskWeight/",
		    {
		        indicator : loader ,
		        width: 30,
		        type   : 'text',
		        submit: "Save",
		        submitdata: { _method: "put" },
		        onsubmit : checkTask,		        
            	event : 'manclick.editable',
            	callback: tasEditDone
		     });
	  
		$(".editLink").on("click", function()
		{
			var id = $(this).attr('id');  
			var me = $.trim($("#taskWeight_"+id).html());
			$("#taskWeight_"+id).empty().html(me);
			$("#taskWeight_"+id).trigger("manclick.editable");
			 
		});
}
function tasEditDone(data)
{
	 
}
function completeProject()
{
	if(confirm("Are you sure you want to complete this project?"))
	{
		return true;
	}
	else
		return false;
}