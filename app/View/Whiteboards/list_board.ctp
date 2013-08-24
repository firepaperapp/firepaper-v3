<script>

function confirmdelete(conid)
{
	var con = confirm("Are you sure to delete updated version?");
	
	if(con==true)
	{	$("#loaderdiv").empty().html(loader).show();
		$.post(siteUrl+'Whiteboards/deleteWhiteboard/', {'whbid': conid},function(data){
			
			$("#loaderdiv").empty().hide();
			 
			//window.location= siteUrl+"Whiteboards/listContent/";
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
			$("#main_"+conid).fadeOut("slow");
   			 
			//$("#msgdiv").html(data).show();
			});
	}
}
</script>

<?php 
	if(count($recWB) > 0)
	{	
 		foreach($recWB  as $rec)
		{
?>			<div id="main_<?php echo $rec['Whiteboard']['id'];?>">			
	            
				<div class="file-bar-empty">
					<div class="file-name">					
						<a href="<?php echo SITE_HTTP_URL?>whiteboards/viewWhiteboard/<?php echo $rec['Whiteboard']['id']?>" id="tool-tip"><?php echo ucfirst(Sanitize::html($rec['Whiteboard']['title']))?></a> <small><? print(Date("dS F Y", strtotime($rec['Whiteboard']['created']))); ?> at <? print(date("H:ia", strtotime($rec['Whiteboard']['created']))); ?></small>
						
						<a href="<?php echo SITE_HTTP_URL?>whiteboards/addEditBoard/<?php echo $rec['Whiteboard']['id']?>"  class="edit deleteFileVersion" id="<?php echo $rec['Whiteboard']['id'];?>">Edit</a>

						<a onclick="confirmdelete(<?php echo $rec['Whiteboard']['id']?>)"" class="edit deleteFileVersion">Delete</a>

						
					</div>
					<div class="clr"></div>
		       </div>
		 </div> 
<?php 	
		}
	}
	else
	{
		echo ERR_RECORD_NOT_FOUND;
	}
?>


