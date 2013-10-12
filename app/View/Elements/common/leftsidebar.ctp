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
	$cansignup = $this->Session->read('cansignup');
	if (strlen($userFullName) > 45) {
	 	//$userFullName = substr($userFullName,0,45)."...";
	}	
?>
<?php
	//Permissions for usertypes
	$dashboardMenu = "active";
	$profileMenu = "active";
	$projectMenu = "active";
	$searchMenu = "active";
	$fileMenu = "active";
	switch($this->request->params['controller'])
	{
		case "dashboard":
		case "yeargroups":
		case "whiteboards":
	 		$dashboardMenu = "active";
			$overviewAction = "active";
			$educatorsAction = "active";
			$studentsAction = "active";
			$filesAction = "active";
			$departmentAction = "active";
			$whiteAction = "";
			switch($this->request->params['action'])
			{	
				/** Files handling starts here **/			
				case "getFiles":
					$filesAction = "active";
					break;
				/** Files handling end here **/
				case "listTeachers":
					$educatorsAction = "active";
					break;
				case "departments":
		 			$departmentAction = "active";
					break;
				case "index":
					if($this->request->params['controller'] == "whiteboards")
		 				$whiteAction = "active";
		 			else 
		 				$overviewAction = "active";
					break;
				case "classGroups":
	 			case "viewgroups":					
		 			$studentsAction = "active";
					break;	
		 		default:
					$overviewAction = "active";
			}
			break;
		case "files":
			$fileMenu = "active";
			switch($this->request->params['action'])
			{	
				/** Files handling starts here **/			
				case "getFiles":
					$filesAction = "active";
					break;
				default:
					$filesAction = "active";
			}
			break;
		case "users":
			$profileMenu = "active";
			$viewProfile = "active";
			$coadmins = "active";
			$viewProgress = "active";
			switch($this->request->params['action'])
			{
				case "viewProfile":
					$viewProfile = "active";
					break;
				case "viewProgress":
					$viewProgress = "active";
					break;
				case "coadmins":
					$coadmins = "active";
				
				default:
					$viewProfile = "active";
					break;
			}
			break;
		case "projects":
			$projectMenu = "active";
			break;
	 		break;
		case "search":
			$searchMenu = "active";
			break;
	}
	?>

<section class="nav">
<!--<a href="<?php echo SITE_HTTP_URL ?>/<?php echo $userId; ?>" >-->
<img class="profile-image" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
<!--</a>-->

<div class="clr"></div>
<?php if($this->Session->read("user_type")!=6) {?>
     <ul>
        <li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" ><span>Dashboard</span> <i class="dashboard-icon">🚀</i></a></li>
             
             <?php 
            if(isset($prjCount) && $prjCount>0)
            {
            	echo $prjCount;
            }?></li>
			  <li><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" ><span>Files</span> <i class="files-icon">📁</i></a></li>
			 
			    
            <!-- <a href="<?php echo SITE_HTTP_URL."search"?>" alt="Search" class="search-icon">Search</a> -->

		 <?php } ?>
         
           	<?php 
           	if($dashboardMenu!='')
           	{?>
				
				<?php if(in_array($this->Session->read('user_type'), array(1,2,3,7))){?>
				<li><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Departments"> <span>Departments</span> <i class="departments-icon">🎓</i></a></li>
				<?php } ?>
				
				<?php if(in_array($this->Session->read('user_type'), array(1,2,7))) {?>
				<li><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" ><span>Educators</span> <i class="educators-icon">👤</i></a></li>
				<?php }?>
				
				<?php if($usertype==4) {?>
				<li class="<?php echo $viewProgress;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" ><span>My Progress</span> <i class="progress-icon">📈</i></a></li>	
				<?php }?>
				<?php if(in_array($this->Session->read('user_type'), array(1,2,3,7))){?>
				<li><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" ><span>Students</span> <i class="students-icon">👥</i></a></li>
				<?php } ?>
			
				<h4>Projects</h4>
				
				<!--<div class="projects-icon"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" >Projects</a></div>-->
				
				<?php if(in_array($this->Session->read('user_type'), array(1,2,3,7))) {?>
				<li>
           		<a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" ><span>Marking</span> <i class="mark-icon">✎</i></a>
           		</li>
           		
           		<li class="<?php if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" ><span>Drafts</span> <i class="project-icon">📰</i></a></li>
           		
           		<?php } ?>
           		
           		<?php if(in_array($this->Session->read('user_type'), array(1,2,3,4,7))) {?>
           		<li>
           		<a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" ><span>Due in</span><?php if($dueInCount>0) echo "<span class='duein'>".$dueInCount."</span>";?> <i class="due-icon">⚠</i></a></li>
           		<li class="<?php if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" ><span>Archive</span> <i class="project-icon">💼</i></a>
           		</li>
           		
           		<?php } ?>
           		
           		<?php
           	 if($usertype == 1)	
           	 {?>
           	 	<li class="<?php echo $coadmins;?>"><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" ><span>Co-Admins</span> <i class="students-icon">👥</i></a></li>           	 	
           	<?php } ?>
			
			
           
           	           	   	 
           	<?php
           		echo $this->requestAction("/files/getMyCategories");
           	}
			?>
			
				</ul>
	         <div class="clr"></div>
	        
	          <div class="user-functions">
		         <a href="<?php echo SITE_HTTP_URL?>users/settings/" class="settings">Settings</a>
		         <a href="<?php echo SITE_HTTP_URL?>logout">Logout</a>
		      </div>
         </div><!-- end nav -->
  
</section>


