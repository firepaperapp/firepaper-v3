<?php
App::uses('Sanitize', 'Utility');
class CommentsController  extends AppController{

	var $name = 'Comments';

	var $uses = array('UserType');

	var $helpers = array('Html', 'Form', 'Time','Js','Flash');
	var $layout = "default_front_inner";
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
	    
	}
	/**
	 * @uses This function is used to render the homepage view
	 * @input NULL
	 * @returns NULL
	 */

	function currentComments(){ 
	 
	 	$this->render("current_comments","ajax");
	}
	 
}
