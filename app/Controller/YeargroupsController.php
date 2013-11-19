<?php
App::uses('Sanitize', 'Utility');
class YeargroupsController  extends AppController{

	var $name = 'Yeargroups';


	var $uses = array('classGroup','UserType','coadminGaurdian', 'classgroupStudent','User','DepartmentTeacher','State','Invite');

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
	/*var $paginate = array(
        'limit' => PAGE_LIMIT,
        'order' => array(
            'Department.id' => 'desc'
        )
    );*/
    function beforeRender()
    {
    	parent::beforeRender();
    	
    }
	function beforeFilter()
	{
	
		if(!strstr($_SERVER['REQUEST_URI'],"verifyme")){
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
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
 	 * This funcation wil be used to view all the outer layout of the year groups
 	 * 
 	 * Groups table with the parent_id = 0
 	 */
	function viewgroups($group_id=0){ 
	

	Controller::disableCache();
		$this->Session->delete('classGroupSearch');	
	//	$loggedinusertype = $this->Session->read('user_type');
	//	if($loggedinusertype==1){
		if($this->Session->read('user_type')==1  || $this->Session->read('user_type')==3 || $this->Session->read('user_type')==7){
			$this->set("showbox",'Y');
		}
		else{
			$find_ldr = $this->DepartmentTeacher->find('first',								array('conditions'=>array('DepartmentTeacher.user_id'=>$this->Session->read('userid')),
										'fields' =>array('leader')		
			));

			
			if($find_ldr){
			$ldr = $find_ldr['DepartmentTeacher']['leader'];
			if($ldr==1){
				$this->set("showbox",'Y');
			}
			else
				$this->set("showbox",'N');
			}
			else
				$this->set("showbox",'N');
			
		}
 		$this->set("group_id",$group_id);
	}
	/**
	 * This function will be used to get the listing for both the year groups and class groups
	 *
	 * @param unknown_type $classgroupid : class group id OR year group id
	 */
	function listYearGroupsAjax($groupId=0)
	{
	
		$filters = "classGroup.admin_id = ".$this->getAdminId();

		//if user is a educator then we will show his/her admin created groups
		################## Start Setting Search Parameters ############################
		if(!empty($this->request->data) && isset($this->request->data['classGroupSearch']['posted']))
     	{	
     		$search = $this->request->data; 
     		$searched = $search['classGroupSearch'];
     	}
	    elseif($this->Session->check('classGroupSearch'))
	        $search = $searched = $this->Session->read('classGroupSearch');
	
	    
	    if(isset($searched) && count($searched)>0) 
	    {
	      	if(isset($searched['keyword']) && $searched['keyword']!='')
	        	$filters.= " AND classGroup.title like '%".add_Slashes(trim($searched['keyword']))."%'";
	        
	        $this->Session->write($search);
	        $search = $this->Session->read('classGroupSearch');
	        $this->set('searched', $searched);
	    } 	
 	    ################## END Setting Search Parameters ############################   
 	     
		$fields = "classGroup.title,"; 
		
		if(isNull($groupId))
		{
			//It means we are on the homepage and get all the yeargrops
			$filters.=" AND group_type='year' AND parent_id=0 ";
			$fields.="(SELECT COUNT(id) from class_groups WHERE parent_id = classGroup.id GROUP BY classGroup.id) as cnt";
			$viewType = "year";
		}
		else 
		{
			//Get all the class groups
			$filters.=" AND group_type='class' AND parent_id=".$groupId;
			
			 
				
			$fields.="(SELECT COUNT(classgroup_students.id) from classgroup_students 
			INNER JOIN users User ON User.id = classgroup_students.user_id
			WHERE group_id = classGroup.id and User.status!=3	GROUP BY classGroup.id) as cnt";
			$viewType = "class";
		}
		
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";

		$this->paginate = array('classGroup'=>
		array('conditions'=> $filters,
			   "fields"=> "UserC.firstname, UserC.lastname, UserC.id, classGroup.admin_id, classGroup.created_by, classGroup.id, classGroup.title, ".$fields,
			   "order"=>"classGroup.title",
			   'joins'=>array(array(
									'type'=>'inner', 
									"table"=>"users", 
									"alias"=>"UserC",
									"conditions"=>array("UserC.id = classGroup.created_by")
									)
							),						
	   		   "limit"=>12
			)	
		);

		$data = $this->paginate('classGroup');
		$totalPages = isset($this->request->params['paging']['classGroup']['pageCount'])?$this->request->params['paging']['classGroup']['pageCount']:"";
 		$order = isset($this->request->params['paging']['classGroup']['options']['order'])?$this->request->params['paging']['classGroup']['options']['order']:"";

 		$this->set('data', $data); 
 		
		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->set('viewType', $viewType);
		$this->set('group_id', $groupId);
		$this->render("list_year_groups_ajax","ajax"); 

	}
	/**
	 * 24th August 2011
	 * Added new search functionality according to the passed filters
	 * 
	 */
 	function filteredSearch()
 	{
 		$renderView = "";
 		$filters = "";
 		$classgp = array();
		//if user is a educator then we will show his/her admin created groups
		################## Start Setting Search Parameters ############################
		if(!empty($this->request->data) && isset($this->request->data['classGroupSearch']['posted']))
     	{	
     		$search = $this->request->data; 
     		$searched = $search['classGroupSearch'];
     	}
	    elseif($this->Session->check('classGroupSearchNew'))
	        $search = $searched = $this->Session->read('classGroupSearchNew');
	      
	        
	       
	    if(isset($searched) && count($searched)>0) 
	    {	 
	    	if($searched['searchType'] == "yeargroup" || $searched['searchType'] == "classgroup")
	    	{
	    		$fields = "classGroup.title, "; 
	    		$filters = "classGroup.admin_id = ".$this->getAdminId();
				$filters.= " AND classGroup.title like '%".add_Slashes(trim($searched['keyword']))."%'";	
	    		if($searched['searchType'] == "yeargroup")
	    		{
	    			//It means we are on the homepage and get all the yeargrops
					$filters.=" AND group_type='year' AND parent_id=0 ";
					$fields.="(SELECT COUNT(id) from class_groups WHERE parent_id = classGroup.id GROUP BY classGroup.id) as cnt";
					$viewType = "year";
	    		}
	    		elseif ($searched['searchType'] == "classgroup")
	    		{
	    			//Get all the class groups
					$filters.=" AND group_type='class'";
			 		$fields.= "(SELECT COUNT(classgroup_students.id) from classgroup_students 
					INNER JOIN users User ON User.id = classgroup_students.user_id
					WHERE group_id = classGroup.id and User.status!=3	GROUP BY classGroup.id) as cnt";
					$viewType = "class";
	    		}
	    		$this->paginate = array('classGroup'=>
				array('conditions'=> $filters,
					   "fields"=> "UserC.firstname, UserC.lastname, UserC.id, classGroup.admin_id, classGroup.created_by, classGroup.id, classGroup.title, ".$fields,
					   "order"=>"classGroup.title",
					   'joins'=>array(array(
											'type'=>'inner', 
											"table"=>"users", 
											"alias"=>"UserC",
											"conditions"=>array("UserC.id = classGroup.created_by")
											)
									),	
														
			   		   "limit"=>12
					)	
				);
		 		$data = $this->paginate('classGroup');
	 			$totalPages = isset($this->request->params['paging']['classGroup']['pageCount'])?$this->request->params['paging']['classGroup']['pageCount']:"";
		 		$order = isset($this->request->params['paging']['classGroup']['options']['order'])?$this->request->params['paging']['classGroup']['options']['order']:"";
		 		$renderView = "list_year_groups_ajax";
	    	}
	        else 
    		{
    			//Students
    			$filters = "User.admin_id = ".$this->getAdminId();
    			$filters.= " AND ( User.firstname like '%".add_Slashes(trim($searched['keyword']))."%' OR  User.lastname like '%".add_Slashes(trim($searched['keyword']))."%')";
    			$this->paginate = array('classgroupStudent'=>
				array('conditions'=>$filters,
						'joins'=>array(		
										array(
										'type'=>'left', 
										"table"=>"coadmin_gaurdians", 
										"alias"=>"coadminGaurdians",
										"conditions"=>array("coadminGaurdians.user_id = classgroupStudent.user_id")
												),
										array(
										'type'=>'left', 
										"table"=>"users", 
										"alias"=>"userGaurdian",
										"conditions"=>array("userGaurdian.id = coadminGaurdians.parent_id","userGaurdian.status=1")					)
			
										),
					  "fields"=> "User.id,classgroupStudent.added_by, User.firstname, User.lastname, User.profilepic,User.status, userGaurdian.id AS GID, userGaurdian.firstname AS Gfirstname, userGaurdian.lastname AS Glastname",
					   "order"=>"User.firstname",
					   "group" => "User.id",
			   		   "limit"=>6
					)	
				);
		 		$data = $this->paginate('classgroupStudent'); 
		 		//To find the groups that a user belongs to
				$gotUsers = array();
				$groupsArray = array();
			 	foreach($data as $rec)	
		   		{ 
		   			$gotUsers[] = $rec['User']['id'];
		   		}
		   		if(count($gotUsers) > 0)
		   		{
					$groups = $this->classgroupStudent->find("all", array(
				 	"conditions"=>"classgroupStudent.user_id IN (".implode(",", $gotUsers).")",
				 	"fields"=>"DISTINCT classgroupStudent.group_id, classGroup.title, classGroup.id, classgroupStudent.user_id, classGroupParent.id, classGroupParent.title",
				 	"joins" => array(
						array(
								"type"=>"inner",
								"table"=>"class_groups",
								"alias"=>"classGroup",
								"conditions"=>"classGroup.id = classgroupStudent.group_id"  
							),
							
						array(
								"type"=>"left",
								"table"=>"class_groups",
								"alias"=>"classGroupParent",
								"conditions"=>"classGroupParent.id = classGroup.parent_id"  
							)
						)
				 	));
				 	foreach ($groups as $rec)
				 	{
				 		$groupsArray[$rec['classgroupStudent']['user_id']][] = $rec;
				 	}
			 
		   		} 
		  
		   		$totalPages = isset($this->request->params['paging']['classgroupStudent']['pageCount'])?$this->request->params['paging']['classgroupStudent']['pageCount']:"";
		 		
		   		$order = isset($this->request->params['paging']['classgroupStudent']['options']['order'])?$this->request->params['paging']['classgroupStudent']['options']['order']:"";
		
		
				$i = 0;	
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
		   			$data[$i]['groups'] = isset($groupsArray[$rec['User']['id']])?$groupsArray[$rec['User']['id']]:array();
		   			$i++;
		   		} 
		   		$viewType = "student";
		   		$renderView = "list_students_ajax";
		      		
    		}  
    		if(isset($search['classGroupSearch']))
    		{
	    		$tmpArray['classGroupSearchNew'] = $search['classGroupSearch'];
	    	    $this->Session->write($tmpArray);
    		}
	        $search = $this->Session->read('classGroupSearchNew');
	        $this->set('searched', $searched);
	    } 	
 	    ################## END Setting Search Parameters ############################   
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";
   		$this->set('group_id', 0); 
   		$this->set('classgroupid', 0); 
    	$this->set('data', $data); 
 		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->set('viewType', $viewType);
		$this->set('searchedNewMode', 1);
		$this->set('classgp', $classgp);
		$this->render($renderView, "ajax");
		
 	}
 	/**
 	 * This funcation wil be used to call the request action of add year group
 	 * 
 	 * Groups table with the parent_id = 0
 	 */
 	function addyeargroup($group_id=0)
 	{ 	Controller::disableCache();
 		// show create a class or year group link only to admin ,coadmin , individual educator or educators who are department leader 	
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 || $this->Session->read('user_type')==3)
		{ 
			$this->set("show_yrgroup_link",'Y'); 
		}
		else
		{
			$leader = $this->DepartmentTeacher->find('first',
											array(
											"conditions"=>array("user_id"=>$this->Session->read('userid')),
											"fields"=>'leader'
												));

			if($leader['DepartmentTeacher']['leader']==1)
			{	$this->set("show_yrgroup_link",'Y'); }
			else
			{	$this->set("show_yrgroup_link",'N'); }
		} 
 		

		$admin_id= $this->getAdminId();
 		
		// saving the data
		if(isset($this->request->data['classGroup']) && count($this->request->data['classGroup'])>0)
		{
			$msgArray = array();
			$this->request->data['classGroup']['created_by'] = $this->Session->read('userid');
			//if user is a educator then we will get his admin id
			//setting fields and their value
 
			 
			$this->request->data['classGroup']['admin_id'] = $admin_id;
			$isErr = $this->classGroup->validateGroup($this->request->data['classGroup']);			
			if($isErr==0)						
			{
 				//User has successfully completed the sign up step1 process
				// we will add the class group
				$add = $this->classGroup->saveData($this->request->data['classGroup']);
	 			if($add == 0)
				{
					
					$msgArray['success'] = $this->classGroup->errMsg;
					$msgArray['id'] = $this->classGroup->groupId;
				}
				else 
				{
					$msgArray['error'] = $this->classGroup->errMsg;
				}
 			}
 			else 
 			{
 				
 				$msgArray['error'] = $this->classGroup->errMsg;
 			}
 			//it wud be a ajax call
 			echo json_encode($msgArray);
 			die;
		}
  
		// $filters = "( classGroup.created_by IN (" .$createdby .")  OR classGroup.admin_id = $admin_id ) AND classGroup.group_type='year' "; 

