<?php
	class Department extends AppModel {
	   var $name = 'Department';
	   var $useTable= "departments";
	   var $errMsg=array();
	   var $err=0;
		/*
			Called from cake_login controller to get valid user data
			@param1 Username
			@param2 Password
		*/

 	function validatDepartmentForm($postArray, $sesId="")
 	{
   		if(isNull($postArray['title']))
		{
	    	$this->errMsg[] = ERR_DEPT_TITLE_EMPTY;
			$this->err=1;
		}
		else 
		{
 
	 		$find = "Department.admin_id =$sesId and  Department.title = '".add_Slashes(trim($postArray['title']))."'";
			if(isset($postArray['dept_id']) && $postArray['dept_id']!='')
			{
				$find.=" and Department.id!= '".$postArray['dept_id']."'";
			}		
		 
			$result = $this->find('count',array("conditions"=>$find));
	 		if($result>0)
			{
				$this->errMsg[] = DEPT_TITLE_EXISTS;
				$this->err=1; 
			}
		}
		return $this->err;
 	}
 	function getAddedUsers($departmentId, $table)
 	{
 		$query = "SELECT GROUP_CONCAT( user_id ) as addedusers
					FROM $table
					WHERE department_id = ".$departmentId."
					GROUP BY department_id
					";
		$rs = $this->query($query);
		return $rs;
 	}
	//These functions are related to maintaing count in dashbard and project count
	function insertUserInCountTable($user_id)
	{
		$qry = "INSERT INTO `counts` SET user_id = ".$user_id;
		$this->query($qry);
	}
 }
?>
