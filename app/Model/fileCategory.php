<?php

/*

	PROJECT MANAGER: HARPREET SINGH

	LAST MODIFIED: 6 DEC 2010

	PROJECT LEAD: AMIT LUTHRA

	AUTHOR: MRK

	*State retrieval, add, edit, delete

*/

class fileCategory extends AppModel {

	var $name='fileCategory';

	var $useTable= "files_categories";

	var $errMsg=array();

	var $err=0;



	//Association(JOin) b/w Admin & MOdules

	function validatCatForm($postArray, $sesId)
	{
		if(isNull($postArray['title']))
		{
	    	$this->errMsg[] = ERR_CAT_TITLE_EMPTY;
			$this->err=1;
		}
		else 
		{
 
	 		$find = "fileCategory.created_by = $sesId and  fileCategory.title = '".add_Slashes(trim($postArray['title']))."'";
			if(isset($postArray['cat_id']) && $postArray['cat_id']!='')
			{
				$find.=" and fileCategory.id!= '".$postArray['cat_id']."'";
			}		
		 
			$result = $this->find('count',array("conditions"=>$find));
	 		if($result>0)
			{
				$this->errMsg[] = CAT_TITLE_EXISTS;
				$this->err=1; 
			}
		}
		return $this->err;
	}

 

}//End-class

?>