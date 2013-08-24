<?php
	class DepartmentTeacher extends AppModel {
	   var $name = 'DepartmentTeacher';
	   var $useTable= "department_teachers";
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
 	}
?>
