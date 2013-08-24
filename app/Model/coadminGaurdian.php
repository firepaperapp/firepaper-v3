<?php
	class coadminGaurdian extends AppModel {
		   var $name = 'coadminGaurdian';
		   var $useTable= "coadmin_gaurdians";

		   var $belongsTo = array(
			'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        	)
   		 );


	/************************* function to find all the ids of admin/coadmins ***********/
	
	function getCreatedbyStr($createdbyarr)
	{ 
		if($createdbyarr['adminUser']['user_type_id']==1)
		{
			$coadmins = $this->find('all',
									array("conditions"=> array('parent_id'=>$createdbyarr['adminUser']['id']) , 
										  "fields"=>array('user_id')	
												)
												);

						$adminsIDArr[]=$createdbyarr['adminUser']['id'];
						if(!empty($coadmins))
						{
							foreach($coadmins as $coadminid)
							{
								$adminsIDArr[]=$coadminid['coadminGaurdian']['user_id'];
							}
						}
						$adminsIDStr = implode(',' , $adminsIDArr);		
						return $adminsIDStr;	//string of IDs
		}



		if($createdbyarr['adminUser']['user_type_id']==7) 
		{
			$idArr  = $this->find('all',
									array("conditions"=> array('parent_id'=>$createdbyarr['adminUser']['created_by']) , "fields"=>array('user_id')	
										)
										);

			$adminsIDArr[]=$createdbyarr['adminUser']['created_by'];
			if(!empty($idArr))
			{
				foreach($idArr as $coadminid)
				{
					$adminsIDArr[]=$coadminid['coadminGaurdian']['user_id'];
				}
			}
			$adminsIDStr = implode(',' , $adminsIDArr); 
			return $adminsIDStr;	//string of IDs
		}
	}

}
?>