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

<div class="white page index">
<!-- search Section tart here -->
	<h3>Departments</h3>  
		<a id="various2" class="button" href="<?php echo SITE_HTTP_URL?>dashboard/addEditDepartment">+&nbsp;Create another Department</a><p>&nbsp;</p>
		<!-- search Section tart here -->
		<!-- Inner Content List start -->
		<div class="listingContent" id="content_departments">			
		</div>
		<!-- Inner Content List end -->		
</div>
	