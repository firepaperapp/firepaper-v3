<script src="<?php echo JS_PATH?>jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script type="text/javascript">
$(document).ready(function(){
                $("#addstudent").fancybox({
			ajax : {
			type	: "POST",
			}
		});
});
</script>
<div class="validation-signup" id="validation-container" style="<?php if(!isset($errMsg)){ echo 'display:none;';} ?>">
<?php
if(isset($errMsg))
{
	echo $this->Utility->display_message($errMsg);	
} 
?>
</div>
<div class="activity">
	<div class="index">
	<h3>Students</h3>
	<?php echo $this->requestAction("/yeargroups/addyeargroup");?>
    <div class="clr-spacer"></div>
    <div class="bread">
    	<div class="crumb">
    		<h2>Home</h2>
    		<em>6 Year Groups</em>
    	</div>
    	<div class="crumb">
    		<h2>Year 11</h2>
    		<em>6 Class Groups</em>
    	</div>
    	<div class="crumb">
    		<h2>Class 11S</h2>
    		<em>10 Students</em>
    	</div>
    </div>
	<?php if($this->Session->read('user_type')!=4 &&  $this->Session->read('user_type')!=5) {?>
	<p style="text-align:right;">
		<a id="addstudent" href="<?php echo SITE_HTTP_URL?>dashboard/addNewUser/student/1">
		Add New Student</a></p>
	<?php }?>
	<div class="clr-spacer"></div>
	    	<div class="row">
	        	<div class="user-box-left">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11A</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>  
	            
	            <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11A</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            
	             <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11A</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            <div class="clr"></div>
	        </div>
	        
	        <div class="row">
	        	<div class="user-box-left">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11A</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>  
	            
	            <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11S</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            
	             <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11S</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            <div class="clr"></div>
	        </div>
	        <div class="row">
	        	<div class="user-box-left">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11S</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>  
	            
	            <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11S</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            
	             <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11F</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            <div class="clr"></div>
	        </div>
	        <div class="row">
	        	<div class="user-box-left">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11F</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>  
	            
	            <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11F</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            
	             <div class="user-box">
	            	<img src="<?php echo IMAGES_PATH;?>neil.gif" class="profile" />
	                <div class="links">
	                <p class="title">Neil Berrow</p>
	                <p><a href="#">Class 11F</a></p>
	                <p><a href="#">View info</a></p>
	                <p><a href="#">View message</a></p>
	                </div>
	            </div>
	            <div class="clr"></div>
	        </div>
	   </div>
</div><!-- end activity -->