
<script>
$('.viewDetails').click(function() {
		 
		  var myId = $(this).attr('id');	
		  var Idnoarr = myId.split("_"); 

		  $('.versions').not($('#versions'+Idnoarr[1])).toggle(false);
		  $('#versions'+Idnoarr[1]).toggle('slow', function() {
		    // Animation complete.
		  });
		  //$('.version').not('span.title_1')
	
			  var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   			loadPiece(siteUrl+"whiteboards/listBoard/"+Idnoarr[1]+"/?rand="+randomnumber,"#versions"+Idnoarr[1]);
	});

function confirmdel(conid)
{
	var con = confirm("Deleting the whiteboard will also delete all subsequent updated new versions.Are you sure you want to delete? ");
	//$("#flashmsg").empty().hide();
	if(con==true)
	{	$("#loaderdiv").empty().html(loader).show();
		$.post(siteUrl+'Whiteboards/deleteWhiteboard/', {'whbid':conid},function(data){
			
			$("#loaderdiv").empty().hide();
			alert(data);
			
			var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   			loadPiece(siteUrl+"whiteboards/listContentAjax/?rand="+randomnumber,"#content_writeboard");
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
		{  ?>
		<div class="file-doc-container"  class="ui-state-default" id="main_<?php echo $content['Whiteboard']['id'];?>">

			<div class="file-name">
						<a href="<?php echo SITE_HTTP_URL?>whiteboards/showContent/<?php echo $content['Whiteboard']['id']?>" id="tool-tip"><?php echo ucfirst(Sanitize::html($content['Whiteboard']['title']))?></a> <em></em> 
						
			</div>
				
			<a href="<?php echo SITE_HTTP_URL?>whiteboards/addEditBoard/<?php echo $content['Whiteboard']['id']?>" class="btn viewDetails" id="<?php echo $content['Whiteboard']['id'];?>">Edit</a>

			<a href="#" class="btn viewDetails" id="viewdetail_<?php echo $content['Whiteboard']['id'];?>">View Details</a>

			<a href="#" onclick="confirmdel(<?php echo $content['Whiteboard']['id']?>)" class="btn deleteFile">Delete</a>
			<div class="clr"></div>

			
		</div>

		<div class="versions" id="versions<?php echo $content['Whiteboard']['id'];?>">



			<?php // echo SITE_HTTP_URL?>whiteboards/listBoard/<?php //echo $content['Whiteboard']['id']?>


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