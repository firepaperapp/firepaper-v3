<?php
App::uses('Sanitize', 'Utility');
class DashboardController  extends AppController{

	var $name = 'Dashboard';

	var $uses = array('UserType','User','State','Department','classgroupStudent','DepartmentTeacher', 'DepartmentStudent','classGroup','Announcement', 'AnnouncementStatus','coadminGaurdian','Subject','SubjectEducator','Project','projComments');

	var $helpers = array('Html', 'Form', 'Time','Js','Flash');
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
	var $paginate = array(
        'limit' => PAGE_LIMIT,
        'order' => array(
            'Department.id' => 'desc'
        )
    );
    function beforeRender()
    {
    	parent::beforeRender();
    	
    }
	function beforeFilter()
	{
		echo "<pre /> here..";
		print_r($this->Session->read()); exit;
		//echo "In BF >> Dashboard"; exit;
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->Auth->logoutRedirect = array('users/logout/');
			//$this->redirect("/users/logout");
		}
		else
		{
			if($this->Session->read("user_type")==6)
			{
					$this->redirect("/users/viewProfile");
			}
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

	function index(){ 
		
		echo "i am here in Index - dashboard"; exit;
		print "<pre />";
print_r($_SESSION);
//print "</pre>";
die;
		$this->set('announce_view','');
		if($this->Session->read("user_type")==1 || $this->Session->read("user_type")==2 ||$this->Session->read("user_type")==3 || $this->Session->read("user_type")==7)
		{
			$this->set('announce_view','admin');
		}

		if($this->Session->read("user_type")==4 || $this->Session->read("user_type")==5)
		{
			$this->set('announce_view','student');
		}
		$userId =  $this->Session->read('userid');
	 	$deptList = $this->Department->find("list", array(
		"conditions"=>"Department.admin_id = ".$userId,
		"fields"=>"Department.id, Department.title"
		)); 
		$this->set("deptList", $deptList);
	}

	function adminLatestActivity($userId="")
	{		 
		$userId = !isNull($userId)?$userId:$this->Session->read('userid');
		$lastDate = date("Y-m-d",strtotime("-5 DAY")); 
		$data = $this->activityLog->find('all', array(
		"conditions"=>"DATE_FORMAT(activityLog.created,'%Y-%m-%d') BETWEEN '".$lastDate."' AND '".date("Y-m-d")."' and activityLog.user_ids LIKE '%,".$userId.",%'",
		"order"=>"created DESC"
		)); 
		$this->set("data", $data);
		$this->set("userId", $userId);
 		$this->render("admin_latest_activity", "ajax");
	}
	function listActivity($userId=Null)
	{
		$userId = !isNull($userId)?$userId:$this->Session->read('userid');
		//$userData = $this->User->findById($userId, "User.lastlogin");
		//To get the latest activities from the last login
		$data = $this->activityLog->find("all", array(
		"conditions"=>"activityLog.user_ids LIKE '%,".$userId.",%'",
		"order"=>"activityLog.created DESC",
		"limit"=>10
			)
		); 
		$this->set("data", $data);
		$this->render("list_activity", "ajax");
	}
	/**
	 * To get the teachers and students in a department
	 * @input department_id
	 */
	function getStuAndTeachersForDept($department_id)
	{
		//To get the teachers in a department
		$teachers = $this->DepartmentTeacher->find("list", array(
		"conditions" => "DepartmentTeacher.department_id = ".$department_id,
		"fields"=>"User.id, User.firstname",
		'joins'=>array(
						array(
							'type'=>'inner', 
							"table"=>"users", 
							"alias"=>"User",
							"conditions"=>array("DepartmentTeacher.user_id = User.id")
							)
					  )							
		));
 		//To get the student in a department 
		$students = $this->DepartmentStudent->getStudents($department_id);
		$preStu = "";
		$studentsFinal = array();
		//making an array of users with its class groups
		if(count($students)>0)
		{
			$i = 0;
			foreach($students as $rec)
			{
				$uid = $rec['User']['id'];
					
				if(!isset($studentsFinal[$uid]['userdetail']))
				{
					$studentsFinal[$uid]['userdetail']['id'] = $rec['User']['id'];
					$studentsFinal[$uid]['userdetail']['name'] = $rec['User']['firstname']." ".$rec['User']['lastname'];
				}
				if(!isset($studentsFinal[$uid]['userdetail']['class']))												$studentsFinal[$uid]['userdetail']['class'] = "";
				
				if(isset($rec['classGroup']['title']) && $rec['classGroup']['title']!='')
				{	
					$studentsFinal[$uid]['userdetail']['class'].=" ".$rec['classGroup']['title'];					 
				}
			}
		}
		$this->set("teachers", $teachers);
		$this->set("students", $studentsFinal);
		$this->render("get_stu_and_teachers_for_dept", "ajax");
	}
	
	/**
	 * To view all activities
	 *
	 */
	function viewAllActivity($userId=NULL)
	{
		$userId = !isNull($userId)?$userId:$this->Session->read('userid');
		$data = $this->activityLog->find('all', array(
		"conditions"=>"activityLog.user_ids LIKE '%,".$userId.",%'",
		"order"=>"created DESC"
		));
		$this->set("data", $data);
 		$this->render("view_all_activity");
	}
	function students()
	{
		
	}
	function educators()
	{
		
	}
	/**
	 * Used to reder the outer view of the departments list,
	 * Internally it will make ajax call to the function getDepartmentList
	 */
	function departments()
	{
		if(!in_array($this->Session->read("user_type"), array(1, 7, 3))) 
		{
			$this->redirect("/");
		}		
		$this->Session->delete('departmentSearch');
		$this->layout = "default_front_inner";
	}
	/**
	 * It will list the departments that will belong to a particular admin
	 *
	 */
	function getDepartmentList()
	{
		$departmentChars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","all");
		$selectedChar = "all";
	 	$filters = "";
	 	################## Start Delete a Department ############################
 	 	if(isset($this->request->params['url']['d']) && !isNull($this->request->params['url']['d']))
   		{
			$ret = $this->Department->deleteAll(" Department.id = ".$this->request->params['url']['d']);
   			if($ret == true)
   			{
   				$this->Session->setFlash(MSG_REC_DELTED);
   			}
   			else 
   				$this->Session->setFlash(MSG_REC_CANT_DELETE);
   		}
	 	################## End Delete a Department ############################
	 	################## Start Setting Search Parameters ############################
  
	    if(isset($this->request->params['form']['title']) && count($this->request->params['form'])>0 && $this->request->params['form']['title']!='all') 
	    { 
	        	$filters.= " AND ( Department.title like '".add_Slashes(trim($this->request->params['form']['title']))."%')"; 
	        	$selectedChar = $this->request->params['form']['title'];
	    } 	
	    ################## END Setting Search Parameters ############################   
 	
		$admin_id = $this->getAdminId();

		$data = $this->Department->find('all', array(
   		"conditions"=>"Department.admin_id IN( $admin_id )".$filters,
   		"fields"=> "Department.title, Department.id, Department.created",
   		"order"=>"title"
   		)
   		);	
		
   		$goList = array();
   		//we will make an array with a-z corresponding to their departments
   		$i = 1;
   		foreach($data as $rec)
   		{
   			$firstChar = substr($rec['Department']['title'], 0, 1);  	   			
   			if(in_array(strtolower($firstChar), $departmentChars))
   			{
   				$rec['Department']['key'] = strtolower($firstChar);
   				$goList[strtolower($firstChar)][] = $rec['Department'];
   				$i++;
   			}
   			else {
   				$rec['Department']['key'] = 'Ext.';
   				$goList['others'][] = $rec['Department'];
   			}
   		}
   	 	//die;
   	 	$this->set("departmentChars", $departmentChars);
   	 	$this->set("selectedChar", $selectedChar);
   		$this->set('data', $goList);
		$this->render("get_department_list","ajax");
	}
	/**
	 * TO adda new department for a faculty
	 */
	function addEditDepartment($dept_id=null)
	{ 
		$admin_id = $this->getAdminId();
		if($this->request->data)
 		{
 			$result = $this->Department->validatDepartmentForm($this->request->data['Department'], $admin_id);
 			$response = array();
 	 		if($this->Department->err==0)						
 			{
 				//we will add department
 				if(!isset($this->request->data['Department']['dept_id']) || $this->request->data['Department']['dept_id']=='')	
 				{
 					$this->Department->id = -1;
 					$this->request->data['Department']['created_by'] = $this->Session->read('userid');
					$this->request->data['Department']['admin_id'] = $admin_id;
 					$this->Department->Save($this->request->data); 					 
 					$response['success'] = MSG_DEPT_CREATED;
 					
 				}
 				else 
 				{ 					
 					$this->request->data['Department']['created_by'] = $this->Session->read('userid');
 					$this->Department->id = $this->request->data['Department']['dept_id'];
 					$this->Department->Save($this->request->data); 					 
 				 	$response['success'] = MSG_DEPT_UPDATED;
 				} 				 				
 			}
 			else 
 			{
 	 			$response['error'] = $this->Department->errMsg;
 			}
 			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;            
 	 	}
 		else 
 		{
 			if($dept_id!='')
 			{
 				$data = $this->Department->find('first', 
 					array(
 					"conditions"=> "created_by =". $this->Session->read('userid')." AND id= ".$dept_id,
 					"fields"=>"Department.id, Department.title"
 					)
 				);
 				$this->request->data = $data;
 				$this->set("data", $data);
 			}
	 		$this->set('dept_id',$dept_id);	
	 		$this->render("add_edit_department","ajax");
 		}
	}
	/**
	 * TO draw the outer lasyout for listing the teachers within a department
	 * Internally Call listTeachersAjax
	 * @param int $departmentId
	 */
	function listTeachers($departmentId=0)
	{ 
		
		//Check to redirect page for a non-admin and non-premium user  
		if($this->Session->read('user_type')!=1 && $this->Session->read('user_type')!=2 && $this->Session->read('user_type')!=7 )
		{
			if($this->referer()!=="")
			{
				$this->redirect($this->referer());
			}
			else
			{
				$this->redirect('/dashboard/');
			}
		}

		
		$this->Session->delete('departmentTeacherSearch');
		$this->set("departmentId",$departmentId);
	}
	/**
	 * TO list the teachers within a department
	 *
	 * @param int $departmentId
	 */
	function listTeachersAjax($departmentId=0)
	{
	 	$filters = "";
		
	 	/***************************Start Setting Search Parameters*********************/
	  
	 	//print " ";
	 	//print_R($this->request->data['departmentTeacherSearch']['firstname']);
	 	
	 	 
	     
	    //  echo $this->request->data['departmentTeacherSearch']['posted']; die;
	    
	  
	 	
		if(!empty($this->request->data) && isset($this->request->data['departmentTeacherSearch']['posted']))
     	{	// print "manj";
     		$search = $this->request->data; 
     		$searched = $search['departmentTeacherSearch'];
     	}
	    elseif($this->Session->check('departmentTeacherSearch'))
	    {
	        $search = $searched = $this->Session->read('departmentTeacherSearch');
	    }
	   
	    if(isset($searched) && count($searched)>0) 
	    {
	      	if(isset($searched['firstname']) && $searched['firstname']!='')
	        	 $filters.= " AND ( User.firstname like '%".add_Slashes(trim($searched['firstname']))."%' OR  User.lastname like '%".add_Slashes(trim($searched['firstname']))."%')";
	        
	        $this->Session->write($search);
	        $search = $this->Session->read('departmentTeacherSearch');
	    } 	
 	   /***************************End Setting Search Parameters*********************/  

	    
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";		

		//select only those who are active and are educators(user_type_id =2)
	 	$filters.=" AND User.status=1 AND User.user_type_id=2 AND User.id!=".$this->Session->read('userid');


		$admin_id = $this->getAdminId();
	
		$this->paginate = array('User'=>
   		array(
	   		"conditions"=>"User.admin_id = ".$admin_id."  ".$filters,
	   		"fields"=> "User.id,User.firstname, User.lastname, User.profilepic,User.status", 
	   		"order"=>"firstname",
	   		"limit"=>12
			)
   		);

   		$data = $this->paginate('User');
    	
   		$totalPages = isset($this->request->params['paging']['User']['pageCount'])?$this->request->params['paging']['User']['pageCount']:"";
 		
   		$order = isset($this->request->params['paging']['User']['options']['order'])?$this->request->params['paging']['User']['options']['order']:"";
  
   		$i = 0;	
   		$gotEducators = array();
   		foreach($data as $rec)	
   		{ 
   			
			if(is_file(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']))
			{ 
				$data[$i]['User']['profilepic'] = USER_IMAGES_PATH.'32X29/'.$rec['User']['profilepic'];
			}
			 else 
   			{ 
   				$data[$i]['User']['profilepic'] = IMAGES_PATH.USER32X29;
   			}
   			$gotEducators[] = $rec['User']['id'];
   			$i++;
   		}
   		$teacherSubjects = array();
   		if(count($gotEducators)>0)
		{
			//We will get subjects of the teachers
			$inGotTeachers = implode(",", $gotEducators);
			$this->SubjectEducator->unBindModel(array("belongsTo"=>array("User")));
			$teacherSubjectsArray = $this->SubjectEducator->find("all", array(
			"fields" => "Subject.title, Subject.id, SubjectEducator.user_id",
			"conditions" => "SubjectEducator.user_id IN (".$inGotTeachers.")",
			'joins'=>array(
							array(
							'type'=>'inner', 
							"table"=>"subjects", 
							"alias"=>"Subject",
							"conditions"=>"Subject.id = SubjectEducator.subject_id"
							)
						),
			"group" => "Subject.id",
			"order" => "SubjectEducator.user_id"
				)
			);
			foreach($teacherSubjectsArray as $rec)
			{
				$teacherSubjects[$rec['SubjectEducator']['user_id']]['subjects'][] = $rec;
			}
		}
	 	$this->set('teacherSubjects', $teacherSubjects);
 		$this->set('data', $data);
		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->render("list_teachers_ajax","ajax");
	}


	/**
	 * TO get the teachers in a department, it wil be used in the department page
	 *
	 * @param int $department_id
	 * @param string $view_type :  "student" OR "educator"
	 */
	function getDepartmentUser($departmentId, $viewType = "student", $subjectID = 0)
	{
		$IdArr = $this->Session->read('userid');
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7)
		{
			$IdArr = $this->Session->read('adminsIDStr');
		}
		if($viewType == "educator")
		{
			if($subjectID > 0)  // find all the educators that are assigned to a subject
			{
				$data = $this->SubjectEducator->find("all",
				array(
			   		"conditions"=>"SubjectEducator.subject_id = $subjectID  AND  SubjectEducator.user_id = User.id AND User.user_type_id = 2",
			   		"fields"=> "User.id,User.firstname, User.lastname, User.profilepic",
			   		"order"=>" User.firstname ASC"
			   		)
	   		);
			}
			else   // find all the educators in a department
			{
				$data = $this->DepartmentTeacher->find("all",
				array(
			   		"conditions"=>"DepartmentTeacher.department_id = ".$departmentId." AND User.user_type_id = 2",
			   		"fields"=> "DepartmentTeacher.leader, User.id,User.firstname, User.lastname, User.profilepic",
			   		"order"=>"DepartmentTeacher.leader DESC, firstname ASC"
			   		)
	   		);
			}
		}
		else 
		{
			$data = $this->DepartmentStudent->find("all",
				array(
			   		"conditions"=>"DepartmentStudent.department_id = ".$departmentId." AND User.user_type_id = 4",
			   		"fields"=> "User.id,User.firstname, User.lastname, User.profilepic",
			   		"order"=>"firstname"
			   		)
	   		);
		}
		$this->set("departmentId", $departmentId);
		$this->set("subjectID", $subjectID);
   		$this->set("viewType", $viewType);
   		$this->set("data", $data); 
   		$this->render("get_department_users","ajax");
	}

	function delUserFromDepartment()
	{		
		$departmentId = $this->request->params['form']['departmentId'];
		$userId = $this->request->params['form']['userId'];
		$viewType = $this->request->params['form']['viewType'];
		$subjectID = $this->request->params['form']['subjectID'];

		if($viewType == "educator")
		{
			if($subjectID > 0 )
			{
				$ret = $this->SubjectEducator->deleteEducatorFromSubject($userId,$subjectID);
			}
			else
			{
				$ret = $this->DepartmentTeacher->deleteAll(
				"DepartmentTeacher.department_id = ".$departmentId." AND user_id =".$userId			   		
	   			);	

				$ret = $this->SubjectEducator->deleteAll("SubjectEducator.user_id = $userId and SubjectEducator.department_id = $departmentId ");
			}
	 	}
		else 
		{
			$data = $this->DepartmentStudent->deleteAll("DepartmentStudent.department_id = ".$departmentId." AND user_id =".$userId  		);
	   			
		}
		$ret = true;
		if($ret == true)
   		{
   			echo "success_".MSG_REC_DELTED;
   		}
   		else 
   			echo "error_".MSG_REC_CANT_DELETE; 	
   		die;
	}

	/******************************list the subjects in a department STARTS **************************************/
	
	function getDepartmentSubject($departmentId=0)
	{
		$admin_id = $this->getAdminId();
		if($departmentId > 0)
	    {
			$data = $this->Subject->find("all",
				array(
			   		"conditions"=>"Subject.admin_id = $admin_id AND  Subject.department_id = ".$departmentId,
			   		"fields"=> "Subject.id, Subject.title ",
			   		"order"=>"Subject.title ASC"
			   		)
	   		);

		$this->set("data", $data);
		}

		$this->set("departmentId", $departmentId);
		$this->render("get_department_subjects","ajax");
		
	}

	/******************************list the subjects in a department ENDS **************************************/

	/******************************Add new subject in a department **************************************/
	function addEditSubject($departmentId=0, $subjectId="")
	{
		$admin_id = $this->getAdminId(); 
		if($this->request->data)
 		{
 			$result = $this->Subject->validateSubjectForm($this->request->data['Subject']);
 			$response = array();  
 	 		if($this->Subject->err==0)						
 			{
 				//we will add contact
 				if(!isset($this->request->data['Subject']['subject_id']) || $this->request->data['Subject']['subject_id']=='')	
 				{
 					$this->Subject->id = -1;
 					$this->request->data['Subject']['created_by'] = $this->Session->read('userid');
					$this->request->data['Subject']['admin_id'] = $admin_id;
					$this->request->data['Subject']['department_id'] = $this->request->data['Subject']['dept_id'];
					
 					$this->Subject->Save($this->request->data); 					 
 					$response['success'] = MSG_SUBJECT_CREATED;
 					
 				}
 				else 
 				{ 	$this->Subject->id = $this->request->data['Subject']['subject_id'];				
 					$this->request->data['Subject']['created_by'] = $this->Session->read('userid'); 					
					$this->request->data['Subject']['admin_id'] = $admin_id;
					$this->request->data['Subject']['department_id'] = $this->request->data['Subject']['dept_id'];

 					$this->Subject->Save($this->request->data); 					 
 				 	$response['success'] = MSG_SUBJECT_UPDATED;
 				} 				 				
 			}
 			else 
 			{
 	 			$response['error'] = $this->Subject->errMsg;
 			}
 			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;            
			exit;
 	 	}

		$this->set("subjectId", $subjectId);
		$this->set("departmentId", $departmentId);
		$this->render("add_edit_subject","ajax");
	}

	/******************************Delete suject from a department **************************************/

	function delSubjectFromDepartment()
	{
		$subjectId=  $this->request->params['form']['subjectId'];
	 	$ret = $this->Subject->delete($subjectId);
		echo MSG_SUBJECT_DELETED_SUCCESSFULLY;
		exit;
		
	}
	/**
	 * It will show a layout to select the users that can be added to a department
	 *
	 * @param unknown_type $viewType : student OR educator
	 * @param unknown_type $departmentId
	 */
	function assignUserToDepartment($viewType, $departmentId ,$subjectID=0)
	{ 
		if(isset($this->request->params['form']) && count($this->request->params['form'])>0)
		{
			$returnArr = array();
			if(count($this->request->params['form']['users'])>0)
			{
				//1 = refresh department listing
				//2 = refresh subject educators listing
				$returnArr['to'] = 1;
			//	pr($this->request->params['form']); exit;
				$gotUsers = array_unique($this->request->params['form']['users']); 				
				$dd['created_by'] = $this->Session->read('userid');
				$dd['department_id'] = $departmentId;
				$notIn = 0;
				if($viewType=="educator")
				{
					// insert the educator record for a particular subject
					if(isset($this->request->params['form']['subjctID']) && $this->request->params['form']['subjctID'] > 0)
					{
						$dd['subject_id'] = $this->request->params['form']['subjctID'];
						$dd['department_id'] = $this->request->params['form']['departmentId'];
						foreach($gotUsers as $key)
						{
							$dd['user_id'] = $key;					
							$this->SubjectEducator->id = -1;
							$this->SubjectEducator->Save($dd);
							$returnArr['success']  = MSG_EDUCATOR_ASSIGNED_TO_SUBJECT;		
							$returnArr['to'] = 2;
						}
					}
					else
					{
						$table = "department_teachers";
						foreach($gotUsers as $key)
						{
							$dd['user_id'] = $key;					
							$this->DepartmentTeacher->id = -1;
							$this->DepartmentTeacher->Save($dd);	
							$returnArr['success']  = MSG_USER_ASSIGNED_TO_GROUP;	
						}
					}
				}
				else
				{ 
					$table = "department_students";
					
					foreach($gotUsers as $key)
					{
						$dd['user_id'] = $key;					
						$this->DepartmentStudent->id = -1;						
						$this->DepartmentStudent->Save($dd);
						$returnArr['success']  = MSG_USER_ASSIGNED_TO_GROUP;						 	
					}	 
				}
							
			}
			else 
				$returnArr['error']  = USERS_CANT_ASSIGNED;
			echo json_encode($returnArr);
			die;
		}
		$this->set("departmentId",$departmentId);
		$this->set("subjectID",$subjectID);
		$this->set("viewType",$viewType);
	}
	
	function getUserToAssign($viewType, $departmentId, $subjectID=0)
	{ 
		
		$data = array();
  		$tag = $this->request->params['url']['tag'];	 
		if($viewType == "educator")
		{
			$table = "department_teachers";
			$typeId = 2;
		}
		else 
		{
			$table = "department_students";
			$typeId = 4;
		}
	
		//We will the users who are already added in the department
		$notIn = 0;
		 
		if($subjectID  > 0)
		{
			$rs = $this->SubjectEducator->getAddedUsers($subjectID); // find all the educators assigned to a subject			
		}
		else
		{ 
			$rs = $this->Department->getAddedUsers($departmentId, $table);
		}

		if(isset($rs[0][0]['addedusers']) && $rs[0][0]['addedusers']!='')
		{
			$notIn = $rs[0][0]['addedusers'];
		}
 	
		// dataGot = educators assigned to a department but not to a particular subject
		if($subjectID  > 0)
		{
		 	$conditions = "DepartmentTeacher.department_id= $departmentId AND DepartmentTeacher.user_id NOT IN ( $notIn ) AND User.status =1";
			$dataGot = $this->DepartmentTeacher->find("all", array("conditions"=>$conditions,
																		  "fields"=> "User.id, concat(User.firstname,' ',User.lastname) as name",
														
																	
															)); 
		}
		else
		{
		$admin_id = $this->getAdminId();
		$dataGot = $this->User->find("all",
			array(
		   		"conditions"=>"User.status = 1 and User.admin_id = $admin_id  AND User.id NOT IN (".$notIn.") AND (User.firstname like '".addslashes($tag)."%' OR User.lastname like '".addslashes($tag)."%') AND User.user_type_id = ".$typeId,
		   		"fields"=> "User.id, concat(User.firstname,' ',User.lastname) as name",			   	 			"order"	=> "name"
		   		)
   		);

		}
   		
   	 	if(count($dataGot)>0)
   	 	{
   	 		$i = 0;
   	 		foreach($dataGot as $rec)
   	 		{
   	 			$data[$i]['key'] = $rec[0]['name'];
   	 			$data[$i]['value'] = $rec['User']['id'];
   	 			$i++;
   	 		}
   	 	} 
		echo json_encode($data);
		die;
	}
	/**
	 * It will show a layout to select the users that can be added to a department
	 *
	 * @param unknown_type $viewType : student OR educator
	 * @param unknown_type $departmentId
	 */
	function viewEducatorsForDepartmetnLeaders($departmentId)
	{ 
		if(isset($this->request->params['form']) && count($this->request->params['form'])>0)
		{
			$returnArr = array();
			if((isset($this->request->params['form']['users']) && count($this->request->params['form']['users'])>0) || isset($this->request->params['form']['noLeader']))
			{
 				$this->DepartmentTeacher->updateAll(array('leader'=>0),array('department_id'=> $departmentId));
	 			//setting all other leaders to 0
	 			$returnArr['success']  = REPLACED_LEADER;		
				if(isset($this->request->params['form']['users']) && count($this->request->params['form']['users'])>0)
				{
					
					$this->DepartmentTeacher->updateAll(array('leader'=>1),
					array('department_id'=> $departmentId, 'user_id'=>$this->request->params['form']['users'][0]));			$returnArr['success']  = LEADER_ASSIGNED;		
					
				} 	
						
				echo json_encode($returnArr);							
				die;
			}
		}
		$this->set("departmentId",$departmentId);
	}
	function getEducatorsForDepartemtnLeaders($departmentId)
	{ 
		$data = array();
		if(!isNull($departmentId))
		{
			$conditions = "DepartmentTeacher.department_id= $departmentId AND User.status =1 AND leader= 0  AND User.user_type_id = 2";		
			$dataGot = $this->DepartmentTeacher->find("all", 
							array("conditions"=>$conditions,															    "fields"=> "User.id, concat(User.firstname,' ',User.lastname) as name"
							)); 
			if(count($dataGot)>0)
	   	 	{
	   	 		$i = 0;
	   	 		foreach($dataGot as $rec)
	   	 		{
	   	 			$data[$i]['key'] = $rec[0]['name'];
	   	 			$data[$i]['value'] = $rec['User']['id'];
	   	 			$i++;
	   	 		}
	   	 	} 
			echo json_encode($data);
 		}
		exit;
	}
	
/*******************************To add new educator or student ********************************/

	function addNewUser($stedu,$dept=0,$group_id=NULL)
	{
	 	global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();
		$this->set("timezones",$timezones);
		$this->set("defaultTimeZone",$defaultTimeZone);
		$this->set("group_id",$group_id);

		$this->set('st_or_edu',$stedu);
		if($stedu=="student")
		{
			$this->request->data['User']['user_type_id'] = 4;
			$this->set('heading',"Student");
		}
		if($stedu=="educator")
		{
			$this->request->data['User']['user_type_id'] = 2;
			$this->set('heading',"Educator");
		}

		if($stedu=="gaurdian")
		{
			$this->request->data['User']['user_type_id'] = 6;
			$this->set('heading',"Gaurdian");
		}

	 	$this->set('referer',$this->referer());
		$this->set('departmentId',$dept);
		
		$errmsg  = "";
		if(!empty($this->request->data['User']['username']))
		{
		//	$sitetitle = $this->request->data['User']['sitetitle'];
			$uname = $this->request->data['User']['username'];
			$uemail = $this->request->data['User']['email'];			
			$cnt_uname = 0;
			/*$cnt_sitetitle = $this->User->find('count',
												array('conditions'=> array('username'=>$sitetitle)				
												));
			*/
			$cnt_uname = $this->User->find('count',
												array('conditions'=> array('username'=>$uname)				
												));
			
			$cnt_email = $this->User->find('count',
												array('conditions'=> array('email'=>$uemail)				
												));

			/*if($cnt_sitetitle==1)
			{
				$errmsg.= ERR_SAME_SITETITLE_EXIST."<br>";
			}*/
			if($cnt_uname==1)
			{
				$errmsg.= ERR_SAME_USERNAME_EXIST."<br>";
			}
			if($cnt_email==1)
			{
				$errmsg.= ERR_SAME_EMAIL_EXIST."<br>";
			}

			if($errmsg!="")
			{
				echo "error#".$errmsg;
			}
			else
			{
				// set the admin_id value 
				$admin_id= $this->getAdminId();

				$this->request->data['User']['status'] = 1;
				$this->request->data['User']['created_by'] = $this->Session->read('userid');
				$this->request->data['User']['admin_id'] = $admin_id;
				$userdata['password']= $this->request->data['User']['password'];
				
				$this->request->data['User']['password'] = md5($this->request->data['User']['password']);
				$this->request->data['User']['lastlogin'] =date("Y-m-d H:i:s");
				$this->User->id = -1;
				$this->User->Save($this->request->data);

				$lastuserid = $this->User->getLastInsertId(); 

				//inserting into classgroup_students table 
				if($group_id!=0 && $group_id!="")
				{
					
					$this->classgroupStudent->id = -1;
					$stud_class_group['classgroupStudent']['group_id']= $group_id;
					$stud_class_group['classgroupStudent']['user_id']= $lastuserid;
					$stud_class_group['classgroupStudent']['added_by']= $this->Session->read('userid');
					$this->classgroupStudent->save($stud_class_group);
					$this->set("group_id",$group_id);
				}

				//inserting into department_teacher 
				if($dept!=0 && $dept!="")
				{
					if($stedu=="educator")
					{
						$this->DepartmentTeacher->id = -1;
						$deptarr['DepartmentTeacher']['department_id'] = $dept;
						$deptarr['DepartmentTeacher']['user_id'] = $lastuserid;
						$deptarr['DepartmentTeacher']['created_by'] = $this->Session->read('userid');
										
						$deptarr['DepartmentTeacher']['leader'] = $this->request->data['User']['leader'];

						//setting all other leaders to 0
						if($this->request->data['User']['leader']==1)
						{
							$this->DepartmentTeacher->updateAll(array('leader'=>0),array('department_id'=> $dept));
						}
					
						$this->DepartmentTeacher->save($deptarr);
					}
					if($stedu=="student")
					{
						$this->DepartmentStudent->id = -1;
						$this->DepartmentStudent->department_id = -1; 
						
						$stud_deptarr['DepartmentStudent']['user_id'] = $lastuserid;
						$stud_deptarr['DepartmentStudent']['created_by'] = $this->Session->read('userid');
						$stud_deptarr['DepartmentStudent']['department_id'] = $dept;
	
						$this->DepartmentStudent->save($stud_deptarr);
					}
				} 			
				$userdata['firstname']=$this->request->data['User']['firstname'];
				$userdata['lastname']=$this->request->data['User']['lastname'];
				$userdata['email']=$this->request->data['User']['email'];
				$userdata['username']=$this->request->data['User']['username'];	
				$userdata['user_type_id'] = $this->request->data['User']['user_type_id']	;		
				
				$this->emailAfterAddUser($userdata);				
				echo "success#".MSG_USER_ADDED_SUCCESSFULLY." ".MSG_EMAIL_SENT_TO_USER;
			}
			die;
		}
		$this->render("add_new_user","ajax");
    }//function end

	// private function to send email after adding user
	private function emailAfterAddUser($data)
	{
 
		$sUserFullName = $data['firstname']." ".$data['lastname'];
	    $this->Email->to =   $data['email'];				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	    
		$userType = $this->UserType->findById($data['user_type_id']);
        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>

		Your account has been created for ".SITE_NAME." successfully.<br/><br/>
		Here are your new login details:<br/>
		Username: ".$data['username']." <br/>
		Password: ".$data['password']." <br/>
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


	function editUserProfile($stedu,$id)
	{
		global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();
		$this->set("timezones",$timezones);
		$this->set("defaultTimeZone",$defaultTimeZone);
		echo $id;

		$this->set('st_or_edu',$stedu);
		if($stedu=="educator")
		{
			//$userdata = $this->User->findById($id);

			$userdata = $this->User->find('first', array(
										'conditions'=>array('User.id'=>$id),
										'fields'=>array('User.*','departmenTteacher.*'),
										'joins'=>array(array(
											'type'=>'inner', 
											"table"=>"department_teachers", 
											"alias"=>"departmenTteacher",
											"conditions"=>array("departmenTteacher.user_id = User.id")))
										)
										);

			$this->set("userdata", $userdata);
		}
	}
	/**
	 * Used to view all the comments received by cureent logged in user
	 *
	 */
	function viewComments()
	{
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
		$this->Session->delete('commentSearch');	 
		$filters = "";
		$joins ="";
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7)
		{
			$filters = "Project.admin_id= ".$this->Session->read('userid')." AND ";
		}
		else if($this->Session->read('user_type')==2 || $this->Session->read('user_type')==3)
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
		$filters .= "  (Project.published=1) " ;
		$prjList = $this->Project->find('list', array(
   		"conditions"=>$filters,
   		"fields"=> "Project.id, Project.title",
		"joins"=>$joins,
   		"order"=>"Project.title ASC",
		"group"=>"Project.id"
   		)
   		);   		 
		$this->set("prjList", $prjList );
		$this->layout = "default_front_inner"; 
	}
	function viewCommentsAjax()
	{				
		$limit = 5;//PAGE_LIMIT;
		$userid = $this->Session->read('userid');
		################## Start Setting Search Parameters ############################
		$filters = "";
		if(!empty($this->request->data))
     	{	
     		$search = $this->request->data; 
     		$searched = $search['commentSearch'];
     	}
	    elseif($this->Session->check('commentSearch'))
	        $search = $searched = $this->Session->read('commentSearch');
	
	    
	    if(isset($searched) && count($searched)>0) 
	    {
	      	if(isset($searched['project_id']) && $searched['project_id']!='')
	        	$filters.= " AND Project.id = ".$searched['project_id'];
	        
	        $this->Session->write($search);
	        $search = $this->Session->read('commentSearch');	 
	        $this->projComments->filters  = $filters;
	    } 	
 	    ################## END Setting Search Parameters ############################    
	    
		$this->projComments->userId = $userid;
		$this->projComments->userType = $this->Session->read('user_type');
		$this->paginate = array('projComments'=> array(
		"conditions"=>"findUnion",
		"limit"=>$limit
		)
		);
		
		$dataGot = $this->paginate('projComments');		
 		$totalPages = isset($this->request->params['paging']['projComments']['pageCount'])?$this->request->params['paging']['projComments']['pageCount']:"";		
   		$order = isset($this->request->params['paging']['projComments']['options']['order'])?$this->request->params['paging']['projComments']['options']['order']:"";
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:1;
	 	$this->set('page', $page);
   		$this->set('limit', $limit);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		//$query = $this->makeQueryComments();	 
	  	$this->set("data", $dataGot);		
		$this->render("view_comments_ajax","ajax");
	}
}