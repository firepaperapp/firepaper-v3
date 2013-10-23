<?php
App::uses('Sanitize', 'Utility');
class UsersController extends AppController{

	var $name = 'Users';
	var $uses = array('User','State','Package','Country','Payment','Department','coadminGaurdian','projComments','Project','classgroupStudent', 'projectStudent','UserType');
	var $layout = "default";
	var $helpers = array('Flash');
	var $components = array('RequestHandler','Paypal','Email','GeneralFunction');
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
	 * @uses It is used to draw the captcha image in signup step1 form
	 * @input NULL
	 * @returns NULL
	 */
    function create_captcha()	
    {
		App::import("Component","Captcha"); //including captcha class
		$this->Captcha =  new CaptchaComponent(new ComponentCollection()); //creating an object instance
		$this->Captcha->controller = &$this; //assign this conroller(CaptchaController) object to its captcha object's controller property.
		$this->set('captcha_src', $captcha_src=$this->Captcha->create()); //create a capthca and assign to a variable
		
		
	}
	
	/**
	 * @uses This function is used to render the sign up step1 form
	 * @input NULL
	 * @returns NULL
	 */
	
	function step1($user_type="", $trialpack = 0)
	{ 
 		if(isUserLoggedIn($this->Session, "userid"))
		{
			if($this->Session->read("user_type")==6)
			{
				$this->redirect("/users/viewProfile");
			}
			else
			{ $this->redirect("/dashboard"); }
		}
		if(isNull($user_type) && isNull($this->request->data['User']['user_type_id']))
		{
			$this->redirect("/");
		}
		if(isset($this->request->data['User']) && count($this->request->data['User'])>0)
		{
			$capCode = $this->Session->read('ver_code');
			$isErr = $this->User->validateUserForm($this->request->data['User'],$capCode);
	 		if($isErr==0)						
			{
 				//User has successfully completed the sign up step1 process
				//proceed to signup step2, it will be a https page later
				$userData['registerUserData'] = $this->request->data['User'];
				$this->Session->write($userData);
				$this->redirect("/signup/step2");
 			}
 		 	$this->set('errMsg',$this->User->errMsg);
		}
  		global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();
 		$this->set("timezones",$timezones);
 		$this->set("trialpack",$trialpack);
 		$this->set("user_type",$user_type);
		$this->set("defaultTimeZone",$defaultTimeZone);
		$this->create_captcha();
	}
	/**
	 * @uses This function is used to render the sign up step1 form
	 * @input NULL
	 * @returns NULL
	 */
	
	function step2()
	{	
		if(isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/dashboard");
		}
		
 		if(!$this->Session->read("registerUserData")){
 			$this->redirect("/");
 			
 		}
  		global $cardTypes;
 		$countries = $this->Country->find('list', array(
		'fields' => array('Country.name', 'Country.name'),
		));

		$states = $this->State->find('list', array(
		'fields' => array('State.abbrev', 'State.name'),
		));
		
 		//we will get the package for the user
 		$selectedUserType = $this->Session->read("registerUserData.user_type_id");	
 		 
		/*$pkg = $this->Package->find('first',
		array("conditions"=> "Package.active = 1 and Package.user_type_id = '".$selectedUserType."' and Package.trial = 1 AND Package.space > 0",
			"fields"=>"Package.name, Package.space, Package.amount, Package.duration, Package.id",
			"limit"	=>1
			)
		);*/		

		 
 		$pkg = $this->Package->find('first',
		array("conditions"=> "Package.active = 1 and Package.user_type_id = '".$selectedUserType."' and Package.isdefault = '1'",
			"fields"=>"Package.name, Package.space, Package.package_type, Package.amount, Package.duration, Package.id",
			"limit"	=>1
			)
		);
		$trialPkg = array();
		$boolTrialPackage = 0;
		if($pkg['Package']['package_type'] == "free" )
		{
		//Students and Educators will be signed up with Free Accounts
		//It will all depend on whether "isdefault" field in the table "packages" is set to 1 or not
		//We will register the user	
			$resultData =  $this->Session->read("registerUserData");		
			$resultData['packageDetails'] = $pkg;
			if($this->SaveUser($resultData) == true)
			{
				$this->redirect("/dashboard");
			}
			else 
			{
				$this->Session->setFlash($this->User->errMsg[0]);
				$this->redirect("/signup/step1");
			}
		}
 		else 
 		{
 			if($pkg['Package']['package_type'] == "trial" )
 			{
 				$boolTrialPackage = 1; 
				$trialPkg = $pkg;
				//User has adoped the trial package
				//$pkg['Package']['amount'];		
				//We have to show what will be the regular package afer trial period
				$comingPackage = $this->Package->find('first',
				array("conditions"=> "Package.active = 1 and Package.user_type_id = '".$selectedUserType."' and Package.amount > ".$pkg['Package']['amount'] ,
					"fields"=>"Package.name, Package.space, Package.package_type, Package.amount, Package.duration, Package.id",
					"limit"	=>1,
					"order" => "Package.amount ASC",
					
					)
				);
				$this->set('comingPackage', $comingPackage); 
			 	 
 			}
 			else if($pkg['Package']['package_type'] == "regular" )
 			{
 				
 			}
 		}
  		if(isset($this->request->data['User']) && count($this->request->data['User'])>0)
		{	 
	 		$isErr = $this->User->validateStep2Form($this->request->data['User']);
	 	
	 		if($this->request->data['User']['country'] != "United States"){
				$displayText = "block";
				$displayDropDown = "none";
			}
			else{
				$displayText = "none";
				$displayDropDown = "block";
			}
			
  			if($isErr==0)						
			{
				
				$resultData = array_merge($this->request->data['User'], $this->Session->read("registerUserData"));		
				$resultData['packageDetails'] = $pkg;
							 
				//we will call the payment selected api				
				//we will integrate the payment gateway
  				//If user has opted a trial package then in the coming billing cycle he will be chrged for the regular period
				$resultData['amount'] =  $boolTrialPackage=1?$comingPackage['Package']['amount']:$pkg['Package']['amount'];		
  				
  				
  				$resultData['billingFrequency'] = $pkg['Package']['duration'];		
  				$resultData['trial'] = $trialPkg; 
  		 		$resArray = $this->Paypal->callPaypalApi($resultData);	
  	 			
 	 			$ack = strtoupper($resArray["ACK"]);	
	 			if($ack!="SUCCESS")
	 			{
	 				//we have got any error
	 				$this->User->errMsg[] = $resArray["L_ERRORCODE0"].": ".$resArray["L_LONGMESSAGE0"];	   
	 			}
	 			else 
	 			{
	 				//This is a unique profile id returned by paypal
					
					
					$resultData['state'] = $resultData['vState'];		
					$resultData['package_id'] = $pkg['Package']['id'];
					
					
					if($this->SaveUser($resultData) == true)
					{
						//The amount that he has actually paid for this month
						$paymentData['status'] = "completed";
						$paymentData['amount'] = $pkg['Package']['amount'];
						$paymentData['user_id'] = $this->Session->read("userid");
						$paymentData['transaction_id'] = $resArray['PROFILEID'];		
						$paymentData['expiryofsubscription'] = date("Y-m-d", strtotime("+ ".$pkg['Package']['duration']." day"));
					
						$this->Payment->id = -1;
						$this->Payment->Save($paymentData);
						$this->redirect("/dashboard");
					}
					else 
					{
						 
					}
	 				
	 			}
 				
			}
			$this->set('errMsg',$this->User->errMsg);
		}
	 	else{
			$displayText = "none";
			$displayDropDown = "block";
		} 
		$this->set("pkg",$pkg);
	 	$this->set("states",$states);
	 	$this->set("cardTypes",$cardTypes);
	 	$this->set("countries",$countries); 
	 	$this->set("displayText",$displayText);
		$this->set("displayDropDown",$displayDropDown);
	}

	
	/**
	 * User has finished the registration, show thanks screent
	 *
	 */
	function thanks()
	{
		
	}
	/**
	 * Validate the user after registration
	 *
	 */
	function validate_user()
	{
	 
		//die(base64_encode("4inguser1@yopmail.com"));
		if (isset($this->request->params['url']['v']) && ($this->request->params['url']['v'] != "")){
 			$userName = base64_decode($this->request->params['url']['v']);
 			$isErr = $this->User->ValidateUser($userName);
 			if($isErr==0)						
			{
						
					//we will set the session for login user
					//User has successfully login
	 				$loginUser = $this->User->loginUser;
					//we will call app_Controller function
					$this->loginSessionSet($loginUser);
					/*
                 	After successful login, user will be redirected to live calls page
                 	*/
				//	print_r($_SESSION); exit;
					$this->Session->setFlash(ACCOUNT_VALIDATED);
					$this->redirect(SITE_HTTP_URL."dashboard");
			}
			else{
	 			$this->Session->setFlash(implode("<br/>",$this->User->errMsg));
				$this->redirect("/users/step1");	
			}
 			
		}
		else{// if url is not set accordinglt
			$this->Session->setFlash(ERR_NOT_VALID_URL);
			$this->redirect("/users/step1");	
		}
	}
 
