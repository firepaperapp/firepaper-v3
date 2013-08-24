<?php
class AddJsCssHelper extends Helper
{
  var $_library; //static array of files to be included            
  var $helpers=array('html','javascript');
   function __construct()
   {
	   static $library;  //for php4 compat
	   $this->_library=& $library;              
	   $this->_library=array();             
   }
  
   /**
	* Adds a javascript file to array
	* @param string $file File to be included
	* @param type $type css | js
	*/
   function register($file,$type)
   {
	   if (! in_array($type,array('css','js'))){
			die("AddJsCss: Incorrect type: $type");           
	   }
	   if (! in_array(array($file,$type),$this->_library)){
		   $this->_library[]=array($file,$type);
	   }
	 }

/**
 * Creates all the links to the files registered
 * @return string
 */          
   function print_registered()
   {
	  foreach ($this->_library as $l)
	  {
		  $file=$l[0];
		  $type=$l[1];
		  switch ($type)
		  {
			  case 'css':
				  echo $this->html->css($file)."\n";   
				  break;
			  case 'js':
				  echo $this->javascript->link($file)."\n";
				  break;
		  }//End switch
	  }//End foreach            
   }//EF  
   
}//End class
?>