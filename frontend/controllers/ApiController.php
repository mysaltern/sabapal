<?php


namespace frontend\controllers;


use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\httpclient\Client;


/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class ApiController extends Controller
    {


    /**
     * @inheritdoc
     */
    public function behaviors()
        {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                        [
                        'actions' => ['virtual', 'test', 'accept', 'render', 'response', 'responsesaderat', 'verify', 'signup'],
                        'allow' => true,
//                        'roles' => ['*'],
                    ]
                ],
            ],
        ];

        }


    public function actionVirtual()
        {



        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;


        $attributes = \yii::$app->request->post();
        $check = count($attributes);
        if ($check == 0)
            {
            return array('status' => '-8', 'description' => 'اطلاعات حتما از طریق بادی و متد پست ارسال شود');
            exit();
            }


        $CallbackURL = $attributes['CallbackURL'];

        $MerchantID = $attributes['MerchantID'];
        $Amount = $attributes['Amount'] * 10;
        $Description = $attributes['Description'];

//        $aa = \yii\helpers\Json::decode($attributes, true);
//        return array('status' => '-4', 'description' => 'نوع درخواست صحیح نیست');
//        exit();





        $ip = Yii::$app->getRequest()->getUserIP();


        $internal = \common\models\InternalPay::find()->where(['ip' => $ip, 'private_code' => $MerchantID, 'active' => 1, 'deleted' => 0])->asArray()->one();

        $private = $internal['private_code'];
        $userID = $internal['userID'];
        if (is_null($userID))
            {
            return array('Status' => '-5', 'description' => 'مرچنت کد شما اشتباه وارد شده است یا اینن که آی پی شما تغییر کرده است');
            exit();
            }
        $urlTest = Yii::$app->Security->checkBlock($userID);
        if ($urlTest == false)
            {
            return array('Status' => '-6', 'description' => 'کاربری شما مسدود شده است');
            exit();
            }

        if (empty($attributes))
            {
            return array('Status' => '-4', 'description' => 'نوع درخواست صحیح نیست');
            exit();
            }
        if (is_null($private))
            {

            return array('Status' => '-3', 'description' => 'آی پی درگاه تایید نشد');
            exit();
            }

        if (!isset($attributes['Amount']))
            {
            return array('status' => '-2', 'description' => 'مبلغ تراکنش شما تایید نشد');
            exit();
            }
        else
            {

            $amount = $attributes['Amount'] * 10;
            }

        if (!isset($attributes['MerchantID']))
            {
            return array('Status' => '-2', 'description' => 'کد تراکنش شما تایید نشد');
            exit();
            }

        if (!isset($attributes['CallbackURL']))
            {
            return array('Status' => '-6', 'description' => 'صفحه ی بازگشتی صحیح نیست');
            exit();
            }



        if (isset($attributes['MerchantID']) and isset($attributes['Amount']) and ! is_null($private))
            {
            if ($attributes['MerchantID'] == $private)
                {



                do
                    {
                    $token = \Yii::$app->security->generateRandomString();


                    $check = Yii::$app->ReadHttpHeader->uniqueAuth($token, 'transaction');
                    } while ($check == true);



                $model = new Transaction();
                $model->token = $token;
                $model->userID = $userID;
                $model->date = time();
                $model->status = -1;


                $model->amount = $amount;
                $model->deleted = 0;
                $model->save(false);
                $model->cck = Yii::$app->Security->generate($userID, $amount, $model->id);
                $model->save(false);

                $callback = new \common\models\TransactionCallback;
                $callback->transaction_id = $model->id;
                $callback->url = $attributes['CallbackURL'];
                $callback->save(false);

                return array('Status' => '100', 'RefID' => $model->id, 'Authority' => $model->token, 'description' => ' تراکنش شما تایید شد');
                exit();
//                $meli = new \common\models\Meli();
//                $meli->request($amount, "http://www.saba.sabapal.ir/sabaYii/frontend/web/api/response", $model->id);
                }
            else
                {
                return array('Status' => -5, 'data' => 'رمز درگاه شما فعال نیست');
                }
            }
        else
            {


            return array('Status' => '-1', 'description' => 'اطلاعات درگاه شما تایید نشد');
            }

        }


    public function actionResponsesaderat()
        {


        $resCode = $_POST['respcode'];


        $respmsg = $_POST['respmsg'];
        $terminalid = $_POST['terminalid'];
        $OrderId = $_POST['invoiceid'];
        $amount = $_POST['amount'];


        $ip = Yii::$app->getRequest()->getUserIP();
        $post = $_POST;

        $url = \common\models\TransactionCallback::urlWithOrder($OrderId);

        if ($resCode == -1 or ! isset($post['rrn']))
            {



            \Yii::$app->getSession()->setFlash('faildTrancaction', 'پرداخت شما   انجام نشد  ');

            header("Location:$url?Status=-1");
            die;
            exit;
            }
        /*   $trans = Transaction::checkWithTokenBankIPBlock($Token);

          if ($trans == false)
          {
          $url = \common\models\TransactionCallback::urlWithOrder($OrderId);
          header("Location:$url?status=-1");
          die;
          exit;
          }
         */


        $rrn = $post['rrn'];
        $cardnumber = $post['cardnumber'];
        $tracenumber = $post['tracenumber'];
        $Token = $post['digitalreceipt'];
        $payload = $post['payload'];
        $datepaid = $post['datepaid'];
        $issuerbank = $post['issuerbank'];
        $OrderId = $post['invoiceid'];


        //  $return = $meli->verify($OrderId, $Token, $ResCode);





        $transID = \common\models\Transaction::findOne(['id' => $OrderId]);
            {
            $terminal = '61001187';
            $params = 'digitalreceipt=' . $Token . '&Tid=' . $terminal;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://mabna.shaparak.ir:8081/V1/PeymentApi/Advice');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($res, true);


            if (strtoupper($result['Status']) == 'OK')
                {



                if ($transID->amount == $result['ReturnId'])
                    {




                    $rrn = $post['rrn'];
                    $cardnumber = $post['cardnumber'];
                    $tracenumber = $post['tracenumber'];
                    $digitalreceipt = $post['digitalreceipt'];
                    $payload = $post['payload'];
                    $datepaid = $post['datepaid'];
                    $issuerbank = $post['issuerbank'];


                    $bank = new \common\models\BankLog();
                    //   $bank->id = $bankID['id'];
                    //   $bank->isNewRecord = false;
                    $bank->amount = $transID->amount;
                    $bank->auth = $digitalreceipt;
                    $bank->response = $cardnumber;
                    $bank->SystemTraceNo = $tracenumber;
                    $bank->RetrivalRefNo = $rrn;
                    $bank->date = time();
                    $bank->response = $payload;
                    $bank->save(false);
                    //    $bank->update(false, ['SystemTraceNo', 'RetrivalRefNo','auth', 'date', 'response', 'amount']);
                    //   $transID = \common\models\Transaction::findOne(['id' => $order]);
                    //  if ($OrderId == $order)
                        {

                        $model = new \common\models\Transaction();
                        $model->id = $OrderId;
                        $model->isNewRecord = false;
                        $model->status = 1;
                        $model->sourceID = $bank->id;
                        $model->sourceTypeID = 1;
                        $model->bankLogID = $bank->id;
                        $model->deleted = 0;
                        //    $model->cck = Yii::$app->Security->generate(Yii::$app->user->id, $money, $model->id);

                        $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'sourceID']);



                        header("Location:$url?Status=OK&Authority=$digitalreceipt&RefID=$OrderId");
                        die;
                        }
                    }
                }

            if (strtoupper($result['Status']) == 'DUPLICATE')
                {
                header("Location:$url?Status=5");
                die;
                exit;
                }
            }

        }


    public function actionAccept()
        {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $attributes = \yii::$app->request->post();


        if (!isset($attributes['token']))
            {
            return array('status' => '-1', 'description' => 'توکن وارد نشد');
            exit();
            }
        $ip = Yii::$app->getRequest()->getUserIP();

        $check = Transaction::checkWithToken($attributes['token'], $ip);

        if ($check != false)
            {
            $checkPay = Transaction::checkPayment($check['id']);

            if ($checkPay == true)
                {
                return array('status' => '1', 'description' => 'این سفارش پرداخت شده است');
                exit();
                }
            else
                {
                $update = \common\models\BankLog::updateStatus($check['id']);

                return true;
                }
            }
        else
            {
            return array('status' => '-1', 'description' => 'اطلاعات توکن تایید نشد');
            exit();
            }

        }


    public function actionRender($Token)
        {

        $ip = Yii::$app->getRequest()->getUserIP();

        $check = Transaction::checkWithTokenIPBlock($Token);
        $orderId = $check['id'];
        $method = Transaction::checkMethod();


        if ($method == false)
            {
            return Yii::$app->response->redirect(['transaction/rooter', 'Token' => $Token, 'orderId' => $orderId]);
            exit;
            }


        $amount = $check['amount'];



        $url = 'https://mabna.shaparak.ir:8080/Pay';

        $terminal = '61001187';
        $redirectAddress = 'https://sabapal.ir/sabapal/frontend/web/api/responsesaderat';

        $invoiceNumber = $orderId;



        echo $setPayment = '<form id="paymentUTLfrm" action="https://mabna.shaparak.ir:8080" method="POST">
					<input type="hidden" id="TerminalID" name="TerminalID" value="' . $terminal . '">
					<input type="hidden" id="Amount" name="Amount" value="' . $amount . '">
					<input type="hidden" id="callbackURL" name="callbackURL" value="' . $redirectAddress . '">
					<input type="hidden" id="InvoiceID" name="InvoiceID" value="' . $invoiceNumber . '">
					<input type="hidden" id="Payload" name="Payload" value="">
					</form><script>
					function submitmabna() {
					document.getElementById("paymentUTLfrm").submit();
					}
					window.onload=submitmabna; </script>';

        exit;



        //   $meli = new \common\models\Meli();
        //$meli->request($check['amount'], "https://sabapal.ir/sabapal/frontend/web/api/response3", $check['id']);

        }


    public function actionResponse()
        {
//        $this->enableCsrfValidation = false;
        $meli = new \common\models\Meli();


        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;


        $attributes = \yii::$app->request->post();


//        if (!isset($attributes['OrderId']))
//        {
//            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
//            return $this->redirect(['create']);
//        }
        $OrderId = $attributes["OrderId"];
        $Token = $attributes["token"];
        $ResCode = $attributes["ResCode"];
        $ip = Yii::$app->getRequest()->getUserIP();

        $trans = Transaction::checkWithTokenBankIPBlock($Token);

        if ($trans == false)
            {
            $url = \common\models\TransactionCallback::urlWithToken($Token, $OrderId);
            header("Location:$url?status=-1");
            die;
            exit;
            }

        if ($ResCode == -1)
            {
            $url = \common\models\TransactionCallback::urlWithToken($Token, $OrderId);

            \Yii::$app->getSession()->setFlash('faildTrancaction', 'پرداخت شما   انجام نشد  ');


            header("Location:$url?status=-1");
            die;
            exit;
            }

        $return = $meli->verify($OrderId, $Token, $ResCode);


        $res = $return->ResCode;

        if ($res == 0)
            {
            $money = $return->Amount;
            $retNo = $return->RetrivalRefNo;
            $order = $return->OrderId;
            $trace = $return->SystemTraceNo;
            $res = $return->ResCode;


            $bankID = \common\models\BankLog::findOne(['auth' => $Token]);


            if ($bankID['amount'] == $money)
                {

                $bank = new \common\models\BankLog();
                $bank->id = $bankID['id'];
                $bank->isNewRecord = false;
                $bank->amount = $money;
                $bank->SystemTraceNo = $trace;
                $bank->RetrivalRefNo = $retNo;
                $bank->date = time();
                $bank->externalPayID = 1;
                $bank->response = $res;

                $bank->update(false, ['SystemTraceNo', 'RetrivalRefNo', 'date', 'response', 'amount', 'externalPayID']);


                $transID = \common\models\Transaction::findOne(['id' => $order]);

                if ($OrderId == $order)
                    {

                    $model = new \common\models\Transaction();
                    $model->id = $OrderId;
                    $model->isNewRecord = false;
                    $model->status = 1;
                    $model->sourceID = $bank->id;
                    $model->sourceTypeID = 1;
                    $model->bankLogID = $bank->id;
                    $model->deleted = 0;
                    //    $model->cck = Yii::$app->Security->generate(Yii::$app->user->id, $money, $model->id);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'sourceID']);

                    $url = $trans['urlBack'];

                    $tokenInternal = $trans['token'];

                    header("Location:$url?Status=OK&Authority=$tokenInternal&RefID=$OrderId");
                    die;
                    }
                }
            }

        }


    public function actionVerify()
        {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $this->enableCsrfValidation = false;

        $private = $_POST["private_code"];

        $token = $_POST["token"];
        $money = (int) $_POST["money"];



        $ip = Yii::$app->getRequest()->getUserIP();
        $internal = \common\models\InternalPay::find()->where(['ip' => $ip, 'private_code' => $private, 'active' => 1, 'deleted' => 0])->asArray()->one();

        $private = $internal['private_code'];
        $userID = $internal['userID'];
        if (is_null($userID))
            {
            return array('Status' => '-5', 'description' => 'مرچنت کد شما اشتباه وارد شده است یا اینن که آی پی شما تغییر کرده است');
            exit();
            }
        $urlTest = Yii::$app->Security->checkBlock($userID);
        if ($urlTest == false)
            {
            return array('Status' => '-6', 'description' => 'کاربری شما مسدود شده است');
            exit();
            }




        $check = Transaction::checkVerify($token, $money, $private, $ip);

        if ($check == false)
            {
            return array('Status' => '-1', 'description' => 'این سفارش پرداخت نشده است');
            exit();
            }
        else
            {
            return array('Status' => '0', 'description' => 'این سفارش پرداخت شده است');
            exit();
            }

        }


    public function actionTest()
        {



        $payment = 'http://localhost/sabaTest1/web/index.php?r=site%2Fpost';
//        $client = new Client(['base_uri' => $payment, 'allow_redirects' => true]);

        $client = new Client();
        $response = $client->createRequest()
                        ->setMethod('post')
                        ->setUrl("$payment")
                        ->setData(['name' => 'John Doe', 'email' => 'johndoe@domain.com'])
                        ->setOptions([
//                    'proxy' => 'tcp://proxy.example.com:5100', // use a Proxy
//                    'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
                        ])
                        ->redirect($payment)->send();
// the problem is not redirect to $payment.
        header("Location: $payment");
        die;

        }


    public function beforeAction($action)
        {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

        }


    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
        {
        if (($model = Transaction::findOne($id)) !== null)
            {
            return $model;
            }
        else
            {
            throw new NotFoundHttpException('The requested page does not exist.');
            }

        }


    public $enableCsrfValidation = false;


    public function actionSignup()
        {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $attr = Yii::$app->request->post();


        if (isset($attr['username']) && isset($attr['password']))
            {
            $username = $attr['username'];
            $pass = $attr['password'];
            $password = \Yii::$app->security->generatePasswordHash($pass);
            $email = $attr['email'];

            $finduser = \dektrium\user\models\User::findAll(['username' => $username]);
            if ($finduser)
                {
                return array('Status' => '-1', 'description' => 'کاربر با همچین نام کاربری قبلا در سامانه ثبت نام کرده است ');
                exit();
                }

            if (!isset($attr['name']))
                {
                return array('Status' => '-2', 'description' => 'نام وارد نشده است ');
                exit();
                }

            if (!isset($attr['lastName']))
                {
                return array('Status' => '-3', 'description' => 'نام خانوادگی وارد نشده است ');
                exit();
                }

            if (!isset($attr['nationalCode']))
                {
                return array('Status' => '-4', 'description' => 'کدملی وارد نشده است ');
                exit();
                }

            if (!isset($attr['address']))
                {
                return array('Status' => '-5', 'description' => 'کدملی وارد نشده است ');
                exit();
                }

            if (!isset($attr['mobile']))
                {
                return array('Status' => '-6', 'description' => 'تلفن همراه وارد نشده است ');
                exit();
                }





            $model = new \dektrium\user\models\User();
            $model->username = $username;
            $model->email = $email;
            $model->password_hash = $password;
            $model->flags = 1;
            $model->save();
            $userID = $model->id;


            $name = $attr['name'];
            $lastName = $attr['lastName'];
            $nationalCode = $attr['nationalCode'];
            $address = $attr['address'];
            $mobile = $attr['mobile'];

            $models = new \common\models\Contact();
            $models->userID = $userID;
            $models->name = $name;
            $models->lastName = $lastName;
            $models->nationalCode = $nationalCode;
            $models->address = $address;
            $models->mobile = $mobile;
            $models->save();

            return array('Status' => '1', 'description' => 'عملیات ثبت نام با موفقیت به پایان رسید ');
            exit();
            }

        }


    }

