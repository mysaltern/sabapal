<?php

namespace frontend\controllers;

use Yii;
use common\models\UserConfirmatory;
use common\models\UserConfirmatorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * DocumentController implements the CRUD actions for UserConfirmatory model.
 */
class DocumentController extends Controller
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
                        'actions' => ['file'],
                        'allow' => true,
                        'roles' => ['@', 'user2'],
                    ],
                ],
                'denyCallback' => function ($rule, $action)
                {


                    if (\Yii::$app->user->can('document'))
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
     * Lists all UserConfirmatory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserConfirmatorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFile()
    {

        if (\Yii::$app->user->can('document'))
        {
            return $this->redirect(Url::to(['site/index']));
        }


        $model = new UserConfirmatory();


        if ($model->load(Yii::$app->request->post()))
        {

            $model->userID = \Yii::$app->user->id;
            $model->active = NULL;
            $model->save();

            $image = UploadedFile::getInstance($model, 'nationalCard_url');
            $image2 = UploadedFile::getInstance($model, 'birthCertificate_url');



            if (!is_null($image))
            {
                $path = Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/documents";
                //here you create the folder
                if (\yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true))
                {
                    $urlTest = Yii::$app->security->generateRandomString() . $image;
                    $image->saveAs(Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/documents/" . $urlTest);

                    $model->nationalCard_url = "uploads/users/$model->userID/documents/$urlTest";
                    $model->save(false);
                }
            }
	
	
            if (!is_null($image2))
            {
                $path = Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/documents";
                //here you create the folder
                if (\yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true))
                {
                    $urlTest = Yii::$app->security->generateRandomString() . $image2;
                    $image2->saveAs(Yii::getAlias('@frontend') . "/web/uploads/users/$model->userID/documents/" . $urlTest);

                    $model->nationalCard_url = "uploads/$model->userID/documents/$urlTest";
                    $model->save(false);
                    \Yii::$app->getSession()->setFlash('success', 'آپلود مدارک شما با موفقیت انجام شد.بعد از تایید مدارک به شما اطلاع داده میشود ');
                }
            }
            else
            {
                \Yii::$app->getSession()->setFlash('faild', 'آپلود مدارک شما   انجام نشد ');
            }




            return $this->redirect(['transaction/index']);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single UserConfirmatory model.
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
     * Creates a new UserConfirmatory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserConfirmatory();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
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
     * Updates an existing UserConfirmatory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
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
     * Deletes an existing UserConfirmatory model.
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
     * Finds the UserConfirmatory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserConfirmatory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserConfirmatory::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
