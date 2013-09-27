<?php
App::uses('Sanitize', 'Utility');
class ProjectsController  extends AppController{

	var $name = 'Projects';

	var $uses = array('Project','projComments','Subject','User','projectTask','userFile','classGroup','classgroupStudent','projectStudentTaskDoc','projectStudent','Project', 'projectStudentTaskMark','SubjectEducator','projectTaskExtraDoc','Whiteboard');

	var $helpers = array('Flash');
	var $layout = "default_front_inner";
	var $components = array('RequestHandler','Email');
	
	  /**
	 * Determines if user will have option to set a cookie based login.
	 *
	 * @access public
	 * @var boolean
	 */
	var $allowCookie = TRUE;

	 /**
	 * Determines length of cookie lifespan.
	 * Use string based date syntax, since strtotime will be applied to value.
	 *
	 * @access public
	 * @var string
	 */
	var $cookieTerm = '+4 weeks';

     function beforeRender()
    {
    	parent::beforeRender();
    	
    }
	function beforeFilter()
	{
	 	if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
 		parent::beforeFilter();
	}

    /**
	 * Checks for allowCookie value and sets proper view value.
	 *
	 * @returns NULL
	 */
    function __configureAuthCookie(){
	    
	}
	/**
	 * @uses This function is used to render the homepage view
	 * @input NULL
	 * @returns NULL
	 */

