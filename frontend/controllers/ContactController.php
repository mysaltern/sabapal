<?php

namespace frontend\controllers;

use Yii;
use common\models\Contact;
use common\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
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
                        'actions' => ['create', 'mobile', 'verify', 'resend', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action)
                {
                    if (\Yii::$app->user->can('@'))
                    {

                    }
                    else
                    {
                        return $action->controller->redirect(Url::to(['user/login']));
                    }
                    if (\Yii::$app->user->can('user3'))
                    {

                    }
                    else
                    {
                        return $action->controller->redirect(Url::to(['file/document']));
                    }
                },
            ],
        ];
    }

    /**
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new Contact();
        $searchModel2 = new ContactSearch();
        $dataProvider = $searchModel2->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResend()
    {
        $userID = Yii::$app->user->id;
        $mobile = \common\models\MobilePhone::find()->where(['user_id' => $userID, 'active' => 0])->asArray()->all();

        foreach ($mobile as $m)
        {
			
			 
            if (isset($m['id']))
            {
                $id = $m['id'];


                $connection = Yii::$app->db;

                $connection->createCommand()
                        ->update('mobile_phone', ['active' => -1], "id = $id")
                        ->execute();
            }
        }



        return $this->redirect(['contact/mobile']);
    }

    public function actionMobile()
    {
	
        $model = new \common\models\MobilePhone();
        $userID = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()))
        {

        $mobile = \common\models\MobilePhone::find()->where(['mobile' =>$model->mobile, 'active' => 1])->asArray()->one();
			if(isset($mobile['id']))

			{
					 \Yii::$app->getSession()->setFlash('close', 'این شماره موبایل در سیستم ما قبلا ثبت شده است');
					  return $this->redirect(['contact/mobile']);
			}
            $model->active = 0;
            $model->count = 0;
            $model->status = 1;
            $model->user_id = $userID;
            $model->token = rand(10000, 99999);
            $model->time = time();





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
            $parameters['to'] = $model->mobile;
            $parameters['text'] = $model->token;
            $parameters['isflash'] = false;
            $parameters['scheduleDateTime'] = "$y-$khareji[1]-$khareji[2]T$saat:59";
            $timeFull = "$y-$khareji[1]-$khareji[2]T$saat:59";
            $parameters['period'] = "Once";

            $scheduleId = $sms_client->AddSchedule($parameters)->AddScheduleResult;



            $model->save(false);









            return $this->redirect(['verify']);
        }

        $mobile = \common\models\MobilePhone::find()->where(['user_id' => $userID, 'active' => 0])->asArray()->one();

        if ($mobile == null)
        {

            return $this->render('mobile', [
                        'model' => $model,
            ]);
        }
        else
        {
            return $this->redirect(['verify']);
        }
    }

    public function actionVerify()
    {
        $model = new \common\models\MobilePhone();
        $userID = Yii::$app->user->id;
        $mobile = \common\models\MobilePhone::find()->where(['user_id' => $userID, 'active' => 1])->asArray()->one();

        if (isset($mobile['id']))
        {
            \Yii::$app->getSession()->setFlash('success', 'موبایل شما با موفقیت فعال شده است');
            return $this->redirect(['internalpay/index']);
            exit();
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $userID = Yii::$app->user->id;
            $mobile = \common\models\MobilePhone::find()->where(['user_id' => $userID, 'active' => 0])->asArray()->one();

            if (isset($mobile['token']))
            {



                $token = $mobile['token'];


                if ($mobile['count'] > 5)
                {

                    $connection = \Yii::$app->db;
                    $connection->createCommand()
                            ->update('mobile_phone', ['status' => -1, 'active' => -1], "user_id = $userID")
                            ->execute();
                    \Yii::$app->getSession()->setFlash('close', 'رمز یک بار مصرف  باطل شد. لطفا دوباره تلفن همراه خود را وارد کنید.');
                    return $this->redirect(['mobile']);
                }
                if ($model->token == $token)
                {

                    $connection = \Yii::$app->db;
                    $connection->createCommand()
                            ->update('mobile_phone', ['active' => 1], "user_id = $userID")
                            ->execute();

                    $auth = \Yii::$app->authManager;
                    if (!\Yii::$app->user->can('mobile'))
                    {
                        $admin = $auth->getPermission('mobile');

                        if (isset($admin->name))
                        {
                            $auth->assign($admin, \Yii::$app->user->id);
                        }
                        else
                        {

                            // add "updatePost" permission
                            $admin = $auth->createPermission('mobile');
                            $admin->description = 'mobile';
                            $auth->add($admin);

                            $auth->assign($admin, \Yii::$app->user->id);
                        }
                    }
                    \Yii::$app->getSession()->setFlash('success', 'موبایل شما با موفقیت فعال شد');
                    return $this->redirect(['internalpay/index']);
                }
                else
                {

                    $count = $mobile['count'] + 1;
                    $connection = \Yii::$app->db;
                    $connection->createCommand()
                            ->update('mobile_phone', ['count' => $count], "user_id = $userID")
                            ->execute();
                    \Yii::$app->getSession()->setFlash('close', 'رمز یک بار مصرف اشتباه بود');
                }
            }
        }
        return $this->render('verify', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();

        if ($model->load(Yii::$app->request->post()))
        {
            if (\Yii::$app->user->can('user2'))
            {
                return $this->redirect(['contact/update']);
                exit;
            }
            $model->userID = \Yii::$app->user->id;

            $model->save();

            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('user2');
            $auth->assign($authorRole, \Yii::$app->user->id);








            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            if (!\Yii::$app->user->can('mobile'))
            {
                return $this->redirect(['contact/mobile']);
            }
            if (\Yii::$app->user->can('user3'))
            {
                return $this->redirect(['site/index']);
            }
            if (\Yii::$app->user->can('user2'))
            {
                return $this->redirect(['contact/update']);
            }
            else
            {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {

        $user_id = \Yii::$app->user->id;
        if (isset(Contact::findOne(['userID' => $user_id])->id))
        {

            $id = Contact::findOne(['userID' => $user_id])->id;
        }
        else
        {

            return $this->redirect(['contact/create']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {

            return $this->redirect(['document/file']);
        }
        else
        {

            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
