<?php
/*
	PROJECT MANAGER: HARPREET SINGH
	LAST MODIFIED: 6 Sep 2010
	AUTHOR: MRK
	*Challege Question retrieval, add, edit, delete
*/
class Country extends AppModel {
	var $name='Country';
	var $useTable= "countries";
	var $errMsg=array();
	var $err=0;



	function getCountries()
	{
	
		$countries = $this->find('list', array(
		'fields' => array('Country.name', 'Country.name'),
		));

		return $countries;
	}

	//Association(JOin) b/w Admin & MOdules

	/*
		Called from cake_login controller to get valid user data
		@param1 Username
		@param2 Password
	*/

}//End-class
?>