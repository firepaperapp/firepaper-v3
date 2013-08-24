<script type="text/javascript">
$(document).ready(function() {
	if(location.href.indexOf("addEditProject")!=-1 || location.href.indexOf("viewDetails")!=-1 )
	{
		$(".dragFiles").draggable({helper:"clone" });
	}
	$('.callfiles').click(function(){
	 		var myRef = this;
			$('.callfiles').each(function(){
				$(this).removeClass('centre');
			});
			
			$('#'+$(myRef).attr('id')).addClass('centre');
			loadPiece(siteUrl+"files/listFiles/"+$(myRef).attr('id'),"#dropbox_files");
			
	});		
});
</script>


<?php
   $i = 0;	
   if(is_array($data) && count($data)>0)
   {?>	 
		<ul class="sortable paginatorSort">
			<li><?php echo $this->Paginator->sort('Name', 'file_name'); ?></li>
			<li><?php echo $this->Paginator->sort('Date', 'uploaded'); ?></li>
			<li><?php echo $this->Paginator->sort('Type', 'file_type_id'); ?></li>
			<div class="clr"></div>
		</ul>
		<?php
	 	 foreach($data as $files)
		 {?>
			 
			<div class="file dragFiles" id="dragFile_<?php echo $files['userFile']['id'];?>">
				<div class="move"></div>
				<img src="<?php echo IMAGES_PATH;?>icons/<?php echo $files['fileType']['icon']?>" />
				<a href="<?php echo SITE_HTTP_URL?>files/downloadFile/<?php echo $files['userFile']['id']?>"><?php echo $files['userFile']['file_name']?></a> <em>- <?php echo date("m/d/Y",strtotime($files['userFile']['uploaded']))?></em>
			</div>
		<?php
		 }?>
		 <div style="float:left;width:80%;padding-left:15px;margin:10px">
		<?php 
	
		$this->Paginator->options(array('url' => $this->passedArgs));
		echo $this->element("pagination/ajax_pagination");?>
		</div>
   <?php
   }
   else 
   {
		echo '<p>'.ERR_RECORD_NOT_FOUND.'</p>';
   }
?>