	function index($dept_id=0){ 
 		
 		 $this->set("dept_id", $dept_id);
	}
	function getLatestProjects($dept_id=0)
	{
		$owner = 0;
		$userId = $this->Session->read('userid');
		$filters = "";
		$this->set("dept_id", $dept_id);
		if(!isNull($dept_id))
		{
			$filters = "Subject.department_id = ".$dept_id." AND ";
		}
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 || $this->Session->read('user_type')==3)
		{
			$owner = 1;
			$admin_id = $this->getAdminId();
			//$filters = "Project.admin_id= ".$this->Session->read('userid')." AND ";
			$filters .= "Project.admin_id= ".$admin_id." AND ";
			$currentProjects = $this->Project->find("all", $this->Project->getLatestProjects($filters));
		}
		else if($this->Session->read('user_type')==2)
		{ 
			$owner = 1;
			$filters .= "Project.leader_id=".$this->Session->read('userid')." AND ";
			$currentProjects = $this->Project->find("all", $this->Project->getLatestProjects($filters));
		}
		else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{ 				
			$filters .= "projectStudent.user_id = ".$userId." AND ";
	 	 	$this->projectStudent->unbindModel(array("belongsTo"=>array("Project")));
	 	 	$currentProjects = $this->projectStudent->find("all", $this->Project->getLatestProjectsForUser($filters));
	 	 	
		}
	 	$this->set("owner", $owner);
 	  	$this->set("data", $currentProjects);
 	  	$this->render("current_projects");
	}
	/**
	 * To view all the projects
	 * 
	 */
	function viewAllProjects($dept_id=0)
	{
		$this->set("dept_id", $dept_id);
	}
	function viewAllProjectsInner($dept_id=0)
	{
		$owner = 0;
		$filters = "";
		$userId = $this->Session->read('userid');
		$this->set("dept_id", $dept_id);
		if(!isNull($dept_id))
		{
			$filters = "Subject.department_id = ".$dept_id." AND ";
		}
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7|| $this->Session->read('user_type')==3)
		{
			$owner = 1;
			$key = "Project";
			$admin_id = $this->getAdminId();
			//$filters = "Project.admin_id= ".$this->Session->read('userid')." AND ";
			$filters .= "Project.admin_id= ".$admin_id." AND ";
			$this->paginate = array('Project'=> $this->Project->getLatestProjects($filters, 0));
			$data = $this->paginate('Project');
		}
		else if($this->Session->read('user_type')==2 )
		{ 
			$owner = 1;
			$key = "Project";
			$filters .= "Project.leader_id=".$this->Session->read('userid')." AND ";
			$this->paginate = array('Project'=> $this->Project->getLatestProjects($filters, 0));
			$data = $this->paginate('Project');
		}
		else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{ 				
	 	 	$this->projectStudent->unbindModel(array("belongsTo"=>array("Project")));
	 	 	$filters .= "projectStudent.user_id = ".$userId." AND ";
	 	 	$this->paginate = array('projectStudent'=> $this->Project->getLatestProjectsForUser($filters, 0));	$this->projectStudent->unbindModel(array("belongsTo"=>array("Project")));
	 	 	$data = $this->paginate('projectStudent');
	 	 	$key = "projectStudent";
		}		
		$totalPages = isset($this->request->params['paging'][$key]['pageCount'])?$this->request->params['paging'][$key]['pageCount']:"";
 		
   		$order = isset($this->request->params['paging'][$key]['options']['order'])?$this->request->params['paging'][$key]['options']['order']:"";
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";	
   		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
	 	$this->set("owner", $data);
 	  	$this->set("data", $data);
  	}
	function activityFilesProjectsDropbox()
	{
		
		$this->render("dropbox");
	}
	function archived()
	{
		$filters = "";
		$joins ="";
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 || $this->Session->read('user_type')==3)
		{
			$admin_id = $this->getAdminId();
			//$filters = "Project.admin_id= ".$this->Session->read('userid')." AND ";
			$filters = "Project.admin_id= ".$admin_id." AND ";
		}
		else if($this->Session->read('user_type')==2)
		{ 
			$filters = "Project.leader_id=".$this->Session->read('userid')." AND ";
		}
		else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{ 			
			$joins = array(
						array(
						"type"=>"inner",
						"table"=>"project_students",
						"alias"=>"projectStudent",
						"conditions"=>"Project.id = projectStudent.project_id AND projectStudent.user_id=". $this->Session->read('userid')
						) );
		}
		$filters .= "  (Project.published=2) " ;
		$data = $this->Project->find('all', array(
   		"conditions"=>$filters,
   		"fields"=> "Project.id, Project.title, Project.admin_id,Project.created",
		"joins"=>$joins,
   		"order"=>"Project.created DESC",
		"group"=>"Project.id",
		"limit"=>10
   		)
   		);
		$this->set("projectData", $data );		
		
		$this->render("archived");
	}
	/**
	 * This function will be used to show the details of the project whose id will be passed
	 * 
	 * @param int $project_id
	 */
	function viewDetails($project_id)
	{
		//project detail
		$prjDetails = $this->Project->find('first', array(
			"conditions"=>"Project.id = ".$project_id,
			"fields"=>"Project.*, Subject.title, UserAdmin.status, UserAdmin.email, User.profilepic,
			User.email, User.status,User.firstname, User.lastname",
			"joins"=>array(
	 							array("type"=>"inner",
	 							"table"=>"subjects",
	 							"alias"=>"Subject",
	 							"conditions"=>array("Subject.id = Project.subject_id")
	 							),
	 							array("type"=>"inner",
	 							"table"=>"users",
	 							"alias"=>"User",
	 							"conditions"=>array("User.id = Project.leader_id")
	 							) 							 							
	 							,
	 							array("type"=>"inner",
	 							"table"=>"users",
	 							"alias"=>"UserAdmin",
	 							"conditions"=>array("UserAdmin.id = Project.admin_id")
	 							)
	 						)	
	 		)
		);		
	  	if(count($prjDetails) > 0 && isset($prjDetails['Project']['id']))
		{
			//project related task details
			$userId = $this->Session->read("userid");
			$isOwner = 0;
			$getMarksAlso = 0;
			$howMuchCompleted = 0;
			$vistor = 0;
			$isUserAdded = array();
			$dataWhiteboards = array();
	 		if($userId == $prjDetails['Project']['leader_id'] || $userId == $prjDetails['Project']['admin_id'] || ($this->Session->read("user_type") == 7 && $prjDetails['Project']['admin_id'] == $this->Session->read("admin_id")))
			{
				$isOwner = 1;
		 	}	
		 	else 
		 	{	
		 		$isUserAdded = $this->projectStudent->find("first", 
		 		array(
		 			"conditions"=>"project_id = ".$project_id." and user_id = ".$userId,
		 			"fields"=>"projectStudent.id, projectStudent.completed"
		 			)
		 		);
		 	 	if(count($isUserAdded)>0 && isset($isUserAdded['projectStudent']['id'])) 	
		 		{
		 			$getMarksAlso = 1;
			 		$howMuchCompleted = $this->howMuchCompleted($project_id, $userId);
		 		}
		 		else 
		 		{
			 		$vistor = 1;
		 		}
		 	}
	 		$tasks = $this->Project->getTasks($project_id, $userId, $getMarksAlso);
	  		 
	 		 
 			//We suppose that this is a view for the user, so comments will be posted to him only 
  			$posted_to = $prjDetails['Project']['leader_id'];
			//To get the comments on the project
			$projComments = $this->projComments->find("all", array(
			"conditions"=>"projComments.comment_type = 'project' and projComments.project_id = ".$project_id,
			"fields"=>"projComments.*, User.id, User.profilepic, User.firstname, User.lastname",
	   		"joins"=>array(
					array("type"=>"inner",
					"table"=>"users",
					"alias"=>"User",
					"conditions"=>array("User.id = projComments.posted_by")),
					)
				
			));
			$noOfTasks = count($tasks); 
			
			$qry = "SELECT DISTINCT(task_id) 
					FROM project_student_task_docs 
					WHERE project_id = ".$project_id." AND user_id = ".$userId;
			$taksDone = count($this->Project->query($qry));
			$this->set("noOfTasks", $noOfTasks);
			$this->set("taksDone", $taksDone);
			
			if($prjDetails['Project']['whiteboards']!='')
			{
				 $prjDetails['Project']['whiteboards'] = rtrim($prjDetails['Project']['whiteboards'],",");
				$dataWhiteboards = $this->Whiteboard->find('all', array(
	 			 "conditions"=>"Whiteboard.id IN (".$prjDetails['Project']['whiteboards'].")",
	 			 "fields"=>"Whiteboard.id, Whiteboard.title"
 				 ));
		 		$i = 0;
		 	 	 
			 }
			 //we will get
			 $this->set("data", $prjDetails);
			 
			$this->set("vistor", $vistor);
			$this->set("isUserAdded", $isUserAdded);
			$this->set("projComments", $projComments);
			$this->set("isOwner", $isOwner);
			$this->set("howMuchCompleted", $howMuchCompleted);
			$this->set("posted_to", $posted_to);
			$this->set("project_id", $project_id);
 			$this->set("tasks", $tasks);
			$this->set("prjDetails", $prjDetails);
			$this->set("dataWhiteboards", $dataWhiteboards);
	 	}
		else 
		{
			//Project does not exist, redirect it to dashboard page
			$this->Session->setFlash(PROJECT_NOT_EXIST);
			$this->redirect("/dashboard");
		}
	}
	/**
	 * 
	 */
	function howMuchCompleted($project_id, $user_id)
	{
		$data = $this->projectStudentTaskMark->find("all", array(
		"conditions"=>"projectStudentTaskMark.project_id = ".$project_id." and projectStudentTaskMark.user_id = ".$user_id,
		"fields"=>"DISTINCT projectStudentTaskMark.task_id, projectTask.weight",		
		"joins"=>array(
						array("type"=>"INNER",
						"table"=>"project_tasks",
						"alias"=>"projectTask",
						"conditions"=>array("projectTask.id = projectStudentTaskMark.task_id")
						) 							
			)
	  
		));
		$sum = 0;
		foreach($data  as $rec)
		{
			$sum+= $rec['projectTask']['weight'];	
		}		 
		return $sum;
	}
	/**
	 * It is used to show the documents added by the user in a task
	 * It will be called through ajax and 
	 * used in the project detail page.(function viewDetails)
	 * @param int $task_id
	 */
	function userDocuments($task_id)
	{
		//project related task details
		$userId = $this->Session->read("userid");
		//To get the docs submitted by the user corresponding to a task
		$taskDocs = $this->Project->getTasksDocsByUser($task_id, $userId);
		$taskOtherComments = $this->projComments->find("all", array(
		"conditions"=>"projComments.comment_type = 'task' and projComments.task_id = ".$task_id,
		"fields"=>"projComments.*, User.id, User.firstname, User.lastname",
   		"joins"=>array(
				array("type"=>"inner",
				"table"=>"users",
				"alias"=>"User",
				"conditions"=>array("User.id = projComments.posted_by")),
				),
		));	 
		$this->set("taskOtherComments", $taskOtherComments);	
		$this->set("task_id", $task_id);	
		$this->set("canChnage", isset($this->request->query['s'])&&$this->request->query['s']=="c"?0:1);	
		$this->set("taskDocs", $taskDocs);	
		$this->render("userdocuments", "ajax");
	}
	function saveActivityForComment($data)
	{
		$prjDetail = $this->Project->findById($data['project_id']);
		$pasedData['Project']['title'] = $prjDetail['Project']['title'];
		$pasedData['Project']['id'] = $data['project_id'];		
		$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
		
		$pasedData['User']['id'] = $this->Session->read("userid");		
		$pasedData['activityLog']['mode'] = isset($data['mode'])?$data['mode']:"";		
		$pasedData['activityLog']['user_ids'] = $data['user_ids'];
		//if admin is posting the comment and specif to a task
		//then this activity will be sent to all the students who belongs to that project
		if($data['user_ids'] == "allstudents")
		{
			//Find the students who are in the group 				
			$getIndiStudent = array();
			$getStudentFromGroups = array();
			if($prjDetail['Project']['groups']!='')
			{
				$getStudentFromGroups = $this->classgroupStudent->find("list", array(
				"conditions"=>"classgroupStudent.group_id IN (".$prjDetail['Project']['groups'].")",
				"fields"=>"classgroupStudent.user_id, classgroupStudent.user_id"			
					)
				);
			}
		 
			if($prjDetail['Project']['otherUsers']!='')
			{
				//Find the students who are in the group 				
				$getIndiStudent = explode(",", $prjDetail['Project']['otherUsers']);
			}
			$getStudentFromGroups = array_merge($getStudentFromGroups, $getIndiStudent);
		 	$st = ",".implode(",",$getStudentFromGroups).",";
		 	$pasedData['activityLog']['user_ids'] = $st;
 				
		}
		else 
		{
				$pasedData['activityLog']['user_ids'] = $data['user_ids'];
		}
	 
		if(isset($data['task_id']))
		{
			$pasedData['activityLog']['activity_task'] = "addCommentInTask";
			$pasedData['task']['title'] = $data['task_title'];
		}
		else 
		{
			$pasedData['activityLog']['activity_task'] = "addComment";
		}
		$this->createActivityLog($pasedData);	
	}
	/**
	 * It is used to show the comments added on documents that are added by the user or admin to task
	 * It will be called through ajax and 
	 * used in the project detail page.(function userDocuments)
	 * @param int $task_id
	 * @param int $gotUserId if it is passed then we get commment according to this user
	 * 				it will be used in the project mark page
	 */
	
	function userDocumentComments($userTaskId, $gotUserId = 0, $view="")
	{
		//project related task details
		if(isNull($gotUserId))
			$userId = $this->Session->read("userid");
		else 
			$userId = $gotUserId;
		################## Start Add a Coment ############################
		if(isset($this->request->params['form']['comment']))
		{
			$gotAd = $this->getAdminsOfProject($this->request->params['form']['project_id']);
			$val = explode("_",$this->request->params['form']['comment']);
 			$this->projComments->id = -1;
			$data['projComments']['comment'] = $this->request->params['form']['comment'];
			$data['projComments']['project_id'] = $this->request->params['form']['project_id'];
			$data['projComments']['posted_by'] = $this->Session->read("userid");
			if(isNull($gotUserId))
			{
				
				$data['projComments']['received_by'] = $gotAd['leader_id'];
				$v['user_ids'] =  ",".$gotAd['admin_id'].",";
				$v['mode'] =  "to_admin";
			}
			else
			{
				//admin is posting the comment on the project mark page				
				$data['projComments']['received_by'] = $gotUserId;
				$v['user_ids'] =  ",".$gotUserId.",";
				$v['mode'] =  "to_user";
			}
			
			$data['projComments']['admin_ids'] = ",".$gotAd['admin_id'].",";			
			$data['projComments']['comment_type'] = "studentdoc";
			$data['projComments']['task_id'] = $this->request->params['form']['task_id'];
		  	$data['projComments']['student_doc_id'] = $this->request->params['form']['student_doc_id'];
		  	
		  
		  	
			$this->projComments->Save($data);
			$this->Session->setFlash(COMMENT_ADDED);
			//Save activity		
			$v['project_id'] = $this->request->params['form']['project_id'];	
			$taskDetail = $this->projectTask->findById($this->request->params['form']['task_id']);
			$v['task_id'] = $taskDetail['projectTask']['id'];
			$v['task_title'] = $taskDetail['projectTask']['title'];
			$this->saveActivityForComment($v);
    	}
		################## End Add a Comment ############################
		################## Start Delete a File ############################
 	 	if(isset($this->request->params['form']['d']) && !isNull($this->request->params['form']['d']))
   		{
   			$cc = $this->request->params['form']['d'];   			 
   			$ret = $this->projComments->deleteAll(" projComments.id = ".$cc." AND ( projComments.received_by = ".$userId." OR  projComments.posted_by = ".$userId.")");
   			if($userTaskId == 0)
   			{
   				//Delete a project comment
   				//We will just fade out the element from the DOM, no other call needed in this case
   				die;
   			}
   			if($ret == true)
   			{
   				$this->Session->setFlash(MSG_REC_DELTED);
   			}
   			else 
   				$this->Session->setFlash(MSG_REC_CANT_DELETE);
   		}
   		$isOwner = 1;
   		if($gotUserId!=0)
   		{
   		 	$isOwner = 0;
   		}
		$from = "";
		//To get the docs submitted by the user corresponding to a task
	  	$taskComments = $this->projComments->getTasksComments($userTaskId, $userId);
	  	$this->set("taskComments", $taskComments);	
  		$this->set("isOwner", $isOwner);	
  		$this->set("userTaskId", $userTaskId);	
  		$this->set("from", $from);	
  		$this->set("viewType", "user");	
		$this->render("user_doc_comment", "ajax");
	}
	function getAllCommentsOnTask($taskId, $gotUserId = 0)
	{
		//To get the docs submitted by the user corresponding to a task
		//project related task details
		$this->set("viewType", "common");	
		if(isNull($gotUserId))
			$userId = $this->Session->read("userid");
		else 
			$userId = $gotUserId;
		################## Start Add a Coment ############################
		if(isset($this->request->params['form']['comment']))
		{
			$gotAd = $this->getAdminsOfProject($this->request->params['form']['project_id']);
			$val = explode("_",$this->request->params['form']['comment']);
 			$this->projComments->id = -1;
			$data['projComments']['comment'] = $this->request->params['form']['comment'];
			$data['projComments']['project_id'] = $this->request->params['form']['project_id'];
			$data['projComments']['posted_by'] = $this->Session->read("userid");
			if(!isNull($gotUserId))
			{
				
			 	$data['projComments']['received_by'] = $gotAd['leader_id'];
				$v['user_ids'] =  ",".$gotAd['admin_id'].",";
				$v['mode'] =  "to_admin";
			}
			else
			{
				//admin is posting the comment on the project mark page				
				//$data['projComments']['received_by'] = $gotUserId;
		 		$v['user_ids'] =  "allstudents"; 				
				$v['mode'] =  "to_user";
			}
			 
			$data['projComments']['admin_ids'] = ",".$gotAd['admin_id'].",";			
			$data['projComments']['comment_type'] = "task";
			$data['projComments']['task_id'] = $this->request->params['form']['task_id'];
  	  	
			$this->projComments->Save($data);
			$this->Session->setFlash(COMMENT_ADDED);
			//Save activity		
 
			$v['project_id'] = $this->request->params['form']['project_id'];	
			$taskDetail = $this->projectTask->findById($this->request->params['form']['task_id']);
			$v['task_id'] = $taskDetail['projectTask']['id'];
			$v['task_title'] = $taskDetail['projectTask']['title'];
			$this->saveActivityForComment($v);
    	}
		################## End Add a Comment ############################
		################## Start Delete a File ############################
 	 	if(isset($this->request->params['form']['d']) && !isNull($this->request->params['form']['d']))
   		{
   			$cc = $this->request->params['form']['d'];   			 
   			$ret = $this->projComments->deleteAll(" projComments.id = ".$cc);
   			if($taskId == 0)
   			{
   				//Delete a project comment
   				//We will just fade out the element from the DOM, no other call needed in this case
   				die;
   			}
   			if($ret == true)
   			{
   				$this->Session->setFlash(MSG_REC_DELTED);
   			}
   			else 
   				$this->Session->setFlash(MSG_REC_CANT_DELETE);
   		}
   		$ex = "";
   		$isOwner = 1;
   		if($gotUserId!=0)
   		{
   			$ex = " AND ( projComments.received_by = ". $this->Session->read("userid")." OR  projComments.posted_by = ". $this->Session->read("userid")."  OR  projComments.received_by is null ) AND comment_type = 'task'";
   			$isOwner = 0;
   		}
   		
		$data = $this->projComments->find('all', array(
   		"conditions"=> "projComments.task_id = $taskId ".$ex,
   		"fields"=>"projComments.*, User.profilepic, User.firstname, User.lastname",
   		"joins"=>array(
				array("type"=>"inner",
				"table"=>"users",
				"alias"=>"User",
				"conditions"=>array("User.id = projComments.posted_by")),
				),
		"order"=>"id DESC"
			)
   		); 
		$taskComments = $data;
		$this->set("taskComments", $taskComments);	
  		$this->set("isOwner", $isOwner);	
  		$this->set("userTaskId", $taskId);	
  		$from = "userDocumentComments";
  		$this->set("from", $from);	
		$this->render("user_doc_comment", "ajax"); 
	}
	/**
	 * 
	 */
	function getAdminsOfProject($project_id)
	{
		$sProject = $this->Project->findById($project_id);
		$res['leader_id'] = $sProject['Project']['leader_id'];
		if($sProject['Project']['admin_id']!=0)
		{
			$res['admin_id'] = $sProject['Project']['created_by'].",".$sProject['Project']['admin_id'];
			//we will get sub amins also
			$myCoAdmins = $this->User->find("all", array(
			"fields"=>"User.id",
			"conditions"=>"User.status = 1 AND User.user_type_id = 7"
			));
			if(Count($myCoAdmins)>0)
			{
				$myCoAdminsF = array();
				foreach($myCoAdmins as $rec)
				{
					$myCoAdminsF[] = $rec['User']['id'];
				}
				$myCoAdminsSt = implode(",",$myCoAdminsF);
				$res['admin_id'] = $res['admin_id'].",".$myCoAdminsSt;
			}
		}
		else 
			$res['admin_id'] = $sProject['Project']['created_by'];
		return $res;
	}
	/**
	 * To update the Comment Text 
	 *
	 * @param int $commnetid
	 */
	function updateComment($commnetid=NULL)
	{
		//pr($this->request->params); 
		$comments = $this->request->params['form']['value'];
		$com = $this->request->params['form']['commenttext'];		
		$commenttext_varr = explode('_',$com);
		$commentid =  $commenttext_varr[1];	
		
		$data['projComments']['comment'] = $comments;
		$this->projComments->id = $commentid;
		
		$updatedecomment = $this->projComments->Save($data);
	 	echo $com = $this->request->params['form']['value'];
		die;
	
	}
	function testActivity()
	{
	 	$pasedData['Document']['id'] = 14;
		$pasedData['Comment']['id'] = 13;
		
		$pasedData['User']['name'] = "Test User";
		$pasedData['User']['id'] = 1;
		
		$pasedData['Project']['title'] = "Test Project";
		$pasedData['Project']['id'] = 1;

		$pasedData['activityLog']['activity_task'] = "addComment";
		$pasedData['activityLog']['user_ids'] = ",2,3";
		$this->createActivityLog($pasedData);
		die;
	}
	/**
	 * It will be used to create a project
	 * By Admin, Educator, Department Leader OR Indiviual Educator
	 */
	function addEditProject($project_id=0)
	{ 
	 	if(!in_array($this->Session->read('user_type'), array(1,2,3,7)))
		{
			
			$this->Session->setFlash(ERR_NOT_AUTHORIZED_THIS);
			$this->redirect("/projects");
		}
		$uData = $this->User->findById($this->Session->read('userid'),array(
		"fields"=>"created_by"
		));
		############ CREATE A PROJECT START #################
		if($this->request->data)
 		{ 
 			$result = $this->Project->validatProjectForm($this->request->data['Project']);
 			$response = array();
 	 		if($this->Project->err==0)						
 			{
 				//we will add contact
 				$this->request->data['Project']['leader_id'] = $this->request->data['Project']['leader_id'];		
				$this->request->data['Project']['admin_id'] = $this->getAdminId();
				$this->request->data['Project']['created_by'] = $this->Session->read('userid');
 				$this->request->data['Project']['duedate'] = date("Y-m-d", strtotime($this->request->data['Project']['duedate']));
 				if($project_id!=0)	
 				{ 			
 					$this->Project->id = $project_id;		
 					$this->Project->Save($this->request->data); 					 
 				 	$response['success'] = MSG_PROJ_UPDATED;
 				 	$response['id'] = $project_id;
 				}
 				else 
 				{
 					$this->Project->id = -1;
 					$this->Project->Save($this->request->data); 					 
 					$response['success'] = MSG_PROJ_CREATED;
 					$response['id'] = $this->Project->getLastInsertId();
 		 		} 			 				 				
 			}
 			else 
 			{
 	 			$response['error'] = $this->Project->errMsg;
 			}
 			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;         
 			die;   
 	 	}
 	 	############ CREATE A PROJECT ENDS #################
 	 	
		// We will get all the data required to create a project
		$dataUsers = array();
		$teachers = array();
		$subjects = array();
		$projTasks = array();
		$dataGroups = array();		
		$projDetails = array();
		$dataWhiteboards = array();
		$userId = $this->Session->read('userid');
	
		######## START To determine what subjects are assigned to this teacher###
		if($this->Session->read('user_type') == 1 || $this->Session->read('user_type') == 7 || $this->Session->read('user_type')==3)
		{
			$admin_id = $this->getAdminId();
			$subjects = $this->Subject->find("all", array(
			"conditions"=>"Subject.admin_id = ".$admin_id,
			"fields"=>"Department.title, Department.id, Subject.id, Subject.title",
			"joins"=>array(
 							array("type"=>"INNER",
 							"table"=>"departments",
 							"alias"=>"Department",
 							"conditions"=>array("Subject.department_id = Department.id")
 							) 							
					),
			"order"=>"Subject.department_id"
			)); 			
		}
		else if($this->Session->read('user_type')==2)
		{ 
			 
			$leaders = $this->DepartmentTeacher->find("all",  array(
			"conditions"=>"DepartmentTeacher.user_id = ".$userId." "));
			$gotLeaders = array();
			 
			if(count($leaders) > 0) 
			{
				foreach ($leaders as $ec1)
				{
					$gotLeaders [] = $ec1['DepartmentTeacher']['department_id'];
				}
				if(count($gotLeaders) > 0 )
				{
					//we will get all the subjects in the department
					$stLeaders = implode( ",", $gotLeaders);
					$subjects = $this->Subject->find("all", array(
					"conditions"=>"Subject.department_id IN (".$stLeaders.")",
					"fields"=>"Department.title, Department.id, Subject.id, Subject.title",
					"joins"=>array(
		 							array("type"=>"INNER",
		 							"table"=>"departments",
		 							"alias"=>"Department",
		 							"conditions"=>array("Subject.department_id = Department.id")
		 							) 							
							),
					"order"=>"Subject.department_id"
					)); 
				}
				 
			}
			else 
			{
			
				$subjects = $this->SubjectEducator->find("all", array(
				"conditions"=>"SubjectEducator.user_id = ".$userId,
				"fields"=>"DISTINCT Subject.id, Department.title, Department.id, Subject.title",
				"joins"=>array(
	 							array("type"=>"INNER",
	 							"table"=>"subjects",
	 							"alias"=>"Subject",
	 							"conditions"=>array("Subject.id = SubjectEducator.subject_id")
	 							),
	 							array("type"=>"INNER",
	 							"table"=>"departments",
	 							"alias"=>"Department",
	 							"conditions"=>array("Subject.department_id = Department.id")
	 							) 	 							
						),
				 
				"order"=>"Subject.department_id"
				)			 
				);
			}
		}
		
		######## TO determine what subjects are assigned to this teacher ENDS###		
		if($project_id!=0)
		{
			$projDetails = $this->Project->findById($project_id);
			$this->request->data = $projDetails;
			//TO get the project tasks
			
			$hasMany = array(
			'projComments' => array(
			/*"conditions"=>"projComments.comment_type = 'task' ",*/
			'foreignKey' => 'task_id',
			"fields"=>"projComments.*"
			));	
			 
			$this->projectTask->bindModel(array("hasMany"=>$hasMany));
			$projTasks = $this->projectTask->find("all", array(
				"order"=>"projectTask.id desc",
				"fields"=>"fileType.icon, projectTask.*,( SELECT COUNT(id) FROM project_task_extra_docs WHERE project_task_extra_docs.task_id = projectTask.id) as extraDocs ",
				"conditions"=>"projectTask.project_id = ".$project_id,
				"joins"=>array(
 							array("type"=>"left",
 							"table"=>"file_types",
 							"alias"=>"fileType",
 							"conditions"=>array("fileType.id = projectTask.file_type_id")
 							) 							
					)
				)
			);	
		  
	 		//We will the user groups who are added in the project
			if($projDetails['Project']['groups']!='')
			{
				
				$dataGot = $this->classGroup->find('all', array(
	 			 "conditions"=>"classGroup.id IN (".$projDetails['Project']['groups'].")",
	 			 "fields"=>"classGroup.id, classGroup.title"
 				 ));
		 		$i = 0;
		 	 	if(count($dataGot)>0)
				{
					$i = 0;
					foreach($dataGot as $rec)
					{
						$dataGroups[$i]['key'] = $rec['classGroup']['title'];
						$dataGroups[$i]['value'] = $rec['classGroup']['id'];
						$i++;
					}
				} 
			 }
			 
			 //We will the user groups who are added in the project
			if($projDetails['Project']['otherUsers']!='')
			{
				
				$dataGot = $this->User->find('all', array(
	 			 "conditions"=>"User.id IN (".$projDetails['Project']['otherUsers'].") AND User.status = 1",
	 			 "fields"=>"User.id, User.firstname, User.lastname"
 				 ));
		 		$i = 0;
		 	 	if(count($dataGot)>0)
				{
					$i = 0;
					foreach($dataGot as $rec)
					{
						$dataUsers[$i]['key'] = ucfirst($rec['User']['firstname']." ".$rec['User']['lastname']);
						$dataUsers[$i]['value'] = $rec['User']['id'];
						$i++;
					}
				} 
			 }
			  //We will the user groups who are added in the project
			if($projDetails['Project']['whiteboards']!='')
			{
				$projDetails['Project']['whiteboards'] = rtrim($projDetails['Project']['whiteboards'],",");
			 	$dataGot = $this->Whiteboard->find('all', array(
	 			 "conditions"=>"Whiteboard.id IN (".$projDetails['Project']['whiteboards'].")",
	 			 "fields"=>"Whiteboard.id, Whiteboard.title"
 				 ));
		 		$i = 0;
		 	 	if(count($dataGot)>0)
				{
					$i = 0;
					foreach($dataGot as $rec)
					{
						$dataWhiteboards[$i]['key'] = ucfirst($rec['Whiteboard']['title']);
						$dataWhiteboards[$i]['value'] = $rec['Whiteboard']['id'];
						$i++;
					}
				} 
			 }
			 //we will get
			 $this->set("data", $projDetails);
			
		}
		//To get the teachers who are under this admin
	 
		$teachers = array();		 
		if($this->Session->read('user_type') == 1 || $this->Session->read('user_type') == 7)
		{
		 
			$leader_id = isset($projDetails['Project']['leader_id'])?$projDetails['Project']['leader_id']:"";
			$this->set("lid",$leader_id);
			if(isset($this->request->data['Project']['subject_id']))
			{
 				$teachers = $this->SubjectEducator->find("list", array(
				"conditions"=>"SubjectEducator.subject_id = ".$this->request->data['Project']['subject_id'],
				"fields"=>"User.id, User.firstname",
				"joins"=>array(
 							array("type"=>"inner",
 							"table"=>"users",
 							"alias"=>"User",
 							"conditions"=>array("User.id = SubjectEducator.user_id")
 							) 							
					)
				
				)			 
				);
			}
		}
		//print_r($teachers);die;
		$this->set("dataUsers", $dataUsers);	 
		$this->set("dataWhiteboards", $dataWhiteboards);	 
		$this->set("projTasks", $projTasks);
		$this->set("dataGroups", $dataGroups);
		$this->set("project_id", $project_id);
		$this->set("teachers", $teachers);
		$this->set("subjects", $subjects);
	 	$this->render("create_project");
	}
	function getTeachersOfSubject($subject_id="")
	{
		$teachers = array();
		if(!isNull($subject_id))
		{
			$teachers = $this->SubjectEducator->find("all", array(
			"conditions"=>"SubjectEducator.subject_id = ".$subject_id,
			"fields"=>"User.id, User.firstname, User.lastname ")
			 
			);
		}
	 	$st = "<select name='data[Project][leader_id]' id='leader_id' style='width:120px'>";
		$st .= "<option value=''>Please Select</option>";
		foreach ($teachers as $rec)
		{
			if(isset($rec['User']['id']))
			{
			$st .= "<option value='".$rec['User']['id']."'>".$rec['User']['firstname']." ".$rec['User']['lastname']."</option>";
			}
		}
		$st.="</select>";
		echo $st;die;
	}
	/**/
	function createTask($task_id = 0)
	{
		$project_id = $this->request->query['p'];
		if(isset($this->request->data['projectTask']) && count($this->request->data['projectTask'])>0)
		{
			$this->request->data['projectTask']['project_id'] = $project_id;
			if(!isNull($this->request->data['projectTask']['title']))
			{
				if(isset($this->request->data['projectTask']['id']) && $this->request->data['projectTask']['id']!=0)	
				{ 					
					$this->projectTask->id = $this->request->data['projectTask']['id'];
					$this->projectTask->Save($this->request->data['projectTask']); 					 
				 	$response['success'] = MSG_TASK_UPDATED;
				 	$response['id'] = $this->request->data['projectTask']['id'];
				}
				else 
				{
					$this->projectTask->id = -1;
					$this->projectTask->Save($this->request->data['projectTask']); 					 
					$response['success'] = MSG_TASK_CREATED;
					$response['id'] = $this->projectTask->getLastInsertId();
		 		} 
		 		if(!isNull($this->request->data['projComments']['comment']))
		 		{
		 			$Data['projComments']['posted_by'] = $this->Session->read("userid");
		 			$Data['projComments']['project_id'] = $project_id;
		 			$Data['projComments']['task_id'] = $response['id'];
		 			$Data['projComments']['comment'] = $this->request->data['projComments']['comment'];
  	 				$Data['projComments']['comment_type'] = "task";
  	 				$this->projComments->Save($Data);	 				
		 		}
		 		$this->set("project_id", $project_id);
				$this->set("task_id", $response['id']); 
		 		
				$details = $this->projectTask->find("first", array(
					"order"=>"projectTask.id desc",
					"fields"=>"fileType.icon, projectTask.*",
					"conditions"=>"projectTask.id = ".$response['id'],
					"joins"=>array(
	 							array("type"=>"left",
	 							"table"=>"file_types",
	 							"alias"=>"fileType",
	 							"conditions"=>array("fileType.id = projectTask.file_type_id")
	 							) 							
						)
					)
				);
		 		
			}
			else 
 			{
 	 			$response['error'] = ERR_TASK_TITLE;
 			}
 			
		}
		$this->set("rec",$details);
		$this->render("created_task","ajax");
	}
	/**
	 * 
	 */
	function createTaskDoc($file_id)
	{
		$fileDetail = $this->userFile->find('first',array(
		"fields"=> "fileType.icon, userFile.file_name, userFile.id, userFile.file_type_id",
		"conditions"=>"userFile.id = ".$file_id,
		"joins"=>array(
 							array("type"=>"inner",
 							"table"=>"file_types",
 							"alias"=>"fileType",
 							"conditions"=>array("fileType.id = userFile.file_type_id")
 							) 							
					)
		));	
		$this->set("file_id", $file_id);
		$this->set("fileDetail", $fileDetail);
		$this->render("create_task_doc", "ajax");
	}
	/**
	 *  Delete a task from the project
	 *  post: taskId
	 */
	function deleteTask()
	{
		if(isset($this->request->params['form']['taskId']) && $this->request->params['form']['taskId']!='')
		{
			$res = $this->projectTask->delete($this->request->params['form']['taskId']);
			if($res == true)
			{
				$response['success'] =  MSG_REC_DELTED;
			}
			else {
				$response['error'] =  MSG_REC_CANT_DELETE;	
			}
			
		}else {
				$response['error'] =  MSG_REC_CANT_DELETE;	
			}
		$this->RequestHandler->respondAs('json'); 			
		echo json_encode($response);
		$this->autoRender = false;         
		die; 
	}
	/**
 	 * This function is used to get the json data for drop down of "otherGroups" 
 	 * in addYearGroup Page
 	 */
 	function getOtherGroups()
 	{
 	 	$this->loadModel('classGroup');
 		$data = array();
 		$tag = $this->request->query['tag'];	 
 		$userId = $this->Session->read('userid'); 
		//  filter the class grop by the admin id for admin and coadmin user
		$filters= "";
		$admin_id = $this->getAdminId();
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 || $this->Session->read('user_type')==3)
		{
			
			$filters = "classGroup.admin_id= ".$admin_id;
		} 
		else if($this->Session->read('user_type') == 2)
		{ 
		 
 			$filters =" classGroup.admin_id = ".$admin_id;
		}
 		//$filters.=" OR classGroup.admin_id = ".$admin_id.")";
 		$dataGot = $this->classGroup->find('all', array(
	 		 "conditions"=>$filters."  AND classGroup.group_type ='class' and classGroup.title like '".add_Slashes($tag)."%'",
	 		 "fields"=>"classGroup.id, classGroup.title"
 		 ));
 		$i = 0;
 	 	if(count($dataGot)>0)
		{
			$i = 0;
			foreach($dataGot as $rec)
			{
				$data[$i]['key'] = $rec['classGroup']['title'];
				$data[$i]['value'] = $rec['classGroup']['id'];
				$i++;
			}
		} 
		echo json_encode($data);
		die;
 	}
 	/**
 	 * This function is used to get the individual users json data for drop down of "otherUsers" 
 	 * in add Project Page
 	 */
 	function getOtherUsers()
 	{
 	 	 
 		$data = array();
 		$tag = $this->request->query['tag'];	 
 		$userId = $this->Session->read('userid'); 
		//  filter the class grop by the admin id for admin and coadmin user
		$filters= "";
		$filters ="( User.user_type_id = 5 OR User.user_type_id = 4) AND User.status = 1";
 		$dataGot = $this->User->find('all', array(
	 		 "conditions"=>$filters." AND ( User.firstname like '".add_Slashes($tag)."%' OR User.firstname like '".add_Slashes($tag)."%' )",
	 		 "fields"=>"User.id, User.firstname, User.lastname"
 		 ));
 		$i = 0;
 	 	if(count($dataGot)>0)
		{
			$i = 0;
			foreach($dataGot as $rec)
			{
				$data[$i]['key'] = ucfirst($rec['User']['firstname']." ".$rec['User']['lastname']);
				$data[$i]['value'] = $rec['User']['id'];
				$i++;
			}
		} 
		echo json_encode($data);
		die;
 	}
 	/**
 	 * WHne user either click on "Send or Save" Project, this function will be invoked
 	 * It will send email to the students If click on the "Send Project"
 	 * Otherwise it will just save selected groups in the db
 	 */ 
 	function saveOrSendProject($project_id, $saveOrSend)
 	{ 
 		$returnArr = array();
 		$pasedData = array();
 		 
		if( (isset($this->request->data['usersGroups']) && count($this->request->data['usersGroups'])>0) || (isset($this->request->data['otherUsers']) && count($this->request->data['otherUsers'])>0))
		{
			$groupsSelected = isset($this->request->data['usersGroups'])?$this->request->data['usersGroups']:array();
			$usersSelected = isset($this->request->data['otherUsers'])?$this->request->data['otherUsers']:array();
			$whiteboardsSelected = isset($this->request->data['whiteboards'])?$this->request->data['whiteboards']:array();
			
			$gotUsers['groups'] = implode(",",array_unique($groupsSelected));
			$gotUsers['otherUsers'] = implode(",",array_unique($usersSelected));
			$st = implode(",",array_unique($whiteboardsSelected));
			if($st!='') $st =  "0,".$st.",";
			$gotUsers['whiteboards'] = $st;
			$gotUsers['published'] = $saveOrSend;
			$this->Project->id = $project_id;
			//echo "<pre>"; print_r($gotUsers);die;
			$this->Project->Save($gotUsers);			
			
			if(isset($this->request->data['projComments']['comment_project']) && $this->request->data['projComments']['comment_project']!='')
			{
				$Data = array();
				$Data['projComments']['posted_by'] = $this->Session->read("userid");
	 			$Data['projComments']['project_id'] = $project_id;
	 	 		$Data['projComments']['comment'] = $this->request->data['projComments']['comment_project'];
 				$Data['projComments']['comment_type'] = "project";
 				$this->projComments->Save($Data);
			}
			$prjDetail = $this->Project->findById($project_id);
			$getStudentFromGroups = array();
			$getIndiStudent = array();
			if($saveOrSend == 1)
 			{
 				//Send the Project
 				//IF project is updated then we delete the users from who are not in the added groups
 				$qry = "DELETE FROM project_students WHERE project_id = ".$project_id;
 				$this->classgroupStudent->query($qry); 			
 				if($this->request->params['form']['mode'] == "add")
 				{
 					$inMail = "created a new" ;
 					$subject = "Project Created";
 					$pasedData['activityLog']['activity_task'] = "createProject";
 				}
 				else 
 				{
 					$inMail = "updated";
 					$subject = "Project Updated";
 					$pasedData['activityLog']['activity_task'] = "projectUpdate";
 				} 					
 				//Find the students who are in the group 				
 				if( count($groupsSelected)>0)
 				{
					$getStudentFromGroups = $this->classgroupStudent->find("all", array(
					"conditions"=>"classgroupStudent.group_id IN (".$gotUsers['groups'].")",
					"fields"=>"classgroupStudent.group_id, User.id, User.email, User.firstname, User.lastname"			
						)
					);
 				}
 				if( count($usersSelected)>0)
 				{
					//Find the students who are in the group 				
					$getIndiStudent = $this->User->find("all", array(
					"conditions"=>"User.id IN (".$gotUsers['otherUsers'].")",
					"fields"=>"User.id, User.email, User.firstname, User.lastname"			
						)
					);
 				}
 				$getStudentFromGroups = array_merge($getStudentFromGroups, $getIndiStudent);
 	 	 		$alreadyAdded = array();
				$students = "";
	 			if(count($getStudentFromGroups)>0)
	 			{
	 							
	 				$insertQuery = "INSERT INTO project_students(user_id, group_id, project_id) values";	
	 				foreach($getStudentFromGroups as $rec)
	 				{
	 					if(!in_array($rec['User']['id'], $alreadyAdded))
	 					{
	 						if(!isset($rec['classgroupStudent']['group_id']))
	 							$rec['classgroupStudent']['group_id'] = 0;
		 					$alreadyAdded[] = $rec['User']['id'];
		 					$insertQuery.="(".$rec['User']['id'].",".$rec['classgroupStudent']['group_id'].",".$project_id."),";
		 					$students.=$rec['User']['id'].",";
							//We will email the user for the new project 
							$sUserFullName = $rec['User']['firstname']." ".$rec['User']['lastname'];
						    $this->Email->to =   $rec['User']['email'];				
							$this->Email->fromName = ADMIN_NAME;
						    $this->Email->from = EMAIL_FROM_ADDRESS;
						    $urlUsed = SITE_HTTP_URL."projects/viewDetails/".$project_id;
					
					        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>".
					        ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"))." has ".$inMail." project <b>".$prjDetail['Project']['title']."</b>.<br/><br/>
					
							Please login into your account, [<a href='".$urlUsed."'>Click Here</a>] to view details of the project.<br/><br/>
					
							Thanks & Regards,<br/>
							Website Support <br/>
							".SITE_NAME." <br/>";
							
					        $this->Email->text_body = $sMessage;
					        $this->Email->subject = SITE_NAME.' - '.$subject;
						//echo "<pre>"; print_r($this->Email);die;
					        $result = $this->Email->sendEmail();
	 					}	 
	 				}
					echo "<pre>"; print_r($prjDetail);
					echo $insertQuery."<br>";
	 				$insertQuery = substr($insertQuery, 0, -1);
					echo $insertQuery;die;
	 				$this->Project->query($insertQuery);
	 				//We will trigger an activity to the selectd users	
	 				
	 				$pasedData['Project']['title'] = $prjDetail['Project']['title'];
					$pasedData['Project']['id'] = $project_id;		
					$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
					$pasedData['User']['id'] = $this->Session->read("userid");
					
					$pasedData['activityLog']['user_ids'] = ",".$students;
					$this->createActivityLog($pasedData);
					
					//Update the count of added students
					$students = substr($students, 0, -1);
					$qry = "UPDATE counts SET project_count = project_count+1 WHERE user_id IN(".$students.")";
					$this->Project->query($qry);
	 			}
 			}	
 				
		}
 	  	$this->redirect("/projects/viewDetails/".$project_id);
 	 }
 	 /**
 	  * It will be invoked when user will submit any Doc in a task
 	  *
 	  */
 	 function studentUploadTaskDoc($file_id, $task_id, $forDrop = 0)
 	 {
 	 	$fileDetail = $this->userFile->find('first',array(
		"fields"=> "fileType.icon, userFile.file_name, userFile.id, userFile.file_type_id",
		"conditions"=>"userFile.id = ".$file_id,
		"joins"=>array(
 							array("type"=>"inner",
 							"table"=>"file_types",
 							"alias"=>"fileType",
 							"conditions"=>array("fileType.id = userFile.file_type_id")
 							) 							
					)
		));	
		$this->set("file_id", $file_id);
		$this->set("task_id", $task_id);
		$this->set("fileDetail", $fileDetail);
		if($forDrop == 0)
			$this->render("create_student_task_file", "ajax");
		else 
			$this->render("create_student_task_file_drop", "ajax");
 	 }
 	 /**
 	  * Assign the doc to project
 	  * Send the activity to admins
 	  * @param unknown_type $task_id
 	  */
 	 function studentSubmitDocToProject($task_id)
 	 {
 	 	$project_id = $this->request->query['p'];
		if(isset($this->request->data['projectStudentTaskDoc']) && count($this->request->data['projectStudentTaskDoc'])>0)
		{
			$this->request->data['projectStudentTaskDoc']['project_id'] = $project_id;
			$this->request->data['projectStudentTaskDoc']['task_id'] = $task_id;
			$this->request->data['projectStudentTaskDoc']['user_id'] = $this->Session->read("userid");
			$this->request->data['projectStudentTaskDoc']['submitted_date'] = date("Y-m-d H:i:s");
			if(!isNull($this->request->data['projectStudentTaskDoc']['title']))
			{
			 	$this->projectStudentTaskDoc->id = -1;
				$this->projectStudentTaskDoc->Save($this->request->data['projectStudentTaskDoc']); 					 
				$response['success'] = MSG_TASKDOC_UPLOADED;
				$response['id'] = $this->projectStudentTaskDoc->getLastInsertId();		
				$gotAd = $this->getAdminsOfProject($project_id); 		 
		 		if(!isNull($this->request->data['projComments']['comment']))
		 		{
		 			
		 			$Data['projComments']['posted_by'] = $this->Session->read("userid");
		 			$Data['projComments']['project_id'] = $project_id;
		 			$Data['projComments']['task_id'] = $task_id;
		 			$Data['projComments']['comment'] = $this->request->data['projComments']['comment'];
  	 				$Data['projComments']['received_by'] = $gotAd['leader_id'];
  	 				$Data['projComments']['admin_ids'] = ",".$gotAd['admin_id'].",";
		 			$Data['projComments']['comment_type'] = "studentdoc";
		 			$Data['projComments']['student_doc_id'] = $response['id'];
  	 				$this->projComments->Save($Data);	 				
		 		}
		 		$taskDetail = $this->projectTask->findById($task_id);
		 		$pasedData = array();
		 		$prjDetail = $this->Project->findById($project_id);
		 		$pasedData['Project']['title'] = $prjDetail['Project']['title'];
				$pasedData['Project']['id'] = $project_id;		
				$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
				$pasedData['User']['id'] = $this->Session->read("userid");				
				$pasedData['activityLog']['user_ids'] = ",".$gotAd['leader_id'].",".$gotAd['admin_id'].",";		
				//If it is tick task
		 
				if($this->request->data['projectStudentTaskDoc']['refer_file_id']==0)
				{
					$pasedData['Task']['title'] = $taskDetail['projectTask']['title'];
					$pasedData['activityLog']['activity_task'] = "tickTaskDoneFrmUser";		 
				}
				else {
					$pasedData['Document']['id'] = $this->request->data['projectStudentTaskDoc']['refer_file_id'];				$pasedData['activityLog']['activity_task'] = "uploadDocumentToAdmin";		 
				}
				$this->createActivityLog($pasedData);
				//TO set the status of the project as unmarked for the admin
				$this->projectStudent->updateAll(
					array("marked" => 0, "submitted_date"=>"'".date("Y-m-d H:i:s")."'"),
					array("user_id" => $this->Session->read("userid"), "project_id"=>$project_id)
				);
				//To update the task record to show that it is not marked
				$this->projectStudentTaskMark->updateRecord($this->request->data['projectStudentTaskDoc']);
			}
			else 
 			{
 	 			$response['error'] = ERR_TASKDOC_TITLE;
 			}
 			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;         
 			die; 
		}	
 	 }
 	 ########### LHS Dropbox Of Projects function start here #######################
 	 /**
 	  * * To list all the projects in panel
 	  *   If user is student we will get where he is assigned
 	  *   otherwise we will get proects created by the loged in user
 	  */
 	 function listProjectsDropbox()
 	 {
 	 	$joins = array();
 	 	$isOwner = 1;
 	 	$filters = "";
 	 	$field = "";
 	 	if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7|| $this->Session->read('user_type')==3)
		{
			$admin_id = $this->getAdminId();
			$filters = "Project.admin_id= ".$admin_id." AND ";
		}
		else if($this->Session->read('user_type')==2 )
		{ 
			$filters = "Project.leader_id=".$this->Session->read('userid')." AND ";
		}
		else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{ 	
		   $isOwner = 0;			
		   $joins = array(
						array(
						"type"=>"inner",
						"table"=>"project_students",
						"alias"=>"projectStudent",
						"conditions"=>"Project.id = projectStudent.project_id AND projectStudent.user_id=". $this->Session->read('userid')
						) );
			$field = "projectStudent.completed, projectStudent.id,";
		}
		$filters .= "  (Project.published=1) " ;
		$myProjects = $this->Project->find('all', array(
	   		"conditions"=>$filters,
	   		"fields"=> "$field Project.id, Project.title, Project.admin_id, Project.created, Project.published",
			"joins"=>$joins,
	   		"order"=>"Project.created DESC",
			"group"=>"Project.id"
   		)
   		);		 	
   		$this->set("myProjects", $myProjects);
 	 	$this->set("isOwner", $isOwner);
 	 	$this->render("list_projects_dropbox", "ajax");
 	 }
 	 /**
 	  *  TO list the tasks within a project in the panel
 	  *
 	  * @param int $project_id
 	  */
 	 function listProjectTasks($project_id)
 	 {
 	 	$isOwner = 0;
 	    if(in_array($this->Session->read('user_type'), array(1,2,3,7)))
		{ 	
		   $isOwner = 1;
		}
 	 	$userId = $this->Session->read("userid");
 	 	$tasks = $this->Project->getTasks($project_id, $userId);	
 	 	$this->set("isOwner", $isOwner);
 	 	$this->set("project_id", $project_id);
 	 	$this->set("tasks", $tasks);
 	 	$this->render("list_projects_tasks", "ajax"); 	 	 
 	 }
 	 /**
 	  * Document uploaded by the logged in user(student) within a task
 	  *
 	  * @param int $task_id
 	  */
 	 function userDocumentsDrop($task_id)
 	 {
 	 	//project related task details
		$userId = $this->Session->read("userid");
		//To get the docs submitted by the user corresponding to a task
		$taskDocs = $this->Project->getTasksDocsByUser($task_id, $userId);		 
		$this->set("canChnage", isset($this->request->query['s'])&&$this->request->query['s']=="c"?0:1);	
	 	$this->set("task_id", $task_id);	
		$this->set("taskDocs", $taskDocs);	
 		$this->render("user_documents_drop", "ajax");	 	 
 	 }
 	 /**
 	  * If task is TICK type task then following function wil be used
 	  * We will give only a check box and Comment to submit the task
 	  * If task is not submitted
 	  * Other wise just show that task is submitted
 	  * @param int $task_id
 	  */
 	 function userDocumentsTick($task_id)
 	 {
 	 	$view = "";
 	 	$taskOtherComments = array();
 	 	$userId = $this->Session->read("userid");
 		$docs = $this->Project->getTasksDocsByUser($task_id, $userId);		 
 	 	$isSubmitted = is_array($docs) && count($docs) > 0?1:0;
 	 	 
 	 	$this->set("docsArr", $docs);
 	 	$this->set("isSubmitted", $isSubmitted);	
 	 	$this->set("task_id", $task_id);	
 	 	if(isset($this->request->query['view']))
 	 	{
 	 		$view = $this->request->query['view'];
 	 	}
  	 	if(strtolower($view) == "large")
 	 	{
	 	 	$taskOtherComments = $this->projComments->find("all", array(
				"conditions"=>"(projComments.comment_type = 'task' OR projComments.comment_type = 'task')  and projComments.task_id = ".$task_id,
				"fields"=>"projComments.*, User.id, User.firstname, User.lastname",
		   		"joins"=>array(
						array("type"=>"inner",
						"table"=>"users",
						"alias"=>"User",
						"conditions"=>array("User.id = projComments.posted_by")),
						),
				));
	  	}
		$this->set("taskOtherComments", $taskOtherComments);	
 	 	//This view will be used both project detail ad left drop box
 	 	$this->set("view", $view);	
 	 	$this->set("canChnage", isset($this->request->query['s'])&&$this->request->query['s']=="c"?0:1);	
 	 	$this->render("user_documents_tick", "ajax");
 	 }
 	 /**
 	  * To delete a docuemnt uploaded in a particulat task by the student
 	  * Activity will send to admins
 	  * @param posted variable $docId
 	  */
 	 function delTaskDoc()
 	 {
 	 	$userId = $this->Session->read("userid");
 	 	if(isset($this->request->data['projectStudentTaskDoc']['d']))
		{
			$response['success'] = MSG_TASKDOC_DEL;
			$detail = $this->projectStudentTaskDoc->find("first", array(
			"fields"=>"projectStudentTaskDoc.title, projectTask.title, Project.id, Project.title, Project.leader_id, Project.created_by, Project.admin_id",
			"conditions"=>"projectStudentTaskDoc.id=".$this->request->data['projectStudentTaskDoc']['d'],
			"joins"=>array(
				array(
				"type"=>"inner",
				"table"=>"project_tasks",
				"alias"=>"projectTask",
				"conditions"=>"projectTask.id = projectStudentTaskDoc.task_id"
				),
				array(
				"type"=>"inner",
				"table"=>"projects",
				"alias"=>"Project",
				"conditions"=>"Project.id = projectTask.project_id"
				)
			)
			));
		 	
			$this->projectStudentTaskDoc->deleteAll("projectStudentTaskDoc.id=".$this->request->data['projectStudentTaskDoc']['d']." and user_id = ".$userId);
		 
	 		$pasedData = array(); 
	 		$pasedData['Project']['title'] = $detail['Project']['title'];
			$pasedData['Project']['id'] =  $detail['Project']['id'];			
			$pasedData['Document']['title'] = $detail['projectStudentTaskDoc']['title'];
			$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
			$pasedData['User']['id'] = $this->Session->read("userid");		 
			$pasedData['Task']['title'] = $detail['projectTask']['title'];
			$pasedData['activityLog']['user_ids'] = ",".$detail['Project']['leader_id'].",".$detail['Project']['created_by'].",".$detail['Project']['admin_id'].",";		
			$pasedData['activityLog']['activity_task'] = "deleteDocumentToAdmin";		 
			 
			$this->createActivityLog($pasedData); 
		}
 	 	else 
		{
 			$response['error'] = MSG_TASKDOC_CANTDEL;
		}
		$this->RequestHandler->respondAs('json'); 			
		echo json_encode($response);
		$this->autoRender = false;         
		die; 
 	 }
 	 ########### LHS Dropbox Of Projects function end here #######################
 	 /**
 	  * This page will be used by the admin or educator to mark a project
 	  * that is submitted by a user
 	  * @param unknown_type $project_id : submitted project id
 	  * @param unknown_type $user_id: who has submitted the project
 	  */
	 function markProject($project_id=Null, $user_id=Null)
 	 {
 	 	if(isNull($project_id) || isNull($user_id))
 	 	{
 	 		$this->Session->setFlash(PROJECT_NOT_EXIST);
			$this->redirect("/dashboard");
 	 	}
 	  
 	 	//project detail
		$prjDetails = $this->Project->find('first', array(
			"conditions"=>"Project.id = ".$project_id,
			"fields"=>"Project.*, Subject.title, UserAdmin.status, UserAdmin.email, User.status, User.email, User.firstname, User.lastname",
			"joins"=>array(
	 							array("type"=>"inner",
	 							"table"=>"subjects",
	 							"alias"=>"Subject",
	 							"conditions"=>array("Subject.id = Project.subject_id")
	 							),
	 							array("type"=>"inner",
	 							"table"=>"users",
	 							"alias"=>"User",
	 							"conditions"=>array("User.id = Project.leader_id")
	 							) 							 							
	 							,
	 							array("type"=>"inner",
	 							"table"=>"users",
	 							"alias"=>"UserAdmin",
	 							"conditions"=>array("UserAdmin.id = Project.admin_id")
	 							)
	 						)	
	 						
	 		)
		);
		$userDetail = $this->User->findById($user_id, "firstname, lastname, id, email");
		//marks submitted
		if(isset($this->request->params['form']['taskProjectChk']) && count($this->request->params['form']['taskProjectChk'])>0)
		{
		 
			foreach($this->request->params['form']['taskProjectChk'] as $key=>$val)
			{
				if($val == 1 && isset($this->request->params['form']['taskWeight'][$key]))
				{
					$this->projectStudentTaskMark->updateAll(
					array("marked" => 1, "marked_date"=>"'".date("Y-m-d H:i:s")."'", "marks"=>$this->request->params['form']['taskWeight'][$key]),
					array("task_id" => $key, "user_id"=>$user_id)
					);
				}
			}
			$update = array("marked" => 1);//, "submitted_date"=>NULL);
			if(isset($this->request->params['form']['isComplete']))
			{
				$update['completed'] = 1;
				$sUserFullName = $userDetail['User']['firstname']." ".$userDetail['User']['lastname'];
				$subject = "Project Completed";
			    $this->Email->to =  $userDetail['User']['email'];				
				$this->Email->fromName = ADMIN_NAME;
			    $this->Email->from = EMAIL_FROM_ADDRESS;
			    $urlUsed = SITE_HTTP_URL."projects/viewDetails/".$project_id;
		
		        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>".
		        ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"))." has marked the '".$prjDetails['Project']['title']."' project and indicate that you have successfully completed the project.<br/><br/>
		
				Please login into your account and [<a href='".$urlUsed."'>Click Here</a>] to view details of the project.<br/><br/>
		
				Thanks & Regards,<br/>
				Website Support <br/>
				".SITE_NAME." <br/>";
				
		        $this->Email->text_body = $sMessage;
		        $this->Email->subject = SITE_NAME.' - '.$subject;
		        $result = $this->Email->sendEmail();	
			}
	 		$this->projectStudent->updateAll(
				$update,
				array("user_id" => $user_id, "project_id"=>$project_id)
			);
			//We will trigger an activity to the selectd users	
		 	$pasedData = array();
	 		$pasedData['activityLog']['activity_task'] = "markProject";
			$pasedData['Project']['title'] = $prjDetails['Project']['title'];
			$pasedData['Project']['id'] = $project_id;		
			$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
			$pasedData['User']['id'] = $this->Session->read("userid");			
			$pasedData['activityLog']['user_ids'] = ",".$user_id.",";
			$this->createActivityLog($pasedData); 
			//Project marked
			$this->Session->setFlash(PROJECT_MARKED);
			$this->redirect("/projects/markProjectsList");
		}
	 	if(count($prjDetails) > 0 && isset($prjDetails['Project']['id']))
		{
			//project related task details
			$userId = $this->Session->read("userid");
			$isOwner = 0;
	 		if($userId == $prjDetails['Project']['leader_id'] || $userId == $prjDetails['Project']['admin_id'])
			{
				$isOwner = 1;
		 	}
		 	/*
		 		We will get list of the file type icon, as we cant join table in bindModels
		 	*/
		 	$projComments = array();
		 	$fileTypes = $this->projectTask->getFileTypes();
		 	$fileTypesO = array();
		 	foreach ($fileTypes as $rec)
		 	{
		 		$fileTypesO[$rec['fileType']['id']]	= $rec['fileType']['icon'];
		 	}
		 	//Get documents submitted by the user in the project
		 	$hasMany = array(
			'projectStudentTaskDoc' => array(
				"fields"=>"projectStudentTaskDoc.id, projectStudentTaskDoc.title, projectStudentTaskDoc.refer_file_id, projectStudentTaskDoc.submitted_date, projectStudentTaskDoc.file_type_id, projectStudentTaskDoc.marks,	   		
	   		(SELECT COUNT(id) FROM project_comments WHERE project_comments.student_doc_id = projectStudentTaskDoc.id and (received_by = ".$user_id." OR posted_by = ".$user_id.") ) as cnt_comment",
				'className' => 'projectStudentTaskDoc',
				'foreignKey' => 'task_id',
				"conditions" => "projectStudentTaskDoc.user_id = ".$user_id,
	 			'order' => 'projectStudentTaskDoc.id ASC' 
	 			)
			); 
			$hasOne = array(
			'projectStudentTaskMark' => array(
				"fields"=>"projectStudentTaskMark.marks",
				'className' => 'projectStudentTaskMark',
				'foreignKey' => 'task_id',
				"conditions" => "projectStudentTaskMark.user_id = ".$user_id,
 	 			)
			); 
			//Get all tasks in the project
			$this->projectTask->bindModel(array("hasMany"=>$hasMany, "hasOne"=>$hasOne));
		 	$tasks = $this->projectTask->find("all",array(
		 	"conditions"=>"projectTask.project_id = ".$project_id,
		 	"fields"=>"projectTask.refer_file_id, projectTask.id, projectTask.title, projectTask.weight, projectStudentTaskMark.marks"
		 	
		 	));	
		 	//Get student class
		 	$groups = $this->classgroupStudent->find("all", array(
		 	"conditions"=>"classgroupStudent.user_id = ".$user_id,
		 	"fields"=>"DISTINCT classgroupStudent.group_id, classGroup.title",
		 	"joins" => array(
				array(
						"type"=>"inner",
						"table"=>"class_groups",
						"alias"=>"classGroup",
						"conditions"=>"classGroup.id = classgroupStudent.group_id"  
					)
				)
		 	));
		 	//To get the class groups to whom user belongs to
		 	$classSt = "";
		  	foreach($groups as $rec)
		  	{
		  		$classSt.=	ucfirst($rec['classGroup']['title']).",";
		  	}
		  	if($classSt != '')
		  		$classSt = substr($classSt, 0, -1);
		  	 	
	 	  	//Setting values 
	 	  	$this->set("userDetail", $userDetail);
	 	  	$this->set("classSt", $classSt);
			$this->set("projComments", $projComments);
			$this->set("fileTypes", $fileTypesO);
			$this->set("isOwner", $isOwner);
			$this->set("gotUserId", $user_id);
		 	$this->set("project_id", $project_id);
 			$this->set("tasks", $tasks);
			$this->set("prjDetails", $prjDetails);
	 	}
		else 
		{
			//Project does not exist, redirect it to dashboard page
			$this->Session->setFlash(PROJECT_NOT_EXIST);
			$this->redirect("/dashboard");
		}
 	 }
 	 /**
 	  * 
 	  */
 	 function currentProjects()
 	 {
 	 	
 	 }


	 /******************************* Archieved Projects listing ***************************/

	function archivedProjects()
	{
		if(isset($this->request->query['url']) && $this->request->query['url']=="projects/draftProjects")
		{
	 		$this->set("draft", "viewdraft");
		}
		else 
			$this->set("draft", "");
	}

	function listArchivedproject($draft=0)
	{
		$filters = "";
		$joins ="";
		$this->set("showdelLink",'');
	 	$this->set("draft",$draft);
 		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7  || $this->Session->read('user_type')==3)
		{
			$admin_id= $this->getAdminId();
			$filters = "Project.admin_id= ".$admin_id." AND ";
			$this->set("showdelLink",'Y');
		}		
		if($this->Session->read('user_type')==2)
		{ 
			$filters = "Project.leader_id=".$this->Session->read('userid')." AND ";
		}

		if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{ 			
			$joins = array(
						array(
						"type"=>"inner",
						"table"=>"project_students",
						"alias"=>"projectStudent",
						"conditions"=>"Project.id = projectStudent.project_id AND projectStudent.user_id=". $this->Session->read('userid')
						) );
		}
		if(!isNull($draft))
			$filters .= "  (Project.published=0) " ;
		else 
			$filters .= "  (Project.published=2) " ;
			
		$projectChars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","all");
		$selectedChar = "all";
	 	
	 	################## Start Delete a Project ############################
 	 	if(isset($this->request->query['d']) && !isNull($this->request->query['d']))
   		{			
			// find all the students related with a project 
			$usersrec = $this->projectStudent->find("all" ,array(
										"conditions"=>array("projectStudent.project_id"=>$this->request->query['d']),
										"joins" => array(
												array(
											"type"=>"inner",
											"table"=>"users",
											"alias"=>"User",
											"conditions"=>"User.id = projectStudent.user_id"  
											)
											),
										"fields"=>array('User.id','User.firstname','User.lastname','User.email', 'Project.title')
				)
				);

			//$ret = true;
			$ret = $this->Project->delete($this->request->query['d']); 
   			if($ret == true)
   			{ 
   				//$this->Session->setFlash(MSG_REC_DELTED);
				$this->projectStudent->deleteAll("projectStudent.project_id=".$this->request->query['d']); 
				echo MSG_REC_DELTED;
				$this->doEmailToUser($usersrec);
   			}
   			else 
   				$this->Session->setFlash(MSG_REC_CANT_DELETE);

			exit;
   		}
	 	################## End Delete a Project ############################

	 	################## Start Setting Search Parameters ############################
  
	    if(isset($this->request->params['form']['title']) && count($this->request->params['form'])>0 && $this->request->params['form']['title']!='all') 
	    { 
	        	$filters.= " AND ( Project.title like '".add_Slashes(trim($this->request->params['form']['title']))."%')"; 
	        	$selectedChar = $this->request->params['form']['title'];
	    } 	
	    ################## END Setting Search Parameters ############################   
 	 
		$data = $this->Project->find('all', array(
   		"conditions"=>$filters,
   		"fields"=> "Project.id, Project.title, Project.admin_id",
		"joins"=>$joins,
   		"order"=>"Project.title",
		"group"=>"Project.id"
   		)
   		);	
		
   		$goList = array();
   		//we will make an array with a-z corresponding to their projects
   		$i = 1;
   		foreach($data as $rec)
   		{
   			$firstChar = substr($rec['Project']['title'], 0, 1);  	   			
   			if(in_array(strtolower($firstChar), $projectChars))
   			{
   				$rec['Project']['key'] = strtolower($firstChar);
   				$goList[strtolower($firstChar)][] = $rec['Project'];
   				$i++;
   			}
   			else {
   				$rec['Project']['key'] = 'Ext.';
   				$goList['others'][] = $rec['Project'];
   			}
   		} 
   	 	//die; 
   	 	$this->set("projectChars", $projectChars);
   	 	$this->set("selectedChar", $selectedChar);
   		$this->set('data', $goList);
		$this->render("list_archived_project","ajax");
	}

	/************************ start private function to send the email ****************************/

	private function doEmailToUser($data,$case=NULL)
	{	

		$namearr = $this->User->find("first",array("conditions"=>array("id"=>$this->Session->read('userid')),
												'fields' => array("firstname","lastname")
		
											));
		
		foreach($data as $rec)
		{
			$sUserFullName = $rec['User']['firstname']." ".$rec['User']['lastname'];
				
			$this->Email->to =  $rec['User']['email'];				
			$this->Email->fromName = ADMIN_NAME;
			$this->Email->from = EMAIL_FROM_ADDRESS;
			
			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>".

			ucfirst($namearr['User']['firstname']." ".$namearr['User']['lastname']) ." has deleted the project <strong>".$rec['Project']['title']."</strong>.";
			$subject = 'Project deleted';

			$sMessage.= " <br/><br/>Thanks & Regards,<br/>
			Website Support <br/>
			".SITE_NAME." <br/>";
			
			$this->Email->text_body = $sMessage;
			$this->Email->subject = SITE_NAME.' - '.$subject;
			$result = $this->Email->sendEmail();
		}
	}


	function sendMessage()
	{
		
		if($this->request->data)
		{
			$goAd = $this->getAdminsOfProject($this->request->params['form']['project_id_comnt']);
	 
			$this->request->data['projComments']['posted_by'] = $this->Session->read('userid');
			$this->request->data['projComments']['project_id'] = $this->request->params['form']['project_id_comnt'];
			$this->request->data['projComments']['received_by'] = $goAd['leader_id'];
			$this->request->data['projComments']['admin_ids'] = ",".$goAd['admin_id'].",";
			$this->request->data['projComments']['comment_type'] = 'prjComment';

			if(isset($this->request->params['form']['chktype']))
			{
				$this->request->data['projComments']['private'] = 1;
			}
			else
			{
				$this->request->data['projComments']['private'] = 0;
			}
			
			$this->projComments->id = -1;
			$this->projComments->save($this->request->data);
			$prjDetail =  $this->Project->find("first",array("conditions"=>array(
												"id"=>$this->request->params['form']['project_id_comnt']), 
												"fields"=>array("title")
												));
			// create the activity log
			$lastcommentId = $this->projComments->getLastInsertId();
			$pasedData['Project']['title'] = $prjDetail['Project']['title'];
			$pasedData['Project']['id'] = $this->request->params['form']['project_id_comnt'];		
			
			$pasedData['Comment']['id'] = $lastcommentId ;
			$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
			$pasedData['User']['id'] = $this->Session->read("userid");
			
			$pasedData['activityLog']['user_ids'] = ",".$this->request->params['form']['posted_to_comnt'].",";
			$pasedData['activityLog']['activity_task'] = "addComment";
			$this->createActivityLog($pasedData);

			echo COMMENT_ADDED; 
			exit;
		}
	}
	/**
	 *  This function will be used to get all projects those are submitted by the students
	 */
	function markProjectsList()
	{
		if(!in_array($this->Session->read('user_type'), array(1,7,2,3)))
		{
			$this->Session->setFlash(ERR_NOT_AUTHORIZED_THIS);
			$this->redirect("/projects");
		}
		$filters = "";
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 )
		{
			$admin_id= $this->getAdminId();
			$filters = "Project.admin_id= ".$admin_id;
 		} 
		else if($this->Session->read('user_type')==2 || $this->Session->read('user_type')==3)
		{ 
			$filters = "Project.leader_id=".$this->Session->read('userid');
		}
		else {
			$filters.=" 1=1 ";
		}
		$filters.=" AND Project.published =1 AND DATEDIFF(curdate(), date_format(projectStudent.submitted_date, '%Y-%m-%d'))<=2"; 
		$projects = $this->projectStudent->getProjectsForMarking($filters);	
		$grpAcToDate = array(); 
		if(count($projects)>0)
		{
			$gotData = array();
			$preDate = "";
			$i = 0;
			$currDate = date("Y-m-d");
			$yesterday = date("Y-m-d", strtotime("-1 DAY"));
			$dayBeforeYesterday = date("Y-m-d", strtotime("-2 DAY"));
			foreach ($projects as $rec)
			{	
				$dd = explode(" ", $rec['projectStudent']['submitted_date']);
				$date = date("Y-m-d", strtotime($dd[0]));
				if(strtotime($currDate) == strtotime($date))
				{	
					//Insert in today array
					$grpAcToDate[0][] = $rec;
				}
				else if(strtotime($yesterday) == strtotime($date))
				{				
					//Insert in today array
					$grpAcToDate[1][] = $rec;
				}
				else if(strtotime($dayBeforeYesterday) == strtotime($date))
				{				
					//Insert in today array
					$grpAcToDate[2][] = $rec;
				}
			}
		}
	 	$this->set("projects", $grpAcToDate);
	 
	}
	//It will be used to list out the projects on RHS of marking page
	function projectsMarking($marked=0)
	{
		$filters = "";
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 || $this->Session->read('user_type')==3)
		{
			$admin_id= $this->getAdminId();
			$filters = "Project.admin_id= ".$admin_id;
 		} 
		else if($this->Session->read('user_type')==2 )
		{ 
			$filters = "Project.leader_id=".$this->Session->read('userid');
		}
		else {
			$filters.=" 1=1 ";
		}
		$filters.=" AND Project.published =1 AND marked = ".$marked;
		$this->projectStudent->unbindModel(array("belongsTo"=>array("Project"))); 
		$this->paginate = array('projectStudent'=>array(
			"fields"=>"projectStudent.submitted_date, projectStudent.marked, Project.title, Project.id, Subject.title, User.id, User.firstname, User.lastname",		
			"conditions"=>$filters,
			"limit"=>5,
			"joins"=>array(
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"projects",
	 	 		"alias"=>"Project",
	 	 		"conditions"=>"Project.id = projectStudent.project_id"
	 	 		) 	,
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"subjects",
	 	 		"alias"=>"Subject",
	 	 		"conditions"=>"Subject.id = Project.subject_id"
	 	 		),
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"users",
	 	 		"alias"=>"User",
	 	 		"conditions"=>"User.id = projectStudent.user_id"
	 	 		)  	 	
	 	 	),
	 	 	"order"=>"projectStudent.submitted_date DESC"		
			));	
		$this->projectStudent->unbindModel(array("belongsTo"=>array("Project"))); 
		$data = $this->paginate('projectStudent');		
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";
		$totalPages = isset($this->request->params['paging']['projectStudent']['pageCount'])?$this->request->params['paging']['projectStudent']['pageCount']:"";		
		$order = isset($this->request->params['paging']['projectStudent']['options']['order'])?$this->request->params['paging']['projectStudent']['options']['order']:"";
  		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->set("projects", $data);
		$this->render("project_marking", "ajax");
	}
	/**
	 * To make the project as archived
	 */
	function closeProject($project_id)
	{
		if(!in_array($this->Session->read('user_type'), array(1,2,3,7)))
		{
			$this->Session->setFlash(ERR_NOT_AUTHORIZED_THIS);
 		}
		else 
		{
			if(is_numeric($project_id)) 
			{	
				$this->Project->updateAll(array("published" => "2") , "(admin_id = ".$this->Session->read('userid')." OR created_by = ".$this->Session->read('userid')." OR leader_id = ".$this->Session->read('userid').") AND id = ".$project_id);			 
				$this->Session->setFlash(PROJECT_STATUS);
			}
		}
		$this->redirect("/projects");
	}
	/**
	 * To make the project as published
	 */
	function openProject($project_id)
	{
		if(!in_array($this->Session->read('user_type'), array(1,2,3,7)))
		{
			$this->Session->setFlash(ERR_NOT_AUTHORIZED_THIS);
 		}
		else 
		{
			if(is_numeric($project_id)) 
			{	
				$this->Project->updateAll(array("published" => "1") , "(admin_id = ".$this->Session->read('userid')." OR created_by = ".$this->Session->read('userid')." OR leader_id = ".$this->Session->read('userid').") AND id = ".$project_id);			 
				$this->Session->setFlash(PROJECT_STATUS);
			}
		}
		$this->redirect("/projects");
	}
	/**
	 * In pLace editing of the tasks on the create project page
	 *
	 */
	function updateTaskWeight()
	{
		if(isset($this->request->params['form']['id']))
		{
			$taskIdArray = explode("_", $this->request->params['form']['id']);
			$taskId = $taskIdArray[1];
			$value['weight'] = trim($this->request->params['form']['value']);
			
			$this->projectTask->id = $taskId;			
			$this->projectTask->Save($value);
			echo trim($value['weight']);
			die;
		}
	}
	/**
	 * 
	 */
	function extraTaskDocs()
	{
	 
		if(isset($this->request->query['addFile'])>0)
		{
			$this->request->data['projectTaskExtraDoc']['project_id'] = $this->request->query['project_id'];
			$this->request->data['projectTaskExtraDoc']['task_id'] = $this->request->query['task_id'];
			$this->request->data['projectTaskExtraDoc']['user_id'] = $this->Session->read("userid");
		 	$this->request->data['projectTaskExtraDoc']['refer_file_id'] = $this->request->query['addFile'];
	 	 	$this->projectTaskExtraDoc->id = -1;
			$this->projectTaskExtraDoc->Save($this->request->data['projectTaskExtraDoc']); 
			
			$response['success'] = MSG_TASKDOC_UPLOADED;
			$response['id'] = $this->projectTaskExtraDoc->getLastInsertId();		
			
	 		$taskDetail = $this->projectTask->find('first', array(
			"conditions"=>"projectTask.id = ".$this->request->data['projectTaskExtraDoc']['task_id'],
			"fields"=>"Project.*, projectTask.*",
				"joins"=>array(
		 							array("type"=>"inner",
		 							"table"=>"projects",
		 							"alias"=>"Project",
		 							"conditions"=>array("Project.id = projectTask.project_id")
		 							) 
		 						)	
		 		)
			);	 
			
	 		$taskDetail['projectTask'] =  $taskDetail['projectTask'];
	 		$pasedData = array();
  	 		$prjDetail['Project'] = $taskDetail['Project'];
 	 		$pasedData['Project']['title'] = $prjDetail['Project']['title'];
			$pasedData['Project']['id'] = $prjDetail['Project']['id'];		
			$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
			$pasedData['User']['id'] = $this->Session->read("userid");				
			$pasedData['activityLog']['user_ids'] = 
	 		$pasedData['Task']['title'] = $taskDetail['projectTask']['title'];
	 		$pasedData['Document']['id'] = $this->request->data['projectTaskExtraDoc']['refer_file_id'];			
   			$pasedData['activityLog']['activity_task'] = "extraDocFromAdminInTask";		 
			//then this activity will be sent to all the students who belongs to that project 
			//Find the students who are in the group 				
			$getIndiStudent = array();
			$getStudentFromGroups = array();
			if($prjDetail['Project']['groups']!='')
			{
				$getStudentFromGroups = $this->classgroupStudent->find("list", array(
				"conditions"=>"classgroupStudent.group_id IN (".$prjDetail['Project']['groups'].")",
				"fields"=>"classgroupStudent.user_id, classgroupStudent.user_id"			
					)
				);
			}
	 		if($prjDetail['Project']['otherUsers']!='')
			{
				//Find the students who are in the group 				
				$getIndiStudent = explode(",", $prjDetail['Project']['otherUsers']);
			}
			$getStudentFromGroups = array_merge($getStudentFromGroups, $getIndiStudent);
		 	$st = ",".implode(",",$getStudentFromGroups).",";//$prjDetail['Project']['leader_id'].",".$prjDetail['Project']['admin_id'].",";		
		 	$pasedData['activityLog']['user_ids'] = $st;
			$this->createActivityLog($pasedData); 
		}
		if(isset($this->request->query['delId'])>0)
		{
			$this->projectTaskExtraDoc->delete($this->request->query['delId']);
		}
		if($this->request->query['task_id']!='')
		{
			$docs = $this->projectTaskExtraDoc->find('all', array(
			"conditions"=>"projectTaskExtraDoc.task_id = ".$this->request->query['task_id'],
			"fields"=>"projectTaskExtraDoc.id, userFile.id, userFile.name, userFile.file_name, fileType.icon",
				"joins"=>array(
		 							array("type"=>"inner",
		 							"table"=>"files",
		 							"alias"=>"userFile",
		 							"conditions"=>array("userFile.id = projectTaskExtraDoc.refer_file_id")
		 							),
		 							array("type"=>"inner",
		 							"table"=>"file_types",
		 							"alias"=>"fileType",
		 							"conditions"=>array("fileType.id = userFile.file_type_id"))
		 								)	
		 						)
		 		); 
		 	$this->set("docs", $docs);
		} 
		$this->set("task_id", $this->request->query['task_id']);
		$this->render("extra_task_docs","ajax");
	}
	function completeProject($project_id)
	{
		$pasedData = array();
 		$prjDetail = $this->Project->findById($project_id);;
 		if(isset($prjDetail['Project']['title']))
 		{
	 		$pasedData['Project']['title'] = $prjDetail['Project']['title'];
			$pasedData['Project']['id'] = $prjDetail['Project']['id'];		
			$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
			$pasedData['User']['id'] = $this->Session->read("userid");				
			$pasedData['activityLog']['user_ids'] = ",".$prjDetail['Project']['leader_id'].",".$prjDetail['Project']['admin_id'].",";	
	 	 	
			$pasedData['activityLog']['activity_task'] = "completeProject";		 
			//then this activity will be sent to all the students who belongs to that project 
			//Find the students who are in the group 				
		 	$this->createActivityLog($pasedData); 
		 	$this->Session->setFlash(MSG_COMPLETED_PROJECT);
 		}
	 	$this->redirect("/projects");
	}
}