 	function login()
 	{
 		 
 		/*
 		If uesr already login, he will be redirected to live page screen
 		*/
// 		print "<pre>";
// 		print_R($_COOKIE);
// 		print "</pre>";
// 		
// 		print "<pre>";
// 		print_R($_SESSION);
// 		print "</pre>";
// 		
// 		 
//  	
	 if(isset($_COOKIE['CakeCookie']['User']))
		 {
		 	$arrCookie = explode(',',$_COOKIE['CakeCookie']['User']);
        	$arrUserCookie = explode(':',$arrCookie[0]);
         	$arrPassCookie = explode(':',$arrCookie[1]);
         	$this->set('userCookieval',$arrUserCookie[1]);
         	$this->set('remember_me',$arrUserCookie[1]);
         	$this->set('passCookieval',$arrPassCookie[1]);
		 }
		 else{
		 	$this->set('remember_me',false);
		 	$this->set('userCookieval',"Username");
         	$this->set('passCookieval',"123456789");
		 	
		 }
 		if ($this->Session->read("userid")) {
			//echo "i am here.."; exit;
		 	$this->redirect("/dashboard");
		}
 		if ($this->request->data)
 		{	
 			$isErr = $this->User->validateLoginForm($this->request->data);
	 		if($isErr==0)						
			{
 					//we will set the session for login user
					//User has successfully login
					//we will call app_Controller function
					$loginUser = $this->User->loginUser;
				//	pr($loginUser);exit; 
					// find all the coadmins for usertype = 1(admin)
					if($loginUser['user_type_id']==1) 
					{
						$coadmins = $this->coadminGaurdian->find('all',
												array("conditions"=> array('parent_id'=>$loginUser['id']),
													"fields"=>array('user_id')	
													)
													);

						$adminsIDArr[]=$loginUser['id'];
						if(!empty($coadmins))
						{
							foreach($coadmins as $coadminid)
							{
								$adminsIDArr[]=$coadminid['coadminGaurdian']['user_id'];
							}
						}
						$adminsIDStr = implode(',' , $adminsIDArr);
						$loginUser['adminsIDStr'] = $adminsIDStr;   //string of IDs
					}

					//find all the admin and coadmin Id for usertype =7 (coadmin)****************************
					if($loginUser['user_type_id']==7) 
					{
						$idArr  = $this->coadminGaurdian->find('all',
												array("conditions"=> array('parent_id'=>$loginUser['created_by']) , "fields"=>array('user_id')	
													)
													); 
						$adminsIDArr[]=$loginUser['created_by'];
						if(!empty($idArr))
						{
							foreach($idArr as $coadminid)
							{
								$adminsIDArr[]=$coadminid['coadminGaurdian']['user_id'];
							}
						}
						$adminsIDStr = implode(',' , $adminsIDArr); 
						$loginUser['adminsIDStr'] = $adminsIDStr;   //string of IDs
					}
 					$this->loginSessionSet($loginUser);
		 			/********* setting values in cookies**************/
		 			
					 if (empty($_POST['remember_me'])) {
	                 	$this->Cookie->delete('User');
	                 } 
	                 elseif( isset($_POST['remember_me']) && $_POST['remember_me']==1) {
	                 	$cookie = array();
	                 	$cookie['sLoginName'] = $this->request->data['username'];
	                    $cookie['sPassword'] = $this->request->data['password'];
	                    $this->Cookie->write('User', $cookie, false, $this->cookieTerm);
	                 }
	                 unset($_POST['remember_me']);
                 	/********* end setting values in cookies**************/
                 	/*
                 	After successful login, user will be redirected to live calls page
                 	*/
                 	if($this->Session->read("user_type")==6)
					{
						$this->redirect("/users/viewProfile");
					}
					else 
					{
						if(defined('HTTP_HOST'))
	                 	{
		                 	if($loginUser['sitetitle']!='')
		                 	{
								$this->redirect("http://".$loginUser['sitetitle'].".".HTTP_HOST."/dashboard");
		                 	}
		                 	else 
		                 	{		                 		
		                 		$this->redirect("http://www.".HTTP_HOST."/"."dashboard");
		                 	}
	                 	}
	                 	else
						{
							$this->redirect("/dashboard");
						}
					} 
			}
			else{
				$this->set('errMsg',$this->User->errMsg);	
			}
 		}
	}
 
	 	/**
	 * @uses It is used to recover the password
	 *	User Account is validated with the username
	 *	If validated, it will set the user password as the current timestamp value and send this password in an email to the user	
	 * @input NULL
	 * @returns NULL
	 */
	function forgotpassword()
	{
		//mail("admincloudpollen@yopmail.com", "dfsfsd","fsdfsd");die;
		if(isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/dashboard");
		}
	 	if ($this->request->data)
 		{
 			$result = $this->User->validateForgotForm($this->request->data);
 			if($this->User->err==0)						
			{
				//we will update the user for the new password and send this in email to the user
				$password = time();
				$this->User->id = $result['User']['id'];
				$data['password'] = md5($password);
				$this->User->Save($data);
   				$sUserFullName = $result['User']['firstname']." ".$result['User']['lastname'];
 		        $this->Email->to = $result['User']['email'];				
				$this->Email->fromName = ADMIN_NAME;
			    $this->Email->from = EMAIL_FROM_ADDRESS;

		        $sMessage ="Dear $sUserFullName ,<br/><br/>

				As requested, your password at ".SITE_NAME." has been reset.<br/><br/>

				Here are your new login details:<br/>
				Username: ".$result['User']['username']." <br/>
				Password: $password <br/><br/>

				Please use the URL below to login to your account:<br/>
				<a href='".SITE_HTTP_URL."/'>".SITE_HTTP_URL."</a><br/><br/>

				Thanks & Regards,<br/>
				Website Support <br/>
				".SITE_NAME." <br/>";
				
		        $this->Email->text_body = $sMessage;
		        $this->Email->subject = 'Forgot Password';
		        $result = $this->Email->sendEmail();
		        $this->Session->setFlash(PASSWORD_SENT);
		        $this->redirect("/forgotpassword")  ;
			}
			else
			{
				$this->set('errMsg',$this->User->errMsg);	
			}
 		}
	}
        
