function getInnerList()
{
	loadPiece(siteUrl+"dashboard/getDepartmentList/","#content_departments");
				
}
function deleteRecord(id)
{
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	if(confirmDeletion())
	{
	   $('#content_departments').empty().html(loader);
       $.get(siteUrl+"dashboard/getDepartmentList/?d="+id+"&rand="+randomnumber, function(data)
		{
 			innerContentCall('content_departments',data);
  		});
	}    	
}

function filterList(selectedTitle)
{ 	
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue	
	$('#content_departments').empty().html(loader);
	$.post(siteUrl+"dashboard/getDepartmentList/?"+"&rand="+randomnumber, 
	{title: selectedTitle}
	, function(data)
	{
			innerContentCall('content_departments',data);
		});
	//$("div.errorJs").hide();
	//$("div.errorServer").hide();
	return false;
}	