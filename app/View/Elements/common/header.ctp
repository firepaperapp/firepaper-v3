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

<aside class="navigation">
<!--<div class="profile">
    <a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Project']['leader_id'];?>" class="name"><?php echo ucfirst(Sanitize::html($this->Session->read("firstname"), array('remove' => true)));?>
                <?php echo ucfirst(Sanitize::html($this->Session->read("lastname"), array('remove' => true)));?></a>
	</span>
</div>-->
<a href="<?php echo SITE_HTTP_URL?>logout" alt="Logout" class="logout-icon"></a>
<a href="<?php echo SITE_HTTP_URL?>users/settings/" alt="Settings" class="settings-icon" >⚙</a>
<!--<a class="activity-toggle" href="">🌎</a>-->
<a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="add-icon">✎</a>

<?php if (isset($cansignup) && $cansignup == 1) {?>

<?php } ?>
<a href="<?php echo SITE_HTTP_URL."dashboard/"?>" alt="Dashboard" class="header-logo"><img src="<?php echo IMAGES_PATH.'header-logo.png'; ?>" /></a>
</aside>