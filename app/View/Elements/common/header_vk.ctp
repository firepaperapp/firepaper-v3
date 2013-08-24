<div class="header">

<h1><span><?php echo ucfirst(Sanitize::html($this->Session->read("firstname"), array('remove' => true)));?></span>&nbsp;<?php echo ucfirst(Sanitize::html($this->Session->read("lastname"), array('remove' => true)));?></h1>

</div><!-- end header -->



<?php
	$params['controller'] = 'whiteboards';
	$dashboardMenu = "active";
	$profileMenu = "active";
	$projectMenu = "active";
	$searchMenu = "active";
	$fileMenu = "active";
	switch($params['controller'])
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
			$whiteAction = "active";
			switch($params['action'])
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
					if($params['controller'] == "whiteboards")
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
			switch($params['action'])
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
			$viewProgress = "";
			switch($params['action'])
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
<div class="navigation">

 		<?php if($user_type !=6) {?>
        <ul class="menu">
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

		 <?php if($user_type ==6) {?>
		   <ul class="menu">        	
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
           		 
	           	switch($params['action'])	
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
				<li class="<?php if($params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" class="project-icon">Drafts</a></li>
			<?php
			}	
			?>	
			<li class="<?php if($params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" class="project-icon">Archive</a></li>
			<?php }
			else if($searchMenu!='')
			{?>
				 
			<?php } 
			
			else if($fileMenu!='')
           	{?> 
           	 
           	  
           	   	 
           	<?php
           		echo $requestAction("/files/getMyCategories");
           	}
			?>
			
          </ul><!-- end ul right -->
         <div class="clr"></div>
</div><!-- end nav -->
</div>
