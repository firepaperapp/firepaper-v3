<?php
	class projComments extends AppModel {
	   var $name = 'projComments';
	   var $useTable= "project_comments";
	   var $errMsg=array();
	   var $err=0;
	   var $userId = "";
		var $userType = "";
		var $filters = "";
	    /**
	    * It is used to get the comments who are sent and received by the user for his uploaded docuemnt
	    * It is used in the userDocumentComments function
	    * @param int $taskId
	    * @param int $userId
	    * @return Added Comments array
	    */
	   function getTasksComments($taskId, $userId)
	   {
	   		$data = $this->find('all', array(
	   		"conditions"=> "projComments.student_doc_id = $taskId and (received_by = ".$userId." OR posted_by = ".$userId.") ",
	   		"fields"=>"projComments.*, User.firstname, User.lastname,User.profilepic",
	   		"joins"=>array(
					array("type"=>"inner",
					"table"=>"users",
					"alias"=>"User",
					"conditions"=>array("User.id = projComments.posted_by")),
					),
			"order"=>"id DESC"
				)
	   		);
     		return $data;
	   }
	   function makeQueryComments($userid, $user_type, $limit= "", $fieldOrCnt=false)
		{
	 		if($fieldOrCnt == true)
			{
				$fieldOrCnt = " count(User.id) as cnt";
			}
			else 
			{
				$fieldOrCnt = "ts.*, User.firstname, User.lastname, User.id,User.username, fileType.icon,User.profilepic";
			}
			$query ="
				SELECt $fieldOrCnt FROM
				(";
			//If user is a student then we will get all the comments are who are made on a project by the admin of the project, in this case received by will be Null
			if(in_array($user_type, array(4,5)))
			{
				$query.="
					(
						SELECT project_comments.created, posted_by, comment, '' as refer_file_id, '' as file_type_id, Project.id as project_id, Project.title as project_title 
						FROM project_comments 
						INNER JOIN projects as Project ON Project.id = project_comments.project_id
						INNER JOIN project_students as ps ON ps.project_id =  project_comments.project_id and ps.user_id = ".$userid."
						WHERE Project.published = 1 AND ( received_by is NULL OR received_by =".$userid.") 
						".$this->filters."
						ORDER BY created DESC						
			 		)
					";
			}
			else 
			{
				//we will comments posted by the student to project admin
				$query.="
				(SELECT project_comments.created, posted_by, comment, '' as refer_file_id, '' as file_type_id, Project.id as project_id, Project.title as project_title 
						FROM project_comments 
						INNER JOIN projects as Project ON Project.id = project_comments.project_id						WHERE Project.published = 1 AND (received_by =".$userid." || admin_ids LIKE '%,".$userid.",%') and ( comment_type='prjComment' OR comment_type='task')
						".$this->filters."
						ORDER BY created DESC	
				)UNION			
				  (
					  SELECT  project_comments.created, posted_by, comment, refer_file_id, file_type_id, Project.id as project_id, Project.title as project_title 
					  FROM project_comments
					  INNER JOIN projects as Project ON Project.id = project_comments.project_id
					  INNER JOIN project_student_task_docs ON project_student_task_docs.id =  project_comments.student_doc_id				  
					  WHERE Project.published = 1 AND  ( received_by = ".$userid." || admin_ids LIKE '%,".$userid.",%') and comment_type='studentdoc'
					  ".$this->filters."
					  ORDER BY created DESC
				  )";
		
			}
			if($this->filters=="")
			{
			$query.="								
				UNION
				(
				SELECT  created, created_by as posted_by, comment, '' as refer_file_id, '' as file_type_id,'' as project_id, '' as project_title
				FROM whiteboard_comments
				WHERE received_by = ".$userid."
				ORDER BY created DESC
	 			)
			";
			}
			$query.=") as ts
			
			INNER JOIN users as User On User.id = posted_by
			LEFT JOIN file_types as fileType ON fileType.id = file_type_id 
			ORDER BY ts.created DESC
			$limit
				";
		 
			return $query;
		}
	    function paginateCount($conditions = null, $recursive = 0, $extra = array()) 
	    {	    	 
	    	if(isset($conditions['findUnion']))
	    	{
	    		$sql = $this->makeQueryComments($this->userId, $this->userType,"",true);
	   			$results = $this->query($sql);	   			 
				return $results[0][0]['cnt'];			 
	    	}
	    	else {
	    		return $this->find("count", $conditions); 
	    	}			
		}
		function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) 
		{
			if(isset($conditions['findUnion']))
	    	{
	    		if($page ==0)
	    			$page =1;
	    			$pLimit = ' LIMIT '.($page-1)*$limit.','.$limit; 
	    		 
	    		
	    		$sql = $this->makeQueryComments($this->userId, $this->userType, $pLimit);
	   			$results = $this->query($sql);
				return $results;			 
	    	}
	    	else {
	    		return $this->find("all",$conditions, $fields, $order, $limit, $page,
$recursive, $extra); 
	    	}
		}
	}
?>