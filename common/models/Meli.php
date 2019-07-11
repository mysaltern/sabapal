<?php

namespace common\models;

use SoapClient;
use yii\base\Model;

class Meli extends \yii\db\ActiveRecord
{

    public $merchant_id;
    public $callback_url;
    public $testing = false;
    private $_status;
    private $_authority;
    private $_ref_id;

    public function request($amount, $callbackParams, $orderID)
    {


        //Prepare data
//        session_start();
//        include_once("function.php");
        $key = "g1AOZ8lNoZdJHarjMUMXxaRHBUGn9Hzt";
        $MerchantId = "000000140274301";
    //    $MerchantId = "000000140250406";
   //     $TerminalId = "24004676";
        $TerminalId = "24006428";
        $Amount = $amount; //Rials
        $OrderId = "$orderID";
        $LocalDateTime = date("m/d/Y g:i:s a");
        $ReturnUrl = "$callbackParams";
        $SignData = $this->encrypt_pkcs7("$TerminalId;$OrderId;$Amount", "$key");
        $data = array('TerminalId' => $TerminalId,
            'MerchantId' => $MerchantId,
            'Amount' => $Amount,
            'SignData' => $SignData,
            'ReturnUrl' => $ReturnUrl,
            'LocalDateTime' => $LocalDateTime,
            'OrderId' => $OrderId);
        $str_data = json_encode($data);
        $res = $this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest', $str_data);
		//var_dump($res );
	//	die;
        $arrres = json_decode($res);
        if ($arrres->ResCode == 0)
        {
            $Token = $arrres->Token;


            $bank = new BankLog;
            $bank->amount = $amount;

            $bank->date = time();
            if (isset(\Yii::$app->user->id))
            {
                $bank->userID = \Yii::$app->user->id;
            }
            $bank->auth = $Token;
            $bank->orderID = $OrderId;
            $bank->externalPayID = 1;
            $bank->save(false);

            $url = "https://sadad.shaparak.ir/VPG/Purchase?Token=$Token";
            header("Location:$url");
            die;
        }
        else
            die($arrres->Description);
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
