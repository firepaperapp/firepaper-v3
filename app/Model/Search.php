<?php
/*
	PROJECT MANAGER: HARPREET SINGH
	LAST MODIFIED: 6 DEC 2010
	PROJECT LEAD: AMIT LUTHRA
	AUTHOR: MRK
	*Search results
*/
class Search extends AppModel {
	var $name='Search';
	var $useTable= "payments";
	var $errMsg=array();
	var $err=0;
	var $userId = "";
	var $userType = "";
	var $filters = "";	
	var $admin_id = "";
	
	//Association(JOin) b/w Admin & MOdules
	function makeQuerySearch($fieldOrCnt=false, $limit="")
	{
 		if($fieldOrCnt == true)
		{
			$fieldOrCnt = " count(title) as cnt";
		}
		else 
		{
			$fieldOrCnt = "ts.*";
		}
		$reg = ' REGEXP  "'.$this->filters.'" ';
		$query = "
			SELECT $fieldOrCnt FROM
			(
		";
		//If user is a student then we will get all the comments are who are made on a project by the admin of the project, in this case received by will be Null
		if(in_array($this->userType, array(4,5)))
		{
			$query.="
			(SELECT title, users.id as userid, concat(users.firstname,' ',users.lastname) as name, 'project' as section, projects.id as gotId
			FROM projects 
	 		INNER JOIN project_students as ps ON ps.project_id =  projects.id 
	 		INNER JOIN users on users.id = projects.leader_id
		    WHERE ps.user_id = ".$this->userId." and projects.published = 1 AND title ".$reg.
			"ORDER BY project.id DESC)
			
			UNION
			(SELECT comment  as title, users.id as userid, concat(users.firstname,' ',users.lastname) as name, 'project comments' as section, project_comments.id as gotId
			FROM project_comments 
			INNER JOIN projects as Project ON Project.id = project_comments.project_id
			INNER JOIN project_students as ps ON ps.project_id =  project_comments.project_id and ps.user_id = ".$this->userId."
			INNER JOIN users on users.id = project_comments.posted_by
			WHERE ( received_by is NULL OR received_by = ".$this->userId.") and comment ".$reg." AND Project.published = 1 
			ORDER BY project_comments.created DESC)";
		}
		else 
		{
			//we will comments posted by the student to project admin
			
			$query.="
			(SELECT title, users.id as userid, concat(users.firstname,' ',users.lastname) as name, 'projects' as section, projects.id as gotId
			FROM projects 
	  		INNER JOIN users on users.id = projects.leader_id
	  	    WHERE projects.published = 1 AND ";
	  	    
	  	    if($this->userType ==1 || $this->userType ==7)
			{
				$query .= "projects.admin_id= ".$this->admin_id;
			}
			else if($this->userType == 2 || $this->userType == 3)
			{ 
				$query.="projects.leader_id=".$this->userId;				
			}		
	  	    $query.=' and title REGEXP "'.$this->filters.'"';
			$query.= "ORDER BY project.id DESC)			
			UNION			
			(SELECT comment as title, users.id as userid, concat(users.firstname,' ',users.lastname) as name, 'project comments' as section, project_comments.id as gotId
					FROM project_comments 
					INNER JOIN projects as Project ON Project.id = project_comments.project_id
					INNER JOIN users on users.id = project_comments.posted_by
					WHERE Project.published = 1 AND (received_by =".$this->userId." || admin_ids LIKE '%,".$this->userId.",%') and comment ".$reg."
					ORDER BY created DESC)";
		}
		$query.='
				UNION
				(SELECT title, "" as userid, "" as name, "whiteboards" as section, id as gotId
				FROM whiteboards 
				WHERE created_by = '.$this->userId.' and title '.$reg.' 
				ORDER BY created DESC)				
				
				UNION
				(SELECT comment as title, users.id as userid, concat(users.firstname," ",users.lastname) as name, "whiteboard comments" as section, whiteboard_id as gotId
				FROM whiteboard_comments 
				INNER JOIN users on users.id = whiteboard_comments.created_by
				WHERE (whiteboard_comments.created_by = '.$this->userId.' OR received_by = '.$this->userId.')  and comment '.$reg.'
				ORDER BY whiteboard_comments.created DESC)				
				
		 		UNION
				(SELECT name as title, "" as userid, "" as name, "files" as section, id as gotId
				FROM files 
				WHERE created_by = '.$this->userId.' and name REGEXP "'.$this->filters.'" 
				ORDER BY id DESC)
				) as ts'.$limit;
		return $query;
	}
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) 
    {	    	 
    	if(isset($conditions['findUnion']))
    	{
    		$sql = $this->makeQuerySearch(true);
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
    		 
    		
    		$sql = $this->makeQuerySearch(false, $pLimit);
   			$results = $this->query($sql);
			return $results;			 
    	}
    	else {
    		return $this->find("all",$conditions, $fields, $order, $limit, $page,
$recursive, $extra); 
    	}
	}
 
}//End-class
?>