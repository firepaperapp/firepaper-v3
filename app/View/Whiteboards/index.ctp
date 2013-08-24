<script>
$(document).ready(function(){
		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   		loadPiece(siteUrl+"whiteboards/listWhiteboardAjax/?rand="+randomnumber,"#content_writeboard");
});
</script>


<div class="activity">
	<div class="index">
		<div style="float:right">
			<a href="<?php echo SITE_HTTP_URL?>whiteboards/addEditBoard/" class="edit">Add New White Board</a>
		</div>
		<h3>Whiteboards</h3>
		<div id="msgdiv" class="success" style="display:none;"></div>
		<?php
		if($this->Session->check('Message.flash'))
		{?>
		<div class="essage errorServer">
			<div id="flashmsg" class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
		<?php }
		?>
		<div class="activity-panel-wrapper">
			<div class="activity-panel">				
		  		<!-- Inner Content List start -->
				<div class="listingContent" id="content_writeboard">
				</div>
				<!-- Inner Content List end -->
			</div>
		</div>
	</div>
</div>
 
