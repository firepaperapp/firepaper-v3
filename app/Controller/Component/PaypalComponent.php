<?php
class PaypalComponent extends Component
{

	/***
	* Paypal Component class
	* 
	* DodirectpaymentReceipt
	* @filesource
 	* @copyright  Copyright © 2009 Ids Infotech
	* @version 0.0.1 
	*   - Initial release
	*/

	var $controller;
	 
	function startup( &$controller ) {
		$this->controller = &$controller;
	}
 
	function hash_call($methodName,$nvpStr)
	{
 		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,PAYPAL_API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PAYPAL_PROXY_HOST and port number to PROXY_PORT in constants.php 
		if(PAYPAL_USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PAYPAL_PROXY_HOST.":".PAYPAL_PROXY_PORT); 
	
		//check if version is included in $nvpStr else include the version.
		if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
			$nvpStr = "&VERSION=" . urlencode(PAYPAL_VERSION) . $nvpStr;	
		}
		
		$nvpreq="METHOD=".urlencode($methodName).$nvpStr;
 	 
 		
	 
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
	
		//getting response from server
		$response = curl_exec($ch);
		curl_close($ch);
		//convrting NVPResponse to an Associative Array
		$nvpResArray = $this->deformatNVP($response);
		$nvpReqArray = $this->deformatNVP($nvpreq);
 	 	return $nvpResArray;				
	}
	
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	  */
	
	function deformatNVP($nvpstr)
	{
	
		$intial=0;
	 	$nvpArray = array(); 
		while(strlen($nvpstr)){
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}
	function callPaypalApi($postedData)
	{
  		/**
		 * Get required parameters from the web form for the request
		 */
	 	$firstName = urlencode( $postedData['firstname']);
		$lastName = urlencode( $postedData['lastname']);
		$creditCardType = urlencode( $postedData['cardtype']);
		$creditCardNumber = urlencode($postedData['cardnumber']);
		
		$expDat = explode("/",$postedData['expiredate']);
		 
		
		// Month must be padded with leading zero
		$padDateMonth = $expDat[0].$expDat[2];//str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		
		 
		$cvv2Number = urlencode($postedData['ccvcode']);
		$address1 = urlencode($postedData['addrsline1']);
		$address2 = urlencode($postedData['addrsline2']);
		$city = urlencode($postedData['city']);
		$state = urlencode( $postedData['vState']);
		$zip = urlencode($postedData['zipcode']);
		$amount = urlencode($postedData['amount']);
		$currencyCode = "USD";
 

		/* Construct the request string that will be sent to PayPal.
	    The variable $nvpstr contains all the variables and is a
	    name value pair string with & as a delimiter */
	    $profileDesc = "Profile Testing";
		$billingPeriod = "Day";
		$billingFrequency = urlencode($postedData['billingFrequency']);
		$totalBillingCycles = 30;
		
		
		$postedData['profileStartDateDay'] = date("d");
		$postedData['profileStartDateMonth'] = date("m");
		$postedData['profileStartDateYear'] = date("Y");
		
	 	$profileStartDate = urlencode($postedData['profileStartDateYear'] . '-' . $postedData['profileStartDateMonth'] . '-' . $postedData['profileStartDateDay'] . 'T00:00:00Z'); 
		
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
	    $nvpstr="&VERSION=65.1&METHOD=CreateRecurringPaymentsProfile&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state"."&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles";
 
	    if(isset($postedData['trial']) && count($postedData['trial'])>0)
	    {
	    	$nvpstr.="&TRIALBILLINGPERIOD=Day&TRIALBILLINGFREQUENCY=".$postedData['trial']['Package']['duration']."&TRIALAMT=0&TRIALTOTALBILLINGCYCLES=1";
	    }
	    
	   /* TRIALBILLINGPERIOD
	    TRIALBILLINGFREQUENCY
	    TRIALAMT
	    TRIALTOTALBILLINGCYCLES*/
		$nvpHeader = $this->makeHeader();
		$nvpstr = $nvpHeader.$nvpstr;				
 
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		
		
		$resArray = $this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
	 	
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		 	$ack = strtoupper($resArray["ACK"]);		
 		return $resArray;
	}
	function makeHeader()
	{
		$getAuthModeFromConstantFile = true;
		//$getAuthModeFromConstantFile = false;
		$nvpHeader = "";
		
		if(!$getAuthModeFromConstantFile) {
			//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.			
			
			//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
			$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
		} else {
			if(PAYPAL_API_USERNAME!='' && PAYPAL_API_PASSWORD!='' && PAYPAL_API_SIGNATURE!='' && SUBJECT!='') {
				$AuthMode = "THIRDPARTY";
		  }
			else if(PAYPAL_API_USERNAME!='' && PAYPAL_API_PASSWORD!='' && PAYPAL_API_SIGNATURE!='') 			{
				$AuthMode = "3TOKEN";
			}else if(SUBJECT!='') {
				$AuthMode = "FIRSTPARTY";
			}
		}
		
		switch($AuthMode) {
			
			case "3TOKEN" : 
					$nvpHeader = "&PWD=".urlencode(PAYPAL_API_PASSWORD)."&USER=".urlencode(PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode(PAYPAL_API_SIGNATURE);
					break;
			case "FIRSTPARTY" :
					$nvpHeader = "&SUBJECT=".urlencode(SUBJECT);
					break;
			case "THIRDPARTY" :
					$nvpHeader = "&PWD=".urlencode(PAYPAL_API_PASSWORD)."&USER=".urlencode(PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode(PAYPAL_API_SIGNATURE)."&SUBJECT=".urlencode(SUBJECT);
					break;		
			
		}
		return $nvpHeader;
	}
	function updateRecurringProfile($postedData)
	{
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
	    $nvpstr="&VERSION=65.1&METHOD=UpdateRecurringPaymentsProfile&PROFILEID=".$postedData['profile_id']."&AMT=".$postedData['amount']."&NOTE=".$postedData['notes'];;
 
		$nvpHeader = $this->makeHeader();
		$nvpstr = $nvpHeader.$nvpstr;				
 
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		
		
		$resArray = $this->hash_call("UpdateRecurringPaymentsProfile",$nvpstr);
	 	
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
   		$ack = strtoupper($resArray["ACK"]);		
 		return $resArray;
	}
	/**
	 * To suspend the user account payment
	 */
	function manageStatus($postedData)
	{
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
	    $nvpstr="&VERSION=65.1&METHOD=ManageRecurringPaymentsProfileStatus&PROFILEID=".$postedData['profile_id']."&ACTION=".$postedData['action'];;
 
		$nvpHeader = $this->makeHeader();
		$nvpstr = $nvpHeader.$nvpstr;				
 
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		
		
		$resArray = $this->hash_call("ManageRecurringPaymentsProfileStatus",$nvpstr);
	 	
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		
   		$ack = strtoupper($resArray["ACK"]);		
  		return $resArray;
	}
}
?>