


<form name="CATUpload" method="POST" enctype="multipart/form-data" action="<?php echo COMMON_URL; ?>/deep/index">
<table>
<tr>
	<td>
	name:- <?php echo $this->Form->input('User.username',array('id' => 'username','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
	</td>
</tr>
<tr>
	<td>
		<input type = "file" name ="data[catxml]" >
	</td>
</tr>
<tr>
	<td>
		<input type = "submit" name = "data[cmdSubmit]" value = "upload">
	</td>
</tr>
</table>
</form>