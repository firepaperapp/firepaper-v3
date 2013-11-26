<?php
	$userFullName = $this->Session->read("firstname")." ".$this->Session->read("lastname");
	$imagename = $this->Session->read('profilepic');
	$userId = $this->Session->read('userid');
	
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
	/* 
	Admin == 1
	School == 2
	Educator == 3
	Student == 4
	Guardian == 6
	Co-admin == 7
	
	*/
?>

<div id="sidr" class="nav">
<a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$userId; ?>" alt="Profile" >
<img class="profile-image" height="50" width="50" src="<?php if (isset($userimage)) { echo $userimage; }?>" class="profile"/>
</a>
<a href="<?php echo SITE_HTTP_URL."users/viewProfile/".$userId; ?>" alt="<?php echo $userFullName; ?>" class="user-fullname"><?php echo $userFullName; ?></a>
<div class="clr"></div>
<?php //if($this->Session->read("user_type")!=6) {?>
<ul>
	<!--<li><a href="<?php echo SITE_HTTP_URL."users/viewProfile"?>" alt="Profile" ><span>Profile details</span> <i class="profile-details-icon">👤</i></a></li>-->
	<li><a href="<?php echo SITE_HTTP_URL."dashboard"?>" alt="Dashboard" ><span>Dashboard</span> <i class="dashboard-icon">🚀</i></a></li>
             <!--<div class="projects-icon"><a href="<?php echo SITE_HTTP_URL."projects"?>"  alt="Projects" >Projects</a></div>-->
             <?php 
            /*f($prjCount>0)
            {
            	//echo $prjCount;
            }*/?>
	<li><a href="<?php echo SITE_HTTP_URL."files/getFiles"?>" alt="Files" ><span>Files</span> <i class="files-icon">📰</i></a></li>
	<!-- <a href="<?php echo SITE_HTTP_URL."search"?>" alt="Search" class="search-icon">Search</a> -->
<?php //} ?>

	<?php if(in_array($usertype, array(1,3,7))){ ?>
		<li><a href="<?php echo SITE_HTTP_URL."departments"?>" alt="Departments"> <span>Departments</span> <i class="departments-icon">🎓</i></a></li>
	<?php } 
		if(in_array($usertype, array(1,2,7))){ ?>
		<li><a href="<?php echo SITE_HTTP_URL."listTeachers";?>" alt="Educators" ><span>Educators</span> <i class="educators-icon">👤</i></a></li>
	<?php }
		 if(in_array($usertype, array(1,2,3,7))){?>
		<li><a href="<?php echo SITE_HTTP_URL."yeargroups/viewgroups";?>" alt="Students" ><span>Students</span> <i class="students-icon">👥</i></a></li>
	<?php } 
		 if(in_array($usertype, array(1,6))){?>
		<li><a href="<?php echo SITE_HTTP_URL."users/mystudents";?>" alt="Students" ><span>Students</span> <i class="students-icon">👥</i></a></li>
	<?php } ?> 
	<h4>Projects</h4>
	<?php if(in_array($this->Session->read('user_type'), array())) { ?>
		<li><a href="<?php echo SITE_HTTP_URL."users/viewProgress"?>" alt="My Progress" ><span>My Progress</span> <i class="progress-icon">📈</i></a></li>
	<?php } 
		 if($usertype==1) { ?>
        <li><a href="<?php echo SITE_HTTP_URL."users/coadmins";?>" alt="Co-Admins" ><span>Co-Admins</span> <i class="students-icon">👥</i></a></li>
        
    <?php  }  if(in_array($usertype, array(1,2,3,7))) {	 ?>
        <li><a href="<?php echo SITE_HTTP_URL."projects/addEditProject"?>" alt="Create project" ><span>Create Project</span> <i>✎</i></a></li>
        <li><a href="<?php echo SITE_HTTP_URL."projects/markProjectsList"?>" alt="Marking" ><span>Marking</span> <i>✎</i></a></li>
	<?php }?>
        
	<?php
      /*
      foreach($departments as $rec)
      {
        //$active = "";
        if(isset($dept_id) && $dept_id == $rec['Department']['id']) {
          //$active = "active";
           
      ?>
		<li id="<?php //echo $rec['Department']['id'];?>"><a href="<?php echo SITE_HTTP_URL."projects/viewProjects/".$rec['Department']['id'];?>" alt="<?php echo $rec['Department']['title'];?>" "<?php //echo $deptProject;?>"><span><?php echo $rec['Department']['title'];?></span> <i class="projects-icon"></i></a></li>
			<?php } if(in_array($usertype, array(1,2,3,7))) {?>
				<li class="<?php //if($this->request->params['url']['url'] == "projects/draftProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/draftProjects"?>" alt="Archive" ><span>Drafts</span> <i class="project-icon"></i></a></li>
			<?php
			}	*/
			?>	
		
<li class="<?php //if($this->request->params['url']['url'] == "projects/archivedProjects") echo "active";?>"><a href="<?php echo SITE_HTTP_URL."projects/archivedProjects"?>" alt="Archive" ><span>Archive</span> <i></i></a></li>
<!--
		<li><a href="<?php echo SITE_HTTP_URL."projects"?>" alt="Due in" ><span>Due in</span><i>⚠</i></a></li>
-->
			<?php
           		 //echo $this->requestAction("/files/getMyCategories");
			?>
</ul>

			<?php if ($used <= 70) { ?>
	         <div class="space-warning">
	         <span class="title">Amount of space left: <?php //echo $userdata['User']['totalspace'] - $userdata['User']['usedspace'] ;?></span> <br>
	         <?php
			
			//print_r($userdata); exit;

			//if($userdata['Package']['unlimited'] == 0)
			if(1)
			{?>
			
            <div class="indicator-holder">
              <div class="indicator-bg">
				<?php
				$used = 0;
				if(!isNull($userdata['User']['totalspace']))
				{
					if($userdata['User']['usedspace']>0)
					{
						$used = round(($userdata['User']['usedspace']/$userdata['User']['totalspace'])*100,2);
					}
				}?>
                <div class="indicator-bar" style="width:<?php echo $used;?>%"><?php //echo $used;?></div>
              </div><!-- end indicator-bg -->
            </div><!-- end indicator-holder -->
		<?php
			} 
			
			?>
	         <a href="https://gum.co/QXnr" class="upgrade-btn">Add more space</a> <script type="text/javascript" src="https://gumroad.com/js/gumroad.js"></script>
	         <div class="clr"></div>
	         <span class="text">Order before you run out, process time can take a few hours</span>
	         </div>
	        <?php 
				}
/* echo $this->requestAction("/files/activityFilesProjectsDropbox"); */?>	        


	         <div class="user-functions">
             <a href="<?php echo SITE_HTTP_URL?>users/settings/" class="settings">Settings</a>
             <a href="<?php echo SITE_HTTP_URL?>logout">Logout</a>
          </div>
         </div><!-- end nav -->

</div>



