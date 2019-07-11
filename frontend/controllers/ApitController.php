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
class ApitController extends Controller
{

//    public $enableCsrfValidation = false;

    public function actions()
    {

//        ini_set("soap.wsdl_cache_enabled", "0");
        return [
            'hello' => 'mongosoft\soapserver\Action',
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
    public function getHello()
    {
        //set up some dummy values to be rendered
        $xmlValues = ['test1' => 'value1', 'test2' => 'value2'];

        //set content type xml in response
//        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xmlValues;
        //set the view and render it partial to skip the layout to be rendered as well
//        return $this->renderPartial('xmlview', [
//                    'xmlValues' => $xmlValues,
//        ]);
    }

//    public function PaymentRequest($MerchantID, $Amount, $Description, $Email, $Mobile, $CallbackURL)
//    {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        echo 1;
//        $string = <<<XML
//<a>
// <b>
//  <c>text</c>
//  <c>stuff</c>
// </b>
// <d>
//  <c>code</c>
// </d>
//</a>
//XML;
//
//        $xml = new \SimpleXMLElement($string);
//
//        return $xml->asXML();
//        exit;
//        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
////        Yii::$app->response->headers->add('Content-Type', 'text/xml');
//
//        return $xmlValues = ['status' => '100'];
//        die;
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        Yii::$app->response->headers->add('Content-Type', 'text/xml');
//
//        $price = $MerchantID['Amount'];
//
//        $Merchant = $MerchantID['MerchantID'];
//        $CallbackURL = $MerchantID['CallbackURL'];
//
//
//
//
//        $clientT = new Client(['baseUrl' => "http://sabapal.ir/sabapal/frontend/web/api/virtual"]);
//
//        $loginResponse = $clientT->post('', [
//                    'amount' => "$price",
//                    'private' => "$Merchant",
//                    'CallbackURL' => "$CallbackURL",
//                ])->send();
//
//        $loginResponse = \yii\helpers\Json::decode($loginResponse->getContent());
//
//        if ($loginResponse['status'] == 0)
//        {
//            $token = $loginResponse['token'];
//
//            $client = new Client(['baseUrl' => "http://sabapal.ir/sabapal/frontend/web/api/accept"]);
//
//            $loginResponse = $client->post('', [
//                        'token' => "$token",
//                    ])->send();
//
//            if ($loginResponse->content == true)
//            {
//
//
//                $xmlValues = ['status' => '100', 'auth' => "$token"];
//                return $this->renderPartial('xml', [
//                            'xmlValues' => $xmlValues,
//                ]);
//            }
//        }
//
//        return $this->renderPartial('xml', [
//                    'xmlValues' => $xmlValues,
//        ]);
//    }
}
