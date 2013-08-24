
<script>
$('.viewDetails').click(function() {
		 
		  var myId = $(this).attr('id');	
		  var Idnoarr = myId.split("_"); 

		  $('.versions').not($('#versions'+Idnoarr[1])).toggle(false);
		  if($('#versions'+Idnoarr[1]).css("display") == "none")
		  {
	 	   var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   			loadPiece(siteUrl+"whiteboards/listBoard/"+Idnoarr[1]+"/?rand="+randomnumber,"#versions"+Idnoarr[1]);
   			$('#versions'+Idnoarr[1]).show("slow");
		  }
		  else
		  {
		  	$('#versions'+Idnoarr[1]).hide("slow");
		  }
	});

function confirmdel(conid)
{
	var con = confirm("Deleting the whiteboard will also delete all subsequent updated new versions.Are you sure you want to delete? ");
	//$("#flashmsg").empty().hide();
	if(con==true)
	{	$("#loaderdiv").empty().html(loader).show();
		$.post(siteUrl+'Whiteboards/deleteWhiteboard/', {'whbid':conid},function(data){
			
			$("#loaderdiv").empty().hide();
	 		
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   			loadPiece(siteUrl+"whiteboards/listWhiteboardAjax/?rand="+randomnumber,"#content_writeboard");
		//	$("#msgdiv").html(data).show();
			});
	}
}
</script>
<div id="loaderdiv" style="display:none;"></div>

 
 <?php
	if(is_array($data) && count($data)>0)
	{
		foreach($data as $content)
		{
	 
		?>
		<div class="file-doc-container"  class="ui-state-default" id="main_<?php echo $content['Whiteboard']['id'];?>">

			<div class="file-name">
						<a href="<?php echo SITE_HTTP_URL?>whiteboard/<?php echo $content['Whiteboard']['id']?>" id="tool-tip"><?php echo ucfirst(Sanitize::html($content['Whiteboard']['title']))?></a> <small><? print(Date("dS F Y", strtotime($content['Whiteboard']['created']))); ?> at <? print(date("H:ia", strtotime($content['Whiteboard']['created']))); ?></small>
						
			</div>
				
			<a href="<?php echo SITE_HTTP_URL?>whiteboards/addEditBoard/<?php echo $content['Whiteboard']['id']?>" class="btn viewDetails" id="<?php echo $content['Whiteboard']['id'];?>">Edit</a>

			<a href="javascript:void(0);" class="btn viewDetails" id="viewdetail_<?php echo $content['Whiteboard']['id'];?>">View Revisions</a>

			<a href="javascript:void(0);" onclick="confirmdel(<?php echo $content['Whiteboard']['id']?>)" class="btn deleteFile">Delete</a>
			<div class="clr"></div>

			
		</div>

		<div class="versions" id="versions<?php echo $content['Whiteboard']['id'];?>" style="display:none;padding-left:10px;">
  
		</div>
<!--		<div>
			<a href="<?php echo SITE_HTTP_URL?>whiteboards/addEditBoard/<?php echo $content['Whiteboard']['id']?>">Edit</a> | <a style="cursor:pointer;" id="delcont" onclick="confirmdelete(<?php echo $content['Whiteboard']['id']?>)">Delete</a>
		</div>-->
	
		<?php 
		} 
	}
	else 
	{
		echo '<p>'.ERR_RECORD_NOT_FOUND.'</p>';
	}
echo "<br>";
		$this->Paginator->options(array('url' => $this->passedArgs));
		echo $this->element("pagination/ajax_pagination");
?>