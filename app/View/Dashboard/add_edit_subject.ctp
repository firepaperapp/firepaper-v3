<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#subject").validate({
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
   	   $("#container_Loader").empty().html(loader);
	   $.post(siteUrl+"dashboard/addEditSubject/&rand="+randomnumber, $("#subject").serialize(), function(data)
		{	// var deptmntID = $("#dept_id").val();
			$("#container_Loader").hide();
			if(typeof(data.success)== "undefined")
			{
				var s = data.error[0];
				$("div#validation-container1").show();
				$("#validation-container1").empty().html(s);				
	 		}
			else
			{
			    var err = data.success.toString();
			    err+="<p><a onclick='closeWindow();' href='javascript:void(0);'>Close</a></p>";
				$('#msgDiv').empty().html(err).show();					
				$('#contentDiv').hide();
				setTimeout("closeWindow()",5000);	
			}
		},"json");
	    return false;
   },
    rules: {
   	"data[Subject][title]":  {required: true},	
   },
   messages: 
   {
   		"data[Subject][title]":{required: "Please enter subject title."}
   }
});
});
function closeWindow()
{
	if($('#fancybox-wrap').css('display') == "block")
	{
		$.fancybox.close();		
		var randomnumber=Math.floor(Math.random()*101);
		var deptId = $("#dept_id").val();
		$.get(siteUrl+"dashboard/getDepartmentSubject/"+deptId+"/?rand="+randomnumber, function(data)
		{	
			$('#subjectView_'+deptId+'_box').empty().html(data);								 
		});
	}
}

</script>
<div style="width:600px;float:left;">

<div id="msgDiv" style="display:none;">
		
</div>
<div id="contentDiv">
	
<div class="validation-signup" id="validation-container1" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">

</div>
	<h2>Add/Edit Subject</h2>
	<p>&nbsp;</p>
	<form method="post" action="" name="subject" id="subject" onsubmit="return false;"> 
		<p>Subject Title<span class="mandatory">*</span></p>

		<?php echo $this->Form->input('Subject.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'150'));?> 

		<input type="hidden" name="data[Subject][dept_id]" id="dept_id" value="<?php echo $departmentId;?>" />

		<input type="hidden" name="data[Subject][subject_id]" id="subject_id" value="<?php echo $subjectId;?>" />

		<input name="btnSubmit" type="submit" value="Save" class="submit"/>

		<div id="container_Loader"></div>
	</form>
</div>
</div>