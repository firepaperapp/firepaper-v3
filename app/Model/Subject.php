<?php
	class Subject extends AppModel {
	   var $name = 'Subject';
	   var $useTable= "subjects";
	   var $errMsg=array();
	   var $err=0;
		/*
			Called from cake_login controller to get valid user data
			@param1 Username
			@param2 Password
		*/


	/******************** Validate the Subject form ***************************************/
	function validateSubjectForm($postArray)
 	{
   		if(isNull($postArray['title']))
		{
	    	$this->errMsg[] = ERR_SUBJECT_TITLE_EMPTY;
			$this->err=1;
		}
		else 
		{
 
	 		$find = " Subject.title = '".add_Slashes(trim($postArray['title']))."'";

			if(isset($postArray['dept_id']) && $postArray['dept_id']!='')
			{
				$find.=" and Subject.department_id = ".$postArray['dept_id'];
			}	

			if(isset($postArray['subject_id']) && $postArray['subject_id']!='')
			{
				$find.=" and Subject.id = '".$postArray['subject_id'];
			}

		
		 	$result = $this->find('count',array("conditions"=>$find)); 
	 		if($result > 0)
			{
				$this->errMsg[] = ERR_SUBJECT_TITLE_EXISTS;
				$this->err=1; 
			}
		}
		return $this->err;
 	} 

 }// class ends
?>
