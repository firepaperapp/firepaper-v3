<?php
	class userFile extends AppModel {
	    var $name = 'userFile';
	    var $useTable= "files";
	    var $errMsg=array();
	    var $err=0;
	    var $userId;
		/*function paginateCount($conditions = null, $recursive = 0, $extra = array()) 
		{
			
		  //query to calculate the count		
		    $count = $this->find('count',
		    							array("conditions"=>"userFile.created_by =".$this->userId." and userFile.version_of = 0")								);
		   	return $count;		
		}*/
		function getIconType($name)
		{
			$query = "SELECT id FROM file_types as fileType WHERE type = '".$name."' LIMIT 0,1";
			$res = $this->query($query);
			if(isset($res[0]['fileType']['id']))
			{
				return 	$res[0]['fileType']['id'];
			}
			else
				return 1;
		}
		function getSubFiles($fileId) 
		{
			$subFiles = $this->find('all', 
	   			array(
	 			"fields"=>"userFile.*, fileType.icon",
	 			"conditions"=>"userFile.version_of =".$fileId,
	 			"joins"=>array(
	 								
	 							array(
	 							"type"=>"inner",
	 							"table"=>"file_types",
	 							"alias"=>"fileType",
	 							"conditions"=>array("fileType.id = userFile.file_type_id")
	 								),
	 									
	 								
	 							)
	 												)
	 							);
			return $subFiles;
		}
		//Used to list the categories created by a user 
		function getCategories($userId)
		{
			$query = "SELECT fileCategory.id,fileCategory.title FROM files_categories as fileCategory WHERE fileCategory.created_by = ".$userId;
			$res = $this->query($query);
			return $res;
		}
		//Used to save the category
		function saveCategory($posted)
		{
			if(count($posted)>0 && isset($posted['value']))
			{
				$data = explode("_", $posted['id']);
				$query = "INSERT INTO files_categories(created_by, title) values(".$posted['created_by'].", '".add_Slashes($posted['value'])."')";
				$this->query($query);
				
				$qry = "SELECT id FROM files_categories as fl WHERE created_by = ".$posted['created_by']." ORDER BY id DESC LIMIT 0,1 ";
				$res = $this->query($qry);
				
				if(isset($res[0]['fl']['id']))
				{
					$query  = "UPDATE files SET category_id=".$res[0]['fl']['id']." WHERE id = ".$data[1];
					$res = $this->query($query);
					return true;
				}
			}
			return false;
		}
		//To validate the file uploaded by the user
		function validateFileUpload($postArray)
		{
			global $videoArray, $filesArray;
			
			if($_SERVER['REMOTE_ADDR'] =='180.188.253.92')
			{
				$getModelName = array_keys($data['data']);
				echo '<pre>'; print_r($getModelName[0]); echo '</pre>';
				exit('stop');
			}
			
			if($postArray['uploadfile']['name']=='' || $postArray['uploadfile']['error']==1 ||  !is_uploaded_file($postArray['uploadfile']['tmp_name']))
			{
				$this->errMsg =  FILE_CANT_UPLOADED;
				$this->err=1;			
			}
			else if($postArray['uploadfile']['size'] > MAX_FILESIZE)
			{
				$this->errMsg= MAX_FILESIZE_MSG;
				$this->err=1;				
			}
			else
			{
				$arFile = explode(".",$postArray['uploadfile']['name']);				
				$string = remove_specialchars($arFile[0]);				
				$fileExt = array_pop($arFile); 
				 
				if(!in_array(strtolower($fileExt), $videoArray) && !in_array(strtolower($fileExt), $filesArray))
				{	 
					$this->errMsg="Please upload valid file.";
					$this->err=1;				
				}
			}
			 
			return $this->err; 
  		}
		
		function checkFileType($data, $inputFile, $fileType=NULL)
		{
			$getModelName = array_keys($data['data']);
			if(!empty($fileType)) {
				$getFileType = $data['data'][$getModelName[0]][$inputFile]['type'];
				if(!in_array($getFileType,$fileType)) {
					$fileTypeError = 'File Type Error';
					return $fileTypeError;
				}
			}
		}
		
		function checkFileSize($data, $inputFile, $fileSize=NULL)
		{
			$getModelName = array_keys($data['data']);
			if(!empty($fileSize))
			{
				$getFileSize = $data['data'][$getModelName[0]][$inputFile]['size']/1024;
				if($getFileSize > $fileSize) {
					$fileSizeError = 'File size Error';
					return $fileSizeError;
				}
			}
		}
		
	}
?>