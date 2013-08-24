<script>
$(document).ready(function() 
{   
	$("a#addUser").fancybox({				 
				ajax : {
				type	: "GET"
				
				}
			});			
	//using random number to resolve cache issue
	  
 			$("#users").fcbkcomplete({
            json_url: siteUrl+"yeargroups/getUserToAssignInGroup/"+$('#groupId').val()+"/",
            cache: false, 
            filter_selected: true,
            addontab: true,                     
            height: 4,
            width:"350",
            loaderDiv: "containerLoaderBox"        
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
		 //$("#containerLoader").empty().html(loader);
		$.post( siteUrl+"yeargroups/assignUserToGroup/"+$('#groupId').val(), $('#assignUsersForm').serialize(),
			function(data)
			{
				//TO alert the success message
				if("undefined" == typeof(data.success))
				{
					var err = data.error.toString();
					$('#msgDiv').empty().html(err).show();
				}
				else
				{		
					var err = data.success.toString();
					err+="<p><a onclick='closeWindow();' href='javascript:void(0);'>Close</a></p>";
					$('#msgDiv').empty().html(err).show();					
					$('#contentDiv').hide();
					setTimeout("closeWindow()",5000);	
				}
			},"json"
		);
	}
	return false;
}
function closeWindow()
{
	if($('#fancybox-wrap').css('display') == "block")
	{
		$.fancybox.close();
		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
		loadPiece(siteUrl+"yeargroups/listStudentsAjax/"+$('#classgroupid').val()+"/?rand="+randomnumber,"#content_yeargroups");
	}
 }
</script>
<div class="width100per" style="width:340px;">
	<div id="msgDiv" style="display:none;">
		
	</div>
	<div id="contentDiv">
		<form action="" name="assignUsersForm" id="assignUsersForm" method="POST" onsubmit="return addUserNow();">
		
		 <h2>Assign student to group</h2>
		 <p>&nbsp;</p>
		 
		 <div class="width100per">Note: Enter the keyword to search users
			 <p>
				 <select id="users" name="users">
		 
				</select>
			</p>
		</div>
		<p id="showAddMore" style="display:none;">No search records found</p>
		
		<p style="margin-top:5px;">Need a Student account? <a href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/student/0/<?php echo $groupid;?>" id="addUser" class="edit">Click Here</a> to add to one.</p>
		
		<p style="margin-top:5px;">
			<input type="submit" name="assignUsers" id="assignUsers" value="Submit"/>
			<input type="button" name="assignUsersCancel" id="assignUsersCancel" value="Cancel" onclick="$.fancybox.close();"/>
	 
		</p>
		<div id="containerLoaderBox"></div>
		<p>&nbsp;</p>
		<input type="hidden" name="groupId" id="groupId" value="<?php echo $groupid;?>"/>
		
		</form>
	</div>
</div>