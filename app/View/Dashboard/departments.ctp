<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>department.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function()
	  {
	  	$("#various2").fancybox({				 
			ajax : {
			type	: "GET"
			}
		});
   	 		getInnerList();
    	}
    );
   
</script>

<div class="white files index">
<!-- search Section tart here -->
	<div class="btn-container">
		<div class="btn-holder">
		<a id="various2" class="submit" href="<?php echo SITE_HTTP_URL?>dashboard/addEditDepartment">Create a Department</a>
		</div>
		<div id="files-categories-box" class="files-categories-box">
			<h4>Tip:<italic>After you create a department, add a subject</italic></h4>
		</div>
	</div>
		<!-- search Section tart here -->
		<!-- Inner Content List start -->
		<div class="listingContent" id="content_departments">			
		</div>
		<!-- Inner Content List end -->		
</div>
	