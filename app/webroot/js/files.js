$(function() 
{
 	$(".file-name a").hover(function() {
	$(this).next("em").stop(true, true).animate({opacity: "show", top: "-24"}, "slow");
	}, function() {
	$(this).next("em").animate({opacity: "hide", top: "-14"}, "fast");
	});
 

   /*$(".commentbox").editable(siteUrl+"files/saveParameters/comment/",
    {
        indicator : "<img src='img/indicator.gif'>",
        type   : 'textarea',
        submitdata: { _method: "put" },
        cssclass:'formbox',
        callback:getData,
        select : true,
        submit : 'Save',
        cancel : 'cancel',
        event : 'manclick.editable',
        cols:40,
        rows : 4
        }
	);        
    $(".commentboxlink").click(function()
	    {
	    	var id = $(this).attr('id');
	        $(".commentbox").hide();
            $("#commentbox_"+id).show();
            $("#commentbox_"+id).trigger('manclick.editable');
	    }
    );*/
   fadeErrorMessage('essage');
   
   $(".commentboxlink").click(function()
   {	
    
   		var myId = $(this).attr('id');
   		
   	 	 if($("#comment_"+myId).css("display") == "block")
	     {
    	 	$("#comment_"+myId).hide("slow");
	     	
	     }
	     else
	     {
	     	
	     	loadPiece(siteUrl+"files/getFileComments/"+myId,"#comment_"+myId);
	     	$("#comment_"+myId).show("slow");   	
	     }
	   	 		
   		 
   }
   );
   $(".addcommentlink").click(function(){
   	
   		var id = $(this).attr('id');
   		//$(".addcomment").hide();    		  		
   		$("#"+id+"_box").find("textarea").val("");
   		$("#"+id+"_box").slideToggle();
   		
   });
    $(".tagboxlink").click(function()
	    {
	    	var id = $(this).attr('id');
	        $(".tagbox").hide();
	        $(".addcomment").hide();
            $("#"+id+"_tag").show();
            $("#"+id+"_tag").trigger('manclick.editable');
	    }
    );
   
     $(".tagbox").editable(siteUrl+"files/saveParameters/tags",
     {
     	    indicator : loader,
            type   : 'text',
            submitdata: { _method: "put" },
            select : true,
            submit : 'Submit',
            cancel : 'Cancel',
            event : 'manclick.editable',
            callback: getDataTag
     }
    );
	$(".editcategory").editable(siteUrl+"files/saveParameters/category",
	{ 
		indicator : loader,
        loadurl : siteUrl+"files/getCategories/?v="+Math.floor(Math.random()*101),
		type   : "select",
		cssclass : "chek",
		 submit : 'Submit',
            cancel : 'Cancel',
		style  : "inherit",
		callback: updateCategoryEdit,
        onsubmit: checkNotEmpty

    });
	$(".addcategory").editable(siteUrl+"files/saveParameters/addcategory",
     {
            indicator : loader,
            type   : 'text',
            submitdata: { _method: "put" },
			placeholder: "  ",			 
		    submit : 'Submit',
            cancel : 'Cancel',
            
            height:'20px',
            event : 'manclick.editable',
            callback: updateCategory,
            onsubmit: checkNotEmpty
     }
    ); 
     $(".addcategorylink").click(function()
	    {  
	    	var id = $(this).attr('id');
	    //	$(".editcategory").tirgger("manclick.reset");
	        $(".addcategory").hide();
            $("#"+id+"_box").show();
            $("#"+id+"_box").trigger('manclick.editable');
	    }
    );
   /* $(".files-container").sortable({
		stop:function(event,ui)	
		{
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
			var ex = "";
			ex = "&page="+$('#page').val()+"&limit="+$('#limit').val()+"&total="+$('#total').val();
			var result = $('.files-container').sortable('serialize')+ex;
		 	//We will call ajax to save the order	
		 	$('#fancybox-overlay1').show();
		 	$.post(siteUrl+"files/saveFilesOrdering/"+"/?rand="+randomnumber, result, function(data)
			{
	           $('#fancybox-overlay1').hide();
	  		});
		}
	});*/
	//$(".files-container").disableSelection();
	$('.viewDetails').click(function() {
		 
		  var myId = $(this).attr('id');	  
		  $('.versions').not($('#versions'+myId)).toggle(false);
		 
		  $('#versions'+myId).animate({ 
		  		opacity: 'toggle',  "height": "toggle"}, 500, function() {
		    // Animation complete.
		     if( $('#versions'+myId).css("display") == "block")
		     {
		     	 var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
		     	loadPiece(siteUrl+"files/getSubFiles/"+myId+"?rand="+randomnumber,"#revisions"+myId);
		     }
		     else
		     {
		     	
		     }
		  });
		 
		  //$('.version').not('span.title_1').
	});
	
//	$(".deleteFile").each(function(){
	
		$("a.deleteFile").fancybox({				 
			ajax : {
			type	: "GET"
			}
		});
		$("a.deleteFileVersion").fancybox({				 
			ajax : {
			type	: "GET"
			}
	});
//	});
	 
	$(".dragFileForProject").draggable({helper:"clone" });
	 
   	$(".upload-link .uploadfilterfile").live("click", function(){
		fileId = $(this).attr('id');
		file = fileId.split("_");
		formId = 'form_'+file[1];
		
		$.ajax({
			type: "POST",
			url: $("#"+formId).attr('action'),
			dataType: "json",
			data: $("#"+formId).serialize(),
			complete: function(data){
				//var json = JSON.parse(data); // create an object with the key of the array
				alert(data.toSource());
			},
			success: function(data){
				//var json = JSON.parse(data); // create an object with the key of the array
				alert(data.toSource()); // where html is the key of array that you want, $response['html'] = "<a>something..</a>";
			},
			     error: function(data){
				//var json = JSON.parse(data);
				//alert(json.error);
			}
		});
		
	}) 
    
});
function updateCategoryEdit(data)
{ 
	 
	$('#add'+($(this).attr('id')+"_box_span")).empty().html(data);	
	$(this).empty().html('Edit');
 
	if($("#main_category_id").val()!=0 && $("#main_category_id").val()!='')
	{
		window.location = siteUrl+"files/getFiles/";
	}
	else
		loadPiece(siteUrl+"files/getFilesInner/","#content_files");
}
function updateCategory(data)
{  
	$('#'+($(this).attr('id')+"_span")).empty().html(data);
	$(this).hide();
	loadPiece(siteUrl+"files/getFilesInner/","#content_files");
	var randomnumber=Math.floor(Math.random()*101);
    $.get(siteUrl+"files/getMyCategories/?rand="+randomnumber,   function(data)
	{	
			$("#nav1").empty().html(data);
			 
	});
}
function getDataTag(data)
{  
	
	$('#'+($(this).attr('id')+"_span")).empty().html(data);
	$(this).hide();
	
}
function addComment(f)
{		
		if($.trim($("#addcommenttext_"+f).val())=="")
		{
			alert("Please enter comment.");
		}
		else
		{
			$("#submitComment_"+f).empty().html(loader);
		    var randomnumber = Math.floor(Math.random()*101);//using random number to resolve cache issue
		    $.post(siteUrl+"files/getFileComments/"+f+"/?rand="+randomnumber, {comment:$("#addcommenttext_"+f).val()}, function(data)
			{
			  $("#submitComment_"+f).empty().html();
			   $("#addcomment_"+f+"_box").slideUp();	
	           innerContentCall('comment_'+f, data);           
	           $("#comment_"+f).show("slow");
	           
	  		});
			//$("div.errorJs").hide();
			//$("div.errorServer").hide();
			return false; 
		}
}
//Used to delete the revison of the file
function delSubFile(mainFile, subFile)
{ 
	if(confirm("Are you sure you want to delete this file?"))    
	{
		loadPiece(siteUrl+"files/getSubFiles/"+mainFile+"/?d="+subFile+"&","#revisions"+mainFile);
	}
}
function checkNotEmpty()
{
 
	 if($.trim(document.editinplaceform.value.value) == "")    
	{
		alert("Please select any category.");
		return false;
	}
}
function closeWindow()
{
	$.fancybox.close();
	//we will refresh the users listing for a department
	var Did = '#'+$('#viewType').val()+'View_'+$('#departmentId').val()+"_box";
	$(Did).empty().html(loader);
		//using random number to resolve cache issue
	var randomnumber=Math.floor(Math.random()*101);
    $.get(siteUrl+"dashboard/getDepartmentUser/"+$('#departmentId').val()+"/"+$('#viewType').val()+"/?rand="+randomnumber,   function(data)
	{	
			$(Did).empty().html(data);
			 
	});
}