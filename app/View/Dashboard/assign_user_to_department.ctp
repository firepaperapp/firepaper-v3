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
            json_url: siteUrl+"dashboard/getUserToAssign/"+$('#viewType').val()+"/"+$('#departmentId').val()+"/"+$('#subjctID').val()+"/?rand="+randomnumber,
            cache: false, 
            filter_selected: true,
            addontab: true,                     
            height: 4,
            width:"350"          
          });		 
        
});
function addUserNow()
{
	if(null == $('#users').val())
	{
		alert("Please select any user first");
	}
	else
	{
		$("#containerLoader").empty().html(loader);
		$.post( siteUrl+"dashboard/assignUserToDepartment/"+$('#viewType').val()+"/"+$('#departmentId').val()+"/"+$('#subjctID').val(), $('#assignUsersForm').serialize(),
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
		if(to==1) // 1 = educators 
		{
			//we will refresh the users listing for a department
			var Did = '#'+$('#viewType').val()+'View_'+$('#departmentId').val()+"_box";

			var url = siteUrl+"dashboard/getDepartmentUser/"+$('#departmentId').val()+"/"+$('#viewType').val()+"/?rand="+randomnumber
		}
		else
		{
			var Did = '#subjectEducatorView_'+$('#subjctID').val()+"_box";
			var url = siteUrl+"dashboard/getDepartmentUser/"+$('#departmentId').val()+"/"+$('#viewType').val()+"/"+$('#subjctID').val()+"/?rand="+randomnumber;
		}
		$(Did).empty().html(loader);
			//using random number to resolve cache issue
		
	    $.get(url, function(data)
		{
			$(Did).empty().html(data);
				 
		});
	}


/*	if($('#fancybox-wrap').css('display') == "block")
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
	}*/
}
</script> 
<div class="width100per" style="width:340px;">
	<div id="msgDiv" style="display:none;">
		
	</div>
	<div id="contentDiv">
		<form action="" name="assignUsersForm" id="assignUsersForm" method="POST" onsubmit="return addUserNow();">
		
		 <h2>Assign user to department</h2>
		 <p>&nbsp;</p>
		 
		 <div class="width100per">Note: Enter the keyword to search users
			 <p>
				 <select id="users" name="users">
		 
				</select>
			</p>
		</div>
		<p>&nbsp;</p>
		<p>
			<input type="submit" name="assignUsers" id="assignUsers" value="Submit"/>
			<input type="button" name="assignUsersCancel" id="assignUsersCancel" value="Cancel" onclick="$.fancybox.close();"/>
			<?php if($subjectID <= 0 ) {?>
			<p id="showAddMore" style="display:none;">No records found. <a href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/<?php echo $viewType;?>/<?php echo $departmentId;?>" id="addUser">Click Here</a> to add another <?php echo $viewType;?></p>
			<?php } ?>
		</p>
		<div id="containerLoader"></div>
		<p>&nbsp;</p>
		<input type="hidden" name="departmentId" id="departmentId" value="<?php echo $departmentId;?>"/>
		<input type="hidden" name="subjctID" id="subjctID" value="<?php echo $subjectID;?>"/>
		<input type="hidden" name="viewType" id="viewType" value="<?php echo $viewType;?>"/>
		</form>
	</div>
</div>
