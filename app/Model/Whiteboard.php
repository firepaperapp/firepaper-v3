<?php 

class Whiteboard extends AppModel
{
	var $name = 'Whiteboard';
	var $useTable= "whiteboards";

	var $belongsTo = array(
			'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'created_by'
        	)
   		 );
}

?>