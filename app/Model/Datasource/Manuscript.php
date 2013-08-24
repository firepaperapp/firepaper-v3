<?php
	class Manuscript extends AppModel {
	   var $name = 'manuscripts';
	   var $errMsg=array();
	   var $err=0;

	   function getStages(){
	   		$arrStages = array();
			$query = "SELECT * FROM stages ";
			$rs = mysql_query($query);
			while($row =  mysql_fetch_array($rs,MYSQL_ASSOC)){
				  $arrStages[] = 	$row;
			}
		   return $arrStages;
	   }

	}
?>