	function logout()
	{
		$this->GeneralFunction->checkUserLogin();
		$userId = $this->Session->read("userid");
	 	if($this->Session->valid())
		{
			//We will updatethe db for the last login field
			$data['lastlogin'] = date("Y-m-d H:i:s");
			$this->User->id = $userId;
			$this->User->Save($data);
			//Destroy the session
    		$this->Session->destroy();
    		$this->redirect($this->Auth->logout());
		}
		if(defined("HTTP_HOST"))
		
			$this->redirect('http://www.'.HTTP_HOST);	
		else 
			$this->redirect('/');	
		 		

	}
	/***********Logegd In user function starts here ******************************/

	function viewProfile($id=Null,$username=null) 
	{
            
		$this->set('showlinks','N');
		$this->set("url_uid",''); 
		//if($id!=NULL && $id!="" && $username!=NULL && $username!="")

		if(($id!=NULL && $id!="") || ($username!=NULL && $username!=""))
		{
			$this->set("url_uid",$id);
			// For display of suspend and delete link to user 			
			$createdbyarr =  $this->User->find('first',
								array(
										'conditions'=>array('id'=>$id),
										'fields'=>array('id','created_by','status'),
									)
							);
	
			// $createdbyarr['User']['id']  = id passed from url 

			// redirect the user to dashboard if id do not exists
			if(empty($createdbyarr['User']['id']))
			{
				$this->Session->setFlash(MSG_USER_DOES_NOT_EXISTS);
				$this->redirect("/dashboard");
			} 
	 		//$this->set('showlinks','Y');
			$this->set('createdbyarr',$createdbyarr);
 			//check that logged in  user is creator of the id passed from url
	 		$createdby = $createdbyarr['User']['created_by'];
 			$IdArr = explode(',', $this->Session->read('adminsIDStr'));
 			for($i=0;$i<count($IdArr);$i++)
			{
				if($createdby==$IdArr[$i])
				{
					$this->set('showlinks','Y');
					break;
				}
				else
				{
					$this->set('showlinks','N');
				}
			}			
	 		$loggeduserid =$this->Session->read('userid');
			if($this->Session->read('user_type')==1 || $this->Session->read('user_type')==7 )
			{
				$loggeduserid = $this->Session->read('adminsIDStr'); 
			}
  			
			$createdusers  = $this->User->find("all" ,array('conditions'=>"created_by IN($loggeduserid)",
													'fields'=>array('id')
														)
										  );
 			$this->set('userid',$id);
			if(!empty($createdusers))
			{
				foreach($createdusers as $value)
				{
					if($id==$value['User']['id'])
					{
						$this->set('showedit','Y');
						break;
					}
					else
					{
						$this->set('showedit','N');						
					}
				}
	 		}
			else
			{ 
				$this->set('showedit','N');
				
			}
			$userid =$id;
			
		}
                else{
                    $this->redirect(SITE_HTTP_URL.'dashboard');
                }
 		if($id==NULL || $id==$this->Session->read('userid'))
		{
			$userid = $this->Session->read('userid');
			$this->set('showedit','Y');
		}
		else
		{
			//$userid =$id;
		//	$this->set('showedit','N');
		}
		$groups = array();
		$userdata = $this->User->findById($userid); 		
		//To get the class groups to whom user belongs to
		if($userdata['User']['user_type_id'] == 4 || $userdata['User']['user_type_id'] == 5)
		{
			$groups = $this->classgroupStudent->find("all", array(
		 	"conditions"=>"classgroupStudent.user_id = ".$userid,
		 	"fields"=>"DISTINCT classgroupStudent.group_id, classGroup.title",
		 	"joins" => array(
				array(
						"type"=>"inner",
						"table"=>"class_groups",
						"alias"=>"classGroup",
						"conditions"=>"classGroup.id = classgroupStudent.group_id"  
					)
				)
		 	));
		}		 
		$this->set('userdata',$userdata);	
		$this->set('groups',$groups);	
 		$this->layout = "default_front_inner";
	}


	/*********************Updating the user profile******************************/


	function updateUserName($id=NULL)
	{ 
                $this->GeneralFunction->checkUserLogin();
		$_POST['value'] = trim($_POST['value']);

		$namearr = explode(' ',$_POST['value']);

		$userdata['firstname'] = trim($namearr[0]);
	   
		$lastname="";
		for($i=1;$i<count($namearr);$i++)
		{
			$lastname .= $namearr[$i]." ";
		}
		$userdata['lastname'] = trim($lastname);

		

		if($id!=NULL && $id!="")
		{
			$this->User->id = $id;
		}
		else
		{
			 //setting firstname and lastname into session
		    $this->Session->write("firstname",$userdata['firstname']);
		    $this->Session->write("lastname",$userdata['lastname']);
			$this->User->id = $this->Session->read('userid');
		}

		$this->User->save($userdata);
		echo trim($_POST['value']);
		
		die;
	  }


		function updateAboutMe($id=NULL)
		{
                        $this->GeneralFunction->checkUserLogin();
			$userdata['aboutme'] = trim($_POST['value']);

			if($id!=NULL && $id!="")
			{
				$this->User->id = $id;
			}
			else
			{
				$this->User->id = $this->Session->read('userid');
			}
			$updateduserdata = $this->User->save($userdata);
			echo $updateduserdata['User']['aboutme'];
			die;
		}


	function updateEmail($id=NULL)
	{ 
            $this->GeneralFunction->checkUserLogin();
		if($id!=NULL && $id!="")
		{
			$userid  = $id;
			$this->User->id = $id;
		}
		else
		{
			$userid = $this->Session->read('userid');
			$this->User->id = $this->Session->read('userid');
		}
	
		$userdata['email'] = trim($this->request->data['User']['email']);

		$contrecord = $this->User->find('all',array(
												'conditions'=>array('email'=>$userdata['email']),
												 'fields'=>array('id')

												)
											);
							
		if(!empty($contrecord))
		{
			if($contrecord[0]['User']['id']==$userid)
			{
				 echo "success#".MSG_EMAIL_UPDATED;
				 
			}
			if($contrecord[0]['User']['id']!=$userid)
			{
				echo "error#".ERR_SAME_EMAIL_EXIST;
				
			}
		}
		else
		{ 
			
			if($userid == $this->Session->read('userid'))
			{
				$this->Session->write("email",$this->request->data['User']['email']);
			}
			
			$urec = $this->User->find('first',array('conditions'=>array('id'=>$userid),
														 'fields'=>array('firstname','lastname','email','password')	
														));

			 
 

			$userdatadata['firstname']= $urec['User']['firstname'];
			$userdatadata['lastname']= $urec['User']['lastname'];
			$userdatadata['email']= $urec['User']['email'];
			$userdatadata['newEmail']= $this->request->data['User']['email'];

			$this->doEmailToUser($userdatadata,'updateemail');
			
			$updateduserdata = $this->User->save($userdata);
			echo "success#".MSG_EMAIL_UPDATED.'<br>'.$updateduserdata['User']['email'];
		}
		
		die;
	  }


