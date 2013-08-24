<?php

/*
  PROJECT MANAGER: HARPREET SINGH
  LAST MODIFIED: 6 Sep 2010
  AUTHOR: MRK
 * Challege Question retrieval, add, edit, delete
 */

class Account extends AppModel {

    var $name = 'Account';
    var $useTable = "SUBSCRIBER";
    var $errMsg = array();
    var $successMsg = array();
    var $err = 0;
    var $loginUser = array();

  /*function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
 
	return 5;
}*/

    private function validatePromoCode($promoCode) {
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return -1;
        // from now you need this Oracle specific approach
        $PO_PROMO_ID = null;
        $PI_PROMO_CODE = $promoCode;

        try {
            $statement = oci_parse($connection,
                            "BEGIN
				        validatepromocode
						(
						:po_promo_id,
						:pi_promo_code
						); 
	end;");
            oci_bind_by_name($statement, ':po_promo_id', $PO_PROMO_ID, 100);
            oci_bind_by_name($statement, ':pi_promo_code', $PI_PROMO_CODE, 100);
            oci_execute($statement);
        } catch (Exception $e) {
            return false;
        }
        if ($PO_PROMO_ID > 0) {
            return true;
        } else {
            return false;
        }
    }

    function validateAccountForm($postArray, $capCode="") {
        if (isset($postArray['vPromotionCode']) && !empty($postArray['vPromotionCode'])) {
            if (!($this->validatePromoCode($postArray['vPromotionCode']))) {
                $this->errMsg[] = ERR_PROMO_CODE;
                $this->err = 1;
            }
        }
        if (!isset($postArray['vEmail']) || empty($postArray['vEmail'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['vEmail'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['vServiceLevel']) || empty($postArray['vServiceLevel'])) {
            $this->errMsg[] = ERR_SERVICE_LEVEL_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vPassword']) || empty($postArray['vPassword'])) {
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['vPassword'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if (!isset($postArray['vConfrmPassword']) || empty($postArray['vConfrmPassword'])) {
            $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
            $this->err = 1;
        }
        if (isset($postArray['vPassword']) && $postArray['vPassword'] != '' && isset($postArray['vConfrmPassword']) && $postArray['vConfrmPassword']) {
            if ($postArray['vPassword'] != $postArray['vConfrmPassword']) {
                $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                $this->err = 1;
            }
        }
        if (!isset($postArray['vChallengeQuestion']) || empty($postArray['vChallengeQuestion'])) {
            $this->errMsg[] = ERR_SELECT_CHLNGQSTN;
            $this->err = 1;
        }
        if (!isset($postArray['vAnswer']) || empty($postArray['vAnswer'])) {
            $this->errMsg[] = ERR_CHALLENGE_ANSWER_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCompanyNote']) || empty($postArray['vCompanyNote'])) {
            $this->errMsg[] = ERR_COMPANY_NOTE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vFirstName']) || empty($postArray['vFirstName'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['vTimezone']) || empty($postArray['vTimezone'])) {
            $this->errMsg[] = ERR_TIMEZONE_EMPTY;
            $this->err = 1;
        }
        /* 	if(!isset($postArray['vAddrsline1']) || empty($postArray['vAddrsline1']))
          {
          $this->errMsg[]=ERR_ADDR_EMPTY;
          $this->err=1;
          }
          if(!isset($postArray['vCity']) || empty($postArray['vCity']))
          {
          $this->errMsg[]=ERR_CITY_EMPTY;
          $this->err=1;
          }
          if(!isset($postArray['vState']) || empty($postArray['vState']))
          {
          $this->errMsg[]=ERR_STATE_EMPTY;
          $this->err=1;
          }
          if(!isset($postArray['vZipCode']) || empty($postArray['vZipCode']))
          {
          $this->errMsg[]=ERR_ZIPCODE_EMPTY;
          $this->err=1;
          }
          if(!isset($postArray['vCountry']) || empty($postArray['vCountry']))
          {
          $this->errMsg[]=ERR_COUNTRY_EMPTY;
          $this->err=1;
          } */
        if (!isset($postArray['sSecurityCode']) || empty($postArray['sSecurityCode'])) {
            $this->errMsg[] = ERR_CAPTCHA_EMPTY;
            $this->err = 1;
        } elseif (strtolower($postArray['sSecurityCode']) != strtolower($capCode)) {
            $this->errMsg[] = ERR_WRONG_CAPTCHA_CODE;
            $this->err = 1;
        }
        if ($this->err == 0) {
            //we will check do user with same email already exist in the db.
            $count = $this->find('count',
                            array("conditions" => "Account.ACCT_USERNAME = '" . $postArray['vEmail'] . "'")
            );
            if ($count > 0) {
                $this->errMsg[] = ERR_SAME_EMAIL_EXIST;
                $this->err = 1;
            }
        }
        return $this->err;
    }

    /**
     * Stores the step1 user data in the database by calling create_subscriber function.
     *
     * @return true or false
     */
    /*
     * function to validate edit account

     */
    function validateEditAccountForm($postArray) {
        /* echo "<pre>";
          print_r($postArray);die("here"); */
        if (isset($postArray['vChangePassword']) && ($postArray['vChangePassword'] == 1)) {

            if (!isset($postArray['vPassword']) || empty($postArray['vPassword'])) {
                $this->errMsg[] = ERR_PASSWORD_EMPTY;
                $this->err = 1;
            } else if (strlen(trim($postArray['vPassword'])) < 5) {
                $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
                $this->err = 1;
            }
            if (!isset($postArray['vConfrmPassword']) || empty($postArray['vConfrmPassword'])) {
                $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
                $this->err = 1;
            }
            if (isset($postArray['vPassword']) && $postArray['vPassword'] != '' && isset($postArray['vConfrmPassword']) && $postArray['vConfrmPassword']) {
                if ($postArray['vPassword'] != $postArray['vConfrmPassword']) {
                    $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                    $this->err = 1;
                }
            }
        }
        if (!isset($postArray['vCompanyNote']) || empty($postArray['vCompanyNote'])) {
            $this->errMsg[] = ERR_COMPANY_NOTE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vFirstName']) || empty($postArray['vFirstName'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['vTimezone']) || empty($postArray['vTimezone'])) {
            $this->errMsg[] = ERR_TIMEZONE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vAddrsline1']) || empty($postArray['vAddrsline1'])) {
            $this->errMsg[] = ERR_ADDR_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCity']) || empty($postArray['vCity'])) {
            $this->errMsg[] = ERR_CITY_EMPTY;
            $this->err = 1;
        }

        if (!isset($postArray['vState']) || empty($postArray['vState'])) {
            $this->errMsg[] = ERR_STATE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vZipCode']) || empty($postArray['vZipCode'])) {
            $this->errMsg[] = ERR_ZIPCODE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCountry']) || empty($postArray['vCountry'])) {
            $this->errMsg[] = ERR_COUNTRY_EMPTY;
            $this->err = 1;
        }
        if(isset($postArray['updateCC']) && $postArray['updateCC']==1)
        {
        	 if (!isset($postArray['vNameOnCard']) || empty($postArray['vNameOnCard'])) {
                    $this->errMsg[] = ERR_NAME_ONCARD_EMPTY;
                    $this->err = 1;
                }
                if (!isset($postArray['vCardNumber']) || empty($postArray['vCardNumber'])) {
                    $this->errMsg[] = ERR_CARDNUMBER_EMPTY;
                    $this->err = 1;
                }
                if (!isset($postArray['vExpireDate']) || empty($postArray['vExpireDate'])) {
                    $this->errMsg[] = ERR_EXPIRE_DATE_EMPTY;
                    $this->err = 1;
                } else {
                    if (strtotime($postArray['vExpireDate']) <= strtotime(date("Y-m-d"))) {
                        $this->errMsg[] = ERR_NOT_VALID_DATE;
                        $this->err = 1;
                    }
                }
                if (!isset($postArray['vCardType']) || empty($postArray['vCardType'])) {
                    $this->errMsg[] = ERR_CARD_TYPE_EMPTY;
                    $this->err = 1;
                }
                if ($this->err == 0) {
                    $valid = $this->fnValidateCC($postArray['vCardNumber'], $postArray['vCardType']);
                    if (!$valid) {
                        $this->errMsg[] = ERR_USER_CREDIT_CARD_TYPE_NOT_VALID_EMPTY;
                        $this->err = 1;
                    }
                }
        }
        /* if($this->err==0)
          {
          //we will check do user with same email already exist in the db.
          $count = $this->find('count',
          array("conditions"=>"Account.ACCT_USERNAME = '".$postArray['vEmail']."'")
          );
          if($count>0)
          {
          $this->errMsg[] = ERR_SAME_EMAIL_EXIST;
          $this->err=1;
          }
          } */
        return $this->err;
    }

    /**
     * Function to update subscriber
     *
     * @param array $data
     * @return boolean
     */
    function updateSubscriber($data) {
        /* echo "<pre>";
          print_r($data);die("here"); */
        // every model has a datasource
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return false;
        // from now you need this Oracle specific approach
        $PO_RESULT_CODE = null;
        $PI_ACCT_ID = $data['UserID'];
        $PI_SERVICE_LEVEL = $data['service_id'];
        $PI_USERNAME = $data['vUsername'];
        if (strlen($data['vPassword']) > 3 && ($data['vChangePassword'] == 1)) {
            $PI_PASSWORD = md5($data['vPassword']);
        } else {
            $PI_PASSWORD = null;
        }

        $PI_FIRSTNAME = $data['vFirstName'];
        $PI_LASTNAME = $data['vLastName'];
        $PI_COMPANYNAME = $data['vCompanyNote'];
        $PI_PHONE1_TYPE = $data['vPhoneType1'];
        $PI_PHONE1_NUM = $data['vPhone1'];
        $PI_PHONE2_TYPE = $data['vPhoneType2'];
        $PI_PHONE2_NUM = $data['vPhone2'];
        $PI_PHONE3_TYPE = $data['vPhoneType3'];
        $PI_PHONE3_NUM = $data['vPhone3'];
        $PI_TIMEZONE = $data['vTimezone'];
        $PI_BILL_METHOD = isset($data['vBillingMethod'])&&$data['vBillingMethod']!=''?$data['vBillingMethod']:Null;  //$data['vBillingMethod'];
        $PI_PAYPAL_EMAIL = Null; //$data['vPayPalEmail'];
        $PI_CC_TYPE = isset($data['vCardType'])&&$data['vCardType']!=''?$data['vCardType']:Null; // $data['vCardType'];
        $PI_CC_NUMBER = isset($data['vCardNumber'])&&$data['vCardNumber']!=''?substr_replace($data['vCardNumber'], "************",0,12):Null; //$data['vCardNumber'];
        $PI_CC_CVN = isset($data['vCCVCode'])&&$data['vCCVCode']!=''?$data['vCCVCode']:Null;//$data['vCCVCode'];
        if(isset($data['vExpireDate'])&&$data['vExpireDate']!='')
        {
        	$arr = explode("/", $data['vExpireDate']);
        	$data['vExpireDate'] = date("Y-m-d",mktime(0,0,0,$arr[0], $arr[1], $arr[2]));
        }
        else{
        	$data['vExpireDate'] = Null;
        }
        $PI_CC_EXPIRE_DATE = $data['vExpireDate']; //
        //$PI_CC_EXPIRE_DATE = $data['vExpireDate'];
        $PI_CC_NAME = isset($data['vNameOnCard'])&&$data['vNameOnCard']!=''?$data['vNameOnCard']:Null; //$data['vNameOnCard'];
        $PI_BILLING_ADDRESS1 = $data['vAddrsline1'];
        $PI_BILLING_ADDRESS2 = $data['vAddrsline2'];
        $PI_BILLING_PHONE = null;
        $PI_BILLING_CITY = $data['vCity'];
        $PI_BILLING_STATE = $data['vState'];
        $PI_BILLING_ZIP = $data['vZipCode'];
        $PI_BILLING_COUNTRY = $data['vCountry'];
        $PI_BILLING_ACHROUTING = Null; //$data['vBRNumber'];
        $PI_BILLING_ACHACCOUNT = Null; //$data['vBANumber'];
        try {
            $statement = oci_parse($connection,
                            "begin
			        UPDATE_SUBSCRIBER
					(
					:po_result_code,
					:pi_acct_id,
					:pi_service_level,
					:pi_username,
					:pi_password,
					:pi_firstname,
					:pi_lastname,
					:pi_companyname,
					:pi_phone1_type,
					:pi_phone1_num,
					:pi_phone2_type,
					:pi_phone2_num,
					:pi_phone3_type,
					:pi_phone3_num,
					:pi_timezone,
					:pi_bill_method,
					:pi_paypal_email,
					:pi_cc_type,
					:pi_cc_number,
					:pi_cc_cvn,
					:pi_cc_expire_date,
					:pi_cc_name,
					:pi_billaddress1,
					:pi_billaddress2,
					:pi_billphone,
					:pi_billcity,
					:pi_billstate,
					:pi_billzip,
					:pi_billcountry,
					:pi_billachrouting,
					:pi_billachaccount
					); 
end;");
            oci_bind_by_name($statement, ':po_result_code', $PO_RESULT_CODE, 100);
            oci_bind_by_name($statement, ':pi_acct_id', $PI_ACCT_ID, 100);
            oci_bind_by_name($statement, ':pi_service_level', $PI_SERVICE_LEVEL, 100);
            oci_bind_by_name($statement, ':pi_username', $PI_USERNAME, 100);
            oci_bind_by_name($statement, ':pi_password', $PI_PASSWORD, 250);
            oci_bind_by_name($statement, ':pi_firstname', $PI_FIRSTNAME, 100);
            oci_bind_by_name($statement, ':pi_lastname', $PI_LASTNAME, 100);
            oci_bind_by_name($statement, ':pi_companyname', $PI_COMPANYNAME, 100);
            oci_bind_by_name($statement, ':pi_phone1_type', $PI_PHONE1_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone1_num', $PI_PHONE1_NUM, 100);
            oci_bind_by_name($statement, ':pi_phone2_type', $PI_PHONE2_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone2_num', $PI_PHONE2_NUM, 100);
            oci_bind_by_name($statement, ':pi_phone3_type', $PI_PHONE3_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone3_num', $PI_PHONE3_NUM, 100);
            oci_bind_by_name($statement, ':pi_timezone', $PI_TIMEZONE, 100);
            oci_bind_by_name($statement, ':pi_bill_method', $PI_BILL_METHOD, 100);
            oci_bind_by_name($statement, ':pi_paypal_email', $PI_PAYPAL_EMAIL, 100);
            oci_bind_by_name($statement, ':pi_cc_type', $PI_CC_TYPE, 100);
            oci_bind_by_name($statement, ':pi_cc_number', $PI_CC_NUMBER, 100);
            oci_bind_by_name($statement, ':pi_cc_cvn', $PI_CC_CVN, 100);
            oci_bind_by_name($statement, ':pi_cc_expire_date', $PI_CC_EXPIRE_DATE, 100);
            oci_bind_by_name($statement, ':pi_cc_name', $PI_CC_NAME, 100);
            oci_bind_by_name($statement, ':pi_billaddress1', $PI_BILLING_ADDRESS1, 100);
            oci_bind_by_name($statement, ':pi_billaddress2', $PI_BILLING_ADDRESS2, 100);
            oci_bind_by_name($statement, ':pi_billphone', $PI_BILLING_PHONE, 100);
            oci_bind_by_name($statement, ':pi_billcity', $PI_BILLING_CITY, 100);
            oci_bind_by_name($statement, ':pi_billstate', $PI_BILLING_STATE, 100);
            oci_bind_by_name($statement, ':pi_billzip', $PI_BILLING_ZIP, 100);
            oci_bind_by_name($statement, ':pi_billcountry', $PI_BILLING_COUNTRY, 100);
            oci_bind_by_name($statement, ':pi_billachrouting', $PI_BILLING_ACHROUTING, 100);
            oci_bind_by_name($statement, ':pi_billachaccount', $PI_BILLING_ACHACCOUNT, 100);
            oci_execute($statement) or die("can't execute the statement");
        } catch (Exception $e) {
            return false;
        }

        if ($PO_RESULT_CODE == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
      Function to updare last use
     */

    function UpdateLastUse($userId, $firstUse=0) {
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return -1;
        // from now you need this Oracle specific approach
        $arrayData = array();
        $arrayData['PO_RESULT_CODE'] = null;
        $arrayData['PI_ACCT_ID'] = $userId;
        $arrayData['PI_FIRST_USE'] = $firstUse;
        try {
            $statement = oci_parse($connection,
                            "BEGIN
				        UPDATE_LAST_USE
						(
						:po_result_code,
						:pi_acct_id,
						:pi_first_use
						); 
	end;");
            oci_bind_by_name($statement, ':po_result_code', $arrayData['PO_RESULT_CODE'], 100);
            oci_bind_by_name($statement, ':pi_acct_id', $arrayData['PI_ACCT_ID'], 100);
            oci_bind_by_name($statement, ':pi_first_use', $arrayData['PI_FIRST_USE'], 100);
            oci_execute($statement) or die("can't execute the statement");
        } catch (Exception $e) {
            return false;
        }

        if ($PO_RESULT_CODE == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * function to validate edit sub account form

     */

    function validateEditSubAccountForm($postArray) {
        if (isset($postArray['vChangePassword']) && ($postArray['vChangePassword'] != 0)) {
            if (!isset($postArray['vPassword']) || empty($postArray['vPassword'])) {
                $this->errMsg[] = ERR_PASSWORD_EMPTY;
                $this->err = 1;
            } else if (strlen(trim($postArray['vPassword'])) < 5) {
                $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
                $this->err = 1;
            }
            if (!isset($postArray['vConfrmPassword']) || empty($postArray['vConfrmPassword'])) {
                $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
                $this->err = 1;
            }
        }

        if (isset($postArray['vPassword']) && $postArray['vPassword'] != '' && isset($postArray['vConfrmPassword']) && $postArray['vConfrmPassword']) {
            if ($postArray['vPassword'] != $postArray['vConfrmPassword']) {
                $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                $this->err = 1;
            }
        }
        if (!isset($postArray['vCompanyNote']) || empty($postArray['vCompanyNote'])) {
            $this->errMsg[] = ERR_COMPANY_NOTE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vFirstName']) || empty($postArray['vFirstName'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['vTimezone']) || empty($postArray['vTimezone'])) {
            $this->errMsg[] = ERR_TIMEZONE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vAddrsline1']) || empty($postArray['vAddrsline1'])) {
            $this->errMsg[] = ERR_ADDR_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCity']) || empty($postArray['vCity'])) {
            $this->errMsg[] = ERR_CITY_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vState']) || empty($postArray['vState'])) {
            $this->errMsg[] = ERR_STATE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vZipCode']) || empty($postArray['vZipCode'])) {
            $this->errMsg[] = ERR_ZIPCODE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCountry']) || empty($postArray['vCountry'])) {
            $this->errMsg[] = ERR_COUNTRY_EMPTY;
            $this->err = 1;
        }
        /* if($this->err==0)
          {
          //we will check do user with same email already exist in the db.
          $count = $this->find('count',
          array("conditions"=>"Account.ACCT_USERNAME = '".$postArray['vEmail']."'")
          );
          if($count>0)
          {
          $this->errMsg[] = ERR_SAME_EMAIL_EXIST;
          $this->err=1;
          }
          } */
        return $this->err;
    }

    /**
     * Function to update subscriber
     *
     * @param array $data
     * @return boolean
     */
    function updateSubSubscriber($data) {
//    	echo "<pre>";
//    	print_r($data);die("here");
        // every model has a datasource
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return -1;
        // from now you need this Oracle specific approach
        $PO_RESULT_CODE = null;
        $PI_ACCT_ID = $data['UserID'];
        $PI_SERVICE_LEVEL = 3; // there is logic in SP using service level
        $PI_USERNAME = $data['vEmail'];
        if (strlen($data['vPassword']) > 3 && ($data['vChangePassword'] == 1)) {
            $PI_PASSWORD = md5($data['vPassword']);
        } else {
            $PI_PASSWORD = null;
        }
        $PI_FIRSTNAME = $data['vFirstName'];
        $PI_LASTNAME = $data['vLastName'];
        $PI_COMPANYNAME = $data['vCompanyNote'];
        $PI_PHONE1_TYPE = $data['vPhoneType1'];
        $PI_PHONE1_NUM = $data['vPhone1'];
        $PI_PHONE2_TYPE = $data['vPhoneType2'];
        $PI_PHONE2_NUM = $data['vPhone2'];
        $PI_PHONE3_TYPE = $data['vPhoneType3'];
        $PI_PHONE3_NUM = $data['vPhone3'];
        $PI_TIMEZONE = $data['vTimezone'];
        $PI_BILL_METHOD = null;
        $PI_PAYPAL_EMAIL = null;
        $PI_CC_TYPE = null;
        $PI_CC_NUMBER = null;
        $PI_CC_CVN = null;
        $PI_CC_EXPIRE_DATE = null;

        $PI_CC_NAME = null;
        $PI_BILLING_ADDRESS1 = $data['vAddrsline1'];
        $PI_BILLING_ADDRESS2 = $data['vAddrsline2'];
        $PI_BILLING_PHONE = null;
        $PI_BILLING_CITY = $data['vCity'];
        $PI_BILLING_STATE = $data['vState'];
        $PI_BILLING_ZIP = $data['vZipCode'];
        $PI_BILLING_COUNTRY = $data['vCountry'];
        $PI_BILLING_ACHROUTING = null;
        $PI_BILLING_ACHACCOUNT = null;

        try {
            $statement = oci_parse($connection,
                            "begin
				        UPDATE_SUBSCRIBER
						(
						:po_result_code,
						:pi_acct_id,
						:pi_service_level,
						:pi_username,
						:pi_password,
						:pi_firstname,
						:pi_lastname,
						:pi_companyname,
						:pi_phone1_type,
						:pi_phone1_num,
						:pi_phone2_type,
						:pi_phone2_num,
						:pi_phone3_type,
						:pi_phone3_num,
						:pi_timezone,
						:pi_bill_method,
						:pi_paypal_email,
						:pi_cc_type,
						:pi_cc_number,
						:pi_cc_cvn,
						:pi_cc_expire_date,
						:pi_cc_name,
						:pi_billaddress1,
						:pi_billaddress2,
						:pi_billphone,
						:pi_billcity,
						:pi_billstate,
						:pi_billzip,
						:pi_billcountry,
						:pi_billachrouting,
						:pi_billachaccount
						); 
	end;");
            oci_bind_by_name($statement, ':po_result_code', $PO_RESULT_CODE, 100);
            oci_bind_by_name($statement, ':pi_acct_id', $PI_ACCT_ID, 100);
            oci_bind_by_name($statement, ':pi_service_level', $PI_SERVICE_LEVEL, 100);
            oci_bind_by_name($statement, ':pi_username', $PI_USERNAME, 100);
            oci_bind_by_name($statement, ':pi_password', $PI_PASSWORD, 250);
            oci_bind_by_name($statement, ':pi_firstname', $PI_FIRSTNAME, 100);
            oci_bind_by_name($statement, ':pi_lastname', $PI_LASTNAME, 100);
            oci_bind_by_name($statement, ':pi_companyname', $PI_COMPANYNAME, 100);
            oci_bind_by_name($statement, ':pi_phone1_type', $PI_PHONE1_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone1_num', $PI_PHONE1_NUM, 100);
            oci_bind_by_name($statement, ':pi_phone2_type', $PI_PHONE2_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone2_num', $PI_PHONE2_NUM, 100);
            oci_bind_by_name($statement, ':pi_phone3_type', $PI_PHONE3_TYPE, 100);
            oci_bind_by_name($statement, ':pi_phone3_num', $PI_PHONE3_NUM, 100);
            oci_bind_by_name($statement, ':pi_timezone', $PI_TIMEZONE, 100);
            oci_bind_by_name($statement, ':pi_bill_method', $PI_BILL_METHOD, 100);
            oci_bind_by_name($statement, ':pi_paypal_email', $PI_PAYPAL_EMAIL, 100);
            oci_bind_by_name($statement, ':pi_cc_type', $PI_CC_TYPE, 100);
            oci_bind_by_name($statement, ':pi_cc_number', $PI_CC_NUMBER, 100);
            oci_bind_by_name($statement, ':pi_cc_cvn', $PI_CC_CVN, 100);
            oci_bind_by_name($statement, ':pi_cc_expire_date', $PI_CC_EXPIRE_DATE, 100);
            oci_bind_by_name($statement, ':pi_cc_name', $PI_CC_NAME, 100);
            oci_bind_by_name($statement, ':pi_billaddress1', $PI_BILLING_ADDRESS1, 100);
            oci_bind_by_name($statement, ':pi_billaddress2', $PI_BILLING_ADDRESS2, 100);
            oci_bind_by_name($statement, ':pi_billphone', $PI_BILLING_PHONE, 100);
            oci_bind_by_name($statement, ':pi_billcity', $PI_BILLING_CITY, 100);
            oci_bind_by_name($statement, ':pi_billstate', $PI_BILLING_STATE, 100);
            oci_bind_by_name($statement, ':pi_billzip', $PI_BILLING_ZIP, 100);
            oci_bind_by_name($statement, ':pi_billcountry', $PI_BILLING_COUNTRY, 100);
            oci_bind_by_name($statement, ':pi_billachrouting', $PI_BILLING_ACHROUTING, 100);
            oci_bind_by_name($statement, ':pi_billachaccount', $PI_BILLING_ACHACCOUNT, 100);
            oci_execute($statement);
        } catch (Exception $e) {
            return false;
        }

        //echo $PO_RESULT_CODE;die("here");

        if ($PO_RESULT_CODE == 0) {
            return true;
        } else {
            return false;
        }
    }

    function storeStep1Data($data) {
        return 1;
        // every model has a datasource
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return -1;

        // from now you need this Oracle specific approach
        $PO_ACCT_ID = "";
        $PO_RESULT_CODE = "";
        $PO_TOLLFREE_DNIS = "";
        $PO_DID_DNIS = "";
        $PO_HOST_CODE = "";
        $PO_CONF_CODE = "";
        $PO_PLAYBACK_CODE = "";
        $PO_RECORD_CODE = "";

        $PI_REFERRAL = $data['vReferedBy'];
        $PI_SERVICE_LEVEL = $data['vServiceLevel'];
        $PI_PROMO_CODE = $data['vPromotionCode'];
        $PI_MASTERLINK = ""; //it will not be null if sub account is doing signup
        $PI_USERNAME = $data['vEmail'];
        $PI_PASSWORD = md5($data['vPassword']);
        $PI_CHALLENGE_ID = $data['vChallengeQuestion'];
        $PI_CHALLENGE_ANS = $data['vAnswer'];
        $PI_FIRSTNAME = $data['vFirstName'];
        $PI_LASTNAME = $data['vLastName'];
        $PI_COMPANYNAME = $data['vCompanyNote'];
        $PI_ADDRESS1 = "";
        $PI_ADDRESS2 = "";
        $PI_CITY = "";
        $PI_ZIP = "";
        $PI_PHONE_NUM = "";
        $PI_COUNTRY = "";
        $PI_STATE = "";
        $PI_TIMEZONE = $data['vTimezone'];

        $statement = oci_parse($connection,
                        "begin VERIFY_ACCOUNT
                (:PI_REFERRAL,:PI_SERVICE_LEVEL,:PI_PROMO_CODE,:PI_MASTERLINK,:PI_USERNAME,2,:PI_PASSWORD,:PI_CHALLENGE_ID,:PI_CHALLENGE_ANS,:PI_FIRSTNAME,:PI_LASTNAME,:PI_COMPANYNAME,:PI_TIMEZONE,
              	:PO_ACCT_ID,:PO_RESULT_CODE,:PO_TOLLFREE_DNIS,:PO_DID_DNIS,2,:PO_HOST_CODE,2,:PO_CONF_CODE,:PO_PLAYBACK_CODE,:PO_RECORD_CODE
                ); end;");

        oci_bind_by_name($statement, ':PI_REFERRAL', $PI_REFERRAL, 100);
        oci_bind_by_name($statement, ':PI_SERVICE_LEVEL', $PI_SERVICE_LEVEL, 100);
        oci_bind_by_name($statement, ':PI_PROMO_CODE', $PI_PROMO_CODE, 100);
        oci_bind_by_name($statement, ':PI_MASTERLINK', $PI_MASTERLINK, 100);
        oci_bind_by_name($statement, ':PI_USERNAME', $PI_USERNAME, 100);
        oci_bind_by_name($statement, ':PI_PASSWORD', $PI_PASSWORD, 100);
        oci_bind_by_name($statement, ':PI_CHALLENGE_ID', $PI_CHALLENGE_ID, 100);
        oci_bind_by_name($statement, ':PI_CHALLENGE_ANS', $PI_CHALLENGE_ANS, 100);
        oci_bind_by_name($statement, ':PI_FIRSTNAME', $PI_FIRSTNAME, 100);
        oci_bind_by_name($statement, ':PI_LASTNAME', $PI_LASTNAME, 100);
        oci_bind_by_name($statement, ':PI_COMPANYNAME', $PI_COMPANYNAME, 100);
        oci_bind_by_name($statement, ':PI_TIMEZONE', $PI_TIMEZONE, 100);

        oci_bind_by_name($statement, ':PO_ACCT_ID', $PO_ACCT_ID, 100);
        oci_bind_by_name($statement, ':PO_RESULT_CODE', $PO_RESULT_CODE, 100);
        oci_bind_by_name($statement, ':PO_TOLLFREE_DNIS', $PO_TOLLFREE_DNIS, 100);
        oci_bind_by_name($statement, ':PO_DID_DNIS', $PO_DID_DNIS, 100);
        oci_bind_by_name($statement, ':PO_HOST_CODE', $PO_HOST_CODE, 100);
        oci_bind_by_name($statement, ':PO_CONF_CODE', $PO_CONF_CODE, 100);
        oci_bind_by_name($statement, ':PO_PLAYBACK_CODE', $PO_PLAYBACK_CODE, 100);
        oci_bind_by_name($statement, ':PO_RECORD_CODE', $PO_RECORD_CODE, 100);

        oci_execute($statement);
        print $return;
        print "here";
        print $param1;
        die;
    }

    /*     * ********************** function to validate login********************* */

    function validateLoginForm($postArray) {
        /* echo "<pre>";
          print_r($postArray);
          die("here"); */
        if (!isset($postArray['vUsername']) || empty($postArray['vUsername'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['vUsername'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['vPasswordIn']) || empty($postArray['vPasswordIn'])) {//change
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['vPasswordIn'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if ($this->err == 0) {

            $this->loginUser = $this->GetLoginInformation($postArray['vUsername'], $postArray['vPasswordIn']);
            if (count($this->loginUser) == 0) {
                $this->errMsg[] = ERR_LOGIN_RECORD_NOT_FOUND;
                $this->err = 1;
            }
        }
        return $this->err;
    }

    private function GetLoginInformation($userName, $password, $userId = false) {//first two parameters will be blank to get information using acc_id
        $passwordMD5 = md5($password);
        //we will check do user with same email already exist in the db.
        if ($userId === false) {
            $result = $this->find("Account.ACCT_USERNAME = '" . $userName . "' AND Account.ACCT_PASSWORD = '" . $passwordMD5 . "' AND STATUS_ID= '0'", "ACCT_ID,BILLING_ID,ISMASTER,FIRSTNAME,LASTNAME,STATUS_ID,SERVICE_ID,DNIS_TOLLFREE,DNIS_DID,DNIS_POOL_ID,LASTUSE_TS,ACCT_USERNAME");
        } else {
            //STATUS would be 100 for not valid users and then we will be accessing details using user id
            $result = $this->find("Account.ACCT_ID = '" . $userId . "' AND STATUS_ID= '100' ", "ACCT_ID,BILLING_ID,ISMASTER,FIRSTNAME,LASTNAME,STATUS_ID,SERVICE_ID,DNIS_TOLLFREE,DNIS_DID,DNIS_POOL_ID,LASTUSE_TS,ACCT_USERNAME,ACCT_PASSWORD");
        }

        if (count($result) > 0 && isset($result['Account']['acct_id'])) {
            $this->err = 0;
            $loginData = $result['Account'];
            return $loginData;
        } else {
            return array();
        }
    }

    /**
     * Function to check if that subaccount belongs to user in session
     *
     */
    public function CheckSubAccount($userName, $userId) {//first two parameters will be blank to get information using acc_id

        //email will be checked to see if that subaccount belongs to user in session
        $result = $this->find("Account.MASTER_ID = '" . $userId . "' AND ACCT_USERNAME='" . $userName . "' AND STATUS_ID= '2' ", "ACCT_ID");
        if (count($result) > 0 && isset($result['Account']['acct_id'])) {

            return $result['Account']['acct_id'];
        } else {
            return false;
        }
    }

    /**
     * This function will return user ID
     *
     * @param varchar2 $userName
     * @return acct_id
     */
    private function GetUserId($userName) {
        try {
            $result = $this->find("Account.ACCT_USERNAME = '" . $userName . "'", "ACCT_ID");
            if (count($result) > 0 && isset($result['Account']['acct_id'])) {
                return $result['Account']['acct_id'];
            } else {
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }
    function ValidateUser($userName) {
        $this->err = 0;
        if ($this->GetUserId($userName) == -1) {
            $this->errMsg[] = ERR_VALID_USER;
            $this->err = 1;
        } else {
            $userId = $this->GetUserId($userName);
            $this->loginUser = $this->GetLoginInformation("", "", $userId);
            if (count($this->loginUser) == 0) {
                $this->errMsg[] = ERR_ACCOUNT_VALIDATED;
                $this->err = 1;
            } else {
                //Update status to zero if its valid URL
                $sqlUpdate = "UPDATE SUBSCRIBER SET STATUS_ID='0' WHERE ACCT_ID='" . $userId . "'";
                $this->query($sqlUpdate);
            }
        }
        return $this->err;
    }

    function resetPassword($acct_id, $password) {
        $query = "UPDATE SUBSCRIBER SET ACCT_PASSWORD='" . md5($password) . "' WHERE acct_id = " . $acct_id;
        $this->query($query);
        return true;
    }

    /*     * **************** end function to validate login********************* */

    /*     * ********************** function to validate forgot password********************* */

    function validateForgotForm($postArray) {

        if (!isset($postArray['vEmail']) || empty($postArray['vEmail'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['vEmail'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['vChallengeQuestion']) || empty($postArray['vChallengeQuestion'])) {
            $this->errMsg[] = ERR_SELECT_CHLNGQSTN;
            $this->err = 1;
        }
        if (!isset($postArray['vChallengeAns']) || empty($postArray['vChallengeAns'])) {
            $this->errMsg[] = ERR_CHALLENGE_ANSWER_EMPTY;
            $this->err = 1;
        }
        if ($this->err == 0) {
            //we will check do user with same email already exist in the db.
            $result = $this->find("Account.ACCT_USERNAME = '" . $postArray['vEmail'] . "' AND Account.STATUS_ID = '0'", "ACCT_ID, ACCT_USERNAME, FIRSTNAME,LASTNAME, CHALLENGE_ID, CHALLENGE_ANS");
            if (count($result) > 0 && isset($result['Account']['acct_id'])) {
                if ($result['Account']['challenge_id'] != $postArray['vChallengeQuestion'] || $postArray['vChallengeAns'] != $result['Account']['challenge_ans']) {
                    $this->err = 1;
                    $this->errMsg[] = ERR_CHALLENGE_QSTN_ANS_NOT_MATCH;
                } else {
                    $this->err = 0;
                    return $result;
                }
            } else {
                $this->errMsg[] = ERR_RECORD_NOT_FOUND;
                $this->err = 1;
            }
        }
        return $this->err;
    }

    /*     * **************** end function to validate forgot form********************* */

    function validateStep2Form($postArray) {
        /* echo "<pre>";
          print_r($postArray);
          die("here"); */
        if (!isset($postArray['vBillingMethod']) || empty($postArray['vBillingMethod'])) {
            $this->errMsg[] = ERR_BILLING_METHOD_EMPTY;
            $this->err = 1;
        } else {
            switch ($postArray['vBillingMethod']) {
                case "Credit Card":
                case "Paypal":
                    if (!isset($postArray['vNameOnCard']) || empty($postArray['vNameOnCard'])) {
                        $this->errMsg[] = ERR_NAME_ONCARD_EMPTY;
                        $this->err = 1;
                    }
                    if (!isset($postArray['vCardNumber']) || empty($postArray['vCardNumber'])) {
                        $this->errMsg[] = ERR_CARDNUMBER_EMPTY;
                        $this->err = 1;
                    }
                    if (!isset($postArray['vExpireDate']) || empty($postArray['vExpireDate'])) {
                        $this->errMsg[] = ERR_EXPIRE_DATE_EMPTY;
                        $this->err = 1;
                    } else {
                        if (strtotime($postArray['vExpireDate']) <= strtotime(date("Y-m-d"))) {
                            $this->errMsg[] = ERR_NOT_VALID_DATE;
                            $this->err = 1;
                        }
                    }
                    if (!isset($postArray['vCardType']) || empty($postArray['vCardType'])) {
                        $this->errMsg[] = ERR_CARD_TYPE_EMPTY;
                        $this->err = 1;
                    }
                    if ($this->err == 0) {
                        $valid = $this->fnValidateCC($postArray['vCardNumber'], $postArray['vCardType']);
                        if (!$valid) {
                            $this->errMsg[] = ERR_USER_CREDIT_CARD_TYPE_NOT_VALID_EMPTY;
                            $this->err = 1;
                        }
                    }
                    break;
                case "ACH Debit":
                    if (!isset($postArray['vBRNumber']) || empty($postArray['vBRNumber'])) {
                        $this->errMsg[] = ERR_BANK_ROUTING_NUMBER_EMPTY;
                        $this->err = 1;
                    }
                    if (!isset($postArray['vBANumber']) || empty($postArray['vBANumber'])) {
                        $this->errMsg[] = ERR_BANK_ACCNT_NUMBER_EMPTY;
                        $this->err = 1;
                    }
                    break;
            }
        }
        if (empty($postArray['vAddrsline1']) && empty($postArray['vAddrsline2'])) {
            $this->errMsg[] = ERR_ADDR_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCity']) || empty($postArray['vCity'])) {
            $this->errMsg[] = ERR_CITY_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vState']) || empty($postArray['vState'])) {
            $this->errMsg[] = ERR_STATE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vZipCode']) || empty($postArray['vZipCode'])) {
            $this->errMsg[] = ERR_ZIPCODE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCountry']) || empty($postArray['vCountry'])) {
            $this->errMsg[] = ERR_COUNTRY_EMPTY;
            $this->err = 1;
        }
        return $this->err;
    }

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

    function storeStep2Data($data) {
        /* echo "<pre>";
          print_r($data);die("here"); */
        // every model has a datasource
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return false;
        // from now you need this Oracle specific approach

        $PO_ACCT_ID = null;
        $PO_RESULT_CODE = null;
        $PO_TOLLFREE_DNIS = null;
        $PO_DID_DNIS = null;
        $PO_HOST_CODE = null;
        $PO_CONF_CODE = null;
        $PO_RECORD_CODE = null;
        $PI_REFERRAL = $data['vReferedBy'];
        $PI_SERVICE_LEVEL = $data['vServiceLevel'];
        $PI_PROMO_CODE = $data['vPromotionCode'];
        $PI_USERNAME = $data['vEmail'];
        $PI_PASSWORD = md5($data['vPassword']);
        $PI_CHALLENGE_ID = $data['vChallengeQuestion'];
        $PI_CHALLENGE_ANS = $data['vAnswer'];
        $PI_FIRSTNAME = $data['vFirstName'];
        $PI_LASTNAME = $data['vLastName'];
        $PI_COMPANYNAME = $data['vCompanyNote'];
        $PI_PHONE1_TYPE = $data['vPhoneType1'];
        $PI_PHONE1_NUM = $data['vPhone1'];
        $PI_PHONE2_TYPE = $data['vPhoneType2'];
        $PI_PHONE2_NUM = $data['vPhone2'];
        $PI_PHONE3_TYPE = $data['vPhoneType3'];
        $PI_PHONE3_NUM = $data['vPhone3'];
        $PI_TIMEZONE = $data['vTimezone'];
        $PI_BILL_METHOD = $data['vBillingMethod'];
        $PI_PAYMENT_MODE = $data['vPaymentMode'];

        /* $PI_PAYPAL_EMAIL = Null;//$data['vPayPalEmail'];
          $PI_CC_TYPE = Null;//$data['vCardType'];
          $PI_CC_NUMBER = Null;//$data['vCardNumber'];
          $PI_CC_CVN = Null;//$data['vCCVCode'];
          //$arr = explode("/", $data['vExpireDate']);
          $PI_CC_EXPIRE_DATE = Null;//date("Y-m-d",mktime(0,0,0,$arr[0], $arr[1], $arr[2])); */

        $PI_BILL_METHOD = $data['vBillingMethod'];
        $PI_PAYPAL_EMAIL = Null; //$data['vPayPalEmail'];
        $PI_CC_TYPE = $data['vCardType'];
        $PI_CC_NUMBER = substr($data['vCardNumber'], 12, 16);
        $PI_CC_CVN = $data['vCCVCode'];
        $arr = explode("/", $data['vExpireDate']);
        if(count($arr) == 3){
             $PI_CC_EXPIRE_DATE = date("Y-m-d", mktime(0, 0, 0, $arr[0], $arr[1], $arr[2]));
        }
        else{
            $PI_CC_EXPIRE_DATE = null;
        }
       
        $PI_CC_NAME = $data['vNameOnCard'];

        $PI_BILLING_ADDRESS1 = $data['vAddrsline1'];
        $PI_BILLING_ADDRESS2 = $data['vAddrsline2'];
        $PI_BILLING_PHONE = null;
        $PI_BILLING_CITY = $data['vCity'];
        $PI_BILLING_STATE = $data['vState'];
        $PI_BILLING_ZIP = $data['vZipCode'];
        $PI_BILLING_COUNTRY = $data['vCountry'];
        $PI_BILLING_ACHROUTING = $data['vBRNumber'];
        $PI_BILLING_ACHACCOUNT = $data['vBANumber'];
        $PI_ACCEPTED_TERMS = $data['terms'];
        if (isset($data['vPersonalTollNumber'])) {
            $PI_CUSTOM_TOLL_FREE_NUMBER = $data['vPersonalTollNumber'];
        } else {
            $PI_CUSTOM_TOLL_FREE_NUMBER = 1;
        }

        $statement = oci_parse($connection,
                        "begin
			        CREATE_SUBSCRIBER
					(
					:po_acct_id,
					:po_result_code,
					:po_tollfree_dnis,
					:po_did_dnis,
					:po_host_code,
					:po_conf_code,
					:po_record_code,
					:pi_referral,
					:pi_service_level,
					:pi_promo_code,
					:pi_username,
					:pi_password,
					:pi_challenge_id,
					:pi_challenge_ans,
					:pi_firstname,
					:pi_lastname,
					:pi_companyname,
					:pi_phone1_type,
					:pi_phone1_num,
					:pi_phone2_type,
					:pi_phone2_num,
					:pi_phone3_type,
					:pi_phone3_num,
					:pi_timezone,
					:pi_bill_method,
					:pi_paypal_email,
					:pi_cc_type,
					:pi_cc_number,
					:pi_cc_cvn,
					:pi_cc_expire_date,
					:pi_cc_name,
					:pi_billaddress1,
					:pi_billaddress2,
					:pi_billphone,
					:pi_billcity,
					:pi_billstate,
					:pi_billzip,
					:pi_billcountry,
					:pi_billachrouting,
					:pi_billachaccount,
					:pi_accepted_terms,
					:pi_custom_tollfree,
					:pi_payment_mode					
					); 
end;");
        oci_bind_by_name($statement, ':po_acct_id', $PO_ACCT_ID, 100);
        oci_bind_by_name($statement, ':po_result_code', $PO_RESULT_CODE, 100);
        oci_bind_by_name($statement, ':po_tollfree_dnis', $PO_TOLLFREE_DNIS, 100);
        oci_bind_by_name($statement, ':po_did_dnis', $PO_DID_DNIS, 100);
        oci_bind_by_name($statement, ':po_host_code', $PO_HOST_CODE, 100);
        oci_bind_by_name($statement, ':po_conf_code', $PO_CONF_CODE, 100);
        oci_bind_by_name($statement, ':po_record_code', $PO_RECORD_CODE, 100);
        oci_bind_by_name($statement, ':pi_referral', $PI_REFERRAL, 100);
        oci_bind_by_name($statement, ':pi_service_level', $PI_SERVICE_LEVEL, 100);
        oci_bind_by_name($statement, ':pi_promo_code', $PI_PROMO_CODE, 100);
        oci_bind_by_name($statement, ':pi_username', $PI_USERNAME, 100);
        oci_bind_by_name($statement, ':pi_password', $PI_PASSWORD, 250);
        oci_bind_by_name($statement, ':pi_challenge_id', $PI_CHALLENGE_ID, 100);
        oci_bind_by_name($statement, ':pi_challenge_ans', $PI_CHALLENGE_ANS, 100);
        oci_bind_by_name($statement, ':pi_firstname', $PI_FIRSTNAME, 100);
        oci_bind_by_name($statement, ':pi_lastname', $PI_LASTNAME, 100);
        oci_bind_by_name($statement, ':pi_companyname', $PI_COMPANYNAME, 100);
        oci_bind_by_name($statement, ':pi_phone1_type', $PI_PHONE1_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone1_num', $PI_PHONE1_NUM, 100);
        oci_bind_by_name($statement, ':pi_phone2_type', $PI_PHONE2_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone2_num', $PI_PHONE2_NUM, 100);
        oci_bind_by_name($statement, ':pi_phone3_type', $PI_PHONE3_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone3_num', $PI_PHONE3_NUM, 100);
        oci_bind_by_name($statement, ':pi_timezone', $PI_TIMEZONE, 100);
        oci_bind_by_name($statement, ':pi_bill_method', $PI_BILL_METHOD, 100);
        oci_bind_by_name($statement, ':pi_paypal_email', $PI_PAYPAL_EMAIL, 100);
        oci_bind_by_name($statement, ':pi_cc_type', $PI_CC_TYPE, 100);
        oci_bind_by_name($statement, ':pi_cc_number', $PI_CC_NUMBER, 100);
        oci_bind_by_name($statement, ':pi_cc_cvn', $PI_CC_CVN, 100);
        oci_bind_by_name($statement, ':pi_cc_expire_date', $PI_CC_EXPIRE_DATE, 100);
        oci_bind_by_name($statement, ':pi_cc_name', $PI_CC_NAME, 100);
        oci_bind_by_name($statement, ':pi_billaddress1', $PI_BILLING_ADDRESS1, 100);
        oci_bind_by_name($statement, ':pi_billaddress2', $PI_BILLING_ADDRESS2, 100);
        oci_bind_by_name($statement, ':pi_billphone', $PI_BILLING_PHONE, 100);
        oci_bind_by_name($statement, ':pi_billcity', $PI_BILLING_CITY, 100);
        oci_bind_by_name($statement, ':pi_billstate', $PI_BILLING_STATE, 100);
        oci_bind_by_name($statement, ':pi_billzip', $PI_BILLING_ZIP, 100);
        oci_bind_by_name($statement, ':pi_billcountry', $PI_BILLING_COUNTRY, 100);
        oci_bind_by_name($statement, ':pi_billachrouting', $PI_BILLING_ACHROUTING, 100);
        oci_bind_by_name($statement, ':pi_billachaccount', $PI_BILLING_ACHACCOUNT, 100);
        oci_bind_by_name($statement, ':pi_accepted_terms', $PI_ACCEPTED_TERMS, 100);
        oci_bind_by_name($statement, ':pi_custom_tollfree', $PI_CUSTOM_TOLL_FREE_NUMBER, 100);
        oci_bind_by_name($statement, ':pi_payment_mode', $PI_PAYMENT_MODE, 100);
        try {
            oci_execute($statement);
			if ($PO_RESULT_CODE == 0) {
                $returnArray = array();
                $returnArray['po_acct_id'] = $PO_ACCT_ID;
                $returnArray['po_tollfree_dnis'] = $PO_TOLLFREE_DNIS;
                $returnArray['po_did_dnis'] = $PO_DID_DNIS;
                $returnArray['po_host_code'] = $PO_HOST_CODE;
                $returnArray['po_conf_code'] = $PO_CONF_CODE;
                $returnArray['po_record_code'] = $PO_RECORD_CODE;
                $returnArray['pi_firstname'] = $data['vFirstName'];
                $returnArray['pi_lastname'] = $data['vLastName'];
                $returnArray['service_id'] = $data['vServiceLevel'];
                return $returnArray;
            } else {
                return array();
            }
        } catch (Exception $e) {
            return array();
        }
    }

    function validateSubAccountForm($postArray, $acct_id = '', $exist=false) {
//         echo "<pre>";
//          print_r($postArray);die;
        if (!isset($postArray['vUsername']) || empty($postArray['vUsername'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['vUsername'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if ($this->err == 0) {
            if ($exist === true) {
                $result = $this->find("Account.ACCT_USERNAME = '" . $postArray['vUsername'] . "' AND Account.acct_id <> '" . $acct_id . "'", "ACCT_ID");
            } else {
                $result = $this->find("Account.ACCT_USERNAME = '" . $postArray['vUsername'] . "'", "ACCT_ID");
            }

            if (count($result) > 0 && isset($result['Account']['acct_id'])) {
                $this->errMsg[] = ERR_ACCOUNT_ALREADY_CREATED;
                $this->err = 1;
            } else if ($exist === true) {

                $updateQuery = "UPDATE SUBSCRIBER SET
					ACCT_USERNAME = '" . $postArray['vUsername'] . "',
					FIRSTNAME = '" . $postArray['vFirstName'] . "',
					LASTNAME = '" . $postArray['vLasttName'] . "'
					WHERE ACCT_ID ='" . $acct_id . "'";
                $this->query($updateQuery);
            } else {
                $dataSource = $this->getDataSource();
                // and every datasource has a  database connection handle
                $connection = $dataSource->connection;
                if (!$connection) {
                    return -1;
                }
                // from now you need this Oracle specific approach
                $PO_ACCT_ID = "";
                $PO_RESULT_CODE = null;
                $PI_USERNAME = $postArray['vUsername'];
                $PI_MASTERID = $postArray['vMasterId'];
                $PI_FIRSTNAME = $postArray['vFirstName'];
                $PI_LASTNAME = $postArray['vLasttName'];
                $statement = oci_parse($connection,
                                "begin
			        CREATE_SUB_ACCOUNT
					(
					:po_acct_id,
					:po_result_code,
					:pi_username,
					:pi_masterid,
					:pi_firstname,
					:pi_lastname
					); 
end;");
                oci_bind_by_name($statement, ':po_acct_id', $PO_ACCT_ID, 100);
                oci_bind_by_name($statement, ':po_result_code', $PO_RESULT_CODE, 100);
                oci_bind_by_name($statement, ':pi_username', $PI_USERNAME, 100);
                oci_bind_by_name($statement, ':pi_masterid', $PI_MASTERID, 100);
                oci_bind_by_name($statement, ':pi_firstname', $PI_FIRSTNAME, 100);
                oci_bind_by_name($statement, ':pi_lastname', $PI_LASTNAME, 100);
                oci_execute($statement) or die('Can not Execute statment');
                if ($PO_RESULT_CODE == 0) {
                    $this->successMsg[] = SUCCESS_SUB_ACCOUNT_ADDED;
                } else {
                    $this->errMsg[] = ERR_CREATE_SUB_ACCOUNT;
                    $this->err = 1;
                }

                /* print ($PO_RESULT_CODE);
                  die("here");
                  oci_free_statement($statement);
                  oci_close($connection); */
            }
        }
        return $this->err;
    }

    /*
     * Function to validate sub account form
     * @param unknown_type $data
     * @return unknown
     */

    function validateUpdateSubAccount($postArray, $capCode="") {
        /* echo "<pre>";
          print_r($postArray);die; */
        if (!isset($postArray['vEmail']) || empty($postArray['vEmail'])) {
            $this->errMsg[] = ERR_EMAIL_EMPTY;
            $this->err = 1;
        } else if (!validateEmail($postArray['vEmail'])) {
            $this->errMsg[] = ERR_NOTVALID_EMAIL;
            $this->err = 1;
        }
        if (!isset($postArray['vServiceLevel']) || empty($postArray['vServiceLevel'])) {
            $this->errMsg[] = ERR_SERVICE_LEVEL_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vPassword']) || empty($postArray['vPassword'])) {
            $this->errMsg[] = ERR_PASSWORD_EMPTY;
            $this->err = 1;
        } else if (strlen(trim($postArray['vPassword'])) < 5) {
            $this->errMsg[] = ERR_PASWD_LEGTH_LESS;
            $this->err = 1;
        }
        if (!isset($postArray['vConfrmPassword']) || empty($postArray['vConfrmPassword'])) {
            $this->errMsg[] = ERR_CONFRMPASSWORD_EMPTY;
            $this->err = 1;
        }
        if (isset($postArray['vPassword']) && $postArray['vPassword'] != '' && isset($postArray['vConfrmPassword']) && $postArray['vConfrmPassword']) {
            if ($postArray['vPassword'] != $postArray['vConfrmPassword']) {
                $this->errMsg[] = ERR_PASWD_CPASWD_NOTMATCH;
                $this->err = 1;
            }
        }
        if (!isset($postArray['vChallengeQuestion']) || empty($postArray['vChallengeQuestion'])) {
            $this->errMsg[] = ERR_SELECT_CHLNGQSTN;
            $this->err = 1;
        }
        if (!isset($postArray['vAnswer']) || empty($postArray['vAnswer'])) {
            $this->errMsg[] = ERR_CHALLENGE_ANSWER_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vCompanyNote']) || empty($postArray['vCompanyNote'])) {
            $this->errMsg[] = ERR_COMPANY_NOTE_EMPTY;
            $this->err = 1;
        }
        if (!isset($postArray['vFirstName']) || empty($postArray['vFirstName'])) {
            $this->errMsg[] = ERR_FIRST_NAME_EMTY;
            $this->err = 1;
        }

        if (!isset($postArray['vTimezone']) || empty($postArray['vTimezone'])) {
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
        return $this->err;
    }

    function updateSubAccount($data) {
        /* echo "<pre>";
          print_r($data);die("here"); */
        // every model has a datasource
        $dataSource = $this->getDataSource();
        // and every datasource has a  database connection handle
        $connection = $dataSource->connection;
        if (!$connection)
            return -1;
        // from now you need this Oracle specific approach
        $PO_ACCT_ID = null;
        $PO_RESULT_CODE = null;
        $PO_TOLLFREE_DNIS = null;
        $PO_DID_DNIS = null;
        $PO_HOST_CODE = null;
        $PO_CONF_CODE = null;
        $PO_RECORD_CODE = null;
        $PI_REFERRAL = null;
        $PI_SERVICE_LEVEL = 3;
        $PI_PROMO_CODE = null;
        $PI_USERNAME = $data['vEmail'];
        $PI_PASSWORD = md5($data['vPassword']);
        $PI_CHALLENGE_ID = $data['vChallengeQuestion'];
        $PI_CHALLENGE_ANS = $data['vAnswer'];
        $PI_FIRSTNAME = $data['vFirstName'];
        $PI_LASTNAME = $data['vLastName'];
        $PI_COMPANYNAME = $data['vCompanyNote'];
        $PI_PHONE1_TYPE = $data['vPhoneType1'];
        $PI_PHONE1_NUM = $data['vPhone1'];
        $PI_PHONE2_TYPE = $data['vPhoneType2'];
        $PI_PHONE2_NUM = $data['vPhone2'];
        $PI_PHONE3_TYPE = $data['vPhoneType3'];
        $PI_PHONE3_NUM = $data['vPhone3'];
        $PI_TIMEZONE = $data['vTimezone'];
        $PI_BILL_METHOD = null;
        $PI_PAYPAL_EMAIL = null;
        $PI_CC_TYPE = null;
        $PI_CC_NUMBER = null;
        $PI_CC_CVN = null;
        $PI_CC_EXPIRE_DATE = null;
        $PI_CC_NAME = null;
//        $PI_BILLING_ADDRESS1 = $data['vAddrsline1'];
//        $PI_BILLING_ADDRESS2 = $data['vAddrsline2'];
        $PI_BILLING_ADDRESS1 = null;
        $PI_BILLING_ADDRESS2 = null;
        $PI_BILLING_PHONE = null;
//        $PI_BILLING_CITY = $data['vCity'];
//        $PI_BILLING_STATE = $data['vState'];
//        $PI_BILLING_ZIP = $data['vZipCode'];
//        $PI_BILLING_COUNTRY = $data['vCountry'];
        $PI_BILLING_CITY = null;
        $PI_BILLING_STATE = null;
        $PI_BILLING_ZIP = null;
        $PI_BILLING_COUNTRY = null;
        $PI_BILLING_ACHROUTING = null;
        $PI_BILLING_ACHACCOUNT = null;
        $PI_ACCEPTED_TERMS = null;
        $PI_CUSTOM_TOLL_FREE_NUMBER = 0;
        $PI_PAYMENT_MODE = null;
        $statement = oci_parse($connection,
                        "begin
			        CREATE_SUBSCRIBER
					(
					:po_acct_id,
					:po_result_code,
					:po_tollfree_dnis,
					:po_did_dnis,
					:po_host_code,
					:po_conf_code,
					:po_record_code,
					:pi_referral,
					:pi_service_level,
					:pi_promo_code,
					:pi_username,
					:pi_password,
					:pi_challenge_id,
					:pi_challenge_ans,
					:pi_firstname,
					:pi_lastname,
					:pi_companyname,
					:pi_phone1_type,
					:pi_phone1_num,
					:pi_phone2_type,
					:pi_phone2_num,
					:pi_phone3_type,
					:pi_phone3_num,
					:pi_timezone,
					:pi_bill_method,
					:pi_paypal_email,
					:pi_cc_type,
					:pi_cc_number,
					:pi_cc_cvn,
					:pi_cc_expire_date,
					:pi_cc_name,
					:pi_billaddress1,
					:pi_billaddress2,
					:pi_billphone,
					:pi_billcity,
					:pi_billstate,
					:pi_billzip,
					:pi_billcountry,
					:pi_billachrouting,
					:pi_billachaccount,
					:pi_accepted_terms,
					:pi_custom_tollfree,
					:pi_payment_mode		
					); 
end;");
        oci_bind_by_name($statement, ':po_acct_id', $PO_ACCT_ID, 100);
        oci_bind_by_name($statement, ':po_result_code', $PO_RESULT_CODE, 100);
        oci_bind_by_name($statement, ':po_tollfree_dnis', $PO_TOLLFREE_DNIS, 100);
        oci_bind_by_name($statement, ':po_did_dnis', $PO_DID_DNIS, 100);
        oci_bind_by_name($statement, ':po_host_code', $PO_HOST_CODE, 100);
        oci_bind_by_name($statement, ':po_conf_code', $PO_CONF_CODE, 100);
        oci_bind_by_name($statement, ':po_record_code', $PO_RECORD_CODE, 100);
        oci_bind_by_name($statement, ':pi_referral', $PI_REFERRAL, 100);
        oci_bind_by_name($statement, ':pi_service_level', $PI_SERVICE_LEVEL, 100);
        oci_bind_by_name($statement, ':pi_promo_code', $PI_PROMO_CODE, 100);
        oci_bind_by_name($statement, ':pi_username', $PI_USERNAME, 100);
        oci_bind_by_name($statement, ':pi_password', $PI_PASSWORD, 250);
        oci_bind_by_name($statement, ':pi_challenge_id', $PI_CHALLENGE_ID, 100);
        oci_bind_by_name($statement, ':pi_challenge_ans', $PI_CHALLENGE_ANS, 100);
        oci_bind_by_name($statement, ':pi_firstname', $PI_FIRSTNAME, 100);
        oci_bind_by_name($statement, ':pi_lastname', $PI_LASTNAME, 100);
        oci_bind_by_name($statement, ':pi_companyname', $PI_COMPANYNAME, 100);
        oci_bind_by_name($statement, ':pi_phone1_type', $PI_PHONE1_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone1_num', $PI_PHONE1_NUM, 100);
        oci_bind_by_name($statement, ':pi_phone2_type', $PI_PHONE2_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone2_num', $PI_PHONE2_NUM, 100);
        oci_bind_by_name($statement, ':pi_phone3_type', $PI_PHONE3_TYPE, 100);
        oci_bind_by_name($statement, ':pi_phone3_num', $PI_PHONE3_NUM, 100);
        oci_bind_by_name($statement, ':pi_timezone', $PI_TIMEZONE, 100);
        oci_bind_by_name($statement, ':pi_bill_method', $PI_BILL_METHOD, 100);
        oci_bind_by_name($statement, ':pi_paypal_email', $PI_PAYPAL_EMAIL, 100);
        oci_bind_by_name($statement, ':pi_cc_type', $PI_CC_TYPE, 100);
        oci_bind_by_name($statement, ':pi_cc_number', $PI_CC_NUMBER, 100);
        oci_bind_by_name($statement, ':pi_cc_cvn', $PI_CC_CVN, 100);
        oci_bind_by_name($statement, ':pi_cc_expire_date', $PI_CC_EXPIRE_DATE, 100);
        oci_bind_by_name($statement, ':pi_cc_name', $PI_CC_NAME, 100);
        oci_bind_by_name($statement, ':pi_billaddress1', $PI_BILLING_ADDRESS1, 100);
        oci_bind_by_name($statement, ':pi_billaddress2', $PI_BILLING_ADDRESS2, 100);
        oci_bind_by_name($statement, ':pi_billphone', $PI_BILLING_PHONE, 100);
        oci_bind_by_name($statement, ':pi_billcity', $PI_BILLING_CITY, 100);
        oci_bind_by_name($statement, ':pi_billstate', $PI_BILLING_STATE, 100);
        oci_bind_by_name($statement, ':pi_billzip', $PI_BILLING_ZIP, 100);
        oci_bind_by_name($statement, ':pi_billcountry', $PI_BILLING_COUNTRY, 100);
        oci_bind_by_name($statement, ':pi_billachrouting', $PI_BILLING_ACHROUTING, 100);
        oci_bind_by_name($statement, ':pi_billachaccount', $PI_BILLING_ACHACCOUNT, 100);
        oci_bind_by_name($statement, ':pi_accepted_terms', $PI_ACCEPTED_TERMS, 100);
        oci_bind_by_name($statement, ':pi_custom_tollfree', $PI_CUSTOM_TOLL_FREE_NUMBER, 100);
        oci_bind_by_name($statement, ':pi_payment_mode',$PI_PAYMENT_MODE, 100);

        try {
            oci_execute($statement);
//			        echo $PO_RESULT_CODE;die("here");

            if ($PO_RESULT_CODE == 0) {
                $returnArray = array();
                $returnArray['po_acct_id'] = $PO_ACCT_ID;
                $returnArray['po_tollfree_dnis'] = $PO_TOLLFREE_DNIS;
                $returnArray['po_did_dnis'] = $PO_DID_DNIS;
                $returnArray['po_host_code'] = $PO_HOST_CODE;
                $returnArray['po_conf_code'] = $PO_CONF_CODE;
                $returnArray['po_record_code'] = $PO_RECORD_CODE;
                $returnArray['pi_firstname'] = $data['vFirstName'];
                $returnArray['pi_lastname'] = $data['vLastName'];
                return $returnArray;
            } else {
                return array();
            }
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * @uses: To insert any entry for the purchased packeage in the payments table
     * It has been used at: accounts/step2 
     */
    function paymentInsertEntry($paymentData) {
        $insert = "INSERT INTO payments
    	(id, acct_id, billing_method, transaction_id, payment_date, amount, approval_code, credit_card, order_number, ach_bank_account, account_type, account_name, check_number, cc_name, cc_type, cc_expire_ts,payment_mode)
  values(SEQ_PAYMENT_ID.nextval,'" . $paymentData['acct_id'] . "', '" . $paymentData['billing_method'] . "', '" . $paymentData['transaction_id'] . "', to_date('" . $paymentData['date'] . "', 'yyyy/mm/dd'),'" . $paymentData['amount'] . "', '" . $paymentData['approval_code'] . "', '" . $paymentData['cCard'] . "', '" . $paymentData['order_number'] . "','" . $paymentData['ach_bank_account'] . "','" . $paymentData['account_type'] . "','" . $paymentData['account_name'] . "','" . $paymentData['check_number'] . "','" . $paymentData['cc_name'] . "','" . $paymentData['cc_type'] . "',to_date('" . $paymentData['cc_expire_ts'] . "', 'yyyy/mm/dd'),'".$paymentData['payment_mode']."')";
		 

        $result = $this->query($insert);
        return $result;
    }

    /**
     * 
     */
    public function GetInformation($userName) {
        $result = array();
        try {
            $result = $this->find("Account.ACCT_USERNAME = '" . $userName . "'", "ACCT_ID,BILLING_ID,ISMASTER,FIRSTNAME,LASTNAME,STATUS_ID,SERVICE_ID,DNIS_TOLLFREE,DNIS_DID,DNIS_POOL_ID,LASTUSE_TS");
            return $result;
        } catch (Exception $e) {
            return $result;
        }
    }

    function getMasterId($acctId) {
        $result = array();
        try {
            $result = $this->find("Account.ACCT_ID = '" . $acctId . "'", "MASTER_ID");
            if ($result['Account']['master_id'] != "") {
                return $result['Account']['master_id'];
            } else {
                return $acctId; //@acctId passed is master or individual account
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Function to retrieve user information to edit account and misc
     *
     * @param number $acctId
     */
    function getEditInfo($acctId) {

        $selSQL = "SELECT SUB.ISMASTER, SUB.PAYMENT_MODE, SUB.ISMASTER, SUB.ACCT_USERNAME, SUB.TIMEZONE, SUB.DNIS_TOLLFREE, SUB.DNIS_DID, BA.BILLING_ID, BA.STATUS_ID, BA.BILLING_METHOD, BA.PAYPAL_EMAIL, BA.CC_NUMBER, BA.CC_CVN, BA.CC_NAME, BA.CC_EXPIRE_TS, BA.BILLING_ADDRESS1, BA.BILLING_ADDRESS2, BA.BILLING_PHONE, BA.BILLING_CITY, BA.BILLING_ST, BA.BILLING_ZIP, BA.BILLING_COUNTRY, BA.CC_TYPE, BA.ACCEPTED_TERMS, BA.ACH_ROUTING_CODE, BA.ACH_BANK_ACCOUNT, SUB.FIRSTNAME, SUB.COMPANYNAME, SUB.LASTNAME, SC.PHONE1_DESCRIPTION, SC.PHONE1_NUM, SC.PHONE2_DESCRIPTION, SC.PHONE2_NUM, SC.PHONE3_DESCRIPTION, SC.PHONE3_NUM, SC.PHONE4_DESCRIPTION, SC.PHONE4_NUM FROM SUBSCRIBER SUB
            LEFT JOIN BILLING_ACCOUNT BA ON BA.BILLING_ID = SUB.BILLING_ID 
            LEFT JOIN SUBSCRIBER_CONTACT SC ON SC.ACCT_ID = SUB.ACCT_ID and contact_index=0 WHERE SUB.ACCT_ID='" . $acctId . "'";
        $dataUser = $this->query($selSQL);
        return $dataUser;
    }

    /**
     * funtion to retrieve required information in step1 of sub account
     *
     * @param number $acctId
     * @return array
     */
    function getSubStep1Info($acctId) {
        $selSQL = "SELECT SUB.DNIS_POOL_ID, SUB.ACCT_USERNAME, SUB.MASTER_ID FROM SUBSCRIBER SUB WHERE SUB.ACCT_ID='" . $acctId . "'";
        $dataUser = $this->query($selSQL);
        return $dataUser;
    }

    /**
     * Function retrieve primary conference information
     *
     * @param number $acctId
     * @return array
     */
    function getSubConfInfo($acctId) {
        $selSQL1 = "SELECT CONF.CODESET_NAME FROM ACCOUNT_CODE_SET CONF WHERE CONF.ACCT_ID='" . $acctId . "' AND IS_PRIMARY=1";
        $dataConf = $this->query($selSQL1);
        return $dataConf;
    }

    /**
     * Function stes sub account under deletion
     * @param number $acctId
     */
    function delSubAccount($acctId, $masterId) {
        $updateQuery = "UPDATE SUBSCRIBER SET
					status_id = '3'
					WHERE ACCT_ID ='" . $acctId . "' AND master_id =" . $masterId . "";
        $this->query($updateQuery);
    }
    function Information4Charge($acctId){
        $selSQL1 = "SELECT CONF.CODESET_NAME FROM ACCOUNT_CODE_SET CONF WHERE CONF.ACCT_ID='" . $acctId . "' AND IS_PRIMARY=1";
        $dataAccount = $this->query($selSQL1);
        return $dataAccount;

    }
    public function getDNISID($userId) {
        try {
            $result = $this->find("Account.ACCT_ID = '" . $userId . "'", "DNIS_POOL_ID,ISMASTER,SERVICE_ID,AVAILABLE_TF_MINUTES");
            if (count($result) > 0 && isset($result['Account']['dnis_pool_id'])) {
                $this->err = 0;
                $loginData = $result['Account'];
                return $loginData;
            } else {
                return array();
            }
        } catch (Exception $e) {
            return array();
        }
    }

    function getAccountInfo($acctId) {

        $selSQL = "SELECT SUB.ACCT_USERNAME, SUB.FIRSTNAME, SUB.COMPANYNAME, SUB.LASTNAME,
            INVOICES.AMOUNT
            FROM SUBSCRIBER SUB
            LEFT JOIN TBLINVOICES INVOICES ON INVOICES.ACCT_ID = SUB.ACCT_ID
            WHERE SUB.ACCT_ID='" . $acctId . "' 
            AND INVOICES.PAID_STATUS=0
            AND INVOICES.CREATED_DATE = (SELECT MAX(tblinvoices.CREATED_DATE) FROM tblinvoices where tblinvoices.acct_id = '" . $acctId . ")
            ORDER BY CREATED_DATE DESC";
        $dataUser = $this->query($selSQL);
        return $dataUser;
    }
    function getAutomaticBillingInfo($acctId) {

        $selSQL = "SELECT P.ORDER_NUMBER, P.TRANSACTION_ID, I.AMOUNT, I.INVOICE_NUMBER,
            B.CC_NAME, B.BILLING_ADDRESS1, B.BILLING_ZIP
            FROM PAYMENTS P
            LEFT JOIN SUBSCRIBER SUB ON SUB.ACCT_ID = P.ACCT_ID
            LEFT JOIN TBLINVOICES I ON SUB.ACCT_ID = I.ACCT_ID
            LEFT JOIN BILLING_ACCOUNT B ON SUB.BILLING_ID = B.BILLING_ID
            WHERE SUB.ACCT_ID='" . $acctId . "'
            AND I.CREATED_DATE = (SELECT MAX(tblinvoices.CREATED_DATE) FROM tblinvoices where tblinvoices.acct_id = '" . $acctId . "')
            AND I.PAID_STATUS = 0
            AND rownum=1";
        $dataUser = $this->query($selSQL);
        return $dataUser;
    }
    function getUserReqInfo($acctId) {

        try {
            $result = $this->find("Account.ACCT_ID = '" . $acctId . "'", "ACCT_USERNAME,FIRSTNAME,LASTNAME");
            if (count($result) > 0 && isset($result['Account']['acct_username'])) {
                return $result['Account'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            return array();
        }
    }
    function updateAvailableSecs($mins,$acctId){
        $updateSql = "update subscriber set AVAILABLE_TF_MINUTES='".$mins."' where acct_id = '".$acctId."'";
        $this->query($updateSql);
    }
    function getAvailableMins($acctId)
    {
        $selSQL = "select AVAILABLE_TF_MINUTES, USED_TF_MINUTES, MASTER_ID FROM subscriber where ACCT_ID =".$acctId;
        $dataMins = $this->query($selSQL);
        $selSubSQL = "select sum(AVAILABLE_TF_MINUTES)as ASUB, sum(USED_TF_MINUTES)as USUB FROM subscriber where master_id = ".$acctId;
        $dataSubMins = $this->query($selSubSQL);
        if($dataMins[0][0]['MASTER_ID'] != 0){
            
            $selSQLMaster = "select AVAILABLE_TF_MINUTES, USED_TF_MINUTES, MASTER_ID FROM subscriber where ACCT_ID =".$dataMins[0][0]['MASTER_ID'];
            $dataMinsMaster = $this->query($selSQLMaster);
            $avMinsMaster = $dataMinsMaster[0][0]['AVAILABLE_TF_MINUTES'];
            $useMinsMaster = $dataMinsMaster[0][0]['USED_TF_MINUTES'];
        }
        else{
            $avMinsMaster = 0;
            $useMinsMaster = 0;
        }
//        echo "<pre>";
//        print_r($dataMins);
//        print_r($dataSubMins);
//        die("here");
//        echo "</pre>";
        $avMins = $dataMins[0][0]['AVAILABLE_TF_MINUTES'] + $dataSubMins[0][0]['ASUB'] + $avMinsMaster;
        $useMins = $dataMins[0][0]['USED_TF_MINUTES'] + $dataSubMins[0][0]['USUB'] + $useMinsMaster;
        $retMins = $avMins - $useMins;
        return $retMins;
    }
}

//End-class
?>