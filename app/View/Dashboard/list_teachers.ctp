<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function(){
                $("#addedu").fancybox({
			ajax : {
			type	: "GET",
			}
		});

		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   		loadPiece(siteUrl+"dashboard/listTeachersAjax/"+$('#departmentId').val()+"/?rand="+randomnumber,"#content_teachers");

	$("#reset").click(function(){
		$("#reset").hide();
	});

   	 });


   	function filterRecords(check)
	{ 	
		
		if(check=='reset')
		{
			document.getElementById('firstname').value="";
		}
		if($.trim($("#firstname").val())!="")
		$("#reset").show();

		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
		$('#content_teachers').empty().html(loader);
		$.post(siteUrl+"dashboard/listTeachersAjax/"+$('#departmentId').val()+"/?rand="+randomnumber, $("#departmentTeacherSearch").serialize(), function(data)
		{
           innerContentCall('content_teachers',data)
  		});
		//$("div.errorJs").hide();
		//$("div.errorServer").hide();
		return false;
	}
   
</script>
<div class="white page index">
		<h3>Educators</h3>
			<!-- search Section tart here -->
 		 <form method="post" action="" name="departmentTeacherSearch" id="departmentTeacherSearch" onsubmit="return filterRecords('filter');">
		 <div class="upload-container">
			
			<?php if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7) { ?>
		<p>
		<a id="addedu" class="submit" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/educator/0">
		Add New Educator</a></p>
		<?php } ?>
 		<span><strong>Search:</strong> 
			 <?php echo $this->Form->input('departmentTeacherSearch.firstname',array('div'=>false,'label'=>false,"id"=>"firstname",'maxlength'=>'150'));?> 
			 <input name="frmSubmit" class="formButtonBluebg" value="Search" alt="Search" title="Search" type="submit"/>
<!--			 <a class="sign-in" href="<?php echo SITE_HTTP_URL?>listTeachers/<?php echo $departmentId;?>">Reset Search</a>-->

		<a class="sign-in" id="reset" style="display:none; "onclick="filterRecords('reset');" href="#">Reset Search</a>
			 <input type="hidden" name="data[departmentTeacherSearch][posted]" id="posted" value="1">
			 </span>		 
		</div>		
		</form>
  		<!-- search Section tart here -->
		<!-- Inner Content List start -->
		<div class="listingContent" id="content_teachers">
		</div>
		<!-- Inner Content List end -->
		<input type="hidden" name="departmentId" id="departmentId" value="<?php echo $departmentId;?>">
	</div>
