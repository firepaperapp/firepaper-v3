<?php
App::uses('Sanitize', 'Utility');
class AdminController extends AppController {

	//Specify View folder

	var $name     = 'Admin';

	//Specify Layout

	var $layout ='default_admin_inner';

	//Specify  models(tables)

	var $uses = array('Admin','User','UserType','State','Package','UserType','Payment','Country','Project'); // model name will come here

	var $components=array('Pagination','Email','Paypal');

	var $helpers=array('Pagination','Html','Form','Js');

	

	function beforeFilter() {

		// For admin section funtions only

		if(!in_array($this->request->action, array('login', 'forgotpassword'))){

//			$this->breadcrumb['Home']='/admin/home/';

			$this->authorize();

		}

		else {

			$this->breadcrumb['Home']='/';

		}

		// Admin section authentication check ends here

	}



	function index() {

	}



	function home(){

		

	}

	/**********FUNCTION TO GET ALL USERS**********/

	function manageusers($search="") {  

	
		
		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['Users']='';

		$filters =array();

		

		$userTypes = $this->UserType->find('all',array('active=1')); 

		$this->set('userTypes',$userTypes);

		$this->set("statustype","");

		$this->set("username","");

		

			$conditions = "1=1 AND User.status!=3 ";

			

			if(!empty($this->request->data))

			{

				$searched['status'] = $this->request->data['User']['status'];

				$searched['username'] = $this->request->data['User']['username'];

				$this->Session->write('adminUserSeacrch' , $searched);

				$this->set("statustype",$searched['status']);

				$this->set("username",$searched['username']);

 			}

			else

			{

				$searched = $this->Session->read('adminUserSeacrch');

				if(!empty($searched['status']))

				$this->set("statustype",$searched['status']);



				if(!empty($searched['username']))

				$this->set("username",$searched['username']);

			}

 

			if(!empty($searched['status']))

			{

				$conditions .= " AND User.user_type_id='".$searched['status']. "'";

			}

			

			if(!empty($searched['username']))

			{

				$conditions .= " AND ( User.firstname like '%".addslashes($searched['username'])."%' OR User.lastname like '%".addslashes($searched['username'])."%')"; 

			}
 
	

		$this->paginate=array(

						  'order'=>array('User.id'=>'desc'),

						  'limit'=>'15',

						  'fields' => array('User.username','User.status,User.email,User.id,User.firstname,User.lastname,Usertype.title,User.user_type_id'),

						  'conditions' => $conditions,

    					  'joins' => array(

    					  				array('table' => 'user_types',

					                         'type' => 'LEFT',

					                         'alias' => 'Usertype',

					                         'conditions' => array('Usertype.id = User.user_type_id'))

										  )

					);
 		$arUsers = $this->paginate('User');

		$this->set('arUsers',$arUsers);

		



	}





	function addedituser($user_id=0) {
		 
		

		global $defaultTimeZone;

		$timezones = $this->State->getTimeZones();

		$this->set("timezones",$timezones);

		$this->set("userID",$user_id);



		$this->set("defaultTimeZone",$defaultTimeZone);

		

		$this->breadcrumb['Home']='/admin/home/';

		if($user_id > 0 )

		{

			$this->breadcrumb['Update User']='';

		}

		else{

		$this->breadcrumb['Add New User']='';

		}		

		$this->set('errMsg',"");

		 

		$arTypes = $this->UserType->find('all',array(

		"conditions" => 'active=1 and cansignup = 1'

		)

		); 			

		$this->set('arrTypes',$arTypes); 

		$arTypesAll = $this->UserType->find('all',array('active=1')); 	

		$this->set('arTypesAll',$arTypesAll); 

 		 

		if(!isNull($this->request->data)) {

			$err = $this->User->validateOnAdminEnd($this->request->data['User'], $this->request->data['uid']);

			

			if($err == 0) 

			{ 			

				$this->request->data['User']['user_type_id'] = $this->request->data['User']['usertype'];

				

				

				foreach($this->request->data['User'] AS $key => $val)

				{

					if($key != 'confirmpassword')

					{

						$data[$key] = $val;

					}

				} 

				

				if($this->request->data['uid']!=0 && $this->request->data['uid'] > 0)

				{

					$this->User->id= $this->request->data['uid']; 
					$dataEmail = $this->request->data['User'];
					$data['password'] = md5($this->request->data['User']['password']);

					$this->User->Save($data);
					$this->doEmailToUser($dataEmail,"edit");
					$this->Session->setFlash("User has been updated.");

					exit;

				}

				else

				{						

					$newuserdata['registerUser'] = $this->request->data['User'];					

					$this->Session->write($newuserdata); 

					echo "success@@";

					exit;

				}			

			}

			else

			{	

				$errormsg ="";

				$errormsg .="error@@";

				for($i=0; $i< count($this->User->errMsg);$i++)

				{

					$errormsg .= $this->User->errMsg[$i]."<br>";

				}

				echo $errormsg; 

				exit;

				

			}

		}



		$userdata = $this->User->read(null, $user_id); 		

		$this->set("userdata",$userdata);







	}



