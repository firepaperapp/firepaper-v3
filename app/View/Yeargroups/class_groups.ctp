<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function(){ 
                $("#addstudent").fancybox({
			ajax : {
			type	: "GET",
			}
		});

		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   	    loadPiece(siteUrl+"yeargroups/listStudentsAjax/"+$('#classgroupid').val()+"/?rand="+randomnumber,"#content_yeargroups");

	//$("#reset").click(function(){
		//$("#reset").hide();
	//});

   	 });
</script>
	<div class="index files white">
		
	 	<!-- search Section start here -->
 		<?php if($showbox=="Y"){ echo $this->requestAction("/yeargroups/addyeargroup/$classgroupid");} 
		else {
		echo $this->element('common/search'); }
		?>
		<div class="clr-spacer"></div>
		<div id="containerLoader" style="color:red;"></div>
 		
  		<!-- Inner Content List start -->
		<div class="listingContent" id="content_yeargroups">
		</div>
		<!-- Inner Content List end -->
		<input type="hidden" name="classgroupid" id="classgroupid" value="<?php echo $classgroupid;?>">
		<input type="hidden" name="showadduserid" id="showadduserid" value="<?php echo $showadduser;?>">
		<input type="hidden" name="calledAction" id="calledAction" value="listStudentsAjax/<?php echo $classgroupid;?>" />
	</div>
