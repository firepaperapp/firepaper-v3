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

	
	
	<?php

	$dashboardMenu = "";
	$profileMenu = "";
	$projectMenu = "";
	$searchMenu = "";
	$fileMenu = "";
	switch($this->request->params['controller'])
	{
		case "dashboard":
		case "yeargroups":
		case "whiteboards":
	 		$dashboardMenu = "active";
			$overviewAction = "";
			$educatorsAction = "";
			$studentsAction = "";
			$filesAction = "";
			$departmentAction = "";
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
			$viewProfile = "";
			$coadmins = "";
			$viewProgress = "";
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

<div class="nav">
	<div class="inner">
 		<?php if($this->Session->read("user_type")!=6) {?>
       
        	<div class="dashboard-icon"><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" >Projects</a></div>
             <!--<div class="projects-icon"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" >Projects</a></div>-->
             <?php 
            if($prjCount>0)
            {
            	//echo $prjCount;
            }?></span></li>
			  <div class="files-icon"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" >Files</a></div>
			  <!--<div class="user-icon"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" >Profile</a></div>-->
			    
            <!-- <a href="<?php echo SITE_HTTP_URL."search"?>" alt="Search" class="search-icon">Search</a> -->

		 <?php } ?>

		<!-- <?php if($this->Session->read("user_type")==6) {?>
		   <ul class="left">        	
				 <li class="<?php echo $profileMenu;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="user-icon">Profile</a></li>
				
		  </ul>< -->
		 <?php } ?>
		
         
           	<?php 
           	if($dashboardMenu!='')
           	{?>
				<div class="<?php echo $overviewAction;?>">
					<a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Overview" class="activity-icon">Overview</a>
				</div>
				<!-- <li class="<?php echo $filesAction;?>"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="My Files" class="files-icon">My Files</a></li>
				
				<div class="<?php echo $whiteAction;?>"><a href="<?php echo SITE_HTTP_URL."whiteboards"?>" alt="Whiteboards" class="files-icon">Whiteboards</a></div>-->
				
				<?php if($usertype==1 || $usertype==7||$usertype==3 ){?>
				<div  class="subjects-icon"><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Subjects"> Subjects </a></div>
				<?php } ?>
				
				<?php if($usertype==1 ||  $usertype==2 || $usertype==7) {?>
				<div class="user-icon"><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" class="educators-icon">Educators</a></div>
				<?php }?>

				<?php if($usertype==1 ||  $usertype==2 ||$usertype==3 || $usertype==7){?>
				<div class="user-icon"><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" class="students-icon">Students</a></div>
				
			
           	<?php }
			}
           	else if($profileMenu!='')
           	{?>
           		<div class="<?php echo $viewProfile;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="profile-details-icon">Profile details</a></div>
           	 <?php if($usertype==6)
					{?>
						<div class="user-icon"><a href="<?php echo SITE_HTTP_URL."users/mystudents";?>" alt="Students" class="students-icon">Students</a></div>
					<?php
					}
				?>
           	<?php if(in_array($this->Session->read('user_type'), array(4,5)))
           	 {?>
<div class="<?php echo $viewProgress;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" class="progress-icon">My Progress</a></div>
			<?php
           	 }?>
           	 <?php
           	 if($usertype == 1)	
           	 {?>
           	 	<div class="<?php echo $coadmins;?>"><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" class="students-icon">Co-Admins</a></div>           	 	
           	<?php 
           	 }
           	}
           	else if($projectMenu!='')
           	{ 
           		$markProjectsList = "";
           		$addEditProject = "";
           		$draftProjects = "";
           		$archivedProjects = "";
           		$deptProject = "";
           		 
	           	switch($this->request->params['action'])	
	           	{
	           		case "markProjectsList":
	           			$markProjectsList = "active";
	           			break;
	           		case "addEditProject":
	           			$addEditProject = "active";
	           			break;
	           		case "draftProjects":
	           			//$draftProjects = "active";
	           			break;
	           		case "archivedProjects":
	           			$archivedProjects = "active";
	           			break;	
	           		default:
	           			$deptProject = "active";	
	           	}
           	if(in_array($usertype, array(1,2,3,7)))
			{	
           	?>
           	<div class="<?php echo $markProjectsList;?>"><a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" class="mark-icon">Marking</a></div>
           	<div class="<?php echo $addEditProject;?>"><a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="create-icon">Create Project</a></div>
			<?php }?>
           		
			<div class=""><a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" class="due-icon">Due in<?php if($dueInCount>0) //echo "<span>".$dueInCount."</span>";?></a></div>
			<?php
			
			foreach($departments as $rec)
			{
				$active = "";
				if(isset($dept_id) && $dept_id == $rec['Department']['id'])	
					$active = "active";
			?>
				<div class="<?php echo $active ;?>" id="deptSub_<?php echo $rec['Department']['id'];?>"><a href="<?php echo SITE_HTTP_URL."projects/viewProjects/".$rec['Department']['id'];?>" alt="<?php echo $rec['Department']['title'];?>" class="project-icon <?php echo $deptProject;?>"><?php echo $rec['Department']['title'];?></a></div>
			<?php
			}
			if(in_array($usertype, array(1,2,3,7)))
			{?>
				<div class="<?php if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" class="project-icon">Drafts</a></div>
			<?php
			}	
			?>	
			<div class="<?php if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" class="project-icon">Archive</a></div>
			<?php }
			else if($searchMenu!='')
			{?>
				 
			<?php } 
			
			else if($fileMenu!='')
           	{?> 
           	 
           	  
           	   	 
           	<?php
           		echo $this->requestAction("/files/getMyCategories");
           	}
			?>
			
         
	         <div class="clr"></div>
	         </div><!-- end nav -->

         </div><!-- end nav -->

</div>


