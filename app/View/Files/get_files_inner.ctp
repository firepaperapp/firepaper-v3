<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.droppable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>files.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.fileupload-ui.css" />
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.fileupload-ui.js"></script>


<?php
	if($this->Session->check('Message.flash'))
	{?>
		<div class="essage errorServer">
			<div class="success">
				<?php
					$this->Session->flash(); // this line displays our flash messages
				?>
			</div>
		</div>
	<?php }
?>
<div class="clr-spacer"></div>
<div class="files-container">
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
<script>
$(".file-col-1-wrapper").first().css( "display", "none" );
</script>
</div>
<?php
if(count($data)>0)
{
	App::import('Helper','Time');
	$time = new TimeHelper(new View());
	$i=0;
	$j = 1;
	foreach($data as $recCategory)
	{	
		$title = $recCategory['fileCategory']['title'];
		$myVersion = isset($rec['userFile']['Revison'])&&count($rec['userFile']['Revison'])>0?$rec['userFile']['Revison']:0;
		$i++;
  	?>		
	<div class="file-col-1-wrapper">
		<div class="files-box-wrapper">
			<div class="files-box" >
				<p class="title-files"><?php echo Sanitize::html($recCategory['fileCategory']['title']);?></p>
				<?php
				if(count($recCategory['userFile'])>0)
				{
				foreach($recCategory['userFile'] as $gotRec)
				{ 
				$rec['userFile'] = $gotRec;
				?>
				<div class="file-name file-name-border" id="main_<?php echo $rec['userFile']['id'];?>"> 
					<img src="<?php echo IMAGES_PATH;?>large-icons/<?php echo $fileTypes[$rec['userFile']['file_type_id']];?>" />
					<a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $rec['userFile']['id'];?>"  id="tool-tip" style="cursor:pointer;"><span id="fileProject_<?php echo $rec['userFile']['id'];?>" class=" dragFileForProject"><?php echo Sanitize::html($rec['userFile']['file_name']);?></span>
					</a>
	            	<p class="file-links">
	            		<span> <?php 
						echo date("m/d/y", strtotime($rec['userFile']['uploaded']))." at ".date("h:i:a", strtotime($rec['userFile']['uploaded']));?></span> - 
	            		<a href="javascript:void(0);" class="viewDetails edit" id="<?php echo $rec['userFile']['id'];?>" >View options</a> | <a href="<?php echo SITE_HTTP_URL?>files/confirmDeletion/<?php echo $rec['userFile']['id'];?>/" class="edit deleteFile">Delete</a>
	            	</p>
	            	<div class="clr"></div>	
	            	<div class="versions" id="versions<?php echo $rec['userFile']['id'];?>" style=" position:  relative;">
	            		
			            <div class="versions-inner"> 
			            	<p>
								<span class="title">Comments:</span> 
								<a href="javascript:void(0);" class="edit commentboxlink" id="<?php echo $rec['userFile']['id'];?>">List Comments</a> - <a href="javascript:void(0);" class="edit addcommentlink" id="addcomment_<?php echo $rec['userFile']['id'];?>">Add New Comment</a>
						    </p>
						     <div class="comment-link fl-left"><span>Comment</span></div>
							 <div class="clr"></div>
						     <div class="addcomment comment-file" id="addcomment_<?php echo $rec['userFile']['id'];?>_box" style="display:none;">
					          	<textarea name="addcommenttext_<?php echo $rec['userFile']['id'];?>" id="addcommenttext_<?php echo $rec['userFile']['id'];?>" rows="5" cols="40" ></textarea>
					          	<div id="submitComment_<?php echo $rec['userFile']['id'];?>"></div>
					          	<div class="submit-wrapper">
						          	<input type="button" class="submit" name="submit" value="Submit" onclick="addComment(<?php echo $rec['userFile']['id'];?>);"/>&nbsp;or&nbsp;
						          	<a name="cancel" class="edit" href="javascript:void(0);" onclick="$('#addcomment_<?php echo $rec['userFile']['id'];?>_box').slideUp('slow');">Cancel</a>
						          	
						         </div><div class="clr"></div>
				             </div>    
							<div class="marginB10" id="comment_<?php echo $rec['userFile']['id'];?>" style="width:250px;display:none;">
						    
						    </div> 	
			            
			             
		                	<p class="width100per">
								<span class="title">Filter:</span><br />
								<label id="addcategory_<?php echo $rec['userFile']['id'];?>_box_span"><?php echo $title;?></label><br />
								<b id= "category_<?php echo $rec['userFile']['id'];?>" class="edit editcategory" style="display: inline">Edit</b>&nbsp;or&nbsp;
								<a href="javascript:void(0);" class="edit addcategorylink" id="addcategory_<?php echo $rec['userFile']['id'];?>">Create a filter</a>
								
							</p>
							<div id="addcategory_<?php echo $rec['userFile']['id'];?>_box" class="addcategory width100per" style="display:none;">   
                
                			</div>  
	                 	    <!--<p class="width100per">
		                	    <span class="title">Tags:</span>  
		                	    <span id="tagbox_<?php echo $rec['userFile']['id'];?>_tag_span"><?php echo $rec['userFile']['tags'];?></span> - 
		              	  		<a href="javascript:void(0);" class="edit tagboxlink" id="tagbox_<?php echo $rec['userFile']['id'];?>">Edit</a>
	              	  	   </p>-->
	              	  	  
	              	  	   	<div class="dotted-spacer"></div>
	              	  	   	<?php
					 		if($this->Session->read("user_type") == 5 && $this->Session->read("admin_id")!=0)
					 		{
					 			
					 		}
						 	else 
						 	{	
						 	?>
	              	  	   	<table id="uploadRevison_<?php echo $rec['userFile']['id'];?>"></table>
			           	   	<form id="form_<?php echo $rec['userFile']['id'];?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile/<?php echo $rec['userFile']['id'];?>?category_id=<?php echo $recCategory['fileCategory']['id']?>" method="POST" enctype="multipart/form-data" class="upload-link">	
		                	 <input type="file" id="uploadfile<?php echo $rec['userFile']['id']?>" name="data[userFile][uploadfile]" />
							 <input type="hidden" name="category_id" value="<?php echo $recCategory['fileCategory']['id']?>" />	
				    		 <a href="javascript:void(0)" class="uploadfilterfile" id="uploadfilterfile">Upload a new version</a>
				   			 <div>Upload a new version</div>
		               		</form>
							<div id="validation-container-task<?php echo $rec['userFile']['id']?>" class="validation-signup" style="display:none;"></div>
							<div id="validation-container-success-task<?php echo $rec['userFile']['id']?>" class="success" style=" display: none;"></div>
							<script type="text/javascript">
								var btnUpload = $('#uploadfile'+<?php echo $rec['userFile']['id']?>);
								var status = $('#loaderJsTask'+<?php echo $rec['userFile']['id']?>);
								$('#form_'+<?php echo $rec['userFile']['id']?>).fileUploadUI({
									dragDropSupport: true,
									uploadTable: $('#uploadRevison_'+<?php echo $rec['userFile']['id'];?>),
									downloadTable: $('#uploadRevison_'+<?php echo $rec['userFile']['id'];?>),
									buildUploadRow: function (files, index) {
										 return $('<tr><td>' + files[index].name + '<\/td>' +
												'<td class="file_upload_progress"><div><\/div><\/td>' +
												'<td class="file_upload_cancel">' +
												'<button class="ui-state-default ui-corner-all" title="Cancel">' +
												'<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
												'<\/button><\/td><\/tr>');
									},
									buildDownloadRow: function (response) {
										//Add uploaded file to list
												if("undefined" == typeof(response.success))
												{
													$("#validation-container-task"+<?php echo $rec['userFile']['id']?>).empty().html("<p class='error'>"+response.error+"</p>").show();
													$("#validation-container-success-task"+<?php echo $rec['userFile']['id']?>).empty().hide();
							
												} else{	 
														$("#validation-container-task"+<?php echo $rec['userFile']['id']?>).empty().hide();
														$("#validation-container-success-task"+<?php echo $rec['userFile']['id']?>).empty().html(response.success).show();
														http://www.firepaperapp.com/dev/files/getSubFiles/451?rand=25?v=1380196461425&cache=false
														$.get(siteUrl+"files/getSubFiles/"+<?php echo $rec['userFile']['id']?>+"/?v="+Number(new Date())+"&cache=false",function(data)
														{	 
															$("div#revisions"+<?php echo $rec['userFile']['id']?>).empty().html(data).show('slow');	
															$("#loaderJsTask").hide();
															$(".dropFileHere").fadeOut('slow');
														});
												}        
									}
								});
							</script>
               				 <?php } ?>
							<div id="revisions<?php echo $rec['userFile']['id'];?>" class="clr">
			                
			                </div>
							<div class="clr"></div>
						</div>	            	
	            	</div>
				</div> 
				
				<?php
				}
				}
				else 
				{
					echo "<p>".ERR_RECORD_NOT_FOUND."</p>";
				}
				?>
	 			<div class="clr"></div>
			</div><!-- end files-box -->
		</div><!-- end files-box-wrapper -->
		<div class="clr"></div>
	</div><!-- end file-col1-wrapper -->
 	<?php
		if($j == 2)
		{
			$j = 0;?>
		
		<?php
		}			
		$j++;
    }//foreach end here    
    ?>
	<input type="hidden" name="page" id="page" value="<?php echo $page;?>"/>
	<input type="hidden" name="total" id="total" value="<?php echo $i;?>"/>
	<input type="hidden" name="limit" id="limit" value="<?php echo $limit;?>"/>
 <?php
 $this->Paginator->options(array('url' => $this->passedArgs));
 echo $this->element("pagination/ajax_pagination");
}
else
{
echo "<p>".ERR_RECORD_NOT_FOUND."</p>";
}
?>
<div class="clr"></div>
</div>
<script>
$('.upload-link').each(function(){ 
		var myId = $(this).attr('id');
		
		var btnUpload = $('#form_'+myId);
		var status=$('#status');
		var taskId = myId.split("_");
 
 	 	if($("#"+myId).hasClass("file_upload") == false)
	 	{
		 $("#"+myId).fileUploadUI({
		 	dragDropSupport: false,
	        uploadTable: $('#filesDrag'+taskId[1]),
	        downloadTable: $('#filesDrag'+taskId[1]),
	        buildUploadRow: function (files, index) {
	        	       return $('<tr><td>' + files[index].name + '<\/td>' +
	                    '<td class="file_upload_progress"><div><\/div><\/td>' +
	                    '<td class="file_upload_cancel">' +
	                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
	                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
	                    '<\/button><\/td><\/tr>');
	        },
	        buildDownloadRow: function (response) {
	        	if("undefined" == typeof(response.success))
					{
							alert(response.error);

					} else{	 
							//alert(response.success);								
							$.get(siteUrl+"projects/studentUploadTaskDoc/"+response.id+"/"+taskId[1]+"/?v="+Number(new Date()),function(data)
							{	 
								$("#task_"+taskId[1]+"_box").append(data).show('slow');		
								//alert($("#taskUnderDiv").html());
								$("#loaderJsTask").hide();
								$("#drag_"+taskId[1]).fadeOut('slow');
							}
							);
					}        
	        }
	    });
	 	}	
	 
	});
</script>