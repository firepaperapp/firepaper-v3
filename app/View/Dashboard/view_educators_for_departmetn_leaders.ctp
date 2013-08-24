<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   
<script>

$(document).ready(function() 
{  
	$("a#addUser").fancybox({				 
				ajax : {
				type	: "GET"
				
				}
			});
			
	//using random number to resolve cache issue
  	var randomnumber=Math.floor(Math.random()*101);
	$("#users").fcbkcomplete({
        json_url: siteUrl+"dashboard/getEducatorsForDepartemtnLeaders/"+$('#departmentId').val()+"/?rand="+randomnumber,
        cache: false, 
        filter_selected: true,
        addontab: true,                     
        height: 4,
        maxitems: 1,
        width:"350"          
      });		 
        
});
function replaceLeader()
{ 
	if(null == $('#users').val() && $("#noLeader:checked").length == 0)
	{
		alert("Please select any user first");
	}
	else if(null != $('#users').val() && $("#noLeader:checked").length == 1)
	{
		alert("Please choose only one option.");
	}
	else
	{
		$("#containerLoader").empty().html(loader);
		$.post( siteUrl+"dashboard/viewEducatorsForDepartmetnLeaders/"+$('#departmentId').val(), $('#assignUsersForm').serialize(),
			function(data)
			{
				//TO alert the success message
				if("undefined" == typeof(data.success))
				{
					var err = data.error.toString();
					$('#msgDiv').empty().html(err).show();
				}
				else
				{	var to = data.to;	
					var err = data.success.toString();
					var closewindow = "closeWindow("+to+");";
					err+="<p><a onclick="+closewindow+" href='javascript:void(0);'>Close</a></p>";
					$('#msgDiv').empty().html(err).show();					
					$('#contentDiv').hide();
					setTimeout("closeWindow("+to+")",5000);	
				}
			},"json"
		);
	}
	return false;
}
function closeWindow(to)
{
	if($('#fancybox-wrap').css('display') == "block")
	{
		$.fancybox.close();
		var randomnumber=Math.floor(Math.random()*101);
	 
		var Did = '#educator'+'View_'+$('#departmentId').val()+"_box";
		var url = siteUrl+"dashboard/getDepartmentUser/"+$('#departmentId').val()+"/educator/?rand="+randomnumber;
		 
		$(Did).empty().html(loader);
		//using random number to resolve cache issue		
	    $.get(url, function(data)
		{
			$(Did).empty().html(data);
				 
		});
	}
}
</script> 
<div class="width100per" style="width:340px;">
	<div id="msgDiv" style="display:none;">
		
	</div>
	<div id="contentDiv">
		<form action="" name="assignUsersForm" id="assignUsersForm" method="POST" onsubmit="return replaceLeader();">
		
		 <h2>Assign leader to department</h2>
		 <p>&nbsp;</p>
		 
		 <div class="width100per">Note: Enter the keyword to search educators
			 <p>
				 <select id="users" name="users">
		 
				</select> 
			</p>
			<p><b>OR</b></p>
			<p><input type="checkbox" name="noLeader" id="noLeader" value="1">&nbsp;No Department leader</p>
		</div>
		<p>&nbsp;</p>
		<p>
			<input type="submit" name="assignUsers" id="assignUsers" value="Submit"/>
			<input type="button" name="assignUsersCancel" id="assignUsersCancel" value="Cancel" onclick="$.fancybox.close();"/>
		 
		</p>
		<div id="containerLoader"></div>
		<p>&nbsp;</p>
		<input type="hidden" name="departmentId" id="departmentId" value="<?php echo $departmentId;?>"/>  
		</form>
	</div>
</div>