        function updatePassword($id=NULL)
        {
                $this->GeneralFunction->checkUserLogin();
        	if(!isUserLoggedIn($this->Session, "userid"))
			{
				$this->redirect("/");
			}
			if($id!=NULL && $id!="")
			{
				$this->User->id = $id;
				$uid = $id;
			}
			else
			{
				$this->User->id = $this->Session->read('userid');
				$uid = $this->Session->read('userid');
			}
			
			
			if(isset($this->request->data['User']['oldpassword']))
			{
				$oldpwd = md5($this->request->data['User']['oldpassword']);
				$urec = $this->User->find('first',array('conditions'=>array('id'=>$uid),
														 'fields'=>array('firstname','lastname','email','password')	
														));

				if($urec['User']['password']==$oldpwd)
				{
					$userpwd['password']=md5($_POST['data']['User']['password']);
					$this->User->save($userpwd);

					$userdatadata['firstname']= $urec['User']['firstname'];
					$userdatadata['lastname']= $urec['User']['lastname'];
					$userdatadata['email']= $urec['User']['email'];
					$userdatadata['newpwd']= $this->request->data['User']['password'];

					$this->doEmailToUser($userdatadata,'updatepassword');
	
					echo "success@".MSG_PASS_UPDATED;
				}
				else
				{
					echo "error@".ERR_OLDPASSWORD_INVALID;
				}

			}
			

            die;
        }
		
		function updateImage($id=NULL)
        { 
        	if(!isUserLoggedIn($this->Session, "userid"))
			{
				$this->redirect("/");
			}
            if($id!=NULL && $id!="")
			{
				$uid = $id;
				$this->User->id=$id;
			}
			else
			{
				 $uid= $this->Session->read('userid');
				 $this->User->id= $this->Session->read('userid');
			}
			
			
		//	$uid= $this->Session->read('userid');
            $user_img_rec = $this->User->find('first',array(
                                                     'conditions'=>array('id'=>$uid),
                                                     'fields'=>array('profilepic'))
                                         );
           
			if($_FILES['uploadfile']['name']!='')
            {

                if($_FILES['uploadfile']['size'] > MAX_FILESIZE_PIC)
				{
					$response['error'] = MAX_FILESIZE_PIC_MSG;
					echo json_encode($response);
					die;
				}
				
				$stImageUploadDir = FILES_PATH."user_image/100X100/";
                $stImageUploadDir2 =FILES_PATH."user_image/32X29/";

                $mineType =  $_FILES['uploadfile']['type'];
                $source = $_FILES['uploadfile']['tmp_name'];
                $arFile = explode(".",$_FILES['uploadfile']['name']);

                $fileExt = array_pop($arFile);
                $filebase = "user_img_".time();
                $filename = $filebase.".".$fileExt;

                $destination = $stImageUploadDir.$filename;
                $destination2 = $stImageUploadDir2.$filename;

                $fileattribs=getimagesize($source);
                $image=$this->uploadimgdef($source,$destination,"100","100",True);
                $image1=$this->uploadimgdef($source,$destination2,"60","60",True);

                if($image)
                {
                    if(isset($user_img_rec['User']['profilepic']))
                    {
                        if($user_img_rec['User']['profilepic'] != ''){
                                $oldFilePath = FILES_PATH."/user_image/100X100/".$user_img_rec['User']['profilepic'];
                                if(file_exists($oldFilePath)){
                                        unlink($oldFilePath);
                                }

                                $oldFilePathThumb = FILES_PATH."/user_image/32X29/".$user_img_rec['User']['profilepic'];
                                if(file_exists($oldFilePathThumb)){
                                        unlink($oldFilePathThumb);
                                }                           

                        }
                    }            
	 				 $_FILES['uploadfile']['name'] = $image;
	                 $userimg['profilepic']= $_FILES['uploadfile']['name'];
	                // $this->User->id= $id;
		             $this->User->save($userimg);
		             
	               	 if( $uid== $this->Session->read('userid'))
					 { 
					  	$this->Session->write("profilepic",$image);
					 }
	                 $response['success'] = $image;
	                 echo json_encode($response);
  
                 }else 
                 {
                 	$response['error'] = FILE_CANT_UPLOADED;
					echo json_encode($response);
					die;
                 }
                
            }

            die;
        }


/**************************To suspend and activate the user account ***************************/
	function suspendActivateAccount($uid,$su_ac)
	{

		$this->User->id=$uid;
		$urec= $this->User->find('first',
										array('conditions'=>array('id'=>$uid),
											  'fields'=>array('firstname','lastname','email')	
											 )
									);
												 
		$payment = $this->Payment->find("first",array(
		"conditions"=>"Payment.user_id=".$this->Session->read("userid"),
		"order"=>"id DESC"
		)
		);
		
		if($su_ac=='S')
		{ 
			$user['status'] = 2;
			$this->User->save($user);
			
		

			$userdatadata['firstname']= $urec['User']['firstname'];
			$userdatadata['lastname']= $urec['User']['lastname'];
		 	$userdatadata['email']= $urec['User']['email'];

			$this->doEmailToUser($userdatadata,'suspenduser');

			if($uid==$this->Session->read("userid"))
			{
				$this->Session->delete("user_type");
				$this->Session->delete("userid");
				$this->Session->delete("firstname");
				$this->Session->delete("lastname");
				$this->Session->delete("email");
				$this->Session->delete("profilepic");
				$this->Session->delete("cansignup");
				$this->Session->destroy();
				/**
				 * *Suspend the payment profile
				 */
				if(isset($payment['Payment']['transaction_id']))
				{
					$da['action'] = "Suspend";
					$da['profile_id'] = $payment['Payment']['transaction_id'];
					$this->Paypal->manageStatus($da);
				}
				echo "suspended@".MSG_SUSPENDED_SUCCESSFULLY;
				exit;
			}

		 	$func = "suspendActivateAccount($uid,'A');";
			echo "<a class='edit' style='cursor:pointer;' onclick=$func >Activate Account</a>@".MSG_SUSPENDED_SUCCESSFULLY;
			exit;
		}

		if($su_ac=='A')
		{			
			$user['status']=1;
			$this->User->save($user);
			/**
				 * *Activate the payment profile
			*/
			if(isset($payment['Payment']['transaction_id']))
			{
				$da['action'] = "Reactivate";
				$da['profile_id'] = $payment['Payment']['transaction_id'];
				$this->Paypal->manageStatus($da);
			}
			echo "<a class='edit' style='cursor:pointer;' onclick=suspendActivateAccount($uid,'S'); >Suspend Account</a>@".MSG_ACTIVATED_SUCCESSFULLY;
			exit;
		}
	}

/**************************To delete the user account ***************************/

