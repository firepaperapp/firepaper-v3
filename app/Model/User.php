<?php
/*
	PROJECT MANAGER: Harpreet Singh
	CREATED : 7 Dec 2010
	AUTHOR: MRK
	*Model to handle data modifications and fetches related to User(users)(table)
*/
	class User extends AppModel {
	   var $name = 'users';
	   var $loginUser = "";
	   var $errMsg=array();
	   var $err=0;
	  /*Function to validate User fields add/edit*/
		function validateUserForm($postArray, $capCode="") {
        
         /*if ((!isset($postArray['sitetitle']) || empty($postArray['sitetitle'])) && $this->request->data['User']['user_type_id'] == 1) {
            $this->errMsg[] = ERR_sitetitle_EMPTY;
            $this->err = 1;
        } else */ if (!isset($postArray['email']) || empty($postArray['email'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['email'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['password']) || empty($postArray['password'])) {
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['password'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if (!isset($postArray['cpassword']) || empty($postArray['cpassword'])) {
            $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
            $this->err = 1;
        }
        if (isset($postArray['password']) && $postArray['password'] != '' && isset($postArray['cpassword']) && $postArray['cpassword']) {
            if ($postArray['password'] != $postArray['cpassword']) {
                $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                $this->err = 1;
            }
        }
        
        if (!isset($postArray['firstname']) || empty($postArray['firstname'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['timezone']) || empty($postArray['timezone'])) {
            $this->errMsg[] = ERR_TIMEZONE_EMPTY;
            $this->err = 1;
        }
       if (!isset($postArray['sSecurityCode']) || empty($postArray['sSecurityCode'])) {
            $this->errMsg[] = ERR_CAPTCHA_EMPTY;
            $this->err = 1;
        } elseif (strtolower($postArray['sSecurityCode']) != strtolower($capCode)) {
            $this->errMsg[] = ERR_WRONG_CAPTCHA_CODE;
            $this->err = 1;
        }
        if ($this->err == 0) {
            //we will check do user with same email already exist in the db.
            $users = $this->find('all',
                            array("conditions" => "User.username = '" . add_Slashes($postArray['username']) . "' OR User.email = '" . add_Slashes($postArray['email']) /*. "' OR User.sitetitle = '" . add_Slashes($postArray['sitetitle'])*/. "'")
            );
          
            $emailExist = false;
            $usernameExist = false;
            $sittitleExist = false;
            if (count($users) > 0 && isset($users[0]['User'])) 
            {
            	 
            	foreach($users as $rec)
            	{
            		if($rec['User']['email'] == $postArray['email'] && $emailExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_EMAIL_EXIST; 			
            			$emailExist = true;
            			$this->err = 1;
            		}
            		if($rec['User']['sitetitle'] == $postArray['sitetitle']  && $sittitleExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_SITETITLE_EXIST; 			
            			$sittitleExist = true;
            			$this->err = 1;
            		}
            		if($rec['User']['username'] == $postArray['username'] && $usernameExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_USERNAME_EXIST; 			
            			$usernameExist = true;
            			$this->err = 1;
            		}
            	}  
 
               
            }
        }
        return $this->err;
    }

    /*Function to validate User fields on admin end*/
		function validateOnAdminEnd($postArray, $userId) {
        
         /*if (!isset($postArray['sitetitle']) || empty($postArray['sitetitle'])) {
            $this->errMsg[] = ERR_sitetitle_EMPTY;
            $this->err = 1;
        } else*/ if (!isset($postArray['email']) || empty($postArray['email'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['email'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['password']) || empty($postArray['password'])) {
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['password'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if (!isset($postArray['confirmpassword']) || empty($postArray['confirmpassword'])) {
            $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
            $this->err = 1;
        }
        if (isset($postArray['password']) && $postArray['password'] != '' && isset($postArray['confirmpassword']) && $postArray['confirmpassword']) {
            if ($postArray['password'] != $postArray['confirmpassword']) {
                $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                $this->err = 1;
            }
        }
        
        if (!isset($postArray['firstname']) || empty($postArray['firstname'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['timezone']) || empty($postArray['timezone'])) {
            $this->errMsg[] = ERR_TIMEZONE_EMPTY;
            $this->err = 1;
        }
       
        if ($this->err == 0) {
            //we will check do user with same email already exist in the db.
            $users = $this->find('all',
                            array("conditions" => "User.id!= $userId AND (User.username = '" . add_Slashes($postArray['username']) . "' OR User.email = '" . add_Slashes($postArray['email']) . "' OR User.sitetitle = '" . add_Slashes($postArray['sitetitle']) . "')")
            );
          
            $emailExist = false;
            $usernameExist = false;
            $sittitleExist = false;
            if (count($users) > 0 && isset($users[0]['User'])) 
            {
            	 
            	foreach($users as $rec)
            	{
            		if($rec['User']['email'] == $postArray['email'] && $emailExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_EMAIL_EXIST; 			
            			$emailExist = true;
            			$this->err = 1;
            		}
            		if($rec['User']['sitetitle'] == $postArray['sitetitle']  && $sittitleExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_u_EXIST; 			
            			$sittitleExist = true;
            			$this->err = 1;
            		}
            		if($rec['User']['username'] == $postArray['username'] && $usernameExist==false)
            		{
            			$this->errMsg[] = ERR_SAME_USERNAME_EXIST; 			
            			$usernameExist = true;
            			$this->err = 1;
            		}
            	}  
 
               
            }
        }
        return $this->err;
    }
    function isUserNameExists($postArray,$userId){
		  if(!isNull($postArray['username'])){
		   	  if($userId ==""){
				  $data = $this->find("username ='".$postArray['username']."'");
				}else{
				  $data = $this->find('first',array('conditions' => array('username' =>$postArray['username'], 'id !='=>$userId)));
				}
				if(!isNull($data)){
				    $this->errMsg[]=ERR_USER_NAME_EXITS;
					$this->err=1;
				}
		    }
		    if(!isNull($postArray['email'])){
		    	if($userId ==""){
				  $data = $this->find("email ='".$postArray['email']."'");
				}else{
				  $data = $this->find('first',array('conditions' => array('email' => $postArray['email'], 'id !=' => $userId)));
			     }
				if(!isNull($data)){
			 	   $this->errMsg[]=ERR_USER_EMAIL_EXITS;
				   $this->err=1;
				}
		    }
		return $this->err;
	}//EF
	/*
		validate the signup step2 data
		 
	*/
	function validateStep2Form($postArray)
	{
		if (!isset($postArray['nameoncard']) || empty($postArray['nameoncard'])) {
            $this->errMsg[] = ERR_NAME_ONCARD_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['cardnumber']) || empty($postArray['cardnumber'])) {
            $this->errMsg[] = ERR_CARDNUMBER_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['expiredate']) || empty($postArray['expiredate'])) {
            $this->errMsg[] = ERR_EXPIRE_DATE_EMPTY;
            $this->err = 1;
        } else {
            if (strtotime($postArray['expiredate']) <= strtotime(date("Y-m-d"))) {
                $this->errMsg[] = ERR_NOT_VALID_DATE;
                $this->err = 1;
            }
        }
      //   die;
        if (!isset($postArray['cardtype']) || empty($postArray['cardtype'])) {
            $this->errMsg[] = ERR_CARD_TYPE_EMPTY;
            $this->err = 1;
        }
        if ($this->err == 0) {
            $valid = $this->fnValidateCC($postArray['cardnumber'], $postArray['cardtype']);
            if (!$valid) {
                $this->errMsg[] = ERR_USER_CREDIT_CARD_TYPE_NOT_VALID_EMPTY;
                $this->err = 1;
            }
        }
        if (empty($postArray['addrsline1']) && empty($postArray['addrsline2'])) {
            $this->errMsg[] = ERR_ADDR_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['city']) || empty($postArray['city'])) {
            $this->errMsg[] = ERR_CITY_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vState']) || empty($postArray['vState'])) {
            $this->errMsg[] = ERR_STATE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['zipcode']) || empty($postArray['zipcode'])) {
            $this->errMsg[] = ERR_ZIPCODE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['country']) || empty($postArray['country'])) {
            $this->errMsg[] = ERR_COUNTRY_EMPTY;
            $this->err = 1;
        }
        return $this->err;
	}
	/**
	 * To validate the credit card
	 *
	 * @param unknown_type $cc_num credit card number
	 * @param unknown_type $type credit card type
	 * @return unknown
	 */
	 function fnValidateCC($cc_num, $type) {
        if ($type == "American") {
            $denum = "American Express";
        } elseif ($type == "Discover") {
            $denum = "Discover";
        } elseif ($type == "Master") {
            $denum = "Master Card";
        } elseif ($type == "Visa") {
            $denum = "Visa";
        }
        if ($type == "American") {
            $pattern = "/^([34|37]{2})([0-9]{13})$/"; //American Express
            if (preg_match($pattern, $cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }
        } elseif ($type == "Discover") {
            $pattern = "/^([6011]{4})([0-9]{12})$/"; //Discover Card
            if (preg_match($pattern, $cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }
        } elseif ($type == "Master") {
            //$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
            $pattern = "/^(5[1-5][0-9]{14})+$/"; //Mastercard
            if (preg_match($pattern, $cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }
        } elseif ($type == "Visa") {
            $pattern = "/^([4]{1})([0-9]{12,15})$/"; //Visa
            if (preg_match($pattern, $cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }
        }
        if ($verified == false) {
            return false;
        } else { //if it will pass...do something
            return true;
        }
    }
	/*
		Called from cake_login controller to get valid user data
		@param1 Username
		@param2 Password
	*/
    function isValidLoginDetails($postArray){
 		if(isNull($postArray['username'])){
			$this->errMsg[]=ERR_USERNAME_EMPTY;
			$this->err=1;
		}

		if(isNull($postArray['password'])){
			$this->errMsg[]=ERR_PASSWORD_EMPTY;
			$this->err=1;
		}
		return $this->err;
    }
    /**
     * validate the user
     *
     * @param string $userName - username
     * @return Error flag
     */
     function ValidateUser($userName) {
        $this->err = 0;
    //    $userData = $this->findByemail($userName);

		$userData = $this->find('first', array('conditions'=>array('User.email'=>$userName),
												'joins'=>array(
															array(
														'type'=>'inner', 
														"table"=>"user_types", 
														"alias"=>"userTypes",
														"conditions"=>array("userTypes.id = User.user_type_id")					)
																),
												'fields'=>array('User.*','userTypes.cansignup')

								));
		
   
        if (!isset($userData['User']['id'])) {
            $this->errMsg[] = ERR_VALID_USER;
            $this->err = 1;
        } else {
            
            $userId = $userData['User']['id'];
			$userData['User']['cansignup'] = $userData['userTypes']['cansignup'];
            $this->loginUser = $userData['User'];
            if (count($this->loginUser) == 0) 
            {
                $this->errMsg[] = ERR_ACCOUNT_VALIDATED;
                $this->err = 1;
            } 
            else 
            {
                //Update status to one if its valid URL
                $dat['status'] = 1;
                $this->id = $userData['User']['id'];
                $this->Save($dat);
            }
        }
        return $this->err;
    }
    /*     * ********************** function to validate login********************* */

    function validateLoginForm($postArray) {
        /* echo "<pre>";
          print_r($postArray);
          die("here"); */
        if (!isset($postArray['username']) || empty($postArray['username'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } 
        if (!isset($postArray['password']) || empty($postArray['password'])) {//change
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['password'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if ($this->err == 0) {

           $userData = $this->find('first', 
           			array("conditions"=>"( User.username = '".add_Slashes($postArray['username'])."' OR User.email = '".add_Slashes($postArray['username'])."') and User.password ='".add_Slashes(md5($postArray['password']))."'",
					'joins'=>array(array(
											'type'=>'inner', 
											"table"=>"user_types", 
											"alias"=>"userTypes",
											"conditions"=>array("userTypes.id = User.user_type_id"))),
					'fields'=>array('User.*','userTypes.cansignup')			
							));

						 
            if (!isset($userData['User']['id'])) {
            	
	          	$this->errMsg[] = ERR_LOGIN_RECORD_NOT_FOUND;
	            $this->err = 1;
	        } 
	        else 
	        {
	        	if ($userData['User']['status'] !=1)
	        	{
	        		if ($userData['User']['status'] == 2)
	        		{
		        		$this->errMsg[] = YOUR_ACCNT_SUSPENED;
		            	$this->err = 1;
	        		}
	        		else 
	        		{
	        			
		        		$this->errMsg[] = YOUR_ACCNT_DELETED;
		            	$this->err = 1;
	        		}
	        	}
	        	else 
	        	{	
					$userData['User']['cansignup'] = $userData['userTypes']['cansignup'];
	             	$this->loginUser = $userData['User'];
	             	if($userData['User']['admin_id']!=0)
	             	{
	             		$adminDetails = $this->findById($userData['User']['admin_id'], "status");			
					 	if($adminDetails['User']['status'] !=1)
			        	{
			        		if ($adminDetails['User']['status'] == 2)
			        		{
				        		$this->errMsg[] = YOUR_ADMIN_ACCNT_SUSPENED;
				            	$this->err = 1;
			        		}
			        		else 
			        		{
			        			
				        		$this->errMsg[] = YOUR_ADMIN_ACCNT_DELETED;
				            	$this->err = 1;
			        		}
			        	}
	             	}
	        	}
            
            }
        }
        return $this->err;
    }
	  /*     * **************** end function to validate login********************* */

    /*     * ********************** function to validate forgot password********************* */

    function validateForgotForm($postArray) {

        if (!isset($postArray['email']) || empty($postArray['email'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } 
        else if (!validateEmail($postArray['email'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
      
        if ($this->err == 0) {
            //we will check do user with same email already exist in the db.
           // $result = $this->find("User.email = '".add_Slashes($postArray['email'])."'", "id, email, username, firstname, lastname");

		$mail = add_Slashes($postArray['email']);
		$sQuery = "SELECT * FROM users WHERE users.email = '$mail'";
		$result = $this->Query($sQuery);

  	 	if (count($result) > 0 && isset($result[0]['users']['id'])) {
                    $this->err = 0;
                    return $result;
                
            } else {
                $this->errMsg[] = ERR_RECORD_NOT_FOUND;
                $this->err = 1;
            }
        }
        return $this->err;
    }


/************************ TO CHECK EMAIL ALREADY EXISTS WHILE UPDATING A RECORD*****************/ 

	function isEmailExists($email,$userid)
	{			
		
	}

	/************************ GET THE USER RECORD TO SET VALUE IN SESSION *****************/ 

	function getUserData($userid)
	{			
		$userData = $this->find('first', array('conditions'=>array('User.id'=>$userid),
												'joins'=>array(
															array(
														'type'=>'inner', 
														"table"=>"user_types", 
														"alias"=>"userTypes",
														"conditions"=>array("userTypes.id = User.user_type_id")					)
																),
												'fields'=>array('User.*','userTypes.cansignup')

								));

		$userData['User']['cansignup'] = $userData['userTypes']['cansignup'];
		return $userData['User'];
		
	}
	/* TO reduce or increase the space of the user if he has uploaded a new file**/
	function manageUserSpace($uploadedSize, $userId, $action="add")
	{
		if($action=="add")
		{
		$sQuery = "UPDATE users SET usedspace = usedspace+".$uploadedSize." WHERE id = ".$userId;
		}
		else {
		$sQuery = "UPDATE users SET usedspace = usedspace-".$uploadedSize." WHERE id = ".$userId;	
		}
		$this->Query($sQuery);
	}
	//To get the student marks in different projects according to subjects
	function getProgressOfStudent($user_id)
	{
		$qry = "SELECT Subject.id, Subject.title, Project.id, Project.title, sum( projectTask.weight ) as totalWeight, (
		SELECT sum( projectStudentTaskMark.marks )
		FROM project_student_task_marks projectStudentTaskMark
		WHERE projectStudentTaskMark.project_id = Project.id
		) AS marksObtained
		FROM project_students AS prjStudent
		INNER JOIN projects Project ON Project.id = prjStudent.project_id
		INNER JOIN subjects Subject ON Subject.id = Project.subject_id
		LEFT JOIN project_tasks projectTask ON projectTask.project_id = Project.id
		WHERE prjStudent.user_id = ".$user_id."  AND prjStudent.completed = 1
		GROUP BY Project.id
		ORDER BY Subject.id, Project.title ASC";
		$rs = $this->query($qry);
		return $rs;
	}
	
}
?>