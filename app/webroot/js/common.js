var loader = "<div class='loader'><img src='"+siteImagesUrl+"ajax-loader.gif' /><p>Loading...</p></div>";
function loadPiece(href,divName) {
		
		 var timestamp = Number(new Date()); //alert(timestamp);
		 $(divName).empty().html(loader);
	     $.get(href+"?v="+timestamp, {cache:false}, function(data){
	     	$(divName).empty().html(data);
	        var divPaginationLinks = divName+" #pagination a";
	        $(divPaginationLinks).click(function() {     
	            var thisHref = $(this).attr("href");	            
	            loadPiece(thisHref,divName);
	            return false;
	        });
	         $('.paginatorSort a').click(function() {     
	        	var thisHref = $(this).attr("href");
	            loadPiece(thisHref,divName);
	            return false;
	        });	 
	        
	    });
}
function confirmDeletion()
{
	var st;
	if(confirm("Are you sure you want to delete this record?"))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function innerContentCall(divId,data)
{
	 $('#'+divId).empty().html(data);
	  var divPaginationLinks = "#"+divId+" #pagination a";
     $(divPaginationLinks).click(function() {
        var thisHref = $(this).attr("href");
        loadPiece(thisHref,'#'+divId);
        return false;
    });
}
function fadeErrorMessage(msgClass)
{
	$('.'+msgClass).delay(5000).fadeOut('slow');
	return;
}
function showAddMore(errorDiv, data)
{
	if($('#'+errorDiv).length!=0)
	{
		//we will show add more container
		 
		if($(data).length == 0)
		{
			$('#'+errorDiv).show();
		}
		else
			$('#'+errorDiv).hide();
	}
}
function delTaskDoc(docId, viewDetail)
{	 
	 
	if(confirm("Are you sure you want to delete this docuemnt?"))
	{	   	 
		$.post(siteUrl+"projects/delTaskDoc/",{'data[projectStudentTaskDoc][d]':docId},function(data){
			//TO alert the success message
			
			if("undefined" == typeof(data.success))
			{
			 	var err = data.error.toString();
				alert(err);
			}
			else
			{	 
				var msg = data.success;
				if("undefined" == typeof(viewDetail))
					$("#a_"+docId).parent("p").fadeOut("slow"); 				
				else
					$("#a_v"+docId).parents("div.encloseJs").fadeOut("slow"); 				
			}				 
		},"json");
		return false; 	
	}
}
function getProjectInDept(dept_id)
{
	$.get(siteUrl+"projects/getLatestProjects/"+dept_id,function(data)
	{
		$("#getLatestProjects").empty().html(data);
	}
	);
}