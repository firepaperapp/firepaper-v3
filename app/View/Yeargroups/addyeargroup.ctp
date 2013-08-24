<script>
$(document).ready(function()
{	
 	if($("#showadduserid").val()=='Y')
		$("#addStudentToGroup").show();
		//$("#addstudent").show();

	else
	$("#addStudentToGroup").hide();
	//$("#addstudent").hide();

	// $("#addstudent").fancybox({
				$("#addStudentToGroup").fancybox({
			ajax : {
			type	: "POST"
			}
		});


	//using random number to resolve cache issue
	$('#parentGroup').change(function() {
		if($(this).val()!= "")
		{
			$("#studentDiv").show();
		}
		else
		{
			$("#studentDiv").hide();
		}
	});
	$("#otherGroups").fcbkcomplete({
		json_url: siteUrl+"yeargroups/getOtherGroups/",
		cache: false,
		filter_selected: true,
		maxitems:15,
		addontab: true,
		height: 4,
		width:"350"
	});
	$("#student").fcbkcomplete({
		json_url: siteUrl+"yeargroups/getStudentToAdd/",
		cache: false,
		filter_selected: true,
		maxitems:15,
		addontab: true,
		height: 4,
		width:"350"
	});
	$("#classGroup").validate({
		errorElement: "p",
		/*errorLabelContainer: "#validation-container",*/

		//debug:true,
		highlight: function(element, errorClass) {
		},
		unhighlight: function(element, errorClass) {
		},
		invalidHandler: function(e, validator) {
			/*var errors = validator.numberOfInvalids();
			if (errors) {
				$("div#validation-container").hide();
			} else {
				$("div#validation-container").hide();
			}*/
		},
		submitHandler: function(form) {
			$('#containerLoader').empty().html(loader);

			$.post(siteUrl +'yeargroups/addyeargroup/',$("#classGroup").serialize(),function(data)
			{
				//alert(data)	;
				//data = eval("(" + data + ")");
				if("undefined" == typeof(data.success))
				{
					var err = data.error.toString();
					$('#containerLoader').show().empty().html(err);
				}
				else
				{
					var id = data.id.toString();
					var ref = siteUrl +'yeargroups/';
					if($.trim($('#parentGroup').val())=="")
					{
						ref+="viewgroups/";	
					}
					else
					{
						ref+="classGroups/";	
					}
					window.location = ref+id;
				}
			},"json");
		},
	 	rules: {
		"data[classGroup][title]":  {required: true}
		},
		messages:
		{
		"data[classGroup][title]":{
			required: "Please enter class group title.",
		},
		"data[classGroup][student]":{
			required: "Please choose students to add in group.",
		}
		}
	});
	 
		if($('#parentGroup').val()!= "")
		{
			$("#studentDiv").show();
		}
		else
		{
			$("#studentDiv").hide();
		}
	 
});
</script>
<div class="upload-container">
	<?php
 		if($this->Session->read('user_type')!=4 &&  $this->Session->read('user_type')!=5) {?>
	<!--	<a id="addstudent" style="display:none;" class="browse-btn" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/student/0/<?php echo $group_id?>">
		Add New Student</a>-->
		<a id="addStudentToGroup" style="display:none;" class="browse-btn" href="<?php echo SITE_HTTP_URL?>yeargroups/assignUserToGroup/<?php echo $group_id?>">
		Add Another Student</a>
	<?php } ?>
	<?php if($show_yrgroup_link=='Y'){?>
 	<a href="javascript:void(0)" onclick="$('#add-groups').slideToggle('slow');" class="add-btn">Create a Year or Class group</a> 
	<?php }?>
	
	<!-- Search Form Start -->
	<?php echo $this->element('common/search'); ?>
	<!-- Search Form End -->
<br>


  	<div id="add-groups">
	<?php echo $this->Form->create('classGroup', array('action'=>'','type' => 'post','id'=>'classGroup','submit'=>'return false;')); ?>
		<div class="clr"></div>
		<div class="group-wrapper">	 
				<div class="group-section-first">
					<p>New group name:</p>
					 <?php echo $this->Form->input('classGroup.title',array('div'=>false,'label'=>false,"id"=>"title","maxlength"=>200, "style"=>"width:150px;"));?> 
				</div>
				<div class="group-section" >
					<p>File under another group:</p>
					<?php echo $this->Form->input('classGroup.parentGroup',array('type'=>'select','div'=>false,'label'=>false,'options'=>$parentGroups,'id'=>"parentGroup",'empty'=>'Please Select',"selected"=>$group_id));?>
				</div>
				<div class="group-section-last">
						<p>Link to other groups:</p>
						<select name="data[classGroup][otherGroups]" id="otherGroups" style="width:180px;"></select>
						<div class="clr"></div>
			 	</div>
				<div class="clr"></div>                                         
		</div>
		<div class="dotted-spacer"></div>
		<div class="group-wrapper">
				<div class="group-section-last" style="padding-left: 0pt ! important;" id="studentDiv">	
					<p>Add Students:</p>
					 <select name="data[classGroup][student]" id="student" style="width:180px;"></select>
					<div class="clr"></div>
		 		</div>
				<div class="clr"></div>
				<input type="submit" class="add-btn" value="Submit" name="btnSubmit" id="btnSubmit" style="border:0;padding: 5px 10px;height:22px;width:80px;"/>			 
				
				<div class="clr"></div>
		</div>
	</form>
	</div>
</div>

