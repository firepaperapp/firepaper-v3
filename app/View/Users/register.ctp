
<script type="text/javascript">
$(document).ready(function() {
	$("#addEditUserForm").validate();
});
</script>

<div class="Middlecontainer" style="width:700px;"> <!-- Middlecontainer start here -->
  <h1 class="heading">Create Account Of New User</h1><br>
  <form action="<?php echo COMMON_URL; ?>/users/register" name="addEditUserForm" id="addEditUserForm" method="post" >
  <table width="100%" border="0" cellspacing="2" cellpadding="2" height="43" class="layout">
	<tr>
		<td colspan="4">
		<div class="fl" style="padding:5px;">
		<?php if(isset($errMsg)) { ?>
		<div class="txt_red" align="center" ><?php echo $this->Utility->display_message($errMsg,'errmsg',1); ?></div>
		<?php } ?>
		<div class="successmsg" align="center" ><strong><?php $this->Session->flash();?></strong></div>
	</tr>
	<tr>
		<td> USER NAME</td>
		<td><?php echo $this->Form->input('User.username',array('id' => 'username','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> PASSWORD
		</td>
		<td><?php echo $this->Form->password('User.password',array('id' => 'password','label' => false,'class' => 'input required','div' => '','MINLENGTH'=>'5','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> CONFIRM PASSWORD
		</td>
		<td><?php echo $this->Form->password('confirm_password',array('id' => 'confirm_password','label' => false,'class' => 'input required','div' => '','MINLENGTH'=>'5','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td>   	USER TYPE
		</td>
		<td>
		<select name="data[User][usertype]" id="usertype" style="width:154px;" class="required " >
			<option value="" >- -Select User Type- -</option>
		   <?php foreach($userTypes as $val ){?>
			 <option value="<?php echo $val['id'];?>" <?php if($this->request->data['User']['usertype'] == $val['id']){?> selected="selected" <?php }?> ><?php echo $val['type'];?></option>
			<?php  }?>
			 </select>
		</td>
	</tr>
	<tr>
		<td> FIRST NAME
		</td>
		<td><?php echo $this->Form->input('User.first_name',array('id' => 'first_name','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td>   	LAST NAME
		</td>
		<td><?php echo $this->Form->input('User.last_name',array('id' => 'last_name','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td>   	EMAIL
		</td>
		<td><?php echo $this->Form->input('User.email',array('id' => 'email','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> ADDRESS
		</td>
		<td><?php echo $this->Form->textarea('User.address',array('id' => 'address','label' => false,'div' => ''));?>
		</td>
	</tr>
	<tr>
		<td> PHONE
		</td>
		<td><?php echo $this->Form->input('User.phone',array('id' => 'phone','label' => false,'class' => 'input required','div' => '','MINLENGTH'=>'10','MAXLENGTH'=>'20'));?>
		</td>
	</tr>

	<tr>
		<td> COUNTRY
		</td>
		<td>
<select name="data[User][country]" id="country" style="width:154px;" class="required " onchange="selectState(document.getElementById('country').value);">
			<option value="" >- -Select Country- -</option>
		   <?php foreach($countrylist as $val ){?>
			 <option value="<?php echo $val['id'];?>" <?php if($this->request->data['User']['country'] == $val['id']){?> selected="selected" <?php }?> ><?php echo $val['name'];?></option>
			<?php  }?>
			 </select>
		</td>
	</tr>
	<tr>
		<td> STATE
		</td>
		<td><?php echo $this->Form->input('User.state',array('id' => 'state','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>

		</td>
	</tr>
	<tr>
		<td> CITY
		</td>
		<td><?php echo $this->Form->input('User.city',array('id' => 'city','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> ZIPCODE
		</td>
		<td><?php echo $this->Form->input('User.zipcode',array('id' => 'zipcode','label' => false,'class' => 'input required','div' => '','MAXLENGTH'=>'30'));?>
		</td>
	</tr>
	<tr>
		<td> DOB
		</td>
		<td><?php
echo $this->Form->day('User.dob', date('d'), array('id' => 'FieldId-dd'), false)." - ";
echo $this->Form->month('User.dob', date('m'), array('id' => 'FieldId-mm'), false)." - ";
echo $this->Form->year('User.dob', '1950', date('Y'), null, array('id' => 'FieldId', 'class' => 'w8em split-date divider-dash highlight-days-12 no-transparency'), false);
?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="submit"  name="data[cmdSubmit]" class="button" value="Register"/>
		</td>
	</tr>


</table>
</form>
 </div>