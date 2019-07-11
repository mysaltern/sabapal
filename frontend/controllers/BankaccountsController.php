<?php

namespace frontend\controllers;

use Yii;
use common\models\BankAccounts;
use common\models\BankAccountsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * BankaccountsController implements the CRUD actions for BankAccounts model.
 */
class BankaccountsController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'delete', 'update'],
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
                },
            ],
        ];
    }

    /**
     * Lists all BankAccounts models.
     * @return mixed
     */
    public function actionIndex()
    {



        $searchModel = new BankAccountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BankAccounts model.
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
     * Creates a new BankAccounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BankAccounts();

        if ($model->load(Yii::$app->request->post()))
        {

            $model->deleted = 0;
            $model->time = time();
            $model->userID = \Yii::$app->user->id;

            $model->save();


            $auth = \Yii::$app->authManager;
            if (!\Yii::$app->user->can('bankAccount'))
            {
                $admin = $auth->getPermission('bankAccount');

                if (isset($admin->name))
                {
                    $auth->assign($admin, \Yii::$app->user->id);
                }
                else
                {

                    // add "updatePost" permission
                    $admin = $auth->createPermission('bankAccount');
                    $admin->description = 'bankAccount';
                    $auth->add($admin);

                    $auth->assign($admin, \Yii::$app->user->id);
                }
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BankAccounts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $userID = Yii::$app->user->id;
            $table = 'bank_accounts';

            $sourceID = $model->id;
            $type = 4;

            \common\models\Log::create($userID, $table, $sourceID, $type, true);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BankAccounts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {




        $to = Yii::$app->ReadHttpHeader->checkAccess(\Yii::$app->user->id, 'bank_accounts', $id);
        if ($to == true)
        {


            $to = Yii::$app->ReadHttpHeader->deleting($id, 'bank_accounts');
            $access = Yii::$app->ReadHttpHeader->lastAccess(\Yii::$app->user->id, 'bank_accounts');
            if ($access == false)
            {
                $auth = \Yii::$app->authManager;

                $admin = $auth->getPermission('bankAccount');
//                $auth->remove($admin);
                $auth->revoke($admin, \Yii::$app->user->id);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the BankAccounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankAccounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BankAccounts::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
