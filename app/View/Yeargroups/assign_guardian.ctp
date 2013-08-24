<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   
<script>

$(document).ready(function() 
{  
	$("a#addGuardianUser").fancybox({				 
				ajax : {
				type	: "GET"
				
				}
			});
			
	//using random number to resolve cache issue
  	var randomnumber=Math.floor(Math.random()*101);
	$("#users").fcbkcomplete({
        json_url: siteUrl+"yeargroups/getGuradianUser/"+"/?rand="+randomnumber,
        cache: false, 
        filter_selected: true,
        addontab: true,                     
        height: 4,
        loaderDiv:'containerLoaderPopup',
        maxitems: 1,
        width:"350"          
      });		 
        
});
function addGuardian()
{ 
	if(null == $('#users').val())
	{
		alert("Please select any user first");
	}
	else
	{
		$("#containerLoaderPopup").empty().html(loader);
		$.post( siteUrl+"yeargroups/assignGuardian/"+$('#studentId').val(), $('#assignUsersForm').serialize(),
			function(data)
			{
				$("#containerLoaderPopup").empty().html();
				//TO alert the success message
				if("undefined" == typeof(data.success))
				{
					var err = data.error.toString();
					$('#msgDiv').empty().html(err).show();
				}
				else
				{	
					
					var gardid = "#gname_"+$("#studentId").val(); //alert(gardid); alert(msgarr[2]);
					
					$(gardid).empty().html(data.link).show();
					
					var addgaurdId = "#addgaurdian_"+$("#studentId").val();
					$(addgaurdId).hide(); //hiding the add gaurdian link
		 			//	setTimeout("movepage()",5000);	
					$.fancybox.close();	
				}
			},"json"
		);
	}
	return false;
}
</script> 
<div class="width100per" style="width:340px;">
	<div id="msgDiv" style="display:none;">
		
	</div>
	<div id="contentDiv">
		<form action="" name="assignUsersForm" id="assignUsersForm" method="POST" onsubmit="return addGuardian();">
		
		 <h2>Assign guardian to student</h2>
		 <p>&nbsp;</p>
		 
		 <div class="width100per">Note: Enter the keyword to search users
			 <p>
				 <select id="users" name="users">
		 
				</select> 
			</p>
	 	</div>
		<p>&nbsp;</p>
		<p id="showAddMore" style="display:none;">No search records found</p>
		
		<p style="margin-top:5px;">Need a Guardian account?<a href="<?php echo SITE_HTTP_URL?>yeargroups/newUser/<?php echo $studentId;?>" id="addGuardianUser" class="edit">Click Here</a> to add to one.</p>
		
		<p style="margin-top:5px;">
			<input type="submit" name="assignUsers" id="assignUsers" value="Submit"/>
			<input type="button" name="assignUsersCancel" id="assignUsersCancel" value="Cancel" onclick="$.fancybox.close();"/>
		 
		</p>
		<div id="containerLoaderPopup"></div>
		<p>&nbsp;</p>
		<input type="hidden" name="studentId" id="studentId" value="<?php echo $studentId;?>"/>  
		</form>
	</div>
</div>