//this might be the final query ...since record need to be found by admin_id and yr gp
		$filters = " classGroup.admin_id = $admin_id  AND classGroup.group_type='year'";
		
 		 $parentGroups = $this->classGroup->find('list', array(
	 		 "conditions"=>$filters,
	 		 "fields"=>"classGroup.id, classGroup.title"
 		 )); 
 		 $this->set("group_id", $group_id); 
 		 $this->set("parentGroups", $parentGroups);
  		 $this->render("addyeargroup", "ajax");

	
		
 	}
 	/**
 	 * This function is used to get the json data for drop down of "otherGroups" 
 	 * in addYearGroup Page
 	 */
 	function getOtherGroups()
 	{
 		$this->loadModel('classGroup');
 		$data = array();
 		$tag = $this->request->params['url']['tag'];
		
		$admin_id= $this->getAdminId();

 		$createdby = $this->Session->read('userid');
		$filters = " classGroup.admin_id = $admin_id  AND classGroup.group_type='year'";
 		$dataGot = $this->classGroup->find('all', array(
	 		 "conditions"=>$filters." and classGroup.title like '".add_Slashes($tag)."%'",
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
 	 * This function is used to get the json data for drop down of "Students" 
 	 * in addYearGroup Page 
 	 */
	function getStudentToAdd()
 	{
 		$data = array();
 		$userId = $this->Session->read('userid');
 		$tag = $this->request->params['url']['tag']; 		
		$admin_id= $this->getAdminId();		
		$filters ="User.admin_id = ".$admin_id;
 		$dataGot = $this->User->find('all', array(
	 		 "conditions"=>"user_type_id = 4 and status = 1 and 
	 		 (User.firstname like '".add_Slashes($tag)."%' OR User.lastname like '".add_Slashes($tag)."%') and $filters",
	 		 "fields"=>"User.id, concat(User.firstname,' ',User.lastname) as uname"
 		 ));
		 
 		$i = 0;
 	 	if(count($dataGot)>0)
		{
			$i = 0;
			foreach($dataGot as $rec)
			{
				$data[$i]['key'] = $rec[0]['uname'];
				$data[$i]['value'] = $rec['User']['id'];
				$i++;
			}
		} 
		echo json_encode($data);
		die;
 	}
	function deletegroup($group_id)
	{	
		if($this->request->data && $this->request->data['classGroup']['group_ids']!='')
		{
			$grpDetail = $this->classGroup->findById($this->request->data['classGroup']['group_ids']);
			$response = array();  
			$cond = "classGroup.id = ".$grpDetail['classGroup']['id'];
			if($grpDetail['classGroup']['parent_id']==0)
			{
				///if it is a yeargroup
				$cond.=" OR classGroup.parent_id = ".$grpDetail['classGroup']['id'];
				//Styudents deletion wil be done by on delete cascades
			}
			$ret = $this->classGroup->deleteAll($cond);
			if($ret == true)
			{
				$response['success'] = MSG_REC_DELTED;
			}
			else 
			{
				$response['error'] = MSG_REC_CANT_DELETE;
			}
			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;   
 			die;			 
		}
		$grpDetail = $this->classGroup->findById($group_id);
  		if(isset($grpDetail['classGroup']['id']))
		{
			$this->set("data", $grpDetail);
			//
		}
		$this->set("referer",$this->referer());
		$this->set("group_id",$group_id);
		$this->render("deletegroup", "ajax");		
	}
/**************************Listing Students By Class Groups STARTS ***************************/	
	function classGroups($id=NULL)
	{
		if(!isset($id))
			$this->redirect("/dashboard");

		$this->Session->delete('classGroupSearchC');	
		//set conditions to hide and show upper box 
		// show upper box only to admin, coadmin, individual educator  or a premium educator  who is a department leader 
		$loggedinusertype = $this->Session->read('user_type');
		if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==3 || $this->Session->read('user_type')==7){
			$this->set("showbox",'Y');
		}
		else{
			$find_ldr = $this->DepartmentTeacher->find('first',								array('conditions'=>array('DepartmentTeacher.user_id'=>$this->Session->read('userid')),
										'fields' =>array('leader')		
			));

			$ldr = $find_ldr['DepartmentTeacher']['leader'];
			if($ldr==1){
				$this->set("showbox",'Y');
			}
			else
				$this->set("showbox",'N');
		}

		
		$classgp = $this->classGroup->find('first',
											array('conditions'=>array('classGroup.id'=>$id),
													
												   'fields'=>'classGroup.title,classGroup.group_type'
													)
									);


		// show add another user link only to this classgroup page	
		if($classgp['classGroup']['group_type']=="class")
		{
			$this->set("showadduser",'Y');
		}
		else
			$this->set("showadduser",'N');
		
		$this->set("classgpname",$classgp['classGroup']['title']);

		$this->set("classgroupid",$id);
	

	}
	
	function listStudentsAjax($classgroupid)
	{
		$this->set("classgroupid",$classgroupid);	
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";

		$filters ="AND User.status=1 ";
		################## Start Setting Search Parameters ############################
		if(!empty($this->request->data) && isset($this->request->data['classGroupSearch']['posted']))
     	{	
     		$search = $this->request->data; 
     		$searched = $search['classGroupSearch'];
     	}
	    elseif($this->Session->check('classGroupSearchC'))
	        $search = $searched = $this->Session->read('classGroupSearchC');
	
	    
	    if(isset($searched) && count($searched)>0) 
	    {
	      	if(isset($searched['keyword']) && $searched['keyword']!='')
	        	$filters.= " AND ( User.firstname like '%".add_Slashes(trim($searched['keyword']))."%' OR  User.lastname like '%".add_Slashes(trim($searched['keyword']))."%')";
	        
	        $this->Session->write($search);
	        $search = $this->Session->read('classGroupSearchC');
	        $this->set('searched', $searched);
	    } 	
 	    ################## END Setting Search Parameters ############################   


		$this->paginate = array('classgroupStudent'=>
		array('conditions'=>'classgroupStudent.group_id='.$classgroupid.' '.$filters,
				'joins'=>array(		
								array(
								'type'=>'left', 
								"table"=>"coadmin_gaurdians", 
								"alias"=>"coadminGaurdians",
								"conditions"=>array("coadminGaurdians.user_id = classgroupStudent.user_id")
										),
								array(
								'type'=>'left', 
								"table"=>"users", 
								"alias"=>"userGaurdian",
								"conditions"=>array("userGaurdian.id = coadminGaurdians.parent_id","userGaurdian.status=1")					)
				),
			  "fields"=> "classgroupStudent.added_by, User.id,User.firstname, User.lastname, User.profilepic,User.status, userGaurdian.id AS GID, userGaurdian.firstname AS Gfirstname, userGaurdian.lastname AS Glastname",
			   "order"=>"User.firstname",
	   		   "limit"=>6
			)	
		);

	/*		$data = array($this->classgroupStudent->query("SELECT userGaurdian.id AS GID, userGaurdian.firstname AS Gfirstname, userGaurdian.lastname AS Glastname, classgroupStudent.added_by , User.id , User.firstname , User.lastname , User.profilepic , User.status  			
			FROM classgroup_students AS classgroupStudent LEFT JOIN users AS User ON ( classgroupStudent.user_id = User.id)
			LEFT JOIN coadmin_gaurdians AS coadminGaurdians ON ( coadminGaurdians.user_id = User.id)
			LEFT JOIN users AS userGaurdian ON ( userGaurdian.id = coadminGaurdians.parent_id )
			WHERE classgroupStudent.group_id =5
			$filters
			ORDER BY User.firstname ASC
			LIMIT 15"); */
		

		$data = $this->paginate('classgroupStudent'); 
   		$totalPages = isset($this->request->params['paging']['classgroupStudent']['pageCount'])?$this->request->params['paging']['classgroupStudent']['pageCount']:"";
 		
   		$order = isset($this->request->params['paging']['classgroupStudent']['options']['order'])?$this->request->params['paging']['classgroupStudent']['options']['order']:"";

		
		$i = 0;	
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
   			$i++;
   		}  
		$classgp = $this->classGroup->findById($classgroupid);

		// find all the educators id or coadmin id created by logged in admin....it is used to show delete link to admin
		
		$this->set('educatorsId', "");
		if($this->Session->read('user_type')==1)
		{
			$cond = "admin_id = ".$this->Session->read('userid')." AND( user_type_id= 2  OR user_type_id = 7 )";
			$educatorsId = $this->User->find("all" ,array("conditions"=>$cond, 
			"fields"=>"User.id"
			));
			$this->set('educatorsId', $educatorsId);
		}

		// find all the educators id created by logged in coadmin ....it is used to show delete link to coadmin
		if($this->Session->read('user_type')==7)
		{
			
			$createdbyArr = $this->User->findById($this->Session->read('userid'),"created_by");		
			
			$educatorsId = $this->User->find("all" ,array("conditions"=>array("User.admin_id"=>$createdbyArr['User']['created_by'], "user_type_id"=>2), 
			"fields"=>"User.id"
			));
			$this->set('educatorsId', $educatorsId);
		}


 		$this->set('data', $data);
 		$this->set('classgp', $classgp);
		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages); 
		$this->set('classgroupid', $classgroupid);
		
		$this->render("list_students_ajax","ajax");
	}
