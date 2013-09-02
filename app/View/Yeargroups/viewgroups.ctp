<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script type="text/javascript">
$(document).ready(function(){
               
		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
		$("#addstudent").fancybox({
			ajax : {
			type	: "GET",
			}
		});
		
   		loadPiece(siteUrl+"yeargroups/listYearGroupsAjax/"+$('#group_id').val()+"/?rand="+randomnumber,"#content_yeargroups");

			
});
</script>
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>

	<div class="index page white">
	<h3>Students</h3>
	<?php if($showbox=="Y"){ echo  $this->requestAction("/yeargroups/addyeargroup/".$group_id);} 
	else {?>

	<div class="upload-container">
	<?php
	echo $this->element('common/search'); 
	?></div>
	<?php
	}?>
	
	<div id="containerLoader" style="color:red;"></div>
	<div class="clr-spacer"></div>
  	<!-- Inner Content List start -->
	<div class="listingContent" id="content_yeargroups">
	</div>
	<!-- Inner Content List end -->  
	</div><!-- end rightcol -->
	<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>" />
	<input type="hidden" name="calledAction" id="calledAction" value="listYearGroupsAjax/<?php echo $group_id;?>" />
