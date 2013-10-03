<?php
/*
	PROJECT MANAGER: Harpreet Singh
	CREATED : 6 Dec 2010
	AUTHOR: MRK
	*Model to handle data modifications and fetches related to Admin model(table)
*/
class Admin extends AppModel {
	var $name='Admin';
	var $useTable= "admins";
	var $errMsg=array();
	var $err=0;
	var $id='';
	var $email='';
	//Association(JOin) b/w Admin & MOdules
 

	function isValidLoginDetails($posted){

		if(isNull($posted['username'])){
			$this->errMsg[]=ERR_USERNAME_EMPTY;
			$this->err=1;
		}

		if(isNull($posted['password'])){
			$this->errMsg[]=ERR_PASSWORD_EMPTY;
			$this->err=1;
		}

		//If no error
		if(!$this->err){
			$data=$this->__getAclData($posted['username'], md5($posted['password']));
			if(isNull($data)){
				$this->errMsg[] = ERR_NOT_AUTHORIZED;
				$this->err=1;
			}else{
				return $data;
			}
		}
		return array();//Returning a empty array
	}//EF


	/*Function to return admin data if login is valid*/
	Private function __getAclData( $login, $passwd) {
		$data = $this->find('first',array('conditions'=>"Admin.userName = '{$login}' AND Admin.password = '{$passwd}'"));
		return $data;
	}//EF

	

	/*Function to check old passowrd*/
	function __isPasswordValid($oldPassword,$userid){
		$data = $this->find("password='".md5($oldPassword)."' AND id='".$userid."'",'Admin.id');
		if($data){
			return true;
		}
		return false;
	}//EF

	/*
		Function to check username already exists or not
		@param1 Username
		@param2 AdminId
	*/
	Private function __isUserNameExists($userName,$adminId='',$retEmail=0){
		$data = $this->find("loginName = '$userName' AND id != $adminId",'Admin.id,Admin.email,Admin.loginName,Admin.firstName');
		if(!isNull($data)){
			$this->id = $data['Admin']['id'];
			$this->sUserName = $data['Admin']['loginName'];
			$this->sFirstName = $data['Admin']['firstName'];
			if(!isNull($adminId) && $data['Admin']['id'] == $adminId){
				return false;
			}
			if($retEmail){
				return $data['Admin']['email'];
			}
			return true;
		}
		if($retEmail){
			return "";
		}
		return false;
	}//EF

	/*
		Function to check username already exists or not
		@param1 Username
		@param2 AdminId
	*/


	function validateAllPasswords($postArray,$id="") {
		if(isNull($postArray['cpassword'])){
			$this->errMsg[]=MSG_CPASSWORD_EMPTY;
			$this->err=1;
		}
		$arUser = $this->read(null, $id);
		
		if(!isNull($postArray['cpassword'])){
			if(md5($postArray['cpassword']) != $arUser['Admin']['password']) {
				$this->errMsg[]=ERR_OLDPASSWORD_INVALID;
				$this->err=1;
			}
		}
		if(isNull($postArray['newpassword'])){
			$this->errMsg[]=ERR_NEWPASSWORD_EMPTY;
			$this->err=1;
		}
		if(isNull($postArray['newconfirmpassword'])){
			$this->errMsg[]=ERR_NEWCONFIRMPASSWORD_EMPTY;
			$this->err=1;
		}
		if($postArray['newpassword'] != $postArray['newconfirmpassword']) {
			$this->errMsg[]=ERR_PASSWORD_NOT_MATCH;
			$this->err=1;
		}
  		return $this->err;
	}

}//End-class
?>