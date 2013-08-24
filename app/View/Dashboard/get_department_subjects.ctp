<script>
$(document).ready(function()
{
	$("a#addSubject").fancybox({				 
				ajax : {
				type	: "GET"
				
				}
			});
 
	/*It will be used Call the listings of the subjects within a department */
	$('.subjectEducatorView').click(function()
	{
		var myId = $(this).attr('id'); 
		var gotId = $(this).attr('id').split("_"); // subject id = gotId[1]
		if("undefined"== typeof(this.educatorCalled))
		{
			//using random number to resolve cache issue
			var randomnumber=Math.floor(Math.random()*101);
			$('#'+myId+"_box").empty().html(loader); 
			$.get(siteUrl+"dashboard/getDepartmentUser/"+$("#deprtmntID").val()+"/educator/"+gotId[1]+"/?rand="+randomnumber,   function(data)
			{	
				$('#'+myId+"_box").empty().html(data);				 
			});
		}
		else
		{
			this.subjectCalled = 0;
		}
	});
 
});


function delSubject(subId,deptId)
	{ 
		if(confirm("Are you sure you to delete this subject?"))
		{	$('#subjectView_'+deptId+'_box').empty().html(loader);
			$.post(siteUrl+"dashboard/delSubjectFromDepartment/", 
					{
						"subjectId": subId
					},
					function(data){
						 
						
						//loaders before getting the list
						//using random number to resolve cache issue
							var randomnumber=Math.floor(Math.random()*101);

							$.get(siteUrl+"dashboard/getDepartmentSubject/"+deptId+"/?rand="+randomnumber,   function(data)
							{	
								$('#subjectView_'+deptId+'_box').empty().html(data);								 
							});
						
					}
			);
		}
	}




</script>
<ul>
	<?php
	if(count($data)>0)
	{?> 
		<?php
		foreach($data as $rec)//  pr($rec); exit;
		{?>
	<!--		<li>
				<a href="#" class="underline-link">
					<?php echo Sanitize::html(ucfirst($rec['Subject']['title']));?>
				</a>&nbsp;-&nbsp;
				<a class="edit" onclick="delSubject(<?php echo $rec['Subject']['id'];?>, <?php echo $departmentId; ?>)">Delete</a>
				&nbsp;-&nbsp;
				<a class="edit educatorViewLink">View Educator(s)</a>
			</li>-->

			<p>
				<a href="#" class="underline-link">
					<?php echo Sanitize::html(ucfirst($rec['Subject']['title']));?>
				</a>&nbsp;-&nbsp;
				<a class="edit" onclick="delSubject(<?php echo $rec['Subject']['id'];?>, <?php echo $departmentId; ?>)">Delete Subject</a>
				<?php
				if($this->Session->read("user_type")!=3)
				{?>
				&nbsp;|&nbsp;
				<a class="edit subjectEducatorView" id="subjectEducatorView_<?php echo $rec['Subject']['id'];?>">View Educator(s)</a>
				<?php
				}?>
			</p>
			<div class="educatorView" id="subjectEducatorView_<?php echo $rec['Subject']['id'];?>_box">
			</div>
			
		<?php
		}?>	
	<?php
	}
	else {
		echo ERR_RECORD_NOT_FOUND;
	}
	?>
<li>

		
		<a class="edit" id="addSubject" href="<?php echo SITE_HTTP_URL?>dashboard/addEditSubject/<?php echo $departmentId;?>">Add new subject</a>	

</li>
</ul>
<input type="hidden" name='deprtmntID' id="deprtmntID" value="<?php echo $departmentId;?>">
		