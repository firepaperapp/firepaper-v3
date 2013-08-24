<?php 
App::uses('Sanitize', 'Utility');
class WhiteboardsController extends AppController
{
	var $name=	'Whiteboards';
	var $uses = array('Whiteboard','WhiteboardComment','coadminGaurdian','User','Project');
	var $helpers = array('Html', 'Form', 'Time','Js','Flash');
	var $layout = "default_front_inner";
	var $components = array('RequestHandler','Email');

	function index()
	{
		
	}
	
	##function to add and edit content STARTS##
	function addEditBoard($whiteboardID=NULL)
	{
		$this->set("contenttitle","");
		$this->set("content", "");
		$this->set("whiteboardID", $whiteboardID);

		if($this->request->data)
		{
			$this->request->data['Whiteboard']['title'] = trim($this->request->data['Whiteboard']['title']);
			$this->request->data['Whiteboard']['content'] = trim($this->request->data['Whiteboard']['content']);
			$this->request->data['Whiteboard']['created_by'] = $this->Session->read('userid');
			$this->request->data['Whiteboard']['admin_id'] = $this->getAdminId();
			if($whiteboardID==NULL)
			{
				$this->Whiteboard->id = -1;
				$this->Whiteboard->save($this->request->data);
				$this->Session->setFlash("Whiteboard Added Successfully");
				$this->redirect("/whiteboards/");
			}
			else
			{
				$this->Whiteboard->id = $whiteboardID;
				if($this->request->data['newversion']==0)
				{
					$this->Whiteboard->save($this->request->data);

					$singleRec = $this->Whiteboard->findById($whiteboardID);
					if($singleRec['Whiteboard']['parent_id'] == 0)
						$parentID = $singleRec['Whiteboard']['id'];
					else
						$parentID = $singleRec['Whiteboard']['parent_id'];

					$this->Whiteboard->id = $parentID;
					$contentarr['title'] = $this->request->data['Whiteboard']['title'];	
					$this->Whiteboard->save($contentarr);

				}
				if($this->request->data['newversion']==1)
				{
					$singleRec = $this->Whiteboard->findById($whiteboardID);
					if($singleRec['Whiteboard']['parent_id'] == 0)
						$parentID = $singleRec['Whiteboard']['id'];
					else
						$parentID = $singleRec['Whiteboard']['parent_id'];
					
					$this->Whiteboard->id = -1;
					$this->request->data['Whiteboard']['parent_id'] =  $parentID;
					$this->Whiteboard->save($this->request->data);

					$this->Whiteboard->id = $parentID;	
					//$this->request->data['Whiteboard']['parent_id'] = 0;
					$contentarr['parent_id'] = 0;
					//$contentarr['content'] = $this->request->data['Whiteboard']['content'];	
					$contentarr['title'] = $this->request->data['Whiteboard']['title'];	
					//$this->Whiteboard->save($contentarr);
			
					
				}

				
				$this->Session->setFlash("Whiteboard Updated Successfully");
				$this->redirect("/whiteboards/");
			}
		}
		//else
		{
			if(isset($whiteboardID) && $whiteboardID > 0)
			{
				$commentdata = $this->Whiteboard->find('first',
													array("conditions"=>array('Whiteboard.id'=>$whiteboardID)
													)
													);
				
				$this->set("contenttitle", $commentdata['Whiteboard']['title']);
				$this->set("content", $commentdata['Whiteboard']['content']);
				
				$this->set("heading", "Update WhiteBoard");
				$this->set("showbutton", "Y");
			}
			else
			{
				
				$this->set("heading", "Add New WhiteBoard");
				$this->set("showbutton", "N");
			}

		}
	
	}
	## function to show single content STARTS ##
	function viewWhiteboard($content_id=0)
	{
	 	$this->set("content_id", $content_id);
		if($content_id > 0)
		{
			 $contentdata = $this->Whiteboard->find('first',array(
			 "conditions"=>array('Whiteboard.id'=>$content_id),
			 "fields"=>"Whiteboard.*,User.firstname, User.lastname")
			 );
			 $projects = $this->Project->find("all",array(
			 "conditions"=>"Project.whiteboards like '%,".$content_id.",%'  AND Project.published!=0",
			 "fields"=>"Project.title, Project.id "
			 ));
			 $projectsAdded = array();
			 $projectsSt = "";
			 foreach($projects as $rec)
			 {
			 	$projectsAdded[] = $rec['Project']['id'];
			 }
			 $projectsSt = implode(",", array_unique($projectsAdded));
			 $prjStu = $this->projectStudent->find("list",
					array("conditions"=>"projectStudent.project_id IN ( ". $projectsSt.")",
					"fields"=>"projectStudent.user_id, projectStudent.user_id"
			  ));
			 $canEdit = 0;
			 if($this->Session->read("userid") == $contentdata['Whiteboard']['created_by'] || in_array($this->Session->read("userid"), $prjStu))
			 {
			 	$canEdit = 1;
			 }
	 		 $this->set("contentdata", $contentdata);
		 	 $this->set("projects", $projects);
		 	 $this->set("canEdit", $canEdit);
		}
	}
	## function to show single comment ENDS ##	
	function listWhiteboardAjax()
	{
			$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";

			$createdBy = $this->Session->read('userid');
			$this->paginate = array('Whiteboard'=>
			array(
				"conditions"=>"Whiteboard.parent_id=0 AND Whiteboard.created_by IN ( ".$createdBy." )",
				"fields"=> "Whiteboard.id,Whiteboard.title, Whiteboard.content, Whiteboard.created", 
				//"order"=>"User.id DESC",
				"order"=>"Whiteboard.id DESC",
				"limit"=>10
				)
			);
			$data = $this->paginate('Whiteboard');


			$totalPages = isset($this->request->params['paging']['Whiteboard']['pageCount'])?$this->request->params['paging']['Whiteboard']['pageCount']:"";
			
			$order = isset($this->request->params['paging']['Whiteboard']['options']['order'])?$this->request->params['paging']['Whiteboard']['options']['order']:"";

			$this->set('data', $data);
			$this->set('page', $page);
			$this->set('order', $order);
			$this->set('totalPages', $totalPages);
	
	}