/**************************Listing Students By Class Groups ENDS ***************************/


/**************************Listing Year Groups STARTS ***************************/

	/*function listYearGroupsAjax($groupId=0)
	{
		$filters = "classGroup.created_by = ".$this->Session->read('userid');
		$fields = "classGroup.title,";
		if(isNull($groupId))
		{
			//It means we are on the homepage and get all the yeargrops
			$filters.=" AND group_type='year' AND parent_id=0 ";
			$fields.="(SELECT COUNT(id) from class_groups WHERE parent_id = classGroup.id GROUP BY classGroup.id) as cnt";
			$viewType = "year";
		}
		else 
		{
			//Get all the class groups
			$filters.=" AND group_type='class' AND parent_id=".$groupId;
			$fields.="(SELECT COUNT(id) from classgroup_students WHERE group_id = classGroup.id GROUP BY classGroup.id) as cnt";
			$viewType = "class";
		}
		
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";
 
		$this->paginate = array('classGroup'=>
		array('conditions'=> $filters,
			   "fields"=> "classGroup.id, classGroup.title, ".$fields,
			   "order"=>"classGroup.title",
	   		   "limit"=>10
			)	
		);

		$data = $this->paginate('classGroup');
   		$totalPages = isset($this->request->params['paging']['classGroup']['pageCount'])?$this->request->params['paging']['classGroup']['pageCount']:"";
 		
   		$order = isset($this->request->params['paging']['classGroup']['options']['order'])?$this->request->params['paging']['classGroup']['options']['order']:"";

 		 
 		$this->set('data', $data);
		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->set('viewType', $viewType);
		$this->set('groupId', $groupId);
		$this->render("list_year_groups_ajax","ajax"); 

	}*/

