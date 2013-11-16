<?php
App::uses('Sanitize', 'Utility');
class HomeController extends AppController{

	var $name = 'Home';

	var $uses = array('UserType');

	//var $helpers = array('Html', 'Form', 'Time','Js','Flash');
	//var $components = array('Facebook','Email');
	  /**
	 * Determines if user will have option to set a cookie based login.
	 *
	 * @access public
	 * @var boolean
	 */
	var $allowCookie = TRUE;

	 /**
	 * Determines length of cookie lifespan.
	 * Use string based date syntax, since strtotime will be applied to value.
	 *
	 * @access public
	 * @var string
	 */
	var $cookieTerm = '+4 weeks';

    var $allowedActions = array('logout');


	function beforeFilter()
	{
 		parent::beforeFilter();
	}

    /**
	 * Checks for allowCookie value and sets proper view value.
	 *
	 * @returns NULL
	 */
    function __configureAuthCookie(){
	    if($this->allowCookie){
	    	  // this prevents the remember_me option from appearing in the user login form
			$this->set('remember_me', False);
		} else {
			  $this->set('remember_me', FALSE);
		}
	}
	/**
	 * @uses This function is used to render the homepage view
	 * @input NULL
	 * @returns NULL
	 */

	function display(){ 
		if(defined("HTTP_HOST"))
		{
			 $subdomain = substr( env("HTTP_HOST"), 0, strpos(env("HTTP_HOST"), ".") );
			 
			if(strlen($subdomain)>0 && $subdomain != "www" && isNull($this->Session->read("userid"))) 
			{
				$this->redirect("http://www.".HTTP_HOST."/");
			}
		}
		$userTypes = $this->UserType->find('list',
			array(
			"fields"=>"UserType.id, UserType.title",
			"conditions" => array("UserType.cansignup = 1", "UserType.title" => 'Educator Account')));
		$this->set("userTypes", $userTypes); 
	}
   
}