	function deleteAccount($uid=NULL,$refer=NULL)
	{ 
		
		Controller::disableCache();
		$this->set("checkdelete",'N');
		if(trim($refer)=="setting")
		{ 
			$this->set("checkdelete",'Y');
		}
		$payment = $this->Payment->find("first",array(
		"conditions"=>"Payment.user_id=".$this->Session->read("userid"),
		"order"=>"id DESC"
		)
		);
		
		if(!empty($uid) && $uid > 0)
		{			
			
			if($uid==$this->Session->read('userid'))
			{
				//$this->User->delete($uid,true);
				$userstatus['status']= 3;
				$this->User->id = $uid;
				$this->User->save($userstatus);

				$this->Session->delete("user_type");
				$this->Session->delete("userid");
				$this->Session->delete("firstname");
				$this->Session->delete("lastname");
				$this->Session->delete("email");
				$this->Session->delete("profilepic");
				$this->Session->delete("cansignup");
				$this->Session->destroy();
				echo "1@".MSG_REC_DELTED;
				die;
			}
			else{
				
				$getUserType = $this->User->find('first',array('conditions'=>array('id'=>$uid),'fields'=>'user_type_id'));
				
				if($getUserType['User']['user_type_id']==2)
				{
					$redirectTo = 2; //"educator";
				}
				if($getUserType['User']['user_type_id']==4)
				{
					$redirectTo = 3 ; //"student";
				}
				if($getUserType['User']['user_type_id']==7)
				{
					$redirectTo = 7 ; //"coadmin";
				}
				/**
				 * *Cancel the payment profile
				 */
				if(isset($payment['Payment']['transaction_id']))
				{
					$da['action'] = "Cancel";
					$da['profile_id'] = $payment['Payment']['transaction_id'];
					$this->Paypal->manageStatus($da);
				}
			//	$this->User->delete($uid,true);

				$userstatus['status']= 3;
				$this->User->id = $uid;
				$this->User->save($userstatus);

				echo "$redirectTo@".MSG_REC_DELTED;
				die;
			}
			
		}
		$this->render("delete_account","ajax");
	}

	/************************ start private function to send the email ****************************/

	private function doEmailToUser($data,$case)
	{

		$sUserFullName = $data['firstname']." ".$data['lastname'];
	  //  $this->Email->to = $data['email'];				
	    $this->Email->to =  $data['email'];				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
		
	    if($case=="updateemail")
		{
			$newEmail = $data['newEmail'];
			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>

			Email has been changed successfully.<br/><br/>
			Your new email is ".$newEmail.".";
			$subject = SITE_NAME." - Email Updated";
		}
        
		if($case=="updatepassword")
		{
			$newpwd = $data['newpwd'];
			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>

			Password has been changed successfully.<br/><br/>
			Your new password is ".$newpwd.".";
			$subject = SITE_NAME." - New Password";
		}
        

		if($case=="suspenduser")
		{
			
			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>

			Your account has been suspended.Please contact to admin.<br/><br/>";
			
			$subject = SITE_NAME." - Account Suspended";
		}

		if($case=="addcoadmin")
		{
			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>

			Your account has been created for ".SITE_NAME." successfully.Below are the login credentials:<br/><br/>";

			//Please [<a href='".$urlUsed."'>Click Here</a>] to validate your account. <br/><br/>OR <br/><br/>Paste URL ".$urlUsed." in your favourite browser to validate your account.<br/><br/>

			 $sMessage.= "Username : ".$data['username']."<br> Password :".$data['password']."<br>Accout Type : Co-Administrator <br><br>";
			 $subject = SITE_NAME.' - Account Created';
		}


		$sMessage.= " <br/><br/>Thanks & Regards,<br/>
		Website Support <br/>
		".SITE_NAME." <br/>";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = $subject;
        $result = $this->Email->sendEmail();
	
	}

	/************************ end private function to send the email ****************************/

	/************************ Update timzone starts ****************************/
	function updateTimezone()
	{
		$userdata['timezone'] = $this->request->params['form']['timezone'];
		$this->User->id= $this->Session->read("userid");
		$this->User->save($userdata);
		echo MSG_TIMEZONE_UPDATED;
		exit;
	}
	/************************ Update timzone ends ****************************/

	/************************ Update Username starts ****************************/
	function updateUsernameUnique()
	{  
		$userdata['username'] = trim($this->request->data['User']['username']); 
		//$userdata['username'] = $this->request->params['form']['username'];
		$unmae = $userdata['username'];
		$condtions = "username= '$unmae' AND id!=".$this->Session->read("userid");
		$unames = $this->User->find('count',array('conditions'=>$condtions));

		if($unames==0)
		{
			$this->User->id= $this->Session->read("userid");
			$this->User->save($userdata);
			echo "success@".MSG_USERNAME_UPDATED."@".$userdata['username'];
		}
		else
		{
			echo "error@".ERR_USERNAME_EXISTS;	
		}
		exit;
	}
	/************************ Update Username ends ****************************/

	/************************ Update SiteTitle starts ****************************/
	function updateSiteTitle()
	{
		$userdata['sitetitle'] = $this->request->params['form']['sitetitle'];
		$titl = $userdata['sitetitle'];
		$condtions = "sitetitle = '$titl' AND id!=".$this->Session->read("userid");
		$titles = $this->User->find('count',array('conditions'=>$condtions));

		if($titles==0)
		{
			$this->User->id= $this->Session->read("userid");
			$this->User->save($userdata);
			echo "success@".MSG_SITETITLE_UPDATED;
		}
		else
		{
			echo "error@".ERR_SITETITLE_EXISTS;	
		}
		exit;
	}
	/************************ Update sitetitle ends ****************************/

	/************************ Update Country starts ****************************/
	function updateCountry()
	{
		$userdata['country'] = $this->request->params['form']['country'];
		$this->User->id= $this->Session->read("userid");
		$this->User->save($userdata);
		echo MSG_COUNTRY_UPDATED;
		exit;
	}
	/************************ Update Country ends ****************************/


	/************************ Update logo Image ****************************/

	function updateLogoImage($id=NULL)
        { 
            if($id!=NULL && $id!="")
			{
				$uid = $id;
				$this->User->id=$id;
			}
			else
			{
				 $uid= $this->Session->read('userid');
				 $this->User->id= $this->Session->read('userid');
			}
			
		//	$uid= $this->Session->read('userid');
            $user_img_rec = $this->User->find('first',array(
                                                     'conditions'=>array('id'=>$uid),
                                                     'fields'=>array('logopic'))
                                         );
          	$response = array(); 
			if($_FILES['uploadfile']['name']!='')
            {

                if($_FILES['uploadfile']['name'] > MAX_FILESIZE_PIC)
				{
					$response['error'] = MAX_FILESIZE_PIC_MSG;
					echo json_encode($response);
					die;
				}
				
				$stImageUploadDir = FILES_PATH."user_image/logo/";
                
                $mineType =  $_FILES['uploadfile']['type'];
                $source = $_FILES['uploadfile']['tmp_name'];
                $arFile = explode(".",$_FILES['uploadfile']['name']);

                $fileExt = array_pop($arFile);
                $filebase = "user_img_".time();
                $filename = $filebase.".".$fileExt;

                $destination = $stImageUploadDir.$filename;
                

                $fileattribs=getimagesize($source);
                $image=$this->uploadimgdef($source,$destination,"261","97",True);               

                if($image)
                {
                    if(isset($user_img_rec['User']['logopic']))
                    {
                        if($user_img_rec['User']['logopic'] != ''){
                                $oldFilePath = FILES_PATH."/user_image/logo/".$user_img_rec['User']['logopic'];
                                if(file_exists($oldFilePath)){
                                        unlink($oldFilePath);
                                }        
                        }
                    }            
                    $_FILES['uploadfile']['name'] = $image;
                    $userimg['logopic']=  $_FILES['uploadfile']['name'];
                    
                    $this->User->id= $this->Session->read('userid');				  
                    $this->User->save($userimg);
                    
                   //if($id==NULL && $id=="")
                   $response['success'] = $image;
                   echo json_encode($response);
                   die;
                }
                 else 
                 {
                 	$response['error'] = FILE_CANT_UPLOADED;
					echo json_encode($response);
					die;
                 }
            }
            $response['error'] = FILE_CANT_UPLOADED;
			echo json_encode($response);
            die;
        }


