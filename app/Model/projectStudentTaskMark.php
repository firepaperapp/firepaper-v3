<?php
/** 
 * This class file will be used for the project's discussion project_student_task_marks table related modules
 * It will be used whenever student submit a task in the project and if teacher assign marks in the tasks
 * Specfically used in the projects controller
 */
class projectStudentTaskMark extends AppModel {
	   var $name = 'projectStudentTaskMark';
	   var $useTable= "project_student_task_marks";
	   var $errMsg=array();
	   var $err=0; 
	   
	  //Evertime user submit a task, we will update the record for marking
	  
	  function updateRecord($data)
	  {
	  		$recsCnt = $this->find("first", array(
	  		"conditions"=>"projectStudentTaskMark.task_id = ".$data['task_id']." and projectStudentTaskMark.user_id = ".$data['user_id']
	  		));
	  		if(count($recsCnt)>0 && isset($recsCnt['projectStudentTaskMark']['id']))
	  		{
	  			$this->id = $recsCnt['projectStudentTaskMark']['id'];
	  		}
	  		else 
	  		{
	  			$this->id = -1;
	  		}
	  		$data['marked'] = 0;
	  		$data['submitted_date'] = date("Y-m-d H:i:s");
	  		$this->Save($data);
	  }
}
?>