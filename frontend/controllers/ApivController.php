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
use mongosoft\soapserver;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class ApivController extends Controller
{

    public $enableCsrfValidation = false;

    public function actions()
    {

        ini_set("soap.wsdl_cache_enabled", "0");
        return [
            'PaymentVerification' => 'mongosoft\soapserver\Action',
        ];
    }

    /**
     * @param string $name
     * @return string
     * @soap
     */
//    public function getHello()
//    {
//        return 'Hello ';
//    }


    public function PaymentVerification($MerchantID, $Authority, $Amount)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');


        $price = $MerchantID['Amount'];

        $Merchant = $MerchantID['MerchantID'];



        $token = $MerchantID['Authority'];

        $client = new Client(['baseUrl' => "https://sabapal.ir/sabapal/frontend/web/api/accept"]);


        $loginResponse = $client->post('', [
                    'token' => "$token",
                ])->send();

        if ($loginResponse->content == 'true')
        {

            $RefID = $token;
            $xmlValues = ['RefID' => "$RefID", 'Status' => "100"];
            return $this->renderPartial('xml2', [
                        'xmlValues' => $xmlValues,
            ]);
            exit;
        }
        else
        {
            $xmlValues = ['RefID' => "", 'Status' => '0'];
            return $this->renderPartial('xml2', [
                        'xmlValues' => $xmlValues,
            ]);
            exit;
        }
    }

}
