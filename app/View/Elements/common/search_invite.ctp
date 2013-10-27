<script type="text/javascript">
jQuery.validator.addMethod("emptysearch", function(value, element, param) 
{
	 
return this.optional(element) || $.trim(value) == "Search";
}, "Please enter keyword.");

$(document).ready(function(){
  		$('.searchKeyword').focusin(
		 function()
		 {
		 	if($(this).val() == "Search")	
		 	{
		 		$(this).val("");
		 	}
		 }
	 );
	 $('.searchKeyword').focusout(
	 	function()
	 	{
	 		if($(this).val() == "")	
		 	{
		 		$(this).val("Search");
		 	}
	 	}
	 );
	 $('#classGroupSearch').submit(
	 function()
	 {
		 	var action = "";
				$('#containerLoader').empty().html(loader);
			 	
				$.post(siteUrl +'yeargroups/listInviteStudentsAjax',$("#classGroupSearch").serialize(),function(data)
				{
					//alert(data)	;
					//data = eval("(" + data + ")");
					$('#containerLoader').hide();
					 innerContentCall('content_yeargroups',data) 
				});
				return false;
		
		});

});
</script>

	<!-- Search Form Start -->
	<?php
	echo $this->Form->create('classGroupSearch', array('action'=>'','type' => 'post', 'id'=>'classGroupSearch', 'submit'=>'return false;')); 
	?>
 	<?php echo $this->Form->input('User.keyword',array('div'=>false,'label'=>false,"id"=>"keyword",'maxlength'=>'150', "class"=>"searchKeyword","value"=>"Search",'style'=>'color:#00'));?> 
 	
 	<input type="submit" name="searchKeywordBtn" class="submit" id="searchKeywordBtn" value="Submit" />
	 <input type="hidden" name="data[classGroupSearch][posted]" id="posted" value="1">
	</form>
	<!-- Search Form End -->