	/************* Confirm Password Before Deleting Record in settings page starts *********/

	function checkPassword()
	{
		
		$userpwd = md5($this->request->data['User']['password']);
		$data = $this->User->find('first',array(
			"conditions"=>array('id'=>$this->Session->read("userid")),
			"fields"=>array('password')
			));

		if($data['User']['password']==$userpwd)
		{
			echo "success";
		}
		else
		{
			echo "Password do not match";
		}
			exit;	
	}

	/************* Confirm Password Before Deleting Record in settings page ENDS*********/
	

	/************************ Settings Page Management ****************************/
	function settings()
	{
 		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
		$userdata = $this->User->find('first',array(
		"fields"=>"User.*, Package.*, UserType.title",
		"conditions"=>"User.id = ".$this->Session->read("userid"),
		"joins"=>array(
			array(
			"type"=>"inner",
			"table"=>"packages",
			"alias"=>"Package",
			"conditions"=>array("User.package_id = Package.id")			
			),
			array(
			"type"=>"inner",
			"table"=>"user_types",
			"alias"=>"UserType",
			"conditions"=>array("User.user_type_id = UserType.id")			
			)
		)
		)); 
		$this->set('userdata',$userdata);	
		$this->set('currentuserid',$this->Session->read("userid"));			
		
		global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();		

		$countries = $this->Country->find('list', array(
		'fields' => array('Country.name', 'Country.name'),
		));

		$packages = $this->Package->find("all", array(
		"conditions"=>"Package.active = 1",
 		"joins"=>array(			 
			array(
			"type"=>"inner",
			"table"=>"user_types",
			"alias"=>"UserType",
			"conditions"=>array("Package.user_type_id = UserType.id")			
			)
		),
		"order"=>"Package.user_type_id ASC, Package.space ASC, Package.amount ASC")
		);
		$this->set("packages",$packages);
	 	$this->set("countries",$countries);
		$this->set("timezones",$timezones);
		$this->layout = "default_front_inner";
	}
	/**
	 * Upgrade the package of the user
	 *
	 */
	function updatePackage($pckg_id)
	{
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
		if(!isNull($pckg_id))
		{
			//we will check what is the current package of the user
			$userdata = $this->User->find('first',array(
			"fields"=>"Package.package_type, Package.space, User.firstname, User.lastname",
			"conditions"=>"User.id = ".$this->Session->read("userid"),
			"joins"=>array(
				array(
				"type"=>"inner",
				"table"=>"packages",
				"alias"=>"Package",
				"conditions"=>array("User.package_id = Package.id")			
				)
			)
			)); 
			//Get Package Details
			$dta = $this->Package->findById($pckg_id);
			
			if($userdata['Package']['package_type'] == "free" || $userdata['Package']['package_type'] == "trial")
			{
				//we have to get the user's CC details
				global $cardTypes;
		 		$countries = $this->Country->find('list', array(
				'fields' => array('Country.name', 'Country.name'),
				));
		
				$states = $this->State->find('list', array(
				'fields' => array('State.abbrev', 'State.name'),
				));
				 
				if(isset($this->request->data['User']) && count($this->request->data['User'])>0)
				{	 
			 		$isErr = $this->User->validateStep2Form($this->request->data['User']);
			 		if($this->request->data['User']['country'] != "United States"){
						$displayText = "block";
						$displayDropDown = "none";
					}
					else{
						$displayText = "none";
						$displayDropDown = "block";
					}
					
		  			if($isErr==0)						
					{
						
						$resultData =  array_merge($this->request->data['User'],$userdata['User']) ;	 								 
						//we will call the payment selected api				
						//we will integrate the payment gateway
		  				//If user has opted a trial package then in the coming billing cycle he will be chrged for the regular period
						$resultData['amount'] =  $dta['Package']['amount'];		
 		  	 			$resultData['billingFrequency'] = $dta['Package']['duration'];		
 		  	 			$resultData['state'] = $resultData['vState'];	
 		  	 			
		   		 		$resArray = $this->Paypal->callPaypalApi($resultData); 
 		 	 			$ack = strtoupper($resArray["ACK"]);	
			 			if($ack!="SUCCESS")
			 			{
			 				//we have got any error
			 				$this->User->errMsg[] = $resArray["L_ERRORCODE0"].": ".$resArray["L_LONGMESSAGE0"];	   
			 			}
			 			else 
			 			{
			 				//This is a unique profile id returned by paypal
	 						
							$resultData['package_id'] = $dta['Package']['id'];
				 			//The amount that he has actually paid for this month
							$paymentData['status'] = "completed";
							$paymentData['amount'] = $dta['Package']['amount'];
							$paymentData['user_id'] = $this->Session->read("userid");
							$paymentData['transaction_id'] = $resArray['PROFILEID'];		
							$paymentData['expiryofsubscription'] = date("Y-m-d", strtotime("+ ".$dta['Package']['duration']." day"));
						
							$this->Payment->id = -1;
							$this->Payment->Save($paymentData);
							$this->Session->write("user_type", $dta['Package']['user_type_id']);
							//we will send email to the user
							$this->User->id =  $this->Session->read("userid");
							$this->User->save($resultData);
							$usr['User']['user_type_id'] = $this->Session->read("user_type");
							$usr['User']['id'] = $this->Session->read("userid");
							$usr['User']['firstname'] = $this->Session->read("firstname");
							$usr['User']['lastname'] = $this->Session->read("lastname");
							
					 		$this->userPlanUpdate($dta, $usr);
							$this->Session->setFlash(PACKAGE_UPDATED);
		 	 				$this->redirect("/users/settings");
			 			}
		 				
					}
					$this->set('errMsg',$this->User->errMsg);
				}
			 	else{
					$displayText = "none";
					$displayDropDown = "block";
				} 
				$this->set("pkg",$dta);
			 	$this->set("states",$states);
			 	$this->set("cardTypes",$cardTypes);
			 	$this->set("countries",$countries); 
			 	$this->set("displayText",$displayText);
				$this->set("displayDropDown",$displayDropDown);
				$this->layout = "default_front_inner";
				$this->render("upgrade_membership");
				
			}
			else 
			{
				$payment = $this->Payment->find("first",array("conditions"=>"Payment.user_id=".$this->Session->read("userid")));
				 
			 	if(isset($payment['Payment']['transaction_id']))
				{
		 			if(isset($dta['Package']['id']))
					{
						$postedData['profile_id'] = $payment['Payment']['transaction_id'];
						$postedData['amount'] = $dta['Package']['amount'];
						$postedData['notes'] = "Account upgrade/downgrade by the user";
				 		$res = $this->Paypal->updateRecurringProfile($postedData);
		 				if(isset($res['ACK']) && $res['ACK']="success")
						{	
							$this->Session->write("user_type", $dta['Package']['user_type_id']);
							//we will send email to the user
							$usr['User']['user_type_id'] = $this->Session->read("user_type");
							$usr['User']['id'] = $this->Session->read("userid");
							$usr['User']['firstname'] = $this->Session->read("firstname");
							$usr['User']['lastname'] = $this->Session->read("lastname");
							
					 		$this->userPlanUpdate($dta, $usr);
							$this->Session->setFlash(PACKAGE_UPDATED);
						}
						else {
							$this->Session->setFlash(PACKAGE_CANT_UPDATED);
						}
					}$this->redirect("/users/settings");
				}
			}
		}
		
		
	}
	
