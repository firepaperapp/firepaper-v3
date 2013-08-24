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
<div class="leftcol">
  	<div class="top">
  		<div class="date-circle">
			<div class="m"><? print(Date("M")); ?></div>
		    <div class="d"><? print(Date("d")); ?></div>
		</div>
    	<div class="profile">
         		<img id="lhsimg" src="<?php echo $userimage;?>" class="profile"/>
         		<h3 class="name"><span>Hey</span></h3>
                <h3 class="name"><label id="lhsuname"><?php echo ucfirst(Sanitize::html($userFullName, array('remove' => true)));?></label></h3>
                <div class="options"><?php if($cansignup==1) {?>
					<a href="<?php echo SITE_HTTP_URL?>users/settings/" alt="Settings" >Settings</a> |
				<?php } ?><a href="<?php echo SITE_HTTP_URL."logout"?>" alt="Logout" class="grey"> Logout</a>
				</div>
                <br />
          </div><!-- profile -->
    </div><!-- end top -->
	
	
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
 		<?php if($this->Session->read("user_type")!=6) {?>
        <ul class="left">
        	<li class="<?php echo $dashboardMenu;?>"><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" class="dashboard-icon">Dashboard</a><span></span></li>
             <li class="<?php echo $projectMenu;?>"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" class="projects-icon">Projects</a><span><?php 
            if($prjCount>0)
            {
            	//echo $prjCount;
            }?></span></li>
			  <li class="<?php echo $fileMenu;?>"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" class="files-icon">Files</a></li>
			  
			    <li class="<?php echo $profileMenu;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="user-icon">Profile</a></li>
			    
            <!-- <li class="<?php echo $searchMenu;?>"><a href="<?php echo SITE_HTTP_URL."search"?>" alt="Search" class="search-icon">Search</a></li> -->

         </ul><!-- end ul left -->
		 <?php } ?>

		 <?php if($this->Session->read("user_type")==6) {?>
		   <ul class="left">        	
				 <li class="<?php echo $profileMenu;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="user-icon">Profile</a></li>
				
		  </ul><!-- end ul left -->
		 <?php } ?>
		
         <ul id="nav1">
           	<?php 
           	if($dashboardMenu!='')
           	{?>
				<li class="<?php echo $overviewAction;?>">
					<a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Overview" class="activity-icon">Overview</a>
				</li>
				<!-- <li class="<?php echo $filesAction;?>"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="My Files" class="files-icon">My Files</a></li>-->
				
				<li class="<?php echo $whiteAction;?>"><a href="<?php echo SITE_HTTP_URL."whiteboards"?>" alt="Whiteboards" class="files-icon">Whiteboards</a></li>
				
				<?php if($usertype==1 || $usertype==7||$usertype==3 ){?>
				<li class="<?php echo $departmentAction;?>"><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Departments" class="departments-icon"> Departments </a></li>
				<?php } ?>
				
				<?php if($usertype==1 ||  $usertype==2 || $usertype==7) {?>
				<li class="<?php echo $educatorsAction;?>"><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" class="educators-icon">Educators</a></li>
				<?php }?>

				<?php if($usertype==1 ||  $usertype==2 ||$usertype==3 || $usertype==7){?>
				<li class="<?php echo $studentsAction;?>"><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" class="students-icon">Students</a></li>
				
			
           	<?php }
			}
           	else if($profileMenu!='')
           	{?>
           		<li class="<?php echo $viewProfile;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="profile-details-icon">Profile details</a></li>
           	 <?php if($usertype==6)
					{?>
						<li class="<?php echo $profileMenu;?>"><a href="<?php echo SITE_HTTP_URL."users/mystudents";?>" alt="Students" class="students-icon">Students</a></li>
					<?php
					}
				?>
           	<?php if(in_array($this->Session->read('user_type'), array(4,5)))
           	 {?>
<li class="<?php echo $viewProgress;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" class="progress-icon">My Progress</a></li>
			<?php
           	 }?>
           	 <?php
           	 if($usertype == 1)	
           	 {?>
           	 	<li class="<?php echo $coadmins;?>"><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" class="students-icon">Co-Admins</a></li>           	 	
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
           	<li class="<?php echo $markProjectsList;?>"><a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" class="mark-icon">Marking</a></li><br />
           	<li class="<?php echo $addEditProject;?>"><a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" class="create-icon">Create Project</a></li><br />
			<?php }?>
           		
			<li class=""><a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" class="due-icon">Due in<?php if($dueInCount>0) //echo "<span>".$dueInCount."</span>";?></a></li>
			<?php
			
			foreach($departments as $rec)
			{
				$active = "";
				if(isset($dept_id) && $dept_id == $rec['Department']['id'])	
					$active = "active";
			?>
				<li class="<?php echo $active ;?>" id="deptSub_<?php echo $rec['Department']['id'];?>"><a href="<?php echo SITE_HTTP_URL."projects/viewProjects/".$rec['Department']['id'];?>" alt="<?php echo $rec['Department']['title'];?>" class="project-icon <?php echo $deptProject;?>"><?php echo $rec['Department']['title'];?></a></li>
			<?php
			}
			if(in_array($usertype, array(1,2,3,7)))
			{?>
				<li class="<?php if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" class="project-icon">Drafts</a></li>
			<?php
			}	
			?>	
			<li class="<?php if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" class="project-icon">Archive</a></li>
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
			
          </ul><!-- end ul right -->
         <div class="clr"></div>
</div><!-- end nav -->


<?php 
if($usertype!=6)
echo $this->requestAction("/files/activityFilesProjectsDropbox");?>
</div>


