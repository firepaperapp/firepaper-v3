<?php
/**
 * This clas file will be used for the project's task table related modules
 * Specfically used in the projects controller
 */
class projectTask extends AppModel {
	   var $name = 'projectTask';
	   var $useTable= "project_tasks";
	   var $errMsg=array();
	   var $err=0; 
	  /**
	   * TO get the file type icons 
	   *
	   * @return array
	   */
	  function getFileTypes()
	  {
	  		$qry = "SELECT fileType.id, fileType.icon FROM  file_types as fileType";
	  		$res = $this->query($qry);
	  		return $res;
	  }
}
?>