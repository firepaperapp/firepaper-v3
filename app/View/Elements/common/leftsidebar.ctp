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

<section class="nav">
<img class="profile-image" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
<div class="clr"></div>
<?php if($this->Session->read("user_type")!=6) {?>
     <ul>
        <li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" class="dashboard-icon">Dashboard </a></li>
             <!--<div class="projects-icon"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" >Projects</a></div>-->
             <?php 
            if($prjCount>0)
            {
            	//echo $prjCount;
            }?></li>
			  <li><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" class="files-icon">Files </a></li>
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
					<li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Overview" >Overview </a><span class="activity-icon"></span></li> 
				
				<!-- <li class="<?php echo $filesAction;?>"><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="My Files" class="files-icon">My Files</a></li>
				
				<div class="<?php echo $whiteAction;?>"><a href="<?php echo SITE_HTTP_URL."whiteboards"?>" alt="Whiteboards" class="files-icon">Whiteboards</a></div>-->
				
				<?php if($usertype==1 || $usertype==7||$usertype==3 ){?>
				<li><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Subjects"> Subjects </a><span class="departments-icon"></span></li>
				<?php } ?>
				
				<?php if($usertype==1 ||  $usertype==2 || $usertype==7) {?>
				<li><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" >Educators </a><span class="educators-icon"></span></li>
				<?php }?>

				<?php if($usertype==1 ||  $usertype==2 ||$usertype==3 || $usertype==7){?>
				<li><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" >Students </a><span class="students-icon"></span></li>
				
			
           	<?php }
			}
           	else if($profileMenu!='')
           	{?>
           		<li class="<?php echo $viewProfile;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" class="profile-details-icon">Profile details</a></li>
           	 <?php if($usertype==6)
					{?>
						<li><a href="<?php echo SITE_HTTP_URL."users/mystudents";?>" alt="Students" >Students </a><span class="students-icon"></span></li>
					<?php
					}
				?>
           	<?php if(in_array($this->Session->read('user_type'), array(4,5)))
           	 {?>
<li class="<?php echo $viewProgress;?>"><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" >My Progress </a><span class="progress-icon"></span></li>
			<?php
           	 }?>
           	 <?php
           	 if($usertype == 1)	
           	 {?>
           	 	<li class="<?php echo $coadmins;?>"><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" >Co-Admins </a><span class="students-icon"></span></li>           	 	
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
           	<li class="<?php echo $markProjectsList;?>">
           		<a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" class="mark-icon">Marking</a>
           	</li>
           	<li class="<?php echo $addEditProject;?>"><a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" >Create Project </a><span class="create-icon"></span></li>
			<?php }?>
           		
			<li><a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" class="due-icon">Due in<?php if($dueInCount>0) //echo "<span>".$dueInCount."</span>";?> </a><span></span></li>
			<?php
			
			foreach($departments as $rec)
			{
				$active = "";
				if(isset($dept_id) && $dept_id == $rec['Department']['id'])	
					$active = "active";
			?>
				<li class="<?php echo $active ;?>" id="deptSub_<?php echo $rec['Department']['id'];?>"><a href="<?php echo SITE_HTTP_URL."projects/viewProjects/".$rec['Department']['id'];?>" alt="<?php echo $rec['Department']['title'];?>" class="project-icon <?php echo $deptProject;?>"><?php echo $rec['Department']['title'];?> <span class="projects-icon"></span></a></li>
			<?php
			}
			if(in_array($usertype, array(1,2,3,7)))
			{?>
				<li class="<?php if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" class="project-icon">Drafts</a></li>
			<?php
			}	
			?>	
			<li class="<?php if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" >Archive </a><span class="project-icon"></span></li>
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
			
				</ul>
	         <div class="clr"></div>
	        
	          <footer class="footer"></div>
         </div><!-- end nav -->
  
</section>


