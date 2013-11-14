<?php
/**
 * This clas file will be used for the projects table related modules
 * Specfically used in the projects controller
 */
class Project extends AppModel {
	   var $name = 'Project';
	   var $useTable= "projects";
	   var $errMsg=array();
	   var $err=0;
	  
	   function getTasks($project_id, $userId, $getMarksAlso = 0)
	   {
	   	 	$stQuery = "SELECT DISTINCT prjTask.project_id, prjTask.title, prjTask.file_name, prjTask.weight, prjTask.id, fileType.icon,prjTask.refer_file_id,	prjTask.created,  docs.title as complete_title, 		
	   		 
	   		(SELECT COUNT(id) FROM project_task_extra_docs WHERE project_task_extra_docs.task_id = prjTask.id)  as extraDocs,
	   		(SELECT COUNT(id) FROM project_comments WHERE project_comments.task_id = prjTask.id
	   		";
	   		
	   		if($getMarksAlso == 1)
	   		{
				$stQuery.= " AND ( project_comments.received_by = ".$userId." OR  project_comments.posted_by = ".$userId." 
				 OR  project_comments.received_by is null)  AND comment_type = 'task'";
	   		
	   		}

	   		$stQuery.=" ) as cnt_comment"; 
	   		
	   		
	   		if($getMarksAlso == 1)
	   		{
	   			$stQuery.=",projectStudentTaskMark.marks";
	   		}
	   		$stQuery.=" FROM project_tasks as prjTask";
	   		if($getMarksAlso == 1)
	   		{
	   			$stQuery.=" LEFT JOIN project_student_task_marks as projectStudentTaskMark ON projectStudentTaskMark.task_id = prjTask.id and user_id = ".$userId." and projectStudentTaskMark.marked=1";	
	   		}
	   			
	   			$stQuery.=" left join project_student_task_docs as docs on docs.task_id=prjTask.id
	   					LEFT JOIN file_types as fileType ON fileType.id = prjTask.file_type_id
	   					WHERE prjTask.project_id = ".$project_id." GROUP BY prjTask.id ORDER BY prjTask.id DESC";

	   		$data = $this->query($stQuery);	  
	   		return $data;
	   }
	   /**
	    * It is used in the viewDetails page
	    * TO get the documents uploaded by the user spceific to a task
	    * @param unknown_type $taskId
	    * @param unknown_type $userId
	    * @return unknown
	    */
	   function getTasksDocsByUser($taskId, $userId)
	   {
	   		$stQuery = "SELECT  prjTaskUserDoc.id, prjTaskUserDoc.title, prjTaskUserDoc.file_name, prjTaskUserDoc.id, prjTaskUserDoc.refer_file_id, fileType.icon, prjTaskUserDoc.submitted_date, prjTaskUserDoc.marks,
	   					(SELECT COUNT(id) FROM project_comments WHERE project_comments.student_doc_id = prjTaskUserDoc.id and (received_by = ".$userId." OR posted_by = ".$userId.") ) as cnt_comment
	   					FROM project_student_task_docs as prjTaskUserDoc
	   					LEFT JOIN file_types as fileType ON fileType.id = prjTaskUserDoc.file_type_id
	   					WHERE prjTaskUserDoc.task_id = ".$taskId." and prjTaskUserDoc.user_id = ".$userId;
	   		$data = $this->query($stQuery);
	   		return $data;
	   }
	  /**
	   * Validate the create a project form
	   */
	  function validatProjectForm($postArray)
	  {
	  		if (!isset($postArray['title']) || empty($postArray['title'])) {
            $this->errMsg[] = ERR_PROJTITLE;
            $this->err = 1;
	        }
	        else if (!isset($postArray['description']) || empty($postArray['description'])) {
	            $this->errMsg[] = ERR_PROJ_DESC;
	            $this->err = 1;
	        }
	        else if (!isset($postArray['subject_id']) || empty($postArray['subject_id'])) {
	            $this->errMsg[] = ERR_SUBJECT;
	            $this->err = 1;
	        }
	        else if (!isset($postArray['duedate']) || empty($postArray['duedate'])) {
	            $this->errMsg[] = ERR_PROJSUE_DATE;
	            $this->err = 1;
	        }
	        else if (!isset($postArray['leader_id']) || empty($postArray['leader_id'])) {
	            $this->errMsg[] = ERR_PROJ_LEADER;
	            $this->err = 1;
	        }	        
	       return $this->err;
	  }
	  /**
	   * * To get the latest project for educators and admins
	   */
	  function getLatestProjects($filters, $latest =1)
	  {
	  		$con = "";
	  		if($latest == 1)
	  			$con = " and date_format(Project.duedate, '%y-%m-%d')>=curdate()";
	  		$currentProjects = array(
	 	 	"conditions"=> $filters." Project.published = 1 ".$con,
	 	 	"fields"=>"Project.*, User.profilepic, User.firstname, User.lastname, (SELECT SUM(weight) FROM project_tasks WHERE project_tasks.project_id = Project.id) as completed, (SELECT COUNT(id) FROM project_student_task_docs as pstdo WHERE pstdo.project_id = Project.id) as noOfFiles, (SELECT COUNT(id) FROM project_comments  as psc WHERE psc.project_id = Project.id) as noOfComments, Subject.title",
	 	 	"order"=>"Project.duedate asc",
	 	 		"joins"=>array(	 	 		 
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"subjects",
	 	 		"alias"=>"Subject",
	 	 		"conditions"=>"Subject.id = Project.subject_id"
	 	 		),
				array(
	 	 		"type"=>"inner",
	 	 		"table"=>"users",
	 	 		"alias"=>"User",
	 	 		"conditions"=>"User.id = Project.leader_id"
	 	 		) 
	 	 	),
	 	 	"limit"=>"10"
	 	 	);	
	 	 	return $currentProjects;
	  }
	  function getLatestProjectsForUser($filter, $latest =1)
	  {
	  		$con = "";
	  		if($latest == 1)
	  			$filter .= " date_format(Project.duedate, '%y-%m-%d')>=curdate() AND ";
	  		$currentProjects = array(
	 	 	"conditions"=>$filter." Project.published = 1  AND projectStudent.completed = 0",
	 	 	"fields"=>"Project.*, User.*, (SELECT SUM(weight) FROM project_tasks INNER JOIN project_student_task_marks ON project_student_task_marks.task_id = project_tasks.id WHERE project_tasks.project_id = Project.id) as completed, (SELECT COUNT(id) FROM project_student_task_docs as pstdo WHERE pstdo.project_id = Project.id) as noOfFiles, (SELECT COUNT(id) FROM project_comments  as psc WHERE psc.project_id = Project.id) as noOfComments, Subject.title",
	 	 	"order"=>"Project.duedate asc",
	 	 	"joins"=>array(
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"projects",
	 	 		"alias"=>"Project",
	 	 		"conditions"=>"Project.id = projectStudent.project_id"
	 	 		) 	,
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"subjects",
	 	 		"alias"=>"Subject",
	 	 		"conditions"=>"Subject.id = Project.subject_id"
	 	 		)  	
	 	 		,
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"users",
	 	 		"alias"=>"User",
	 	 			"conditions"=>"User.id = Project.leader_id"
	 	 		) ,
			
				
	 	 	), 
			"group"=>"Project.id",		 	 	
	 	 	"limit"=>"10"
	 	 	);
	 	 	return $currentProjects;
	  }
	  
	  
	   function getProjectCompleted($project_id)
	  {
	  
	  	$stQuery=" select count(distinct tasks.id) as total,count(distinct docs.task_id) as task_count from projects left join project_tasks as tasks on tasks.project_id=projects.id left join project_student_task_docs as docs on docs.project_id=projects.id and tasks.id=docs.task_id  where projects.id=".$project_id." limit 1";
	  	$data = $this->query($stQuery);
	   		return $data;
	  }
	  
}
?>
