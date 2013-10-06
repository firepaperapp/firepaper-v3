<div class="header-signup">
  <div class="logo">
	  
  </div>
</div>
<script>
	function redirect(free)
	{
		var redirect = siteUrl+"signup/step1/"+$('#user_type').val();
		if(typeof(free)!="undefined")
		{
			redirect+="/"+free
		}
		window.location = redirect;
		
	}
</script>
<div class="main-signup">
	
		<?php echo $this->Form->input('user_type',array('type'=>'select','div'=>false,'class'=>'user_list','label'=>false,'options'=>$userTypes,'id'=>"user_type"));?>
		
		<p class="sign-in-link">
		<a href="#" class="sign-in" onclick="redirect();">Sign Up</a> or <a href="<?php echo SITE_HTTP_URL?>login" class="sign-in" >Login</a>
		</p>
		
		
</div>