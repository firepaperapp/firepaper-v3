<?php
App::uses('Sanitize', 'Utility');
class FilesController  extends AppController{

	var $name = 'Files';

	var $uses = array('userFile','Comment', 'User','fileCategory','projectTask');

	var $helpers = array('Html', 'Form', 'Time','Js','Flash');
	var $layout = "default_front_inner";
	var $components = array('RequestHandler');
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
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
 		parent::beforeFilter();
	}
	function beforeRender()
    {
    	parent::beforeRender();
    	
    }
  	/**
	 * @uses This function is used to render the homepage view
	 * @input NULL
	 * @returns NULL
	 */

	function getFiles($id=0)
	{ 
	    //die;	
	    $this->set("id", $id);
   		$this->render("index");
	}	
	function getFilesInner($id=0)
	{  	
		$data = array();
		$this->userFile->userId = $this->Session->read('userid');	   
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";   		
		$limit = 10;//PAGE_LIMIT;
		$conditions = "";
		$hasMany = array(
			'userFile' => array(
				"fields"=>"userFile.*, (Select count(id) from files where files.version_of = userFile.id) as count",
				'conditions'=>"userFile.version_of = 0",
 				'className' => 'userFile',
				'foreignKey' => 'category_id',
	 			'order' => 'userFile.id DESC' 
	 			)
			); 
		if($id!=0 && $id!='')
		{
			$conditions.= " AND fileCategory.id = ".$id;
		}
		$this->fileCategory->bindModel(array("hasMany"=>$hasMany));	
 		$this->paginate = array('fileCategory'=> array(
		"fields"=>"fileCategory.title,fileCategory.id",
		"conditions"=>"fileCategory.created_by = ".$this->Session->read('userid').$conditions,
		"order"=>"fileCategory.isdefault DESC"
		));
		
		//Get all tasks in the project
		$this->fileCategory->bindModel(array("hasMany"=>$hasMany));
		$data = $this->paginate('fileCategory');  
  
     	$totalPages = isset($this->request->params['paging']['fileCategory']['pageCount'])?$this->request->params['paging']['fileCategory']['pageCount']:"";		
   		$order = isset($this->request->params['paging']['fileCategory']['options']['order'])?$this->request->params['paging']['fileCategory']['options']['order']:"";
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:1;
   	 
   	 	
   		$i = 0;
   		$prev = "";
   		$current = "";
    	$i = 0;		 
   		
   		$db = ConnectionManager::getDataSource('default');
		$db->rawQuery("SELECT fileType.id, fileType.icon FROM  file_types as fileType");
		$fileTypes = array();

		if ($db->hasResult()) {
			while ($item = $db->fetchRow()) {
				$fileTypes[] = $item;
			}
		}
		
	 	$fileTypesO = array();
	 	foreach ($fileTypes as $rec)
	 	{
	 		$fileTypesO[$rec['fileType']['id']]	= $rec['fileType']['icon'];
	 	}
    	$this->set("fileTypes", $fileTypesO);
     	$this->set("data", $data);
   		$this->set('page', $page);
   		$this->set('limit', $limit);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
  		$this->render("get_files_inner","ajax");
	} 
	function getSubFiles($fileId)
	{    
	 	################## End Delete a Department ##############################
	 	$data = array();
		$subFiles = $this->userFile->getSubFiles($fileId);
		if(isset($subFiles[0]['userFile']['id']))
		{
			$data['Revison'] = $subFiles;
		}
		$this->set("mainId",$fileId);
		$this->set("rec",$data);
		$this->render("get_sub_files","ajax");
	}

	/**
	 * User can change the ordering of the files from the view
	 * It will be used to save the order of the files
	 * We will be using "order" fiels for the master files only.
	 * Whatever order will be sent, we will calcuate it from the pageNumbr
	
	  It is not getting used now	
	 */
	
	function saveFilesOrdering()
	{ 
 		if(isset($this->request->params['form']))
		{
			$page = $this->request->params['form']['page'];
			$limit = $this->request->params['form']['limit'];
			$recondOnPage = $this->request->params['form']['total'];
			
			if($page==1)
			{
				if($recondOnPage<$limit)
				{
					$start = $limit-($limit-$recondOnPage);
				}
				else 
				{
					$start = $limit;
				}
			}
			else 
			{
				if($recondOnPage<$limit)
				{
					$left = $limit-$recondOnPage;
					$start = ($page*$limit)-$left;
				}
				else 
				{
					$start = ($page*$limit);
				}
			}
		 
			$idsArray = $this->request->params['form']['main']; 
			$j = count($idsArray)-1;
	 		for($i=$start;$i>$start-$limit;$i--)
			{
				if($j>-1)
				{
					$qry = "UPDATE files set `order` = ".$i." WHERE id = ".$idsArray[$j];
					$this->userFile->query($qry);
				}
				$j--;
			}
		}
		$this->autoRender = false;            
		die;
	}
	/**
	 * To save the parameters like:comment, category and tags
	 */
	function saveParameters($action="")
	{
		switch ($action)
		{
			case "comments":
				{
					$val = explode("_",$this->request->params['form']['id']);
		 			$this->Comment->id = $val[1];
					$data['Comment']['message'] = $this->request->params['form']['value'];
					$this->Comment->Save($data);
					echo $data['Comment']['message'];
					break;
				}
			case "tags":
				{
				 
					$val = explode("_",$this->request->params['form']['id']);
		 			$this->userFile->id = $val[1];
					$data['userFile']['tags'] = $this->request->params['form']['value'];
					$this->userFile->Save($data);
					echo $data['userFile']['tags'];
					break;
				}
			case "category":
				{		 
					$val = explode("_",$this->request->params['form']['id']);
					$valCat = explode("_",$this->request->params['form']['value']);
		 			$this->userFile->id = $val[1];
					$data['userFile']['category_id'] = $valCat[0];
					$this->userFile->Save($data);
					echo $valCat[1];
					break;
				}
			case "addcategory":
				{
					$post = $this->request->params['form'];
					$post['created_by'] = $this->Session->read("userid");
					if($this->userFile->saveCategory($post))
					{
						echo $post['value'];
					}
					else 
						echo MSG_REC_CANT_UPDATED;
					die;
				}
		}
		die;
	}
	
	/**
	 * Will bne used in overall the project to draw the right bootom drop box
	 * of Activity, Fiels and projects
	 */
	function activityFilesProjectsDropbox()
	{		
		$userId = $this->Session->read('userid');
		$this->loadModel('User');
		
 		$this->render("dropbox");
	}
	/**
	 * TO get the files list in the LHS dropbox, it will according to the selected option
	 *  by name, type OR Date
	 */
	function listFiles($viewType = "selname")
	{
		if($viewType == "seltdate")
		{
			$order = " userFile.`uploaded` ";
		}
		else if($viewType == "seltype")
		{
			$order = " userFile.`file_type_id` ";
		}
		else 
		{
			$order = " userFile.`file_name` ";
		}
		$this->userFile->userId = $this->Session->read('userid');	   
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";   		
		$limit = 10;//PAGE_LIMIT;
		$this->paginate = array('userFile'=> array(
 			"limit"=>$limit,
			"fields"=>"userFile.*, fileType.icon, (Select count(id) from files where files.version_of = userFile.id) as count",
 			"conditions"=>"userFile.created_by =".$this->Session->read('userid'),
 			"joins"=>array(
 							array("type"=>"inner",
 							"table"=>"file_types",
 							"alias"=>"fileType",
 							"conditions"=>array("fileType.id = userFile.file_type_id"))
 								),
 			"order"=>$order
 			));
   		$data = $this->paginate('userFile');   		
 
     	$totalPages = isset($this->request->params['paging']['userFile']['pageCount'])?$this->request->params['paging']['userFile']['pageCount']:"";		
   		$order = isset($this->request->params['paging']['userFile']['options']['order'])?$this->request->params['paging']['userFile']['options']['order']:"";
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:1;
    	$this->set("data", $data);
   		$this->set('page', $page);
   		$this->set('limit', $limit);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
  		$this->render("list_files_inner","ajax");
	}
	/**
	 * It is used to list the comments related to a file
	 *
	 * @param unknown_type $fileId : file id
	 */
	function getFileComments($fileId=NULL)
	{
		if($fileId!='')
		{				
			################## Start Add a Coment ############################
			if(isset($this->request->params['form']['comment']))
			{
				$val = explode("_",$this->request->params['form']['comment']);
	 			$this->Comment->id = -1;
				$data['Comment']['message'] = $this->request->params['form']['comment'];
				$data['Comment']['from_id'] = $this->Session->read("userid");
				$data['Comment']['file_id'] = $fileId;
				$this->Comment->Save($data);
				$this->Session->setFlash(COMMENT_ADDED);
        	}
			################## End Add a Comment ############################
			################## Start Delete a File ############################
	 	 	if(isset($this->request->params['url']['d']) && !isNull($this->request->params['url']['d']))
	   		{
	   			$cc = $this->request->params['url']['d'];
	   			$ret = $this->Comment->deleteAll(" Comment.id = ".$cc);
	   			die;
	   				
	   		}
		 	################## End Delete a File ############################
			$limit = 20;//PAGE_LIMIT;
			$this->paginate = array('Comment'=> array(
	 			"limit"=> $limit,
				"fields"=>"Comment.*",
	 			"conditions"=>"Comment.file_id = ".$fileId." AND Comment.from_id =".$this->Session->read('userid'),
	 			"order"=>"id desc"
	 			));
	   		$data = $this->paginate('Comment');   		
	 
	     	$totalPages = isset($this->request->params['paging']['Comment']['pageCount'])?$this->request->params['paging']['Comment']['pageCount']:"";		
	   		$order = isset($this->request->params['paging']['Comment']['options']['order'])?$this->request->params['paging']['Comment']['options']['order']:"";
	   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:1;
	    	$this->set("data", $data);
	   		$this->set('page', $page);
	   		$this->set('limit', $limit);
			$this->set('order', $order);
			$this->set('totalPages', $totalPages);
			$this->set('fileId', $fileId);
	  		$this->render("get_file_comments","ajax");
		}		
	}
	/**
	 * It is used to upload the file
	 *
	 * @param unknown_type $fileId : If it a version of any file, otherwise NULL
	 */
	function uploadFile($fileId="")
	{
		 //echo "i am here.."; exit;
  		$uid = $this->Session->read('userid');
	    $msg = "";
		global $videoArray;
		$this->request->params['form'] = $_FILES;
		
	  //	print_r($this->request->params['form']); exit;
	  
			if($this->userFile->validateFileUpload($this->request->params['form']) == 0)
		{
			
		 	$uploads_dir = "";
			$uploads_strt_dir = FILES_PATH."files/";
			########### whether user's admin or user itself has enough space to upload the file ###########	
			 
			if($this->Session->read("admin_id")!=0)
			{
				$uploads_dir = $this->Session->read("admin_id")."/";
				//we will get the space used by his admin
				$spaceDetail = 
				$this->User->find(
				"first",
				array("conditions"=>"User.id = ".$this->Session->read("admin_id"), 
				"fields"=>"totalspace, usedspace, Package.unlimited",
				"joins"=>array(
					array("type"=>"inner",
					"table"=>"packages",
					"alias"=>"Package",
					"conditions"=>array("Package.id = User.package_id")),
					)
				)
			   );		
					
				$ms = ENOUGH_SPACE_ADMIN;	
			}
			else 
			{
				//If is a individual user
				$spaceDetail = 
				
				$this->User->find(
				"first",
				array("conditions"=>"User.id = ".$this->Session->read("userid"), 
				"fields"=>"totalspace, usedspace, Package.unlimited",
				"joins"=>array(
					array("type"=>"inner",
					"table"=>"packages",
					"alias"=>"Package",
					"conditions"=>array("Package.id = User.package_id")),
					)
				)
			   );		
			   
				$ms = ENOUGH_SPACE_USER;
			}
	 		if(($spaceDetail['User']['usedspace']+$this->request->params['form']['uploadfile']['size']) > $spaceDetail['User']['totalspace'] &&  $spaceDetail['Package']['unlimited']!=1)
			{
				echo "check1 ==="; exit;
				$response['error'] = $ms;
				
			}
			else 
			{
				if($_SERVER['REMOTE_ADDR'] =='180.188.253.92')
				{
					$getModelName = array_keys($this->request->params['form']['data']['name']);
					$_moduleName = $getModelName[0];
				
					$uploads_dir.= $this->Session->read("userid"); 
					$mineType =  $this->request->params['form']['data']['type'][$_moduleName]['uploadfile'];
					$source = $this->request->params['form']['data']['tmp_name'][$_moduleName]['uploadfile'];
					$arFile = explode(".",$this->request->params['form']['data']['name'][$_moduleName]['uploadfile']);
					$string = remove_specialchars($arFile[0]);				
					$fileExt = array_pop($arFile);
					
					$filebase = $string."_".time();
					
					$filename = $filebase.".".$fileExt;
					$actualFilename = $string.".".$fileExt;
					
					$result = copy($this->request->params['form']['data']['tmp_name'][$_moduleName]['uploadfile'],WWW_ROOT.'files/'.$filename);
					echo '<pre>'; var_dump($result); echo '</prE>';
					echo '<pre>'; var_dump(WWW_ROOT.'files/'.$filename); echo '</prE>'; exit;
					
					if(!file_exists($uploads_strt_dir))
					{	
						mkdir($uploads_strt_dir); 
					}
					$uploads_dir_explode = explode("/", $uploads_dir);
					if(count($uploads_dir_explode)>0)
					{
						foreach($uploads_dir_explode as $createDir)
						{
							if(!file_exists($uploads_strt_dir.$createDir))
							{  
								mkdir($uploads_strt_dir.$createDir);
								@chmod($uploads_strt_dir.$createDir, 0755);
							}
						}
					}
					if(!file_exists($uploads_strt_dir.$uploads_dir))
					{  
						mkdir($uploads_strt_dir.$uploads_dir);
					}
					@chmod("$uploads_strt_dir.$uploads_dir", 0755);
					
					if($fileId!='')
					{
						$uploads_dir = $uploads_dir."/".$fileId;
						if(!file_exists($uploads_strt_dir.$uploads_dir))
						{

							mkdir($uploads_strt_dir.$uploads_dir); 
						}
						@chmod($uploads_strt_dir.$uploads_dir,0777);
						$this->request->data['userFile']['version_of'] = $fileId;
					}					
					if(in_array(strtolower($fileExt), $videoArray))
					{
						//if it is a video file
						$filename = $this->uploadVideo($uploads_dir."/", $this->request->params['form']['uploadfile']);			 
						if($filename!=false)
						{
							$return = true; 						 
							$rest = explode("##", $filename);
							$filename = $rest[0];
							$this->request->params['form']['uploadfile']['size'] = $rest[1];
						}
						else 
						{
							$return = false; 						 
						}
					}
					else
					{	 
						//we will simply upload the file
						move_uploaded_file($this->request->params['form']['data']['tmp_name'][$_moduleName]['uploadfile'], $uploads_strt_dir.$uploads_dir."/".$filename);
							 
			
						$old = umask(0);
						@chmod("$uploads_dir/$filename", 0755);
						umask($old);

						// Checking
						if ($old != umask()) {
							die('An error occured while changing back the umask');
						}
						else {
							//We will upload the object into amazon
							 $return = true;
							$return = $this->moveFileToAmazon($uploads_dir."/".$filename);
							//We will delete the local file
							//@unlink($uploads_strt_dir.$uploads_dir);
						}
					}
					/*
					if($return == true)
					{
						$iconType = $this->userFile->getIconType($fileExt);				
						$this->request->data['userFile']['name'] = $filename;
						$this->request->data['userFile']['file_name'] = $actualFilename;//$filename;
						$this->request->data['userFile']['file_type_id'] = $iconType;
						$this->request->data['userFile']['size'] = $this->request->params['form']['uploadfile']['size'];
						$this->request->data['userFile']['created_by'] = $this->Session->read("userid");
						$this->request->data['userFile']['uploaded'] = date("Y-m-d H:i:s");
						
						//$this->Session->setFlash(MSG_FILE_UPLOADED);				 
						if(isset($_POST['category_id']) && !isNull($_POST['category_id']))
						{
							$gotCat = $_POST['category_id'];
						}
						else 
						{
							$defaultCat = $this->fileCategory->find("first", array(
							"conditions"=>"isdefault = 1 and created_by = ".$this->Session->read("userid")
							));
							if(!isset($defaultCat['fileCategory']['id']))
							{
								$defCat['fileCategory']['title'] = "UnCategorized";
								$defCat['fileCategory']['isdefault'] = 1;
								$defCat['fileCategory']['created_by'] = $this->Session->read("userid");
								$this->fileCategory->Save($defCat);
								$gotCat = $this->fileCategory->getLastInsertId();
							}
							else 
							{
								$gotCat = $defaultCat['fileCategory']['id'];
							}
						}
						 
						$this->request->data['userFile']['category_id'] = $gotCat;
						$this->userFile->Save($this->request->data);
						//we will increase admin's used space
						if($this->Session->read("admin_id")!=0)
						{
							$uid = $this->Session->read("admin_id");						
						}
						else 
						{
							//If is a individual user
							$uid = $this->Session->read("userid");			
						}
						$this->User->manageUserSpace($this->request->data['userFile']['size'], $uid, "add");
						$response['success'] = MSG_FILE_UPLOADED;
						$response['id'] = $this->userFile->getLastInsertId();
					}
					else 
					{
						$response['error'] = FILE_CANT_UPLOADED;
					}
					*/
					$response['id'] = 1;
					
				}else{
					/*
					echo "check2 ==="; exit;
					print_r($this->request->params['form']); exit;
					*/
					########### End Here ###########
					
					$uploads_dir.= $this->Session->read("userid"); 
					$mineType =  $this->request->params['form']['uploadfile']['type'];
					$source = $this->request->params['form']['uploadfile']['tmp_name'];
					$arFile = explode(".",$this->request->params['form']['uploadfile']['name']);				
					$string = remove_specialchars($arFile[0]);				
					$fileExt = array_pop($arFile);
					
					$filebase = $string."_".time();
					//$filebase = $string;
					
					$filename = $filebase.".".$fileExt;
					$actualFilename = $string.".".$fileExt;
					if(!file_exists($uploads_strt_dir))
					{	
						mkdir($uploads_strt_dir); 
					}
					$uploads_dir_explode = explode("/", $uploads_dir);
					if(count($uploads_dir_explode)>0)
					{
						foreach($uploads_dir_explode as $createDir)
						{
							if(!file_exists($uploads_strt_dir.$createDir))
							{  
								mkdir($uploads_strt_dir.$createDir);
								@chmod($uploads_strt_dir.$createDir, 0755);
							}
						}
					}
					if(!file_exists($uploads_strt_dir.$uploads_dir))
					{  
						mkdir($uploads_strt_dir.$uploads_dir);
					}
					@chmod("$uploads_strt_dir.$uploads_dir", 0755);
					if($fileId!='')
					{
						$uploads_dir = $uploads_dir."/".$fileId;
						if(!file_exists($uploads_strt_dir.$uploads_dir))
						{

							mkdir($uploads_strt_dir.$uploads_dir); 
						}
						@chmod($uploads_strt_dir.$uploads_dir,0777);
						$this->request->data['userFile']['version_of'] = $fileId;
					}					
					if(in_array(strtolower($fileExt), $videoArray))
					{
						//if it is a video file
						$filename = $this->uploadVideo($uploads_dir."/", $this->request->params['form']['uploadfile']);			 
						if($filename!=false)
						{
							$return = true; 						 
							$rest = explode("##", $filename);
							$filename = $rest[0];
							$this->request->params['form']['uploadfile']['size'] = $rest[1];
						}
						else 
						{
							$return = false; 						 
						}
					}
					else
					{	 
						//we will simply upload the file
						move_uploaded_file( $this->request->params['form']['uploadfile']['tmp_name'], $uploads_strt_dir.$uploads_dir."/".$filename);
							 
			
						$old = umask(0);
						@chmod("$uploads_dir/$filename", 0755);
						umask($old);

						// Checking
						if ($old != umask()) {
							die('An error occured while changing back the umask');
						}
						else {
							//We will upload the object into amazon
							 $return = true;
							$return = $this->moveFileToAmazon($uploads_dir."/".$filename);
							//We will delete the local file
							//@unlink($uploads_strt_dir.$uploads_dir);
						}
					}
					if($return == true)
					{
						$iconType = $this->userFile->getIconType($fileExt);				
						$this->request->data['userFile']['name'] = $filename;
						$this->request->data['userFile']['file_name'] = $actualFilename;//$filename;
						$this->request->data['userFile']['file_type_id'] = $iconType;
						$this->request->data['userFile']['size'] = $this->request->params['form']['uploadfile']['size'];
						$this->request->data['userFile']['created_by'] = $this->Session->read("userid");
						$this->request->data['userFile']['uploaded'] = date("Y-m-d H:i:s");
						
						//$this->Session->setFlash(MSG_FILE_UPLOADED);				 
						if(isset($_POST['category_id']) && !isNull($_POST['category_id']))
						{
							$gotCat = $_POST['category_id'];
						}
						else 
						{
							$defaultCat = $this->fileCategory->find("first", array(
							"conditions"=>"isdefault = 1 and created_by = ".$this->Session->read("userid")
							));
							if(!isset($defaultCat['fileCategory']['id']))
							{
								$defCat['fileCategory']['title'] = "UnCategorized";
								$defCat['fileCategory']['isdefault'] = 1;
								$defCat['fileCategory']['created_by'] = $this->Session->read("userid");
								$this->fileCategory->Save($defCat);
								$gotCat = $this->fileCategory->getLastInsertId();
							}
							else 
							{
								$gotCat = $defaultCat['fileCategory']['id'];
							}
						}
						 
						$this->request->data['userFile']['category_id'] = $gotCat;
						$this->userFile->Save($this->request->data);
						//we will increase admin's used space
						if($this->Session->read("admin_id")!=0)
						{
							$uid = $this->Session->read("admin_id");						
						}
						else 
						{
							//If is a individual user
							$uid = $this->Session->read("userid");			
						}
						$this->User->manageUserSpace($this->request->data['userFile']['size'], $uid, "add");
						$response['success'] = MSG_FILE_UPLOADED;
						$response['id'] = $this->userFile->getLastInsertId();
					}
					else 
					{
						$response['error'] = FILE_CANT_UPLOADED;
					}
				}
			}				 
        
		}
		else
		{
			$response['error'] = $this->userFile->errMsg;
		}
		
		$this->RequestHandler->respondAs('json'); 			
		echo json_encode($response);
		$this->autoRender = false;         
		die; 
	}
	/**
	* It is used to upload the video in case of create a new file
	*/
	function uploadVideo($uploadDir, $videoArray)
	{
		$uploads_strt_dir = FILES_PATH."files/"; 
		$gotDir = $uploadDir;
		$uploadDir = $uploads_strt_dir.$uploadDir;
		$arrFileExt = explode(".", strrev($videoArray['name']));
		$arrFileName = explode(".",str_replace(" ","",$videoArray['name']));
		$strFileName = $arrFileName[0]."_".time();
 		//	if(!$this->videogalleries->validateVideo($this->request->params['data']['video'],$this->request->data['video']['sName']['name'])){
 
		#UPLOAD VEDIO ON THE SERVER
		#UPLOAD VEDIO ON THE SERVER
 
		chmod($uploadDir,0777);
		if(!is_dir($uploadDir.'video'))
		{
			mkdir($uploadDir.'video');
		}
		chmod($uploadDir.'video',0777);
		if(!is_dir($uploadDir.'flv'))
		{
			mkdir($uploadDir.'flv');
		}		
		if(!is_dir($uploadDir.'videoshots'))
		{
			mkdir($uploadDir.'videoshots');
		}		
		$fileName = $uploadDir.'video/'.$strFileName.".".strrev($arrFileExt[0]);
		move_uploaded_file($videoArray["tmp_name"], $fileName);		 
		chmod($fileName, 0755);
		//Move to amazon
		
		chmod($uploadDir.'flv', 0777);
		exec(MENCODER.$uploadDir.'video/'.$strFileName.".".strrev($arrFileExt[0])." -oac mp3lame -vf scale=320:240,harddup -lavcopts vcodec=flv:vbitrate=200:cbp:mv0:mbd=2:trell:v4mv:predia=2:dia=2:last_pred=3 -of lavf -lameopts br=64 -ovc lavc -ofps 25 -srate 22050 -o ".$uploadDir.'flv/'.$strFileName.".flv",$outPut,$returnVar);
		
		
		$outPut = "";
		$returnVar = "";
	 
		chmod($uploadDir.'videoshots',0777); 
		exec(FFMPEG." -itsoffset -4 -i ".$uploadDir.'video/'.$strFileName.".".strrev($arrFileExt[0])." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 120x120 ".$uploadDir.'videoshots/'.$strFileName.".jpg", $outPut, $returnVar);	
		@chmod($uploadDir.'videoshots/'.$strFileName.".jpg", 0755);
		
		$file1 = $gotDir.'video/'.$strFileName.".".strrev($arrFileExt[0]);
		$file2 = $gotDir.'flv/'.$strFileName.".flv";
		$file3 = $gotDir.'videoshots/'.$strFileName.".jpg";
		
		/*$file1 = '226/video/ROUND1_1296737236.MPG';
		$file2 = '226/flv/barsandtone.flv';
		$file3 = '226/videoshots/1285779079_envelope.png';*/
		if($this->moveFileToAmazon($file1))
		{
			$ttlSize = filesize($uploads_strt_dir.$file1)+filesize($uploads_strt_dir.$file2)+filesize($uploads_strt_dir.$file3);
			$this->moveFileToAmazon($file2);
			$this->moveFileToAmazon($file3); 
			//unlink($uploads_strt_dir.$file1);
			//unlink($uploads_strt_dir.$file2);
			//unlink($uploads_strt_dir.$file3);
			return $strFileName.".".strrev($arrFileExt[0])."##".$ttlSize;	
		}
		else 
		{
			return false;
		}		
	}
	/**
	 * This will be used to move the local file to the amazon web server
	 *
	 * @param unknown_type $fileWithPath .$fileWithPath
	 * @return unknown
	 */
	function moveFileToAmazon($fileWithPath)
	{ 
		App::import('Vendor', 's3', array('file' => 's3'.DS.'sdk.class.php')); 
		$buket = MAIN_BUCKET;
		$obj = new AmazonS3(AMAZON_S3_KEY, AMAZON_S3_SECURITY_KEY);
		$response = $obj->create_object($buket, "files/".$fileWithPath,
		array("fileUpload"=> FILES_PATH."files/".$fileWithPath,
		"contentType" => mime_content_type_update(FILES_PATH."files/".$fileWithPath))
		);
		
		if ($response->isOK()) 
		{
			return true;
		}
		return false;		
	}
	/**
	 * Delete a file from amazon server
	 *
	 * @param unknown_type Path of the file or the directory that you want to delete
	 * @return unknown
	 */
	function deleteFileFromAmazon($fileWithPath)
	{
//		print "<pre>";
//		print_R($fileWithPath);
//		print "</pre>";
		$size = 0; 
	 	App::import('Vendor', 's3', array('file' => 's3'.DS.'sdk.class.php')); 
		$buket = MAIN_BUCKET;
		$obj = new AmazonS3(AMAZON_S3_KEY, AMAZON_S3_SECURITY_KEY);
		print "<pre>";
		print_R($obj);
		print "</pre>";
		die;
		if(!is_Array($fileWithPath))
		{
			$size = $obj->get_object_filesize($buket, "files/".$fileWithPath);				 
	 		$response = $obj->delete_object($buket, "files/".$fileWithPath);		
		}
		else {			
			foreach($fileWithPath as $rec)
			{
				$size+= $obj->get_object_filesize($buket, "files/".$rec['fileWithPath']);	
				$response = $obj->delete_object($buket, "files/".$rec['fileWithPath']);
			}
		}		
	 	if ($response->isOK()) 
		{
			return  $size;			
		}
		return false;		
	}
	
 
	/**
	 * It is used to confirm the user for deletion of a file
	 * We will give a set of option to user that he can opt in to delete the file
  	   @$numberOfVersions : If file has not revisions then we will show only "Delete Conformation"
	 * @param int $fileId : It is file ID to be deleted
	 */

	function confirmDeletion($fileId)
	{
		global $videoArray;
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			echo PLEASE_LOGIN;die;
		} 
		if($this->request->data)
		{
			if(isset($this->request->data['userFile']['delFile']))
			{
				$reduceSpace = 0;
				//Delete file from the project
				$res = $this->userFile->find('first',array(
						"conditions"=>"userFile.id=".$fileId) 
					);
				if(isset($this->request->data['userFile']['reason']))
				{					
				 	$this->delFileFromProject($fileId, $this->request->data['userFile']['reason'], $this->request->data['userFile']['delFile']);					
				}
				//Delete file
				if(isset($res['userFile']['id']))
				{
					$arrFileExt = explode(".", strrev($res['userFile']['file_name']));
				 	$fileWithPath = "";						
					if($this->Session->read("admin_id")!=0)
					{
						$fileWithPath.=$this->Session->read("admin_id")."/";
					}	
									
					if(in_array(strtolower(strrev($arrFileExt[0])), $videoArray ))
					{ 
						//it is a video file	
								
						$ret = $this->deleteFileFromAmazon($fileWithPath.$this->Session->read("userid")."/video/".$res['userFile']['file_name']);
						if($ret!=false)
						{					
				 			$reduceSpace+= $ret;							
							$ret = $this->deleteFileFromAmazon($fileWithPath.$this->Session->read("userid")."/flv/".strrev($arrFileExt[1]).".flv");							
							$reduceSpace+= $ret;							
							$ret = $this->deleteFileFromAmazon($fileWithPath.$this->Session->read("userid")."/videoshots/".strrev($arrFileExt[1]).".jpg");							
							$reduceSpace+= $ret;
						
						}
					}
					else
					{	$ex = "";
						if($res['userFile']['version_of']!=0)
						{
							$ex = $res['userFile']['version_of']."/";
						}
							$ret = $this->deleteFileFromAmazon($fileWithPath.$this->Session->read("userid")."/".$ex.$res['userFile']['file_name']);
			 		$reduceSpace+= $ret;
					}				
				 	if($this->request->data['userFile']['delFile']==1 || $this->request->data['userFile']['delFile']==2)
					{
						//to delete the revisons
						//@rrmdir(FILES_PATH."files/".$this->Session->read("userid")."/".$fileId);						
						$files = $this->userFile->find("all", 
						array("conditions"=>"userFile.created_by = ".$this->Session->read("userid")." AND (userFile.version_of = ".$fileId.")",
						"fields"=>"userFile.file_name"
						)
						);
						$delArray = array();
						foreach($files as $rec) 
						{
							$delArray[]['fileWithPath'] = $fileWithPath.$this->Session->read("userid")."/".$fileId."/".$rec['userFile']['file_name'];
						}
						if(Count($delArray)>0)
						{
							$this->deleteFileFromAmazon($delArray);
						}
						$ret = 
						$this->userFile->deleteAll("userFile.created_by = ".$this->Session->read("userid")." AND (userFile.version_of = ".$fileId." OR userFile.id = ".$fileId.")");
					 
					}
					else
					{
						if($res['userFile']['version_of']==0)
						{
							$resLastDoc = $this->userFile->find('first',
								array("conditions"=>"userFile.version_of =".$fileId,
									  "order"=>"id desc",
									  "fields" => "userFile.id"
									)
										); 
							$ret = $this->userFile->updateAll(
								array("version_of"=> $resLastDoc['userFile']['id']),
								array("version_of"=>$fileId)
							);
							$ret = $this->userFile->updateAll(
								array("version_of"=> 0),
								array("id"=>$resLastDoc['userFile']['id'])
							);
						}
						$ret = $this->userFile->deleteAll("userFile.created_by = ".$this->Session->read("userid")." AND userFile.id = ".$fileId."");
						 
					}
				}
				//we will increase admin's used space
				if($this->Session->read("admin_id")!=0)
				{
					$uid = $this->Session->read("admin_id");						
				}
				else 
				{
					//If is a individual user
					$uid = $this->Session->read("userid");			
				}
	 			$this->User->manageUserSpace($reduceSpace, $uid, "remove");
		 			
				$response['success'] = 1;
				$this->RequestHandler->respondAs('json'); 			
				echo json_encode($response);
				$this->autoRender = false;
				die;
			}
		}
		$numberOfVersions = $this->userFile->find('count',
			array("conditions"=>"userFile.version_of=".$fileId." AND userFile.created_by = ".$this->Session->read('userid')
			));
		$this->loadModel("projectTask");
		$this->loadModel("projectStudentTaskDoc");
		$isInAnyProject = $this->projectTask->find("count",array(
		"conditions"=>"projectTask.refer_file_id = ".$fileId)
		);
		$isInAnyProject1 = $this->projectStudentTaskDoc->find("count",array(
		"conditions"=>"projectStudentTaskDoc.refer_file_id = ".$fileId)
		);
		$anyPrjCnt = $isInAnyProject+$isInAnyProject1;
		 
		$this->set("anyPrjCnt", $anyPrjCnt);
		$this->set("fileId", $fileId);
		$this->set("numberOfVersions", $numberOfVersions);
	}
	/**
	* It is used to send the categories data in files page
	* @return : json formatted data
	*/
	function getCategories()
	{
		Controller::disableCache();
		$userId = $this->Session->read("userid");
		$res = $this->userFile->getCategories($userId);
		//$this->RequestHandler->respondAs('json'); 			
		$response = array();
		if(isset($res[0]['fileCategory']['id']))
		{
			foreach($res as $rec)
			{
				$response[$rec['fileCategory']['id']."_".$rec['fileCategory']['title']] = $rec['fileCategory']['title'];
			}
		}
		echo json_encode($response);
		$this->autoRender = false;
		die;
	}
	/**
	 *  Download a file according to a given fiel ID.
	 */
	function downloadFile($id)
	{
	 
     	global $videoArray;
		$fileArray = $this->userFile->find('first', 
		array(
		"fields"=>"fileType.type, userFile.id, userFile.name, userFile.file_name, userFile.created_by, userFile.version_of",
		"conditions"=>"userFile.id = ".$id,
		"joins"=>array(
					array("type"=>"inner",
					"table"=>"file_types",
					"alias"=>"fileType",
					"conditions"=>array("fileType.id = userFile.file_type_id")),
					)
				)
		); 
		if(isset($fileArray['userFile']['id']))
		{	
			$path = "files/";
			$userRec = $this->User->findById($fileArray['userFile']['created_by'], "admin_id");
			if($userRec['User']['admin_id'] != 0)
			{
				$path.=$userRec['User']['admin_id']."/";
			}
			$path.= $fileArray['userFile']['created_by']."/";;
			if($fileArray['userFile']['version_of']!=0)
			{
				$path.= $fileArray['userFile']['version_of']."/";
			}
			if(in_array(strtolower($fileArray['fileType']['type']), $videoArray))
			{
				$path.= "video/";
			}
			$path.= $fileArray['userFile']['name']; 
			App::import('Vendor', 's3', array('file' => 's3'.DS.'sdk.class.php')); 
			$buket = MAIN_BUCKET;
			$obj = new AmazonS3(AMAZON_S3_KEY, AMAZON_S3_SECURITY_KEY);
			
			$response = $obj->get_object($buket, $path);
		 	 
			$mim = mime_content_type_update($fileArray['userFile']['name']) ;
			/*$response = $obj->get_bucket_filesize($buket, true);*/		 
 			if ($response->isOK()) 
			{			
				if($response->status == 200)	
				{
					header('Content-Description: File Transfer');
				    header('Content-Type: '.$mim);//$response->header['content-type']);
				    header('Content-Disposition: attachment; filename='.basename($path));
				    header('Content-Transfer-Encoding: binary');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				    header('Pragma: public');
				   // header('Content-Length: ' . filesize($file));
				    ob_clean();
				    flush();
				    echo $response->body;
				}
				else 
				{
					echo "File not found1.";
				}
				die;
			}
			else {
				 echo "File not found2.";
			}
 		}
		die;
	}
		/**
	 *  Add a file Category
	 */
	function addEditCategory($cat_id=Null)
	{
	   	if($this->request->data)
 		{ 
 			$result = $this->fileCategory->validatCatForm($this->request->data['fileCategory'], $this->Session->read('userid'));
 			$response = array();
 	 		if($this->fileCategory->err==0)						
 			{
 				//we will add department
 				$this->request->data['fileCategory']['created_by'] = $this->Session->read('userid');
	 			if(!isset($this->request->data['fileCategory']['cat_id']) || $this->request->data['fileCategory']['cat_id']=='')	
 				{
 					$this->fileCategory->id = -1;
 					$this->fileCategory->Save($this->request->data); 					 
 					$response['success'] = MSG_CAT_CREATED;
 			    	$response['id'] = $this->fileCategory->getLastInsertId();

 				}
 				else 
 				{ 					
 					$this->fileCategory->id = $this->request->data['fileCategory']['cat_id'];
 					$this->fileCategory->Save($this->request->data); 					 
 				 	$response['success'] = MSG_CAT_UPDATED;
 				 	$response['id'] = $this->request->data['fileCategory']['cat_id'];

 				} 				 				
 			}
 			else 
 			{
 	 			$response['error'] = $this->fileCategory->errMsg;
 			}
 			$this->RequestHandler->respondAs('json'); 			
 			echo json_encode($response);
 			$this->autoRender = false;         
 			die;   
 	 	}
 		else 
 		{
 			if(!isNull($cat_id) && $cat_id!='')
 			{
 				$data = $this->fileCategory->find('first', 
 					array(
 					"conditions"=> "created_by =". $this->Session->read('userid')." AND id= ".$cat_id,
 					"fields"=>"fileCategory.id, fileCategory.title"
 					)
 				);
 				$this->request->data = $data;
 				$this->set("data", $data);
 			}
	 		$this->set('cat_id',$cat_id);	
	 		
 		}
		 $this->render("add_edit_category","ajax");
	}
	function getMyCategories()
	{
		$userId = $this->Session->read("userid");
		 $res = $this->userFile->getCategories($userId);
		//$this->RequestHandler->respondAs('json');
	 	$this->set("fileCategories", $res);
	 	$this->render("get_my_categories", "ajax");
	}
	function test()
	{
		$path = "files/1/4";
		$dest = "files/man/4/";
		App::import('Vendor', 's3', array('file' => 's3'.DS.'sdk.class.php')); 
		$buket = MAIN_BUCKET;
		$obj = new AmazonS3(AMAZON_S3_KEY, AMAZON_S3_SECURITY_KEY);
		$response = $obj->copy_object(array("bucket"=>$buket, "filename"=>$path), array("bucket"=>$buket, "filename"=>$dest) );
		print "<pre>";
		print_R($response);
		print "</pre>";
		die;
		/*$response = $obj->get_bucket_filesize($buket, true);*/
	 	if ($response->isOK()) 
		{
			return true;
		}
	}
}
