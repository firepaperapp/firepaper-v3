<?php
/* SVN FILE: $Id: app_controller.php 4409 2007-02-02 13:20:59Z phpnut $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4409 $
 * @modifiedby		$LastChangedBy: phpnut
 * @lastmodified	$Date: 2007-02-02 07:20:59 -0600 (Fri, 02 Feb 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.cake
 */
class AppController extends Controller {

	var $helpers=array('Js','Html','Utility','AddJsCss');
	var $components=array('Session','Cookie','Image','Email');
	var $breadcrumb=array('Home'=>'');
	var $uses = array('activityLog','projectStudent','Department','DepartmentStudent','DepartmentTeacher','User','Project');

	var $categoryType;
	var $metaTitle;
	var $metaKeywords;
	var $metaDescription;
	var $hiddenParentID;
	var $keywords;

	  /**
	 * Determines if a user can use the remember me feature of the Users/login function
	 *
	 */
	public $allowCookie = TRUE;



	/**
	 * Determines length of time that the cookie will be valid.
	 *
	 * If a value is here, but allowCookie is FALSE, then the term value is ignored.
	 */
	public $cookieTerm = '+4 weeks';

	/**
	 * Name to use for cookie holding user values
	 */
	public $cookieName = 'User';

 

	function __construct($request = null, $response = null)
	{
	    parent::__construct($request, $response);
	
		//    if ($this->name == 'CakeError') {
		//      header('location:'.COMMON_URL);
		//	  exit;
		//    }
	}
   function beforeFilter(){
	   	
		$this->Auth->logoutRedirect = array('component'=>'User','action'=>'logout');
   		$departments = array();
   		$dueInCount = 0;
		if($this->request->params['controller'] == "projects")
		{
			## Following will be used to get the departments
			## If user is an educator then find out the projects created by him
			## If an admin then find out all the departments within his domain
			## If a student then find out all the departments in which he has assigned in any project
			## Due in
			if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7|| $this->Session->read('user_type')==3)
			{
	 			$admin_id = $this->getAdminId();
	 			$filters = "Department.admin_id= ".$admin_id;
				$departments = $this->Department->find("all", array(
				"conditions"=> $filters
				)
				);
				$dueInCount = $this->Project->find("count",array(
	 			"conditions"=>"Project.published =1 AND Project.duedate = curdate() AND Project.admin_id = ".$admin_id
	 			
	 			));
			}
			else if($this->Session->read('user_type')==2 )
			{ 
	 			$filters = "DepartmentTeacher.user_id = ".$this->Session->read('userid');		 
	 			$departments = $this->DepartmentTeacher->find("all", array(
				"conditions"=> $filters,
				"fields"=>"Department.id, Department.title",
				"joins"=>array(
					array(
					"type"=>"inner",
					"alias"=>"Department",
					"table"=>"departments",
					"conditions"=>"DepartmentTeacher.department_id = Department.id"
					)
				),
				"group"=>"DepartmentTeacher.department_id"
				)
				);
				
				$dueInCount = $this->Project->find("count",array(
	 			"conditions"=>"Project.published =1 AND Project.duedate = curdate() AND Project.leader_id = ".$this->Session->read('userid')
	 			
	 			));
	 			
			}
			else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
			{
				
				$departments = $this->DepartmentStudent->find("all", array(
				"conditions"=> "DepartmentStudent.user_id = ".$this->Session->read('userid'),
				"fields"=>"Department.id, Department.title",
				"joins"=>array(
					array(
					"type"=>"inner",
					"alias"=>"Department",
					"table"=>"departments",
					"conditions"=>"DepartmentStudent.department_id = Department.id"
					)
				)
				)
				);				
				$dueInCount = $this->projectStudent->find("count",array(
	 			"conditions"=>"projectStudent.completed = 0 AND Project.published =1 AND Project.duedate = curdate() AND projectStudent.user_id = ".$this->Session->read('userid')	 			
	 			));
	 			
			} 
		}
		else if($this->request->params['controller'] == "files" && $this->request->params['action']=="getFiles")
		{
			 
		}
 		$user_id = $this->getAdminId();
		$prjCount = 0;
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7|| $this->Session->read('user_type')==3)
		{
 			
 			$prjCount = $this->projectStudent->find("count",array(
 			"conditions"=>"projectStudent.marked = 0 AND Project.published =1 AND Project.admin_id = ".$user_id
 			
 			));
  		}
		else if($this->Session->read('user_type')==2 )
		{ 
	 		$user_id = $this->Session->read('userid');			 
 			$prjCount = $this->projectStudent->find("count",array(
 			"conditions"=>"projectStudent.marked = 0 AND Project.published =1 AND Project.leader_id = ".$user_id
 			));
  		}
		else if($this->Session->read('user_type')==4 || $this->Session->read('user_type')==5)
		{	
			$user_id = $this->Session->read('userid');
		 	$prjCount = $this->projectStudent->find("count",array(
 			"conditions"=>"projectStudent.completed = 0 AND projectStudent.user_id = ".$user_id 
 			));
		}
		//if($this->Session->read("metas") == "")
		{
			$select = "SELECT * FROM metas";
			$res = $this->Department->query($select);
			$this->Session->write("metas", $res);
		}
		if($this->request->is('ajax')!=1)
		{	 
			$metas = $this->Session->read("metas");
			foreach($metas as $rec)
			{				 
				if($rec['metas']['section'] == $this->request->params['controller'])
				{
					$this->set("metaTitle", $rec['metas']['title']);
					$this->set("metaKeyword", $rec['metas']['keyword']);
					$this->set("metaDescription", $rec['metas']['description']);
				}
			}
		}		 
		//print $prjCount;
		$this->set("prjCount", $prjCount);
		$this->set("dueInCount", $dueInCount);
 		$this->set("departments", $departments);
	}

	function beforeRender() {
 		$res= "";
		$this->set('breadcrumbs',$this->breadcrumb);		
		Controller::disableCache();
	    //if($this->Session->read('userid')!=0)
 		//$res= $this->User->getUserCounter($this->Session->read('userid'));
		//$this->set("counter",$res);


		//$this->set('breadcrumbs',$this->breadcrumb);
		//$this->menu();
		//$this->getcontrollerName();
	}


