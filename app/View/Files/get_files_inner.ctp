<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.droppable.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>files.js"></script>
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
	<div class="file-col-1<?php //echo $j;?>-wrapper">
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
					<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $fileTypes[$rec['userFile']['file_type_id']];?>" />
					<a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $rec['userFile']['id'];?>"  id="tool-tip" style="cursor:pointer;"><span id="fileProject_<?php echo $rec['userFile']['id'];?>" class=" dragFileForProject"><?php echo Sanitize::html($rec['userFile']['file_name']);?></span>
					</a>
	            	<p class="file-links">
	            		<span> <?php 
						echo date("m/d/y", strtotime($rec['userFile']['uploaded']))." at ".date("h:i:a", strtotime($rec['userFile']['uploaded']));?></span> - 
	            		<a href="javascript:void(0);" class="viewDetails edit" id="<?php echo $rec['userFile']['id'];?>" >View options</a>| <a href="<?php echo SITE_HTTP_URL?>files/confirmDeletion/<?php echo $rec['userFile']['id'];?>/" class="edit deleteFile">Delete</a>
	            	</p>
	            	<div class="clr"></div>	
	            	<div class="versions" id="versions<?php echo $rec['userFile']['id'];?>">
	            		
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
								<span class="title">Category:</span>&nbsp;
								<label id="addcategory_<?php echo $rec['userFile']['id'];?>_box_span"><?php echo $title;?></label>-&nbsp;<b id= "category_<?php echo $rec['userFile']['id'];?>" class="edit editcategory" style="display: inline">Edit</b>&nbsp;OR&nbsp;
								<a href="javascript:void(0);" class="edit addcategorylink" id="addcategory_<?php echo $rec['userFile']['id'];?>">Create Category</a>
								
							</p>
							<div id="addcategory_<?php echo $rec['userFile']['id'];?>_box" class="addcategory width100per" style="display:none;">   
                
                			</div>  
	                 	    <p class="width100per">
		                	    <span class="title">Tags:</span>  
		                	    <span id="tagbox_<?php echo $rec['userFile']['id'];?>_tag_span"><?php echo $rec['userFile']['tags'];?></span> - 
		              	  		<a href="javascript:void(0);" class="edit tagboxlink" id="tagbox_<?php echo $rec['userFile']['id'];?>">Edit</a>
	              	  	   </p>
	              	  	   <div id="tagbox_<?php echo $rec['userFile']['id'];?>_tag" class="tagbox" style="display:none;"><?php echo trim(ucfirst(Sanitize::html($rec['userFile']['tags'])));?></div>
	              	  	   	<div class="dotted-spacer"></div>
	              	  	   	<?php
					 		if($this->Session->read("user_type") == 5 && $this->Session->read("admin_id")!=0)
					 		{
					 			
					 		}
						 	else 
						 	{	
						 	?>
	              	  	   	<table id="uploadRevison_<?php echo $rec['userFile']['id'];?>"></table>
			           	   	<form id="form_<?php echo $rec['userFile']['id'];?>" action="<?php echo SITE_HTTP_URL;?>files/uploadFile/<?php echo $rec['userFile']['id'];?>" method="POST" enctype="multipart/form-data" class="upload-link">	
		                	 <input type="file" id="uploadfile" name="data[userFile][uploadfile]" />   	 					 <input type="hidden" name="category_id" value="<?php echo $recCategory['fileCategory']['id']?>" />	
				    		 <button>Upload</button>
				   			 <div>Upload files</div>
		               		</form>
               				 <?php } ?>
							<div id="revisions<?php echo $rec['userFile']['id'];?>">
			                
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
			<div class="clr"></div>
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
