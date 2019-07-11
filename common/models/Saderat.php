<?php

namespace common\models;

use SoapClient;
use yii\base\Model;

class Saderat extends \yii\db\ActiveRecord
{

    public $merchant_id;
    public $callback_url;
    public $testing = false;
    private $_status;
    private $_authority;
    private $_ref_id;

    public function request($amount, $callbackParams, $orderID)
    {

			$bank = new \common\models\BankLog;
            $bank->amount = $amount;

            $bank->date = time();
       
		 
          $invoiceNumber=   $bank->orderID =$orderID;
            $bank->externalPayID = 3;
            $bank->save(false);


		
		//	$callbackParams = 'https://mabna.shaparak.ir:8080/Pay';
		 
			$terminal= '61001187';
			$redirectAddress=$callbackParams;
			
		 	   
			   
			   
					echo $setPayment = '<form id="paymentUTLfrm" action="https://mabna.shaparak.ir:8080" method="POST">
					<input type="hidden" id="TerminalID" name="TerminalID" value="'.$terminal.'">
					<input type="hidden" id="Amount" name="Amount" value="'.$amount.'">
					<input type="hidden" id="callbackURL" name="callbackURL" value="'.$redirectAddress.'">
					<input type="hidden" id="InvoiceID" name="InvoiceID" value="'.$invoiceNumber.'">
					<input type="hidden" id="Payload" name="Payload" value="">
					</form><script>
					function submitmabna() {
					document.getElementById("paymentUTLfrm").submit();
					}
					window.onload=submitmabna; </script>';

					exit;
    }

    public function verify($orderID, $token, $ResCode)
    {


        $key = "g1AOZ8lNoZdJHarjMUMXxaRHBUGn9Hzt";
        $OrderId = $orderID;
        $Token = $token;

        if ($ResCode == 0)
        {
            $verifyData = array('Token' => $Token, 'SignData' => $this->encrypt_pkcs7($Token, $key));
            $str_data = json_encode($verifyData);
            $res = $this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify', $str_data);
            $arrres = json_decode($res);

            return $arrres;
        }
        else
        {
            return false;
        }
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function getRedirectUrl($zaringate = true)
    {
        if ($this->testing)
        {
            $url = 'https://sandbox.zarinpal.com/pg/StartPay/' . $this->_authority;
        }
        else
        {
            $url = 'https://www.zarinpal.com/pg/StartPay/' . $this->_authority;
        }
        $url .= ($zaringate) ? '/ZarinGate' : '';

        return $url;
    }

    public function getAuthority()
    {
        return $this->_authority;
    }

    public function encrypt_pkcs7($str, $key)
    {
      /*  $key = base64_decode($key);
        $block = mcrypt_get_block_size("tripledes", "ecb");
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $ciphertext = mcrypt_encrypt("tripledes", $key, $str, "ecb");
        return base64_encode($ciphertext);*/
		       $key = base64_decode($key);
		
    $block = OpenSSL_encrypt($str,"DES-EDE3", $key, OPENSSL_RAW_DATA);

    return base64_encode($block);
    }

//Send Data
    public function CallAPI($url, $data = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

}
