<script>
function filterList(selectedTitle)
{  
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue	
	$('#content_archievedProjects').empty().html(loader);
	$.post(siteUrl+"Projects/listArchivedproject/"+$("#draft").val()+"/?"+"&rand="+randomnumber, 
	{title: selectedTitle}
	, function(data)
	{
			innerContentCall('content_archievedProjects',data);
		});
	//$("div.errorJs").hide();
	//$("div.errorServer").hide();
	return false;
}

function deleteRecord(id)
{
	var randomnumber=Math.floor(Math.random()*101);//using random number to resolve cache issue
	if(confirmDeletion())
	{
	   $('#content_archievedProjects').empty().html(loader);
       $.get(siteUrl+"Projects/listArchivedproject/"+$("#draft").val()+"/?d="+id+"&rand="+randomnumber, function(data)
		{	 
			loadPiece(siteUrl+"Projects/listArchivedproject/"+$("#draft").val(),"#content_archievedProjects");
 			//innerContentCall('content_archievedProjects',data);
  		});
	}    	
}
	
</script>
<div class="sorter">
	<ul>
	<?php
	foreach($projectChars as $key=>$val)
	{?>
		<li>
			<?php
				$sel = ""; 
				if(strtolower($selectedChar) == strtolower($val))
					$sel = "selected";
			?>
			<a href="#" onclick="filterList('<?php echo $val;?>')" class="<?php echo $sel;?>">
			<?php echo strtoupper($val);?></a>
		</li>
	<?}?>	
	</ul>		
</div>
<p>&nbsp;</p>
<!-- some script will go here --> 
<div class="dept-wrapper">
<?php
if(count($data)>0)
{
	foreach($data as $rec) 
	{?>	 
		<div class="dept-box">
			<div class="left-section">
				<div class="letter">
					<?php
						echo ucfirst($rec[0]['key']);
					?>
				</div>
			</div>
			<div class="right-details">
				<?php
				foreach($rec as $inRec)
				{ ?>
					<h4>
						<?php echo Sanitize::html($inRec['title']);?>			 	
					 </h4>	
					 <a href="<?php echo SITE_HTTP_URL?>projects/viewDetails/<?php echo $inRec['id']?>" class="edit" id="expandView_<?php echo $inRec['id'];?>">Open</a> 
					 <?php
					 
					 if($showdelLink=="Y" || $inRec['admin_id']==$this->Session->read('userid'))
					 { ?>
						 |&nbsp;<a class="edit" onclick="deleteRecord(<?php echo $inRec['id'];?>);">Delete</a>		
					<?php
					}
				}
				?>
			</div>
		</div>
	<?php 
	}
}
else 
	echo "<p>".ERR_RECORD_NOT_FOUND."</p>";
?>
<div class="clr"></div>  
