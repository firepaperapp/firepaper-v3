
	<div class="white files index">
	
	<?php echo $this->requestAction("/dashboard/addyeargroup");?>
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
	

	            <div class="clr"></div>
	        </div>
	   </div>
