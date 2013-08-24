<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>
<script>

$(document).ready(function(){

	$("#groups").fcbkcomplete({
            json_url: siteUrl+"announcements/getGroups/",
            filter_selected: true,
            cache: false, 
            addontab: true,                     
            filter_hide: true,
            height: 4,
            width:"350"          
          });
    $("#yeargroups").fcbkcomplete({
            json_url: siteUrl+"announcements/getGroups/year",
            filter_selected: true,
            cache: false, 
            addontab: true,                     
            filter_hide: true,
            height: 4,
            width:"350"          
          });
          
    $("#students").fcbkcomplete({
            json_url: siteUrl+"announcements/getStudents/",
            filter_selected: true,
            filter_hide: true,
            cache: false, 
            addontab: true,                     
            height: 4,
            width:"350"          
          });

});

function addAnnouncementNow()
{	
	if($.trim($('#announce-text').val())=="")
	{
		alert("Please enter announcement");
		return false;
	}
	if(null == $('#groups').val() && null == $('#students').val())
	{
		alert("Please select any group or student first");
		return false;
	}
	
	else
	{
		$("#containerLoader").empty().html(loader);
		$.post( siteUrl+"announcements/sendAnnouncement/", $('#announcementForm').serialize(),
			function(data)
			{
				//TO alert the success message
				
				$("#containerLoader").empty().hide();
				$("#announce-text").val('');

				var dataArr = data.split('@@@');
		
				$("#announce_li").show();
				//$("#togroupid").html(dataArr[0]);
				$("#msgdiv").html(dataArr[1]).show();
				$("#annc_msg").html(dataArr[2]);
			}
		);
	}
	return false;
}

</script>
<div id="msgdiv" style="display:none;" class="success"></div>
<div id="announcements-wrapper">
<div id="announcements">
	<p class="heading">Announcements</p>
	<ul>
		<li id="announce_li" style="display:none;">
			<span id="togroupid" style="margin-right:10px;"></span>
			<span style="font-weight:normal;" id="annc_msg"></span>
		</li>
	  	<!--
		<input name="grousp-add" type="text" value="Groups" /><input name="group-add-btn" type="button" value="Add" /> <a class="group-tab" href="">Maths dept x</a>-->
 </ul>
	<form action="" name="announcementForm" id="announcementForm" method="POST" onsubmit="return addAnnouncementNow();"> 
		<p>Write an announcement</p>
		<div class="text-column">
		<textarea name="announce-text" id="announce-text" cols="" rows="" style="width:98%;" ></textarea>
		</div>
		<div class="clr"></div>
		<div class="input-column">
			<p>Year Groups</p>
 	 		<select id="yeargroups" name="yeargroups" style="width:150px;"></select>
 	 		</div>
 	 		<div class="input-column">
			<p>Class Groups</p>
 	 		<select id="groups" name="groups" style="width:150px;"></select>
 	 	</div>
		<div class="input-column">
 	 		<p>Students</p>
 	 		<select id="students" name="students" style="width:150px;"></select>
 	 		
			<p id="showAddMore" style="display:none;">No records found.</p>	
 	 	</div>
		<input type="submit" name="assignUsers" id="assignUsers" class="btn" value="Submit"/>
 	 </form>
	<div id="containerLoader"></div>
	<div class="clr"></div>
	</div><!-- end announcements -->
	
</div>		
 	 		
 	 	
		
 		
	