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

class ReadHttpHeader extends Component
{

    public function RealIP()
    {
        $ip = false;

        $seq = array('HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR'
            , 'HTTP_X_FORWARDED'
            , 'HTTP_X_CLUSTER_CLIENT_IP'
            , 'HTTP_FORWARDED_FOR'
            , 'HTTP_FORWARDED'
            , 'REMOTE_ADDR');

        foreach ($seq as $key)
        {
            if (array_key_exists($key, $_SERVER) === true)
            {
                foreach (explode(',', $_SERVER[$key]) as $ip)
                {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false)
                    {
                        return $ip;
                    }
                }
            }
        }
    }

    public function txtOrder($id)
    {
        if ($id == 1)
        {
            $txtOrder = 'بالا';
        }
        if ($id == 2)
        {
            $txtOrder = 'متوسط';
        }
        if ($id == 3)
        {
            $txtOrder = 'پایین';
        }


        return $txtOrder;
    }

    public function txtStatus($id)
    {
        if ($id == 1)
        {
            $txtOrder = 'باز';
        }
        if ($id == 2)
        {
            $txtOrder = 'انتظار برای پاسخ';
        }
        if ($id == 3)
        {
            $txtOrder = 'بسته';
        }
        if ($id == 4)
        {
            $txtOrder = 'پاسخ داده شده';
        }


        return $txtOrder;
    }

    public function settlement($id)
    {
        if ($id == 0)
        {
            $settlement = 'تایید نشده';
        }
        if ($id == 2)
        {
            $settlement = 'در حال انجام';
        }
        if ($id == 3)
        {
            $settlement = 'فرستاده شده';
        }



        return $settlement;
    }

    public function deleting($id, $table)
    {
        $connection = \Yii::$app->db;
        $userID = \Yii::$app->user->id;



        $connection->createCommand()
                ->update("$table", ['deleted' => 1], "id= $id and userID = $userID")
                ->execute();
    }

    public function ShowStatus($ErrorCode)
    {
        $soapclient = new \SoapClient('https://sadad.shaparak.ir/services/MerchantUtility.asmx?wsdl');
        $token = $soapclient->GetToken();
        $client->ListTable($token);
        var_dump($client);
        die;
        $MerchandID = '111111';
        $amount = '1000'; // 100 toman
        $order_id = 1; // tekrari babashad
        $TransactionKey = 'aaaaaa';
        $TerminalID = '222222';
        $callback = 'http://example.org/callback.php?order_id=' . $order_id;

        $result = $soapProxy->PaymentUtility($MerchandID, $amount, $order_id, $TransactionKey, $TerminalID, $callback);
    }

    public function money($userID)
    {



        $kharid = \common\models\Transaction::find()->joinWith('sourceType')->where(['userID' => $userID, 'status' => 1, 'sourcetypes.opration' => 1, 'deleted' => 0])->sum('amount');

        $check = \common\models\Transaction::find()->joinWith('sourceType')->where(['userID' => $userID, 'status' => 1, 'sourcetypes.opration' => 1, 'deleted' => 0])->orderBy('transaction.id desc')->one();
        if (isset($check->attributes['id']))
        {

            if (isset($check->attributes['cck']))
            {
                $id = $check->attributes['id'];
                $cck = $check->attributes['cck'];
				//var_dump($cck);
				//die;
                $money = $check->attributes['amount'];
                $validate = Yii::$app->Security->checkSecurity($money, $userID, $ip = 1, $cck, 1, $id);
//var_dump($id);
//die;

                if ($validate != true)
                {

                    Yii::$app->Security->blockUser($userID);


                    Yii::$app->getSession()->destroy();
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
                }
            }
            else
            {
                Yii::$app->Security->blockUser($userID);


                Yii::$app->getSession()->destroy();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
            }
        }
        $fooroosh = \common\models\Transaction::find()->joinWith('sourceType')->where(['userID' => $userID, 'status' => [0, 1], 'sourcetypes.opration' => -1, 'deleted' => 0])->sum('amount');
        $checkF = \common\models\Transaction::find()->joinWith('sourceType')->where(['userID' => $userID, 'status' => [0, 1], 'sourcetypes.opration' => -1, 'deleted' => 0])->orderBy('transaction.id desc')->one();


        if (isset($checkF->attributes['id']))
        {



            if (isset($checkF->attributes['cck']))
            {
                $id = $checkF->attributes['id'];
                $cck = $checkF->attributes['cck'];
                $money = $checkF->attributes['amount'];
                $validate = Yii::$app->Security->checkSecurity($money, $userID, $ip = 1, $cck, 1, $id);
                if ($validate != true)
                {
                    Yii::$app->Security->blockUser($userID);


                    Yii::$app->getSession()->destroy();
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
                }
            }
            else
            {
                Yii::$app->Security->blockUser($userID);

                Yii::$app->getSession()->destroy();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
            }
        }

        return $kharid - $fooroosh;
    }

    public function getIDwithEmail($email)
    {

        $id = \dektrium\user\models\User::find()->where("email=  '$email' or username = '$email' or mobile = '$email' and mobile_phone.status =1 and mobile_phone.active =1")->leftjoin('mobile_phone', 'mobile_phone.user_id=user.id')->one();

        if (isset($id['id']))
        {
            return $id['id'];
        }
        else
        {
            return false;
        }
    }






    public function checkAccess($userID, $table, $id)
    {
        $query = new Query;
        $query->select('id')
                ->from("$table")
                ->where(['userID' => "$userID", 'deleted' => 0, 'id' => $id]);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();
        if (isset($rows['id']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function lastAccess($userID, $table)
    {
        $query = new Query;
        $query->select('id')
                ->from("$table")
                ->where(['userID' => "$userID", 'deleted' => 0]);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();
        if (isset($rows['id']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function uniqueAuth($auth, $table)
    {
        $query = new Query;
        $query->select('id')
                ->from("$table")
                ->where(['token' => "$auth", 'deleted' => 0]);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();

        if (isset($rows['id']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function access($id, $table, $itemName)
    {
        $query = new Query;
        $query->select('item_name')
                ->from("$table")
                ->where(['user_id' => "$id", 'item_name' => "$itemName"]);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();

        if (isset($rows['item_name']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function primary($userID)
    {
        $query = new Query;
        $query->select('name,lastName')
                ->from("contact")
                ->where(['userID' => "$userID"]);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();

        if (isset($rows['name']))
        {
            return $rows['name'] . ' ' . $rows['lastName'];
        }
        else
        {
            $query->select('username')
                    ->from("user")
                    ->where(['id' => "$userID"]);
            $rows = $query->one();
            $command = $query->createCommand();
            $rows = $command->queryOne();
            if (isset($rows['username']))
            {
                return $rows['username'];
            }
            else
            {
                return 'لطفا وارد شوید';
            }
        }
    }

    public function sendSMS($mobile, $text)
    {


//ارسال اس ام اس
        $saltern = new \common\models\saltern();
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));


        $time = '';
//   گرفتن تایم امروز
        date_default_timezone_set('Iran');
        $saat = date('H:i', strtotime("+0 minutes"));

        $sal = date('y');
        $khareji[1] = date('m');
        $khareji[2] = date('d');
        $y = date("Y");
//   گرفتن تایم امروز


        $parameters['username'] = $saltern->username;
        $parameters['password'] = $saltern->password;
        $parameters['from'] = $saltern->from;
        $parameters['to'] = $mobile;
        $parameters['text'] = $text;
        $parameters['isflash'] = false;
        $parameters['scheduleDateTime'] = "$y-$khareji[1]-$khareji[2]T$saat:59";
        $timeFull = "$y-$khareji[1]-$khareji[2]T$saat:59";
        $parameters['period'] = "Once";

        $scheduleId = $sms_client->AddSchedule($parameters)->AddScheduleResult;
    }

    public function jsonTransaction($arr)
    {
 
        $path = Yii::getAlias('@frontend') . "/web/json/";
//set the filename
        $filename = $path . "_13980215.json";
       // $iin = $arr['iin'];
      //  $acceptorCode = $arr['acceptorCode'];
        $acceptorCode ='000000263930015';
      //  $wage = $arr['wage'];
         $wage =10;
      //  $amount = $arr['amount'];
        $amount =500;
	 
      //  $sheba = $arr['sheba'];
     //   $shebaMasdoodi = $arr['shebaMasdoodi'];
	 	$amountResult = $this->calculateWage($wage, 0, $amount);
	 //	$amountResult = $this->calculateWage(10, 0, 1000);
	//	  var_dump($amount);
	//	   var_dump($amountResult);
		$resultWage = $amount -$amountResult;
 // var_dump($resultWage);
 

 // die;
        if (file_exists("$filename"))
        {
	 
			$static = Yii::$app->params['paymentFacilitatorIban'];

//prepare the data
            $data = array('settlementDataDetails');
            $data = array(
                'iin' => 581672061,
                'acceptorCode' => "$acceptorCode",
              //  'paymentFacilitatorIban' => "$shebaMasdoodi",
                'paymentFacilitatorIban' => "IR730560080981002961662001",
                'settlementAmount' => round($amountResult, 0) ,
                'wageAmount' =>  round($resultWage, 0),
             //   'settlementIban' => "$sheba",
                'settlementIban' => "IR680170000000223650150001",
            );


            $inp = file_get_contents("$filename");
            $tempArray = json_decode($inp, true);
 
            array_push($tempArray['settlementDataDetails'], $data);

            $formattedData = json_encode($tempArray);


//open or create the file
            $handle = fopen($filename, 'w+');

//write the data into the file
            fwrite($handle, $formattedData);

//close the file
            fclose($handle);
        }
        else
        {




       //     $data= array("settlementDataDetails"   );

       //     $formattedData = json_encode($data);
$post_data = json_encode(array('settlementDataDetails' => array()));

//open or create the file
            $handle = fopen($filename, 'w+');

//write the data into the file
            fwrite($handle, $post_data);

//close the file
            fclose($handle);
            $data = $filename;
			
		 $this->jsonTransaction($arr);
        }
    }

    public function to($userID, $amount)
    {

        $to = array();

        $wage = $this->wage($userID, $amount);
        $to['wage'] = $wage;

        $userID = Yii::$app->user->id;


        $query = new Query;
        $query->select('*')
                ->from('internal_pay')
                ->join('inner join', 'bank_accounts', "bank_accounts.userID = internal_pay.userID")
                ->where(['internal_pay.active' => 1, 'internal_pay.userID' => $userID, 'bank_accounts.deleted' => 0, 'bank_accounts.primary' => 1]);
        $command = $query->createCommand();
        $data = $command->queryOne();


        if ($data == false)
        {
            \Yii::$app->getSession()->setFlash('close', ' لطفا حساب اصلی خود را وارد کنید یا اگر حساب اصلی خودتان را وارد کرده اید منتظر بمانید تا توسط ما تایید شود و سپس تقاضای تسویه نمایید.');
            return $this->redirect(['bankaccounts/index']);
            exit;
        }
        else
        {



            $myShaba = \common\models\Config::checkOurShaba('ملی');

            if ($myShaba == false)
            {
                \Yii::$app->getSession()->setFlash('close', 'متاسفانه این درخواست به دلیل مشکلات فنی فعلا در دسترس نیست . لطفا بعدا امتحان کنید.');
                return $this->redirect(['transaction/index']);
                exit();
            }
            $to['myShaba'] = $myShaba['shaba'];

            $to['shaba'] = $data['shaba'];
            $to['amount'] = $amount;

            return $to;
        }
    }

    public function wage($userID, $amount)
    {
        $wage = \common\models\WageAmount::amountCheck($userID, $amount);


        $static = array();

        if ($wage['staticAmount'] > 0)
        {
            $static = $wage['staticAmount'];
        }
        if ($wage['percent'] > 0)
        {
            $percent = $wage['percent'];
        }

        $amount = $this->calculateWage($percent, $static, $amount);

        return $amount;
    }

    public function calculateWage($percent, $static, $amount)
    {


        // محاسبه ی درصد

        $priceA = $percent * $amount / 100;

        $price = $amount - $priceA;

        //محاسبه قیمت ثابت

        $price2 = $price - $static;
 

        if ($price >= $price2)
        {
            return $price2;
        }
        else
        {
            return $price2;
        }
    }

}

?>