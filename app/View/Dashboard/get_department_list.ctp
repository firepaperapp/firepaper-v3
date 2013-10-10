<div class="clr-spacer"></div>
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

<div class="sorter">
	<ul>
	<?php
	foreach($departmentChars as $key=>$val)
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
<div class="clr"></div> 

<script>
	$(document).ready(function() { 
		$('.expandViewLink').click(function()
		{ 
			var myId = $(this).attr('id');
			//$('.expandView').hide();
			$('#'+myId+"_box").toggle('slow', function() {
				if($(this).css('display') == "block")
					$('#'+myId).empty().html("Close");	
				else
					$('#'+myId).empty().html("Open"); 
			});
		});
		/*It will be used Call the listings of the eucators within a department */
		$('.educatorViewLink').click(function()
		{
			var myId = $(this).attr('id'); 
			var gotId = $(this).attr('id').split("_");
	 		if("undefined"== typeof(this.educatorCalled))
			{
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
				$('#'+myId+"_box").empty().html(loader);
				$.get(siteUrl+"dashboard/getDepartmentUser/"+gotId[1]+"/educator/0/?rand="+randomnumber,   function(data)
				{	
		 			$('#'+myId+"_box").empty().html(data);
		 			 
		  		});
			}
			else
			{
				this.educatorCalled = 0;
			}
		});
		/*It will be used Call the listings of the student within a department */
		$('.studentViewLink').click(function()
		{
			var myId = $(this).attr('id');
			var gotId = $(this).attr('id').split("_");
	 		if("undefined"== typeof(this.studentCalled))
			{
				$('#'+myId+"_box").empty().html(loader);
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
				$.get(siteUrl+"dashboard/getDepartmentUser/"+gotId[1]+"/student/0/?rand="+randomnumber,   function(data)
				{	
		 			$('#'+myId+"_box").empty().html(data);
		 			 
		  		});
			}
			else
			{
				this.studentCalled = 0;
			}
		});

		/*It will be used Call the listings of the subjects within a department */
		$('.subjectViewLink').click(function()
		{
			var myId = $(this).attr('id'); 
			var gotId = $(this).attr('id').split("_"); // department id
	 		if("undefined"== typeof(this.educatorCalled))
			{
				//using random number to resolve cache issue
				var randomnumber=Math.floor(Math.random()*101);
				$('#'+myId+"_box").empty().html(loader);
				$.get(siteUrl+"dashboard/getDepartmentSubject/"+gotId[1]+"/?rand="+randomnumber,   function(data)
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

	function delUser(departmentId,subjectID, userId, type)
	{ 
		if(confirm("Are you sure to delete this record?"))
		{	
			if(subjectID > 0 )
			{
				$("#subjectEducatorView_"+subjectID+"_box").empty().html(loader);
			}
			else
			{
				$('#'+type+"View_"+departmentId+"_box").empty().html(loader);
			//	$("#studentView_"+departmentId+"_box").html(loader);
			}
			
			$.post(siteUrl+"dashboard/delUserFromDepartment/", 
					{
						"departmentId": departmentId,
						"userId": userId,
						"viewType": type,
						"subjectID": subjectID
					},
					function(data){
						var responseGot = data.split("_");
						alert(responseGot[1]);
		 
						//loaders before getting the list
						//using random number to resolve cache issue
							var randomnumber=Math.floor(Math.random()*101);
							
							$.get(siteUrl+"dashboard/getDepartmentUser/"+departmentId+"/"+type+"/"+subjectID+"/?rand="+randomnumber,   function(data)
							{	
								//it will ouput as "educatorView12_box" OR "studentView12_box"
								if(subjectID > 0 )
								{ 
									$("#subjectEducatorView_"+subjectID+"_box").empty().html(data).show();
								}
								else
								{
					 				$('#'+type+"View_"+departmentId+"_box").empty().html(data);
									//$("#subjectView_"+departmentId+"_box").empty().html(data);

										//refreshing the subject listing div  
										if($("#subjectView_"+departmentId+"_box").style.display=="block")
										{
											$.get(siteUrl+"dashboard/getDepartmentSubject/"+departmentId+"/?rand="+randomnumber,   function(data)
											{
												$("#subjectView_"+departmentId+"_box").empty().html(data);								 
											}); 
										}
								}
					 			 
					  		});						
					}
			);
		}


	}
</script>
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
						<?php echo Sanitize::html($inRec['title']);?>&nbsp;-&nbsp;
					 	<a href="javascript:void(0)" class="edit expandViewLink" id="expandView_<?php echo $inRec['id'];?>">Open</a>
					 </h4>				
					
					<div class="expandView" id="expandView_<?php echo $inRec['id'];?>_box" style="display:none;">   
						
						<p>&nbsp;</p>
						<?php
						if($this->Session->read("user_type") != 3) // only for amin and co-aadmin
						{?>
						<p>
							<span class="title">Educators in this department:</span>&nbsp;-&nbsp;
							<a class="edit educatorViewLink" id="educatorView_<?php echo $inRec['id'];?>">View</a>
						</p>
						<?php
						}?>
						<div class="educatorView" id="educatorView_<?php echo $inRec['id'];?>_box">
							
						</div>
						<p><span class="title">Students in this department:</span>&nbsp;-&nbsp;
							<a class="edit studentViewLink" id="studentView_<?php echo $inRec['id'];?>">View</a></p>
						<div class="studentView" id="studentView_<?php echo $inRec['id'];?>_box">
							
						</div>
							
						<p>
							<span class="title">Subjects in this department:</span>&nbsp;-&nbsp;
							<a class="edit subjectViewLink" id="subjectView_<?php echo $inRec['id'];?>">View</a>
						</p>
						<div class="subjectView" id="subjectView_<?php echo $inRec['id'];?>_box">
							
						</div>


					  	<p><a class="edit" onclick="deleteRecord(<?php echo $inRec['id'];?>);">Delete this department</a></p>	
					  	 <p>&nbsp;</p>
					</div>
					
				<?php
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
