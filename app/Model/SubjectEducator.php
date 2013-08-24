<?php
	class SubjectEducator extends AppModel {
	   var $name = 'SubjectEducator';
	   var $useTable= "subject_educators";
	   var $errMsg=array();
	   var $err=0;

	   var $belongsTo = array(
			'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        	)
   		 );

		
	/****************************** get all the educators that are already added to a subject*******************************/

	function getAddedUsers($subject_id)
 	{
 		$query = "SELECT GROUP_CONCAT( user_id ) as addedusers
					FROM subject_educators
					WHERE subject_id = ".$subject_id."
					GROUP BY subject_id
					";
		$rs = $this->query($query);
		return $rs;
 	}

	function deleteEducatorFromSubject($userId,$subjectID)
	{
		$query = "Delete from subject_educators where user_id = $userId AND subject_id = $subjectID";
		$rs = $this->query($query);
		return $rs;
	}

		
 	}
?>