<link type="text/css" href="<?php echo CSS_PATH?>jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<script src="<?php echo JS_PATH?>jquery.jeditable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<!-- PL Upload // -->
<style type="text/css">@import url(<?php echo JS_PATH; ?>plupload/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
<script type="text/javascript" src="<?php echo JS_PATH; ?>plupload/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	showFiles();
});

function showFiles() {
	loadPiece("<?php echo SITE_HTTP_URL;?>files/getFilesInner/<?php echo $id;?>", "#content_files");
}


</script>

<div class="white page index">
			<input type="button" value="Upload Files" class="button" onclick="showUploader()">
			
			<form id="files-upload-form" style="display: none">
		    	<div id="uploader"></div>
			</form>
			
			<div id="files-categories-box" class="files-categories-box">
				<h4>Filters</h4>
				<ul><?php echo $this->requestAction("/files/getMyCategories"); ?></ul>
			</div>
			
			<table id="files">
			</table>
			
			<div id="content_files">
			</div>
</div> <! -- End white -->


