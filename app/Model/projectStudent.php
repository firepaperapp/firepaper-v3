<?php
/**
 * This clas file will be used for the project's task table related modules
 * Specfically used in the projects controller
 */
class projectStudent extends AppModel {
	   var $name = 'projectStudent';
	   var $useTable= "project_students";
	   var $errMsg=array();
	   var $err=0; 
	   var $belongsTo = array(
        'Project' => array(
            'className'    => 'Project',
            'foreignKey'    => 'project_id'
        	)
   		 );
   	  function getProjectsForMarking($filters="")
	  {
	  		$this->unbindModel(array("belongsTo"=>array("Project")));
		  	$projects = $this->find("all",array(
			"fields"=>"projectStudent.submitted_date, projectStudent.marked, Project.title, Project.id, Subject.title, User.id, User.firstname, User.lastname",		
			"conditions"=>$filters,
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
	 	 		),
	 	 		array(
	 	 		"type"=>"inner",
	 	 		"table"=>"users",
	 	 		"alias"=>"User",
	 	 		"conditions"=>"User.id = projectStudent.user_id"
	 	 		)  	 	
	 	 	),
	 	 	"order"=>"projectStudent.submitted_date DESC"		
			));	
			
			return $projects;
	  }
 
}
?>