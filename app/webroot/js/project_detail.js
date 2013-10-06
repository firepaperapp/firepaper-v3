$(document).ready(function() {		 
		
	
	/*
	* TO upload a file when user click on uploadFile
	*/
	
	$('.upload-link').each(function(){
		var myId = $(this).attr('id');
		var btnUpload = $('#form_'+myId);
		var status=$('#status');
		var taskId = myId.split("_");
 
 	 	if($("#"+myId).hasClass("file_upload") == false)
	 	{alert('hajj');
		 $("#"+myId).fileUploadUI({
		 	dragDropSupport: false,
	        uploadTable: $('#filesDrag'+taskId[1]),
	        downloadTable: $('#filesDrag'+taskId[1]),
	        buildUploadRow: function (files, index) {
	        	       return $('<tr><td>' + files[index].name + '<\/td>' +
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
							//alert(response.success);								
							$.get(siteUrl+"projects/studentUploadTaskDoc/"+response.id+"/"+taskId[1]+"/?v="+Number(new Date()),function(data)
							{	 
								$("#task_"+taskId[1]+"_box").append(data).show('slow');		
								//alert($("#taskUnderDiv").html());
								$("#loaderJsTask").hide();
								$("#drag_"+taskId[1]).fadeOut('slow');
							}
							);
					}        
	        }
	    });
	 	}	
	 
	});
	$( ".dropFileHere").droppable({ accept: '.dragFiles' , drop: function(event, ui) 
		{ 
		 
			var gotIdDrop = $(this).attr('id').split("_"); 
			var gotId = $(ui.draggable).attr('id').split("_");
			//We will get the detail of the selected file and populate HTML
			$("#loaderJsTask").empty().html(loader).show();
			//$(ui.draggable).hide('slow');
			$.get(siteUrl+"projects/studentUploadTaskDoc/"+gotId[1]+"/"+gotIdDrop[1]+"?v="+Number(new Date()),function(data)
			{	 
				$("#task_"+gotIdDrop[1]+"_box").append(data).show('slow');		
				//alert($("#taskUnderDiv").html());
				$("#loaderJsTask").hide();
				$("#drag_"+gotIdDrop[1]).fadeOut('slow');
			}
			);
		}
	});		
});