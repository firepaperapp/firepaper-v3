<?php
	$usertype = $this->Session->read('user_type');
?>
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
  $("#comment-dropdown").click(function(ev){
		ev.stopPropagation();		
			var $this = $(this), content = $(".panel");
				if (content.is(":visible")) {
				       return;
			    }
			    $(".panel").fadeOut('fast');
			       content.fadeIn();
		       });
		       
		       $(".panel").click(function(ev) {
			       ev.stopPropagation();
		       })
		      		       
		       $(document).click(function(){
			       $(".panel").fadeOut();
		       });
		       
	$('#nav-toggle').toggle(function(){
    $('.nav').css('display', 'none');
    $('.container').css('margin-left', '0');
    }, function(){
    $('.nav').css('display', 'block');
    $('.container').css('margin-left', '280px');
    });
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45888249-1', 'firepaperapp.com');
  ga('send', 'pageview');

</script>
<aside class="navigation">

<a href="javascript:void(0);" id="nav-toggle" alt="nav-toggle" class="nav-icon">☰</a>
<?php if($usertype==1 || $usertype==2 || $usertype==3 || $usertype==7) {?>
<a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="add-icon">✎</a>
<?php } else { } ?>
<div class="comment-icon-area">
	<a href="javascript:void(0);" alt="Comments" class="icon-comment" id="comment-dropdown" ></a>
<?php echo $this->requestAction("users/currentComments");?>
</div>
<?php if (isset($cansignup) && $cansignup == 1) {?>

<?php } ?>
<a href="<?php echo SITE_HTTP_URL."dashboard/"?>" alt="Dashboard" class="header-logo"><img src="<?php echo IMAGES_PATH.'header-logo.png'; ?>" /></a>
</aside>