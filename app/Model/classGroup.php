<?php
	class classGroup extends AppModel {
		   var $name = 'classGroup';
		   var $useTable= "class_groups";
		   var $errMsg=array();
		   var $err=0;
		   var $groupId;
		/**
		 * Used to validate the creation of group before insertion
		 *
		 * @param unknown_type $postArray : poseted data
		 * @return unknown
		 */
	 	function validateGroup($postArray)
	 	{
	 		 
	 		if (!isset($postArray['title']) || empty($postArray['title'])) 
	 		{
	            $this->errMsg[] = ERR_CLASS_EMPTY;
	            $this->err = 1;
	        }
	        else { 
	        if($postArray['parentGroup']!="")
			{
				 // We will check if the same group name already exist within selected group
				$cCount = $this->find('count', array("conditions"=>"classGroup.parent_id = ".$postArray['parentGroup']." and classGroup.title= '".$postArray['title']."'"));
				if($cCount>0)
				{
					$this->errMsg[] = CLASS_GROUP_EXISTS;
		            $this->err = 1;
				}
			}
			else 
			{
				 $cCount = $this->find('count', array("conditions"=>"classGroup.created_by = '".$postArray['created_by']."'  and classGroup.title= '".$postArray['title']."'"));
				 if($cCount>0)
				 {
					$this->errMsg[] = YEAR_GROUP_EXISTS;
		            $this->err = 1;
				 }
			}}
	        return $this->err; 
	 	}
	 	function saveData($postArray)
	 	{
 
	 		$data = array();				
	 		$data['title'] = $postArray['title'];
	 		$data['created_by'] = $postArray['created_by'];
	 		$data['admin_id'] = $postArray['admin_id'];
			if($postArray['parentGroup']!="")
			{
				$data['group_type'] = "class";
				$data['parent_id'] = $postArray['parentGroup'];
			}
			else 
				$data['group_type'] = "year"; 
			
			$this->Save($data);
			
			$groupId = $this->getLastInsertId();	
			$this->groupId = $groupId;
			if((isset($postArray['student']) && count($postArray['student'])>0) || (isset($postArray['otherGroups']) && count($postArray['otherGroups'])>0))		
			{
				$postArray['group_id'] = $groupId;				
				//Save in students table
				if(isset($postArray['student']) && count($postArray['student'])>0)
				{
					$query = "INSERT INTO classgroup_students(group_id, user_id, added_by) values";
					foreach($postArray['student'] as $key=>$val) 
					{
						$query.= "(".$postArray['group_id'].", ".$val.", ".$postArray['created_by']."),";
					}
					$query = substr($query, 0, -1);
					try {
	 				$this->query($query);
					}
					catch(Exception $e)
					{
						$this->errMsg[] = ERR_FAILED;
						 $this->err = 1;
					}
				}
				if(isset($postArray['otherGroups']) && count($postArray['otherGroups'])>0)
				{
					$query = "INSERT INTO classgrp_linkedgrps(group_id, user_id, added_by) values";
					foreach($postArray['student'] as $key=>$val) 
					{
						$query.= "(".$postArray['group_id'].", ".$val.", ".$postArray['created_by']."),";
					}
					$query = substr($query, 0, -1);
					try {
					$this->query($query);
					}
					catch(Exception $e)
					{
						$this->errMsg[] = ERR_FAILED;
						$this->err = 1;
					}
				}
				
			}
			 
	 	}
 
	}
?>