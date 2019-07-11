<?php

namespace frontend\controllers;

use Yii;
use common\models\Ticket;
use common\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * @inheritdoc
     */

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
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {




        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $txtOrder = Yii::$app->ReadHttpHeader->txtOrder($model->order);
        $txtStatus = Yii::$app->ReadHttpHeader->txtStatus($model->status);


        $otherModel = Ticket::find()->where(['parent' => $model->id])->asArray()->all();




        return $this->render('view', [
                    'model' => $model,
                    'txtOrder' => $txtOrder,
                    'txtStatus' => $txtStatus,
                    'otherModel' => $otherModel,
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticket();

        if ($model->load(Yii::$app->request->post()))
        {






            $model->userID = Yii::$app->user->id;



            $image = UploadedFile::getInstance($model, 'file');





            if (!empty($image))
            {
                $path = Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/ticket";
                //here you create the folder
                if (\yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true))
                {
                    $urlTest = Yii::$app->security->generateRandomString() . $image;
                    $image->saveAs(Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/ticket/" . $urlTest);

                    $model->file = "uploads/users/$model->userID/ticket/$urlTest";
                    $model->save(false);
                }
            }
            $model->status = 2;
            $model->type = 1;
            $model->deleted = 0;
            $model->parent = 0;
            $model->date = time();

            $model->save(false);


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
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);



        if ($model->load(Yii::$app->request->post()))
        {


            if ($model->status == 4)
            {
                \Yii::$app->getSession()->setFlash('close', 'بعد از پاسخ به تیکت شما توانایی تغییر آن رو ندارید ');
                return $this->render('update', [
                            'model' => $model,
                ]);
                die;
            }


            $image = UploadedFile::getInstance($model, 'file');





            if (!empty($image))
            {
                $path = Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/ticket";
                //here you create the folder
                if (\yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true))
                {
                    $urlTest = Yii::$app->security->generateRandomString() . $image;
                    $image->saveAs(Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/ticket/" . $urlTest);

                    $model->file = "uploads/users/$model->userID/ticket/$urlTest";
                    $model->save(false);
                }
            }

            $model->save();

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
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();
        Yii::$app->ReadHttpHeader->deleting($id, 'ticket');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id, 'parent' => 0, 'userID' => Yii::$app->user->id, 'deleted' => 0])) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
