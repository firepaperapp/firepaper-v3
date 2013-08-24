<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script>
$(document).ready(function() 
{ 
	$("#addcoadmin").fancybox({ 
				ajax : {
				type	: "GET",
				}
			});

	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	loadPiece(siteUrl+"users/listCoadminsAjax/?rand="+randomnumber,"#content_coadmin");
});
</script>

<div class="activity">
	<div class="index">
		<h3>Co-Admins</h3>
	 		<div class="upload-container" style="height:25px;">	
				<a id="addcoadmin" href="<?php echo SITE_HTTP_URL?>users/addNewCoadmin" class="add-btn">Add New Co-Admin</a>
			</div>
			<div class="clr-spacer"></div>
 		 
				<!-- Inner Content List start -->
					<div class="listingContent" id="content_coadmin">
					</div>
				 
				<!-- Inner Content List end -->
			 
	</div>
</div>