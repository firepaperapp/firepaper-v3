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

<div class="index files white">
	 <div class="upload-container">
                                 		
    		<a href="" class="button">Add another Student</a>
            <a href="javascript:animatedcollapse.toggle('add-groups')" class="button right">Create a Year or Class group</a>
    		<h3>Search:</h3>
            <input class="" value="Search">
            <div class="clr"></div>
            <div style="display: block;" fade="1" id="add-groups">
               <div class="group-wrapper">	 
               <div class="group-section-first">
                    <p>New group name:</p>
                    <input name="" type="text">
                    
                </div>
                
       	    <div class="group-section">
                    	<p>File under another group:</p>
                    	<select name="" width="140px">
                    	  <option selected="selected">Select a group</option>
       				  </select>
                    </div>
                    <div class="group-section-last">
                    	<p>Link to other groups:</p>
                    	<input name="" type="text"><a href="" class="add-btn">Add</a>
                        <div class="clr"></div>
                        <a href="" class="group-tab">Maths x</a> <a href="" class="group-tab">Spanish x</a>
                        
                    </div>
                    <div class="clr"></div>                                         
                </div>
               <div class="dotted-spacer"></div>
                 <div class="group-wrapper">
                 <div class="group-section-last" style="padding-left: 0pt ! important;">	
                    <p>Add Students:</p>
                    <input name="" type="text"><a href="" class="add-btn">Add</a>
                    <div class="clr"></div>
                    <p>Students Added:</p>
					<a href="" class="group-tab">Sam Berrow x</a> <a href="" class="group-tab">Neil Steven x</a>
                </div>
                <div class="clr"></div>
                <a href="" class="add-btn">Submit</a>
                <div class="clr"></div>
                </div>
            </div>
    </div>
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
