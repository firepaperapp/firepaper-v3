<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#department").validate({
	errorElement: "p",
    invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 		$("div#validation-container").show();
	} else {
		$("div#validation-container").hide();
 	}
   },
   submitHandler: function(form) 
   {
    	   var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   	   $("#containerLoader").empty().html(loader);
	   $.post(siteUrl+"dashboard/addEditDepartment/"+$('#dept_id').val()+"/&rand="+randomnumber, $("#department").serialize(), function(data)
		{
			$("#containerLoader").hide();
			if(typeof(data.success)== "undefined")
			{
				var s = data.error[0];
				$("div#validation-container1").show();
				$("#validation-container1").empty().html(s);				
	 		}
			else
			{
			    var err = data.success.toString();
			    err+="<p><a onlick='closeWindow();' href='javascript:$.fancybox.close();'>Close</a></p>";
				$('#msgDiv').empty().html(err).show();					
				$('#contentDiv').hide();
				setTimeout("closeWindow()",5000);	
			}
		},"json");
	    return false;
   },
    rules: {
   	"data[Department][title]":  {required: true},	
   },
   messages: 
   {
   		"data[Department][title]":{required: "Please enter department title."}
   }
});
});
function closeWindow()
{
	 $.fancybox.close();
	 getInnerList();
}
</script>
<div style="width:600px;float:left;">

<div id="msgDiv" style="display:none;">
		
</div>
<div id="contentDiv">
	
<div class="validation-signup" id="validation-container1" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">

</div>
	<h2>Add Department</h2>
	<p>&nbsp;</p>
	<form method="post" action="" name="department" id="department" onsubmit="return false;"> 
	<p>Department Title<span class="mandatory">*</span></p>
	   <p><?php echo $this->Form->input('Department.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'150'));?> </p>
	   <p>
	<input type="hidden" name="data[Department][dept_id]" id="dept_id" value="<?php echo $dept_id;?>" />
	 <input name="btnSubmit" type="submit" value="Save" class="create-account"/>
	 </p>
	 <div id="containerLoader"></div>
	</form>
</div>
</div>