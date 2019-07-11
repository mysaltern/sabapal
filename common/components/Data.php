<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Query;

class Data extends Component
{

    public function account($userID, $access)
    {




        $query = new Query;
        $query->select('*')
                ->from('contact')
                ->join('inner join', 'bank_accounts', "bank_accounts.userID = contact.userID")
                ->join('inner join', 'user', "user.id = contact.userID")
//                ->join('inner join', 'contact', "contact.userID = internal_pay.userID")
                ->where(['contact.userID' => $userID, 'bank_accounts.deleted' => 0, 'bank_accounts.primary' => 1]);
        $command = $query->createCommand();
        $data = $command->queryOne();
//        if ($userID != 1)
//        {
//            var_dump($userID);
    //        var_dump($data);
     //       die;
//        }
        if ($access == 1)
        {
            if (isset($data['nationalCode']))
            {
                if (!is_null($data['nationalCode']))
                {
                    return $data;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return $data;
        }
    }

    public function jsonTransfer($arrF, $arrT)
    {


        $array = array();


        $array['sourceIban'] = '';
        $array['transferType'] = '';
        $array['transactionDate'] = '';
        $array['trackingNumber'] = '';
        $array['referenceNumber'] = '';
        $array['amount'] = '';
        $array['destinationIban'] = '';
        $array['ownerName'] = '';
        $array['ownerNationalId'] = '';
        $array['description'] = '';
    }

    public function status($arr, $start = '', $end = '', $trackingNumbers = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $array = array();


        $array['requestDate'] = '';
        $array['requestTypes'] = '';
        $array['statuses'] = '';
        $array['trackingNumbers'] = '';
        $array['trackingNumberPsps'] = '';
        return $array;
    }

    public function addShaparak($trackingNumberPsp, $requestType, $merchant, $relatedMerchants = null, $contract = null, $pspRequestShopAcceptors, $description)
    {

    }

    public function merchent($userID,$type)
    {
		 
		 $arr = array();
        $data = $this->account($userID, 1);
		$shaba = $data['shaba'];
		$nationalCode=	$data['nationalCode'];
	 	$shabaDes = 'تستی';
       //  $arr['merchantIbans'] = array(['merchantIbans'=>$shaba,'desc'=>$shabaDes]);
	 
		 

       
    //   $arr["firstNameFa"] = $data['name'];
	     $arr["firstNameFa"] ="حمید رضا";
       $arr["lastNameFa"] = 'خورش';
       $arr["fatherNameFa"] = 'رضا';
        $arr["firstNameEn"] ="hamidreza" ;
        $arr["lastNameEn"] = 'khoresh';
        $arr["fatherNameEn"] = 'reza';
        $arr["gender"] = 1;
		//timestamp milisanie
        $arr["birthDate"] = 273309202000;
        $arr ["registerDate"] = null;
        $arr["nationalCode"] = "0073942154";
        $arr["registerNumber"] = null;
        $arr["comNameFa"] = null;
        $arr["comNameEn"] = null;
        $arr["merchantType"] = 0;
        $arr["residencyType"] = 0;
        $arr["vitalStatus"] = 0;
 
		
       $arr["birthCrtfctNumber"] = 0;        
       $arr["birthCrtfctSerial"] = 619508;
       $arr["birthCrtfctSeriesLetter"] = 0;
        $arr["birthCrtfctSeriesNumber"] = 32;
        $arr["nationalLegalCode"] = null;
        $arr["commercialCode"] = null;
        $arr["foreignPervasiveCode"] = null;
        $arr["passportNumber"] = null;
        $arr["passportExpireDate"] = null;
        $arr["description"] = null;
        $arr["telephoneNumber"] ="021-88325660";
		 // $mobile = \common\models\MobilePhone::withUserId($userID);
	 
        $arr["cellPhoneNumber"] = $data['mobile'];
        $arr["emailAddress"] = $data['email'];
        $arr["webSite"] = "www.sefroweb.com";
        $arr["fax"] = null;
        $arr["merchantOfficers"] = null;
		
		if($type==14)
		{
			$arr["updateAction"] = 0;
		}
      //  $arr["updateAction"] = null;
	  
	  if($type!=7 and $type !=14 and $type!=17 and $type!=18)
	  {
		       $arr["merchantIbans"][] = array("merchantIban"=>"IR680170000000223650150001","description"=>'hamidreza khoresh');
     
	  }
	  // var_dump($arr);
	   // die;
		
		return $arr;
    }

    public function shops($userID,$type)
    {
        $data = \common\models\InternalPay::withUserId($userID, 1);

 
        $arr = array();
        $arr["farsiName"] = $data['website_name'];
        $arr["englishName"] = 'sefroweb';
      //  $arr["telephoneNumber"] = $data['customer_tell'];
		$arr["telephoneNumber"] = "021-88325660";
		
        $arr["postalCode"] = "1911715313";
      //  $arr["businessCertificateNumber"] = "123";
     //   $arr["certificateExpiryDate"] = 1568108800000;
     //   $arr["description"] = "aaa";
        $arr["businessCategoryCode"] = "5816";
        $arr ["businessSubCategoryCode"] = "0000";
        $arr ["ownershipType"] = 1;
     //   $arr ["rentalContractNumber"] = "1";
     //   $arr ["rentalExpiryDate"] = 100000000;
     //   $arr ["Address"] = 100000000;
	     $arr["countryCode"] = "IR";
    //    $arr["provinceCode"] = "THR";
		
    //    $arr["cityCode"] = "108012";
		   $arr["businessType"] = 2;
		   
		 //      $arr["etrustCertificateType"] = null;
     //   $arr["etrustCertificateIssueDate"] = null;
     //   $arr["etrustCertificateExpiryDate"] = null;
		
		    $arr["emailAddress"] = "mysaltern@gmail.com";
		   $arr["websiteAddress"] = "www.sefroweb.com";
		   
		   if($type==14)
		{
			$arr["updateAction"] = 0;
		}
		   
		   
      /*
به درد نخور

	  $arr["certificateIssueDate"] = null;
        $arr["rentalExpiryDate"] = null;
        $arr["rentalContractNumber"] = null;
    
     
        $arr["address"] = null;
    
      
     */
    
		return $arr;
    }

    public function acceptors($userID,$type)
    {
		$today = date("Y-m-d");

        $data = \common\models\BankAccounts::bank_list($userID, 1);
        $shaba = $data['shaba'];


        $arr = array();
		
		 
		$terminals = array();
		
        $arr["iin"] = "581672061";
		
        $arr["acceptorCode"] = "000000263930015";
		$arr["facilitatorAcceptorCode"] = "000000263752742";
        $arr["acceptorType"] = 2;
        $arr["cancelable"] = false;
        $arr["refundable"] = false;
        $arr["blockable"] = false;
        $arr["chargeBackable"] = false;
        $arr ["settledSeparately"] = false;
        $arr ["allowScatteredSettlement"] = 0;
        $arr["acceptCreditCardTransaction"] = false;
        $arr["allowIranianProductsTrx"] = false;
        $arr["allowKaraCardTrx"] = false;
        $arr["allowGoodsBasketTrx"] = false;
        $arr["allowFoodSecurityTrx"] = false;
        $arr["allowJcbCardTrx"] = false;
        $arr["allowUpiCardTrx"] = false;
        $arr["allowVisaCardTrx"] = false;
        $arr["allowMasterCardTrx"] = false;
        $arr["allowAmericanExpressTrx"] = false;
        $arr["allowOtherInternationaCardsTrx"] = false;
        $arr["description"] = 'aa';
      
       if($type!=7 and $type !=14 and $type!=17 and $type!=18 )
	  {
	 	    $arr["shaparakSettlementIbans"] = array("IR680170000000223650150001");
	   }
	      if($type==14)
		{
			$arr["updateAction"] = 0;
		}
		
		 $arr['terminals']=array()  ;
		
          $terminal =array();
		//   $terminal;
	$terminal['sequence'] = "10305633762654";
    $terminal["terminalNumber"]="61242330";
    $terminal["serialNumber"]= null;
    $terminal["setupDate"]= "$today";
    $terminal["terminalType"]= 1; 
    $terminal["hardwareBrand"]= null;
    $terminal["hardwareModel"]= null;
    $terminal["accessAddress"]= "sefroweb.com";
    $terminal["accessPort"]= "443";
    $terminal["callbackAddress"]= "sefroweb.com"; 
    $terminal["callbackPort"]= "443";
    $terminal["description"]= "desc";
 array_push(   $arr['terminals'], $terminal ) ;
 if($type==6 or $type==17)
 {
	 $arr['terminals']=null;
 }
 
 // $arr['terminals']=$terminal;
//  var_dump($arr);
//  die;
        return $arr;
    }

    public function security()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $username = "faraz_andishan";
        $password = "Fa@123456";
        $string = $username . ":" . $password;
        $base = base64_encode($string);

 
        return $base;
    }
	
	    public function securityEND()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $username = "infosabasamanecom_pf";
        $password = "786T@leb!";
        $string = $username . ":" . $password;
        $base = base64_encode($string);
 
 
        return $base;
    }
	
	   public function merchantIbans($userID)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      
	  
	  
	  
        return $arr;
    }
	    public function xml($url)
    {
        $xml = simplexml_load_file("$url") or die("Error: Cannot create object");
        $json = json_encode($xml);
        $configData = json_decode($json, true);
        $head = ($configData['pacs.008.001.01']);

        $content = $configData['pacs.008.001.01']['CdtTrfTxInf'];

        $arr = array('head' => $head, 'content' => $content);

        return $arr;
    }

}

?>