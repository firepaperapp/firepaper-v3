<?php
App::uses('Sanitize', 'Utility');
class AnnouncementsController  extends AppController{

	var $name = 'Announcements';

	var $uses = array('UserType','classGroup','classgroupStudent', 'Announcement','AnnouncementStatus','User');

	var $helpers = array('Html', 'Form', 'Time','Js','Flash');
	var $layout = "default_front_inner";
	//var $components = array('Facebook','Email');
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

    
	function beforeFilter()
	{
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

	function today(){ 
	 
	 	$this->render("today","ajax");
	}
 
	/**************************To get the group names for the announcement STARTS**************************
	 * At this time only admin user can see write announcement option	 
	 */
	function getGroups($yearGroup = "")
	{
		$data = array();
  		$tag = $this->request->params['url']['tag'];	 
		
  		$admin_id = $this->getAdminId();
		if($yearGroup!='')
		{
			$groupsarr = $this->classGroup->find("all",
						array('conditions'=>"classGroup.group_type='year' AND classGroup.admin_id = ".$admin_id." AND classGroup.title LIKE '".addslashes($tag)."%'" ,
						
						'fields'=>array('id','title')			
						)); 
		}
		else 
		{
			$groupsarr = $this->classGroup->find("all",
												array('conditions'=>"classGroup.group_type='class' AND classGroup.admin_id = ".$admin_id." AND classGroup.title LIKE '".addslashes($tag)."%'" ,
												
												'fields'=>array('id','title')			
												)); 
		}
		if(count($groupsarr)>0)
   	 	{
   	 		$i = 0;
   	 		foreach($groupsarr as $rec)
   	 		{
   	 			$data[$i]['key'] = $rec['classGroup']['title'];
   	 			$data[$i]['value'] = $rec['classGroup']['id'];
   	 			$i++;
   	 		}
   	 	}  
		echo json_encode($data);	
		die;
	}
	
/**************************To get the group names for the announcement ENDS ***************************/
	/**
	 * To get the students who are in selected class group
	 *
	 */
	function getStudents()
	{
		$data = array();
  		$tag = $this->request->params['url']['tag'];	 

			$admin_id = $this->getAdminId();
		$groupsarr = $this->User->find("all",
					array('conditions'=>"User.user_type_id = 4 AND User.admin_id = ".$admin_id." AND ( User.firstname LIKE '".addslashes($tag)."%' OR User.lastname LIKE '".addslashes($tag)."%') AND User.status = 1" ,
					
					'fields'=>array('id','firstname','lastname')			
					)); 
		if(count($groupsarr)>0)
   	 	{
   	 		$i = 0;
   	 		foreach($groupsarr as $rec)
   	 		{
   	 			$data[$i]['key'] = ucfirst($rec['User']['firstname']." ".$rec['User']['lastname']);;
   	 			$data[$i]['value'] = $rec['User']['id'];
   	 			$i++;
   	 		}
   	 	}  
		echo json_encode($data);	
		die;
	}
/**************************To send announcement to students  ***************************/
	function sendAnnouncement()
	{
	
		if( ( isset($this->request->params['form']['groups']) && count($this->request->params['form']['groups'])>0) || 
		(isset($this->request->params['form']['students']) && count($this->request->params['form']['students'])>0)
		 || 
		(isset($this->request->params['form']['yeargroups']) && count($this->request->params['form']['yeargroups'])>0)
		
		){
			$sentTO = "";
			$sendToStudents = array();
			$announceData['announcement_text']= $this->request->params['form']['announce-text'];
			$announceData['created_by']= $this->Session->read('userid');
			
			$this->Announcement->id= -1;
			$this->Announcement->save($announceData);					
			
			$lastanouuncementID= $this->Announcement->getLastInsertId();	
			
			if( isset($this->request->params['form']['yeargroups']) && count($this->request->params['form']['yeargroups'])>0)
			{
				$gotGroups = array_unique($this->request->params['form']['yeargroups']);
				$grpsIdStr = implode(',',$gotGroups);
				$getClassGroups = $this->classGroup->find('all',array(
																	'conditions'=>"parent_id IN (".$grpsIdStr.") ",
																	'fields' => array('id', 'title')
																)
														   );
				$ClassGroupsArray = array();
		 		if(count($getClassGroups)>0)
				{
					foreach($getClassGroups as $group )
					{
						$ClassGroupsArray [] = $group['classGroup']['id'];
						//$sentTO[$group['classGroup']['title']] = $group['classGroup']['title'];
					}
					$stClassGroups = implode(',', $ClassGroupsArray);
					if($stClassGroups != "")
					{
						$groupUsers = $this->classgroupStudent->find("all",array(
																"conditions"=> "group_id IN (".$stClassGroups.")",
																"fields"=>"user_id"
															))	;		
						foreach($groupUsers as $student )
						{
							$sendToStudents [] = $student['classgroupStudent']['user_id'];
						}
					}
				}
			}
			if( isset($this->request->params['form']['groups']) && count($this->request->params['form']['groups'])>0)
			{			
				// getting group id as string and finding the gropunames
				$gotGroups = array_unique($this->request->params['form']['groups']);
				$grpsIdStr = implode(',',$gotGroups);
				$conditions = "id IN($grpsIdStr)";
				$groupNamesData= $this->classGroup->find('all',array('conditions'=>$conditions,
														'fields' => array('id')
				));
				
				foreach($groupNamesData as $gpnd)
				{
					$gpnamearr[] = $gpnd['classGroup']['id'];
					//$sentTO[$group['classGroup']['title']] = $group['classGroup']['title'];
				}				
				$grpsStr = implode(',' , $gpnamearr); // groupname string			
		 		$groupUsers = $this->classgroupStudent->find("all",array(
															"conditions" => "group_id IN (".$grpsStr.")",
															"fields" => array("user_id")
														))	;		
 				if(count($groupUsers) >0 )
				{
					foreach($groupUsers as $user)
					{
						$sendToStudents [] = $user['classgroupStudent']['user_id'];
					}
				}				
				 
			}
		  
			if(isset($this->request->params['form']['students']) && count($this->request->params['form']['students'])>0)
			{
				
				$sendToStudents = array_merge($sendToStudents, $this->request->params['form']['students']);
				
			}
		//	$grpsStr = implode(", ", $sentTO);
			$sendToStudents = array_unique($sendToStudents);
			foreach($sendToStudents as $key=>$val)
			{
				 
					$userRec['announcement_id'] = $lastanouuncementID;
					$userRec['student_id'] =  $val;
					$userRec['status'] = 1;
					$this->AnnouncementStatus->id= -1;
					$this->AnnouncementStatus->save($userRec);	
		 		 
			}
			echo $sentTO."@@@".MSG_ANNOUNCEMENT_SUBMITTED."@@@".$announceData['announcement_text'];

		}

		exit;
	}
	/**************************To send announcement to students  ENDS ***************************/

	/**************************Get All  announcement to list to students  STARTS ***************************/
	function students()
	{
		$userid = $this->Session->read('userid');
	/*	$annnouncementRecorsds = $this->Announcement->query("
		SELECT ANC.id , ANC.announcement_text AS announcement 
		FROM announcements AS ANC ,announcement_status AS ANCST ,users 
		WHERE users.id= $userid AND 
		
		ANCST.student_id= users.id AND 		
		ANCST.announcement_id = ANC.id AND
		ANCST.status !='0' order by ANC.id DESC"); */

		$annnouncementRecorsds = $this->AnnouncementStatus->find("all",array(
							"conditions"=>array('AnnouncementStatus.student_id'=>$userid,"AnnouncementStatus.status='1'"),
							'joins'=>array(
											array(
											'type'=>'inner', 
											"table"=>"announcements", 
											"alias"=>"ANC",
											"conditions"=>array("AnnouncementStatus.announcement_id = ANC.id"))
											
										  ),
							'fields'=>array('ANC.id','ANC.announcement_text AS announcement'),
							'order'=> "ANC.id DESC"
						));
	
		if($this->Session->read('showhideAnnouncement')==1) //hide announcement
		{
			$this->set("showHideAnnc",'N');
		}
		else
		{
			$this->Session->write('showhideAnnouncement',2); //show announcement ...overwriting session value  in                                                                    closeAnnouncement	 method
			$this->set("showHideAnnc",'Y');
		}
		
		$this->set("annnouncementRecorsds",$annnouncementRecorsds);
		$this->render("student","ajax");
	}
	/**************************Get All  announcement to list to students  ENDS ***************************/


/**************************Set announcement status to 0  STARTS ***************************/
	function closeAnnouncement()
	{
		
		//$announcementid = $this->request->params['form']['aid'];
		//if(!empty($announcementid))
		{
			$this->AnnouncementStatus->updateAll(
										array('status'=>"'0'"), //fields
										array('status '=>'1',    //conditions
											  'student_id'=>$this->Session->read('userid')
											)
												);
		
		$this->Session->write('showhideAnnouncement',1);

		echo "success";
		}
		exit;
	}
/**************************Set announcement status to 0  ENDS ***************************/
	 
}
