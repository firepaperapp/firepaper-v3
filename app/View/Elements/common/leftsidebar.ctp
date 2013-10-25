<?php
	$userFullName = $this->Session->read("firstname")." ".$this->Session->read("lastname");
	$imagename = $this->Session->read('profilepic');
	
	if(is_file(USER_IMAGES_URL.'100X100/'.$imagename) && file_exists(USER_IMAGES_URL.'100X100/'.$imagename))
	{
		$userimage = USER_IMAGES_PATH.'100X100/'.$imagename;
	}
	else
	{
		$userimage = IMAGES_PATH.'profile-pic.png';
	}
	
	$usertype = $this->Session->read('user_type');
	$cansignup= $this->Session->read('cansignup');
	if (strlen($userFullName) > 45) {
	 	//$userFullName = substr($userFullName,0,45)."...";
	}	
?>


<section class="nav">
<img class="profile-image" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
<div class="clr"></div>
<?php if($this->Session->read("user_type")!=6) {?>
<ul>
	<li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" ><span>Dashboard</span> <i class="dashboard-icon">🚀</i></a></li>
             <!--<div class="projects-icon"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" >Projects</a></div>-->
             <?php 
            /*f($prjCount>0)
            {
            	//echo $prjCount;
            }*/?>
	<li><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" ><span>Files</span> <i class="files-icon">📰</i></a></li>
			  <!--<div class="user-icon"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" >Profile</a></div>-->
			    
            <!-- <a href="<?php echo SITE_HTTP_URL."search"?>" alt="Search" class="search-icon">Search</a> -->
<?php } ?>

		<!-- <?php if($this->Session->read("user_type")==6) {?>
		   <ul class="left">        	
				 <li class="<?php echo $profileMenu;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="user-icon">Profile</a></li>
				
		  </ul> -->

				<div class="<?php //echo $overviewAction;?>">
					<li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Overview" ><span>Overview</span> <i class="activity-icon"></i></a></li> 
				
				<!-- <li class="<?php echo $filesAction;?>"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="My Files" class="files-icon">My Files</a></li>
				
				<div class="<?php echo $whiteAction;?>"><a href="<?php echo SITE_HTTP_URL."whiteboards"?>" alt="Whiteboards" class="files-icon">Whiteboards</a></div>-->
				
				<?php if($usertype==1 || $usertype==7|| $usertype==3 ){?>
				<li><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Departments"> <span>Departments</span> <i class="departments-icon">🎓</i></a></li>
				<?php } ?>
				
				<?php if($usertype==1 ||  $usertype==2 || $usertype==7) {?>
				<li><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" ><span>Educators</span> <i class="educators-icon">👤</i></a></li>
				<?php }?>

				<?php if($usertype==1 ||  $usertype==2 || $usertype==3 || $usertype==7){?>
				<li><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" ><span>Students</span> <i class="students-icon">👥</i></a></li>
				
				<?php } ?>
           		<li><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" ><span>Profile details</span> <i class="profile-details-icon">👤</i></a></li>
           	 <?php if($usertype==6) {?>
						<li><a href="<?php echo SITE_HTTP_URL."users/mystudents";?>" alt="Students" ><span>Students</span> <i class="students-icon">👥</i></a></li>
			<?php } ?>
           	<?php if(in_array($this->Session->read('user_type'), array(4,5)))
           	 {?>
<li class="<?php echo $viewProgress;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" ><span>My Progress</span> <i class="progress-icon">📈</i></a></li>
			<?php
           	 }?>
           	 
           	 <?php
           	 if($usertype == 1)	 {?>
           	 	<li class="<?php //echo $coadmins;?>"><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" ><span>Co-Admins</span> <i class="students-icon">👥</i></a></li>
           	<?php 
           	 } if(in_array($usertype, array(1,2,3,7)))
			{	
           	?>
           	
           	<li>
           		<a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" ><span>Marking</span> <i>✎</i></a>
           	</li>
           	<li><a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" ><span>Create Project</span> <i>✎</i></a></li>
			<?php }?>
           		
			<li><a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" ><span>Due in</span><i>⚠</i></a></li>
			<?php
      
      foreach($departments as $rec)
      {
        //$active = "";
        if(isset($dept_id) && $dept_id == $rec['Department']['id']) {
          //$active = "active";
           
      ?>
				<li id="<?php //echo $rec['Department']['id'];?>"><a href="<?php echo SITE_HTTP_URL."projects/viewProjects/".$rec['Department']['id'];?>" alt="<?php echo $rec['Department']['title'];?>" "<?php //echo $deptProject;?>"><span><?php echo $rec['Department']['title'];?></span> <i class="projects-icon"></i></a></li>
			<?php }
			
			if(in_array($usertype, array(1,2,3,7)))
			{?>
				<li class="<?php //if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" ><span>Drafts</span> <i class="project-icon"></i></a></li>
			<?php
			}	
			?>	
			<li class="<?php //if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" ><span>Archive</span> <i class="project-icon"></i></a></li>
			
	
           	 
           	  
           	   	 
           	<?php
           		 //echo $this->requestAction("/files/getMyCategories");
			?>
			
				</ul>
	         <div class="clr"></div>
	        
	         <div class="user-functions">
             <a href="<?php echo SITE_HTTP_URL?>users/settings/" class="settings">Settings</a>
             <a href="<?php echo SITE_HTTP_URL?>logout">Logout</a>
          </div>
         </div><!-- end nav -->
  
</section>