	// function to delete a Whiteboard
	function deleteWhiteboard()
	{ 
		Controller::disableCache();
	
		$whiteboardID = $this->request->params['form']['whbid'];
		if(!empty($whiteboardID))
		{			
			$wbparentid = $this->Whiteboard->findById($whiteboardID);
			
			if($wbparentid['Whiteboard']['parent_id']==0)
			{
				$this->Whiteboard->deleteAll("Whiteboard.id=$whiteboardID OR Whiteboard.parent_id=$whiteboardID");
				echo MSG_REC_DELTED;
				exit;
			}
			else
			{
				$this->Whiteboard->delete($whiteboardID,true);
			}
			echo MSG_REC_DELTED;
			//$this->Session->setFlash(MSG_REC_DELTED);		
			die;
		}
	}


	function addComment($contentid)
	{ 
		if($this->request->data)
		{			
			$CreatedBy = $this->Whiteboard->find('first',array("conditions"=>array('Whiteboard.id'=>$contentid),'fields'=> 'created_by, title, id, User.firstname, User.lastname'));		
		
			$this->WhiteboardComment->id = -1;
			$this->request->data['WhiteboardComment']['whiteboard_id']=$contentid;
			$this->request->data['WhiteboardComment']['received_by']=$CreatedBy['Whiteboard']['created_by'];
			$this->request->data['WhiteboardComment']['created_by']=$this->Session->read("userid");
			
			 $this->WhiteboardComment->save($this->request->data);
			 echo COMMENT_ADDED;
			 $stUsers = "0,";
			 if($CreatedBy['Whiteboard']['created_by'] != $this->Session->read("userid"))
			 {
			 	$stUsers.= $CreatedBy['Whiteboard']['created_by'].",";
			 }
			 $projectsAdded = array();
			 $projects = $this->Project->find("all",array(
			 "conditions"=>"Project.whiteboards like '%,".$contentid.",%'  AND Project.published!=0",
			 "fields"=>"Project.title, Project.id "
			 ));
	 	 	 
			 foreach($projects as $rec)
			 {
			 	$projectsAdded[] = $rec['Project']['id'];
			 }
			 $projectsSt = implode(",", array_unique($projectsAdded));
			 if($projectsSt!='')
			 {
				 $prjStu = $this->projectStudent->find("list",
						array("conditions"=>"projectStudent.project_id IN ( ". $projectsSt.") AND projectStudent.user_id!=".$this->Session->read("userid"),
						"fields"=>"projectStudent.user_id, projectStudent.user_id"
				  ));
				 
				$stUsers.= implode(",",array_unique($prjStu)).",";
				if($stUsers!='')
				{
					$receivedSt = $stUsers;
					$pasedData['Whiteboard']['title'] = $CreatedBy['Whiteboard']['title'];
					$pasedData['Whiteboard']['id'] = $CreatedBy['Whiteboard']['id'];		
					$pasedData['User']['name'] =   ucfirst($CreatedBy["User"]["firstname"]." ".$CreatedBy["User"]["lastname"]);			
					$pasedData['User']['id'] = $this->Session->read("userid");		
					
				 	$pasedData['activityLog']['user_ids'] = $stUsers;
					$pasedData['activityLog']['activity_task'] = "whiteboardComment";
					 
					$this->createActivityLog($pasedData);
				} 
			 }
			/*if(count($commentRec)>0)
			{
				$received = array();
				foreach ($commentRec as $rec)
				{
					$received[] = $rec['WhiteboardComment']['created_by'];
				}
				if(count($received)>0)
				{
					$receivedSt = ",".implode(",",$received).",";
					$pasedData['Whiteboard']['title'] = $CreatedBy['Whiteboard']['title'];
					$pasedData['Whiteboard']['id'] = $CreatedBy['Whiteboard']['id'];		
					$pasedData['User']['name'] =   ucfirst($CreatedBy["User"]["firstname"]." ".$CreatedBy["User"]["lastname"]);			
					$pasedData['User']['id'] = $this->Session->read("userid");		
					
					$pasedData['activityLog']['user_ids'] = $receivedSt;
					$pasedData['activityLog']['activity_task'] = "whiteboardComment";
					 
					$this->createActivityLog($pasedData);
				}
			}*/
		}
		
		exit;
	}

