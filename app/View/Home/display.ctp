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
	
		<?php echo $this->Form->input('user_type',array('type'=>'select','div'=>false,'label'=>false,'options'=>$userTypes,'id'=>"user_type"));?>
		
		<p class="sign-in-link">
		<a href="#" onclick="redirect();">Sign Up</a> or <a href="<?php echo SITE_HTTP_URL?>login" class="submit" >Login</a>
		</p>
		
		
</div>