	/****************************user registration step 2- Subscription *********/





	function subscribe()

	{  
	global $cardTypes;
	$countries = $this->Country->find('list', array(
	'fields' => array('Country.name', 'Country.name'),
	));

	$states = $this->State->find('list', array(
	'fields' => array('State.abbrev', 'State.name'),
	));
	
		//we will get the package for the user
		$selectedUserType = $this->Session->read("registerUser.user_type_id");	
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
			$resultData =  $this->Session->read("registerUser");		
			$resultData['packageDetails'] = $pkg;
			if($this->SaveUser($resultData) == true)
			{
				$this->redirect("/admin/manageusers");
			}
			else 
			{
				$this->Session->setFlash($this->User->errMsg[0]);
				$this->redirect("/admin/addedituser");
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
  		if($this->request->data)
		{	 
			$this->request->data['User'] = $this->request->data;
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
				
				$resultData = array_merge($this->request->data['User'], $this->Session->read("registerUser"));		
			
				$resultData['packageDetails'] = $pkg;
							 
				//we will call the payment selected api				
				//we will integrate the payment gateway
  				//If user has opted a trial package then in the coming billing cycle he will be chrged for the regular period
				$resultData['amount'] =  $boolTrialPackage=1?$comingPackage['Package']['amount']:$pkg['Package']['amount'];		 		 	$resultData['billingFrequency'] = $pkg['Package']['duration'];		
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
						$this->redirect("/admin/manageusers");
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
 

/******************************Send email after creating the user *************/



	private function emailAfterSubscribe($data)

	{



		$sUserFullName = $data['firstname']." ".$data['lastname'];

	    $this->Email->to =  $data['email'];				

		$this->Email->fromName = ADMIN_NAME;

	    $this->Email->from = EMAIL_FROM_ADDRESS;	   

		$userType = $this->UserType->findById($data['user_type_id']);

        $sMessage ="Dear ".$sUserFullName.","."<br/><br/>



		You account has been created for ".SITE_NAME." successfully.Below are the login credentials:<br/><br/>";



		$sMessage.= "Username : ".$data['username']."<br> Password :".$data['password']."<br/>Account type: ".$userType['UserType']['title']."<br/><br>";

			



		$sMessage.="Thanks & Regards,<br/>

		Website Support <br/>

		".SITE_NAME." <br/>";

		

        $this->Email->text_body = $sMessage;

        $this->Email->subject = SITE_NAME.' - Account Created';

        $result = $this->Email->sendEmail();

	}





	/******* Admin Login *********/

	function login() {

		$this->layout = 'default_admin';

		$this->set('errMsg','');



		if($this->Session->check("notAuthorize")){

			$this->set('errMsg',$this->Session->read("notAuthorize"));

		}



		if(!isNull($this->request->data)) {

			if(isset($this->request->data['Admin']['remcookie']) && $this->request->params['data']['Admin']['remcookie'] == 1){

				$Month = 2592000 + time();

				setcookie("UserNameCookie", $this->request->data['Admin']['username'],$Month);

				setcookie("UserPassCookie", $this->request->data['Admin']['password'],$Month);

			} else {

				setcookie("UserNameCookie", "", time()-3600);

				setcookie("UserPassCookie", "", time()-3600);

			}

			$arUser['username']  = ($this->request->data['Admin']['username']);

			$arUser['password'] = $this->request->data['Admin']['password'];



			//Check if user has entered valid details

		 

			$data = $this->Admin->isValidLoginDetails($arUser);



			if($this->Admin->err==0) {

 

				$userdata = $data;

				$this->Session->write("login",'1');

				$this->Session->write("aid",$userdata['Admin']['ID']);

				$this->Session->write("username",$userdata['Admin']['userName']);

				$this->redirect("/admin/home");

				die();

			} else {

				$this->set('err',$this->Admin->err);

				$this->set('errMsg',$this->Admin->errMsg);

			}

		}

		//If some use is already logged in

		if($this->Session->check("cakeAuth")){

			$this->redirect("/admin/home");

			die();

		}

	}



	/*Function to logout Writes a session variable that is used to display a message on login page*/

	function logout() {

		//$this->Auth->logout();

		$this->Session->write("login",NULL);

		$this->Session->write("aid",NULL);

		$this->Session->write("notAuthorize",MSG_SUCCESS_LOGGEDOUT);
	$this->Session->write('adminUserSeacrch' , '');
		$this->redirect('/admin/login');

		exit();

	}//EF

	

	/*Function to display forgot password form*/

	function forgotpassword(){

		$this->layout = 'default_admin';



		$this->set('errMsg','');

		$this->breadcrumb['Home']='admin/home/';

		$this->breadcrumb['Forgot Password']='';



		if($this->request->data) {

			

			$userdata = $this->Admin->find("username = '".$this->request->data['Admin']['username']."'");



			if($userdata!="" && count($userdata) > 0){



				$userdata['Admin']['password'] = substr(md5(time()),8,8);

				$this->Admin->id = $userdata['Admin']['ID'];

				$this->Admin->saveField('password',md5($userdata['Admin']['password']));

				$this->__sendForgotPassword($userdata);

				$this->Session->setFlash("New password is sent to your registered email.");

				$this->redirect(SITE_HTTP_URL.'admin/login/forgotpassword');



			} else {

				$this->Admin->errMsg[] = ERR_INVALID_FORGOT;

				$this->set('errMsg',$this->Admin->errMsg);

			}//End email check

		}//End data check

	}//EF



	/*Function to send email after reseting admin password*/

	Private function __sendForgotPassword($userdata){



		        $this->Email->to = $userdata['Admin']['email'];

				$this->Email->toName = ucfirst($userdata['Admin']['firstName']);

				$this->Email->fromName = EMAIL_FROM_NAME;

			    $this->Email->from = EMAIL_FROM_ADDRESS;



		        $sMessage ="Dear ".$userdata['Admin']['firstName'].",<br/><br/>



				Here are your new login details:<br/>

				Username: ".$userdata['Admin']['userName']."<br/>

				Password: ".$userdata['Admin']['password']."<br/><br/>



				Please use the URL below to login to the secure Admin area:<br/>

				<a href='".SITE_HTTP_URL."admin/'>".SITE_HTTP_URL."admin/</a><br/><br/>



				Thanks & Regards,<br/>

				Website Support <br/>

				".SITE_NAME." <br/>";



		        $this->Email->text_body = $sMessage;

		        $this->Email->subject = 'Forgot Password';

		       $result = $this->Email->sendEmail();

	}//EF

	

	/*Function to change password */

	function changepassword() {

		

		$this->breadcrumb['Home']='admin/home/';

		$this->breadcrumb['Change Password']='';

		$errMsg = array();

		if(!isNull($this->request->data)) {

			

			$err = $this->Admin->validateAllPasswords($this->request->data['Admin'], $this->Session->read("aid"));

			

			if($err == 0) {

				$this->Admin->id = $this->Session->read("aid");

				$this->newPassword = $this->request->data['Admin']['newpassword'];

				$this->Admin->saveField('password',md5($this->newPassword));

				

				 

				$userdata = $this->Admin->find("id = ".$this->Admin->id);

				$userdata['Admin']['password'] = $this->newPassword;

				$this->__sendChangePassword($userdata);

				$this->Session->setFlash("New password is sent to your registered email.");

				$this->redirect('/admin/changepassword');

			}

			$errMsg = $this->Admin->errMsg;

		}

		$this->set('errMsg',$errMsg);

	}

	/*Function to send email after reseting admin password*/

	Private function __sendChangePassword($userdata){



		        $this->Email->to = $userdata['Admin']['email'];

				$this->Email->toName = ucfirst($userdata['Admin']['firstName']);

				$this->Email->fromName = EMAIL_FROM_NAME;

			    $this->Email->from = EMAIL_FROM_ADDRESS;



		        $sMessage ="Dear ".$userdata['Admin']['firstName'].",<br/><br/>



				Here are your new login details:<br/>

				Username: ".$userdata['Admin']['userName']."<br/>

				Password: ".$userdata['Admin']['password']."<br/><br/>



				Please use the URL below to login to the secure Admin area:<br/>

				<a href='".SITE_HTTP_URL."admin/'>".SITE_HTTP_URL."admin/</a><br/><br/>



				Thanks & Regards,<br/>

				Website Support <br/>

				".SITE_NAME." <br/>";



		        $this->Email->text_body = $sMessage;

		        $this->Email->subject = 'Change Password';

		       $result = $this->Email->sendEmail();

	}//EF



	function deleteuser($id) {

		$id = (int)$id;

		if($id > 0) {

			$this->User->delete($id);

		}

		



		$userData = $this->User->findById($id);

		$data['firstname']= $userData['User']['firstname'];

		$data['lastname']= $userData['User']['lastname'];

		$data['email']= $userData['User']['email'];



		$this->doEmailToUser($data,'delete');



		$this->Session->setFlash(MSG_USER_DELETED);

		$this->redirect(SITE_HTTP_URL.'admin/manageusers');

	}

	

	function userstatus($userId,$status){

		

		$this->User->query("UPDATE users SET status=".$status." WHERE id=".$userId."");

		$this->Session->setFlash(USER_STATUS_UPDATED); 

		$this->autoRender = false;	

		

		$userData = $this->User->findById($userId);

		$data['firstname']= $userData['User']['firstname'];

		$data['lastname']= $userData['User']['lastname'];

		$data['email']= $userData['User']['email'];



		$payment = $this->Payment->find("first",array(

		"conditions"=>"Payment.user_id=".$userId,

		"order"=>"id DESC"

		)

		);

 		if($status == 1) //activate case

		{

			$case = "activate";

			if(isset($payment['Payment']['transaction_id']))

			{

				$da['action'] = "Reactivate";

				$da['profile_id'] = $payment['Payment']['transaction_id'];

				$this->Paypal->manageStatus($da);

			}

		}

		elseif ($status == 2)

		{

			$case = "suspenduser";

			if(isset($payment['Payment']['transaction_id']))

			{

				$da['action'] = "Suspend";

				$da['profile_id'] = $payment['Payment']['transaction_id'];

				$this->Paypal->manageStatus($da);

			}

		}

		elseif ($status == 3)

		{

			$case = "delete";

			/**

			 * *Cancel the payment profile

			 */
			if(isset($payment['Payment']['transaction_id']))

			{

				$da['action'] = "Cancel";

				$da['profile_id'] = $payment['Payment']['transaction_id'];

				$this->Paypal->manageStatus($da);

			}

		}

		$this->doEmailToUser($data, $case);
		
		$this->redirect($this->referer());

		//$this->redirect(SITE_HTTP_URL."admin/manageusers");

	}







	function ViewProfile($userID=0, $referer=NULL)

	{

		$this->set('referer',"");

		if($referer=="VR")

		{

			$this->set('referer', 'viewReport');

		}

		if($referer=="MU")

		{

			$this->set('referer', 'manageusers');

		}

		$this->breadcrumb['Home']='admin/home/';

		$this->breadcrumb['View Profile']='';

		if($userID > 0)

		{

			

			$userdata= $this->User->find('first',array(

											'conditions'=>array('User.id'=>$userID),

											'joins'=>array(array(

														'type'=>'inner', 

														"table"=>"user_types", 

														"alias"=>"userTypes",

											'conditions'=>array('userTypes.id = User.user_type_id'))),

											'fields'=>array('User.*,userTypes.title')

								));



			$state = $this->State->find('first',array('conditions'=>array('abbrev'=>$userdata['User']['state'])));

				

			$this->set('userdata',$userdata);

			$this->set('userstate',$state['State']['name']);



		}

	}







	/************************ start private function to send the email ****************************/



	private function doEmailToUser($data,$case)

	{



		$sUserFullName = $data['firstname']." ".$data['lastname'];

	  //  $this->Email->to = $data['email'];				

	    $this->Email->to =  $data['email'];				

		$this->Email->fromName = ADMIN_NAME;

	    $this->Email->from = EMAIL_FROM_ADDRESS;

		
		if($case=="edit")

		{
 				$sMessage ="Dear ".$sUserFullName.",<br/><br/>



				Site Administrator has changed your details, below are your new login details:<br/>

				Username: ".$data['username']."<br/>

				Password: ".$data['password']."<br/><br/>



				Please use the URL below to login to your account::<br/>

				<a href='".SITE_HTTP_URL."'>".SITE_HTTP_URL."</a>";
			    $subject = "Account Updated";
		}
	    

		if($case=="delete")

		{

			

			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>



			Your account has been deleted by admin.";

			$subject = "Account Deleted";

		}

        if($case=="activate")

		{

			

			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>



			Your account has been Activated by admin.";

			$subject = "Account Activate";

		}



		if($case=="suspenduser")

		{

			

			$sMessage ="Dear ".$sUserFullName.","."<br/><br/>



			Your account has been suspended.Please contact to admin.<br/><br/>";

			

			$subject = "Account Suspended";

		}





		$sMessage.= " <br/><br/>Thanks & Regards,<br/>

		Website Support <br/>

		".SITE_NAME." <br/>";

		

        $this->Email->text_body = $sMessage;

        $this->Email->subject = SITE_NAME.' - '.$subject;

        $result = $this->Email->sendEmail();
 

	}



	/************************ end private function to send the email ****************************/



	function resetSearch()

	{

		$this->Session->write('adminUserSeacrch' , '');

		$this->redirect(SITE_HTTP_URL."admin/manageusers");

	}

	



	function manageplans()

	{

		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['Manage Plans']='';

	

		

		$conditions ="";

		$this->paginate=array(

						  'order'=>array('Package.id'=>'desc'),

						  'limit'=>'10',

						  'fields' => array('Package.id', 'Package.name','Package.amount','Package.duration', 'Package.package_type' ,'Package.user_type_id' ,'Usertype.title'),

						  'conditions' => $conditions,

    					  'joins' => array(

    					  				array('table' => 'user_types',

					                         'type' => 'inner',

					                         'alias' => 'Usertype',

					                         'conditions' => array('Usertype.id = Package.user_type_id'))

										  )

					);



		$arPackages = $this->paginate('Package'); 



		for($i=0; $i<count($arPackages);$i++)

		{

			// converting in no. of months 

 			$arPackages[$i]['Package']['duration'] = $arPackages[$i]['Package']['duration'] / 30; 



			// counting the no of users using a plan 

			$countpackage = $this->User->find('count',array('conditions'=>array('package_id'=>$arPackages[$i]['Package']['id'])));

			$arPackages[$i]['Package']['countpackages'] = $countpackage;

		}





		$this->set('arPackages',$arPackages);



	}



	function addeditPackage($packageID=0)

	{

	

		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['Manage Plans']='admin/manageplans';

		$this->breadcrumb['Add Plans']='';

		



		$cansignupUser = $this->UserType->find('all',array('conditions'=>array('cansignup'=>1),

										  'fields'=>array('id','title')		

		));

		

		$arrUsertype = array();

		foreach($cansignupUser as $cansignup)

		{

			$arrUsertype[$cansignup['UserType']['id']] = $cansignup['UserType']['title'];

		}

		

		$this->set("durationArr", "");

	/*	$durationArr = array(

						'1'=> '1 Month' ,

						'2'=>'2 Months' ,

						'3'=>'3 Months' ,

						'4'=>'4 Months' ,

						'5'=>'5 Months' ,

						'6'=>'6 Months' , 

						'7'=>'7 Months' , 

						'8'=>'8 Months' ,

						'9'=>'9 Months' , 

						'10'=>'10 Months' ,

						'11'=>'11 Months' ,

						'12'=>'12 Months'  );

*/

		

		if(!empty($this->request->data))

		{ 

	 		//$this->request->data['Package']['duration'] = $this->request->data['Package']['duration']* 30;

			$this->request->data['Package']['isdefault'] = $this->request->params['form']['isdefault'];
	 
			if($this->request->data['Package']['isdefault'] == 1)
			{
				$this->Package->updateAll(
				array("isdefault"=> 0),
				array("user_type_id"=> $this->request->data['Package']['user_type_id'])
				
				);
			}
			if($this->request->data['Package']['package_type'] == "unlimited")
			{
				$this->request->data['Package']['unlimited'] = 1;
			}

			if($packageID >  0)

			{

				$this->Package->id = $packageID;

				$this->Package->save($this->request->data);

				$this->Session->setFlash(MSG_PLAN_UPDATED_SUCCESSFULLY);

				$this->redirect(SITE_HTTP_URL.'admin/manageplans');

			}

			else

			{

				// durations in no of days				

				$this->Package->id = -1;

				$this->Package->save($this->request->data);

				$this->Session->setFlash(MSG_PLAN_ADDED_SUCCESSFULLY);
			 
				$this->redirect(SITE_HTTP_URL.'admin/manageplans');

			}

		}

		

		if($packageID >  0)

		{

			$conditions ="Package.id=".$packageID;



			$packageRecord = $this->Package->find('first', array(

								'conditions'=>$conditions,

								'fields'=> array('Package.id', 'Package.name','Package.amount','Package.space' , 'Package.duration', 'Package.package_type', 'Package.user_type_id' ,'Usertype.title', 'Package.isdefault'),

								 'joins' => array(

    					  				array('table' => 'user_types',

					                         'type' => 'inner',

					                         'alias' => 'Usertype',

					                         'conditions' => array('Usertype.id = Package.user_type_id'))

										  )

				));

			$packageRecord['Package']['duration'] = $packageRecord['Package']['duration'] / 30;

			

			$this->request->data = $packageRecord;

			$this->set("data", $this->request->data);



		}


		$package_type = array(
		"trial"=>"Trial Package",
		"free"=>"Free Package",
		"unlimited"=>"Unlimited Space Package",
		"regular"=>"Regular Package"
		);
		$selectedPackageType = isset($this->request->data['Package']['package_type'])?$this->request->data['Package']['package_type']:"regular";

	//	$this->set("durationArr", $durationArr);
		$this->set("package_type", $package_type);
		$this->set("selectedPackageType", $selectedPackageType);
		$this->set("packusertypes", $arrUsertype);

	}





	function viewPlan($packageID = 0)

	{

		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['Manage Plans']='admin/manageplans';

		$this->breadcrumb['View Plan']='';

		

		if($packageID > 0 )

		{

			$conditions ="Package.id=".$packageID;
  			$packageRec = $this->Package->find('first', array(

								'conditions'=>$conditions,

								'fields'=> array('Package.id', 'Package.name','Package.amount','Package.space', 'Package.duration', 'Package.user_type_id' ,'Usertype.title'),

								 'joins' => array(

    					  				array('table' => 'user_types',

					                         'type' => 'inner',

					                         'alias' => 'Usertype',

					                         'conditions' => array('Usertype.id = Package.user_type_id'))

										  )

				));





			// converting in no. of months 

			$packageRec['Package']['duration'] = $packageRec['Package']['duration'] / 30; 



			$this->set("packageRec", $packageRec);

		}

	}





	function deletePackage($packageID=0)

	{

		if($packageID > 0)

		{

			$this->Package->delete($packageID,true);

			$this->Session->setFlash(MSG_PLAN_DELETED_SUCCESSFULLY);

			$this->redirect(SITE_HTTP_URL.'admin/manageplans');

			exit;

		}

	}





	function viewReport()

	{		

		

		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['View Reports']='';

		

		$this->set("uname", "");

		$sDateFrom="";

		$sDateTo="";

		$conditions = "";

		$stdt = $this->request->data['startdate'];

		$enddt = $this->request->data['enddate'];

		$fomrPosted =0;

		$from ="";

		if(!empty($this->request->data))

		{	$fomrPosted =1;		

			if($this->request->data['startdate']!="" && $this->request->data['enddate']!="")

			{

				$this->request->data['startdate'] = date("Y-m-d",strtotime($this->request->data['startdate']));

				$this->request->data['enddate'] = date("Y-m-d",strtotime($this->request->data['enddate']));



				$sDateFrom =$this->request->data['startdate'];

				$sDateTo =$this->request->data['enddate'];



				$conditions = 'date_format(Payment.created, "%Y-%m-%d") between "'.$this->request->data['startdate'].'" AND  "'.$this->request->data['enddate'].'"';				

			}



			elseif($this->request->data['startdate']!="" && $this->request->data['enddate']=="")

			{				

				$this->request->data['startdate'] = date("Y-m-d",strtotime($this->request->data['startdate']));

				$sDateFrom =$this->request->data['startdate'];



				$conditions = 'date_format(Payment.created, "%Y-%m-%d") >= "'.$this->request->data['startdate'].'"';

				

			}

			elseif($this->request->data['startdate']=="" && $this->request->data['enddate']!="")

			{

				$this->request->data['enddate'] = date("Y-m-d",strtotime($this->request->data['enddate']));

				$sDateTo =$this->request->data['enddate'];

				$conditions = 'date_format(Payment.created, "%Y-%m-%d") <= "'.$this->request->data['startdate'].'"';

				

			}			



			if(!empty($this->request->data['username']))

			{ 
					$conditions.= "  AND  ( User.firstname like '".addslashes($this->request->data['username'])."%' OR  User.lastname like '".addslashes($this->request->data['username'])."%')";

			 


				 



				$this->set("uname", addslashes($this->request->data['username']));

			}
 		 
		 	$stQuery = 'SELECT date_format(Payment.created,"%Y-%m") as datePay, SUM(Payment.amount) as totalSale, Count(Payment.id) as cnt

						FROM payments as Payment '.$from.'
						INNER JOIN users User ON Payment.user_id = User.id

						WHERE  User.status!=3 AND Payment.status="completed" AND '.$conditions.' 

						GROUP BY date_format(Payment.created,"%Y-%m")';



			$records = $this->Payment->query($stQuery);

			

		}

		else

		{

			

			$startdate = date('Y-m-01');

			$conditions = ' User.status!=3 AND date_format(Payment.created, "%Y-%m-%d") >= "'.$startdate.'" AND Payment.status="completed"';	

	 

			$sDateFrom = date("Y-m")."-01";			

			$sDateTo = date("Y-m")."-31";



			$records = $this->Payment->find('all',array(

							'order' => array('date_format(Payment.created,"%Y-%m")' => 'desc', 'totalSale'=>'desc'),

							'fields' => array('User.id', 'User.firstname', 'User.lastname','SUM(Payment.amount) as		totalSale','Count(Payment.id) as cnt','Payment.created', 'date_format(Payment.created,"%Y-%m") as datePay' ),

							'joins'=>array(

											array(

											'type'=>'inner', 

											"table"=>"users", 

											"alias"=>"User",

											"conditions"=>array("User.id = Payment.user_id")					)

											),

							'conditions' =>  $conditions,

                           'group' => array('date_format(Payment.created,"%Y-%m")', 'Payment.user_id')));







		//	$pymentRecord = $this->paginate('Payment'); 

		}

		

			$this->set("data",$records);

			$this->set("sDateTo",$sDateTo);

			$this->set("sDateFrom",$sDateFrom);

			$this->set("fomrPosted",$fomrPosted);

			

		

			/*$grandtotal= 0;

			foreach($pymentRecord as $rec)

			{

				$grandtotal =  $grandtotal + $rec['0']['usertotal'];

			}

			

			$this->request->data['startdate']= $stdt ;

			$this->request->data['enddate']= $enddt ;

			//$this->set("grandtotal" ,$grandtotal);

			//$this->set("pymentRecord" ,$pymentRecord); */

	}



	function reportsDetail()

	{

		

		$conditions ="";

		$conditions.="Payment.amount > 0 AND Payment.status = 'completed'" ;

	 	if(isset($this->request->params['form']['date']))

		{

			$conditions.= ' AND  date_format(Payment.created, "%Y-%m-%d") LIKE "%'.$this->request->params['form']['date'].'%"';

		}
		if($this->request->params['form']['startdate']!="0" && $this->request->params['form']['enddate']!="0")

		{

			$this->request->params['form']['startdate'] = date("Y-m-d",strtotime($this->request->params['form']['startdate']));
			$this->request->params['form']['enddate'] = date("Y-m-d",strtotime($this->request->params['form']['enddate'])); 
			$sDateFrom = $this->request->params['form']['startdate'];
			$sDateTo = $this->request->params['form']['enddate'];
			$conditions.= ' AND date_format(Payment.created, "%Y-%m-%d") between "'.$this->request->params['form']['startdate'].'" AND  "'.$this->request->params['form']['enddate'].'"';				

		}
		elseif($this->request->params['form']['startdate']!="0" && $this->request->params['form']['enddate']=="0")
		{				

			$this->request->params['form']['startdate'] = date("Y-m-d",strtotime($this->request->params['form']['startdate']));
			$sDateFrom = $this->request->params['form']['startdate'];
			$conditions.= ' AND date_format(Payment.created, "%Y-%m-%d") >= "'.$this->request->params['form']['startdate'].'"';
		}

		elseif($this->request->params['form']['startdate']=="0" && $this->request->params['form']['enddate']!="0")

		{

			$this->request->params['form']['enddate'] = date("Y-m-d",strtotime($this->request->params['form']['enddate']));
			$sDateTo =$this->request->params['form']['enddate'];
			$conditions.= ' AND date_format(Payment.created, "%Y-%m-%d") <= "'.$this->request->params['form']['startdate'].'"';

		}			
 
		if(isset($this->request->params['form']['uname']))

		{

			$conditions.= "  AND  ( User.firstname like '".$this->request->params['form']['uname']."%' OR  User.lastname like '".$this->request->params['form']['uname']."%')";

		}

		$records = $this->Payment->find('all',array(

							'order' => array('date_format(Payment.created,"%Y-%m")' => 'desc','totalSale'=>'desc'),

							'fields' => array('User.id','User.firstname', 'User.lastname' , 'SUM(Payment.amount) as totalSale','Count(Payment.id) as  cnt', 'Payment.created','Payment.created','date_format(Payment.created,"%Y-%m") as datePay'),



							'joins'=>array(

											array(

											'type'=>'inner', 

											"table"=>"users", 

											"alias"=>"User",

											"conditions"=>array("User.id = Payment.user_id")					)

											),

							'conditions' => "User.status!=3 AND ".$conditions,

                           'group' => array('date_format(Payment.created,"%Y-%m")', 'Payment.user_id')));

         $this->set("data",$records);

		 $this->render("reports_detail","ajax");

	}
	


	/****************** View All Payments Done By a USER ****************************************/



	function viewPayments($userID=0)

	{

		$this->breadcrumb['Home']='/admin/home/';

		$this->breadcrumb['View Reports']='admin/viewReport';

		$this->breadcrumb['Payments']='';



		if($userID > 0)

		{

			$paymentrec = $this->Payment->find("all" ,

												array("conditions"=>array('user_id'=>$userID),

													"fields"=>array("id","amount","transaction_id","created", 'User.firstname', 'User.lastname' ),

													"order"=>"created DESC",

													'joins'=>array(

																array(

																'type'=>'inner', 

																"table"=>"users", 

																"alias"=>"User",

																"conditions"=>array("User.id = Payment.user_id")					)

																),

													

															));

			$i=0;

			foreach($paymentrec as $rec)

			{

				$created = strtotime($rec['Payment']['created']);

				$paymentrec[$i]['Payment']['created'] = date('M d Y',$created );

				$i++;

			}

			

			$this->set("paymentrec" , $paymentrec);

			

		}

	}
	/**
	 * 
	 */
	function changeMembership($userId, $pckg_id="")
	{
	 	
	 	$userdata = $this->User->find('first',array(
		"fields"=>"User.*, Package.*, UserType.title",
		"conditions"=>"User.id = ".$userId,
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
		$this->set('userdata',$userdata);	$dta = $this->Package->findById($pckg_id);
		$this->set("user_id", $userId);		
		if(isset($pckg_id) && !isNull($pckg_id))
		{
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
							$paymentData['user_id'] = $userId;
							$paymentData['transaction_id'] = $resArray['PROFILEID'];		
							$paymentData['expiryofsubscription'] = date("Y-m-d", strtotime("+ ".$dta['Package']['duration']." day"));
						
							$this->Payment->id = -1;
							$this->Payment->Save($paymentData);
							$this->Session->write("user_type", $dta['Package']['user_type_id']);
							//we will send email to the user
							$this->User->id =  $userId;
							$this->User->save($resultData);
							$usr['User']['user_type_id'] = $userdata['User']['user_type_id'];
							$usr['User']['id'] = $userId;
							$usr['User']['firstname'] = $userdata['User']['firstname'];
							$usr['User']['lastname'] = $userdata['User']['lastname'];
							
					 		$this->userPlanUpdate($dta, $usr);
							$this->Session->setFlash(PACKAGE_UPDATED);
		 	 				$ref = $this->Session->read("referrer");
							$this->Session->delete("referrer");
							$this->redirect($ref);
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
				$this->layout = "default_admin_inner";
				$this->render("upgrade_membership");
			}
			else 
			{
				$payment = $this->Payment->find("first",array("conditions"=>"Payment.user_id=".$userId));			 
			 	if(isset($payment['Payment']['transaction_id']))
				{
					//New package
					$dta = $this->Package->findById($pckg_id);				
					if(isset($dta['Package']['id']))
					{
						$postedData['profile_id'] = $payment['Payment']['transaction_id'];
						$postedData['amount'] = $dta['Package']['amount'];
						$postedData['notes'] = "Account upgrade/downgrade by the user";
				 		$res = $this->Paypal->updateRecurringProfile($postedData);
		 				if(isset($res['ACK']) && $res['ACK']="success")
						{	
							//we will send email to the user 
					 		$this->userPlanUpdate($dta, $userdata);
							$this->Session->setFlash(PACKAGE_UPDATED);
						}
						else {
							$this->Session->setFlash(PACKAGE_CANT_UPDATED);
						}
					}
					$ref = $this->Session->read("referrer");
					$this->Session->delete("referrer");
					$this->redirect($ref);
				}
			}
		}
		else 
		{
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
			"order"=>"Package.user_type_id ASC, Package.amount ASC")
			);
			$this->set("packages",$packages);
		 	$this->Session->write("referrer", $this->referer());
			$this->render("change_membership","ajax");
		}
	} 
}

?>