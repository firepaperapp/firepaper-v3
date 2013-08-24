<?php
	class WhiteboardComment extends AppModel {
	   var $name = 'WhiteboardComment';
	   var $useTable= "whiteboard_comments";
	   var $errMsg=array();
	   var $err=0;
		/*
			Called from cake_login controller to get valid user data
			@param1 Username
			@param2 Password
		*/
		var $belongsTo = array(
        'Whiteboard' => array(
            'className'    => 'Whiteboard',
            'foreignKey'    => 'whiteboard_id'
        	),
		'User' => array(
		'className'    => 'User',
		'foreignKey'    => 'created_by'
		)
   		 ); 
 	}
?>