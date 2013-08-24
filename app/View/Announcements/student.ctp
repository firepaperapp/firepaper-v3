<script>
function closeAnnouncement()
{
	$("#containerLoader").empty().html(loader).show();

	$.post(siteUrl+"announcements/closeAnnouncement/",'',  function(data){ 	
		if($.trim(data)=="success")
		{
			$("#containerLoader").empty().hide();
			$("#announcements-wrapper").slideUp('slow');
		}
	});
}

</script>

<?php if($showHideAnnc=='Y')
{?>
<div id="containerLoader" style="display:none"></div>
<?php
	if(count($annnouncementRecorsds) > 0)
	{ ?>
		<div id="announcements-wrapper">
		<div id="announcements">
			<p class="heading">Announcements</p>
			<ul>
			<?php 	
				foreach($annnouncementRecorsds as $rec)
				{ 
					echo "<li>".$rec['ANC']['announcement']."</li>" ; 		
				}			
			?> 
			</ul>
			<a class = "close" href="#"  onclick="closeAnnouncement();">
			<img style="float:right;border:none;" src="<?php echo IMAGES_PATH; ?>close.png" ></a>
		</div>	<!-- end announcements -->
		</div>
<?php 	}  
		} //if ends
	?>
	
