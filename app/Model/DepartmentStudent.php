<?php
	class DepartmentStudent extends AppModel {
	   var $name = 'DepartmentStudent';
	   var $useTable= "department_students";
	   var $errMsg=array();
	   var $err=0;
		/*
			Called from cake_login controller to get valid user data
			@param1 Username
			@param2 Password
		*/
		var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        	)
   		 ); 
   		 
   		 function getStudents($dept_id)
   		 {
				$query = "SELECT User.id, User.firstname, User.lastname, classGroup.id, classGroup.title 
				FROM department_students DepartmentStudent
				INNER JOIN users User ON User.id = DepartmentStudent.user_id
				LEFT JOIN classgroup_students classgroupStudent ON classgroupStudent.user_id = DepartmentStudent.user_id
				INNER JOIN class_groups classGroup ON classGroup.id = classgroupStudent.group_id
				WHERE DepartmentStudent.department_id = ".$dept_id."
				ORDER BY User.id";
				$res = $this->query($query);
				return $res;
   		 	
   		 }
 	}
?>