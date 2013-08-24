<?php
/*
	PROJECT MANAGER: HARPREET SINGH
	LAST MODIFIED: 6 DEC 2010
	AUTHOR: MRK
	*State retrieval, add, edit, delete
*/
class State extends AppModel {
	var $name='State';
	var $useTable= "states";
	var $errMsg=array();
	var $err=0;

	//Association(JOin) b/w Admin & MOdules

	/*
		Called from cake_login controller to get valid user data
		@param1 Username
		@param2 Password
	*/
	function getTimeZones()
	{
		$sQuery = "SELECT tz.gmt, tz.name FROM timezones tz";
		$rsResult = $this->query($sQuery);
		$arryTz = array();
	 	foreach($rsResult as $rec)
	 	{
	 		$arryTz[$rec['tz']['gmt']] = $rec['tz']['name'];
	 	}
	 	return $arryTz;
	}
}//End-class
?>