/*
		send  emails
		params: arrfields is array type
		array('to'=>'to@serv.com','from'=>'','viewBody'=>'','title'=>'title');
	*/
	function authorize()
	{
		if(!$this->Session->read("login"))
		{
			$this->redirect("/admin/login");
			exit;
		}
	}//EF
	function userauthorize(){
		if(!$this->Session->read("user")){
			header('location:'.COMMON_URL.'/home/login');
			exit;
		}
	}//EF
	function swiftmail($arrfields=array()){
		$this->swiftMailer->connect_smtp();
		$this->swiftMailer->to=$arrfields['to'];
		$this->swiftMailer->from	= $arrfields['from']; //ADMIN_EMAIL;
		$this->swiftMailer->viewBody($arrfields['viewBody']);//'member_signup'
		//pr($this->swiftMailer);
		$this->swiftMailer->send($arrfields['subject']);
		return;
	}
	function loginSessionSet($loginUser)
	{	
	 	$this->Session->write("user_type",$loginUser['user_type_id']);
	 	$this->Session->write("sitetitle",$loginUser['sitetitle']);
	 	$this->Session->write("userid",$loginUser['id']);
		$this->Session->write("firstname",$loginUser['firstname']);
		$this->Session->write("lastname",$loginUser['lastname']);
		$this->Session->write("email",$loginUser['email']);
		$this->Session->write("profilepic",$loginUser['profilepic']); 
		$this->Session->write("cansignup",$loginUser['cansignup']); 
		$this->Session->write("username",$loginUser['username']); 
		$this->Session->write("adminsIDStr", isset($loginUser['adminsIDStr'])?$loginUser['adminsIDStr']:""); 
	 	$this->Session->write("admin_id",$loginUser['admin_id']); 
 	}

	function uploadimgdef($source,$destination,$width=84,$height=108,$merge=0,$crop=0)
	{
		$this->Image->ImageFile=$source;
		$this->Image->Resize = true;
		$this->Image->ResizeScale = 100;
		$this->Image->Position = 'topleft';
		$this->Image->Compression = 80;
		$this->Image->Width = $width;
		$this->Image->Height = $height ;
		$this->Image->Merge = $merge ;
		$this->Image->Crop = $crop ;
		// call funtion at last
		$image	= $this->Image->SaveImageAs($destination,TRUE);
		//echo $image;
		return  $image;
	}
	/**
	 * Activity Insert
	 * User ids set: whom to sent the activity
	 * Common
		 * $pasedData['User']['name']
		 * $pasedData['User']['id']
		 
	 * Project Taks		 
		 
	 	 * $pasedData['Project']['title']  
		 * $pasedData['Project']['id']
		 
		 * addComment on Project 
			 
			 * $pasedData['Comment']['id']
		 * uploadDocument on Project
			 * $pasedData['Document']['id']
		 * deleteDocument on Project
			 * $pasedData['Document']['title']	 
		 * createProject
		 	* 	nothing additional 
		 * tickTaskDoneFrmUser
		 	* $pasedData['Task']['title']	 
		 * markProject
		 	 only project id
		 	 
	 * Whiteboard Taks		 
	 	* $pasedData['Whiteboard']['title']  
		* $pasedData['Whiteboard']['id']
		 	
	 * Comment Tasks
	 	
	 	* personalComment
	 		* $pasedData['Comment']['id'] 	
	 * 
	 */
	
	function createActivityLog($pasedData = array())
	{
		$stQuery = "SELECT aConf.template
					FROM activity_config as aConf
					WHERE task = '".$pasedData['activityLog']['activity_task']."'";
		$data = $this->activityLog->query($stQuery);
		if(isset($data[0]['aConf']['template']))
		{
			//We will make activity text
			$gotText = $data[0]['aConf']['template'];
			$gotText = str_replace("%who%", "<a href='".SITE_HTTP_URL."users/viewProfile/".$pasedData['User']['id']."'>".$pasedData['User']['name']."</a>", $gotText);
			
			//Replacing the template accoring to the task that is triggered
			switch ($pasedData['activityLog']['activity_task'])
			{				
				case "addComment":
					{
						//we assume that we will get three parameters: who, commentlink and project					
						$gotText = str_replace("%commentlink%", "<a href='".SITE_HTTP_URL."dashboard/viewComments/'>comment</a>", $gotText);
						$link = "markProject";
						if($pasedData['activityLog']['mode'] == "to_user")
						{
							$link = "viewDetails";
						}
						
						
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/".$link."/".$pasedData['Project']['id']."/".$pasedData['User']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
					}
					break;
				case "addCommentInTask":
					{
						//we assume that we will get three parameters: who, commentlink and project					
						$gotText = str_replace("%commentlink%", "<a href='".SITE_HTTP_URL."dashboard/viewComments/'>comment</a>", $gotText);
						$link = "markProject";
					 
						$gotText = str_replace("%task%", $pasedData['task']['title'], $gotText);
						
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/".$link."/".$pasedData['Project']['id']."/".$pasedData['User']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
					}
					break;
				case "uploadDocumentToAdmin": /*send activity to Admin*/
				{
					//project and document
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/markProject/".$pasedData['Project']['id']."/".$pasedData['User']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%document%", "<a href='".SITE_HTTP_URL."files/downloadFile/".$pasedData['Document']['id']."'>document</a>", $gotText);
				}
				case "uploadDocument": /*send activity to user*/
					{
						//project and document
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/viewDetails/".$pasedData['Project']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%document%", "<a href='".SITE_HTTP_URL."files/downloadFile/".$pasedData['Document']['id']."'>document</a>", $gotText);
						
					}
					break;
				case "extraDocFromAdminInTask":
					{
						//project and document
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/viewDetails/".$pasedData['Project']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%document%", "<a href='".SITE_HTTP_URL."files/downloadFile/".$pasedData['Document']['id']."'>document</a>", $gotText);
						$gotText = str_replace("%task%", $pasedData['Task']['title'], $gotText);
						
					}
					break;
				case "deleteDocumentToAdmin":
					
				case "documentReplaceToAdmin":
					{
						//project and document
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/markProject/".$pasedData['Project']['id']."/".$pasedData['User']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%document%", $pasedData['Document']['title'], $gotText);
						
					}
				case "deleteDocument":/*send activity to user*/
				case "documentReplace":
					{
						//project and document
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/viewDetails/".$pasedData['Project']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%document%", $pasedData['Document']['title'], $gotText);
						
					}
					break;
				case "projectUpdate":
				case "markProject": // admin has marked a project of student
				
				case "createProject":
					{
						//project only
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/viewDetails/".$pasedData['Project']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
					}
					break;
				
				case "personalComment":
					{
						$gotText = str_replace("%commentlink%", "<a href='".SITE_HTTP_URL."users/viewComments/'>comment</a>", $gotText);
					}
					break;
				case "tickTaskDoneFrmUser":
				case "completeProject":
					{
						$gotText = str_replace("%project%", "<a href='".SITE_HTTP_URL."projects/markProject/".$pasedData['Project']['id']."/".$pasedData['User']['id']."'>".$pasedData['Project']['title']."</a>", $gotText);
						$gotText = str_replace("%task%", $pasedData['Task']['title'], $gotText);
						break;
					}
				case "whiteboardComment":
					{
					//	$gotText = str_replace("%commentlink%", "<a href='".SITE_HTTP_URL."dashboard/viewComments/'>comment</a>", $gotText);
						
						$gotText = str_replace("%whiteboard%", "<a href='".SITE_HTTP_URL."whiteboards/viewWhiteboard/".$pasedData['Whiteboard']['id']."'>".$pasedData['Whiteboard']['title']."</a>", $gotText);
						
						break;
					}
					
			}
			//After the template creation, we will insert populate activity_logs for the users to be triggered.
			$this->activityLog->id = -1;
			$d['activityLog']['user_ids'] = $pasedData['activityLog']['user_ids'];
			$d['activityLog']['activity_text'] = $gotText;
			$this->activityLog->Save($d);
			return;
		}
	}
		/**
		 * Delete a file that is assigned to a project
		 * 
		 */
		function delFileFromProject($fileId, $reason, $doDelRevison)
		{
			$this->loadModel("projectTask");
			$this->loadModel("projectStudent");
			$subFilesSt = $fileId;
			$subFiles = array();
			
			//we will get all subrevisons
			$subFiles = $this->userFile->find("list", array(
			"conditions"=>"userFile.version_of = ".$fileId,
			'fields' => array('userFile.id'),
			)
			);
			if(count($subFiles)>0)
			{
				$subFilesSt.= ",".implode(",",$subFiles);
			}
			$act = "Deleted";
			if($doDelRevison == 0)
			{
				$act = "Replaced";		
				$resLastDoc = $this->userFile->find('first',
							array("conditions"=>"userFile.version_of =".$fileId,
								  "order"=>"id desc",
								  "fields" => "userFile.id, file_name, file_type_id"
								)
									);		 
			}
			if(in_array($this->Session->read("user_type"), array(1,2,3,7)))
			{
				//if user is admin or educator				
				$tasks = $this->projectTask->find("all", array(
				"fields"=>"Project.id, Project.title, projectTask.title",
				"conditions"=>"projectTask.refer_file_id IN(".$subFilesSt.")",
				"joins"=>array(
					array(
					"type"=>"inner",
					"alias"=>"Project",
					"table"=>"projects",
					"conditions"=>array("Project.id = projectTask.project_id")),
					)
				)
				);
		  	 	$subject = "Task ".$act;
				foreach($tasks as $rec)
				{
					$stInform = "";
					//we will get the users who are in the project and send them an email and an activity log will also be generated for the same					
		 			$this->projectStudent->unbindModel(array('belongsTo' => array('Project')));
					$students = $this->projectStudent->find("all", array(
					"fields"=>"User.firstname, User.lastname, User.id, User.email",
					"conditions"=>"projectStudent.project_id = ".$rec['Project']['id'],
					"joins"=>array(
						array(
						"type"=>"inner",
						"alias"=>"User",
						"table"=>"users",
						"conditions"=>array("User.id = projectStudent.user_id"))
						)
					));
				 	foreach($students as $stu)
					{
						//We will email the user for the new project 
						$sUserFullName = $stu['User']['firstname']." ".$stu['User']['lastname'];
					    $this->Email->to =   $stu['User']['email'];				
						$this->Email->fromName = ADMIN_NAME;
					    $this->Email->from = EMAIL_FROM_ADDRESS;
					    $urlUsed = SITE_HTTP_URL."projects/viewDetails/".$rec['Project']['id'];
				
				        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>".
				        ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"))." has $act a task <b>".$rec['projectTask']['title']."</b> from the project <b>".$rec['Project']['title']."</b> and has mentioned the following reason for this:<br/>".
				        nl2br($reason)."
				        <br/><br/>
						
						Please login into your account and [<a href='".$urlUsed."'>Click Here</a>] to view the updated project.<br/><br/>
				
						Thanks & Regards,<br/>
						Website Support <br/>
						".SITE_NAME." <br/>";
						
				        $this->Email->text_body = $sMessage;
				        $this->Email->subject = SITE_NAME.' - '.$subject;
				        $result = $this->Email->sendEmail();	
				        $stInform.= $stu['User']['id'].",";
					}
					$pasedData = array();
			 		$pasedData['Project']['title'] = $rec['Project']['title'];
					$pasedData['Project']['id'] = $rec['Project']['id'];					
					
					$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
					$pasedData['User']['id'] = $this->Session->read("userid");
					$pasedData['Document']['title'] = $rec['projectTask']['title'];
					$pasedData['activityLog']['user_ids'] = ",".$stInform;
					if($doDelRevison == 0)
					{
						$pasedData['activityLog']['activity_task'] = "documentReplace";
					}
					else 
						$pasedData['activityLog']['activity_task'] = "deleteDocument";				
					$this->createActivityLog($pasedData);				
					//Delete from table
					
				}
				if($doDelRevison == 0)
				{
					$f = explode(".",$resLastDoc['userFile']['file_name']);
					$ret = $this->projectTask->updateAll(
							array("refer_file_id"=> $resLastDoc['userFile']['id'],
								  "file_name"=>"'".$resLastDoc['userFile']['file_name']."'",
								  "title"=>"'".$f[0]."'",
								  "file_type_id"=>$resLastDoc['userFile']['file_type_id']
								),
							array("refer_file_id"=>$fileId)
						);
				 
				}
				else 
				{
					$delQuery = "DELETE project_tasks, project_comments
								 FROM project_tasks
								 LEFT JOIN project_comments ON project_comments.task_id = project_tasks.id
								 WHERE project_tasks.refer_file_id IN( ".$fileId.")";
					$this->projectTask->query($delQuery);
				}
			}
			else {
				//if user is student
				$this->loadModel("projectStudentTaskDoc");
				//if user is admin or educator				
				$docs = $this->projectStudentTaskDoc->find("all", array(
				"fields"=>"Project.id, Project.title, projectStudentTaskDoc.title, User.firstname, User.lastname, User.id",
				"conditions"=>"projectStudentTaskDoc.refer_file_id IN(".$subFilesSt.")",
				"joins"=>array(
					array(
					"type"=>"inner",
					"alias"=>"Project",
					"table"=>"projects",
					"conditions"=>array("Project.id = projectStudentTaskDoc.project_id"),
					),
					array(
					"type"=>"inner",
					"alias"=>"User",
					"table"=>"users",
					"conditions"=>array("User.id = Project.leader_id")
					)
				),
				"group"=>"Project.id"				  
				)				
				);
			 	$subject = "User Document Deleted";
				foreach($docs as $rec)
				{
					//we will send email to the leader of the project and an activity log will also be generated for the same
	 				//We will email the user for the new project 
					$sUserFullName = $rec['User']['firstname']." ".$rec['User']['lastname'];
				    $this->Email->to =  $rec['User']['email'];				
					$this->Email->fromName = ADMIN_NAME;
				    $this->Email->from = EMAIL_FROM_ADDRESS;
				    $urlUsed = SITE_HTTP_URL."projects/markProject/".$rec['Project']['id']."/".$this->Session->read("userid");
			
			        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>".
			        ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"))." has $act a document <b>".$rec['projectStudentTaskDoc']['title']."</b> from the project <b>".$rec['Project']['title']."</b> and has mentioned the following reason for this:<br/>".
				        nl2br($reason)."<br/><br/>
			
					Please login into your account and [<a href='".$urlUsed."'>Click Here</a>] to view the updated project.<br/><br/>
			
					Thanks & Regards,<br/>
					Website Support <br/>
					".SITE_NAME." <br/>";
					
			        $this->Email->text_body = $sMessage;
			        $this->Email->subject = SITE_NAME.' - '.$subject;
			        $result = $this->Email->sendEmail();	
			        
			        //Create activity
					$pasedData = array();
			 		$pasedData['Project']['title'] = $rec['Project']['title'];
					$pasedData['Project']['id'] = $rec['Project']['id'];					
					
					$pasedData['User']['name'] =   ucfirst($this->Session->read("firstname")." ".$this->Session->read("lastname"));
					$pasedData['User']['id'] = $this->Session->read("userid");
					$pasedData['Document']['title'] = $rec['projectStudentTaskDoc']['title'];
					
					$pasedData['activityLog']['user_ids'] = ",".$rec['User']['id'].",";
					if($doDelRevison == 1)
					{
						$pasedData['activityLog']['activity_task'] = "documentReplaceToAdmin";
					}
					else 
					{						
						$pasedData['activityLog']['activity_task'] = "deleteDocument";								}			 
					$this->createActivityLog($pasedData);				
					
				}
				if($doDelRevison == 0)
				{
					$f = explode(".",$resLastDoc['userFile']['file_name']);
					$ret = $this->projectTask->updateAll(
							array("refer_file_id"=> $resLastDoc['userFile']['id'],
								  "file_name"=>"'".$resLastDoc['userFile']['file_name']."'",
								  "title"=>"'".$f[0]."'",
								  "file_type_id"=>$resLastDoc['userFile']['file_type_id']
								),
							array("refer_file_id"=>$fileId)
						);
				 
				}
				else 
				{
					
					$delQuery = "DELETE projectStudentTaskDoc, project_comments
								 FROM project_student_task_docs as projectStudentTaskDoc
								 LEFT JOIN project_comments ON projectStudentTaskDoc.id = project_comments.student_doc_id
								 WHERE projectStudentTaskDoc.refer_file_id IN( ".$fileId.")";
					$this->projectStudentTaskDoc->query($delQuery);
					
				}
			}
		}
	
	/******************* function to find the admin_id STARTS****************************************/

	function getAdminId()
	{
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==3)
		{
			$admin_id = $this->Session->read('userid');
		}
		else
		{
			$admin_id = $this->Session->read('admin_id');
		}
		
		return $admin_id;
		
	}
	/******************* function to find the admin_id ENDS****************************************/
	function userPlanUpdate($dta, $usr)
	{
	 	if($dta['Package']['user_type_id'] != $usr['User']['user_type_id'])
		{
			$feeStudentPack = $this->Package->find("first", array(
			"conditions"=>"Package.user_type_id = 5 AND trial = 1 AND amount < 1"
			)
			);							
			//User want to change the account type
			if($usr['User']['user_type_id'] == 1)
			{
				if($dta['Package']['user_type_id'] == 5)
				{
					//User is admin and downgrades, he becomes a student
					//We will get his students and educators both and then make all of them independent students
					$conditions = "User.admin_id = ".$usr['User']['id']." AND User.user_type_id IN(2, 4, 7)";
					
				}
				else if($dta['Package']['user_type_id'] == 3)
				{
					//User is admin and downgrades, he becomes a educator
					//We will get his educators and then make all of them independent students
					$conditions = "User.admin_id = ".$usr['User']['id']." AND User.user_type_id IN(2,7)";
				}
				$this->User->updateAll(array("User.user_type_id" => 5, "User.package_id" => $feeStudentPack['Package']['id'], "totalspace" => "totalspace+".($feeStudentPack['Package']['space']*MULTIPLY_BY)), $conditions);
				//mark the project status as closed
				$this->Project->updateAll(array("published" => 0),array("admin_id"=>$usr['User']['id']));
			}
			else if($usr['User']['user_type_id'] == 3)
			{
				 
				if($dta['Package']['user_type_id'] == 1)
				{
					//User is educator and upgrades, he becomes a admin
				}
			 	else if($dta['Package']['user_type_id'] == 5)
				{
					//User is admin and downgrades, he becomes a student
					$conditions = "User.admin_id = ".$usr['User']['id']." AND User.user_type_id IN(4,7)";
					$this->User->updateAll(array("User.user_type_id" => 5, "User.package_id" => $feeStudentPack['Package']['id'], "totalspace" => "totalspace+".($feeStudentPack['Package']['space']*MULTIPLY_BY)),  $conditions);
					
					//mark the project status as closed
					$this->Project->updateAll(array("published" => 0),array("admin_id"=>$usr['User']['id']));
				}
			}
			else if($usr['User']['user_type_id'] == 5)
			{
				
				if($dta['Package']['user_type_id'] == 1)
				{
					//User is educator and upgrades, he becomes a admin
				}
			 	else if($dta['Package']['user_type_id'] == 3)
				{
					//User is admin and downgrades, he becomes a student
				}								
			}	
		}
		$qry = "UPDATE users set package_id = ".$dta['Package']['id'].", totalspace = totalspace+".($dta['Package']['space']*MULTIPLY_BY).", user_type_id = ".$dta['Package']['user_type_id']." WHERE id = ".$usr['User']['id'];
		$this->User->query($qry);
	
	
		//Email  user for the new plan
		$sUserFullName = $usr['User']['firstname']." ".$usr['User']['lastname'];
	    $this->Email->to =  $this->Session->read("email");				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	    
		$userType = $this->UserType->findById($dta['Package']['user_type_id']);
        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>

		Your payment plan is updated on ".SITE_NAME." successfully.<br/><br/>
		Here is your new plan:<br/>
		Amount: $".$dta['Package']['amount']." PM<br/>
		Space: ".$dta['Package']['space']." GB<br/>
		Account type: ".$userType['UserType']['title']."<br/><br/>
		
		Please use the URL below to login to your account:<br/>
		<a href='".SITE_HTTP_URL."/'>".SITE_HTTP_URL."</a><br/><br/>

		Thanks & Regards,<br/>
		Website Support <br/>
		".SITE_NAME." <br/>";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = SITE_NAME.' - Plan Updated';
        $result = $this->Email->sendEmail();
	 }
	 /**
	  * Common function to save user for both front end and admin end
	  */
	 function saveUser($resultData)
	{
		
		//we will store the user data
	 	try 
		{
			$resultData['password_w'] = $resultData['password'];
			$resultData['password'] = md5($resultData['password']);
			$resultData['lastlogin'] = date("Y-m-d H:i:s");
			
			//We believe that space in db is in GB so we convert it into bytes
			$gotSpace = $resultData['packageDetails']['Package']['space'];
			$resultData['package_id'] = $resultData['packageDetails']['Package']['id'];
			$resultData['totalspace'] = MULTIPLY_BY*$gotSpace;
			//we will unset
			
 		
			$resultData['trialpackage'] = $resultData['packageDetails']['Package']['package_type']=="trial"?1:0;
	
			unset($resultData['trial']);
			unset($resultData['packageDetails']);
			unset($resultData['User']);
			$resultData['status'] = 1;
			$this->User->id = -1;
			$this->User->Save($resultData);
	 
			$userId = $this->User->getLastInsertId();
 			$resultData['user_id'] = $userId;
			
			
			
			//We will send an email to the user for account activation			
			
			$this->emailAfterStep2($resultData);
			//Insert in count table	 					
			$this->Session->setFlash(MSG_SUCCESSFULLY_REGISTERED);	
			$loginUser = $this->User->getUserData($userId);
			$loginUser['adminsIDStr'] = $loginUser['id'];
			
			$this->loginSessionSet($loginUser);
			 
			return true;
			//$this->redirect("/users/thanks");
			
		}
		catch (Exception $e)
		{
			$this->User->errMsg[] = ERR_SITE_DOWN;
			return false;
			
		}
	}
	function emailAfterStep2($data)
	{
//		echo "<pre>";
//		print_r($data);
//		echo EMAIL_FROM_ADDRESS;
//		die("here");
		$sUserFullName = $data['firstname']." ".$data['lastname'];
	    $this->Email->to =  $data['email'];				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	    
		$userType = $this->UserType->findById($data['user_type_id']);
        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>

		Your account has been created for ".SITE_NAME." successfully.<br/><br/>
		Here are your new login details:<br/>
		Username: ".$data['username']." <br/>
		Password: ".$data['password_w']." <br/>
		Account type: ".$userType['UserType']['title']."<br/><br/>
		Please use the URL below to login to your account:<br/>
		<a href='".SITE_HTTP_URL."/'>".SITE_HTTP_URL."</a><br/><br/>

		Thanks & Regards,<br/>
		Website Support <br/>
		".SITE_NAME." <br/>";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = SITE_NAME.' - Account Created';
        $result = $this->Email->sendEmail();
	}
}//End class
?>