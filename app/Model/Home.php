<?php
	class Home extends AppModel {
	   var $name = 'home';
	   var $errMsg=array();
	   var $err=0;
		/*
			Called from cake_login controller to get valid user data
			@param1 Username
			@param2 Password
		*/
	    function isValidLoginDetails($postArray){
	 	if(isNull($postArray['username'])){
			//	echo "test";
				//die;
				$this->errMsg[]=ERR_USERNAME_EMPTY;
				$this->err=1;
			}

			if(isNull($postArray['password'])){
				$this->errMsg[]=ERR_PASSWORD_EMPTY;
				$this->err=1;
			}

		  return $this->err;
	    }

		function getLoginDetails($login, $passwd){
			$data = $this->__getAclData($login, md5($passwd));
			if(isNull($data)){
				$this->errMsg[] = ERR_NOT_AUTHORIZED;
				$this->err=1;
			}else{
				return $data;
			}

		}//EF

		/*Function to return admin data if login is valid*/
		Private function __getAclData($login, $passwd) {
			$data = $this->find("username = '{$login}' AND password = '{$passwd}' AND status='1'");
			return $data;
		}//EF
	}
?>
