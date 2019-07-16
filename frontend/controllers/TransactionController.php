<?php

namespace frontend\controllers;

use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use dektrium\user\filters\AccessRule;
use dektrium\user\Finder;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use dektrium\user\models\UserSearch;
use dektrium\user\helpers\Password;
use dektrium\user\Module;
use dektrium\user\traits\EventTrait;
use yii\base\ExitException;
use yii\base\Model;
use yii\base\Module as Module2;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\db\Query;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'pic', 'responsesaderat', 'responsesaderat', 'create2', 'wallet', 'create3', 'pay', 'request', 'responsereq', 'index', 'clearing', 'transfer', 'response', 'response2'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['pay', 'pic', 'responsetosaderat', 'responsereq', 'responsereqsaderat'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'responsesaderat', 'create2', 'create3', 'wallet', 'request', 'index', 'clearing', 'transfer', 'response', 'response2'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {

//        $data = Yii::$app->Data->merchent(Yii::$app->user->id);
        //      $data = Yii::$app->Data->acceptors(Yii::$app->user->id);
//        var_dump($data);
//        die;
// echo $_SERVER['SERVER_ADDR'];
        //die;
        $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);


        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'money' => $money,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionWallet()
    {

        $token = $_GET['Token'];
        $toArr = Transaction::getUserIdWithToken($token);
        $to = $toArr['userID'];
        $check = Transaction::transfering(\Yii::$app->user->id, $to, $toArr['amount'], true);

        if ($check == true)
        {
            $url = \common\models\TransactionCallback::urlWithOrder($toArr['id']);
            $orderID = $toArr['id'];
            header("Location:$url?Status=OK&Authority=$token&RefID=$orderID");
            die;
        }
    }

    public function actionRooter()
    {




        if (isset($_POST['method']))
        {
            $token = $_GET['Token'];
            return $this->redirect(['wallet', 'Token' => $token]);
        }


        return $this->render('rooter');
    }

    public function actionPic()
    {

        $this->layout = false;

        return $this->render('pic');
    }

    public function actionRequest()
    {


        if (!\Yii::$app->user->can('mobile'))
        {
            \Yii::$app->getSession()->setFlash('close', 'لطفا ابتدا موبایل خود را وارد کنید');
            return $this->redirect(['contact/mobile']);
            exit;
        }
//        \Yii::$app->getSession()->setFlash('close', 'این امکان هنوز فعال سازی نشده است');
        $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);
        $model = new Transaction;
        $model->load(\Yii::$app->request->post());


        $list = Transaction::listRequest(Yii::$app->user->id);
        if ($model->load(\Yii::$app->request->post()))
        {



            if ($model->validate())
            {

                $model->userID = Yii::$app->user->id;
                $model->date = time();
                $model->status = -1;
                $model->sourceTypeID = 6;
                $model->sourceID = $model->goal;
                $model->save(false);
                $mobile = \common\models\MobilePhone::getMobile($model->userID);

                $modelID = \common\models\Transaction::findOne(['id' => $model->id]);

                $text = "مشترک  $mobile از شما درخواست $modelID->amount ریال را کرده است . برای پردخت لطفا روی لینک زیر کلیک کنید";
                $text .= "https://sabapal.ir/sabapal/frontend/web/transaction/pay?link=$model->id";


                $send = Yii::$app->ReadHttpHeader->sendSMS($model->goal, "$text");

                \Yii::$app->getSession()->setFlash('success', "درخواست وجه برای $model->goal ارسال شد");
                return $this->redirect(['index']);
            }
        }

        return $this->render('request', [
                    'money' => $money,
                    'list' => $list,
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();
        $meli = new \common\models\Meli();

        if ($model->load(Yii::$app->request->post()))
        {

            $model->userID = Yii::$app->user->id;
            $model->date = time();
            $model->status = -1;
            $model->save(false);


            $meli->request($model->amount, "https://sabapal.ir/sabapal/frontend/web/transaction/response", $model->id);
//            var_dump($a);
            die;
//            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreate3()
    {




        $model = new Transaction();
        if ($model->load(Yii::$app->request->post()))
        {


            $model->userID = Yii::$app->user->id;
            $model->date = time();
            $model->status = -1;
            $model->sourceTypeID = 1;

            $model->save(false);


            $amount = $model->amount;

            $bank = new \common\models\BankLog;
            $bank->amount = $amount;

            $bank->date = time();

            $bank->userID = \Yii::$app->user->id;

            $bank->orderID = $model->id;
            $bank->externalPayID = 3;
            $bank->save(false);



            $url = 'https://mabna.shaparak.ir:8080/Pay';

            $terminal = '61001187';
            $redirectAddress = 'https://sabapal.ir/sabapal/frontend/web/transaction/responsesaderat';

            $invoiceNumber = $model->id;



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
        }


        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionResponsesaderat()
    {







        $post = $_POST;


        $respcode = $post['respcode'];
        $respmsg = $post['respmsg'];
        $terminalid = $post['terminalid'];
        $invoiceid = $post['invoiceid'];
        $amount = $post['amount'];
        if ($respcode == 0)
        {
            $rrn = $post['rrn'];
            $cardnumber = $post['cardnumber'];
            $tracenumber = $post['tracenumber'];
            $digitalreceipt = $post['digitalreceipt'];
            $payload = $post['payload'];
            $datepaid = $post['datepaid'];
            $issuerbank = $post['issuerbank'];

            $bankID = \common\models\BankLog::findOne(['orderID' => $invoiceid, 'userID' => Yii::$app->user->id]);
            {
                $bank = new \common\models\BankLog();
                $bank->id = $bankID['id'];
                $bank->isNewRecord = false;
                $bank->auth = $digitalreceipt;
                $bank->response = $cardnumber;
                $bank->SystemTraceNo = $tracenumber;
                $bank->RetrivalRefNo = $rrn;
                $bank->date = time();
                $bank->response = $payload;

                $bank->update(false, ['SystemTraceNo', 'RetrivalRefNo', 'auth', 'date', 'response', 'amount']);

                $transID = \common\models\Transaction::findOne(['id' => $invoiceid, 'userID' => Yii::$app->user->id]);
                {
                    $terminal = '61001187';
                    $params = 'digitalreceipt=' . $digitalreceipt . '&Tid=' . $terminal;
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



                        $model = new \common\models\Transaction();
                        $model->id = $invoiceid;
                        $model->isNewRecord = false;
                        $model->status = 1;
                        $model->sourceID = $bank->id;
                        $model->sourceTypeID = 1;
                        $model->bankLogID = $bank->id;
                        $model->deleted = 0;


                        $model->cck = Yii::$app->Security->generate(Yii::$app->user->id, $bankID->amount, $model->id);

                        $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);







                        \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');

                        return $this->redirect(['index']);
                    }
                    else
                    {


                        \Yii::$app->getSession()->setFlash('faild', 'پرداخت شما نا موفق بود');

                        return $this->redirect(['index']);
                    }
                }
            }
        }
        else
        {

            \Yii::$app->getSession()->setFlash('faild', 'پرداخت نا موفق بود');
            return $this->redirect(['transaction/create3']);
            exit;
        }
    }

    public function actionCreate2()
    {

        $model = new Transaction();

        $parsian = new \common\models\Parsian();
        if ($model->load(Yii::$app->request->post()))
        {

            $model->userID = Yii::$app->user->id;
            $model->date = time();
            $model->status = -1;
            $model->save(false);


            $parsian->request($model->amount, "https://sabapal.ir/sabapal/frontend/web/transaction/response2", $model->id);
//            var_dump($a);
            die;
//            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionClearing()
    {


        $model = new Transaction;

        $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);

        $model->load(\Yii::$app->request->post());
        $errors = '';

        if ($model->load(\Yii::$app->request->post()))
        {

            $check = Transaction::checkResult(\Yii::$app->user->id, $model->amount);


            if (!Yii::$app->user->can('bankAccount'))
            {
                \Yii::$app->getSession()->setFlash('close', 'لطفا یک حساب بانکی وارد کنید');
                return $this->redirect(['bankaccounts/create']);
            }
            else
            {
                $email = \Yii::$app->user->identity->email;

                $email = Yii::$app->ReadHttpHeader->getIDwithEmail($email);

                $to = Yii::$app->ReadHttpHeader->getIDwithEmail($email);

                if ($to != false)
                {
                    \Yii::$app->getSession()->setFlash('faildTrancaction', 'اطلاعات شما کامل نیست');
                    return $this->render('clearing', [
                                'money' => $money,
                                'model' => $model,
                                'errors' => $errors
                    ]);
                    exit;
                }
                else
                {

                    if ($check == false)
                    {
                        \Yii::$app->getSession()->setFlash('faildTrancaction', 'مبلغ تسویه را کاهش دهید');
                        return $this->redirect(['transaction/clearing']);
                    }
                    else
                    {


                        $to = Yii::$app->ReadHttpHeader->to(\Yii::$app->user->id, (int) $model->amount);


                        $json = Yii::$app->ReadHttpHeader->jsonTransaction($to);
                        $trans = Transaction::clearing($model->amount, \Yii::$app->user->id);
                        \Yii::$app->getSession()->setFlash('success', 'انتقال وجه با موفقیت انجام شد');
                        return $this->redirect(['index']);
                    }
                }
            }
// all inputs are valid
        }
        else
        {
// validation failed: $errors is an array containing error messages
            $errors = $model->errors;
        }


        return $this->render('clearing', [
                    'money' => $money,
                    'model' => $model
//                    'errors' => $errors
        ]);
    }

    public function actionPay($link)
    {


        $model = new Transaction;

        $money = \common\models\Transaction::find()->select('amount,userID')->where(['id' => $link, 'sourceTypeID' => 6, 'status' => -1])->asArray()->one();

        if (isset($money))
        {
            $mobile = \common\models\MobilePhone::getMobile($money['userID']);


            if ($model->load(Yii::$app->request->post()))
            {



                $Saderat = new \common\models\Saderat();

                $Saderat->request($money['amount'], "https://sabapal.ir/sabapal/frontend/web/transaction/responsereqsaderat", $link);
            }
            return $this->render('pay', [
                        'money' => $money['amount'],
                        'goal' => $mobile,
                        'model' => $model,
            ]);
        }
    }

    public function actionResponse()
    {

        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;
        $meli = new \common\models\Meli();

        if (!isset($_POST['OrderId']))
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['create']);
        }
        $OrderId = $_POST["OrderId"];
        $Token = $_POST["token"];
        $ResCode = $_POST["ResCode"];
        $return = $meli->verify($OrderId, $Token, $ResCode);
        if (isset($return->ResCode))
        {



            $res = $return->ResCode;
            if ($res == 0)
            {

            }
            $money = $return->Amount;
            $retNo = $return->RetrivalRefNo;
            $order = $return->OrderId;
            $trace = $return->SystemTraceNo;
            $res = $return->ResCode;


            $bankID = \common\models\BankLog::findOne(['auth' => $Token, 'userID' => Yii::$app->user->id]);


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



                $transID = \common\models\Transaction::findOne(['id' => $order, 'userID' => Yii::$app->user->id]);

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


                    $model->cck = Yii::$app->Security->generate(Yii::$app->user->id, $money, $model->id);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);

                    \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');
                    return $this->redirect(['index']);
                }
            }
        }
        else
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['create']);
        }
    }

    public function actionResponse2()
    {

        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;
        $parsian = new \common\models\Parsian();

        if (!isset($_POST['OrderId']))
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['create']);
        }


        $OrderId = $_POST["OrderId"];
        $Token = $_POST["Token"];
        $ResCode = $_POST["status"];
        $return = $parsian->verify($OrderId, $Token, $ResCode);

        if ($return != false)
        {


            $return = $return->ConfirmPaymentResult;

            //  $money = $return->Amount;
            $retNo = $return->RRN;
            //  $order = $return->Token;
            $trace = $return->CardNumberMasked;
            $res = $return->Token;


            $bankID = \common\models\BankLog::findOne(['auth' => $Token, 'userID' => Yii::$app->user->id]);


            //  if ($bankID['amount'] == $money)
            {


                $bank = new \common\models\BankLog();
                $bank->id = $bankID['id'];
                $bank->isNewRecord = false;
                //    $bank->amount = $money;
                $bank->SystemTraceNo = $trace;
                $bank->RetrivalRefNo = $retNo;
                $bank->date = time();
                $bank->externalPayID = 2;
                $bank->response = $res;

                $bank->update(false, ['SystemTraceNo', 'RetrivalRefNo', 'date', 'response', 'amount', 'externalPayID']);



                $transID = \common\models\Transaction::findOne(['id' => $OrderId, 'userID' => Yii::$app->user->id]);

                //        if ($OrderId == $order)
                {




                    $model = new \common\models\Transaction();
                    $model->id = $OrderId;
                    $model->isNewRecord = false;
                    $model->status = 1;
                    $model->sourceID = $bank->id;
                    $model->sourceTypeID = 1;
                    $model->bankLogID = $bank->id;
                    $model->deleted = 0;


                    $model->cck = Yii::$app->Security->generate(Yii::$app->user->id, $bankID->amount, $model->id);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);

                    \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');
                    return $this->redirect(['index']);
                }
            }
        }
        else
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['create2']);
        }
    }

    public function actionResponsereqsaderat()
    {

        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;
        $saderat = new \common\models\Saderat();


        if (!isset($_POST['rrn']))
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['request']);
        }



        $post = $_POST;

        $respcode = $post['respcode'];
        $respmsg = $post['respmsg'];
        $terminalid = $post['terminalid'];
        $invoiceid = $post['invoiceid'];
        $amount = $post['amount'];
        if ($respcode == 0)
        {
            $rrn = $post['rrn'];
            $cardnumber = $post['cardnumber'];
            $tracenumber = $post['tracenumber'];
            $digitalreceipt = $post['digitalreceipt'];
            $payload = $post['payload'];
            $datepaid = $post['datepaid'];
            $issuerbank = $post['issuerbank'];

            $bankID = \common\models\BankLog::findOne(['orderID' => $invoiceid]);




            $terminal = '61001187';
            $params = 'digitalreceipt=' . $digitalreceipt . '&Tid=' . $terminal;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://mabna.shaparak.ir:8081/V1/PeymentApi/Advice');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($res, true);


            if (strtoupper($result['Status']) != 'OK')
            {
                \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
                return $this->redirect(['request']);
            }





            if ($amount == $bankID['amount'])
            {

                $bank = new \common\models\BankLog();
                $bank->id = $bankID['id'];
                $bank->isNewRecord = false;
                //     $bank->amount = $bankID['amount'];
                $bank->auth = $digitalreceipt;
                $bank->response = $cardnumber;
                $bank->SystemTraceNo = $tracenumber;
                $bank->RetrivalRefNo = $rrn;
                $bank->date = time();
                $bank->externalPayID = 3;

                $bank->update(false, ['auth', 'SystemTraceNo', 'RetrivalRefNo', 'date', 'response', 'externalPayID']);



                $transID = \common\models\Transaction::findOne(['id' => $invoiceid]);

                if ($transID != null)
                {




                    $model = new \common\models\Transaction();
                    $model->id = $invoiceid;
                    $model->isNewRecord = false;
                    $model->status = 1;
                    $model->sourceID = $bank->id;
                    $model->sourceTypeID = 6;
                    $model->bankLogID = $bank->id;
                    $model->deleted = 0;


                    $model->cck = Yii::$app->Security->generate($transID['userID'], $amount, $invoiceid);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);


                    $master = $transID->attributes;
                    $sourceID = $master['sourceID'];
                    $amount = $master['amount'];

                    $mobile = \common\models\MobilePhone::getMobile($transID['userID']);

                    $text = "درخواست وجه شما از $sourceID  به مبلغ $amount پرداخت شد .";

                    $send = Yii::$app->ReadHttpHeader->sendSMS($mobile, "$text");

                    \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');
                    return $this->redirect(['index']);
                }
            }
        }
        else
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['request']);
        }
    }

    public function actionResponsereq()
    {

        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;
        $meli = new \common\models\Meli();


        if (!isset($_POST['OrderId']))
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['request']);
        }
        $OrderId = $_POST["OrderId"];
        $Token = $_POST["token"];
        $ResCode = $_POST["ResCode"];
        $return = $meli->verify($OrderId, $Token, $ResCode);
        if (isset($return->ResCode))
        {



            $res = $return->ResCode;
            if ($res == 0)
            {

            }
            $money = $return->Amount;
            $retNo = $return->RetrivalRefNo;
            $order = $return->OrderId;
            $trace = $return->SystemTraceNo;
            $res = $return->ResCode;


            $bankID = \common\models\BankLog::findOne(['auth' => $Token, 'orderID' => $OrderId]);


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
                    $model->sourceTypeID = 6;
                    $model->bankLogID = $bank->id;
                    $model->deleted = 0;


                    $model->cck = Yii::$app->Security->generate($transID['userID'], $money, $OrderId);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);


                    $master = $transID->attributes;
                    $sourceID = $master['sourceID'];
                    $amount = $master['amount'];

                    $mobile = \common\models\MobilePhone::getMobile($transID['userID']);

                    $text = "درخواست وجه شما از $sourceID  به مبلغ $amount پرداخت شد .";

                    $send = Yii::$app->ReadHttpHeader->sendSMS($mobile, "$text");

                    \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');
                    return $this->redirect(['index']);
                }
            }
        }
        else
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['request']);
        }
    }

    public function actionVirtual()
    {

        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $attributes = \yii::$app->request->post();

        $student = Student::find()->where(['ID' => $attributes['id']])->one();

        if (count($student) > 0)
        {


            return array('status' => true, 'data' => 'Student record is successfully deleted');
        }
        else
        {
            return 1;
        }
    }

    public function actionTo($key)
    {

        $userID = \common\models\Token::getUserID($key, 2);

        $txtStatus = Yii::$app->ReadHttpHeader->primary($userID);

        $model = new Transaction;
        if ($model->load(Yii::$app->request->post()))
        {

//var_dump($model->amount);
//die;
            $amount = $model->amount;

            $model->userID = $userID;
            $model->date = time();
            $model->status = -1;
            $model->sourceID = $model->mobile;
            $model->sourceTypeID = 7;
            $model->save(false);



            $meli = new \common\models\Saderat();
            $meli->request($amount, "https://sabapal.ir/sabapal/frontend/web/transaction/responsetosaderat", $model->id);
        }
        return $this->render('to', [
                    'model' => $model,
                    'info' => $txtStatus,
        ]);
    }

    public function actionResponsetosaderat()
    {


        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;


        if (!isset($_POST))
        {

            \Yii::$app->getSession()->setFlash('faild', 'مشکل در دریافت اطلاعات ');

            return $this->redirect(['index']);
        }
        $post = $_POST;

        $respcode = $post['respcode'];
        $respmsg = $post['respmsg'];
        $terminalid = $post['terminalid'];
        $invoiceid = $post['invoiceid'];
        $amount = $post['amount'];
        if ($respcode == 0)
        {
            $rrn = $post['rrn'];
            $cardnumber = $post['cardnumber'];
            $tracenumber = $post['tracenumber'];
            $digitalreceipt = $post['digitalreceipt'];
            $payload = $post['payload'];
            $datepaid = $post['datepaid'];
            $issuerbank = $post['issuerbank'];

            $bankID = \common\models\BankLog::findOne(['orderID' => $invoiceid]);
            {
                $bank = new \common\models\BankLog();
                $bank->id = $bankID['id'];
                $bank->isNewRecord = false;
                $bank->auth = $digitalreceipt;
                $bank->response = $cardnumber;
                $bank->SystemTraceNo = $tracenumber;
                $bank->RetrivalRefNo = $rrn;
                $bank->date = time();
                $bank->response = $payload;

                $bank->update(false, ['SystemTraceNo', 'RetrivalRefNo', 'auth', 'date', 'response', 'amount']);

                $transID = \common\models\Transaction::findOne(['id' => $invoiceid]);
                {
                    $terminal = '61001187';
                    $params = 'digitalreceipt=' . $digitalreceipt . '&Tid=' . $terminal;
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



                        $model = new \common\models\Transaction();
                        $model->id = $invoiceid;
                        $model->isNewRecord = false;
                        $model->status = 1;
                        $model->sourceID = $bank->id;
                        $model->sourceTypeID = 7;
                        $model->bankLogID = $bank->id;
                        $model->deleted = 0;


                        $model->cck = Yii::$app->Security->generate($transID['userID'], $amount, $invoiceid);
                        $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);




                        $mobile = \common\models\MobilePhone::getMobile($transID['userID']);



                        \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');

                        return $this->redirect(['index']);
                    }
                    else
                    {


                        \Yii::$app->getSession()->setFlash('faild', $result['Message']);

                        return $this->redirect(['index']);
                    }
                }
            }
        }
        else
        {

            \Yii::$app->getSession()->setFlash('faild', $post['respmsg']);

            return $this->redirect(['index']);
        }
    }

    public function actionResponseto()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        $this->enableCsrfValidation = false;
        $meli = new \common\models\Meli();


        if (!isset($_POST['OrderId']))
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['to']);
        }
        if ($_POST['ResCode'] == -1)
        {
            \Yii::$app->getSession()->setFlash('faildTrancaction', 'مشکلی در پرداخت شما وجود داشت لطفا دوباره امتحان  کنید   ');
            return $this->redirect(['index']);
        }
        $OrderId = $_POST["OrderId"];
        $Token = $_POST["token"];
        $ResCode = $_POST["ResCode"];
        $return = $meli->verify($OrderId, $Token, $ResCode);
        if (isset($return->ResCode))
        {



            $res = $return->ResCode;
            if ($res == 0)
            {

            }
            $money = $return->Amount;
            $retNo = $return->RetrivalRefNo;
            $order = $return->OrderId;
            $trace = $return->SystemTraceNo;
            $res = $return->ResCode;


            $bankID = \common\models\BankLog::findOne(['auth' => $Token, 'orderID' => $OrderId]);


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
                    $model->sourceTypeID = 7;
                    $model->bankLogID = $bank->id;
                    $model->deleted = 0;


                    $model->cck = Yii::$app->Security->generate($transID['userID'], $money, $OrderId);

                    $model->update(false, ['status', 'sourceTypeID', 'bankLogID', 'cck', 'deleted']);


                    $master = $transID->attributes;
                    $sourceID = $master['sourceID'];
                    $amount = $master['amount'];

                    $mobile = \common\models\MobilePhone::getMobile($transID['userID']);

//                    $text = "درخواست وجه شما از $sourceID  به مبلغ $amount پرداخت شد .";
//
//                    $send = Yii::$app->ReadHttpHeader->sendSMS($mobile, "$text");

                    \Yii::$app->getSession()->setFlash('success', 'پرداخت شما با موفقیت انجام شد  ');
                    return $this->redirect(['index']);
                }
            }
        }
    }

    public function actionTransfer()
    {

        $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);


        $model = new Transaction;
        $model->load(\Yii::$app->request->post());
        $errors = '';
        if ($model->load(\Yii::$app->request->post()))
        {
            if ($model->validate())
            {

                $check = Transaction::checkResult(\Yii::$app->user->id, $model->amount);


                if ($check == false)
                {
                    \Yii::$app->getSession()->setFlash('faildTrancaction', 'موجودی برای این عملیات کافی نیست . لطفا موجودی خود را افزایش دهید یا مبلغ انتقالی را کاهش دهید  ');
                    return $this->render('transfer', [
                                'model' => $model,
                                'errors' => $errors
                    ]);
                    exit;
                }
                else
                {

                    $to = Yii::$app->ReadHttpHeader->getIDwithEmail($model->goal);

                    if ($to == false)
                    {
                        \Yii::$app->getSession()->setFlash('faildTrancaction', 'ایمیل یا موبایل یا نام کاربری  وارد شده در سیستم ما موجود نیست');
                        return $this->render('transfer', [
                                    'model' => $model,
                                    'errors' => $errors
                        ]);
                        exit;
                    }
                    else
                    {
                        $arr = array();
                        $userID = \Yii::$app->user->id;

                        $data = Yii::$app->Data->account($userID, 1);
                        if ($data == false)
                        {
                            \Yii::$app->getSession()->setFlash('faild', ' لطفا مدارک خود را ارسال کنید یا منتظر تایید مدیر سیستم ما باشید. ' . ' ممکن است کد ملی شما تایید نشده باشد  ');
                            return $this->redirect(['document/file']);
                            exit;
                        }

                        $data = Yii::$app->Data->account($to, 1);
                        if ($data == false)
                        {
                            $mobileTo = \common\models\MobilePhone::getMobile($userID);
                            if ($mobileTo != false)
                            {
                                $send = Yii::$app->ReadHttpHeader->sendSMS($model->goal, "لطفا مشخصات خود را سایت صباپال کامل کنید. فردی قصد انتقال وجه برای شما را داشت اما موفق نشد.");
                            }


                            \Yii::$app->getSession()->setFlash('faild', 'کد ملی یاشماره حساب مقصد تایید نشده است . بعد از تایید حساب مقصد لطفا مجددا امتحان فرمایید');
                            return $this->redirect(['document/file']);
                            exit;
                        }
                        if (\Yii::$app->user->id == $to)
                        {
                            \Yii::$app->getSession()->setFlash('faild', 'شما نمی توانید برای خودتان وجهی را انتقال دهید ');
                            return $this->redirect(['index']);
                            exit;
                        }

                        $arrF = Yii::$app->Data->account(Yii::$app->user->id, 1);
                        $arrT = Yii::$app->Data->account($to, 1);

                        $json = Yii::$app->Data->jsonTransfer($arrF, $arrT);



                        $to = $trans = Transaction::transfering(\Yii::$app->user->id, $to, $model->amount);
                        \Yii::$app->getSession()->setFlash('success', 'انتقال وجه با موفقیت انجام شد');
                        return $this->redirect(['index']);
                    }
                }
            }
// all inputs are valid
        }
        else
        {
// validation failed: $errors is an array containing error messages
            $errors = $model->errors;
        }
        return $this->render('transfer', [
                    'money' => $money,
                    'model' => $model,
                    'errors' => $errors
        ]);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save())
//            {
//            return $this->redirect(['view', 'id' => $model->id]);
//            } else
//            {
//            return $this->render('update', [
//                        'model' => $model,
//            ]);
//            }
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();
//        Yii::$app->ReadHttpHeader->deleting($id, 'transaction');

        return $this->redirect(['index']);
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

}
