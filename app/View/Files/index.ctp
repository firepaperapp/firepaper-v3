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

function showUploader() {
	if ($("#files-upload-form").css("display") == "none") {
		$("#files-upload-form").css("display", "");

		$("#files-upload-form").css("position", "absolute");
		$("#files-upload-form").css("width", "100%");
		
		function attachCallbacks(uploader) {
			uploader.bind('BeforeUpload', function(up) {
				up.settings.multipart_params.category_id = <?php echo (int) $id;?>
			});

	 		uploader.bind('Error', function(up, err, result) {
	 			try {
		 			var data = $.parseJSON(result.response);
		 			
		 			if (data.error) {
			        	alert(data.error);
			        } else {
			        	alert(result.response);
			        }
		        } catch(e) {
		        	alert(result.response);
		        }
		    });
		    
		    uploader.bind('FileUploaded', function(up, file, result) {
		    	try {
			    	var data = $.parseJSON(result.response);
			    	
			    	if (data.success) {
			    		// do nothing, see Upload Complete
			        } else if (data.error) {
			        	// display the error message
			        	alert(data.error)
			        } else {
			        	alert(result.response);
			        }
			    } catch(e) {
		        	alert(result.response);
		        }
		    });
					    
		    uploader.bind('UploadComplete', function(up, file) {
		    	$("#files-upload-form").css("display", "none");
		    	showFiles();
		    });
	 	}
	 	
	    $("#uploader").pluploadQueue({
	        runtimes : 'html5,html4',
	        url : '<?php echo SITE_HTTP_URL;?>files/uploadFile',
	        multipart: true,
	        multipart_params: { 'category_id': <?php echo (int) $id;?> },
	        file_data_name: 'uploadfile',
	        init: attachCallbacks
	    });
	 	
	    $("#files-upload-form").submit(function(e) {
	        var uploader = $("#uploader").pluploadQueue();
	 		
	        if (uploader.files.length > 0) {
	        	uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $("#files-upload-form").submit();
	                }
	            });
			    
	            uploader.start();
	        } else {
	            alert("You must queue at least one file.");
	        }
	 
	        return false;
	    });
	} else {
		$("#files-upload-form").css("display", "none");
	}
}
</script>

<div class="white files index">
	<div class="btn-container">
			<div class="btn-holder">
			<input type="button" value="Upload Files" class="submit" onclick="showUploader()">
			</div>
			<div id="files-categories-box" class="files-categories-box">
				<h4>Filters:</h4>
				<ul><li><a href="#" onclick="window.location.reload(true);" alt="All">All</a></li><?php echo $this->requestAction("/files/getMyCategories"); ?></ul>
			</div>
			<div class="file-upload-area">
			<form id="files-upload-form" style="display: none">
				<div id="uploader"></div>
		   </form>
			</div>
	</div>	
			<table id="files">
			</table>
			
			<div id="content_files">
			</div>
</div> <! -- End white -->


