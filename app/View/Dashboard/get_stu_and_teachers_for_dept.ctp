<?php echo $this->Form->input('teacher',array('type'=>'select','div'=>false,'label'=>false,'options'=>$teachers,'id'=>"teacher_act","onchange"=>"getActivityFor();", "empty"=>"Educators"));?>
<select name="students" id="students_act" onchange="getActivityFor();">
<option value="">Students</option>
<?php
foreach ($students as $rec)
{?>
	<option value="<?php echo $rec['userdetail']['id']?>"><?php 
	echo $rec['userdetail']['name'];
	if($rec['userdetail']['class']!="")
	{
		echo "(".trim($rec['userdetail']['class']).")";
	}	
	?></option>
<?php
}
?>
</select>