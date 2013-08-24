<?php
App::uses('Sanitize', 'Utility');
class SearchController  extends AppController{

	var $name = 'Search';

	var $uses = array('Search');

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
	 * @uses This function is used to render the homepage view
	 * @input NULL
	 * @returns NULL
	 */

	function index(){ 
 		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
		$this->Session->delete('search');
 		$this->render("index");
	}
	function searchContent()
	{
		$limit = 5;//PAGE_LIMIT;
		$filter = "";
		$userid = $this->Session->read('userid');
		/***************************Start Setting Search Parameters*********************/
		if(!empty($this->request->data) && isset($this->request->data['search']['posted']))
     	{	
 	 		$searched = $this->request->data;
     	}
	    elseif($this->Session->check('search'))
	        $searched['search'] = $this->Session->read('search');
	
		
	    $dataGot = array();
	    if(isset($searched) && count($searched)>0) 
	    {
	    	$searched['search']['title'] = str_replace("/","",$searched['search']['title']);
	    	$searched['search']['title'] = str_replace("\\","",$searched['search']['title']);
	    	
	    	if($searched['search']['title']!='')
	    	{
				$myReg = "/([^\w\^])+/i";//\w=[a-z0-9_]	
				//$mystr = "alok%diwan*good#^butalsodog_";	
				
				$filter =  preg_replace($myReg,"[$1]", $searched['search']['title']);
				$filter = str_replace('"','\"',$filter); 
				
	 		   	$admin_id = $this->getAdminId(); 
	   	        $this->Session->write($searched);
		   		$this->Search->filters  = $filter;
		   		$this->Search->userId = $userid;
				$this->Search->userType = $this->Session->read('user_type');
				$this->Search->admin_id = $admin_id;
				$this->paginate = array('Search'=> array(
				"conditions"=>"findUnion",
				"limit"=>$limit
				)
				);
				
				$dataGot = $this->paginate('Search');	 
	    	}
	    }
	  
 	   /***************************End Setting Search Parameters*********************/  
 	    $totalPages = isset($this->request->params['paging']['Search']['pageCount'])?$this->request->params['paging']['Search']['pageCount']:"";		
   		$order = isset($this->request->params['paging']['Search']['options']['order'])?$this->request->params['paging']['Search']['options']['order']:"";
   		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:1;
   	 	$this->set('page', $page);
   		$this->set('limit', $limit);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
 		$this->set("data", $dataGot);  
 		$this->set("filters", $filter);  
 		$this->render("search_content", "ajax");
	}
}
