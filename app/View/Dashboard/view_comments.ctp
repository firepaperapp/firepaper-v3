<script type="text/javascript">
	$(document).ready(function(){
   		loadPiece(siteUrl+"dashboard/viewCommentsAjax/","#content_cms");
   		var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
   		$("#project_id").change(function(){
   			$("#content_cms").empty().html(loader);
   			$.post(siteUrl+"dashboard/viewCommentsAjax/?rand="+randomnumber, {'data[commentSearch][project_id]':$("#project_id").val()}, function(data)
		{
           innerContentCall('content_cms',data)
  		});
   			
   		});
   	 });
</script>  
<div class="activity">
	<div class="index">
		<div class="left">
		 	<h3>Comments</h3>     
		 	<div class="project-brief-box-wrapper">
		        <div class="project-brief-box" style="width:92.5%;">
				    <div id="content_cms">
				   	
				    </div>
			    </div>
	 		</div>
		</div>
		<div class="right">
			 <h3>Filter</h3>		 
			 <strong>By Projects</strong>
			 <p>
			 	<?php
			 	echo $this->Form->input('project_id',array('type'=>'select','div'=>false,'label'=>false,'options'=>$prjList,'id'=>'project_id','class'=>'dropdown','empty'=>"Please Select","style"=>"width:150px;"));
			 	?>
			 </p>
		</div>
	</div>
</div><!-- end activity -->