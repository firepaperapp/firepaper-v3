<script type="text/javascript">
jQuery.fn.topLink = function(settings) {
  settings = jQuery.extend({
    min: 1,
    fadeSpeed: 200
  }, settings);
  return this.each(function() {
    //listen for scroll
    var el = $(this);
    el.hide(); //in case the user forgot
    $(window).scroll(function() {
      if($(window).scrollTop() >= settings.min)
      {
        el.fadeIn(settings.fadeSpeed);
      }
      else
      {
        el.fadeOut(settings.fadeSpeed);
      }
    });
  });
};

//usage w/ smoothscroll
$(document).ready(function() {
  //set the link
  $('#top-link').topLink({
    min: 400,
    fadeSpeed: 500
  });
  //smoothscroll
  $('#top-link').click(function(e) {
    e.preventDefault();
    $.scrollTo(0,300);
  });
});
</script>


  	<div class="top">
  		<!--<div class="date-circle">
			<div class="m"><? print(Date("M")); ?></div>
		    <div class="d"><? print(Date("d")); ?></div>
		</div>-->
    	
         
<div class="navigation">
<div class="profile">
         		<img class="" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
      
                <a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Project']['leader_id'];?>" class="name"><?php echo ucfirst(Sanitize::html($this->Session->read("firstname"), array('remove' => true)));?>
                <?php echo ucfirst(Sanitize::html($this->Session->read("lastname"), array('remove' => true)));?></a>
                <span><?php if (isset($cansignup) && $cansignup == 1) {?>
					<a href="<?php echo SITE_HTTP_URL?>users/settings/" alt="Settings" >Settings</a> |
				<?php } ?><a href="<?php echo SITE_HTTP_URL."logout"?>" alt="Logout" class="grey"> Logout</a>
				</span>
			

    
</div><!-- end nav -->
<a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="button">Create a new Project</a>
</div><!-- end header -->
</div>