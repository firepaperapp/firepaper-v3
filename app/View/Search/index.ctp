<script>
$(document).ready(function(){
    
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	loadPiece(siteUrl+"search/searchContent/"+"/?rand="+randomnumber,"#content_search"); 

 });


function filterRecords(check)
{ 	
	if(check=='reset')
	{
		$('#title').val("");
	}
	else
	{
		if($.trim($('#title').val()) == "")
		{
			alert("Please enter keyword");
			return false;
		}
		else if($.trim($('#title').val()).indexOf("^")!=-1)
		{
			alert("^ is not allowed");
			return false;
		}
	}
 	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	$('#content_search').empty().html(loader);
	$.post(siteUrl+"search/searchContent/"+"?rand="+randomnumber, $("#search").serialize(), function(data)
	{
		 
       innerContentCall('content_search',data)
	});	 
	return false;
}
</script>
<div class="white page index">
		<h3>Search</h3>
			<!-- search Section tart here -->
 		 <form method="post" action="" name="search" id="search" onsubmit="return filterRecords('filter');">
		 <div class="upload-container">
 			<span><strong>Search:</strong> 
			 <?php echo $this->Form->input('search.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'150'));?> 
			 <input name="frmSubmit" class="formButtonBluebg" value="Search" alt="Search" title="Search" type="submit"/>
			<a class="sign-in" id="reset" style="display:none;" onclick="filterRecords('reset');" href="#">Reset Search</a>
			 <input type="hidden" name="data[search][posted]" id="posted" value="1">
			 </span>		 
			 <p style="margin-left: 50px;"><small>^ is not allowed</small></p>
		</div>		
		</form>
		<!-- search Section tart here -->
		<!-- Inner Content List start -->
		
		<div class="listingContent" id="content_search"></div>
		<!-- Inner Content List end -->
		 
	</div>
