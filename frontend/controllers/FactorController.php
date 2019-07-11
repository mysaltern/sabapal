<?php

namespace frontend\controllers;

use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use common\models\Factor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class FactorController extends \yii\web\Controller
{

    public function actionIndex($URL)
    {

        $model = new Transaction();
        $meli = new \common\models\Meli();

        if ($model->load(Yii::$app->request->post()))
        {

            $model->userID = Yii::$app->user->id;
            $model->date = time();
            $model->status = -1;
            $model->save(false);


            $meli->request($model->amount, "http://sabapal.ir/frontend/web/transaction/response", $model->id);
//            var_dump($a);
            die;
//            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            $factor = Factor::find()->where(['url' => $URL])->asArray()->one();
            $model = new Transaction();
            $meli = new \common\models\Meli();


            return $this->render('index', [
                        'model' => $model,
                        'factor' => $factor,
            ]);
        }
    }

}
