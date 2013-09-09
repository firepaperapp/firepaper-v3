<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function(){

		loadPiece(siteUrl+"Projects/listArchivedproject/<?php echo $draft;?>","#content_archievedProjects");
	 
    });
   
</script>
	 <div class="index">
	 
	 	<!-- search Section start here -->
	 	 <h3><?php
	 		if(!isNull($draft))
	 		{
	 			echo "Drafted Projects";
	 		}
	 		else 
	 		{
	 			echo "Archived Projects";
	 		}
	 		?>
		 </h3>   
		<!-- search Section tart here -->
		<!-- Inner Content List start -->
		<div class="page-wrapper">
        	<div class="page"> 
				<div class="listingContent" id="content_archievedProjects">
					
				</div>
			</div>
		</div>
		<!-- Inner Content List end -->
	</div>
<input type="hidden" name="draft" id="draft" value="<?php echo $draft;?>" />