	function updateComment($commnetid=NULL)
	{
		//pr($this->request->params); 
		$comments = $this->request->params['form']['value'];
		$com= $this->request->params['form']['commenttext'];
		
		$commenttext_varr = explode('_',$com);
		$commentid=  $commenttext_varr[1];

		$updatedecomment = $this->WhiteboardComment->query("update whiteboard_comments SET comment='$comments' where id = $commentid");
		//pr($updatedecomment);
		echo $com= $comments = $this->request->params['form']['value'];
		die;

	}

    ## to show the comment listing of a whiteboard through ajax ##
	function listCommentAjax($contentid = 0)
	{  
		$this->set("show_editdelete",'N');
		$this->set("contentid",$contentid);
		$contentRec =$this->Whiteboard->find("first",
									array('conditions'=>array('Whiteboard.id'=>$contentid),
											'fields'=>array('Whiteboard.parent_id')
											));
	 	$whiteboardArr = array();
		// getting all the id as string to find all the comments
		if($contentRec['Whiteboard']['parent_id']==0)
		{
			$whiteboardArr[] = $contentid;			
		}
		else
		{
			 
			$allIDArr= $this->Whiteboard->find("all",
								array('conditions'=>array('Whiteboard.parent_id'=>$contentRec['Whiteboard']['parent_id']),
											'fields'=>array('Whiteboard.id')
											));		
			$whiteboardArr[] = $contentRec['Whiteboard']['parent_id'];			
		}
			
		if(!empty($allIDArr))
		{
			foreach($allIDArr as $idarr)
			{
			 	$whiteboardArr[] = $idarr['Whiteboard']['id'];					
			}
		} 
		  
		$whiteboardIdStr = implode("," , $whiteboardArr);		
				
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";

		$this->paginate = array('WhiteboardComment'=>
			array(
				"conditions"=>"WhiteboardComment.whiteboard_id IN (".$whiteboardIdStr." )",
				"fields"=> "Whiteboard.title AS version, WhiteboardComment.id,WhiteboardComment.comment, WhiteboardComment.created_by, WhiteboardComment.received_by, User.id , User.firstname,User.lastname, User.profilepic", 
				//"order"=>"User.id DESC",
				"order"=>"WhiteboardComment.id DESC",
				//"limit"=>2
				)
			);
		
			$data = $this->paginate('WhiteboardComment');
		

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

			$totalPages = isset($this->request->params['paging']['WhiteboardComment']['pageCount'])?$this->request->params['paging']['WhiteboardComment']['pageCount']:"";
			
			$order = isset($this->request->params['paging']['WhiteboardComment']['options']['order'])?$this->request->params['paging']['WhiteboardComment']['options']['order']:"";
			
	 		$this->set('data', $data);
			$this->set('page', $page);
			$this->set('order', $order);
			$this->set('totalPages', $totalPages);
			$this->render("list_comment_ajax", "ajax");
	}

