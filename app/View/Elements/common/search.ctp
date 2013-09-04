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
			if($("#keyword").val() == "Search" || $("#keyword").val() == "")
			{
				alert("Please enter search keyword.");
				return false;
			}
			else
			{
				$('#containerLoader').empty().html(loader);
			 	if($("#searchType").val() == "")
			 	{
			 		action = $('#calledAction').val();
			 	}
			 	else
			 	{
			 		action = "filteredSearch";
			 	}
				$.post(siteUrl +'yeargroups/'+action,$("#classGroupSearch").serialize(),function(data)
				{
					//alert(data)	;
					//data = eval("(" + data + ")");
					$('#containerLoader').hide();
					 innerContentCall('content_yeargroups',data) 
				});
				return false;
			}
		});

});
</script>


		<h3>Search:</h3> 

	<!-- Search Form Start -->
	<?php
	echo $this->Form->create('classGroupSearch', array('action'=>'','type' => 'post', 'id'=>'classGroupSearch', 'submit'=>'return false;')); 
	?>
 	<?php echo $this->Form->input('classGroupSearch.keyword',array('div'=>false,'label'=>false,"id"=>"keyword",'maxlength'=>'150', "class"=>"doc-name searchKeyword","value"=>"Search",'style'=>'color:#00'));?> 
 	<select name="data[classGroupSearch][searchType]" id="searchType">
 		<option value="">global</option>
 		<option value="yeargroup">Year Group</option>
 		<option value="classgroup">Class Group</option>
 		<option value="student">Student</option>
 	</select>
 	<input type="submit" name="searchKeywordBtn" class="action-button" id="searchKeywordBtn" value="Submit" />
	 <input type="hidden" name="data[classGroupSearch][posted]" id="posted" value="1">
	</form>
	<!-- Search Form End -->