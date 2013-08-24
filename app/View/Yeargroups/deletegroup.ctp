<script type="text/javascript">
$(document).ready(function(){
$("#btnCancel").click(function(){
 $.fancybox.close();
 window.location = siteUrl+$('#referer').val(); 
});

$('#btnSubmitS').click(function()
{	
	$.post(siteUrl+"yeargroups/deletegroup/"+$('#group_ids').val()+"/", $("#confirmDeletion").serialize(), function(data)
		{
			if(typeof(data.success)== "undefined")
			{
				var s = data.msg[0];
				$("div#validation-container1").show();
				$("#validation-container1").empty().html(s);				
	 		}
			else
			{
			    $.fancybox.close();
			    window.location = siteUrl+$('#referer').val(); 
			}
		},"json");
	    return false;
});
});
</script>
<div style="width:500px;" id="dele">
<div class="validation-signup" id="validation-container1" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>"></div>
<form method="post" action="" name="confirmDeletion" id="confirmDeletion" onsubmit="return false;"> 
<p>&nbsp;</p>
<p>
<?php
if($data['classGroup']['group_type'] == "year")
{	
	echo 'Are you sure you want to delete this group as deletion of this group will also delete class groups and students within those class groups?';
}
else
{
	echo 'Are you sure you want to delete this group as deletion of this group will also delete students within this class group?'; 
}?>
</p>
<p>&nbsp;</p>
<p>
<input type="button" name="btnSubmitS" id="btnSubmitS" value="Ok" />
<input type="button" name="btnCancel" id="btnCancel" value="Cancel" />
<input type="hidden" name="data[classGroup][group_ids]" id="group_ids" value="<?php echo $group_id;?>" />
<input type="hidden" name="referer" id="referer" value="<?php echo $referer;?>" />
</p>
</form>
</div>