	function viewProgress($user_id=Null) {
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}
		$this->layout = "default_front_inner";
		if(!isNull($user_id) && $user_id !=  $this->Session->read("userid"))
		{
			//we wil get the user detail
			$userDetail = $this->User->findById($user_id, "firstname, lastname, user_type_id");
			 
		}
		else 
		{
			$userDetail['User']['firstname'] = $this->Session->read("firstname");
			$userDetail['User']['lastname'] = $this->Session->read("lastname");
			$userDetail['User']['user_type_id'] = $this->Session->read("user_type");
			$user_id = $this->Session->read("userid");
		}
	 	if($userDetail['User']['user_type_id'] != 4 && $userDetail['User']['user_type_id'] != 5 )
			$this->redirect("/dashboard");
			
		 
		$finalArray = array();
		$data = $this->User->getProgressOfStudent($user_id);	 
		$prevSubject = "";
		$i = 0;
		$j = 0;
		$prjctsWeight = 0;
		$obtndMarks = 0;
		$noOfProjectCompleted = 0;
		$overAllPrjctsWeight = 0;
		$overAllPrjctsMarks = 0;
	 	foreach($data as $rec)
		{
		 	if($prevSubject != $rec['Subject']['id'])
			{
				if($i!=0)
				{
					//percentage according to a subjects					
					$finalArray[$i]['overTtl']  = round(($obtndMarks/$prjctsWeight)*100,2);
					$overAllPrjctsWeight+= $prjctsWeight;
					$overAllPrjctsMarks+= $obtndMarks;
					$prjctsWeight = 0;
					$obtndMarks = 0;
				}
				$i++;
				$finalArray[$i]['Subject']  = $rec['Subject'];				
				$prevSubject = $rec['Subject']['id'];				
			}		
			//We have to keep track of project	
			$prjctsWeight += $rec[0]['totalWeight'];			 
			if(!isNull($rec[0]['marksObtained']))
			{
				//percentage of tasks completed in a project
				if($rec[0]['totalWeight']>0) {
					$byProject = round(($rec[0]['marksObtained']/$rec[0]['totalWeight'])*100,2);
				}
				else
				{
					$byProject = 0;
				} 
				$obtndMarks += $rec[0]['marksObtained'];
			}
			else 
			{
				$byProject = 0;
			}
			$rec['Project']['total'] = $byProject;
			$finalArray[$i]['Project'][] = $rec['Project'];						
			$noOfProjectCompleted++; //increase count of No.of Completed Projects
			//If we are at the end of array then we will store current total count
			if($j == count($data)-1)
			{
				$finalArray[$i]['overTtl']  = round(($obtndMarks/$prjctsWeight)*100,2);
				$overAllPrjctsWeight+= $prjctsWeight;
				$overAllPrjctsMarks+= $obtndMarks;
			}
			$j++; 
		}
		$lateProjects = $this->projectStudent->find("count", array(
		"conditions"=> "projectStudent.completed = 0 AND projectStudent.user_id = ".$user_id." AND Project.duedate < curdate()" 
		
		));		
	 	$this->set("data", $finalArray);
		$this->set("lateProjects", $lateProjects);		
		$this->set("user_id", $user_id);		
		$this->set("userDetail", $userDetail);
		//Overall percentage		
		$this->set("overAllPrjctsWeight", $overAllPrjctsWeight);		
		$this->set("overAllPrjctsMarks", $overAllPrjctsMarks);
	 	$this->set("noOfProjectCompleted", $noOfProjectCompleted);
		$this->render("view_progress");
	}
 	/***********Logegd In user function End here ******************************/
 	
 	
	/***********ListCoadmins******************************/
 	function coadmins()
	{ 
		if(!isUserLoggedIn($this->Session, "userid") || $this->Session->read("user_type")!=1)
		{
			$this->redirect("/");
		}
		$this->layout = "default_front_inner";
	}
	/***********ListCoadmins ENDS******************************/

	/***********ListCoadmins******************************/
 	function listCoadminsAjax()
	{ 
		
		$filters=" AND User.user_type_id=7 ";
		$page = isset($this->request->params['named']['page'])?$this->request->params['named']['page']:"";
		$this->paginate = array('User'=>
   		array(
	   		"conditions"=>"User.created_by = ".$this->Session->read('userid')." ".$filters,
	   		"fields"=> "User.id,User.firstname, User.lastname, User.profilepic,User.status", 
			//"order"=>"User.id DESC",
	   		"order"=>"firstname",
	   		"limit"=>4
			)
   		);

		$data = $this->paginate('User');
  
   		$totalPages = isset($this->request->params['paging']['User']['pageCount'])?$this->request->params['paging']['User']['pageCount']:"";
 		
   		$order = isset($this->request->params['paging']['User']['options']['order'])?$this->request->params['paging']['User']['options']['order']:"";
  
   		$i = 0;	
   		foreach($data as $rec)	
   		{ 
   			
				if(is_file(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']))
				{ 
					$data[$i]['User']['profilepic'] = USER_IMAGES_PATH.'32X29/'.$rec['User']['profilepic'];
				}
			 
   			else 
   			{ 
   				$data[$i]['User']['profilepic'] = IMAGES_PATH.USER32X29;
   			}
   			$i++;
   		}
		
 		$this->set('data', $data);
		$this->set('page', $page);
		$this->set('order', $order);
		$this->set('totalPages', $totalPages);
		$this->render("list_coadmins_ajax","ajax");

	}
	/***********ListCoadmins ENDS******************************/
	
	
	/***********Add new Coadmins******************************/
 	function addNewCoadmin()
	{ 
		global $defaultTimeZone;
		$timezones = $this->State->getTimeZones();
		$this->set("timezones",$timezones);
		$this->set("defaultTimeZone",$defaultTimeZone);

		$errmsg="";
		if(!empty($this->request->data)) 
		{
			$sitetitle = $this->request->data['User']['sitetitle'];
			$uname = $this->request->data['User']['username'];
			$uemail = $this->request->data['User']['email'];			
			
			$cnt_sitetitle = $this->User->find('count',
												array('conditions'=> array('username'=>$sitetitle)				
												));

			$cnt_uname = $this->User->find('count',
												array('conditions'=> array('username'=>$uname)				
												));
			
			$cnt_email = $this->User->find('count',
												array('conditions'=> array('email'=>$uemail)				
												));
												
			if($cnt_sitetitle==1)
			{
				$errmsg.= ERR_SAME_SITETITLE_EXIST."<br>";
			}
			if($cnt_uname==1)
			{
							$errmsg.= ERR_SAME_USERNAME_EXIST."<br>";
			}
						if($cnt_email==1)
			{
							$errmsg.= ERR_SAME_EMAIL_EXIST."<br>";
			}
						if($errmsg!="")
			{
							echo "error##".$errmsg;
			}
			else
			{
				$this->request->data['User']['status'] = 1;
				$this->request->data['User']['user_type_id'] = 7;
				$this->request->data['User']['created_by'] = $this->Session->read('userid');
				//$this->request->data['User']['admin_id'] =$this->Session->read('userid');
				$this->request->data['User']['admin_id'] =  $this->getAdminId();
				$userdata['password']= $this->request->data['User']['password']; // used to send in email
				
				$this->request->data['User']['password'] = md5($this->request->data['User']['password']);
				$this->User->id = -1;
				$this->User->Save($this->request->data);

				//inserting values in coadmin_gaurdians table
				$coadminData['user_id'] = $this->User->getLastInsertId();
				$coadminData['parent_id'] = $this->Session->read('userid');
				$coadminData['type'] = 2;				
				$this->coadminGaurdian->id = -1;
				$this->coadminGaurdian->Save($coadminData);

				$userdata['firstname']=$this->request->data['User']['firstname'];
				$userdata['lastname']=$this->request->data['User']['lastname'];
				$userdata['email']=$this->request->data['User']['email'];
				$userdata['username']=$this->request->data['User']['username'];
				
				$this->doEmailToUser($userdata,'addcoadmin');
				
				echo "success##".MSG_USER_ADDED_SUCCESSFULLY." ".MSG_EMAIL_SENT_TO_USER;
			}
			exit;
		}

		$this->render("add_new_coadmin","ajax");
		
	} //function addNewCoadmin ends
	/**
	 * Used as request action on the dashboard page
	 * Pick the latest comments from all the tables
	 */
	function currentComments()
	{
		if(!isUserLoggedIn($this->Session, "userid"))
		{
			$this->redirect("/");
		}		
		$userid = $this->Session->read('userid');
		$user_type = $this->Session->read('user_type');
		$query = $this->projComments->makeQueryComments($userid, $user_type, "LIMIT 0,10");
		$res = $this->User->query($query);
		$this->set("data", $res);
		$this->render("current_comments", "ajax"); 
	}
	
	
	/**
	 * It will be used as ipn handler for the paypal request
	 * We will populate the payments table if we are getting the valid IPN in the request
	 * This will help in creating the reports
	 */
	function populateDbForTransaction()
	{
		$email = $_GET['ipn_email']; 
		$header = ""; 
		$emailtext = ""; 
		
		// Read the post from PayPal and add 'cmd' 
		$req = 'cmd=_notify-validate'; 
		if(function_exists('get_magic_quotes_gpc')) 
		{  
			$get_magic_quotes_exits = true; 
		} 
		foreach ($_POST as $key => $value) 
		// Handle escape characters, which depends on setting of magic quotes 
		{  
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){  
				$value = urlencode(stripslashes($value)); 
			} else { 
				$value = urlencode($value); 
			} 
			$req .= "&$key=$value"; 
		} 
		// Post back to PayPal to validate 
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n"; 
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 
		//$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); 
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 
		 
		// Process validation from PayPal 
		// TODO: This sample does not test the HTTP response code. All 
		// HTTP response codes must be handles or you should use an HTTP 
		// library, such as cUrl 
		 
		if (!$fp) { // HTTP ERROR 
		} else { 
		// NO HTTP ERROR 
		fputs ($fp, $header . $req); 
		while (!feof($fp)) { 
			$res = fgets ($fp, 1024); 
			if (strcmp ($res, "VERIFIED") == 0) { 
				if(isset($_POST['txn_type']) &&  $_POST['txn_type'] == 'recurring_payment')
				{
					$userRec = $this->Payment->findByTransactionId($_POST['recurring_payment_id']);	
					if(isset($userRec['Payment']['user_id']) && $userRec['Payment']['user_id']!='')
					{
						$dSave['user_id'] = $userRec['Payment']['user_id'];
						$dSave['transaction_id'] = $_POST['recurring_payment_id'];
						$dSave['amount'] = $userRec['Payment']['amount'];
						$dSave['expiryofsubscription'] = $userRec['Payment']['expiryofsubscription'];
						$dSave['status'] = strtolower($_POST['payment_status']);//"completed";
						$this->Payment->Save($dSave);
						
						$usrDetail = $this->User->findById($dSave['user_id']);
						//We will also check that if user is trial user and current payemnt is regular then change his account for the space and package id
						if($_POST['payment_status']=="completed")
						{
							if(isset($usrDetail['User']['id']) && $usrDetail['User']['trialpackage']==1 && $_POST['period_type']!="Trial")
							{
								$pkg = $this->Package->find('first',
								array("conditions"=> "Package.active = 1 and Package.user_type_id = '".$usrDetail['User']['user_type_id']."' and Package.isdefault = '1'",
									"fields"=>"Package.name, Package.space, Package.amount, Package.duration, Package.id",
									"limit"	=>1
									)
								); 
								$sql = "UPDATE users SET package_id=".$pkg['Package']['id'].", totalspace = totalspace+".MULTIPLY_BY*$pkg['Package']['space']." WHERE id = ".$userRec['Payment']['user_id'];
								 $this->User->query($sql);
								 mail("manpreet.k@idsil.com", "Live-VERIFIED IPN - TRIAL TEST ".$userRec['Payment']['user_id'], $emailtext . "\n\n" . $req); 
							}
						}
						else 
						{
							//we can inform the user for the failed payment
						}
					}
				}				
				// TODO: 
				// Check the payment_status is Completed 
				// Check that txn_id has not been previously processed 
				// Check that receiver_email is your Primary PayPal email 
				// Check that payment_amount/payment_currency are correct 
				// Process payment 
				// If 'VERIFIED', send an email of IPN variables and values to the 
				// specified email address 
				foreach ($_POST as $key => $value){ 
					$emailtext .= $key ." = " .$value ."\n\n"; 
				} 
				
			} else if (strcmp ($res, "INVALID") == 0) { 
				// If 'INVALID', send an email. TODO: Log for manual investigation. 
				foreach ($_POST as $key => $value){ 
				$emailtext .= $key . " = " .$value ."\n\n"; 
				} 
				//mail("manpreet.k@idsil.com", "Live-INVALID IPN", $emailtext . "\n\n" . $req);
			}
		}
		}
		exit;
	}
	/**
	 *  To get the students that are added in the co-admin's account
	 */
	function mystudents()
	{
		$this->layout= "default_front_inner";
		if($this->Session->read("user_type") == 6)
		{
			$uid = $this->Session->read("userid");
			$getStudents = $this->coadminGaurdian->find("all", array(
			"conditions"=>"coadminGaurdian.parent_id = ".$uid." AND coadminGaurdian.type=1 AND User.status = 1 ",
			"fields"=> "User.profilepic, User.firstname, User.lastname, User.id"
			));
			$i = 0;	
			$data = array();
	   		foreach($getStudents as $rec)	
	   		{ 
	   			$data[$i] = $rec;
				if(is_file(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']) && file_exists(USER_IMAGES_URL.'32X29/'.$rec['User']['profilepic']))
				{ 
					$data[$i]['User']['profilepic'] = USER_IMAGES_PATH.'32X29/'.$rec['User']['profilepic'];
				}
	   			else 
	   			{ 
	   				$data[$i]['User']['profilepic'] = IMAGES_PATH.USER32X29;
	   			}
	   			$i++;
	   		} 
			$this->set("data", $data);
		}
		else {
			$this->Session->setFlash(ERR_NOT_AUTHORIZED_THIS);
			$this->redirect("/");	
		}
	}

	//
	function test()
	{
		
	    $this->Email->to = "manpreet.k@idsil.com";				
		$this->Email->fromName = ADMIN_NAME;
	    $this->Email->from = EMAIL_FROM_ADDRESS;
	    
        $sMessage ="HI";
		
        $this->Email->text_body = $sMessage;
        $this->Email->subject = SITE_NAME.' - Account Created';
        $result = $this->Email->sendEmail();
        die;
	}
         public function check_user_login(){
            $this->autoLayout = false;
            $this->autoRender = false;
            $loggeduserid =$this->Session->read('userid');
            if(empty($loggeduserid)){ 
               echo $this->redirect('/users/logout');
            }else{
                return true;
            }
        }
}