/**************************Listing Year Groups End ***************************/

/**************************Breadcrumb STARTS ***************************/

	function breadCrumb($id=NULL)
	{
		$filters ="";
		$loggedinuserid = $this->Session->read('userid');

		// set default fields for breadcrumb
		$this->set("showyear",'N');
		$this->set("showclass",'N');

		//set default value for ctp files
		$this->set("yrgpname","");
		$this->set("classgrpcount","");
		$this->set("studentclassgpname","");
		$this->set("studentclassgrpcount","");
		$this->set("yrgpid","");

		$admin_id = $this->getAdminId();
		$filters = "( parent_id = 0 and   classGroup.admin_id = $admin_id )";
	  	$filters.= " AND classGroup.group_type = 'year'";
//count year group 
		$countyrgp = $this->classGroup->find('count',
								array('conditions'=>array(
								$filters
								)
														)
								);
								
		$this->set("yeargp_count",$countyrgp);
		
		if(!empty($id) && $id > 0)
		{
			$check_gptype = $this->classGroup->find('first',array('conditions'=>array('id'=>$id),
																		'fields'=>array('group_type')
																	));				

			if($check_gptype['classGroup']['group_type']=='year') // yearlisting 
			{

				$yeargp = $this->classGroup->query("
				SELECT classGroup.title, count(classgp.id) as countcgp 
				FROM class_groups as classGroup 
				LEFT JOIN class_groups as classgp ON classgp.parent_id =classGroup.id
				where  classGroup.id =$id 
				group by classGroup.id" );

				$this->set("showyear",'Y');
				$this->set("yrgpname",$yeargp[0]['classGroup']['title']);
				$this->set("classgrpcount",$yeargp[0][0]['countcgp']);
				$this->set("yrgpid",$id);

			}

			if($check_gptype['classGroup']['group_type']=='class') // classlisting 
			{
	
				$studentyeargp = $this->classGroup->query("SELECT classGroup.title, classGroup.parent_id, (SELECT count(student.id)		
				FROM classgroup_students student
				INNER JOIN users User ON User.id = student.user_id
				WHERE student.group_id = classGroup.id and User.status!=3				  
				) as countstudent 
				FROM class_groups as classGroup 
			 	where classGroup.id =$id group by classGroup.id " );

				if(!empty($studentyeargp))
				{
					$yrid = $studentyeargp[0]['classGroup']['parent_id'];
					$this->set("studentclassgpname",$studentyeargp[0]['classGroup']['title']);
					$this->set("studentclassgrpcount",$studentyeargp[0][0]['countstudent']);
					$this->set("yrgpid",$studentyeargp[0]['classGroup']['parent_id']);
				}
				$yeargp = $this->classGroup->query("SELECT classGroup.title,count(classgp.id) as countcgp FROM class_groups as classGroup ,class_groups as classgp where classgp.parent_id =classGroup.id AND classGroup.id =$yrid group by classGroup.id" );

				if(!empty($yeargp))
				{
					$this->set("yrgpname",$yeargp[0]['classGroup']['title']);
					$this->set("classgrpcount",$yeargp[0][0]['countcgp']);
				}
	 			$this->set("showyear",'Y');
				$this->set("showclass",'Y');
			}

		}//notempty if end

	$this->render("bread_crumb", "ajax");

	}


/**************************Breadcrumb ENDS ***************************/

/***************student deleted from the group only(not deleting the user record) ***************/
	function deleteStudentAccount($uid,$groupid)
	{
		if(!empty($uid))
		{			
			$this->classgroupStudent->query("DELETE from classgroup_students where group_id=$groupid AND user_id= $uid ");
			echo MSG_USER_DELETED_FROM_GROUP;
			//$this->Session->setFlash(MSG_REC_DELTED);		
			die;
		}
	}

/**************************Assign Student to a group STARTS***************************/
	function assignUserToGroup($groupid)
	{
		
		if(isset($this->request->params['form']) && count($this->request->params['form'])>0)
		{
			$returnArr = array();
			if(count($this->request->params['form']['users'])>0)
			{
				$gotUsers = array_unique($this->request->params['form']['users']);
				
				$dd['group_id'] = $groupid;
				$dd['added_by'] = $this->Session->read('userid');
				foreach($gotUsers as $key)
				{
					$dd['user_id'] = $key;					
					$this->classgroupStudent->id = -1;
					$this->classgroupStudent->Save($dd);
				}
				$returnArr['success']  = MSG_USER_ASSIGNED_TO_GROUP;
			}
			else 
				$returnArr['error']  = USERS_CANT_ASSIGNED;
			echo json_encode($returnArr);
			die;
		}
		$this->set("groupid",$groupid);
	}
/**************************Assign Student to a group ENDS***************************/


/*********************Get the Students to assign into a group STARTS****************/

	function getUserToAssignInGroup($groupid)
	{
		$this->set("groupid",$groupid);

		$data = array();
  		$tag = $this->request->params['url']['tag'];		
		$typeId = 4;

		//We will not the users who are already added in the group
		$notIn = 0;

		$rs = $this->classgroupStudent->getAddedUsers($groupid);

		if(isset($rs[0][0]['addedusers']) && $rs[0][0]['addedusers']!='')
		{
			$notIn = $rs[0][0]['addedusers'];
		}
 		$dataGot = $this->User->find("all",
			array(
		   		"conditions"=>"User.status = 1 and User.admin_id = ".$this->getAdminId()." AND User.id NOT IN (".$notIn.") AND (User.firstname like '".addslashes($tag)."%' OR User.lastname like '".addslashes($tag)."%') AND User.user_type_id = ".$typeId,
		   		"fields"=> "User.id, concat(User.firstname,' ',User.lastname) as name",			   	 			"order"	=> "name"
		   		)
   		);

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

/*********************Get the Students to assign into a group ENDS****************/

/*********************Add New User(gaurdian) STARTS****************/

	function newUser($userID=0)
	{
		//echo $userID;  pr($this->request->data); exit;
		$this->set("studentID", $userID);
		$errmsg="";
		if(!empty($this->request->data))
		{
			//$sitetitle = $this->request->data['User']['sitetitle'];
			$uname = $this->request->data['User']['username'];
			$uemail = $this->request->data['User']['email'];			
			$cnt_uname = $this->User->find('count',
												array('conditions'=> array('username'=>$uname)				
												));
			
			$cnt_email = $this->User->find('count',
												array('conditions'=> array('email'=>$uemail)				
												));

		/*	if($cnt_sitetitle==1)
			{
				$errmsg.= ERR_SAME_SITETITLE_EXIST."<br>";
			} */
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
				echo "error##".$errmsg; exit;
			}
			else
			{
				$userdata['password']= $this->request->data['User']['password'];
				//setting the fields
				$this->request->data['User']['status'] = 1;
				$this->request->data['User']['created_by'] = $this->Session->read('userid');
				$this->request->data['User']['user_type_id'] = 6;
				$this->request->data['User']['password'] = md5($this->request->data['User']['password']);
	
				$admin_id = $this->getAdminId();
				$this->request->data['User']['admin_id'] = $admin_id;
					//we will get student detail
				$child = $this->User->findById($this->request->data['User']['studentid'], "firstname, lastname, id");
				 
				$this->User->id = -1;
				$this->User->Save($this->request->data);

				$lastuserid = $this->User->getLastInsertId(); 

				$gaurdianData['user_id'] = $this->request->data['User']['studentid'];   //studentID
				$gaurdianData['parent_id'] = $lastuserid;   //parentID
				$gaurdianData['type'] = 1;   //type  =gaurdian

				$this->coadminGaurdian->id = -1;
				$this->coadminGaurdian->Save($gaurdianData);

				$userdata['firstname']=$this->request->data['User']['firstname'];
				$userdata['lastname']=$this->request->data['User']['lastname'];
				$userdata['email']=$this->request->data['User']['email'];
				$userdata['username']=$this->request->data['User']['username'];
				$userdata['user_type_id']=$this->request->data['User']['user_type_id'];
				
			
				$this->emailAfterAddUser($userdata, $child);
				

				$stdntId = $this->request->data['User']['studentid'];

				$href= SITE_HTTP_URL."users/viewProfile/".$lastuserid; // link to view gaurdian profile

				$confirmdel= "confirmdel($lastuserid,'G',$stdntId)";

				$link = "<a href='$href'>".ucfirst($this->request->data['User']['firstname']." ".$this->request->data['User']['lastname'])."</a>&nbsp;&nbsp;&nbsp;&nbsp; <a class='edit deleteGroup' style='cursor:pointer;' onclick=$confirmdel;>Delete Guardian</a>";

				echo "success##".MSG_USER_ADDED_SUCCESSFULLY." ".MSG_EMAIL_SENT_TO_USER."##".$link; 
				exit;
			}				

		}
	}

/*********************Add gaurdian ENDS****************/

/*********************Delete(gaurdian) STARTS****************/


	private function emailAfterAddUser($data, $child = array())
	{
 	 	$sUserFullName = $data['firstname']." ".$data['lastname'];
	  //  $this->Email->to = $data['email'];				
	    $this->Email->to =  $data['email'];				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	    $urlUsed = SITE_HTTP_URL."users/validate_user/?v=".base64_encode($data['email']);
		$userType = $this->UserType->findById($data['user_type_id']);
		
       $sMessage ="Dear ".$sUserFullName.","."<br/><br/>

		Your account has been created for ".SITE_NAME." successfully.<br/><br/>
		Here are your new login details:<br/>
		Username: ".$data['username']." <br/>
		Password: ".$data['password']." <br/>
		Account type: ".$userType['UserType']['title']."<br/>";
       	if(isset($child) && count($child)>0)
       	{
       		$sMessage.="For Student: <a href = '".SITE_HTTP_URL."users/viewProfile/".$child['User']['id']."'>".$child['User']['firstname']." ".$child['User']['lastname']."</a> <br/>";		
       	}
       	 
		$sMessage.="<br/>Please use the URL below to login to your account:<br/>
		<a href='".SITE_HTTP_URL."/'>".SITE_HTTP_URL."</a><br/><br/>

		Thanks & Regards,<br/>
		Website Support <br/>
		".SITE_NAME." <br/>";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = SITE_NAME.' - Account Created';
        $result = $this->Email->sendEmail();
	 
	}
	

/**************************To delete the user account ***************************/
	function deleteUser($case="")
	{
		$userID = $this->request->params['form']['uid'];
		if(!empty($userID))
		{
			switch($case)
			{
				case "guardian":
					$this->coadminGaurdian->deleteAll(" user_id = ".$userID." and type = 1");
					break;
				default:
					$userstatus['status']= 3;
					$this->User->id = $userID;
					$this->User->save($userstatus);
			}
 			echo "success##".MSG_REC_DELTED;
		}
 		exit;
 	}
	function assignGuardian($studentId)
	{
		if(isset($this->request->params['form']) && count($this->request->params['form'])>0)
		{
			$returnArr = array();
			if(isset($this->request->params['form']['users']) && count($this->request->params['form']['users'])>0)
			{
				$lastuserid = $this->request->params['form']['users'][0];
 				$gaurdianData['user_id'] = $studentId;   //studentID
				$gaurdianData['parent_id'] = $this->request->params['form']['users'][0];   //parentID
				$gaurdianData['type'] = 1;   //type  =gaurdian

				$this->coadminGaurdian->id = -1;
				if($this->coadminGaurdian->Save($gaurdianData))
				{
					$usrDetail = $this->User->findById($lastuserid, "firstname, lastname, email, username");
					$userdata['firstname'] = $usrDetail['User']['firstname'];
					$userdata['lastname'] = $usrDetail['User']['lastname'];
					$userdata['email'] = $usrDetail['User']['email'];
					$userdata['username'] = $usrDetail['User']['username'];
					
					 
					$href= SITE_HTTP_URL."users/viewProfile/".$lastuserid; // link to view gaurdian profile
	
					$confirmdel= "confirmdel($lastuserid,'G',$studentId)";
	
					$link = "<a href='$href'>".ucfirst($userdata['firstname']." ".$userdata['lastname'])."</a>&nbsp;&nbsp;&nbsp;&nbsp; <a class='edit deleteGroup' style='cursor:pointer;' onclick=$confirmdel;>Delete Guardian</a>";
	
					$returnArr['success']  = GUARDIAN_ASSIGNED;				
					$returnArr['link']  = $link;
				}
				else 
				{
					$returnArr['error']  = ERROR_OCCURED;				
				}
				echo json_encode($returnArr);							
				die;				 
			}
		}
		$this->set("studentId",$studentId);
	}
	function getGuradianUser()
	{
		$tag = $this->request->params['url']['tag'];	 
		$data = array();	
		$admin_id = $this->getAdminId();
		$conditions = "User.user_type_id = 6  AND (User.firstname like '".addslashes($tag)."%' OR User.lastname like '".addslashes($tag)."%') AND User.status = 1 AND User.admin_id = ".$admin_id ;		
		$dataGot = $this->User->find("all", 
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
		exit;
	}
	
	
		
	//Start of new Added by sourab 26-10-2013
	
	
	function addUser()
	{
		$this->render("add_user","ajax");
	}
	
	

	// this function will add new user and also invite user . initiated by teacher
		function addNewInvite()
	{
		$this->autoRender = false;
	 	global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();
		$this->set("timezones",$timezones);
		$this->set("defaultTimeZone",$defaultTimeZone);
		$i=0;
		foreach($this->request->data["User_table"]["firstname"] as $field=>$value)
		{
	
			$check=$this->User->find("all",array('conditions' => array("email"=>$this->request->data["User_table"]["email"][$i])));
			$userdata=array();
			if(!$check)
			{
				$this->request->data['User']["firstname"] = $this->request->data['User_table']['firstname'][$i];	
				$this->request->data['User']["lastname"] =$this->request->data["User_table"]["lastname"][$i];
				$this->request->data['User']["email"] =$this->request->data["User_table"]["email"][$i];
				$this->request->data['User']['created_by']= $this->Session->read('userid');
				$this->request->data['User']["status"]= 0;
				$this->request->data['User']["user_type_id"]= 4;
				$this->request->data['User']["unique_key"]=uniqid(md5(rand()), true);
				$this->User->create();
				$this->User->Save($this->request->data);
				$lastuserid = $this->User->getLastInsertId(); 
				
				
				$this->request->data['Invite']['teacher_id']= $this->Session->read('userid');
				$this->request->data['Invite']["student_id"]= $lastuserid;
				$this->request->data['Invite']["email"]=$this->request->data["User_table"]["email"][$i];
				$this->Invite->create();
				$this->Invite->Save($this->request->data);
				
				
				$userdata['firstname']=$this->request->data['User_table']['firstname'][$i];
				$userdata['lastname']=$this->request->data['User_table']['lastname'][$i];
				$userdata['email']=$this->request->data['User_table']['email'][$i];
				$userdata['user_type_id'] = 4	;	
				$this->emailAfterAddInvite($userdata,$this->request->data['User']["unique_key"]);				
				
				
				$i++;
				
			}
			else
			{
			
				$check2=$this->Invite->find("all",array('conditions' => array("email"=>$this->request->data["User_table"]["email"][$i],"teacher_id"=>$this->Session->read('userid'))));
				if(!$check2)
				{
		
						$this->request->data['Invite']['teacher_id']= $this->Session->read('userid');
						$this->request->data['Invite']["student_id"]= $check[0]["User"]["id"];
						$this->request->data['Invite']["email"]=$this->request->data["User_table"]["email"][$i];
						$this->Invite->create();
						$this->Invite->Save($this->request->data);
						
						$this->request->data['User']["id"]=$check[0]["User"]["id"];
						$this->request->data['User']["unique_key"]=uniqid(md5(rand()), true);
						$this->User->Save($this->request->data);
									
						
							$userdata['firstname']=$this->request->data['User_table']['firstname'][$i];
							$userdata['lastname']=$this->request->data['User_table']['lastname'][$i];
							$userdata['email']=$this->request->data['User_table']['email'][$i];
							$userdata['user_type_id'] = 4	;		
							$this->emailAfterAddInvite($userdata,$this->request->data['User']["unique_key"]);
							$i++;	
				}
				
			}
			
		}
		
		
		$errmsg  = "";
		
		if($i>0)
		{
			echo "success#".INVITE_SUCCESS;
		}
		else
		{
			echo "error#".INVITE_UNSUCCESS;
		}
	
    }//function end
	
	// private function to send email after adding user
	private function emailAfterAddInvite($data,$unique)
	{
 		$this->autoRender = false;
		$sUserFullName = $data['firstname']." ".$data['lastname'];
	  	//$this->Email->config('smtp');
	    $this->Email->to =   $data['email'];				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	  
		$verified=SITE_HTTP_URL."users/verifyme/".$unique."/". $data['email'];
    $sMessage ="Dear ".$sUserFullName.","."<br/><br/>

		Your account has been created for ".SITE_HTTP_URL." successfully by ".$this->Session->read('firstname')." ".$this->Session->read('lastname')."<br/><br/>
		Please use the URL below to Verify Your your account:<br/>
		<a href='".$verified."/'>".$verified."</a><br/><br/>

		Thanks & Regards,<br/>
		Website Support <br/>
		".SITE_NAME." <br/>";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = SITE_NAME.' - Account Created';
        $result = $this->Email->sendEmail();
		
		
         	
	}
	
	function listInviteStudentsAjax()
	{
	
	

		
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";
		
		$filters=array("User.id = Invite.student_id");
		if(isset($this->request->data["User"]["keyword"]) && ($this->request->data["User"]["keyword"]<>"")&& ($this->request->data["User"]["keyword"]<>"Search"))
		{
		
			$keyword=$this->request->data["User"]["keyword"];
			$filters["OR"] =array("User.firstname like '%".$keyword."%'","User.lastname like '%".$keyword."%'","User.email like '%".$keyword."%'");
		
		}
		
		
		

		$this->paginate = array('Invite'=>
		array('conditions'=>" Invite.teacher_id=".$this->Session->read('userid'),
				'joins'=>array(		
							array(
								'type'=>'inner', 
								"table"=>"users", 
								"alias"=>"User",
								"conditions"=>$filters)
				),
			  "fields"=> "Invite.id, User.id,User.firstname, User.lastname, User.profilepic,User.status",
			   "order"=>"User.firstname",
	   		    'group' => array('Invite.id'),
			   "limit"=>6
			)	
		);



		$data = $this->paginate('Invite'); 
   		$totalPages = isset($this->request->params['paging']['Invite']['pageCount'])?$this->request->params['paging']['Invite']['pageCount']:"";
 		
   	

		
		$i = 0;	
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
   			$i++;
   		}  
	
 		$this->set('data', $data);
 		$this->set('page', $page);
		$this->set('totalPages', $totalPages); 
		
		$this->render("list_invite_students_ajax","ajax");
	}

	function deleteStudentInvite($uid)
	{
		if(!empty($uid))
		{			
			$this->Invite->query("DELETE from invites where student_id=$uid AND teacher_id=  ".$this->Session->read('userid'));
			//echo MSG_USER_DELETED_FROM_GROUP;
			$this->Session->setFlash(INVITE_DEL_SUCCESS);		
			die;
		}
	}
	//End of  of new Added by sourab 26-10-2013
	

}
