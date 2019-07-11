<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\helpers\Url;

/**
 * Site controller
 */
class PageController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {


        $this->layout = 'smallMain';

        return $this->render('index', [
//                    'model' => $model,
        ]);
    }

    public function actionTerms()
    {

        $this->layout = 'smallMain';

        return $this->render('terms', [
//                    'model' => $model,
        ]);
    }

    public function actionTariffs()
    {

        $this->layout = 'smallMain';

        return $this->render('tariffs', [
//                    'model' => $model,
        ]);
    }

}
