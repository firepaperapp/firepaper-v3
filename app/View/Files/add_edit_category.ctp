<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#Category").validate({
	errorElement: "p",
    invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 	//	$("div#validation-container-category").show();
	} else {
	//	$("div#validation-container-category").hide();
 	}
   },
   submitHandler: function(form) 
   {
       var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   	   $("#containerLoader").empty().html(loader);
	   $.post(siteUrl+"files/addEditCategory/"+$('#cat_id').val()+"/&rand="+randomnumber, $("#Category").serialize(), function(data)
		{
			$("#containerLoader").hide();
			if(typeof(data.success)== "undefined")
			{
				var s = data.error[0];
				$("#validation-container-category").empty().html(s).show();				
	 		}
			else
			{
			   window.location = siteUrl+"files/getFiles/"+data.id;
			}
		},"json");
	    return false;
   },
    rules: {
   	"data[Category][title]":  {required: true},	
   },
   messages: 
   {
   		"data[Category][title]":{required: "Please enter category title."}
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
<div class="validation-signup" id="validation-container-category" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">

</div>
	<h2>Add Category</h2>
	<p>&nbsp;</p>
	<form method="post" action="" name="Category" id="Category" onsubmit="return false;"> 
	<p>Category Title<span class="mandatory">*</span></p>
	   <p><?php echo $this->Form->input('fileCategory.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'150'));?> </p>
	   <p>
	<input type="hidden" name="data[fileCategory][cat_id]" id="cat_id" value="<?php echo $cat_id;?>" />
	 <input name="btnSubmit" type="submit" value="Save" class="create-account"/>
	 </p>
	 <div id="containerLoader"></div>
	</form>
</div>
</div>