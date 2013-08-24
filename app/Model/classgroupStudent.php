<?php
	class classgroupStudent extends AppModel {
		   var $name = 'classgroupStudent';
		   var $useTable= "classgroup_students";

		   var $belongsTo = array(
			'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        	)
   		 );

	function getAddedUsers($groupId)
 	{
 		$query = "SELECT GROUP_CONCAT( user_id ) as addedusers
					FROM classgroup_students
					WHERE group_id = ".$groupId."
					GROUP BY group_id
					";
		$rs = $this->query($query);
		return $rs;
 	}

}
?>
