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
<div class="profile">
         		<img class="" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
      
                <a href="<?php echo SITE_HTTP_URL?>users/viewProfile/<?php echo $prjDetails['Project']['leader_id'];?>" class="name"><?php echo ucfirst(Sanitize::html($this->Session->read("firstname"), array('remove' => true)));?>
                <?php echo ucfirst(Sanitize::html($this->Session->read("lastname"), array('remove' => true)));?></a>
				
				</span>
</div>
<a class="latest-activity" href=""></a>
 <div class="activity-panel-wrapper">
			<div class="activity-panel">
				<div class="upload-container">
					<p>Filter by: </p>
					<?php echo $this->Form->input('department',array('type'=>'select','div'=>false,'label'=>false,'options'=>$deptList,'id'=>"department_act","onchange"=>"getStuAndTeachers();","empty"=>"Please Select"));?>
					<span id="stuTeacher"></span>
				</div>
		 		<div id="gotActivity">
		 		<?php
		 		echo $this->requestAction("../dashboard/adminLatestActivity");
		 		?>
		 		</div>
		 	</div>
		 </div>
 		<?php
 		}
 		?>	
  	 </div><!-- end left -->        
   <div class="latest-activity">
     		<?php echo $this->requestAction("../users/currentComments");?>   
     		<?php 
if($usertype!=6)
echo $this->requestAction("../files/activityFilesProjectsDropbox");?>
  
 	</div><!-- end right -->
 	
<?php if (isset($cansignup) && $cansignup == 1) {?>
<a href="<?php echo SITE_HTTP_URL?>users/settings/" alt="Settings" class="settings-icon" ></a>
<?php } ?>


<a href="<?php echo SITE_HTTP_URL."logout"?>" alt="Logout" class="logout right"> Logout</a>
<a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="button">Create a new Project</a>

</aside>