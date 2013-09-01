<script type="text/javascript">
$(document).ready(function(){
		$("a#addCategory").fancybox({				 
			ajax : {
			type	: "GET"
			}
		});
});
</script>
	
<?php
foreach($fileCategories as $rec)
{
?>
<li id="fileCat_<?php echo $rec['fileCategory']['id'];?>">
<a href="<?php echo SITE_HTTP_URL."files/getFiles/".$rec['fileCategory']['id'];?>" alt="<?php echo $rec['fileCategory']['title'];?>" class="project-icon"><?php echo $rec['fileCategory']['title'];?></a></li>

<?php
} 
?>
<li class=""><a href="<?php echo SITE_HTTP_URL."files/addEditCategory"?>" alt="Add Category" class="create-icon" id="addCategory">Add a new filter</a></li>	