	function deleteComment($commentid)
	{
		if(!empty($commentid))
		{			
			$this->WhiteboardComment->delete($commentid,true);
			echo MSG_COMMENT_DELETED;
		//	$this->Session->setFlash(MSG_COMMENT_DELETED);		
			die;
		}
	}
 	function listBoard($whiteboardID=0)
	{
		if($whiteboardID > 0 )
		{
			
			$singleRec = $this->Whiteboard->findById($whiteboardID);
			$wbtitle = $singleRec['Whiteboard']['title'];

			$conditions = "Whiteboard.parent_id= $whiteboardID";
			$recWB= $this->Whiteboard->find("all" ,array("conditions"=>$conditions));
			
			$this->set("wbtitle" ,$wbtitle);
			$this->set("recWB" ,$recWB);
		}
		$this->set("whiteboardID",$whiteboardID);		
		$this->render("list_board","ajax");		
	}
	/**
	 * To get the whiteboards those are added by the user
	 * Used on the project creation page
	 */
	
	function getWhiteboards()
	{
		$data = array();
 		$tag = $this->request->params['url']['tag'];	 
 		$userId = $this->Session->read('userid'); 
		//  filter the class grop by the admin id for admin and coadmin user
		$filters= "";
		$admin_id = $this->getAdminId();
		$dataGot = $this->Whiteboard->find("all",
								array('conditions'=>'Whiteboard.admin_id = '.$admin_id.' and Whiteboard.title like "'.add_Slashes($tag).'%" AND parent_id = 0',
									'fields'=>array('Whiteboard.title,Whiteboard.id ')));
		//$filters.=" OR classGroup.admin_id = ".$admin_id.")";
 	 
 		$i = 0;
 	 	if(count($dataGot)>0)
		{
			$i = 0;
			foreach($dataGot as $rec)
			{
				$data[$i]['key'] = $rec['Whiteboard']['title'];
				$data[$i]['value'] = $rec['Whiteboard']['id'];
				$i++;
			}
		} 
		echo json_encode($data);
		die;						 
	}
	function test()
	{
		$strMyReg = "/(?<!\d)5(?!\d)/";
		
		$input1 = "5";
		$input2 = "5,";
		$input3 = ",5,";
		$input4 = ",5";
		$input5 = "45";
		$input6 = "54";
		$input7 = "454";
		$input8 = "55";
		
		if(preg_match($strMyReg,$input1))
		{
			echo "correct";
		}else
		{
			echo "incorrect";
		}
		
	}

}

?>