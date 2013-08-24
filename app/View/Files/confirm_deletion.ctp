<script type="text/javascript">
$(document).ready(function(){
$('#btnSubmit').click(function()
{
	if($('#reason').length!=0 && $.trim($('#reason').val())=="")
	{
		alert("Please enter reason for deletion of this file.");
	}
	else
	{
		$("#submitWrr").empty().html(loader).show();
		$.post(siteUrl+"files/confirmDeletion/"+$('#fileId').val()+"/", $("#confirmDeletion").serialize(), function(data)
			{
				if(typeof(data.success)== "undefined")
				{
					var s = data.msg[0];
					$("div#validation-container1").show();
					$("#submitWrr").empty().html(s);				
		 		}
				else
				{
				    $.fancybox.close();
				    loadPiece(siteUrl+"files/getFilesInner/","#content_files"); 
				}
			},"json");
		    return false;
	}
});
});
</script>
<h3>Delete File</h3>
<div class="validation-signup" id="validation-container1" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<form method="post" action="" name="confirmDeletion" id="confirmDeletion" onsubmit="return false;"> 
<p>&nbsp;</p>
<?php 
if($numberOfVersions>0)
{
?>
	<p>As you are deleting the main file, kindly opt any of the following option to delete a file.</p>
	<p>&nbsp;</p>
	<p><input type="radio" name="data[userFile][delFile]" value="1" checked="checked"/>&nbsp;Delete file and all versions</p>
	<p><input type="radio" name="data[userFile][delFile]" value="0" />&nbsp;Delete file only (In this case any last added version will become main file)
	
	</p>
<?php 
}
else
{?>
	<p><input type="hidden" name="data[userFile][delFile]" value="2" />Are you sure you want to delete this file?</p>
<?php }
if($anyPrjCnt>0)
{?>
	<p>&nbsp;</p>
	<p>Please Note: This file is assigned to a project. Kindly enter your reason for deletion of this file.</p>
	<p><textarea name="data[userFile][reason]" id="reason" rows="5" cols="40"></textarea></p>
<?php
}
?>

<p>&nbsp;</p><input type="hidden" id="fileId" name="data[userFile][fileId]" value="<?php echo $fileId;?>" />
<p id="submitWrr">
	<input name="btnSubmit" id="btnSubmit" type="button" value="Submit" class="create-account"/>
	<input name="" type="button" value="Cancel" class="create-account" onclick="$.fancybox.close();"/>
</p>
</form>
