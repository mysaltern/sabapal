<?php

namespace common\models;

use SoapClient;
use yii\base\Model;

class Parsian extends \yii\db\ActiveRecord
{

    public $merchant_id;
    public $callback_url;
    public $testing = false;
    private $_status;
    private $_authority;
    private $_ref_id;

    public function request($amount, $callbackParams, $orderID)
    {


 

	ini_set ( "soap.wsdl_cache_enabled", "0" );
	
	
	$PIN = 'frLVReo7qPS6GI6tFN0V';
	$wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
	$site_call_back_url = $callbackParams;
	 
	$order_id = $orderID;
	
	$params = array (
			"LoginAccount" => $PIN,
			"Amount" => $amount,
			"OrderId" => $order_id,
			"CallBackUrl" => $site_call_back_url ,
			"AdditionalData" => '105825109622066' ,
			"Originator" => '105825109622066' ,
	);
	
	$client = new SoapClient ( $wsdl_url );
	
	try {
		$result = $client->SalePaymentRequest ( array (
				"requestData" => $params 
		) );
		if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {
			
			  $LocalDateTime = date("m/d/Y g:i:s a");
			
            $Token = $result->SalePaymentRequestResult->Token;


            $bank = new BankLog;
            $bank->amount = $amount;

            $bank->date = time();
            if (isset(\Yii::$app->user->id))
            {
                $bank->userID = \Yii::$app->user->id;
            }
            $bank->auth = $Token;
            $bank->orderID = $orderID;
            $bank->externalPayID = 1;
            $bank->save(false);
			
			header ( "Location: https://pec.shaparak.ir/NewIPG/?Token=" . $Token ); /* Redirect browser */
			exit ();
		}
		elseif ( $result->SalePaymentRequestResult->Status  != '0') {
			$err_msg = "(<strong> ع©ط¯ ط®ط·ط§ : " . $result->SalePaymentRequestResult->Status . "</strong>) " .
			 $result->SalePaymentRequestResult->Message ;
		} 
	} catch ( Exception $ex ) {
		$err_msg =  $ex->getMessage()  ;
	}
 







 

   
	  echo 'error parsian model';
	 
         
    }

    public function verify($orderID, $token, $ResCode)
    {

	$PIN = 'frLVReo7qPS6GI6tFN0V';
	$wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";
	 
	$Token = $_REQUEST ["Token"];
	$status = $_REQUEST ["status"];
	$OrderId = $_REQUEST ["OrderId"];
	$TerminalNo ='61242330';
	//$Amount = $_REQUEST ["Amount"];
	//$RRN = $_REQUEST ["RRN"];
	 
	if ( $status == 0) {
		
		$params = array (
				"LoginAccount" => $PIN,
				"Token" => $Token 
		);
		
		$client = new SoapClient ( $wsdl_url );
		
		try {
			$result = $client->ConfirmPayment ( array (
					"requestData" => $params 
			) );
			 
		if($result->ConfirmPaymentResult->Status==0)
		{
			return $result;
		}			
		 
			if ($result->ConfirmPaymentResult->Status != '0') {
				$err_msg = "(<strong> کد خطا : " . $result->ConfirmPaymentResult->Status . "</strong>) " ;
			}
		} catch ( Exception $ex ) {
			$err_msg =  $ex->getMessage()  ;
		}
	}elseif($status) {
		$err_msg = "کد خطای ارسال شده از طرف بانک $status " . "";
		return false;
	}else {

		$err_msg = "پاسخی از سمت بانک ارسال نشد " ;
		return false;
	}
	return false;
	
    }
 
}
